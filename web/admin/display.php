<?php
include("inc.php");
$notice = file_get_contents("../include/notice.txt");
$notice_e = htmlspecialchars($notice);
echo <<<eot
<fieldset>
<legend>修改公告</legend>
<fieldset>
<legend>公告内容</legend>
$notice
</fieldset>
<hr/>
<form action="updatenotice.php" method="post">
<textarea name="notice" cols="80" rows="5">$notice_e</textarea><br/>
<input type="submit" value="修改"/>
</form>
</fieldset>
eot;
include("footer.php");
?>
