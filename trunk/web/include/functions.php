<?php
function rndstr($length = 6){
    $str = "";
    while($length > 0){
        $str .= (rand() % 10);
        $length--;
    }
    return $str;
}

function msgbox($msg, $htmlencode = true){
    ob_clean();
    if($htmlencode){
        $msg = htmlspecialchars($msg);
    }
    echo <<<eot
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
    a{color:blue;text-decoration:none;}
    a:hover{color:red;text-decoration:underline;}
    .msgbox{
        width: 500px;
        margin-top: 120px;
        border: 1px solid #00a7dd; 
        border-top: 1px solid #00a7dd; 
        text-align: center; 
    }
    .msgbox-title{
        font-weight: bold; 
        border-bottom: 1px solid #00a7dd; 
        background-color: #00a7dd;
        color: #fff;
        padding: 5px;
    }
    .msgbox-content{
        padding: 10px; 
        padding-bottom: 20px; 
        text-align: left;
    }
    .msgbox-bottom{
        border-top: 1px dashed #00a7dd; 
        padding: 5px;
    }
    </style>
</head>
<body align="center">
<center>

<div class="msgbox" align="center">
    <div class="msgbox-title">提示</div>
    <div class="msgbox-content">{$msg}</div>
    <div class="msgbox-bottom">
        {$links}
        <a href="javascript:history.back(1)">返回上一页</a>
    </div>
</div>
</center>
</body>
</html>
eot;
    exit();
}

function select_school($school_id = -1, $type = 0){
    global $conn;
    $query = "SELECT * FROM {tblprefix}_schools";
    if($type > 0){
        $query .= " WHERE `school_type` = $type";
    }
    $query .= " ORDER BY `school_type` DESC";
    $res = getQuery($conn, $query);
    $out =  "<select name=\"school_id\">\n";
    while($row = $res->fetch_assoc()){
        $id = $row['school_id'];
        $name = htmlspecialchars($row['school_name_cn']);
        if($id == $school_id) $selected = "selected=\"selected\"";
        else $selected = "";
        $out .= "<option $selected value=\"$id\">$name</option>\n";
    }
    $out .= "</select>\n";
    return $out;
}

function time2str($timestamp = -1){
    if($timestamp == -1) $timestamp = time();
    return date("Y-m-d H:i:s", $timestamp);
}

function str2time($str){
    list($Y, $m, $d, $H, $i, $s) = split(" |-|:", $str);
    return mktime($H, $i, $s, $m, $d, $Y);
}

?>
