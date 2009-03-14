<?php
$relpath = dirname(__FILE__);
include($relpath."/def.php");

include_once(APP_ROOT."admin/inc.php");

$a = new team($_GET['team_id']);
if($a->errno){
    msgbox($a->error);
}

encodeObject($a);

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
<form action="updateteam.php?team_id={$a->team_id}" method="post">
<fieldset style="margin:10px;">
<legend>队伍信息 [<a href="editmembers.php?team_id={$a->team_id}">编辑成员</a>]</legend>
编号: {$a->team_id}<br/>
队名: {$a->team_name}<br/>
邮箱: <input type="text" name="email" value="{$a->email}" />修改须谨慎<br/>
验证码: <input type="text" name="vcode" value="{$a->vcode}"/>留空为已验证<br/>
密码: <input type="text" name="password" value="{$a->password}" /><br/>
学校: 
<input type="radio" $school_whu name="team_type" checked="checked" value="1"/>武汉大学队伍 
<input type="radio" $school_o name="team_type" value="2"/>其他高校队伍
$school_list
<input type="radio" $school_high name="team_type" value="3"/>高中队伍<br/>
电话: <input type="text" name="telephone" value="{$a->telephone}"/><br/>
地址: <input type="text" name="address" value="{$a->address}"/><br/>
邮编: <input type="text" name="postcode" value="{$a->postcode}"/><br/>
<input type="checkbox" name="valid_for_final" $for_final value="1"/>若晋级能前往参加决赛<br/>
<fieldset>
<legend>比赛信息</legend>
(-1)表示没有相应信息<br/>
预赛排名: <input type="text" name="pre_rank" value="{$a->pre_rank}"/><br/>
预赛出题数: <input type="text" name="pre_solved" value="{$a->pre_solved}"/><br/>
预赛罚时: <input type="text" name="pre_penalty" value="{$a->pre_penalty}"/>秒<br/>
决赛编号: <input type="text" name="final_id" value="{$a->final_id}"/><br/>
决赛排名: <input type="text" name="final_rank" value="{$a->final_rank}"/><br/>
决赛出题数: <input type="text" name="final_solved" value="{$a->final_solved}"/><br/>
决赛罚时: <input type="text" name="final_penalty" value="{$a->final_penalty}"/>秒<br/>
</fieldset>
住宿要求: <textarea name="requirement" cols="50" rows="3">{$a->requirement}</textarea><br/>
备注: <textarea name="remark" cols="50" rows="3">{$a->remark}</textarea><br/>
<input type="submit" value="更新"/>
</form>
</fieldset>
</form>
eot;

include_once(APP_ROOT."admin/footer.php");
?>
