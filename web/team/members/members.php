<?php
include_once("def.php");

include_once(APP_ROOT."team/inc.php");
include_once(APP_ROOT."team/verifiedmail.php");

$team_id = (int)$_SESSION['team_id'];

$query = "SELECT * FROM `{tblprefix}_members` WHERE `team_id`={$team_id}";
$res = getQuery($conn, $query);

$member_c = 0;
while($row = $res->fetch_assoc()){
    if($row['type'] == 0) {
        $members['coach'] = new member($row['member_id']);
    } elseif($row['type'] == 1) {
        $member_c++;
        $members['member'][] = new member($row['member_id']);
    } elseif($row['type'] == 2) {
        $members['master'] = new member($row['member_id']);
    }
}

echo <<<eot
<style>
input.text{
    width: 160px;
    display:inline;
}
select{
    width:160px;
}
</style>

<script>
function delmember(id, name){
    if(confirm("确认要删除队员 ["+name+"] ?")){
        var submitbtn = document.getElementById("delsubmit");
        if(submitbtn) submitbtn.click();
        //window.location = "index.php?page=delmember&member_id=" + id;
    }
}
</script>
<table>
<tr>
<td>

eot;

echo <<<eot
<div class="textbox">
<div class="textbox-title">教练信息(非必需)</div>
<div class="textbox-content">

eot;
if(!isset($members['coach'])){
    $school_list = select_school($a->school_id);
    echo <<<eot
<form action="team/members/addmember.php?type=0" method="post">
<table class="membertbl" border="0">
<tr>
    <td class="tdl">姓名</td>
    <td class="tdr"><input type="text" class="text" name="member_name" value="" /></td>
</tr>
<tr>
    <td class="tdl">拼音</td>
    <td class="tdr"><input type="text" class="text" name="member_name_pinyin" value="" /></td>
</tr>
<tr>
    <td class="tdl">性别</td>
    <td class="tdr"><select name="gender"><option selected="selected" value="1">男</option><option value="0">女</option></select></td>
</tr>
<tr>
    <td class="tdl">邮箱</td>
    <td class="tdr"><input type="text" class="text" name="email" value="" /></td>
</tr>
<tr>
    <td class="tdl">学校</td>
    <td class="tdr">$school_list  若无贵校请联系管理员</td>
</tr>
<tr>
    <td class="tdl">院系</td>
    <td class="tdr"><input type="text" class="text" name="faculty_major" value="" />(高中队伍可不填)</td>
</tr>
<tr>
    <td class="tdl">备注</td>
    <td class="tdr"><textarea name="remark" style="width:300px;height:100px;"/></textarea></td>
</tr>
<tr>
    <td class="tdl"></td><td class="tdr"><input type="submit" value="添加"/></td>
</tr>
</table>
</form>
eot;
}else{
    $member = $members['coach'];
    $school_list = select_school($member->school_id);
    $gender_GG = $member->gender == 1 ? 'selected="selected"' : "";
    $gender_MM = $member->gender == 0 ? 'selected="selected"' : "";
    encodeObject($member);
    echo <<<eot
<form action="team/members/updatemember.php?type=0" method="post">
<input type="hidden" name="member_id" value="{$member->member_id}"/>
<table class="membertbl">
<tr>
    <td class="tdl">姓名</td>
    <td class="tdr"><input type="text" class="text" name="member_name" value="{$member->member_name}" /></td>
</tr>
<tr>
    <td class="tdl">拼音</td>
    <td class="tdr"><input type="text" class="text" name="member_name_pinyin" value="{$member->member_name_pinyin}" /></td>
</tr>
<tr>
    <td class="tdl">性别</td>
    <td class="tdr"><select name="gender"><option $gender_GG value="1">男</option><option $gender_MM value="0">女</option></select></td>
</tr>
<tr>
    <td class="tdl">邮箱</td>
    <td class="tdr"><input type="text" class="text" name="email" value="{$member->email}" /></td>
</tr>
<tr>
    <td class="tdl">学校</td>
    <td class="tdr">$school_list 若无贵校请联系管理员</td>
</tr>
<tr>
    <td class="tdl">院系</td>
    <td class="tdr"><input type="text" class="text" name="faculty_major" value="{$member->faculty_major}" />(高中队伍可不填)</td>
</tr>
<tr>
    <td class="tdl">备注</td>
    <td class="tdr"><textarea name="remark" style="width:300px;height:100px;">{$member->remark}</textarea></td>
</tr>
<tr>
    <td class="tdl"></td>
    <td class="tdr"><input type="submit" value="修改"/></td>
</tr> 
</table>
</form>

eot;
}
echo <<<eot
</div>
</div>
</td>
<td>
<div class="textbox">
<div class="textbox-title">队长信息(必需)</div>
<div class="textbox-content">

eot;
if(!isset($members['master'])){
    $school_list = select_school($a->school_id);
    echo <<<eot
<form action="team/members/addmember.php?type=2" method="post">
<table class="membertbl">
<tr>
	<td class="tdl">学号</td>
	<td class="tdr"><input type="text" class="text" name="stu_number" value="" />(非本校队伍可不填)</td>
</tr>
<tr>
	<td class="tdl">姓名</td>
	<td class="tdr"><input type="text" class="text" name="member_name" value="" /></td>
</tr>
<tr>
	<td class="tdl">拼音</td>
	<td class="tdr"><input type="text" class="text" name="member_name_pinyin" value="" /></td>
</tr>
<tr>
	<td class="tdl">性别</td>
	<td class="tdr"><select name="gender"><option selected="selected" value="1">男</option> <option value="0">女</option></select></td>
</tr>
<tr>
	<td class="tdl">学校</td>
	<td class="tdr">$school_list  若无贵校请联系管理员</td>
</tr>
<tr>
	<td class="tdl">院系专业</td>
	<td class="tdr"><input type="text" class="text" name="faculty_major" value="" />(高中队伍可不填)</td>
</tr>
<tr>
	<td class="tdl">年级班级</td>
	<td class="tdr"><input type="text" class="text" name="grade_class" value="" /></td>
</tr>
<tr>
	<td class="tdl">邮箱</td>
	<td class="tdr"><input type="text" class="text" name="email" value="" /> </td>
</tr>
<tr>
	<td class="tdl">电话</td>
	<td class="tdr"><input type="text" class="text" name="telephone" value="" /> </td>
</tr>
<tr>
	<td class="tdl">备注</td>
	<td class="tdr"><textarea name="remark" style="width:300px;height:100px;"></textarea></td>
</tr>
<tr>
    <td class="tdl"></td>
    <td class="tdr"><input type="submit" value="添加"/></td>
</tr>
</table>
</form>
eot;
}else{
    $member = $members['master'];
    $school_list = select_school($member->school_id);
    $gender_GG = $member->gender == 1 ? 'selected="selected"' : "";
    $gender_MM = $member->gender == 0 ? 'selected="selected"' : "";
    encodeObject($member);
    echo <<<eot
<form action="updatemember.php?type=2" method="post">
<input type="hidden" name="member_id" value="{$member->member_id}"/>
<table class="membertbl">
<tr>
	<td class="tdl">学号</td>
	<td class="tdr"><input type="text" class="text" name="stu_number" value="{$member->stu_number}" />(非本校队伍可不填)</td>
</tr>
<tr>
	<td class="tdl">姓名</td>
	<td class="tdr"><input type="text" class="text" name="member_name" value="{$member->member_name}" /></td>
</tr>
<tr>
	<td class="tdl">姓名拼音</td>
	<td class="tdr"><input type="text" class="text" name="member_name_pinyin" value="{$member->member_name_pinyin}" /></td>
</tr>
<tr>
	<td class="tdl">性别</td>
	<td class="tdr"><select name="gender"><option $gender_GG value="1">男</option><option $gender_MM value="0">女</option></select></td>
</tr>
<tr>
	<td class="tdl">学校</td>
	<td class="tdr">$school_list  若无贵校请联系管理员</td>
</tr>
<tr>
	<td class="tdl">院系专业</td>
	<td class="tdr"><input type="text" class="text" name="faculty_major" value="{$member->faculty_major}" />(高中队伍可不填)</td>
</tr>
<tr>
	<td class="tdl">年级班级</td>
	<td class="tdr"><input type="text" class="text" name="grade_class" value="{$member->grade_class}" /> </td>
</tr>
<tr>
	<td class="tdl">邮箱</td>
	<td class="tdr"><input type="text" class="text" name="email" value="{$member->email}" /> </td>
</tr>
<tr>
	<td class="tdl">电话</td>
	<td class="tdr"><input type="text" class="text" name="telephone" value="{$member->telephone}" /> </td>
</tr>
<tr>
	<td class="tdl">备注</td>
	<td class="tdr"><textarea name="remark" style="width:300px;height:100px;">{$member->remark}</textarea></td>
</tr>
<tr>
	<td class="tdl"></td>
	<td class="tdr"><input type="submit" value="修改"/></td>
</tr>
</table>
</form>
eot;
}

echo <<<eot
</div>
</div>
</td>
</tr>
<tr>
<td>

eot;
for($i = 0; $i < $member_c; $i++){
    if($i == 1 && $member_c == 2){
        echo "</td>\n<td>\n";
    }
    $member = $members['member'][$i];
    $school_list = select_school($member->school_id);
    $gender_GG = $member->gender == 1 ? 'selected="selected"' : "";
    $gender_MM = $member->gender == 0 ? 'selected="selected"' : "";
    encodeObject($member);
    $member_name_slash = str_replace("'", "\\'", $member->member_name);
    echo <<<eot
<div class="textbox">
    <div class="textbox-title">[队员] 
        {$member->member_name} 
        <form action="team/members/delmember.php" method="get">
        <input type="hidden" name="member_id" value="{$member->member_id}"/>
        <input type="submit" id="delsubmit" style="display:none;"/>
        [<a href="javascript:delmember({$member->member_id}, '{$member_name_slash}');">删除</a>]
        </form>
    </div>
    <div class="textbox-content">
        <form action="updatemember.php?type=1" method="post">
        <input type="hidden" name="member_id" value="{$member->member_id}"/>
        <table class="membertbl">
        <tr>
            <td class="tdl">学号</td>
            <td class="tdr"><input type="text" class="text" name="stu_number" value="{$member->stu_number}" />(非本校队伍可不填)</td>
        </tr>
        <tr>
            <td class="tdl">姓名</td>
            <td class="tdr"><input type="text" class="text" name="member_name" value="{$member->member_name}" /></td>
        </tr>
        <tr>
            <td class="tdl">姓名拼音</td>
            <td class="tdr"><input type="text" class="text" name="member_name_pinyin" value="{$member->member_name_pinyin}" /></td>
        </tr>
        <tr>
            <td class="tdl">性别</td>
            <td class="tdr"><select name="gender"><option $gender_GG value="1">男</option><option $gender_MM value="0">女</option></select></td>
        </tr>
        <tr>
            <td class="tdl">学校</td>
            <td class="tdr">$school_list  若无贵校请联系管理员</td>
        </tr>
        <tr>
            <td class="tdl">院系专业</td>
            <td class="tdr"><input type="text" class="text" name="faculty_major" value="{$member->faculty_major}" />(高中队伍可不填)</td>
        </tr>
        <tr>
            <td class="tdl">年级班级</td>
            <td class="tdr"><input type="text" class="text" name="grade_class" value="{$member->grade_class}" /> </td>
        </tr>
        <tr>
            <td class="tdl">邮箱</td>
            <td class="tdr"><input type="text" class="text" name="email" value="{$member->email}" /> </td>
        </tr>
        <tr>
            <td class="tdl">电话</td>
            <td class="tdr"><input type="text" class="text" name="telephone" value="{$member->telephone}" /> </td>
        </tr>
        <tr>
            <td class="tdl">备注</td>
            <td class="tdr"><textarea name="remark" style="width:300px;height:100px;">{$member->remark}</textarea></td>
        </tr>
        <tr>
            <td class="tdl"></td>
            <td class="tdr"><input type="submit" value="修改"/></td>
        </tr>
        </table>
        </form>
    </div>
</div>

eot;
}
$school_list = select_school($a->school_id);
for($i = 0; $i < 2 - $member_c; $i++){
    if($member_c == 1 || $i == 1 && $member_c == 0){
        echo "</td>\n<td>\n";
    }
    echo <<<eot
    <div class="textbox">
    <div class="textbox-title">新增队员</div>
    <div class="textbox-content">
        <form action="team/members/addmember.php?type=1" method="post">
        <table class="membertbl">
        <tr>
            <td class="tdl">学号</td>
            <td class="tdr"><input type="text" class="text" name="stu_number" value="" />(非本校队伍可不填)</td>
        </tr>
        <tr>
            <td class="tdl">姓名</td>
            <td class="tdr"><input type="text" class="text" name="member_name" value="" /></td>
        </tr>
        <tr>
            <td class="tdl">姓名拼音</td>
            <td class="tdr"><input type="text" class="text" name="member_name_pinyin" value="" /></td>
        </tr>
        <tr>
            <td class="tdl">性别</td>
            <td class="tdr"><select name="gender"><option selected="selected" value="1">男</option><option value="0">女</option></select></td>
        </tr>
        <tr>
            <td class="tdl">学校</td>
            <td class="tdr">$school_list  若无贵校请联系管理员</td>
        </tr>
        <tr>
            <td class="tdl">院系专业</td>
            <td class="tdr"><input type="text" class="text" name="faculty_major" value="" />(高中队伍可不填)</td>
        </tr>
        <tr>
            <td class="tdl">年级班级</td>
            <td class="tdr"><input type="text" class="text" name="grade_class" value="" /> </td>
        </tr>
        <tr>
            <td class="tdl">邮箱</td>
            <td class="tdr"><input type="text" class="text" name="email" value="" /> </td>
        </tr>
        <tr>
            <td class="tdl">电话</td>
            <td class="tdr"><input type="text" class="text" name="telephone" value="" /> </td>
        </tr>
        <tr>
            <td class="tdl">备注</td>
            <td class="tdr"><textarea name="remark" style="width:300px;height:100px;"></textarea></td>
        </tr>
        <tr>
            <td class="tdl"></td>
            <td class="tdr"><input type="submit" value="添加"/></td>
        </tr>
        </table>
        </form>
    </div>
    </div>

eot;
}
echo <<<eot
</td>
</tr>
</table>
eot;
?>
