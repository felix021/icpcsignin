<?php
$relpath = dirname(__FILE__);
include($relpath."/def.php");

include(APP_ROOT."admin/inc.php");

if (get_magic_quotes_gpc()){
    foreach($_POST as &$v){
        $v = stripslashes($v);
    }
}
extract($_POST, EXTR_SKIP);

$team_id = (int)$_POST['team_id'];
$t = new team($team_id);
if($t->errno){
    msgbox($t->error);
}

$m = new mailer;
$content = symbol2value($content, $team_id);
switch($content_type){
case 0: // plain
    $content = "<pre>" . htmlspecialchars($content) . "</pre>\n";
    break;
case 1: // html
    $content = fixurl($content);
    break;
case 2: // UBB
default:
    $content = ubb2html($content);
    $content = fixurl($content);
    break;
}
encodeObject($t);
echo "Send to {$t->team_name}({$t->email}): ";
if($m->email($t->team_name, $t->email, $title, $content)){
    msgbox("邮件发送成功!");
}else{
    msgbox("邮件发送失败: ".$m->ErrorInfo);
}
?>
