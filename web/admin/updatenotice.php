<?php
include("inc.php");

$notice = $_POST['notice'];
if(get_magic_quotes_gpc()){
    $notice = stripslashes($notice);
}

if(@file_put_contents("../include/notice.txt", $notice)){
    msgbox("更新成功!");
}else{
    msgbox("更新失败!");
}
?>
