<?php
include("../inc.php");
include("../verifiedmail.php");

$team_id = (int)$_SESSION['team_id'];

$m = new member($_GET['member_id']);
if($m->errno) msgbox($m->error);
if($m->team_id != $_SESSION['team_id']){
    msgbox("错误的成员编号！请不要而已提交，谢谢合作！");
}

if(member::delById($m->member_id)){
    msgbox("删除成功!");
}else{
    msgbox("删除失败!");
}

include("../../include/footer.php");
?>
