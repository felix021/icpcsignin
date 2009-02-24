<?php
$t = new school;
$data = split("\n", $content);
include_once(APP_ROOT."admin/header.php");
$i = 1;
foreach($data as $line){
    $line = trim($line);
    if(empty($line)) continue;
    if(!preg_match("/.*(\t|\|).*(\t|\|)[01](\t|\|)[01](\t|\|)[01]/", $line)){
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
        $t->school_name_cn = $s[0];
        $t->school_name_en = $s[1];
        if($s[2] == "1"){
            $t->setOurSchool(true);
        }else{
            $t->setOurSchool(false);
        }
        if($s[3] == "1"){
            $t->setOurCity(true);
        }else{
            $t->setOurCity(false);
        }
        if($s[4] == "1"){
            $t->setUniversity(true);
        }else{
            $t->setUniversity(false);
        }
        $t->insert();
        if($t->errno){
            echo "<div style=\"color:red;\">导入失败: $line</div>\n";
        }else{
            echo "<div>导入成功: $line</div>\n";
        }
    }
}
include_once(APP_ROOT."admin/footer.php");
?>
