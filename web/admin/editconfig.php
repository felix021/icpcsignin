<?php
ob_start();
$relpath = dirname(__FILE__);
include($relpath."/def.php");
include(APP_ROOT."admin/inc.php");

date_default_timezone_set("PRC");
if(isset($_POST['adminpass'])){
    if(!get_magic_quotes_gpc()){
        foreach($_POST as &$value)
            $value = addslashes($value);
    }
    extract($_POST, EXTR_OVERWRITE);
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
    msgbox("更新成功!");
}else{
    $adminpass = htmlspecialchars($adminpass);
    $dbhost = htmlspecialchars($dbhost);
    $dbuser = htmlspecialchars($dbuser);
    $dbpass = htmlspecialchars($dbpass);
    $dbname = htmlspecialchars($dbname);
    $tblprefix = htmlspecialchars($tblprefix);
    $contestname = htmlspecialchars($contestname);
    $sponsor = htmlspecialchars($sponsor);
    $signinbegin = htmlspecialchars($signinbegin);
    $signinend = htmlspecialchars($signinend);
    $prebegin = htmlspecialchars($prebegin);
    $finalbegin = htmlspecialchars($finalbegin);
    $installDir = htmlspecialchars($installDir);
    $itemsperpage = htmlspecialchars($itemsperpage);
?>
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
报名开始时间: <input type="text" name="signinbegin" value="<?php echo $signinbegin; ?>"/><br/>
报名截止时间: <input type="text" name="signinend" value="<?php echo $signinend; ?>"/><br/>
预赛开始时间: <input type="text" name="prebegin" value="<?php echo $prebegin; ?>"/><br/>
决赛开始时间: <input type="text" name="finalbegin" value="<?php echo $finalbegin; ?>"/><br/>
<br/>
系统安装目录: <input type="text" name="installDir" value="<?php echo $installDir; ?>"/><br/>
<br/>
每页显示数: <input type="text" name="itemsperpage" value="<?php echo $itemsperpage; ?>"/><br/>
<input type="submit" value="确定"/>
</form>
<?php
eot;
}
    include(APP_ROOT."admin/footer.php");
?>
