<?php
include("inc.php");
$id = (int)$_SESSION['team_id'];

$ref = basename($_SERVER['HTTP_REFERER']);
if($ref == "index.php" || $ref == "unsetteam.php"){
    if (team::delById($id)){
        unset($_SESSION['team_id']);
        $msg = <<<eot
<p>队伍数据已经删除!</p>
<p><a href="../index.php" target="_top">返回首页</a></p>
eot;
        msgbox($msg, false);
    }else{
        msgbox("删除队伍失败");
    }
}else{
    msgbox("入口错误! 请从队伍管理界面点击删除队伍");
}
?>
