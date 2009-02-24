<?php
$t = new team;
$data = split("\n", $content);
include_once(APP_ROOT."admin/header.php");

$i = 1;
foreach($data as $line){
    $line = trim($line);
    if(empty($line)) continue;
    if(!preg_match("/^\\s*(\\d+(\t|\|)\\d+(\t|\|)\\d+)\\s*/", $line)){
        msgbox("第{$i}行格式错误: {$line}");
        exit;
    }
    $i++;
}

reset($data);
foreach($data as $line){
    $line = trim($line);
    if(empty($line)) continue;
    else{
        $s = preg_split("/\t|\|/is", $line);
        foreach($s as &$v) $v = trim($v);
        $t->getById((int)$s[0]);
        if($t->errno){
            echo "<div style=\"color:red;\">导入失败: $line({$t->error})</div>\n";
        }else{
            $t->pre_solved = (int)$s[1];
            $t->pre_penalty = (int)$s[2];
            $t->update();
            if($t->errno){
                echo "<div style=\"color:red;\">导入失败: $line($t->error)</div>\n";
            }else{
                echo "<div>导入成功: $line</div>\n";
            }
        }
    }
}
echo "<div>正在排序...</div>";
$query = "SELECT `team_id` FROM `{tblprefix}_teams` ORDER BY `pre_solved` DESC, `pre_penalty` ASC";
$res = getQuery($conn, $query);
$i = 1;
$a = new team;
while($row = $res->fetch_assoc()){
    $team_id = (int)$row['team_id'];
    $a->getById($team_id);
    if($a->pre_solved < 0) continue;
    else
        $a->pre_rank = $i;
    if($a->update()){
        echo "<div>team{$a->team_id} $a->team_name: $i</div>\n";
    }
    $i++;
}
include_once(APP_ROOT."admin/footer.php");
?>
