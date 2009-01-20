<?php
include("verify.php");
include("header.php");
$includedir = dirname(dirname(__FILE__))."/include/";
include($includedir."classes.php");

function msgbox($msg){
    ob_clean();
    $_SESSION['msg'] = $msg;
    include(dirname(__FILE__)."/msgbox.php");
    exit();
}
?>
