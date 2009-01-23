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
?>
