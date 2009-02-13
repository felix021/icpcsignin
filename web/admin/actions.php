<?php
$relpath = dirname(__FILE__);
include($relpath."/def.php");
include(APP_ROOT."admin/verify.php");
include(APP_ROOT."admin/header.php");
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
    <li><a href="article/index.php" target="display">通知管理</a></li>
    <li><a href="messages/index.php" target="display">信息管理</a></li>
    <li><a href="mail/index.php" target="display">发送邮件</a></li>
    <li>....</li>
    <li><a href="sqlquery/" target="display">自定义查询</a></li>
    <li><a href="files.php" target="display">文件管理</a></li>
    <li><a href="index.php" target="_top">退出登陆</a></li>
</ul>
<?php include(APP_ROOT."admin/footer.php"); ?>
