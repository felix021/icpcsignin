<?php
include_once('def.php');
include_once(APP_ROOT.'admin/inc.php');
?>
<script>
function import_data(t){
try{
    var import_type = document.getElementById('import_type');
    import_type.value = t;
    var submitbtn = document.getElementById('submitbtn1');
    if(confirm("确定导入?(type="+t+")")){
        submitbtn.click();
    }
}catch(e){alert(e);}
}
</script>
<div class="textbox">
<div class="textbox-title">导入</div>
<div class="textbox-content">
<form method="post" action="import.php">
<input type="hidden" name="import_type" id="import_type" value="0"/>
<input type="submit" id="submitbtn1" style="display:none;"/>
<table>
<tr>
<td>
导入文本:<br/>
<textarea name="content" style="width:600px;height:300px;"></textarea><br/>
</td>
<td style="text-align:left">
<pre>
格式：

学校列表：
中文名|英文名|是否本校|是否本地|是否高校
例:  武汉大学|Wuhan University|1|1|1

预赛结果：
Rank|队伍id|出题数量|罚时(H:m:s, oak格式)
e.g. 20|1|3|6:23:13

决赛结果：
队伍id|出题数量|罚时(分钟, pc2格式)
e.g. 20|1|3|456
</pre>
</td>
</tr>
</table>
<input type="button" value="学校列表" onclick="javascript:import_data('school');"/>
<input type="button" value="预赛结果" onclick="javascript:import_data('pre');"/>
<input type="button" value="决赛结果" onclick="javascript:import_data('final');"/>
</form>
</div>
</div>
<div class="textbox">
<div class="textbox-title">导出</div>
<div class="textbox-content">
<form method="post" action="export.php">
<input type="hidden" name="export_type" value="for_oak"/>
WOJ队伍ID前缀<input type="text" name="prefix" value="whu09cc_"/>
<input type="submit" value="生成oak队伍数据"/>
导出：已验证邮箱并添加成员的队伍<br/>
<input type="checkbox" name="include_no_member" value="1"/>
包括未添加成员的队伍
</form>
</div>
</div>
<?php
include_once(APP_ROOT."admin/footer.php");
?>
