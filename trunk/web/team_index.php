<?php
include("def.php");
include_once(APP_ROOT."include/classes.php");
if(!isset($_SESSION['team_id'])) exit();

$a = new team($_SESSION['team_id']);

encodeObject($a);

echo <<<eot
<div class="textbox">
<div class="textbox-title" style="text-align:center;">队伍基本信息</div>
<div class="textbox-content">
队伍编号: {$a->team_id}<br/>
队名: {$a->team_name}<br/>

eot;

if(!empty($a->vcode)){
    echo <<<eot
<form action="team/vcodeverify.php" method="get">
请输入<span style="text-decoration:underline;color:blue;" title="请打开注册邮箱查看">邮箱验证码</span>:
<input type="text" size="10" name="vcode"/>
<input type="submit" value="验证邮箱"/>
</form>

eot;
}

echo <<<eot
<a href="team/index.php">进入队伍管理界面</a><br/>
<a href="team_logout.php">注销登陆</a>
</div>
</div>

eot;

?>
