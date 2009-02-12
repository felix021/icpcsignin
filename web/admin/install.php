<?php
ob_start();
$relpath = dirname(__FILE__);
include($relpath."/def.php");

date_default_timezone_set("PRC");
if(file_exists(APP_ROOT.'admin/lock.txt')){
    die('Please remove lock.txt first!');
}
if(!isset($_POST['adminpass'])){
    include(APP_ROOT."include/config.php");
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <title>输入数据</title>
</head>
<body>
    <form method="post">
管理员密码: <input type="text" name="adminpass" value="<?php echo $adminpass; ?>"/><br/>
<br/>
数据库主机: <input type="text" name="dbhost" value="<?php echo $dbhost; ?>"/><br/>
数据库用户: <input type="text" name="dbuser" value="<?php echo $dbuser; ?>"/><br/>
数据库密码: <input type="text" name="dbpass" value="<?php echo $dbpass; ?>"/><br/>
数据库名称: <input type="text" name="dbname" value="<?php echo $dbname; ?>"/><br/>
数据表前缀: <input type="text" name="tblprefix" value="<?php echo $tblprefix; ?>"/><br/>
<br/>
比赛名称: <input type="text" name="contestname" value="<?php echo $contestname; ?>"/><br/>
赞助商: <input type="text" name="sponsor" value="<?php echo $sponsor; ?>"/><br/>
<br/>
报名开始时间: <input type="text" name="signinbegin" value="<?php echo date("Y-m-d 00:00:00"); ?>"/><br/>
报名截止时间: <input type="text" name="signinend" value="<?php echo date("Y-m-d 23:59:59"); ?>"/><br/>
预赛开始时间: <input type="text" name="prebegin" value="<?php echo date("Y-m-d 09:00:00"); ?>"/><br/>
决赛开始时间: <input type="text" name="finalbegin" value="<?php echo date("Y-m-d 09:00:00"); ?>"/><br/>
<br/>
系统安装目录: <input type="text" name="installDir" value="<?php echo $installDir; ?>"/><br/>
<br/>
每页显示数: <input type="text" name="itemsperpage" value="<?php echo $itemsperpage; ?>"/><br/>
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

    \$installDir = "$installDir";

    \$itemsperpage = $itemsperpage;
?>
eot;
    file_put_contents(APP_ROOT."include/config.php", $config);

    foreach($_POST as &$value)
        $value = stripslashes($value);
    extract($_POST, EXTR_SKIP);
    if($conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname)){
        include(APP_ROOT."admin/database.php");
        $query = split(";", $query);
        foreach($query as $q){
            if(trim($q) == "") continue;
            $conn->query($q);
            if($conn->errno){
                ob_clean();
                die("Query: $q<br/>" . $conn->error);
            }
        }
        file_put_contents(APP_ROOT.'admin/lock.txt', "");
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
