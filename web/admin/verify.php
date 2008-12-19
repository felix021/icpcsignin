<?php
    session_start();
    ob_start();
    if($_SESSION['admin'] != true){
        header("location: index.php");
        exit;
    }
?>
