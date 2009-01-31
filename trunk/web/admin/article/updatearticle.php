<?php

include("../inc.php");

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
    msgbox("更新成功!");
}else{
    msgbix($a->error);
}

?>
