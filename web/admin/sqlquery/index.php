<?php
$relpath = dirname(__FILE__);
include($relpath."/def.php");

include(APP_ROOT."admin/inc.php");

echo <<<eot
<div style="text-align:left">
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
常用查询:<br/>
<pre>
查看高中队伍
SELECT * FROM {tblprefix}_teams WHERE school_id=-1

查看未验证邮箱的队伍
SELECT * FROM {tblprefix}_teams WHERE vcode != ""

查看队伍人数
SELECT a.team_id as team_id, a.team_name as team_name, COUNT(b.`member_id`) as num
  FROM `{tblprefix}_teams` a LEFT JOIN `{tblprefix}_members` b
  ON a.team_id = b.team_id
  # WHERE b.type > 0  # 教练type是0，队长是1，队员是2
  GROUP BY a.team_id
  # Having num = 0 #去掉行首井号则选择没有队员的队伍, >0则是符合条件的队伍

人员判重
SELECT * FROM `{tblprefix}_members` a, `{tblprefix}_members` b 
WHERE a.member_name = b.member_name 
  and a.team_id <> b.team_id;

找出队伍学校与队员学校不符合的队伍(高中队伍除外)
SELECT a.team_id, a.team_name, a.school_id as a_s, b.school_id as b_s
  FROM 2009_teams a JOIN 2009_members b
    ON a.team_id=b.team_id
  WHERE a.school_id > 0 AND a.school_id != b.school_id
</pre>
</div>
eot;

include(APP_ROOT."admin/footer.php");

?>
