<?php session_start(); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>"百度杯"武汉大学第六届程序设计比赛</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body style="margin:20px;">
<center>
<img src="images/title.jpg" alt="ACM/ICPC 官方首页" border="0"/>

<div id="bar">
<table width="800" align="center">
<tr>
    <td align="center" style="font-size:16px;font-weight:bold;">
        <a href="<?php echo $_SERVER['PHP_SELF'];?>?page=summary">排名页面</a>
    </td>
    <td align="center" style="font-size:16px;font-weight:bold;">
        <a href="<?php echo $_SERVER['PHP_SELF'];?>?page=code">代码打印</a>
    </td>
</tr>
</table>
</div>

<!-- 网页内容 -->
<?php
if($_GET['page']=="code")
{
    include("code.php");
} else {
    include("summary.php");
}
?>

<div id="ft">
  <hr width="979" size="0" style="margin-top:20px;"/>
  <img src="images/whu.gif" alt="武汉大学" width="181" height="50"/><br/>
  Copyright &copy; 2009 ACM/ICPC Association of Wuhan University. All Rights Reserved.<br/>
</div>
</center>
</body>
</html>
