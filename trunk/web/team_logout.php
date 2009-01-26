<?php
ob_start();
session_start();
unset($_SESSION['team_id']);
header("location: index.php");
?>
