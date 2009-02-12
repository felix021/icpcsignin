<?php
    session_start();
    $includeDir = dirname(dirname(__FILE__));
    include_once("$includeDir/include/functions.php");
    if(!isset($_SESSION['team_id'])){
        //msgbox("请先 [<a href=\"../index.php\" target=\"_top\">登陆</a>] 再进行操作!", false);
        ob_end_clean();
        include("../include/header.php");
        echo <<<eot
<script>
alert("请先登录后再进入管理!");
window.top.location = '../index.php';
</script>
eot;
        include("../include/footer.php");
    }
?>
