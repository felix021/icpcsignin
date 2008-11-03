<?php
    session_start(); //开启session
    include("config.php"); //包含存放用户名和密码的文件
    if($username == $_POST['user'] && $password == $_POST['pass']){
        //正确，在服务器端标识用户已经注册
        $_SESSION['logged'] = true;
        //重定向到 manage.php
        header("location: manage.php");
        exit;
    }
    //不正确，输出错误信息
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
</head>
<body>
用户名或密码错误，请<a href="javascript:history.back(1)">返回</a>重试!
</body>
</html>
