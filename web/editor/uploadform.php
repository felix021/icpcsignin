<?php
$relpath = dirname(__FILE__);
include($relpath."/def.php");
include_once(APP_ROOT."include/config.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body style="margin:0">
<form action="<?php echo $installDir; ?>/editor/upload.php" style="display:inline;" enctype="multipart/form-data" method="POST">
文件(慎用中文名) <input name="userfile" type="file"/><input type="submit" value="上传"/>
</form>
</body>
</html>
