<?php
    include('header.php');
    include('../include/config.php');
    include('verify.php');
    include('../include/function.php');
    include('function.php');
    $conn = new db_operator($dbhost, $dbuser, $dbpass, $dbname);
    if($conn->errno){ adminerror($conn->error); }
    $id = (int)$_GET['id'];
    $query = 'DELETE FROM `info` WHERE `id`='.$id;
    $conn->query($query);
    if($conn->errno == 0){
        $msg = '删除成功!';
    }else{
        $msg = '删除失败: ' . $conn->error;
    }
    ob_clean();
    adminerror($msg);
?>
