<?php
include 'Header2.php';
if(!isset($_SESSION['user']))
{
    header('Location:Welcome_user.php');
}
$email=$_SESSION['user'];
?>
<div style="text-align:center">
   <br><br>
<?php

$page_title="Order List";

require 'mysqli_connect.php';
$r=mysqli_query($dbc,"select customer_id from customers where email='$email'") or die(mysql_errno($dbc));
$row=mysqli_fetch_array($r,MYSQLI_NUM);
$cid=$row[0]; 
// default query  for this page
$q="select order_id,customer_id,total,order_date,shipping_Address from orders where customer_id=$cid order by order_id";
  
  
  // create the table head
  echo '<div class="container" align=center><table border="0" class="table table-bordered"
       align="center">
   <tr>
   <td align="left" width="20%"><b>Order ID</b></td>
   <td align="left" width="20%"><b>Customer ID</b></td>
   <td align="left" width="20%"><b>Total</b></td>
   <td align="left" width="20%"><b>Order Date</b></td>
   <td align="left" width="20%"><b>Shipping Address</b></td>
   ';
  // display all the prints, linked to URLs
  
  $r=  mysqli_query($dbc, $q)or die(mysqli_error($dbc));
  while($row= mysqli_fetch_array($r,MYSQLI_ASSOC))
  {
      // display each record
      
      echo "\t<tr>
        <td align=\"left\"> 
            {$row['order_id']}</td>
        <td align=\"left\"> 
            {$row['customer_id']}</td>
        <td align=\"left\"> 
            {$row['total']}</td>
         
         <td align=\"left\"> 
            {$row['order_date']}</td>
         <td align=\"left\">
           {$row['shipping_Address']}</td>
                
       </tr>\n ";
  } // end of while loop
  echo "</table></div>";
  mysqli_close($dbc);
  ?>
</div>
<?php
  include 'footer.php';
?>
</body>
</html>
    