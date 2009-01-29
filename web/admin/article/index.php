<?php

include("../inc.php");
include("select_priority.php");

echo <<<eot
<p><a href="newarticle.php">发布新通知</a></p>

eot;

$query = "SELECT `article_id`, `title`, `pub_time`, `priority`, `permission`, `views` "
        ."    FROM `{tblprefix}_articles` ORDER BY `priority` DESC, `pub_time` DESC";
$res = getQuery($conn, $query);

if($conn->affected_rows == 0){
    echo "尚无通知";
    include("../footer.php");
    exit();
}

echo <<<eot
<script language="javascript">
function editArticle(id){
    window.location = "editarticle.php?article_id=" + id;
}
function delArticle(id, title){
    try{
    if(confirm("确定要删除文章 ["+title+"] 吗?")){
        window.location = "delarticle.php?article_id=" + id;
    }
}catch(e){alert(e);}
}
</script>
<table>
<tr class="tblhead">
<td>编号</td>
<td>标题</td>
<td>发布时间</td>
<td>优先级</td>
<td>权限</td>
<td>访问量</td>
<td>操作</td>
</tr>

eot;

$i = 0;
while($row = $res->fetch_assoc()){
    $trclass = $i & 1 ? "tre" : "tro";
    encodeObject($row);
    extract($row);
    $pubtime = time2str($pub_time);
    $priority_list = select_priority($priority);
    $perm = $permission == 1 ? "checked=\"checked\"" : "";
    $title_slash = str_replace("'", "\\'", $title);
    echo <<<eot
<form action="updatearticle.php?type=basicinfo&article_id={$article_id}" method="post">
<tr class="$trclass">
<td>{$article_id}</td>
<td><input type="text" name="title" value="{$title}"/></td>
<td><input type="text" name="pub_time" value="{$pubtime}"/></td>
<td>$priority_list</td>
<td><input type="checkbox" name="permission" $perm value="1"/>开放</td>
<td>{$views}</td>
<td>
<input type="submit" value="更新" />
<input type="button" value="编辑" onclick="javascript:editArticle({$article_id});" />
<input type="button" value="删除" onclick="javascript:delArticle({$article_id}, '{$title_slash}');" />
</td>
</tr>
</form>

eot;
}

include("../footer.php");

?>
