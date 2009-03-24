<?php
$query = <<<eot
SELECT * FROM `{tblprefix}_teams`
    WHERE `final_id` > 0
      AND `requirement` != ""
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
    <td>队伍id</td>
    <td>决赛id</td>
    <td>队名</td>
    <td>队伍类型</td>
    <td>电话</td>
    <td>住宿要求</td>
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
    $requirement = nl2br($requirement);
    $out .= <<<eot
<tr class="{$trclass}">
    <td>{$team_id}</td>
    <td>{$final_id}</td>
    <td>{$team_name}</td>
    <td>{$school_t}</td>
    <td>{$telephone}</td>
    <td>{$requirement}</td>
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
header("Content-Disposition: attachment;filename=hotel_requirements.html");
echo $out;

?>
