<?php
$relpath = dirname(__FILE__);
include($relpath."/def.php");

    session_start();
    ob_start();
    if($_SESSION['admin'] != true){
        //header("location: index.php");
        include(APP_ROOT."include/header.php");
        echo <<<eot
<script>
alert("请先登录后再进入管理!");
window.top.location = 'index.php';
</script>
eot;
        include(APP_ROOT."include/footer.php");
        exit;
    }
?>
