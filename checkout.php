<?php

// This page inserts the order information into table
// This page would come after the billing process
// This page assume that the billing process worked (money has been taken)
// set the page title and include the html header
$page_title='Order Confirmation';
include 'Header2.php';
if(!isset($_SESSION['user']))
{
    header('Location:Welcome_user.php');
}
$email=$_SESSION['user'];
?>
<div style="text-align:center">
  
 <?php
// Assume that the customer i logged in and that this page has access to cutomers id
if(isset($_POST['submit']))
{
 include 'mysqli_connect.php';
 $address=$_POST['address'];
 //echo "Address is ".$address;
$r=mysqli_query($dbc,"select customer_id from customers where email='$email'") or die(mysql_errno($dbc));
$row=mysqli_fetch_array($r,MYSQLI_NUM);
$cid=$row[0]; // Temporary
// Assume that this page receives order total
$total=$_SESSION['total'];

require 'mysqli_connect.php';

// Connect to database
//Turn autocommit off;
mysqli_autocommit($dbc,FALSE);
// Add the order to the orders table
$q="insert into orders(customer_id,total,shipping_Address) values ($cid,$total,'$address')";
$r=  mysqli_query($dbc, $q) or die(mysqli_error($dbc));
if(mysqli_affected_rows($dbc)==1)
{
    // need the order id
    $oid=  mysqli_insert_id($dbc);
    // insert the specific order conetent into the database
    // prepare the query
    $q="insert into order_contents(order_id,print_id,quantity,price)
        values(?,?,?,?)";
    $stmt=mysqli_prepare($dbc,$q);
    mysqli_stmt_bind_param($stmt, 'iiid',$oid,$pid,$qty,$price);
    // Execute each query Count the total effected
    $affected=0;
    
     $q1="update prints set quantity=quantity-? where print_id=?";
      $stmt1=  mysqli_prepare($dbc,$q1);
      mysqli_stmt_bind_param($stmt1,'ii',$qty,$pid);
    foreach ($_SESSION['cart'] as $pid=>$item)
    {
        $qty=$item['quantity'];
        $price=$item['price'];
        mysqli_stmt_execute($stmt);
        $affected+=mysqli_stmt_affected_rows($stmt);
      // mysqli_query($dbc,$q1) or die(mysql_error());
         mysqli_stmt_execute($stmt1);
        
    }
    // close the prepared statement
    mysqli_stmt_close($stmt);
    // Report on the success
    if($affected==count($_SESSION['cart']))
    {
        // Commit the transaction
        mysqli_commit($dbc);
        // clear the cart
        unset($_SESSION['cart']);
        // Message to the customer
        ?>
   <h1>Charge $55 with Stripe</h1>

<!-- display errors returned by createToken -->
<span class="payment-errors"></span>

<!-- stripe payment form -->
<form action="" method="POST" id="paymentFrm">
    <p>
        <label>Name</label>
        <input type="text" name="name" maxlength="40" required size="50" />
    </p>
    <p>
        <label>Email</label>
        <input type="text" name="email" maxlength="40" required size="50" />
    </p>
    <p>
        <label>Card Number</label>
        <input type="text" name="card_num" maxlength="40" required size="20" autocomplete="off" 
class="card-number" />
    </p>
    <p>
        <label>CVC</label>
        <input type="text" name="cvc" size="4" maxlength="40" required autocomplete="off" class="card-cvc" />
    </p>
    <p>
        <label>Expiration (MM/YYYY)</label>
        <input type="text" name="exp_month" size="2" maxlength="40" required class="card-expiry-month"/>
        <span> / </span>
        <input type="text" name="exp_year" size="4" maxlength="40" required class="card-expiry-year"/>
    </p>
    <button type="submit" name="pay" id="payBtn">Submit Payment</button>
</form>

<?php 
       
        // send email and do what ever
        
    
//echo '<br><br>Message has been sent';
        
        // end of code
    }
   
    else
    {
        // Rollback and report
        mysqli_rollback($dbc);
            echo '<p>Your order could be order due to system error</p>';
         // send the order information to administrator
   }
   
}
else
{
    // Rollback and report
        mysqli_rollback($dbc);
            echo '<p>Your order could be order due to system error</p>';
         // send the order information to administrator
}
mysqli_close($dbc);
}
else if(isset($_POST["pay"]))
{
    $username = htmlspecialchars($_SESSION['user']);
    $name = htmlspecialchars($_POST['name']);
    $email =htmlspecialchars( $_POST['email']);
    $card_num =htmlspecialchars( $_POST['card_num']);
    $card_cvc =htmlspecialchars( $_POST['cvc']);
    $card_exp_month =htmlspecialchars( $_POST['exp_month']);
    $card_exp_year = htmlspecialchars($_POST['exp_year']);


    include 'mysqli_connect.php'; 

    $q="insert into payment (username,name,email,card_num,cvc,exp_month,exp_year) values ('$username','$name','$email','$card_num','$card_cvc','$card_exp_month','$card_exp_year')";
        $r=  mysqli_query($dbc, $q) or die(mysqli_error($dbc));
        if(mysqli_affected_rows($dbc)==1)
        {
            echo '<br><br><p> Payment Received Successfully <br>Thank you for your order';
        }




}
else
{
?>

<br><br>
<form action="" method="post">
    <h3>Enter the Shipping Details</h3>
    <table align="center"><tr><td>Enter shipping Address:
    <td> <textarea name="address" rows="5" cols="20"></textarea>
        <tr><td colspan="2" align="center" required>
            <input type="submit" name="submit" class="btn btn-primary" value="order now" />    
            </td>
        </tr>
    </table>
     
    </form>
</div>
<?php
}
include 'footer.php';
?>
