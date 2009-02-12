<?php
$relpath = dirname(__FILE__);
include($relpath."/def.php");

include(APP_ROOT."admin/inc.php");

if(article::delById((int)$_GET['article_id'])){
    msgbox("删除成功!");
}else{
    msgbox("删除失败!");
}
?>
