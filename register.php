<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
		
		require 'PHPMailer-master/Exception.php';
		require 'PHPMailer-master/PHPMailer.php';
		require 'PHPMailer-master/SMTP.php';

if(isset($_SESSION["user_id"]))
{
 header("location:home.php");
}

include('function.php');

$connect = new PDO("mysql:host=localhost; dbname=thi_php", "root", "");

$message = '';
$error_user_name = '';
$error_user_email = '';
$error_user_password = '';
$error_user_repassword = '';
$user_name = '';
$user_email = '';
$user_password = '';
$user_repassword = '';

if(isset($_POST["register"]))
{
 if(empty($_POST["user_name"]))
 {
  $error_user_name = "<label class='text-danger'>Enter Name</label>";
 }
 else
 {
  $user_name = trim($_POST["user_name"]);
  $user_name = htmlentities($user_name);
 }

 if(empty($_POST["user_email"]))
 {
  $error_user_email = '<label class="text-danger">Enter Email Address</label>';
 }
 else
 {
  $user_email = trim($_POST["user_email"]);
  if(!filter_var($user_email, FILTER_VALIDATE_EMAIL))
  {
   $error_user_email = '<label class="text-danger">Enter Valid Email Address</label>';
  }
 }

 if(empty($_POST["user_password"]))
 {
  $error_user_password = '<label class="text-danger">Enter Password</label>';
 }
 else
 {
  $user_password = trim($_POST["user_password"]);
  $user_password = md5($user_password);
 }

 if(empty($_POST["user_repassword"]))
 {
  $error_user_repassword = '<label class="text-danger">Enter Repassword</label>';
 }
 else
 {
  $user_repassword = trim($_POST["user_repassword"]);
  $user_repassword = md5($user_repassword);
 }

 if(($_POST["user_repassword"] == $_POST["user_password"]))
 {
   $user_repassword = trim($_POST["user_password"]);
   $user_repassword = md5($user_password); 
 }
 else
 {
    $error_user_repassword = '<label class="text-danger">Confirm Password is not match</label>';
 }

 if($error_user_name == '' && $error_user_email == '' && $error_user_password == '' && $error_user_repassword == '')
 {
  $user_activation_code = md5(rand());

  $user_otp = rand(100000, 999999);

  $data = array(
   ':user_name'  => $user_name,
   ':user_email'  => $user_email,
   ':user_password' => $user_password,
   ':user_repassword' => $user_repassword,
   ':user_activation_code' => $user_activation_code,
   ':user_email_status'=> 'not verified',
   ':user_otp'   => $user_otp
  );

  $query = "
  INSERT INTO register_user 
  (user_name, user_email, user_password,user_repassword ,user_activation_code, user_email_status, user_otp)
  SELECT * FROM (SELECT :user_name, :user_email, :user_password,:user_repassword ,:user_activation_code, :user_email_status, :user_otp) AS tmp
  WHERE NOT EXISTS (
      SELECT user_email FROM register_user WHERE user_email = :user_email OR user_name = :user_name
  ) 
  ";

  $statement = $connect->prepare($query);

  $statement->execute($data);

  if($connect->lastInsertId() == 0)
  {
   $message = '<label class="text-danger">Email OR Username Already Register</label>';
  } 
  else
  {
   $mail = new PHPMailer();
   $mail->IsSMTP();
   $mail->Host = "ssl://smtp.gmail.com"; 
   $mail->Port = 465;
   $mail->SMTPAuth = true;
   $mail->Username = 'kietnguyen12191219@gmail.com';
   $mail->Password = '0913463624zx';
   $mail->SMTPSecure = 'ssl';
   $mail->From = 'kietnguyen12191219@gmail.com';
   $mail->FromName = 'kietnguyen';
   $mail->AddAddress($user_email);
   $mail->WordWrap = 50;
   $mail->IsHTML(true);
   $mail->Subject = 'Verification code for Verify Your Email Address';
   $mail->SMTPOptions = array(
    'ssl' => array(
    'verify_peer' => false,
    'verify_peer_name' => false,
    'allow_self_signed' => true
    )
    );
    // $mail->SMTPDebug = 3;
   $message_body = '
   <p>Mã xác thực OTP của bạn là: <b>'.$user_otp.'</b>.</p>
   <p>Không nên cung cấp mã này cho bất kỳ ai!</p>
   <p>NTK-admin</p>
   ';
   $mail->Body = $message_body;

   if($mail->Send())
   {
    echo '<script>alert("Please Check Your Email for Verification Code")</script>';

    header('location:email_verify.php?code='.$user_activation_code);
   }
   else
   {
    $message = $mail->ErrorInfo;
   }
  }

 }
}
?>
<!DOCTYPE html>
<html>
 <head>
  <title>OTP</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="http://code.jquery.com/jquery.js"></script>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
     <link href="back-end/css/admin/style.css" rel="stylesheet"/>
     <link href="back-end/css/admin/register.css" rel="stylesheet"/>
 </head>

 <body>
 <div class="svg-wrapper">
  <svg height="60" width="320" xmlns="http://www.w3.org/2000/svg">
    <rect class="shape" height="60" width="320" />
  </svg>
   <H1 style="text-align: center;" class="text">Register</H1>
</div>
 
 
  <div class="container">
   
   <div class="panel panel-info">
    <div class="panel-heading">
 
    </div>
    <div class="panel-body">
     <?php echo $message; ?>
     <form method="post">
      <div class="form-group">
       <label>Enter Your Name</label>
       <input type="text" name="user_name" value="<?php  echo $user_name;?>"  class="form-control" />
       <?php echo $error_user_name; ?>
      </div>
      <div class="form-group">
       <label>Enter Your Email</label>
       <input type="text" name="user_email" value="<?php  echo $user_email;?>" class="form-control" />
       <?php echo $error_user_email; ?>
      </div>
      <div class="form-group">
       <label>Enter Your Password</label>
       <input type="password" name="user_password" class="form-control" />
       <?php echo $error_user_password; ?>
      </div>

      <div class="form-group">
       <label>Repassword</label>
       <input type="password" name="user_repassword" class="form-control" />
       <?php echo $error_user_repassword; ?>
      </div>
      <div class="form-group text-center">
       <input type="submit" name="register" class="btn btn-info" value="Click to Register" />&nbsp;&nbsp;&nbsp;
       <a href="index.php" class="btn btn-warning">Login</a>
      </div>
     </form>
    </div>
   </div>
  </div>
  <br />
  <br />
 
 </body>
</html>
