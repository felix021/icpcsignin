<?php
$relpath = dirname(__FILE__);
include($relpath."/def.php");

include(APP_ROOT."admin/inc.php");

$itemsperpage = 5;

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

$teams_c = (int)$row[0];
$pages_c = ceil($teams_c / $itemsperpage);

$page = (int)$_GET['page'];

if($page < 1) $page = 1;
else if($page > $pages_c) $page = $pages_c;

$start = ($page - 1) * $itemsperpage;

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
$query .= "ORDER BY `team_id` LIMIT $start,$itemsperpage ";
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

eot;

echo "<div>共{$pages_c}页{$teams_c}队 ";
echo get_listbar($page, $teams_c, $itemsperpage, "index.php", "keyword=$keyword_u&school_id={$_GET['school_id']}&");
echo "</div>\n";

if($teams_c > 0){
    echo <<<eot
<script>
function editTeam(id){
    window.location = "editteam.php?team_id=" + id;
}
function editMembers(id){
    window.location = "editmembers.php?team_id=" + id;
}
function delTeam(id, name){
    if(confirm("确认删除队伍 [" + name + "] 吗?")){
        window.location = "delteam.php?team_id=" + id;
    }
}
function email(id){
    window.location = "sendmail.php?team_id="+id;
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
        if($school_id == -1) $school_name = "高中队伍";
        else {
            $sch = new school($school_id);
            $school_name = $sch->school_name_cn;
        }
        $school_name = htmlspecialchars($school_name);
        $pre = $pre_rank > 0 ? $pre_rank : "-";
        $for_final = $valid_for_final == 1 ? "Y" : "N";
        $final = $final_rank > 0 ? $final_rank : "-";
        $team_name_slash = str_replace("'", "\\'", $team_name);
        echo <<<eot
<tr class="$trclass">
<td>$team_id</td>
<td>$team_name</td>
<td>$school_name</td>
<td>$email</td>
<td>$pre</td>
<td>$for_final</td>
<td>$final</td>
<td>
<input type="button" value="详细" onclick="javascript:editTeam($team_id);"/>
<input type="button" value="成员" onclick="javascript:editMembers($team_id);"/>
<input type="button" value="发送邮件" onclick="javascript:email($team_id);"/>
<input type="button" value="删除" onclick="javascript:delTeam($team_id, '$team_name_slash');"/>
</td>
</tr>

eot;
    }
    echo "</table>\n";
}else{
    echo "<div>无队伍</div>\n";
}

include(APP_ROOT."admin/footer.php");
?>
