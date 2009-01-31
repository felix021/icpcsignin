<?php
include_once("verify.php");
include_once("inc.php");
?>
<style type="text/css">
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
    <li><a href="../" target="_top">返回主页</a></li>
    <li><a href="display.php" target="display">管理首页</a></li>
    <li><a href="members/members.php" target="display">成员管理</a></li>
    <li><a href="messages/messages.php" target="display">信息管理</a></li>
    <li>....</li>
    <li><a href="../team_logout.php" target="_top">退出登陆</a></li>
</ul>
<?php include("../include/footer.php"); ?>
