<?php
$relpath = dirname(__FILE__);
include($relpath."/def.php");

include_once(APP_ROOT."include/classes.php");
if(!isset($_SESSION['team_id'])) exit();

$a = new team($_SESSION['team_id']);
if($a->errno) msgbox($a->error);
$sch = school::getNameByTeamId($a->team_id);

encodeObject($a);

echo <<<eot
<style>
#ctrlpanel{
    margin: 0px;
    margin-left:20px;
    padding: 0px;
    list-style: square;
}
#ctrlpanel li{
    margin:2px;
}
</style>
<div class="textbox">
<div class="textbox-title" style="text-align:center;">队伍管理</div>
<div class="textbox-content">
欢迎，{$sch} {$a->team_name} 队。
<hr/>
<ul id="ctrlpanel">
<li><a href="index.php?page=team_info">队伍信息</a></li>
<li><a href="index.php?page=team_member">成员管理</a></li>
<li><a href="index.php?page=contest_info">比赛成绩</a></li>
<!-- <li><a href="index.php?page=team_message">消息管理</a></li> -->
<li><a href="index.php?page=hotel">住宿管理</a></li>
<li><a href="index.php?page=team_del">删除队伍</a></li>
<li><a href="team_logout.php">注销登陆</a></li>
</ul>

eot;

if(!empty($a->vcode)){
    echo <<<eot
<hr/>
<span style="color:red;">邮箱未验证,<a href="index.php?page=team_info">现在验证</a></span>

eot;
}

$query = "SELECT COUNT(*) as num FROM `{tblprefix}_members` b"
        ."  WHERE `team_id` = {$a->team_id} and `type`>0";
$res = getQuery($conn, $query);
$row = $res->fetch_assoc();
if($row['num'] == 0){
    echo <<<eot
<hr/>
<span style="color:red;">尚未添加成员,<a href="index.php?page=team_member">现在添加</a></span>

eot;
        
}

?>
</div>
</div>
