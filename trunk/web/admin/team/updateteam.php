<?php
include("../inc.php");

$team_id = (int)$_GET['team_id'];

$a = new team($team_id);
if($a->errno){
    msgbox($a->error);
}

if(get_magic_quotes_gpc()){
    foreach($_POST as &$value){
        $value = stripslashes($value);
    }
}
extract($_POST, EXTR_OVERWRITE);

$a->email = $email;
$a->vcode = $vcode;
$a->password = $password;
$a->telephone = $telephone;
$a->address = $address;
$a->postcode = $postcode;
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
if($valid_for_final == 1){
    $a->valid_for_final = 1;
}else{
    $a->valid_for_final = 0;
}

$a->pre_solved = $pre_solved;
$a->pre_penalty = $pre_penalty;
$a->final_solved = $final_solved;
$a->final_penalty = $final_penalty;

$a->requirement = $requirement;
$a->remark = $remark;

if($a->update()){
    msgbox("更新成功!");
}else{
    msgbox($a->error);
}


include("../include/footer.php");
?>
