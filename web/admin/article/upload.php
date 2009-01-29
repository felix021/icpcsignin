<?php
include("../inc.php");
ob_clean();
echo <<<eot
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body style="margin:0">
eot;
if(isset($_FILES['userfile'])){
    $res = array();
    if(upload_file('userfile', $res)){
        encodeObject($res);
        $file_slash = str_replace("'", "\\'", $res[2]);
        echo <<<eot
<script>
function insertLink(name){
    var cont = parent.document.getElementById('content');
    cont.value += '[a href="attachments/' + name + '"]' + name + '[/a]';
}
</script>
文件 <a href="../../attachments/{$res[2]}" target="_blank">attachments/{$res[2]}</a> 上传成功!
<input type="button" value="将链接插入文章" onclick="javascript:insertLink('{$file_slash}')"/>
<input type="button" onclick="javascript:history.back(1);" value="返回继续上传"/>
eot;
    }else{
        encodeObject($res);
        echo <<<eot
无法上传文件: {$res[3]}
<input type="button" onclick="javascript:history.back(1);" value="返回"/>
eot;
    }
}
?>
</body>
</html>
