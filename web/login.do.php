<?php
$relpath = dirname(__FILE__);
include($relpath."/def.php");

include(APP_ROOT."include/header.php");
include(APP_ROOT."include/classes.php");
if(get_magic_quotes_gpc()){
    foreach($_POST as &$value){
        $value = stripslashes($value);
    }
}
extract($_POST, EXTR_SKIP);
$team_name = $conn->real_escape_string($team_name);
$password = $conn->real_escape_string($password);
$query = "SELECT `team_id` FROM `{tblprefix}_teams` "
        ." WHERE `team_name`='$team_name' AND `password`='$password'";
$res = getQuery($conn, $query);
if($conn->affected_rows == 1){
    $row = $res->fetch_assoc();
    $_SESSION['team_id'] = $row['team_id'];
    header('location: index.php');
}else{
    session_destroy();
    msgbox("队名或密码错误!");
}
?>
