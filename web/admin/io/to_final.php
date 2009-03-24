<?php
$t = new team;
$data = split("\n", $content);
shuffle($data);
include_once(APP_ROOT."admin/header.php");

$i = 1;
foreach($data as $line){
    $line = trim($line);
    if(empty($line)) continue;
                        //Rank       ID         AC          Penalty
    if(!preg_match("/^\\s*\\d+\\s*/", $line)){
        msgbox("第{$i}行格式错误: {$line}");
        exit;
    }
    $i++;
}

reset($data);
$i = 1;
foreach($data as $line){
    $line = trim($line);
    if(empty($line)) continue;
    else{
        $t->getById((int)$line);
        if($t->errno){
            echo "<div style=\"color:red;\">导入失败: $line({$t->error})</div>\n";
        }else{
            $t->final_id = $i;
            $t->update();
            if($t->errno){
                echo "<div style=\"color:red;\">导入失败: $line($t->error)</div>\n";
            }else{
                echo "<div>导入成功: $line(final_id={$t->final_id})</div>\n";
            }
        }
    }
    $i++;
}
include_once(APP_ROOT."admin/footer.php");
?>
