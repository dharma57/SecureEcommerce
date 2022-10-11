<?php

include 'Header1.php';
?>
<div style="text-align:center">
    <?php

$page_title="User List";
require 'mysqli_connect.php';

// default query  for this page
$q="select customer_id,email from customers order by customer_id";
  
  
  // create the table head
  echo '<div class="container" align=center><table style="margin:10px" border="0" class="table table-bordered" 
       align="center">
   <tr text-align="center">
   <td align="left" width="40%"><b>Customer ID</b></td>
   <td align="left" width="40%"><b>Email</b></td>
   ';
  // display all the prints, linked to URLs
  
  $r=  mysqli_query($dbc, $q)or die(mysqli_error($dbc));
  while($row= mysqli_fetch_array($r,MYSQLI_ASSOC))
  {
      // display each record
      
      echo "\t<tr>
        
        <td align=\"left\"> 
            {$row['customer_id']}</td>
               <td align=\"left\"> 
            {$row['email']}</td>
                
       </tr>\n ";
  } // end of while loop
  echo "</table></div>";
  mysqli_close($dbc);
  ?>

</div>
    <?php
include 'footer.php';
?>
