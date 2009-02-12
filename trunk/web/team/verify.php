<?php
    session_start();
    $relpath = dirname(__FILE__);
    include($relpath."/def.php");

    include_once(APP_ROOT."include/functions.php");
    if(!isset($_SESSION['team_id'])){
        //msgbox("请先 [<a href=\"../index.php\" target=\"_top\">登陆</a>] 再进行操作!", false);
        ob_end_clean();
        include(APP_ROOT."include/header.php");
        echo <<<eot
<script>
alert("请先登录后再进入管理!");
window.top.location = '../index.php';
</script>
eot;
        include(APP_ROOT."include/footer.php");
    }
?>
