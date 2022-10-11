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

// This page displays the details for a particular print
$row=FALSE; // Assume nothing

if(isset($_GET['pid'])&& filter_var($_GET['pid'],FILTER_VALIDATE_INT,array('min_range'=>1)))
{
    // make sure there's a print ID!
    $pid=$_GET['pid'];
    //GET The print info.
    require 'mysqli_connect.php';
    // connect to database
    $q="select CONCAT_WS(' ',first_name,middle_name,last_name) as artist,print_name,
        price,description,size,image_name,quantity from artists,prints where artists.artist_id=
        prints.artist_id and prints.print_id=$pid";
    $r= mysqli_query($dbc, $q)or die(mysqli_error($dbc));
    if(mysqli_num_rows($r)==1)
    {
      // Good to go
        // Fetch the information
        $row=  mysqli_fetch_array($r,MYSQLI_ASSOC);
        // start the html
        $page_title=$row['print_name'];
        
        //Display a header
        echo "<div align='center'><b>{$row['print_name']}</b> by {$row['artist']}<br/>";
        // print size or default message
        echo (is_null($row['size']))? '(No size information available':$row['size'];
        if($row['quantity']>0)
        {
        echo "<br />\${$row['price']}
        <a href=\"add_cart.php?pid=$pid\">Add to Cart </a>";
        }
        else
        {
        echo "<br />\${$row['price']}
        <a href=\"\">Items are not available </a>";
            
        }
           
        echo "</div><br>";
        // Get the image information and display the image:
        if($image=@getimagesize("uploads/$pid"))
        {
           // echo "<div align=\"center\">".$image[0].$image[1].$image[2].$image[3]."</div>";
          echo "<div align=\"center\"><img src=\"show_image.php?image=$pid&name=".urlencode($row['image_name'])."\" $image[3]
                 alt=\"{$row['print_name'] }\"/></div>\n";
          // echo "<div align=\"center\"><img src=uploads\4.jpg\ /></div>";
         }
        else
        {
            echo "<div align='center'>No image available.</div> ";
        }
        // Add the description or default message
        echo '<p align="center">'.((is_null($row['description']))? '(No description Available)' : $row['description']).'</p>';
     
        }// end of mysqli_num_row

        mysqli_close($dbc);
        
    } // End of if
    if(!$row)
    {
        // show an error message
        $page_title='Error';
        include 'Header.php';
        echo '<div align="center">This page has been accessed in error</div>';

     }
     

?>


</div>
<?php
  include 'footer.php';
?>
</body>
</html>
    