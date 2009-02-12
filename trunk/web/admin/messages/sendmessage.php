<?php
$relpath = dirname(__FILE__);
include($relpath."/def.php");

include(APP_ROOT."admin/inc.php");
echo <<<eot
<form action="sendmessage.do.php" method="post" style="display:inline;">
<input type="hidden" name="rep_id" id="rep_id" value="" />
回复/追加消息:
<input type="submit" value="发送"/><br/>
<textarea name="message_content" id="msg" cols="40" rows="5"></textarea>
</form>
eot;
include(APP_ROOT."admin/footer.php");
?>
