<?php
include("def.php");

include(APP_ROOT."team/inc.php");
include(APP_ROOT."team/verifiedmail.php");
$now = time();
$signin_end = str2time($signinend);
$end_time = time2str($signin_end, "Y年m月d日 H时i分");
if($now > $signin_end){
    $msg = "报名已经结束于{$end_time}，如需修改队伍信息请联系管理员。";
    msgbox($msg);
}

$team_id = (int)$_SESSION['team_id'];

$m = new member($_GET['member_id']);
if($m->errno) msgbox($m->error);
if($m->team_id != $_SESSION['team_id']){
    msgbox("无法删除该成员：该成员不属于贵队。");
}

if(member::delById($m->member_id)){
    msgbox("删除成功!");
}else{
    msgbox("删除失败!");
}

include(APP_ROOT."include/footer.php");
?>
