<?php
include("../inc.php");

$query = "SELECT COUNT(*) FROM `{tblprefix}_teams` ";

if(!empty($_GET['keyword'])){
    $kw = $conn->real_escape_string($_GET['keyword']);
    $query .= " WHERE `team_name` LIKE '%$kw%' ";
}

if($_GET['school_id'] > 0){
    if(empty($_GET['keyword'])) $query .= " WHERE ";
    else $query .= " AND ";
    $query .= "`school_id`={$_GET['school_id']} ";
}

$res = getQuery($conn, $query);
$row = $res->fetch_array();

$items_per_page = 3;
$teams_c = (int)$row[0];
$pages_c = ceil($teams_c / $items_per_page);

$page = (int)$_GET['page'];
if($page < 1) $page = 1;
else if($page > $pages_c) $page = $pages_c;

$start = ($page - 1) * $items_per_page;

$query = "SELECT * FROM `{tblprefix}_teams` ";
if(!empty($_GET['keyword'])){
    $kw = $conn->real_escape_string($_GET['keyword']);
    $query .= " WHERE `team_name` LIKE '%$kw%' ";
}
if($_GET['school_id'] > 0){
    if(empty($_GET['keyword'])) $query .= " WHERE ";
    else $query .= " AND ";
    $query .= "`school_id`={$_GET['school_id']} ";
}
$query .= "ORDER BY `team_id` LIMIT $start,$items_per_page ";
$res = getQuery($conn, $query);

$keyword = htmlspecialchars($_GET['keyword']);
$keyword_u = urlencode($keyword);
$school_list = select_school($_GET['school_id'], -1, 1);
echo <<<eot
<form method="get">
队名: <input type="text" name="keyword" value="{$keyword}" />
$school_list
<input type="submit" value="按队名筛选" />
<input type="button" value="取消筛选" onclick="javascript:window.location='index.php';"/>
</form>

<div>
[<a href="index.php?keyword=$keyword_u&school_id={$_GET['school_id']}">首页</a>]
eot;
if($page > 1){
    $pre_page = $page - 1;
    echo " [<a href=\"index.php?page=$pre_page&keyword=$keyword_u&school_id={$_GET['school_id']}\">上一页</a>] \n";
}else{
    echo " [上一页] \n";
}

for($i = 1; $i <= $pages_c; $i++){
    if($page == $i)
        echo "[$i] ";
    else
        echo "[<a href=\"index.php?page=$i&keyword=$keyword_u&school_id={$_GET['school_id']}\">$i</a>]\n";
}
if($page < $pages_c){
    $next_page = $page + 1;
    echo " [<a href=\"index.php?page=$next_page&keyword=$keyword_u&school_id={$_GET['school_id']}\">下一页</a>] \n";
}else{
    echo " [下一页] \n";
}
echo "[<a href=\"index.php?page=$pages_c&keyword=$keyword_u&school_id={$_GET['school_id']}\">末页</a>]\n";
echo "共{$pages_c}页{$teams_c}队</div>";

if($teams_c > 0){
    echo <<<eot
<script>
function editTeam(id){
    window.location = "editteam.php?team_id=" + id;
}
function delTeam(id, name){
    if(confirm("确认删除队伍 [" + name + "] 吗?")){
        window.location = "delteam.php?team_id=" + id;
    }
}
</script>
<table>
<tr class="tblhead">
<td>编号</td>
<td>队名</td>
<td>学校</td>
<td>邮箱</td>
<td>预赛</td>
<td>现场</td>
<td>决赛</td>
<td>操作</td>
</tr>
eot;
    $i = 0;
    while($row = $res->fetch_assoc()){
        $trclass = ($i & 1 == 0) ? "tre" : "tro";
        encodeObject($row);
        extract($row, EXTR_OVERWRITE);
        $team_name_slash = htmlspecialchars($team_name);
        $sch = new school($school_id);
        $pre = $pre_rank > 0 ? $pre_rank : "";
        $for_final = $valid_for_final == 1 ? "checked=\"checked\"" : "";
        $final = $final_rank > 0 ? $final_rank : "";
        echo <<<eot
<tr class="$trclass">
<td>$team_id</td>
<td>$team_name</td>
<td>{$sch->school_name_cn}</td>
<td>$email</td>
<td>$pre</td>
<td><input type="checkbox" $for_final/></td>
<td>$final</td>
<td>
<input type="button" value="详细" onclick="javascript:editTeam($team_id);"/>
<input type="button" value="删除" onclick="javascript:delTeam($team_id, '$team_name_slash');"/>
</td>
</tr>

eot;
    }
    echo "</table>\n";
}else{
    echo "<div>无队伍</div>\n";
}


?>
