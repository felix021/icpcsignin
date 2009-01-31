<?php
include("../inc.php");
include("../verifiedmail.php");
echo <<<eot
<form action="sendmessage.do.php" method="post" style="display:inline;">
向管理员发送信息(1000字以内):<br/>
<input type="hidden" id="to_id" name="to_id" value="-1"/>
<textarea name="message_content" id="msg" cols="40" rows="5"></textarea>
<br/>
<input type="submit" value="发送"/>
</form>
eot;
include("../../include/footer.php");
?>
