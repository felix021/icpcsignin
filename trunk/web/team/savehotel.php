<?php
include("def.php");
include(APP_ROOT."team/inc.php");
include(APP_ROOT."team/verifiedmail.php");
$team_id = (int) $_SESSION['team_id'];
$t = new team($team_id);
if($t->errno) msgbox($t->error);

$req = $_POST['requirement'];
if(get_magic_quotes_gpc()){
    $req = stripslashes($req);
}
$t->requirement = $req;
if($t->update()){
    msgbox("住宿信息: 保存成功!");
}else{
    msgbox("住宿信息保存失败: ". $t->error);
}
?>
