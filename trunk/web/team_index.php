<?php
$relpath = dirname(__FILE__);
include($relpath."/def.php");

include_once(APP_ROOT."include/classes.php");
if(!isset($_SESSION['team_id'])) exit();

$a = new team($_SESSION['team_id']);
if($a->errno) msgbox($a->error);

if(!empty($a->vcode)){
    $verifyinfo = <<<eot
<span style="color:red;">(邮箱未验证!)</span>
eot;
}

encodeObject($a);

echo <<<eot
<div class="textbox">
<div class="textbox-title" style="text-align:center;">队伍管理</div>
<div class="textbox-content">
<ul>
<li><a href="index.php?page=team_info">队伍信息</a>{$verifyinfo}</li>
<li><a href="index.php?page=team_member">成员管理</a></li>
<!-- <li><a href="index.php?page=team_message">消息管理</a></li> -->
<li><a href="index.php?page=team_hotel">住宿信息</a></li>
<li><a href="index.php?page=team_del">删除队伍</a></li>
<li><a href="team_logout.php">注销登陆</a></li>
</ul>
</div>
</div>

eot;

?>
