<?php

include("../inc.php");
include("select_priority.php");

$a = new article($_GET['article_id']);
if($a->errno){
    msgbox($a->error);
}

$timestr = time2str($a->pub_time);
$priority_list = select_priority($a->priority);
$perm = $a->permission ? "checked=\"checked\"" : "";

encodeObject($a);

echo <<<eot
<form action="updatearticle.php?article_id={$a->article_id}&action=all" method="post" style="text-align:left;">
编号: {$a->article_id} <br/>
标题: <input type="text" name="title" value="{$a->title}" /><br/>
发布时间: <input type="text" name="pub_time" value="{$timestr}"/>
优先级: $priority_list <input type="checkbox" name="permission" $perm value="1" />公开<br/>

eot;

include('editor.php');

echo <<<eot
</form>

eot;

include("../footer.php");

?>
