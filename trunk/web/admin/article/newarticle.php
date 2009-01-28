<?php

include("../inc.php");
include("select_priority.php");

$priority_list = select_priority();

echo <<<eot
<form action="addarticle.php" method="post" style="text-align:left;">
标题: <input type="text" name="title" />
优先级: $priority_list 
<input type="checkbox" name="permission" checked="checked" value="1" />公开<br/>

eot;

include('editor.php');

echo <<<eot
<br/>
<input type="submit" value="发布"/>
</form>

eot;

include("../footer.php");

?>
