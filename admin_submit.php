<?php
    
    session_start();
    $connect = mysqli_connect("localhost", "root", "","thi_php");
    mysqli_set_charset($connect, 'UTF8');
    
    if(isset($_POST["login"]) && $_POST["user_name"] != '' && $_POST["user_password"] != ''){
     
        $user_name = $_POST["user_name"];
        $password = $_POST["password"];
       
        $sql = "SELECT * FROM user WHERE user_name='$user_name' AND password='$password' ";
        $user = mysqli_query($connect, $sql);
        if( mysqli_num_rows($user) > 0 ){
            $_SESSION["user"] = $user_name;
            header("location:ql_user.php");
        }
        else{
            $_SESSION["thongbao"] = "<script language='javascript'>alert('Sai Tên Đăng Nhập Hoặc Mật Khẩu')</script>";
            header("location: login.php");
        } 
    }
    else{
     
        header("location: login.php");  
    }
?>