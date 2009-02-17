<?php
$relpath = dirname(__FILE__);
include($relpath."/def.php");

include(APP_ROOT."team/inc.php");
include(APP_ROOT."team/verifiedmail.php");

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
<style type="text/css">
fieldset{margin:10px;}
</style>
eot;

echo "<fieldset>\n<legend>教练信息(非必需)</legend>\n";
if(!isset($members['coach'])){
    $school_list = select_school($a->school_id);
    echo <<<eot
<form action="addmember.php?type=0" method="post">
姓名: <input type="text" name="member_name" value="" /><br/>
姓名拼音: <input type="text" name="member_name_pinyin" value="" /><br/>
性别: <select name="gender">
<option selected="selected" value="1">GG</option>
<option value="0">MM</option>
</select>
学校: $school_list <br/>
院系(高中队伍可不填): <input type="text" name="faculty_major" value="" /> <br/>
邮箱: <input type="text" name="email" value="" /> <br/>
备注: <textarea name="remark" cols="40" rows="3"></textarea><br/>
<input type="submit" value="添加"/>
</form>
eot;
}else{
    $member = $members['coach'];
    $school_list = select_school($member->school_id);
    $gender_GG = $member->gender == 1 ? 'selected="selected"' : "";
    $gender_MM = $member->gender == 0 ? 'selected="selected"' : "";
    encodeObject($member);
    echo <<<eot
<form action="updatemember.php?type=0" method="post">
<input type="hidden" name="member_id" value="{$member->member_id}"/>
姓名: <input type="text" name="member_name" value="{$member->member_name}" /><br/>
姓名拼音: <input type="text" name="member_name_pinyin" value="{$member->member_name_pinyin}" /><br/>
性别: <select name="gender">
<option $gender_GG value="1">GG</option>
<option $gender_MM value="0">MM</option>
</select>
学校: $school_list <br/>
院系(高中队伍可不填): <input type="text" name="faculty_major" value="{$member->faculty_major}" /> <br/>
邮箱: <input type="text" name="email" value="{$member->email}" /> <br/>
备注: <textarea name="remark" cols="40" rows="3">{$member->remark}</textarea><br/>
<input type="submit" value="修改"/>
</form>
eot;
}
echo "</fieldset>\n";

echo "<fieldset>\n<legend>队长信息(必需)</legend>\n";
if(!isset($members['master'])){
    $school_list = select_school($a->school_id);
    echo <<<eot
<form action="addmember.php?type=2" method="post">
学号(非本校队伍可不填): <input type="text" name="stu_number" value="" /> <br/>
姓名: <input type="text" name="member_name" value="" /><br/>
姓名拼音: <input type="text" name="member_name_pinyin" value="" /><br/>
性别: <select name="gender">
<option selected="selected" value="1">GG</option>
<option value="0">MM</option>
</select>
学校: $school_list <br/>
院系及专业(高中队伍可不填): <input type="text" name="faculty_major" value="" /> <br/>
年级及班级: <input type="text" name="grade_class" value="" /> <br/>
邮箱: <input type="text" name="email" value="" /> <br/>
电话: <input type="text" name="telephone" value="" /> <br/>
备注: <textarea name="remark" cols="40" rows="3"></textarea><br/>
<input type="submit" value="添加"/>
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
学号(非本校队伍可不填): <input type="text" name="stu_number" value="{$member->stu_number}" /> <br/>
姓名: <input type="text" name="member_name" value="{$member->member_name}" /><br/>
姓名拼音: <input type="text" name="member_name_pinyin" value="{$member->member_name_pinyin}" /><br/>
性别: <select name="gender">
<option $gender_GG value="1">GG</option>
<option $gender_MM value="0">MM</option>
</select>
学校: $school_list <br/>
院系及专业(高中队伍可不填): <input type="text" name="faculty_major" value="{$member->faculty_major}" /> <br/>
年级及班级: <input type="text" name="grade_class" value="{$member->grade_class}" /> <br/>
邮箱: <input type="text" name="email" value="{$member->email}" /> <br/>
电话: <input type="text" name="telephone" value="{$member->telephone}" /> <br/>
备注: <textarea name="remark" cols="40" rows="3">{$member->remark}</textarea><br/>
<input type="submit" value="修改"/>
</form>
eot;
}
echo "</fieldset>\n";


echo <<<eot
<script>
function delmember(id, name){
    if(confirm("确认要删除队员 ["+name+"] ?")){
        window.location = "delmember.php?member_id=" + id;
    }
}
</script>
eot;
echo "<fieldset>\n<legend>队员信息(非必需)</legend>\n";
for($i = 0; $i < $member_c; $i++){
    $member = $members['member'][$i];
    $school_list = select_school($member->school_id);
    $gender_GG = $member->gender == 1 ? 'selected="selected"' : "";
    $gender_MM = $member->gender == 0 ? 'selected="selected"' : "";
    encodeObject($member);
    $member_name_slash = str_replace("'", "\\'", $member->member_name);
    echo <<<eot
<fieldset>
<legend>{$member->member_name} [<a href="javascript:delmember({$member->member_id}, '{$member_name_slash}');">删除</a>]</legend>
<form action="updatemember.php?type=1" method="post">
<input type="hidden" name="member_id" value="{$member->member_id}"/>
学号(非本校队伍可不填): <input type="text" name="stu_number" value="{$member->stu_number}" /> <br/>
姓名: <input type="text" name="member_name" value="{$member->member_name}" /><br/>
姓名拼音: <input type="text" name="member_name_pinyin" value="{$member->member_name_pinyin}" /><br/>
性别: <select name="gender">
<option $gender_GG value="1">GG</option>
<option $gender_MM value="0">MM</option>
</select>
学校: $school_list <br/>
院系及专业(高中队伍可不填): <input type="text" name="faculty_major" value="{$member->faculty_major}" /> <br/>
年级及班级: <input type="text" name="grade_class" value="{$member->grade_class}" /> <br/>
邮箱: <input type="text" name="email" value="{$member->email}" /> <br/>
电话: <input type="text" name="telephone" value="{$member->telephone}" /> <br/>
备注: <textarea name="remark" cols="40" rows="3">{$member->remark}</textarea><br/>
<input type="submit" value="修改"/>
</form>
</fieldset>
eot;
}
if($member_c < 2){
    $school_list = select_school($a->school_id);
    for($i = 0; $i < 2 - $member_c; $i++){
        echo <<<eot
<fieldset>
<legend>新增</legend>
<form action="addmember.php?type=1" method="post">
学号(非本校队伍可不填): <input type="text" name="stu_number" value="" /> <br/>
姓名: <input type="text" name="member_name" value="" /><br/>
姓名拼音: <input type="text" name="member_name_pinyin" value="" /><br/>
性别: <select name="gender">
<option selected="selected" value="1">GG</option>
<option value="0">MM</option>
</select>
学校: $school_list <br/>
院系及专业(高中队伍可不填): <input type="text" name="faculty_major" value="" /> <br/>
年级及班级: <input type="text" name="grade_class" value="" /> <br/>
邮箱: <input type="text" name="email" value="" /> <br/>
电话: <input type="text" name="telephone" value="" /> <br/>
备注: <textarea name="remark" cols="40" rows="3"></textarea><br/>
<input type="submit" value="添加"/>
</form>
</fieldset>
eot;
    }
}
echo "</fieldset>\n";

include(APP_ROOT."include/footer.php");
?>
