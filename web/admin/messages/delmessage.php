<?php

include("../inc.php");
ob_clean();

$msg_id = (int)$_GET['msg_id'];

if(message::delById($msg_id)){
    echo 0;
}else{
    echo 1;
}

?>
