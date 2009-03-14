<?php
$conn1 = new mysqli($dbhost, $dbuser, $dbpass, $dbname) or msgbox("连接数据库失败!");
$cond = "";
$name = "teaminfo_".$_POST['type'];
switch($_POST['type']){
case "whu":
    $cond .= "AND `school_id` = 1 ";
    break;
case "col":
    $cond .= "AND `school_id` > 1 ";
    break;
case "high":
    $cond .= "AND `school_id` < 0 ";
    break;
case "all":
}
if($_POST['attend_pre']){
    $cond .= "AND `pre_rank` > 0 ";
    $name .= "_attendpre";
}
if($_POST['attend_final']){
    $cond .= "AND `final_id` > 0 ";
    $name .= "_attendfinal";
}
$query = <<<eot
SELECT * FROM `{tblprefix}_teams`
    WHERE vcode = "" {$cond}
    ORDER BY `team_id` ASC
eot;

$res = getQuery($conn, $query);

$out = <<<eot
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<title>队伍信息</title>
<style type="text/css">
td{text-align:center;}
.tre{background-color: #ccc;}
.tro{background-color: #eee;}
</style>
</head>
<body>
<center>
<table align="center">
<tr class="tro">
    <td>编号</td>
    <td>队名</td>
    <td>邮箱</td>
    <td>队伍类型</td>
    <td>电话</td>
    <td>地址</td>
    <td>邮编</td>
    <td>成员</td>
</tr>

eot;
$i = 0; 
while ($row = $res->fetch_assoc()){
    $i++;
    $trclass = $i & 1 ? "tre" : "tro";
    if($row['school_id'] == 1){
        $school_t = '本校';
    }else if($row['school_id'] > 1){
        $school_t = '其他高校';
    }else{
        $school_t = '高中队伍';
    }
    foreach($row as &$v) $v = htmlspecialchars($v);
    extract($row, EXTR_OVERWRITE);
    $query1 = <<<eot
SELECT * FROM `{tblprefix}_members` WHERE `team_id` = {$team_id} ORDER BY `type` DESC
eot;
    $res1 = getQuery($conn1, $query1);
    $memberinfo = "";
    $i1 = 0;
    while($row1 = $res1->fetch_assoc()){
        $i1++;
        $trclass1 = $i1 & 1 ? "tre" : "tro";
        $memberinfo .= "<tr class=\"{$trclass1}\">";
        foreach($row1 as &$v) $v = htmlspecialchars($v);
        switch($row1['type']){
        case 0: //教练
            $memberinfo .= "<td>教练</td>";
            break;
        case 1: //队员
            $memberinfo .= "<td>队员</td>";
            break;
        case 2: //队长
            $memberinfo .= "<td>队长</td>";
            break;
        }
        $sch = new school($row1['school_id']);
        $gender = $row1['gender'] ? "男" : "女";
        $memberinfo .= <<<eot
    <td>{$row1['member_name']}</td>
    <td>{$gender}</td>
    <td>{$row1['email']}</td>
    <td>{$row1['telephone']}</td>
    <td>{$sch->school_name_cn}</td>
    <td>{$row1['faculty_major']} {$row1['grade_class']}</td>
    </tr>
eot;
    }
    $out .= <<<eot
<tr class="{$trclass}">
    <td>{$team_id}</td>
    <td>{$team_name}</td>
    <td>{$email}</td>
    <td>{$school_t}</td>
    <td>{$telephone}</td>
    <td>{$address}</td>
    <td>{$postcode}</td>
    <td>
    <table width="100%">
        {$memberinfo}
    </table>
    </td>
</tr>

eot;
}

$out .= <<<eot
</table>
</body>
</html>
eot;

ob_clean();

header("Content-type: application/octet-stream");
header("Accept-Ranges: bytes");
header("Accept-Length: ".strlen($out));
header("Content-Disposition: attachment;filename={$name}.html");
echo $out;

?>
