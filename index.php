<?php

session_start();

?>

<!DOCTYPE html>
<html>

<head>
    <title>PHP Login with OTP Authentication</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="http://code.jquery.com/jquery.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="back-end/css/admin/style.css" rel="stylesheet" />
    <link href="back-end/css/admin/login.css" rel="stylesheet" />
</head>

<body>

    <div class="container">
        <div class="svg-wrapper">
            <svg height="60" width="320" xmlns="http://www.w3.org/2000/svg">
                <rect class="shape" height="60" width="320" />
            </svg>
            <h1 style="text-align: center;" class="text">Login</h1>
        </div>

        <?php

        if (isset($_SESSION["thongbao"])) {
            echo $_SESSION["thongbao"];
            session_unset();
        }

        if (isset($_GET["register"])) {
            if ($_GET["register"] == 'success') {
                echo '
     <h1 class="text-success">Email Successfully verified, Registration Process Completed...</h1>
     ';
            }
        }

        if (isset($_GET["reset_password"])) {
            if ($_GET["reset_password"] == 'success') {
                echo '<h1 class="text-success">Password change Successfully, Now you can login with your new password</h1>';
            }
        }
        ?>

        <div class="row">
            <div class="col-md-3">&nbsp;</div>
            <div class="col-md-6">
                <div class="panel panel-warning">
                    <div class="panel-heading">

                    </div>
                    <div class="panel-body">
                        <form method="POST" action="admin_submit.php" id="login_form">
                            <div class="form-group" id="email_area">
                                <label>Enter Username</label>
                                <input type="text" name="user_name" class="form-control" />

                            </div>
                            <div class="form-group" id="password_area">
                                <label>Enter Password</label>
                                <input type="password" name="user_password" class="form-control" />

                            </div>
                            <div class="form-group" align="center">
                                <input type="submit" name="login" class="btn btn-warning" value="Login" />
                                <a href="register.php" class="btn btn-success">Sign Up</a>

                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="container">
        <div class="svg-wrapper">
            <svg height="60" width="320" xmlns="http://www.w3.org/2000/svg">
                <rect class="shape" height="60" width="320" />
            </svg>
            <h1 style="text-align: center;" class="text"><b><a href="forget_password.php?step1=1">Forgot Password?</a></b></h1>
        </div>
</body>

</html>

<script>