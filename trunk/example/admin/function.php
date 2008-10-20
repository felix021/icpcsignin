<?php
    //转向错误页面，输出错误信息
    function adminerror($msg){
        ob_clean();
        header("location:../msg.php?msg=".urlencode($msg));
        exit;
    }
?>
