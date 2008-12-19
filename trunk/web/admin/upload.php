<?php
include("verify.php");
include("header.php");
ob_clean();
if(isset($_FILES['userfile'])){
    echo <<<eot
<html><head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
<style>a{color:blue;text-decoration:none;} a:hover{color:red;text-decoration:underline;}</style>
</head><body>
eot;
    $file = $_FILES['userfile'];
    $target = "../attachments/{$file['name']}";
    if(file_exists($target)){ 
        ob_clean();
        die("File <a href=\"{$target}\">attachment/{$file['name']}</a> Exists!");
    }
    if(move_uploaded_file($file['tmp_name'], $target) == false){
        echo <<<eot
<span style="color:red">文件上传失败, 请联系管理员. </span>
<a href="javascript:history.back(1)">返回</a>
eot;
    }else{
        echo <<<eot
<span style="color:red">上传成功至 <a href="{$target}">attachment/{$file['name']}</a> !</span>
<a href="javascript:history.back(1)">返回</a><br/>
eot;
    }
    echo "</body></html>";
}else{
    echo <<<eot
<html><head><meta http-eqvui="Content-Type" content="text/html;charset=utf-8"/></head><body>
<form action="{$_SERVER['PHP_SELF']}" enctype="multipart/form-data" method="POST">
文件<input name="userfile" type="file"/>
<input type="submit" value="上传"/>
</form></body></html>
eot;
}
?>
