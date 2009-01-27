<?php
include("include/header.php");
include("include/config.php");
echo <<<eot
<div>
ooxx1<br/>
ooxx2<br/>
ooxx2<br/>
ooxx2<br/>
</div>
eot;

if(isset($_SESSION['team_id'])){
    include("team_index.php");
}else{
    echo <<<eot
<div>
<form action="login.do.php" method="post">
队名<input type="text" name="team_name"/><br/>
密码<input type="password" name="password" /> <br/>
<input type="submit" value="登陆"/>
<a href="team/register.php">注册新队伍!</a>
</form>
</div>
<div><a href="admin/">管理入口</a></div>
eot;
}

include("include/footer.php");
?>
