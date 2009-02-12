<?php
$relpath = dirname(__FILE__);
include($relpath."/def.php");

include(APP_ROOT."admin/inc.php");

$file = basename($_GET['file']);
if($file == "index.php") msgbox("不能删除 index.php");
$fullname = "../attachments/" . $file;

if(@unlink($fullname)){
    msgbox("删除 $file 成功!");
}else{
    msgbox("删除 $file 失败!");
}

?>
