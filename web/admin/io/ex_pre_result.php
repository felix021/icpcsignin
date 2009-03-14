<?php
$cond = "";
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
$query = <<<eot
SELECT * FROM `{tblprefix}_teams`
    WHERE `pre_rank` >= 0 {$cond}
    ORDER BY `pre_rank` ASC
eot;

$res = getQuery($conn, $query);

$out = <<<eot
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<title>预赛结果</title>
<style type="text/css">
td{text-align:center;}
.tre{background-color: #ddd;}
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
    <td>学校</td>
    <td>出题</td>
    <td>罚时</td>
    <td>排名</td>
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
    $school_name = school::getNameByTeamId($row['team_id']);
    $tm = int2timestr($row['pre_penalty']);
    foreach($row as &$v) $v = htmlspecialchars($v);
    extract($row, EXTR_OVERWRITE);
    $out .= <<<eot
<tr class="{$trclass}">
    <td>{$team_id}</td>
    <td>{$team_name}</td>
    <td>{$email}</td>
    <td>{$school_t}</td>
    <td>{$school_name}</td>
    <td>{$pre_solved}</td>
    <td>{$tm}</td>
    <td>{$pre_rank}</td>
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
header("Content-Disposition: attachment;filename=pre_result_{$_POST['type']}.html");
echo $out;

?>
