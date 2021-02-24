	<?php

            $connect = mysqli_connect("localhost", "root", "", "thi_php");
            mysqli_set_charset($connect, 'UTF8');

			if(isset($_GET['delete_id'])  ){
				
				$delete_id = $_GET['delete_id'];
                $sql = "DELETE FROM register_user WHERE register_user_id =$delete_id";
                
				$query = mysqli_query($connect,$sql);
                header('location:ql_user.php');
				
			}
			
		?>