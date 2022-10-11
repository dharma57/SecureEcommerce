<?php

// This page retrives and shows an image
// flag variables
$image=FALSE;
$name=(!empty($_GET['name']))? trim($_GET['name']):'print image';
// check for an image value in the url:
//echo $name;
if(isset($_GET['image']) && filter_var($_GET['image'],FILTER_VALIDATE_INT,array('min_range=>1')))
{
// full image path
    // $image="uploads/4.jpg";
    $image='uploads/'.$_GET['image'];
   // echo "\nThe file name is ".$image;

//check that the image exists and  is a file
 if((!file_exists($image))||(!is_file($image)))
 {
     $image=FALSE;
     //echo "\nThe file name is".$image;
 }
} // end of $_GET['image']
// if there was a problem use the default image
if(!$image)
{
    $image='images/unavailable.png';
    $name='unavailable.png';
    //echo "The file name is ".$image;
}
// Get the image information
$info=  getimagesize($image);
$fs=filesize($image);
// send the content information
header("Content-Type:{$info['mime']}\n");
header("Content-Disposition:inline;filename=\"$name\"\n");
header("Content-Length:$fs\n");
readfile($image);
?>
