<?php
include("def.php");

include(APP_ROOT."include/header.php");
include(APP_ROOT."include/classes.php");

$now = time();
$signin_begin = str2time($signinbegin);
$begin_time = time2str($signin_begin, "Y年m月d日 H时i分");

if($now < $signin_begin){
    $msg = "报名尚未开始，报名开始时间是：{$begin_time}。";
    msgbox($msg);
}

if(get_magic_quotes_gpc()){
    foreach($_POST as &$value){
        $value = stripslashes($value);
    }
}
extract($_POST, EXTR_SKIP);

$a = new team;

if($team_type == 1){ //武汉大学队伍
    $a->school_id = 1;
}else if($team_type == 2){
    if($school_id > 0){ //选择了队伍
        $a->school_id = $school_id;
    }else{
        $a->school_id = -2;
    }
}else{ //高中队伍
    $a->school_id = -1;
}
$a->team_name = $team_name;
$a->password = $password;
$a->email = $email;
$a->telephone = $telephone;
$a->address = $address;
$a->postcode = $postcode;
if(isset($valid_for_final)){
    $a->valid_for_final = 1;
}else {
    $a->valid_for_final = 0;
}
if($a->insert()){
    $info = sendvcode($a->team_id);
    $msg = <<<eot
<p>队伍注册成功，请前往注册邮箱查收验证码。</p>
<p><a href="../index.php">返回首页</a></p>
eot;
    msgbox($msg, false);
}else{
    msgbox($a->error);
}
?>
