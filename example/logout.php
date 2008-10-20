<?php
    session_start();
    //销毁登录信息
    session_destroy();
    //转向登录页面
    header("location: index.php");
?>
