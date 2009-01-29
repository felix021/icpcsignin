<?php
function rndstr($length = 6){
    $str = "";
    while($length > 0){
        $str .= (rand() % 10);
        $length--;
    }
    return $str;
}

function encodeObject(&$a, $quote = ENT_COMPAT){
    foreach($a as &$v){
        $v = htmlspecialchars($v, $quote, "utf-8");
    }
}

function msgbox($msg, $htmlencode = true){
    @ob_clean();
    @ob_clean();
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

function select_school($school_id = 0, $type = -1, $force_none = 0, $add_high = 0){
    global $conn;
    $query = "SELECT * FROM {tblprefix}_schools";
    switch($type){
    case 1: //高校
        $query .= " WHERE `school_type` & 4 = 4 ";
        break;
    case 2: //非本校高校
        $query .= " WHERE `school_type` & 1 = 0 AND `school_type` & 4 = 4 ";
        break;
    case 3: //高中
        $query .= " WHERE `school_type` & 4 = 0 ";
        break;
    default:
        ;
    }
    $query .= " ORDER BY `school_type` DESC";
    $res = getQuery($conn, $query);
    $out =  "<select name=\"school_id\">\n";
    if($force_none == 1 || $school_id <= 0){
        if($school_id <= 0) $selected = "selected=\"selected\"";
        $out .= "<option $selected value=\"-1\">请选择学校</option>\n";
    }
    while($row = $res->fetch_assoc()){
        $id = $row['school_id'];
        $name = htmlspecialchars($row['school_name_cn']);
        if($id == $school_id) $selected = "selected=\"selected\"";
        else $selected = "";
        $out .= "<option $selected value=\"$id\">$name</option>\n";
    }
    if($addhigh != 0){
        $out .= "<option value=\"-1\">高中队伍</option>\n";
    }
    $out .= "</select>\n";
    return $out;
}

function time2str($timestamp = -1, $format = "Y-m-d H:i:s"){
    if($timestamp == -1) $timestamp = time();
    return date($format, $timestamp);
}

function str2time($str){
    list($Y, $m, $d, $H, $i, $s) = split(" |-|:", $str);
    return mktime($H, $i, $s, $m, $d, $Y);
}


function sendmail($email, $content, $mode = 0){
    ;
}

function ubb2html($str){
    $str = htmlspecialchars($str, ENT_NOQUOTES);
    $pattern = array(
        "/\[b\](.+?)\[\/b\]/is", //1
        "/\[i\](.+?)\[\/i\]/is", //2
        "/\[u\](.+?)\[\/u\]/is", //3
        "/\[sup\](.+?)\[\/sup\]/is", //4
        "/\[sub\](.+?)\[\/sub\]/is", //5
        "/\[center\](.+?)\[\/center\]/is", //6
        "/\[code\](.+?)\[\/code\]/is", //7
        "/\[quote\](.+?)\[\/quote\]/is", //8
        "/\[span style=\"(.*?)\"\](.+?)\[\/span\]/is", //9
        '/\[img\\s+src=\"(.+?)\"\]/is', //10
        '/\[img\\s+src=\"(.+?)\"\\s+width=\"(.+?)\"\]/is', //11
        '/\[img\\s+src=\"(.+?)\"\\s+height=\"(.+?)\"\]/is', //12
        '/\[img\\s+src=\"(.+?)\"\\s+width=\"(.+?)\"\\s+height=\"(.+?)\"\]/is', //13
        '/\[img\\s+src=\"(.+?)\"\\s+height=\"(.+?)\"\\s+width=\"(.+?)\"\]/is', //14
        '/\[a\\s+href=\"(.+?)\"\](.+?)\[\/a\]/is', //15
        );
    $replace = array(
        "<b>\\1</b>", //1
        "<i>\\1</i>", //2
        "<u>\\1</u>", //3
        "<sup>\\1</sup>", //4
        "<sub>\\1</sub>", //5
        "<center>\\1</center>", //6
        "<div class=\"code\">\\1</div>", //7
        "<div class=\"quote\">\\1</div>", //8
        "<span style=\"\\1\">\\2</span>", //9
        "<img border=\"0\" src=\"\\1\"/>", //10
        "<img border=\"0\" src=\"\\1\" width=\"\\2\"/>", //11
        "<img border=\"0\" src=\"\\1\" height=\"\\2\"/>", //12
        "<img border=\"0\" src=\"\\1\" width=\"\\2\" height=\"\\3\"/>", //13
        "<img border=\"0\" src=\"\\1\" width=\"\\3\" height=\"\\2\"/>", //14
        "<a href=\"\\1\" target=\"_blank\">\\2</a>", //15
        );
    $str = preg_replace($pattern, $replace, $str);
    $str = str_replace("  ", "&nbsp; ", $str);
    $str = str_replace("  ", " &nbsp;", $str);
    return nl2br($str);
}

function upload_judge($name){
    $forbidden_exts = array("php", "php3", "asp", "jpg", "aspx");
    $pos = strrpos($name, ".");
    if($pos === false) return true;
    $ext = substr($name, $pos+1);
    if(in_array($ext, $forbidden_exts)) return false;
    return true;
}

function upload_file($postfile, &$res){
    if(isset($_FILES[$postfile])){
        $file = $_FILES[$postfile];
        $filename = $file['name'];
        $target = dirname(dirname(__FILE__));
        $target .= "/attachments/$filename";
        $res[0] = false;
        $res[1] = $target;
        $res[2] = $filename;
        if(upload_judge($filename) == false){
            $res[3] = "文件扩展名非法!";
            return false;
        }
        if(file_exists($target)){ 
            $res[3] = "文件已经存在!";
            return false;
        }
        if(move_uploaded_file($file['tmp_name'], $target) == false){
            $res[3] = "文件上传失败!";
            return false;
        }else{
            $res[0] = true;
            $res[3] = "文件上传成功";
            return true;
        }
    }else{
            $res[1] = "";
            $res[2] = "";
            $res[4] = "请指定上传文件";
            return false;
    }
}

?>
