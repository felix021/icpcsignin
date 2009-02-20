<?php
$relpath = dirname(__FILE__);
include($relpath."/def.php");

include(APP_ROOT."team/inc.php");
?>
<script language="javascript">
function change(t){
    var b = document.getElementById("delbtn");
    if(b){
        if (t.value == "OK" || t.value == "ok"){
            b.disabled = false;
        }else{
            b.disabled = true;
        }
    }
}
function unsetteam(){
    if(confirm("确认要删除此队伍?删除后队伍信息将无法恢复!")){
        var unsetbtn = document.getElementById("unsetbtn");
        if(unsetbtn) unsetbtn.click();
        //window.location = 'team/unsetteam.do.php';
    }
}
</script>
<div class="textbox">
<div class="textbox-title">删除队伍 [注意：删除后队伍信息不可恢复！]</div>
<div class="textbox-content">
请输入"OK"进行确认: 
<input type="text" size="5" onkeyup="javascript:change(this)"/>
<input type="button" value="确认删除" id="delbtn" disabled onclick="unsetteam()"/>
<form action="team/unsetteam.do.php" style="display:none;" method="get">
<input type="submit" id="unsetbtn">
</form>
</div>
</div>
<?php
include(APP_ROOT."include/footer.php");
?>
