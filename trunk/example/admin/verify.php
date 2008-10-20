<?php
    if($_SESSION['admin'] != true){
        //如果不是已经登录的管理员，转向
        header("location: index.php");
        exit;
    }
?>
