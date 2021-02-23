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
$user_name = '';
$user_email = '';
$user_password = '';

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
  $user_password = password_hash($user_password, PASSWORD_DEFAULT);
 }

 if($error_user_name == '' && $error_user_email == '' && $error_user_password == '')
 {
  $user_activation_code = md5(rand());

  $user_otp = rand(100000, 999999);

  $data = array(
   ':user_name'  => $user_name,
   ':user_email'  => $user_email,
   ':user_password' => $user_password,
   ':user_activation_code' => $user_activation_code,
   ':user_email_status'=> 'not verified',
   ':user_otp'   => $user_otp
  );

  $query = "
  INSERT INTO register_user 
  (user_name, user_email, user_password, user_activation_code, user_email_status, user_otp)
  SELECT * FROM (SELECT :user_name, :user_email, :user_password, :user_activation_code, :user_email_status, :user_otp) AS tmp
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
   <p>kietnguyen,</p>
   <p>Nguyễn Tấn Kiệt</p>
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
 </head>
 <body>
 <h1 style="text-align: center;">SIGN UP</h1>
  <br />
  <div class="container">
   <br />
   <div class="panel panel-default">
    <div class="panel-heading">
     <h3 class="panel-title">Registration</h3>
    </div>
    <div class="panel-body">
     <?php echo $message; ?>
     <form method="post">
      <div class="form-group">
       <label>Enter Your Name</label>
       <input type="text" name="user_name" class="form-control" />
       <?php echo $error_user_name; ?>
      </div>
      <div class="form-group">
       <label>Enter Your Email</label>
       <input type="text" name="user_email" class="form-control" />
       <?php echo $error_user_email; ?>
      </div>
      <div class="form-group">
       <label>Enter Your Password</label>
       <input type="password" name="user_password" class="form-control" />
       <?php echo $error_user_password; ?>
      </div>

      <div class="form-group">
       <label>Reassword</label>
       <input type="password" name="user_password" class="form-control" />
       <?php echo $error_user_password; ?>
      </div>
      <div class="form-group">
       <input type="submit" name="register" class="btn btn-success" value="Click to Register" />&nbsp;&nbsp;&nbsp;
      </div>
     </form>
    </div>
   </div>
  </div>
  <br />
  <br />
 </body>
</html>
