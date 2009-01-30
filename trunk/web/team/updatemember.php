<?php
include("inc.php");
include("verify.php");

$team_id = (int)$_SESSION['team_id'];
$a = new team($team_id);
if($a->errno){
    msgbox($a->error);
}
if($a->vcode != ""){
    msgbox("请先验证邮箱后再进行此操作");
}


if(get_magic_quotes_gpc()){
    foreach($_POST as &$value){
        $value = stripslashes($value);
    }
}
extract($_POST, EXTR_OVERWRITE);

$m = new member($member_id);
if($m->errno) msgbox($m->error);
if($m->team_id != $_SESSION['team_id']){
    msgbox("错误的成员编号！请不要而已提交，谢谢合作！");
}

$m->stu_number = $stu_number;
$m->member_name = $member_name;
$m->member_name_pinyin = $member_name_pinyin;
$m->gender = $gender;
$m->school_id = $school_id;
$m->faculty_major = $faculty_major;
$m->grade_class = $grade_class;
$m->email = $email;
$m->telephone = $telephone;
$m->remark = $remark;

if($m->update()){
    msgbox("更新成功!");
}else{
    msgbox("更新失败: " . $m->error);
}

include("../include/footer.php");
?>
