<?php
    $a = new team((int)$_SESSION['team_id']);
    if($a->errno){
        msgbox($a->error);
    }
    if($a->vcode != ""){
        msgbox("请先验证邮箱后再进行此操作");
    }
    unset($a);
?>
