<?php
ob_start();
date_default_timezone_set("PRC");
if(file_exists('lock.txt')){
    die('Please remove lock.txt first!');
}
if(!isset($_POST['adminpass'])){
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <title>输入数据</title>
</head>
<body>
    <form method="post">
管理员密码: <input type="text" name="adminpass" value="123456"/><br/>
<br/>
数据库主机: <input type="text" name="dbhost" value="localhost"/><br/>
数据库用户: <input type="text" name="dbuser" value="root"/><br/>
数据库密码: <input type="text" name="dbpass" value="123456"/><br/>
数据库名称: <input type="text" name="dbname" value="signin"/><br/>
数据表前缀: <input type="text" name="tblprefix" value="2008"/><br/>
<br/>
比赛名称: <input type="text" name="contestname" value="第n届华中北区程序设计邀请赛"/><br/>
赞助商: <input type="text" name="sponsor" value="百度"/><br/>
<br/>
报名开始时间: <input type="text" name="signinbegin" value="<?php echo date("Y-m-d H:i:s"); ?>"/><br/>
报名截止时间: <input type="text" name="signinend" value="<?php echo date("Y-m-d H:i:s"); ?>"/><br/>
预赛开始时间: <input type="text" name="prebegin" value="<?php echo date("Y-m-d H:i:s"); ?>"/><br/>
决赛开始时间: <input type="text" name="finalbegin" value="<?php echo date("Y-m-d H:i:s"); ?>"/><br/>
<!--
<br/>
For PHP Mailer<br/>
用户名: <input type="text" name="phpmaileruser" value=""/><br/>
密码: <input type="text" name="phpmailerpass" value=""/><br/>
主机: <input type="text" name="phpmailerhost" value=""/><br/>
-->
<br/>
每页显示数: <input type="text" name="itemsperpage" value="10"/><br/>
    <input type="submit" value="确定"/>
    </form>
</body>
</html>
<?php
}else{
    if(!get_magic_quotes_gpc()){
        foreach($_POST as &$value)
            $value = addslashes($value);
    }
    extract($_POST, EXTR_SKIP);
    $config = <<<eot
<?php
    \$adminpass = "$adminpass";

    \$dbhost = "$dbhost";
    \$dbuser = "$dbuser";
    \$dbpass = "$dbpass";
    \$dbname = "$dbname";
    \$tblprefix = "$tblprefix";

    \$contestname = "$contestname";
    \$sponsor = "$sponsor";

    \$signinbegin = "$signinbegin";
    \$signinend = "$signinend";
    \$prebegin = "$prebegin";
    \$finalbegin = "$finalbegin";

    \$itemsperpage = $itemsperpage;
?>
eot;
    file_put_contents("../include/config.php", $config);

    foreach($_POST as &$value)
        $value = stripslashes($value);
    extract($_POST, EXTR_SKIP);
    if($conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname)){
        include("database.php");
        $query = split(";", $query);
        foreach($query as $q){
            if(trim($q) == "") continue;
            $conn->query($q);
            if($conn->errno){
                ob_clean();
                die("Query: $q<br/>" . $conn->error);
            }
        }
        file_put_contents('lock.txt', "");
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <title>安装成功!</title>
</head>
<body>安装成功! <a href="index.php">管理员登录&gt;&gt;</a></body></html>
<?php
    }else{
        ob_clean();
        die("Error connecting.");
    }
}

?>
