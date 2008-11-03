<?php
    session_start();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
</head>
<body>
<?php
    if($_SESSION['logged'] == true){
        //如果已经标识为登录
        echo <<<eot
欢迎! <a href="index.php?act=logout">退出登录</a>
eot;
    }else{
        echo <<<eot
请先<a href="index.php">登录</a>!
eot;
    }
?>
</body>
</html>
