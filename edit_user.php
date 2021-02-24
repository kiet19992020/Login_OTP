<?php
$page_title = 'Update';
include('includes/header.html');
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="back-end/css/admin/edit_user.css" rel="stylesheet" />
	<title>Edit_User</title>
</head>

<body>
	<?php
	$connect = mysqli_connect("localhost", "root", "", "thi_php");
	mysqli_set_charset($connect, 'UTF8');
	$msg = "";
	if (isset($_GET['edit_id'])) {
		$edit_id = $_GET['edit_id'];

		$sql_up = "SELECT * FROM register_user WHERE register_user_id='$edit_id'";
		$query_up = mysqli_query($connect, $sql_up);
		$row_up = mysqli_fetch_assoc($query_up);

		if (
			isset($_POST['submit']) && $_POST['user_name'] != '' && $_POST['user_password']
			!= '' && $_POST['user_email'] != ''
		) {

			$user_name = $_POST['user_name'];
			$user_password = $_POST['user_password'];
			$user_email = $_POST['user_email'];


			//up ảnh
			// $image = $_FILES['image']['name'];
			// $target = "web_images/".basename($image);
			// if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) 
			// {
			// 	$msg = "Upload ảnh thành công";
			// }else
			// {
			// 	$msg = "Lỗi khi upload ảnh";
			// }
			//up ảnh
			$sql = "SELECT * FROM register_user WHERE register_user_id='$edit_id'";

			$query = mysqli_query($connect, $sql);
			$sql =
				"UPDATE register_user SET user_name='$user_name', user_password='$user_password', user_email='$user_email',
                 WHERE register_user_id='$edit_id'";

			mysqli_query($connect, $sql);

			echo "<script language='javascript'>alert('Cập nhật thành công')</script>";
			$sql_up = "SELECT * FROM register_user WHERE register_user_id='$edit_id'";
			$query_up = mysqli_query($connect, $sql_up);
			$row_up = mysqli_fetch_assoc($query_up);
		}
	}
	?>
	<div class="content_edit">
		<div class="to">
			<form action="" class="form" method="POST" enctype="multipart/form-data">
				<h2 style="color:#FF0000;"> UPDATE</h2>

				Email<input type="email" name="user_email" value="<?php echo $row_up['user_email'] ?>">
				Tài Khoản<input type="text" name="user_name" value="<?php echo $row_up['user_name'] ?>">
				Mật Khẩu<input type="password" name="user_password" value="<?php echo $row_up['user_password'] ?>">
				Nhập Lại<input type="password" name="repassword" value="<?php echo $row_up['user_password'] ?>">
				<input id="submit" type="submit" class="btn btn-info info" name="submit" value="Update"></br>
				<a style="margin-left:84px ; bottom: 10px; color:white" href="ql_user.php" name="submit" class="btn btn-warning">Cancel</a>
			</form>

		</div>
		<?php include('includes/footer.html'); ?>
	</div>
</body>

</html>