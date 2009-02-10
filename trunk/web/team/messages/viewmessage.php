<?php
include("../inc.php");
include("../verifiedmail.php");
if(!isset($_GET['msg_id'])){
    echo <<<eot
<p>查看消息内容</p>
<p>请点击上面的"查看"按钮查看消息.</p>
eot;
}else{
    $team_id = (int)$_SESSION['team_id'];
    $msg_id = (int)$_GET['msg_id'];
    $a = new message($msg_id);
    if($a->to_id != $team_id && $a->from_id != $team_id){
        echo <<<eot
消息id错误，请不要恶意提交，谢谢.
eot;
    }else{
        encodeObject($a);
        $type = $a->to_id == $team_id ? "reply" : "cont";
        $disp = $a->to_id == $team_id ? "回复" : "追加";
        echo <<<eot
<script src="msgfunc.js"></script>
阅读消息内容 
<input type="button" value="{$disp}" onclick="javascript:reply({$a->message_id}, '$type')"/>
<br/>
<textarea cols="40" rows="5" readonly border="0" style="border-style:none;">$a->message_content</textarea>
eot;
        if($a->to_id == $team_id){
            $a->read = 1;
            $a->update();
        }
    }
}
include("../../include/footer.php");
?>
