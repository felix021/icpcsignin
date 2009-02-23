<?php
include_once("def.php");
include_once(APP_ROOT."team/inc.php");
?>
<script language="javascript">
function unsetteam(){
    if(confirm("确认要删除此队伍?删除后队伍信息将无法恢复!")){
        var unsetbtn = document.getElementById("unsetbtn");
        if(unsetbtn) unsetbtn.click();
    }
}
</script>
<div class="textbox">
<div class="textbox-title">删除队伍 [注意：删除后队伍信息不可恢复！]</div>
<div class="textbox-content">
<form action="team/unsetteam.do.php" method="post">
请输入队伍密码进行确认: <input type="password" name="password" size="10"/>
<input type="button" value="确认删除" id="delbtn" onclick="unsetteam()"/>
<input type="submit" id="unsetbtn" style="display:none;" />
</form>
</div>
</div>
