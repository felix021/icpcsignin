<?php
include_once('def.php');
include_once(APP_ROOT.'admin/inc.php');
?>
<script>
function import_data(t){
try{
    var import_type = document.getElementById('import_type');
    import_type.value = t;
    var submitbtn = document.getElementById('submitbtn');
    submitbtn.click();
}catch(e){alert(e);}
}
</script>
<div class="textbox">
<div class="textbox-title">导入</div>
<form method="post" action="import.php">
<input type="hidden" name="import_type" id="import_type" value="0"/>
<input type="submit" id="submitbtn" style="display:none;"/>
导入文本:<br/>
<textarea name="content" style="width:600px;height:300px;"></textarea><br/>
<input type="button" value="学校列表" onclick="javascript:import_data('school');"/>
<input type="button" value="预赛结果" onclick="javascript:import_data('pre');"/>
<input type="button" value="决赛结果" onclick="javascript:import_data('final');"/>
</form>
</div>
<?php
include_once(APP_ROOT."admin/footer.php");
?>
