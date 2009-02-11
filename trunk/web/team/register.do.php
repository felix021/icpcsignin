<?php
include("../include/header.php");
include("../include/classes.php");

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
    msgbox("<p>队伍注册成功，请前往注册邮箱查收验证码。</p><p><a href=\"../index.php\">返回首页</a></p>", false);
}else{
    msgbox($a->error);
}

include("../include/footer.php");
?>
