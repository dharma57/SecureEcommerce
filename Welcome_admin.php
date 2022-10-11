<?php
include 'Header1.php';
if(!isset($_SESSION['admin']))
{
    header('Location:login.php');
}

?>
<div style="text-align:center">
    
    <h2 style="text-align: center">Welcome To Admin</h2>
    <p style="text-align:justify;line-height:20px;padding:10px">
	<h2 style="color:green;"> You are now logged in.</h2>
   
</div>
    <?php
include 'footer.php';
?>
