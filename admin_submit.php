<?php
    session_start();
    $connect = mysqli_connect("localhost", "root", "","thi_php");
    mysqli_set_charset($connect, 'UTF8');
    
    if(isset($_POST["login"]) && $_POST["user_name"] != '' && $_POST["user_password"] != ''){
     
        $user_name = $_POST["user_name"];
        $user_password = $_POST["user_password"];
        $user_password = md5($user_password);

        $sql = "SELECT * FROM register_user WHERE user_name ='$user_name' AND user_password = '$user_password'  Limit 1";
        
        $user = mysqli_query($connect, $sql);
        
        if( mysqli_num_rows($user) == 1){
            $_SESSION["user"] = $user_name;
            $_SESSION["user_password"] = $user_password;
            header("location:ql_user.php");
        }
        else{
            $_SESSION["thongbao"] = "<script language='javascript'>alert('Sai Tên Đăng Nhập Hoặc Mật Khẩu')</script>";
            header("location: index.php");
        } 
    }
    else{
     
        header("location: index.php");  
    }
