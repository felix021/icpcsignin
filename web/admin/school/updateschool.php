<?php
include("../inc.php");
if(get_magic_quotes_gpc()){
    foreach($_POST as &$value){
        $value = stripslashes($value);
    }
}

extract($_POST);

$links = '<a href="school.php">学校管理</a>';

if(isset($modify)){ //修改
    
    $a = new school((int)$_POST['school_id']);
    $a->school_name_cn = $school_name_cn;
    $a->school_name_en = $school_name_en;
    $a->setOurSchool($isOurSchool == 1);
    $a->setOurCity($isOurCity == 2);
    $a->setUniversity($isUniversity == 4);

    if($a->update()){
        msgbox("更新成功!");
    }else{
        msgbox($a->error);
    }

}else if(isset($add)){ //增加

    $a = new school;
    $a->school_name_cn = $school_name_cn;
    $a->school_name_en = $school_name_en;
    $a->setOurSchool($isOurSchool == 1);
    $a->setOurCity($isOurCity == 2);
    $a->setUniversity($isUniversity == 4);

    if($a->insert()){
        msgbox("添加成功!");
    }else{
        msgbox($a->error);
    }

}

include("../footer.php");
?>
