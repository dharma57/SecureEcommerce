<?php
include 'Header2.php';
if(!isset($_SESSION['user']))
{
    header('Location:Welcome_user.php');
}
$email=$_SESSION['user'];
?>
<div style="text-align:center">
   <br>
   <br>
<?php

$page_title='view your shopping cart';

// check if the form has been submitted
if($_SERVER['REQUEST_METHOD']=='POST')
{
    // change any qunatity
    foreach ($_POST['qty'] as $k=>$v)
    {
        // Must be integers
        $pid=(int)$k;
        $qty=(int)$v;
        if($qty==0)
        {
            //delete
            unset($_SESSION['cart'][$pid]);
            
        }
        else if ($qty>0)
        {
            $_SESSION['cart'][$pid]['quantity']=$qty;
        }
        
    }
}
// Display the cart if it is not empty
if(!(empty($_SESSION['cart'])))
{
    // Retrieve all of the information  for the prints  in the cart
    require 'mysqli_connect.php';
    $q="select print_id,CONCAT_WS(' ',first_name,middle_name,last_name) as artist,
        print_name,quantity from artists,prints where artists.artist_id=prints.artist_id and
        prints.print_id in(";
         foreach($_SESSION['cart'] as $pid => $value)
         {
             $q.=$pid.',';
            // echo $q;
         }
         $q=  substr($q,0,-1) . ')order by artists.last_name asc';
         $r=  mysqli_query($dbc, $q)or die(mysqli_error($dbc));
         
         //Create a form and a table
        echo '<div class="container"><form action="view_cart.php" method="post">
        <table border="0" width="90%" class="table table-bordered">
        <tr>
        <td align="left" width="30%"><b>Artist</b></td>
        <td align="left" width="30%"><b>Print Name</b></td>
        <td align="left" width="30%"><b>Price</b></td>
        <td align="left" width="30%"><b>Qty</b></td>
        <td align="left" width="30%"><b>Total Price</b></td>
        </tr>
           ';
        //print each item
        $total=0; //total cost of the order
        while($row= mysqli_fetch_array($r, MYSQLI_ASSOC))
        {
            // calculate the total and sub total
            if($row['quantity']<$_SESSION['cart'][$row['print_id']]['quantity'])
            {
                echo "<tr><td style='color:red'>only ".$row['quantity']." are available in stock" ;
              $_SESSION['cart'][$row['print_id']]['quantity']=  $row['quantity'];
            }
            $subtotal=$_SESSION['cart'][$row['print_id']]['quantity']*
             $_SESSION['cart'][$row['print_id']]['price'];
            $total+=$subtotal;
            //print the row
            echo "\t<tr>
            <td align=\"left\">{$row['artist']}</td>
            <td align=\"left\">{$row['print_name']}</td>
            <td align=\"left\">\${$_SESSION['cart'][$row['print_id']]['price']}</td>
            <td align=\"center\"><input type=\"number\" size=\"3\" name=\"qty[{$row['print_id']}]\"
                value=\"{$_SESSION['cart'][$row['print_id']]['quantity']}\"</td>
            <td align=\"right\">$".number_format($subtotal,2)."</td>
            <tr>\n";
        }// end of while loop
        mysqli_close($dbc);// close the  connection
        // print the total , close the table  and form
        echo '<tr>
          <td colspan="4" align="right" >
          <b>Tax:</b> 
          </td>
          <td align="right">$', ($total*8)/100 .'</td>
           <tr>
          <td colspan="4" align="right" >
          <b>Total:</b> 
          </td>
          <td align="right">$',  number_format($total+($total*8)/100,2).'</td>   
          </tr></table> </div>
          <div align="center"><input type="submit" class="btn btn-primary" name="submit" value=
          "update my cart" /></div>
          </form><p align="center">Enter an quantity of 0 to remove an item
          <br><br><a href="checkout.php" style="background-color:green;color:white;padding:10px 20px">CheckOut</a></p>';
        $total=$total+($total*8)/100;
        $_SESSION['total']=$total;
}
else
{
 echo '<p>Your cart is Currently empty.</p>';    
}


?>


</div>
<?php
  include 'footer.php';
?>
</body>
</html>
    