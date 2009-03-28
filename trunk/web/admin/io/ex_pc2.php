<?php
$query = <<<eot
SELECT 
    `team_id`, #队伍编号
    `team_name`, #队名
    `final_id` #决赛编号
  FROM `{tblprefix}_teams`
  WHERE `final_id` > 0
  ORDER BY `final_id` ASC
eot;

$res = getQuery($conn, $query);
if($conn->affected_rows == 0){
    msgbox("没有符合条件的队伍");
}

$out = "";
while($row = $res->fetch_assoc()){
    encodeObject($row);
    extract($row);
    $team_name = str_replace("|", " ", $team_name);
    $pass = rndstr(6);
    $out .= <<<eot
{$final_id}|team{$final_id} - {$team_name}|TRUE|{$pass}

eot;
}

ob_clean();
header("Content-type: application/octet-stream");
header("Accept-Ranges: bytes");
header("Accept-Length: ".strlen($out));
header("Content-Disposition: attachment;filename=pc2.txt");
echo $out;
exit;
?>
