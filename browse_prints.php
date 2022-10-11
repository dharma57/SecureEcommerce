<?php
include 'Header2.php';
if(!isset($_SESSION['user']))
{
    header('Location:Welcome_user.php');
}
$email=$_SESSION['user'];
?>
<div class="container" style="text-align:center">
    <br><br>
    <form action="">
         <div class="row">
         <div class = "col-sm-2">

        </div>
           <div class = "col-sm-4">
            
         <input type="text" name="search" placeholder="Enter the Print Name to Search" class="form-control" id="">
         </div>
         <div class = "col-sm-2">
         <input type="submit" class="btn btn-lg btn-primary" name="submit" value="Search"></input> 
       </div>
         </div>
         <br>
    </form>
<?php

$page_title="Browse The Prints";
require 'mysqli_connect.php';
// default query  for this page
$q="select artists.artist_id,CONCAT_WS(' ',first_name,middle_name,last_name) as
    artist,print_name,price,description,quantity,print_id from artists,prints
    where artists.artist_id=prints.artist_id order by artists.last_name asc,
    prints.print_name asc";
  if(isset($_GET["submit"]))
  {
    $pname = htmlspecialchars($_GET['search']);
    $q="select artists.artist_id,CONCAT_WS(' ',first_name,middle_name,last_name) as
    artist,print_name,price,description,quantity,print_id from artists,prints
    where artists.artist_id=prints.artist_id and print_name like '%$pname%' order by artists.last_name asc,
    prints.print_name asc";
  }
  // Are we looking  at a particular artist?
  if(isset($_GET['aid']) && filter_var($_GET['aid'],FILTER_VALIDATE_INT,array('min_range'=>1)))
  {
         // Overwrite the query
      $q="select artists.artist_id,concat_ws(' ',first_name,middle_name,last_name)as
        artist,print_name,price,description,quantity,print_id from artists,prints where
        artists.artist_id=prints.artist_id and prints.artist_id={$_GET['aid']}
        order by prints.print_name";
  }
  // create the table head
  echo '<div class="container" align=center><table border="0" class="table table-bordered" 
       align="center">
   <tr>
   <td align="left" width="20%"><b>Artist</b></td>
   <td align="left" width="20%"><b>Print Name</b></td>
   <td align="left" width="20%"><b>Description</b></td>
   <td align="left" width="20%"><b>Price</b></td>
   <td align="left" width="20%"><b>Quantity</b></td>
';
  // display all the prints, linked to URLs
  
  $r=  mysqli_query($dbc, $q)or die(mysqli_error($dbc));
  while($row= mysqli_fetch_array($r,MYSQLI_ASSOC))
  {
      // display each record
      
      echo "\t<tr>
        <td align=\"left\"><a href=\"browse_prints.php?aid={$row['artist_id']}\"> 
            {$row['artist']}</a></td>
        <td align=\"left\"><a href=\"view_print.php?pid={$row['print_id']}\"> 
            {$row['print_name']}</a></td>
        <td align=\"left\"> 
            {$row['description']}</td>
               <td align=\"left\"> 
            {$row['price']}</td>
              <td align=\"left\"> 
            {$row['quantity']}</td>
                
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
    