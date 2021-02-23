<?php

session_start();

if(isset($_SESSION["user_id"]))
{
 header("location:home.php");
}
?>

<!DOCTYPE html>
<html>
 <head>
  <title>PHP Login with OTP Authentication</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="http://code.jquery.com/jquery.js"></script>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 </head>
 <body>
  <br />
  <div class="container">
   <h3 align="center">Register Success</h3>
   <br />

   <?php
   
   if(isset($_GET["register"]))
   {
    if($_GET["register"] == 'success')
    {
     echo '
     <h1 class="text-success">Email Successfully verified, Registration Process Completed...</h1>
     ';
    }
   }

   if(isset($_GET["reset_password"]))
   {
    if($_GET["reset_password"] == 'success')
    {
     echo '<h1 class="text-success">Password change Successfully, Now you can login with your new password</h1>';
    }
   }
   ?>

   <div class="row">
    <div class="col-md-3">&nbsp;</div>
    <div class="col-md-6">
     <div class="panel panel-default">
      <div class="panel-heading">
       <h3 class="panel-title">Login</h3>
      </div>
      <div class="panel-body">
       <form method="POST" action="admin_submit.php" id="login_form">
        <div class="form-group" id="email_area">
         <label>Enter Username</label>
         <input type="text" name="user_name" id="user_name" class="form-control" />

        </div>
        <div class="form-group" id="password_area" >
         <label>Enter password</label>
         <input type="password" name="user_password" id="user_password" class="form-control" />
    
        </div>
        <div class="form-group" align="right">

         <input type="submit" name="login" id="next" class="btn btn-primary" value="Login" />
        </div>
       </form>
      </div>
     </div>
     <div align="center">
      <b><a href="forget_password.php?step1=1">Forgot Password</a></b>
     </div>
    </div>
   </div>
   
  </div>
  <br />
  <br />
 </body>
</html>

<script>

