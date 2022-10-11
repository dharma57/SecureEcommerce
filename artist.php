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
include 'Header1.php';
?>
<div style="text-align:center">
   
     <?php
        // put your code here
        $error="";
         if($_SERVER['REQUEST_METHOD']=='POST')
         {
             // validate the first and middle names(neither required)
             $fn=(!empty($_POST['first_name']))
             ? trim($_POST['first_name']):NULL;
             $mn=(!empty($_POST['middle_name']))
             ? trim($_POST['middle_name']):NULL;
             // check for the last name
             if(!empty($_POST['last_name']))
             {
                 $ln=trim($_POST['last_name']); 

                 $fn = htmlspecialchars($fn);
                 $ln = htmlspecialchars($ln);
                 $mn = htmlspecialchars($mn);
             
             // add an artist to the database
             require ('mysqli_connect.php');
             $q='insert into artists(first_name,middle_name,last_name)
                 values(?,?,?)';
             $stmt=  mysqli_prepare($dbc, $q);
             mysqli_stmt_bind_param($stmt, 'sss',$fn,$mn,$ln);
             mysqli_stmt_execute($stmt);
             //check the result
             if(mysqli_stmt_affected_rows($stmt)==1)
             {
                 echo "<p style='color:green'> The Artist has been added successfully added";
                 $post=array(); 
                 
             }
             else
                 $error='The new Artist could not be added to the database';
             
             mysqli_stmt_close($stmt);
             mysqli_close($dbc);
             
             
         
         }
         else
         {
             $error="please enter the artist name";
         }
         
     }
     // check for an error and print it
      if(isset($error))
      {
          echo "<p style='font-weight:bold;color:#C00'>".$error.'.</p>';
      }
        ?>
        
        <div align="center">
    <h2><?php echo $error; ?></h2>
   <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title">Fill out the Form to add an artist</h1>
            <div class="account-wall">
                
                <form class="form-signin" action="" method="post">
                <input type="text" name="first_name" maxlength="40" class="form-control" value="<?php if(isset($_POST['first_name'])) echo $_POST['first_name'] ?>" placeholder="First Name" required autofocus>
                 <br>
                 <input type="text" name="middle_name" maxlength="40" class="form-control" value="<?php if(isset($_POST['middle_name'])) echo $_POST['middle_name'] ?>" placeholder="Middle Name" required autofocus>
                  <br>

                  <input type="text" name="last_name" maxlength="40" class="form-control" value="<?php if(isset($_POST['middle_name'])) echo $_POST['middle_name'] ?>" placeholder="Middle Name" required autofocus>
                  <br>
                 
                <button class="btn btn-lg btn-primary btn-block" name="submit" type="submit">
                    Add Artist</button>
               
                </form>
            </div>
        </div>
    </div>
    <br>
        
    
</div>

</div>
    <?php
include 'footer.php';
?>
