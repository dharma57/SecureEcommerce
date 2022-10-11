<!DOCTYPE html>
<?php
session_start();
?>
<html lang="en">
<head>
  <title>Online Painting Store</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <style>
    /* Remove the navbar's default rounded borders and increase the bottom margin */ 
    .navbar {
      margin-bottom: 50px;
      border-radius: 0;
    }
    
    /* Remove the jumbotron's default bottom margin */ 
     .jumbotron {
      margin-bottom: 0;
    }
   
    /* Add a gray background color and some padding to the footer */
    footer {
	  background-color: #f2f2f2;
      padding: 25px;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#">Online Painting</a>   
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="Welcome_user.php">Home</a></li>
        <li><a href="browse_prints.php">Prints</a></li>
        <li><a href="order_list1.php">Order Items</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <!--<li><a href="login.php"><span class="glyphicon glyphicon-user"></span> Your Account</a></li>-->
      <li><a href="view_cart.php"><span class="glyphicon glyphicon-shopping-cart"></span>Cart</a></li>
        <li><a href="Logout.php"><span class="glyphicon glyphicon-log-out">Logout</span>
        </a></li>
      </ul>
    </div>
  </div>
</nav>

  
<br><br>