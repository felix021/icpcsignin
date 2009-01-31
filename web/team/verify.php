<?php
    session_start();
    $includeDir = dirname(dirname(__FILE__));
    include_once("$includeDir/include/functions.php");
    if(!isset($_SESSION['team_id'])){
        msgbox("请先 [<a href=\"../index.php\" target=\"_top\">登陆</a>] 再进行操作!", false);
    }
?>
