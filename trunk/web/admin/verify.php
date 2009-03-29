<?php
session_start();
ob_start();
header("Content-Type: text/html;charset=utf-8");
$relpath = dirname(__FILE__);
include($relpath."/def.php");
include_once(APP_ROOT."include/config.php");

    if($_SESSION['admin'] != true){
        //header("location: index.php");
        include(APP_ROOT."include/header.php");
        echo <<<eot
<script>
alert("请先登录后再进入管理!");
window.top.location = '$installDir/admin/index.php';
</script>
eot;
        include(APP_ROOT."include/footer.php");
        exit;
    }
?>
