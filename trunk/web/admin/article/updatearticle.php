<?php
$relpath = dirname(__FILE__);
include($relpath."/def.php");

include(APP_ROOT."admin/inc.php");

if(get_magic_quotes_gpc()){
    foreach($_POST as &$v)
        $v = stripslashes($v);
}
extract($_POST, EXTR_SKIP);

$a = new article($_GET['article_id']);
if($a->errno){
    msgbox($a->error);
}

$a->title = $title;
$a->pub_time = str2time($pub_time);
$a->priority = $priority;
if($permission == 1) $a->permission = 1;
else $a->permission = 0;
if($_GET['action'] == "all"){
    $a->content = $content;
    $a->content_type = $content_type;
}

if($a->update()){
    $msg = <<<eot
<p>更新成功!</p>
<p><a href="index.php">返回文章管理</a></p>
eot;
    msgbox($msg, false);
}else{
    msgbox($a->error);
}

?>
