<?php 
    ob_start(); 
    session_start(); 
    include_once(dirname(__FILE__) . "/config.php");
    $contestname_enc = htmlspecialchars($contestname);
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo $contestname_enc; ?> - 赛事主页</title>
    <link rel="stylesheet" type="text/css" href="<?php echo $installDir;?>/include/style.css"/>
</head>
<body>
<center>

