<?php
if($_POST['include_no_member'] == "1"){ //包括没添加成员的队伍
    $query = <<<eot
    SELECT 
        team_id, #队伍编号
        team_name, #队名
        email, #邮箱
        password, #密码
        school_id #学校编号
      FROM `{tblprefix}_teams`
      WHERE vcode = ""
      ORDER BY team_id ASC
eot;
}else{ //不包括没添加成员的队伍
    $query = <<<eot
    SELECT 
        a.team_id as team_id, #队伍编号
        a.team_name as team_name, #队名
        a.email as email, #邮箱
        a.password as password, #密码
        a.school_id as school_id, #学校编号
        COUNT(b.member_id) as num #队员人数
      FROM `{tblprefix}_teams` a LEFT JOIN `{tblprefix}_members` b
        ON a.team_id = b.team_id
      WHERE a.vcode="" AND b.type > 0
      GROUP BY a.team_id
      HAVING num > 0
      ORDER BY a.team_id ASC

eot;
}

$res = getQuery($conn, $query);
if($conn->affected_rows == 0){
    msgbox("没有符合条件的队伍");
}

echo "<textarea style=\"width:900;height:480;\">";
while($row = $res->fetch_assoc()){
    encodeObject($row);
    extract($row);
    $sch = school::getNameByTeamId($team_id);
    echo <<<eot
{$prefix}{$team_id}\t{$email}\t{$password}\t{$team_name}\t$sch

eot;
}
echo "</textarea>\n";
include_once(APP_ROOT."admin/footer.php");
?>
