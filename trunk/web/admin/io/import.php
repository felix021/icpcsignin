<?php
include_once('def.php');
include_once(APP_ROOT.'admin/inc.php');

if(get_magic_quotes_gpc()){
    foreach($_POST as &$v) $v = stripslashes($v);
}

extract($_POST, EXTR_SKIP);

if(file_exists("$import_type.php")){
    set_time_limit(0);
    include("$import_type.php");
    include_once(APP_ROOT."admin/footer.php");
}else{
    msgbox("错误的导入类型!");
}
?>
