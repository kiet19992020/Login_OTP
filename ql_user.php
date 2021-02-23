<?php
$page_title = 'Quản Lý User';
require ('includes/header.html');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    
table, th, td{
   
    text-align: center;
    border: 1px solid black;
    height: 50px;
    width: 1000px;
    margin: 30px 5px 50px 130px;
   
}
table{
    border-collapse:collapse;
  
    box-shadow: 5px 5px 15px 5px #66CDAA;   
}

table tr:nth-child(odd){
    background-color:#DCDCDC;
}
table tr:nth-child(even){
    background-color:white;
}
table tr:nth-child(1){
    background-color:skyblue;
}
.content_ql{
    background-color: black;
    background-image: url(web_images/bg2.jpg);
    background-size: cover;
}

</style>
<body>
    <div class="content_ql">
         <?php
                    $conn = mysqli_connect('localhost', 'root', '', 'thi_php');
                        mysqli_set_charset($conn, 'UTF8');

                        $rowsPerPage=4;
                        $page = 1;
                        if (isset($_GET['page']))
                        { 
                            $page = $_GET['page'];
                        }
                        //vị trí của mẩu tin đầu tiên trên mỗi trang
                        $offset =($page-1)*$rowsPerPage;
                        //lấy $rowsPerPage mẩu tin, bắt đầu từ vị trí $offset

                        
                        if(isset($_POST["search"]))
                        {
                            $name_search = $_POST['nhap'];
                            $sql = "select * from user where name like '$name_search' LIMIT ". $offset . ", " .$rowsPerPage;
                            mysqli_query($conn,$sql);
                        }else
                        {
                            $sql = "select * from user LIMIT ". $offset . ", " .$rowsPerPage;
                        }
                        $result = mysqli_query($conn,$sql);

            ?>
    <form action="" method ="POST" enctype="multipart/form-data" style='padding:50px 0px 0px 350px'>
    <div class="form-group row">
    
        <div class="col-sm-6">
            <input class="form-control"  type="text " id="" size="20" name="nhap" value="">
        </div>
        <div class="col-sm-2">
        <button type="submit"  class="btn btn-danger  ml-1" name="search">Tiềm Kiếm</button>
        </div>
        <div class="col-sm-1">
        <button type="reset"  class="btn btn-danger " name=""><a href="ql_user.php" style="text-decoration: none; color:white">Hủy</a></button>
        </div>
        
    </div>
    
    </form>
        <div>                  
                <table >
                    <tr style="text-align:center;color :black">
                        <th width="50px;">STT</th>
                        <th width="50px;">Tên</th>
                        <th width="100;">Email</th>
                        <th width="50;">Mật khẩu</th>
                        <th width="100;">Cấpbậc</th>
                        <th width="100;">Giớitính</th>
                        <th width="100;">Ảnh</th>
                        <th width="50;">Xóa</th>
                        <th width="50;">Sửa</th>
                    </tr>
               <?php
                   if(mysqli_num_rows($result)<>0)
                   { $stt=1;
                   while($rows=mysqli_fetch_array($result))
                   { echo "<tr>";
                       echo "<td>$stt</td>";
                     
                       echo "<td>$rows[name]</td>";
                       echo "<td>$rows[email]</td>";
                       echo "<td>$rows[password]</td>";
                       
                       if($rows["level"]==1)
                       {
                           echo "<td>Admin</td>";
                       }
                       elseif($rows["level"]!=1)
                       {
                           echo "<td>User</td>";
                       }
                       if($rows["gioitinh"]==1)
                       {
                           echo "<td><img src='web_images/0.jpg' style='height:30px;width:30px'></td>";
                       }
                       elseif($rows["gioitinh"]!=1)
                       {
                           echo "<td><img src='web_images/1.png' style='height:30px;width:30px'></td>";
                       }
                       echo "<td><img style ='height: 30px;width: 30px;' src='web_images/$rows[image]'></td>";
                       echo "<td><a onclick ='return del(`$rows[name]`)' href='delete_user.php?delete_id=$rows[id]' ><button class='btn btn-danger'>Xóa</button></a></td>";
                       echo "<td><a href='edit_user.php?edit_id=$rows[id]'><button class='btn btn-success'>Sửa</button></a></td>";
                       echo "</tr>";
                   $stt+=1;
                   }//while
                   }
               ?>
                </div>
                </table>
                <?php
                echo '<div style="text-align:center">';
                $re = mysqli_query($conn, 'select * from user');
                //tổng số mẩu tin cần hiển thị
                $numRows = mysqli_num_rows($re);
                //tổng số trang
                $maxPage = floor($numRows/$rowsPerPage) + 1;
              

                //tổng số trang
                $maxPage = floor($numRows/$rowsPerPage) + 1;
                //tạo link tương ứng tới các trang
                for ($i=1 ; $i<=$maxPage ; $i++)
                { if ($i == $page)
                { echo '<b>'.$i.'</b> '; //trang hiện tại sẽ được bôi đậm
                }
                else
                echo "<a href=" .$_SERVER['PHP_SELF']. "?page=".$i.">".$i."</a> ";
                }

                echo '</div>';
                ?>
    </div>
         
</body>
</html>
<script>
    function del(name){
        return confirm("Bạn Có Chắc Muốn Xóa " + name + "?");
    }
</script>
<?php include ('includes/footer.html'); ?>