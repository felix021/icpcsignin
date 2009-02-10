<?php
include("inc.php");
include("verify.php");

$team_id = (int)$_SESSION['team_id'];
$a = new team($team_id);
if($a->errno){
    msgbox($a->error);
}

if(get_magic_quotes_gpc()){
    foreach($_POST as &$value){
        $value = stripslashes($value);
    }
}
extract($_POST, EXTR_SKIP);

switch($_GET['action']){
case "basicinfo":
    $a->telephone = $telephone;
    $a->address = $address;
    $a->postcode = $postcode;
    $a->remark = $remark;
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
    $a->valid_for_final = $valid_for_final == 1 ? 1 : 0;

    if($a->update()){
        msgbox("更新成功!");
    }else{
        msgbox($a->error);
    }
    break;

case "email":
    $a->vcode = rndstr();
    if($a->update()){
        //send verify mail
        if(sendvcode($a->team_id, $info)){
            msgbox("更改成功，请前往注册邮箱查收验证码");
        }else{
            msgbox("更改成功，但验证码发送失败: $info");
        }
    }else{
        msgbox($a->error);
    }
    break;

case "password":
    if($a->password == $old_pass){
        if(empty($new_pass)) msgbox("密码不能为空!");
        if($new_pass == $new_pass_confirm){
            $a->password = $new_pass;
            if($a->update()){
                msgbox("更改密码成功!");
            }else{
                msgbox($a->error);
            }
        }else{
            msgbox("确认密码错误!");
        }
    }else{
        msgbox("密码错误!");
    }
    break;

default:
    msgbox("请勿恶意提交，谢谢合作！");
}


if($conn->affected_rows == 0){
    echo <<<eot

eot;
}

include("../include/footer.php");
?>
