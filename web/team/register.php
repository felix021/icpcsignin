<?php
include("inc.php");
?>
<script>
function $(id) {return document.getElementById(id);}
function verify(){
    //check for null input
    var submitbtn = $('submitbtn');
    submitbtn.click();
}
</script>
<form action="register.do.php" method="post">
选择队伍类型: 
<input type="radio" name="team_type" checked="checked" value="1"/>武汉大学队伍 
<input type="radio" name="team_type" value="2"/>其他高校队伍 
<select id="school_id" name="school_id">
    <option selected="selected" value="-1">请选择学校</option>
<?php
$query = "SELECT `school_id`, `school_name_cn` FROM {tblprefix}_schools WHERE `school_type` & 1 = 0 AND `school_type` & 4 <> 0 ";
$res = getQuery($conn, $query);
while($row = $res->fetch_assoc()){
    echo <<<eot
    <option value="{$row['school_id']}">{$row['school_name_cn']}</option>

eot;
}
?>
</select>
<input type="radio" name="team_type" value="3"/>高中队伍
<br/>
队名 <input type="text" name="team_name" /> (20字符以内) <br/>
密码 <input type="password" name="password" title="此密码为明文保存，请不要使用常用密码" />
(20字符以内；此密码为明文保存，请不要使用常用密码) <br/>
<fieldset>
<legend>联系方式</legend>
邮箱 <input type="text" name="email" title="务必正确填写此邮箱! 系统将向此邮箱发送验证码" value=""/> 务必正确填写此邮箱! 系统将向此邮箱发送验证码<br/>
电话 <input type="text" name="telephone" value=""/><br/>
地址 <input type="text" name="address" value=""/><br/>
邮编 <input type="text" name="postcode" value=""/><br/>
</fieldset>
<input type="checkbox" checked="checked" name="valid_for_final"/>若晋级决赛, 可以前往参加(如不确定可先勾选, 并在确定后及时反馈)<br/>
<input type="submit" id="submitbtn" style="display:none;" value="确定"/>
<input type="button" value="注册" onclick="verify()"/>
</form>
<?php
include("../include/footer.php");
?>
