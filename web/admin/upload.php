<?php
$relpath = dirname(__FILE__);
include($relpath."/def.php");

include(APP_ROOT."admin/inc.php");
if(isset($_FILES['userfile'])){
    $res = array();
    $app_root = APP_ROOT;
    if(upload_file('userfile', $res)){
        encodeObject($res);
        msgbox("文件<a href=\"{$app_root}attachments/{$res[2]}\" target=\"_blank\">{$res[2]}</a>上传成功!", false);
    }else{
        encodeObject($res);
        msgbox("无法上传文件: {$res[3]}");
    }
}else{
    echo <<<eot
<form enctype="multipart/form-data" method="POST">
文件<input name="userfile" type="file"/>
<input type="submit" value="上传"/>
</form>
eot;
    include(APP_ROOT."admin/footer.php");
}
?>
