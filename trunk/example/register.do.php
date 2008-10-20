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
    //注册
    $conn->register($username, $password, $description);
    if($conn->errno){ error($conn->error); }
    //清空输出缓存
    ob_clean();
    //转向 manage.php
    header("location: manage.php");
?>
