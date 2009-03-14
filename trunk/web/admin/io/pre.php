<?php
$t = new team;
$data = split("\n", $content);
include_once(APP_ROOT."admin/header.php");

$i = 1;
foreach($data as $line){
    $line = trim($line);
    if(empty($line)) continue;
                        //Rank       ID         AC          Penalty
    if(!preg_match("/^\\s*\\d+(\t|\|)\\d+(\t|\|)\\d+(\t|\|)\\d+\\s*/", $line)){
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
        $t->getById((int)$s[1]);
        if($t->errno){
            echo "<div style=\"color:red;\">导入失败: $line({$t->error})</div>\n";
        }else{
            $t->pre_rank = (int)$s[0];
            $t->pre_solved = (int)$s[2];
            $t->pre_penalty = (int)timestr2int($s[3]); //oak格式
            $t->update();
            if($t->errno){
                echo "<div style=\"color:red;\">导入失败: $line($t->error)</div>\n";
            }else{
                echo "<div>导入成功: $line</div>\n";
            }
        }
    }
}
include_once(APP_ROOT."admin/footer.php");
?>
