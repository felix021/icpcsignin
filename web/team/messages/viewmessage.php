<?php
include("../inc.php");
include("../verifiedmail.php");
if(!isset($_GET['msg_id'])){
    echo <<<eot
查看消息内容:<br/>
请点击下面的链接查看消息.
eot;
}else{
    $team_id = (int)$_SESSION['team_id'];
    $msg_id = (int)$_GET['msg_id'];
    $a = new message($msg_id);
    if($a->to_id != $team_id && $a->from_id != $team_id){
        echo <<<eot
消息id错误，请不要恶意提交，谢谢.
eot;
    }
    encodeObject($a);
    echo <<<eot
<script src="msgfunc.js"></script>
阅读消息内容<br/>
<textarea cols="40" rows="5">$a->message_content</textarea><br/>
<input type="button" value="回复" onclick="javascript:reply({$a->message_id})"/>
eot;
    if($a->to_id == $team_id){
        $a->read = 1;
        $a->update();
    }
}
include("../../include/footer.php");
?>
