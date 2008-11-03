<?php
    include("include/header.php");
    include("include/config.php");
    include("include/function.php");
    //实例化 db_operator 对象
    $conn = new db_operator($dbhost, $dbuser, $dbpass, $dbname);
    if($conn->errno){ error($conn->error); }
    if(get_magic_quotes_gpc()){
        //处理魔术引号
        foreach($_POST as &$value){
            $value = stripslashes($value);
        }
    }
    extract($_POST); //释放$_POST数组中的元素为变量
    //检测新密码和重复的新密码是否对上
    if($newpass != $newpass1) error('重复新密码有误!');
    //注册
    $id = (int)$_SESSION['id'];
    $conn->update($id, $oldpass, $newpass, $description);
    if($conn->errno){ error($conn->error); }
    //清空输出缓存
    ob_clean();
    //转向 manage.php
    header("location: manage.php?msg=".urlencode('更新成功!'));
?>
