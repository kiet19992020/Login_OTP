<?php
$page_title = 'Quản Lý User';
require('includes/header.html');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="back-end/css/admin/ql_user.css" rel="stylesheet" />
</head>

<body>
    <div class="content_ql">
        <?php
        $conn = mysqli_connect('localhost', 'root', '', 'thi_php');
        mysqli_set_charset($conn, 'UTF8');
        $rowsPerPage = 4;
        $page = 1;
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        }
        //vị trí của mẩu tin đầu tiên trên mỗi trang
        $offset = ($page - 1) * $rowsPerPage;
        //lấy $rowsPerPage mẩu tin, bắt đầu từ vị trí $offset


        if (isset($_POST["search"])) {
            $name_search = $_POST['nhap'];
            $sql = "select * from register_user where user_name like '%$name_search%' LIMIT " . $offset . ", " . $rowsPerPage;
            mysqli_query($conn, $sql);
        } else {
            $sql = "select * from register_user LIMIT " . $offset . ", " . $rowsPerPage;
        }
        $result = mysqli_query($conn, $sql);
        ?>
        <form class="form-inline" style="padding-top:150px ; padding-left:650px" action="" method="POST" enctype="multipart/form-data">
            <div class="form-group p-2">
                <input class="form-control" size="50" type="text " id="" name="nhap" value="">
            </div>
            <div class="form-group p-2">
                <button type="submit" class="btn btn-danger" name="search">Tiềm Kiếm</button>
            </div>
            <div class="form-group p-2">
                <button type="reset" class="btn btn-warning " name=""><a href="ql_user.php" style="text-decoration: none; color:white">Hủy</a></button>
            </div>
        </form>
        <div>
            <table>
                <tr style="text-align:center;color :black">
                    <th width="50px;">STT</th>
                    <th width="50px;">Tên</th>
                    <th width="100;">Email</th>
                    <th width="50;">Mật khẩu</th>
                    <!-- <th width="100;">Cấpbậc</th> -->
                    <th width="100;">Giớitính</th>
                    <!-- <th width="100;">Ảnh</th> -->
                    <th width="100;">Xóa</th>
                    <th width="100;">Sửa</th>
                </tr>
                <?php
                if (mysqli_num_rows($result) <> 0) {
                    $stt = 1;
                    while ($rows = mysqli_fetch_array($result)) {
                        echo "<tr>";
                        echo "<td>$stt</td>";

                        echo "<td>$rows[user_name]</td>";
                        echo "<td>$rows[user_email]</td>";
                        echo "<td>$rows[user_password]</td>";

                        //    if($rows["level"]==1)
                        //    {
                        //        echo "<td>Admin</td>";
                        //    }
                        //    elseif($rows["level"]!=1)
                        //    {
                        //        echo "<td>User</td>";
                        //    }
                        //    if($rows["gioitinh"]==1)
                        //    {
                        //        echo "<td><img src='web_images/0.jpg' style='height:30px;width:30px'></td>";
                        //    }
                        //    elseif($rows["gioitinh"]!=1)
                        //    {
                        //        echo "<td><img src='web_images/1.png' style='height:30px;width:30px'></td>";
                        //    }
                        echo "<td><img style ='height: 30px;width: 30px;' src='web_images/$rows[user_avatar]'></td>";
                        echo "<td><a onclick ='return del(`$rows[user_name]`)' href='delete_user.php?delete_id=$rows[register_user_id]' ><button class='btn btn-danger'>Xóa</button></a></td>";
                        echo "<td><a href='edit_user.php?edit_id=$rows[register_user_id]'><button class='btn btn-success'>Sửa</button></a></td>";
                        echo "</tr>";
                        $stt += 1;
                    } //while
                }
                ?>
        </div>
        </table>
        <?php
        echo '<div style="text-align:center">';
        $re = mysqli_query($conn, 'select * from register_user');
        //tổng số mẩu tin cần hiển thị
        $numRows = mysqli_num_rows($re);
        //tổng số trang
        $maxPage = floor($numRows / $rowsPerPage) + 1;


        //tổng số trang
        $maxPage = floor($numRows / $rowsPerPage) + 1;
        //tạo link tương ứng tới các trang
        for ($i = 1; $i <= $maxPage; $i++) {
            if ($i == $page) {
                echo '<b>' . $i . '</b> '; //trang hiện tại sẽ được bôi đậm
            } else
                echo "<a href=" . $_SERVER['PHP_SELF'] . "?page=" . $i . ">" . $i . "</a> ";
        }

        echo '</div>';
        ?>
    </div>

</body>

</html>
<script>
    function del(name) {
        return confirm("Bạn Có Chắc Muốn Xóa " + name + "?");
    }
</script>
<?php include('includes/footer.html'); ?>