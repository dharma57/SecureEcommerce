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
  $error = "";
require 'mysqli_connect.php';

  if($_SERVER['REQUEST_METHOD']=='POST')
  {
      //validate the incoming data
      $errors=array();
      // check for the printname
      if(!empty($_POST['print_name']))
      {
          $pn=trim($_POST['print_name']);
      }
      else
      {
          $errors[]="please enter the prints name";
      }
      // chec for an image
      if(is_uploaded_file($_FILES['image']['tmp_name']))
     {
          // create a temporary file name
        $temp='./uploads/'.md5($_FILES['image']['name']);
        
        // move the file over
        
        if(move_uploaded_file($_FILES['image']['tmp_name'], $temp))
        {
            echo '<p style="font-weight:bold;color:green">File has been uploaded</p>';
            // set the $i var name to the images name
            $i=$_FILES['image']['name'];
        }
        else
        {
            $errors[]="The file could not be moved";
            $temp=$_FILES['image']['tmp_name'];
        }
      }
       else
       {
           $errors[]='no file was uploaded';
           $temp=NULL;
       }
       // check for a size (not required)
       $s=(!empty($_POST['size']))?trim($_POST['size']):NULL;
       
       // check for price
       if(is_numeric($_POST['price']) && ($_POST['price']>0))
       {
           $p=(float)$_POST['price'];
       }
       else
       {
           $errors[]='please enter the prints price!';
       }
   // check for description or not
       $d=(!empty($_POST['description']))?trim($_POST['description']):NULL;
        // validate the artist
   if(isset($_POST['artist']) && filter_var($_POST['artist'],FILTER_VALIDATE_INT,array('min_range'=>1)))
       {
           $a=$_POST['artist'];
       }
      else
      {
          $errors[]='plese select the print\s artist!';
      }
      if(isset($_POST['qty']) && filter_var($_POST['qty'],FILTER_VALIDATE_INT,array('min_range'=>1)))
       {
           $qty=$_POST['qty'];
       }
      else
      {
          $errors[]='plese select the print\s artist!';
      }
      
        if(empty($errors)){
            // every thing is ok.
            // to prevent the xss attack
            $a = htmlspecialchars($a);
            $pn = htmlspecialchars($pn);
            $p = htmlspecialchars($p);
            $s = htmlspecialchars($s);
            $d = htmlspecialchars($d);
            $qty = htmlspecialchars($qty);
            $i = htmlspecialchars($i);
            $q='Insert into prints(artist_id,print_name,price,size,description,quantity,image_name)
                 values(?,?,?,?,?,?,?)';
            $stmt=  mysqli_prepare($dbc, $q);
            mysqli_stmt_bind_param($stmt, 'isdssis',$a,$pn,$p,$s,$d,$qty,$i);
            mysqli_stmt_execute($stmt) or die(mysqli_errno($dbc));
            if(mysqli_stmt_affected_rows($stmt)==1)
            {
                echo '<p style="font-weight:bold;color:green"> The print has been added.</p>';
                // Rename the image
                $id=  mysqli_stmt_insert_id($stmt);
                rename($temp,"./uploads/$id");
                //clear $_POST
                $_POST=array();
            }
            else
            {
                echo '<p Style="font-weight:bold;color:c00">your submission
                    cannot be processed due to system error.</p>';
                
            }
            mysqli_stmt_close($stmt);
        }
        // delete upload files if still exists
        if(isset($temp) && file_exists($temp) && is_file($temp))
        {
            unlink($temp);
        }
  }
  //check for any errors and print them
  
  if(!empty($errors) && is_array($errors))
  {
       echo '<h1>Error!</h1>
       <p style="font-weight:bold;color:#c00">The following error occured:
       <br>';
       foreach($errors as $msg)
       {
         echo "-$msg<br/>\n";
       }
      echo 'please reselect the print image and try again </p>';
    }
 //  Displaying the form  
?>
        
        <div align="center">
    <h2><?php echo $error; ?></h2>
   <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title">Add A Print</h1>
            <div class="account-wall">
                
                <form class="form-signin" enctype="multipart/form-data" action="prints.php"  method="post">
                <label for="">Print Name</label>
                <input type="text" name="print_name" class="form-control" value="<?php if(isset($_POST['print_name'])) 
                         echo htmlspecialchars($_POST['print_name']);?>"  placeholder="Print Name" required autofocus>
                 <br>
                 <label for="">Image</label>
                 <input type="file" name="image" class="form-control"  required autofocus>
                  <br>

                  <label for="">Artist</label>
                  <select class="form-control" name="artist" required>
                  <option>Select One</option>
                <?php
                // Retrive all artist and add to pull down menu.
                $q="select artist_id,concat_ws('',first_name,middle_name
                    ,last_name)from artists order by last_name,first_name asc";
                $r=  mysqli_query($dbc, $q) or die(mysql_error());
                if(mysqli_num_rows($r)>0)
                {
                    while ($row=  mysqli_fetch_array($r, MYSQLI_NUM))
                            
                    {
                        echo "<option value=\"$row[0]\"";
                        // check for stickyness
                        if(isset($_POST['existing']) &&($_POST['existing']==$row[0]))
                        
                        echo 'selected="selected"';
                        echo ">$row[1]</option>\n";
                        
                    }
                }
                        else
                        {
                            echo '<option> please add a new artist first</option';
                        }
                        
                        mysqli_close($dbc);
                    
                     
                    
                   
                ?>
              </select>
                  <br>

                  <label for="">Price</label>
                <input  class="form-control" type="text" name="price" 
                     value="<?php if(isset($_POST['price'])) 
                         echo ($_POST['price']);?>" required autofocus>
                 <br>


                <label for="">Size</label>
                <input  class="form-control" type="text" name="size"
                     value="<?php if(isset($_POST['size'])) 
                         echo htmlspecialchars($_POST['size']);?>" required autofocus>
                 <br>

                 <label for="">Description</label>
                 <textarea name="description" class="form-control" cols="40" rows="5" required><?php if(isset($_POST['Description'])){ echo htmlspecialchars($_POST['Description']); }?></textarea>
                 <br>
                 <label for="">Quantity</label>
                 <input type="text" name="qty" class="form-control"
                     value="<?php if(isset($_POST['qty'])) echo htmlspecialchars($_POST['qty']);?>" />
                <br>
                 
                <button class="btn btn-lg btn-primary btn-block" name="submit" type="submit">
                    Add Prints</button>
               
                </form>
            </div>
        </div>
    </div>
    <br>
        
    
</div>

</div>

       
</div>
    <?php
include 'footer.php';
?>
