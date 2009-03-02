<?php
$relpath = dirname(__FILE__);
include($relpath."/def.php");

include(APP_ROOT."admin/inc.php");

$query = $_POST['query'];
if(get_magic_quotes_gpc()){
    $query = stripslashes($query);
}

$query = trim($query);

$pattern = "/^(select.*FROM|describe)\\s* (`?$dbname`?\.)?`?($tblprefix|\{tblprefix\})/is";
if(preg_match($pattern, $query) == 0){
    msgbox("SQL查询中包含不被允许的查询语句");
}

$res = getQuery($conn, $query);

$i = 0;
$out = "";
$tblhead = <<<eot
<table>
<tr class="tblhead">

eot;
while($row = $res->fetch_assoc()){
    encodeObject($row);
    $trclass = $i & 1 ? "tro" : "tre";
    $out.= "<tr class=\"$trclass\">\n";
    foreach($row as $key=>$value){
        if($i == 0){
            $key = htmlspecialchars($key);
            $tblhead .= <<<eot
<td><a style="color:white;" href="javascript:addfield('$key')">$key</a></td>

eot;
        }
        $out .=  "<td>$value</td>\n";
    }
    $out .= "</tr>\n";
    $i++;
}
$out .= "</table>\n";

$tblhead .= "</tr>\n";

$query = htmlspecialchars($query);
echo <<<eot
<script>
function addfield(a){
    var q = document.getElementById('query');
    q.value += ' `'+ a + '` ';
}
</script>
<form method="post">
<textarea name="query" id="query" cols="60" rows="5">$query</textarea><br/>
<input type="submit" value="继续查询"/>
</form><br/>
查询结果如下(共{$conn->affected_row}条结果, 点击字段名 可加入查询语句) 
<input type="button" onclick="window.location='index.php';" value="返回"/><br/>
eot;
echo $tblhead, $out;

include(APP_ROOT."admin/footer.php");


?>
