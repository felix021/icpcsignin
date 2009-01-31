<?php

include("../inc.php");
include("../verify.php");

if (get_magic_quotes_gpc()){
    foreach($_POST as &$v) 
        $v = stripslashes($v);
}

$team_id = $_SESSION['team_id'];
$reply_id = $_POST['to_id'];

if($reply_id > 0){
    $t = new message($reply_id);
    if($t->errno){
        msgbox_t($t->error);
    }
    if($t->to_id != $team_id){
        msgbox_t("该消息不是发送给队伍$team_id, 不能回复");
    }
    $t->replied = 1;
    if($t->update() == false){
        msgbox_t("该消息不是发送给队伍$team_id, 不能回复");
    }
}

$a = new message;
if($a->teamsend($team_id, $_POST['message_content'])){
    msgbox_t("消息发送成功!", $reply_id);
}else{
    msgbox_t("消息发送失败: " . $a->error);
}

function msgbox_t($msg, $reply_id = -1){
    @ob_clean();
    @ob_clean();
    $msg = htmlspecialchars($msg);
    $morescript = "";
    if($reply_id > 0){
        $morescript = <<<eot
var t1 = parent.document.getElementById('msg_recv');
var rep = t1.contentWindow.document.getElementById($reply_id+'_replied');
rep.checked = true;
eot;
    }
    echo <<<eot
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<meta http-equiv="refresh" content="3; url=sendmessage.php"/>
</head>
<body style="margin-top:30px;text-align:center;">
<center>
{$msg}
<p>3s后自动返回... [<a href="sendmessage.php">立即返回</a>]</p>
<script>
try{
var t = parent.document.getElementById('msg_send');
t.src = t.src + '?' + Math.random();

$morescript

}catch(e){alert(e);}
</script>
</center>
</body>
</html>
eot;
    exit();
}

?>
