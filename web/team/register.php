<?php
$relpath = dirname(__FILE__);
include($relpath."/def.php");

include_once(APP_ROOT."include/header.php");
include_once(APP_ROOT."include/classes.php");
?>
<script>
function $(id) {return document.getElementById(id);}
function verify(){
    //check for null input
    var submitbtn = $('submitbtn');
    submitbtn.click();
}
function select_other_high(){
    try{
        var other_high = $('other_high');
        if(other_high) other_high.checked = true;
    }catch(e){alert(e);}
}
</script>
<form action="team/register.do.php" method="post">
<div class="textbox" style="margin-top:8px;">
<div class="textbox-title">队伍注册</div>
<div class="textbox-content">
<table class="tblleft" border="0" style="text-align:left;">
<tr>
    <td colspan="2">
        选择队伍类型: 
        <input type="radio" name="team_type" checked="checked" value="1"/>武汉大学队伍 
        <input type="radio" name="team_type" id="other_high" value="2"/>其他高校队伍 
<?php
echo select_school(-1, 2);
?>
        <input type="radio" name="team_type" value="3"/>高中队伍
    </td>
</tr>
<tr>
    <td>队名</td>
    <td><input type="text" name="team_name" /> (50字符以内)</td>
</tr>
<tr>
    <td>密码</td>
    <td><input type="password" name="password"/> (20字符以内；此密码为明文保存，请不要使用常用密码)</td>
</tr>
<tr>
    <td>邮箱</td>
    <td><input type="text" name="email" value=""/> 务必正确填写此邮箱! 系统将向此邮箱发送验证码<br/>
请尽量使用gmail, qq, 163, sina邮箱(若未在收件箱，请查看垃圾邮件)。yahoo邮箱无法收到验证邮件。
    </td>
</tr>
<tr>
    <td>电话</td>
    <td><input type="text" name="telephone" value=""/></td>
</tr>
<tr>
    <td>地址</td>
    <td><input type="text" name="address" value=""/></td>
</tr>
<tr>
    <td>邮编</td>
    <td><input type="text" name="postcode" value=""/></td>
</tr>
<tr>
    <td><input type="button" value="注册" onclick="verify()"/></td>
    <td><input type="checkbox" checked="checked" name="valid_for_final"/>若晋级决赛, 可以前往参加(如不确定可先勾选, 并在确定后及时反馈)</td>
</tr>
</table>
<input type="submit" id="submitbtn" style="display:none;" value="确定"/>
</div>
</div>
</form>
<?php
include(APP_ROOT."include/footer.php");
?>
