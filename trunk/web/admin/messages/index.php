<?php
$relpath = dirname(__FILE__);
include($relpath."/def.php");

include(APP_ROOT."admin/inc.php");
?>
<script>
function autofit(iframeobj){
    iframeobj.height = iframeobj.contentWindow.document.body.scrollHeight;
    iframeobj.scrolling = "none";
    iframeobj.style.scrolling = "none";
}
</script>
<iframe src="msg_recv.php" id="msg_recv" width="800" height="190" frameborder="0" scrolling="none" style="scrolling:none;" onload="javascript:autofit(this);"></iframe>
<hr/>
<table width="820">
<tr>
<td><iframe src="viewmessage.php" id="viewmsg" style="display:inline;" width="400" height="160" frameborder="0" scrolling="none" style="scrolling:none;" ></iframe></td>
<td><iframe src="sendmessage.php" id="sendmsg" style="display:inline;" width="400" height="160" frameborder="0" scrolling="none" style="scrolling:none;" ></iframe></td>
</tr>
</table>
<hr/>
<iframe src="msg_send.php" id="msg_send" width="800" height="190" frameborder="0" scrolling="none" style="scrolling:none;" onload="javascript: autofit(this);"></iframe>
<?php include(APP_ROOT."admin/footer.php");
