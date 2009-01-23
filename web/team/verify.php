<?php
    session_start();
    if(!isset($_SESSION['team_id'])){
        header("location: ../team_logout.php");
        exit();
    }
?>
