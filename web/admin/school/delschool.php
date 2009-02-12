<?php
$relpath = dirname(__FILE__);
include($relpath."/def.php");

include(APP_ROOT."admin/inc.php");
$id = (int)$_GET['school_id'];

if(school::delById($id)){
    msgbox("删除成功!");
}else{
    //echo ->error;
    msgbox("删除失败!");
}
echo '<a href="school.php">返回</a>';

include(APP_ROOT."admin/footer.php");
?>
