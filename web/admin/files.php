<?php
include("inc.php");

$dirname = "../attachments";
$dir = scandir($dirname);

ob_start();
echo <<<eot
<script>
function delFile(file){
    if(confirm("确实要删除文件 " + file + " 吗?")){
        window.location = "delfile.php?file=" + encodeURIComponent(file);
    }
}
</script>
<table>
<tr class="tblhead">
<td width="400">文件</td>
<td>操作</td>
</tr>

eot;
natcasesort($dir);
$i = 0;
foreach($dir as &$file){
    $fullname = $dirname . "/" . $file;
    if(!is_file($fullname)) continue;
    if($file == "index.php") continue;
    $trclass = $i & 1 == 0 ? "tre" : "tro";
    $i++;
    $fullname = htmlspecialchars($fullname);
    $file = htmlspecialchars($file, ENT_COMPAT);
    $file_slash = str_replace("'", "\\'", $file);
    echo <<<eot
<tr class="$trclass">
<td><a href="$fullname" target="_blank">$file</a></td>
<td><input type="button" value="删除" onclick="javascript:delFile('$file_slash');"/></td>
</tr>

eot;
}
echo "</table>\n";
if($i == 0){
    ob_clean();
    echo "<div> 暂无文件 </div>\n";
}

?>
<form action="upload.php" enctype="multipart/form-data" method="POST">
文件(慎用中文文件名):
<input name="userfile" type="file"/>
<input type="submit" value="上传"/>
</form>
<?php include("footer.php"); ?>
