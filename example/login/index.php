<?php
    ob_start(); //开启输出缓冲
    session_start(); //开启session
    if($_GET['act'] == 'logout') 
        session_destroy(); //注销
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
<title>登录</title>
</head>
<body>
<form action="login.php" method="post">
用户名: <input type="text" name="user"/><br/>
密码: <input type="password" name="pass"/><br/>
<input type="submit" value="登录"/>
</form>
测试用户名为test，密码为test
</body>
</html>
