<?php
$relpath = dirname(__FILE__);
include($relpath."/def.php");

include(APP_ROOT."admin/inc.php");

if(get_magic_quotes_gpc()){
    foreach($_POST as &$v)
        $v = stripslashes($v);
}
extract($_POST, EXTR_SKIP);

$a = new article;

$a->pub_time = time();
$a->title = $title;
$a->content = $content;
$a->content_type = (int)$content_type;
$a->priority = $priority;
$a->permission = $permission;
$a->views = 0;

if($a->insert()){
    $msg = <<<eot
<p>发布成功!</p>
<p><a href="index.php">返回文章管理</a></p>
eot;
    msgbox($msg, false);
}else{
    msgbox($a->error);
}

?>
