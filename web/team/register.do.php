<?php
include("inc.php");

if(get_magic_quotes_gpc()){
    foreach($_POST as &$value){
        $value = stripslashes($value);
    }
}
extract($_POST, EXTR_OVERWRITE);

$a = new team;

if($team_type == 1){ //武汉大学队伍
    $a->school_id = 1;
}else if($team_type == 2){
    if($school_id > 0){ //选择了队伍
        $a->school_id = $school_id;
    }else{ 
        $error = "请选择队伍";
    }
}else{ //高中队伍
    $a->school_id = -1;
}

$a->team_name = $team_name;
if(strlen($team_name) > 20){
    $error = "队名太长(20字符以内)";
}else if($team_name == ""){
    $error = "请填写队名";
}

$a->password = $password;
if(strlen($password) > 20){
    $error = "密码太长(20字符以内)";
}else if($password == ""){
    $error = "请填写密码";
}

$a->email = $email;
if(!ereg(".*@.*\..*", $email)){
    $error = "邮箱地址格式错误";
}else if(strlen($email) > 50){
    $error = "邮箱地址太长(<=50字符)";
}else if($email == ""){
    $error = "请填写邮箱";
}

$a->telephone = $telephone;
if(strlen($telephone) > 20){
    $error = "电话太长(20字符以内)";
}else if($telephone == ""){
    $error = "请填写电话";
}

$a->address = $address;
if(strlen($address) > 100){
    $error = "地址太长(100字符以内)";
}else if($address == ""){
    $error = "请填写地址";
}

$a->postcode = $postcode;
if(strlen($postcode) > 20){
    $error = "邮编太长(20字符以内)";
}else if($postcode == ""){
    $error = "请填写邮编";
}

if(isset($valid_for_final)){
    $a->valid_for_final = 1;
}else {
    $a->valid_for_final = 0;
}

if($error != ""){
    msgbox($error);
}

$a->vcode = rndstr();
if($a->insert()){
    msgbox("队伍注册成功，请前往注册邮箱查收验证码({$a->vcode})。");
}else{
    msgbox($a->error);
}

include("../include/footer.php");
?>
