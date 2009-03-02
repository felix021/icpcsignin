<?php
include("def.php");

include_once(APP_ROOT."team/verify.php");
include_once(APP_ROOT."team/inc.php");

$a = new team($_SESSION['team_id']);

$now = time();
$signin_end = str2time($signinend);
$end_time = time2str($signin_end, "Y年m月d日 H时i分");
if($now > $signin_end){
    echo <<<eot
<div class="textbox">
<div class="textbox-title">友情提示</div>
<div class="textbox-content">
报名已经结束于{$end_time}，如需修改队伍信息请联系管理员。
</div>
</div>

eot;
}


encodeObject($a);

if(!empty($a->vcode)){
    echo <<<eot
<div class="textbox" style="margin-top:8px;">
<div class="textbox-title">验证邮箱(请查收邮件，可能在垃圾邮件中)</div>
<div class="textbox-content">
<form action="team/vcodeverify.php" method="get" style="display:inline">
请输入邮箱验证码:
<input type="text" size="10" name="vcode"/>
<input type="submit" value="验证邮箱"/> <br/>
如未收到，请<a href="#email">修改</a>为gmail/qq/163/sina等邮箱。请不要使用yahoo邮箱。
</form>
</div>
</div>
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
<div class="textbox" style="margin-top:8px;">
    <div class="textbox-title">队伍信息 [<a href="#password" style="color:#f00;text-decoration:underline;">修改密码</a>]</div>
    <div class="textbox-content">
        <form action="team/updateteam.php?action=basicinfo" method="post" style="display:inline;">
        <table border="0" class="tblleft">
        <tr><td class="listname" style="width:50px;">编号</td><td>{$a->team_id}</td></tr>
        <tr><td>队名</td><td>{$a->team_name}</td></tr>
        <tr><td>邮箱</td><td>{$a->email} (<a href="#email">修改</a>)</td></tr>
        <tr>
            <td>学校</td>
            <td>
                <input type="radio" $school_whu name="team_type" checked="checked" value="1"/>武汉大学队伍 
                <input type="radio" $school_o name="team_type" value="2"/>其他高校队伍
        $school_list
                <input type="radio" $school_high name="team_type" value="3"/>高中队伍
                (若列表中无贵校请联系管理员)
            </td>
        </tr>
        <tr>
            <td>电话</td>
            <td><input type="text" name="telephone" value="{$a->telephone}"/></td>
        </tr>
        <tr>
            <td>地址</td>
            <td><input type="text" name="address" value="{$a->address}"/></td>
        </tr>
        <tr>
            <td>邮编</td>
            <td><input type="text" name="postcode" value="{$a->postcode}"/></td>
        </tr>
        <tr>
            <td><input type="submit" value="更新"/></td>
            <td><input type="checkbox" name="valid_for_final" $for_final value="1"/>若晋级能前往参加决赛</td>
        </tr>
        <tr>
            <td>备注</td>
            <td><textarea name="remark" style="width:400px;height:100px;">{$a->remark}</textarea></td>
        </tr>
        </table>
        </form>
    </div>
</div>

<a name="password"></a>
<div class="textbox">
    <div class="textbox-title">修改密码</div>
    <div class="textbox-content">
        <form action="team/updateteam.php?action=password" method="post" style="display:inline;">
        <table class="tblleft">
        <tr><td>原密码</td><td><input type="password" name="old_pass"/></td></tr>
        <tr><td>新密码</td><td><input type="password" name="new_pass"/></td></tr>
        <tr><td>确认新密码</td><td><input type="password" name="new_pass_confirm" /></td><tr>
        </table>
        <input type="submit" value="修改"/>
    </form>
    </div>
</div>

<a name="email"></a>
<div class="textbox">
    <div class="textbox-title">修改邮箱 (请尽量使用gmail/qq/163/sina邮箱, yahoo邮箱无法收到；此邮件可能会出现在垃圾邮件中。)</div>
    <div class="textbox-content">
        <form action="team/updateteam.php?action=email" method="post" style="display:inline;">
        新邮箱: <input type="text" name="email" />
        <input type="submit" value="修改"/>
        <span style="color:red;">修改邮箱需要重新验证！</span>
        </form>
    </div>
</div>
eot;

include_once(APP_ROOT."include/footer.php");
?>
