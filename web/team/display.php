<?php
$relpath = dirname(__FILE__);
include($relpath."/def.php");

include_once(APP_ROOT."team/verify.php");
include_once(APP_ROOT."team/inc.php");

$a = new team($_SESSION['team_id']);

encodeObject($a);

if(!empty($a->vcode)){
    echo <<<eot
<form action="vcodeverify.php" method="get">
<fieldset>
<legend>验证邮箱</legend>
请输入<span style="text-decoration:underline;color:blue;" title="请打开注册邮箱查看">邮箱验证码</span>({$a->vcode}):
<input type="text" size="10" name="vcode"/>
<input type="submit" value="验证邮箱"/>
</fieldset>
</form>
eot;
}

$school_id = $a->school_id;
if($school_id == 1)
    $school_whu = "checked=\"checked\"";
else if($school_id < 0)
    $school_high = "checked=\"checked\"";
else
    $school_o = "checked=\"checked\"";

$school_list = select_school($school_id, 2);
$for_final = $a->valid_for_final == 1 ? "checked=\"checked\"" : "";

echo <<<eot
<form action="updateteam.php?action=basicinfo" method="post">
<fieldset style="margin:10px;">
<legend>队伍基本信息</legend>
编号: {$a->team_id}<br/>
队名: {$a->team_name}<br/>
邮箱: {$a->email}<br/>
学校: 
<input type="radio" $school_whu name="team_type" checked="checked" value="1"/>武汉大学队伍 
<input type="radio" $school_o name="team_type" value="2"/>其他高校队伍
$school_list
<input type="radio" $school_high name="team_type" value="3"/>高中队伍<br/>
电话: <input type="text" name="telephone" value="{$a->telephone}"/><br/>
地址: <input type="text" name="address" value="{$a->address}"/><br/>
邮编: <input type="text" name="postcode" value="{$a->postcode}"/><br/>
<input type="checkbox" name="valid_for_final" $for_final value="1"/>若晋级能前往参加决赛<br/>
备注: <textarea name="remark" cols="50" rows="3">{$a->remark}</textarea><br/>
<input type="submit" value="更新"/>
</form>
</fieldset>

<form action="updateteam.php?action=password" method="post">
<fieldset>
<legend>修改密码</legend>
原密码: <input type="password" name="old_pass" /><br/>
新密码: <input type="password" name="new_pass" /><br/>
确认新密码: <input type="password" name="new_pass_confirm" /><br/>
<input type="submit" value="修改"/>
</fieldset>
</form>

<form action="updateteam.php?action=email" method="post">
<fieldset>
<legend>修改邮箱</legend>
新邮箱: <input type="text" name="email" />
<input type="submit" value="修改"/>
<span style="color:red;">修改邮箱需要重新验证！</span>
</fieldset>
</form>
eot;

include_once(APP_ROOT."include/footer.php");
?>
