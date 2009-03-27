<?php

die("Access Denied.");

//By Felix021
session_start();
$password = "123456";

if($_POST['password'] == $password) $_SESSION['logged']=true;

if($_GET['act']=="logout")
{
  session_destroy();
  header("location:".$_SERVER['PHP_SELF']);
  exit(0);
}
if(!$_SESSION['logged'])
{
  echo <<<eot
<form method="post" action="{$_SERVER['PHP_SELF']}">
<input type="password" name="password"/><input type="submit" value="OK"/>
</form>
eot;
  exit;
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>打印后台管理</title>
</head>
<body style="font-family:courier new;font-size:14px">
<?php
$list = scandir(".");
natcasesort($list);
foreach($list as $file)
{
  if(substr($file,-4)!=".txt")continue;
  echo <<<eot
<a href="$file">$file</a><br/>

eot;
}
?>
</body>
</html>
