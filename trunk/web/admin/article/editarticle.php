<?php
$relpath = dirname(__FILE__);
include($relpath."/def.php");

include(APP_ROOT."admin/inc.php");

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

if(isset($a)){
    $content = $a->content;

    switch($a->content_type){
    case 0:
        $plain = "checked=\"checked\"";
        $display = "none";
        break;
    case 1:
        $html = "checked=\"checked\"";
        $display = "none";
        break;
    default:
    case 2:
        $ubb = "checked=\"checked\"";
        $display = "block;";
        break;
    }
}else{
    $ubb = "checked=\"checked\"";
    $display = "block;";
}
include('editor.php');

echo <<<eot
</form>

eot;

include(APP_ROOT."admin/footer.php");

?>
