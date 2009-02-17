<?php

$relpath = dirname(__FILE__);
include($relpath."/def.php");

include(APP_ROOT."team/inc.php");
include(APP_ROOT."team/verify.php");

$team_id = (int)$_SESSION['team_id'];
$a = new team($team_id);
if($a->errno){
    msgbox($a->error);
}
if($a->vcode != ""){
    msgbox("请先验证邮箱后再进行此操作");
}

$query = "SELECT * FROM `{tblprefix}`_members WHERE `team_id`={$team_id}";
$res = getQuery($conn, $query);

if($conn->affected_rows == 0){
    echo <<<eot

eot;
}

include(APP_ROOT."include/footer.php");
?>
