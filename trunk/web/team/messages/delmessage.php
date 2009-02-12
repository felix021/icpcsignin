<?php
$relpath = dirname(__FILE__);
include($relpath."/def.php");

include(APP_ROOT."team/inc.php");
include(APP_ROOT."team/verify.php");
ob_clean();

$team_id = (int)$_SESSION['team_id'];
$msg_id = (int)$_GET['msg_id'];

$a = new message($msg_id);
if($a->from_id == $team_id || $a->to_id == $team_id){
    if(message::delById($msg_id)){
        echo 0;
    }else{
        echo 1;
    }
}else{
    echo 2;
}
?>
