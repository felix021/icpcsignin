<?php
include("inc.php");
if(isset($_FILES['userfile'])){
    $res = array();
    if(upload_file('userfile', $res)){
        encodeObject($res);
        msgbox("文件<a href=\"{$res[1]}\" target=\"_blank\">{$res[2]}</a>上传成功!", false);
    }else{
        encodeObject($res);
        msgbox("无法上传文件: {$res[3]}");
    }
}else{
    echo <<<eot
<form action="{$_SERVER['PHP_SELF']}" enctype="multipart/form-data" method="POST">
文件<input name="userfile" type="file"/>
<input type="submit" value="上传"/>
</form>
eot;
    include("footer.php");
}
?>
