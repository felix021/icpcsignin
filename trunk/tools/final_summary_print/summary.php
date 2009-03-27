<?php
if(file_exists("summary.html"))
{
    $summary = file_get_contents("summary.html");
    $start = strpos($summary, "<table");
    $end = strpos($summary, "</body>");
    $length = $end + 8 - $start;
    $summary = substr($summary, $start, $length);
    echo <<<eot
<div style="font-size:22px"><p><br/>即时排名<br/></p></div>
eot;
    echo str_replace('<table border="0"', '<table border="1"', $summary);
} else {
    echo <<<eot
<div style="text-align:center;font-size:22px;margin:20px;">尚未开始:)</div>
eot;
}
?>
