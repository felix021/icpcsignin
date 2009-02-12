<?php
$relpath = dirname(__FILE__);
include($relpath."/def.php");
include(APP_ROOT."admin/inc.php");

$priority_list = select_priority();

echo <<<eot
<form action="addarticle.php" method="post" style="text-align:left;">
标题: <input type="text" name="title" />
优先级: $priority_list 
<input type="checkbox" name="permission" checked="checked" value="1" />公开<br/>

eot;

$ubb = "checked=\"checked\"";
$display = "block";
include(APP_ROOT.'editor/editor.php');

echo <<<eot
</form>

eot;

include(APP_ROOT."admin/footer.php");

?>
