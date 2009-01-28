<?php

include("../inc.php");

if(get_magic_quotes_gpc()){
    foreach($_POST as &$v)
        $v = stripslashes($v);
}
extract($_POST, EXTR_OVERWRITE);

$a = new article;

$a->pub_time = time();
$a->title = $title;
$a->content = $content;
$a->content_type = (int)$content_type;
$a->priority = $priority;
$a->permission = $permission;
$a->views = 0;

if($a->insert()){
    msgbox("发布成功!");
}else{
    msgbox($a->error);
}

?>
