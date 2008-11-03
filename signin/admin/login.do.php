<?php
    include("header.php");
    include("../include/config.php");
    include("function.php");
    //实例化 db_operator 对象
    if(get_magic_quotes_gpc()){
        //处理魔术引号
        foreach($_POST as &$value){
            $value = stripslashes($value);
        }
    }
    extract($_POST); //释放$_POST数组中的元素为变量
    //验证
    if($username == $adminuser && $password == $adminpass){
        //清空输出缓存
        ob_clean();
        //设置管理登录
        $_SESSION['admin'] = true;
        //转向 manage.php
        header("location: manage.php");
    }else{
        adminerror('用户名或密码错误!');
    }
?>
