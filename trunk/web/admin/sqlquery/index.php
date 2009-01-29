<?php

include("../inc.php");

echo <<<eot
<p style="text-align:left;">
本页面允许使用自定义的SELECT/DESCRIBE语句进行查询并显示查询结果。<br/>
注意：一次只能运行一条语句.<br/><br/>
数据库中包含以下表(数据库具体结构参见项目文档的database.txt):
<ul style="text-align:left;">
<li>{$tblprefix}_articles</li>
<li>{$tblprefix}_hotels</li>
<li>{$tblprefix}_members</li>
<li>{$tblprefix}_messages</li>
<li>{$tblprefix}_schools</li>
<li>{$tblprefix}_teams</li>
</ul>
</p>

<form action="query.php" method="post">
<textarea name="query" cols="60" rows="5">SELECT * FROM `{$tblprefix}_teams` WHERE 1</textarea>
<br/>
<input type="submit" value="提交查询"/>
</form>

eot;

include("../footer.php");

?>
