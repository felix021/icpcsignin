<?php
$relpath = dirname(__FILE__);
include($relpath."/def.php");

include(APP_ROOT."admin/inc.php");

$t = new team((int)$_GET['team_id']);
if($t->errno){
    msgbox($t->error);
}

encodeObject($t);
echo <<<eot
<form action="sendmail.do.php" method="post" style="text-align:left">
<p> 给队伍 {$t->team_name}($t->email} 发送邮件: </p>
<input type="hidden" name="team_id" value="{$t->team_id}"/>
邮件标题: <input type="text" name="title" value=""/><br/>

eot;
$ubb = 'checked="checked"';
$display = "block";
include(APP_ROOT."editor/editor.php");
echo "</form>\n";

include(APP_ROOT."admin/footer.php");
?>
