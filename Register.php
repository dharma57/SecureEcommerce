<style>

.form-signin
{
    max-width: 330px;
    padding: 15px;
    margin: 0 auto;
}
.form-signin .form-signin-heading, .form-signin .checkbox
{
    margin-bottom: 10px;
}
.form-signin .checkbox
{
    font-weight: normal;
}
.form-signin .form-control
{
    position: relative;
    font-size: 16px;
    height: auto;
    padding: 10px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
.form-signin .form-control:focus
{
    z-index: 2;
}
.form-signin input[type="text"]
{
    margin-bottom: -1px;
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
}
.form-signin input[type="password"]
{
    margin-bottom: 10px;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
}
.account-wall
{
    margin-top: 20px;
    padding: 40px 0px 20px 0px;
    background-color: #f7f7f7;
    -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
}
.login-title
{
    color: #555;
    font-size: 18px;
    font-weight: 400;
    display: block;
}
.profile-img
{
    width: 96px;
    height: 96px;
    margin: 0 auto 10px;
    display: block;
    -moz-border-radius: 50%;
    -webkit-border-radius: 50%;
    border-radius: 50%;
}
.need-help
{
    margin-top: 10px;
}
.new-account
{
    display: block;
    margin-top: 10px;
}
</style>
<?php
include 'Header.php';
$error="";
 if(isset($_SESSION['csrf_token']) && isset($_POST['register']))
{
    // csrf time validatio 
    $max_time = 60 * 60 * 24;
    $token_time = $_SESSION['csrf_token_time'];

    if($_POST['csrf_token'] == $_SESSION['csrf_token'] && ($token_time+$max_time >= time()) )
    {
if(isset($_POST['register']) )
    {
       $email=$_POST['u1'];
       $password=$_POST['p1'];
       $rpassword=$_POST['p2'];


       if(strlen($email) <= 40 && strlen($password) <= 40)
       {
       if($password==$rpassword)
       {
           // Check the email is existing or not 
           include 'mysqli_connect.php';
           $q="select * from customers where email='".$email."'";
           //echo "The query is ".$q;
           $stmt= mysqli_query($dbc, $q);
           if(mysqli_affected_rows($dbc)>0)
           {
               $error="Email Id is already registered";
           }
           else
           {
             $q="insert into customers(email,pass) values('$email','$password')";
                //$stmt= mysqli_prepare($dbc,$q);
           //  mysqli_stmt_bind_param($stmt,"sss",$email,$password);
            // mysqli_stmt_execute($stmt);
            $r=  mysqli_query($dbc, $q) or die(mysqli_error($dbc));
             //check the result
            // echo mysqli_affected_rows($dbc); 
            if(mysqli_affected_rows($dbc)>0)
             {
                // echo "<p style='color:green'> The User has been added successfully ";
                $error="<p style='color:green'> The User Registration successfully ";
                 
             }
             else
                 $error='The new User could not be added to the database';
                
            
          }
            
             mysqli_close($dbc);
            // Register a user
       }
       else
       {
         $error="Passwords does not match";  
       }
    }
    else 
    {
        $error ="<span style='color:red'>Buffer Overflow</span>";
    }

    }

}
        else 
        {
            $error = "CSRF Token Expired<br>Refresh the form and submit again";
        }

}
$token =  md5(uniqid(rand(),true));
$_SESSION['csrf_token'] = $token;
$_SESSION['csrf_token_time'] = time();
?>
<div align="center">
<br>
    <br>
    <h2><?php echo $error; ?></h2>
<div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title">Register Customer for Painting Store</h1>
            <div class="account-wall">
                <img class="profile-img" src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=120"
                    alt="">
                <form class="form-signin" action="" method="post">
                <input type="hidden" name="csrf_token" value="<?php echo $token; ?>" />
               
                <input type="text" name="u1" class="form-control" placeholder="Email" maxlength = "40"  required autofocus>
                 <br>
                <input type="password"  name="p1" class="form-control" placeholder="Password" maxlength="40" required>
                  <br>
                  <input type="password"  name="p2" class="form-control" placeholder="Confirm Password" maxlength="40" required>
                <button class="btn btn-lg btn-primary btn-block" name="register" type="submit">
                    Register</button>
               
                </form>
            </div>
            <a href="login.php" class="text-center new-account">For Login Click Here</a>
        </div>
    </div>
    <br>
        
    
</div>

     
<?php
include 'footer.php';
?>
