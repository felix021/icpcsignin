<?php
$conn1 = new mysqli($dbhost, $dbuser, $dbpass, $dbname) or msgbox("连接数据库失败!");
$cond = "";
$name = "teaminfo_".$_POST['type'];
switch($_POST['type']){
case "whu":
    $cond .= "AND `school_id` = 1 ";
    break;
case "notwhu":
    $cond .= "AND `school_id` != 1 ";
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
    $cond .= "AND `final_id` > 0 AND `final_rank` > 0 ";
    $name .= "_attendfinal";
}
$query = <<<eot
SELECT * FROM `{tblprefix}_teams`
    WHERE vcode = "" {$cond}
eot;
$final_info_td = "";
if ($_POST['final_info']){
    $query .= <<<eot
    ORDER BY `final_rank` ASC
eot;
    $final_info_td = <<<eot
    <td>决赛编号</td>
    <td>决赛出题</td>
    <td>决赛罚时</td>
    <td>决赛排名</td>
eot;
}else{
    $query .= <<<eot
    ORDER BY `team_id` ASC
eot;
}

$res = getQuery($conn, $query);

$mem_td_title = "";
if($_POST['mem_info'] == 1){
    $mem_td_title = "<td>成员</td>\n";
}

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
    <td>顺序</td>
    <td>编号</td>
    <td>队名</td>
    <td>学校名</td>
    {$final_info_td}
    <td>邮箱</td>
    <td>队伍类型</td>
    <td>电话</td>
    <td>地址</td>
    <td>邮编</td>
    {$mem_td_title}
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
    $memberinfo = "";
    if($_POST['mem_info'] == 1){
        $query1 = <<<eot
    SELECT * FROM `{tblprefix}_members` WHERE `team_id` = {$team_id} ORDER BY `type` DESC
eot;
        $res1 = getQuery($conn1, $query1);
        $memberinfo = <<<eot
    <td>
        <table width="100%">

eot;
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
        $memberinfo .= <<<eot
        </table>
    </td>

eot;
    }
    $school_name = school::getNameByTeamId($team_id);
    $school_name = htmlspecialchars($school_name);
    if ($_POST['final_info']){
        $penalty = int2timestr($final_penalty);
        $final_info_team = <<<eot
    <td>{$final_id}</td>
    <td>{$final_solved}</td>
    <td>{$penalty}</td>
    <td>{$final_rank}</td>
eot;
    }
    $out .= <<<eot
<tr class="{$trclass}">
    <td>{$i}</td>
    <td>{$team_id}</td>
    <td>{$team_name}</td>
    <td>{$school_name}</td>
    {$final_info_team}
    <td>{$email}</td>
    <td>{$school_t}</td>
    <td>{$telephone}</td>
    <td>{$address}</td>
    <td>{$postcode}</td>
    {$memberinfo}
</tr>

eot;
}

$out .= <<<eot
</table>
</center>
</body>
</html>
eot;

ob_clean();

header("Content-type: application/octet-stream");
header("Accept-Ranges: bytes");
header("Accept-Length: ".strlen($out));
header("Content-Disposition: attachment;filename={$name}.html");
echo $out;
exit;
?>
