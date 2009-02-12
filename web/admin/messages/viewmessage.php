<?php
$relpath = dirname(__FILE__);
include($relpath."/def.php");

include(APP_ROOT."admin/inc.php");
if(!isset($_GET['msg_id'])){
    echo <<<eot
<p>查看消息内容</p>
<p>请点击上面的"查看"按钮查看消息.</p>
eot;
}else{
    $msg_id = (int)$_GET['msg_id'];
    $a = new message($msg_id);
    encodeObject($a);
    $type = $a->to_id == -1 ? "reply" : "cont";
    $disp = $a->to_id == -1 ? "回复" : "追加";
    echo <<<eot
<script src="msgfunc.js"></script>
阅读消息内容 
<input type="button" value="{$disp}" onclick="javascript:reply({$a->message_id}, '$type')"/>
<br/>
<textarea cols="40" rows="5" readonly border="0" style="border-style:none;">$a->message_content</textarea>
eot;
    if($a->to_id == -1){
        $a->read = 1;
        $a->update();
    }
}
include(APP_ROOT."admin/footer.php");
?>
