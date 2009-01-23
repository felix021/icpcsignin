<?php
include_once("include/classes.php");
if(!isset($_SESSION['team_id'])) exit();

$a = new team($_SESSION['team_id']);

echo <<<eot
<fieldset>
<legend>Team Infomation</legend>
team_id: {$a->team_id}<br/>
team_name: {$a->team_name}<br/>
eot;

if(!empty($a->vcode)){
    echo <<<eot
<form action="team/vcodeverify.php" method="get">
请输入<span style="text-decoration:underline;color:blue;" title="请打开注册邮箱查看">邮箱验证码</span>({$a->vcode}):
<input type="text" size="10" name="vcode"/>
<input type="submit" value="验证邮箱"/>
</form>
eot;
}

echo <<<eot
<a href="team/index.php">进入队伍管理界面</a><br/>
<a href="team_logout.php">注销登陆</a>
</fieldset>
eot;

?>
