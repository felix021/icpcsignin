<?php
$relpath = dirname(__FILE__);
include($relpath."/def.php");

include(APP_ROOT."team/inc.php");
$team_id = (int)$_SESSION['team_id'];
$t = new team($team_id);
if($t->errno) msgbox($t->error);

$url = parse_url($_SERVER['HTTP_REFERER']);
$ref = basename($url['path']);
$pass = $_POST['password'];
if(get_magic_quotes_gpc()){
    $pass = stripslashes($pass);
}
if($pass != $t->password){
    msgbox("请输入正确的密码！");
}
if($ref == "index.php" || $ref == "unsetteam.php"){
    if (team::delById($team_id)){
        unset($_SESSION['team_id']);
        include(APP_ROOT."include/header.php");
        $msg = <<<eot
<p>队伍已经删除</p>
<p><a href="$installDir/index.php">返回首页</a></p>
eot;
        msgbox($msg, false);
    }else{
        msgbox("删除队伍失败");
    }
}else{
    msgbox("入口错误! 请从队伍管理界面点击删除队伍");
}
?>
