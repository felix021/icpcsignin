<?php
include("inc.php");
?>
<p>注意：注销后队伍信息不可恢复！</p>
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
        window.location = 'unsetteam.do.php';
    }
}
</script>
<p>请输入"OK"进行确认:</p>
<input type="text" size="5" onkeyup="javascript:change(this)"/>
<input type="button" value="确认删除" id="delbtn" disabled onclick="unsetteam()"/>
<?php
include("../include/footer.php");
?>
