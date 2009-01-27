<?php
include("verify.php");
include("header.php");
?>
<style>
li{
    list-style:none;
    width:100px;
    border:1px solid #00a7dd;
    background-color: #fff;
    color: #000;   
    padding: 2px;
}
</style>
<ul style="margin-top:60px;">
    <li><a href="display.php" target="display">管理首页</a></li>
    <li><a href="school/school.php" target="display">学校管理</a></li>
    <li><a href="team/index.php" target="display">队伍管理</a></li>
    <li>....</li>
    <li><a href="index.php" target="_top">退出登陆</a></li>
</ul>
<?php include("footer.php"); ?>
