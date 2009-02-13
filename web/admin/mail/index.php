<?php
$relpath = dirname(__FILE__);
include($relpath."/def.php");

include(APP_ROOT."admin/inc.php");

?>
<form action="sendmail.php" method="post" style="text-align:left">
<p>
给队伍发送邮件(发送到队伍邮箱):
<select name="team_type">
<option value="verified" selected>已验证邮箱队伍</option>
<option value="final">晋级决赛队伍</option>
<option value="all">所有队伍</option>
</select>
(给单个队伍发送邮件请在队伍管理界面找到该队伍，选择发送邮件)
</p>
邮件标题: <input type="text" name="title" value=""/><br/>
<?php
$ubb = 'checked="checked"';
$display = "block";
include(APP_ROOT."editor/editor.php");
?>
</form>
<?php
include(APP_ROOT."admin/footer.php");
?>
