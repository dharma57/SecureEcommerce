<?php
include 'Header2.php';

if(!isset($_SESSION['user']))
{
    header('Location:login.php');
}
$email=$_SESSION['user'];
?>
<div style="text-align:center">
    
    <h2 style="text-align: center">Welcome To <?php echo htmlspecialchars(substr($email, 0, strpos($email, '@'))); ?> </h2>
   <center> <p align="center" style="text-align:center;line-height:20px;padding:10px"> 
   
   <image src="images/Colorful-and-Surreal-10.jpg"  align="center" style="float:middle;padding: 20px"/> </p>
<font size="4"> Our mission is simple, to offer professional quality hand made prints of famous paintings.Our Online gallery features master pieces done by great painters from all corners of the World.
</font>
  <p></center><br>
   
</div>
    <?php
include 'footer.php';
?>
