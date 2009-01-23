<?php
include_once("inc.php");

if(isset($_SESSION['team_id'])){
    $team_id = (int) $_SESSION['team_id'];
}else if(isset($_GET['team_id'])){
    $team_id = (int) $_GET['team_id'];
}

$a = new team($team_id);
if($a->errno) msgbox($a->error);

if($a->vcode == ""){
    msgbox("队伍{$a->team_name}已经验证");
}else if($_GET['vcode'] == $a->vcode){
    $a->vcode = "";
    if($a->update()){
        msgbox("验证成功");
        $_SESSION['team_id'] = $team_id;
    }else{
        msgbox($a->error);
    }
}else{
    msgbox("验证码输入错误，请检查后重新输入");
}

?>
