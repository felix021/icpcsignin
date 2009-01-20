<?php
include("../inc.php");
?>
<script language="javascript">
function delschool(id, name){
    if(confirm("确定要删除编号为"+id+"的学校"+name+"吗?")){
        window.location = "delschool.php?school_id=" + id;
    }
}
</script>
<?

$school_name = htmlspecialchars($_GET['school_name']);
$isOurSchool = isset($_GET['isOurSchool']) ? "checked" : "";
$isOurCity = isset($_GET['isOurCity']) ? "checked" : "";
$isUniversity = isset($_GET['isUniversity']) ? "checked" : "";
echo <<<eot
<div class="msg" style="margin:25px;text-align:center;">学校管理</div>
<form method="get">
学校名称(中/英文):<input type="text" name="school_name" value="$school_name"/>
<input type="checkbox" name="isOurSchool" $isOurSchool value="1"/>本校
<input type="checkbox" name="isOurCity" $isOurCity value="2"/>本市
<input type="checkbox" name="isUniversity" $isUniversity value="4"/>高校
<input type="submit" value="筛选"/>
</form>
eot;

$query = "SELECT * FROM {tblprefix}_schools WHERE 1 ";
if(isset($_GET['school_name'])){
    unset($isOurSchool);
    unset($isOurCity);
    unset($isUniversity);
    extract($_GET, EXTR_OVERWRITE);
    if(get_magic_quotes_gpc()) 
        $school_name = stripslashes($school_name);
    if(!empty($school_name)) {
        $school_name = $conn->real_escape_string($school_name);
        $query .= " AND (`school_name_cn` LIKE '%$school_name%' "
                 ."   OR `school_name_en` LIKE '%$school_name%')";
    }
    if(isset($isOurSchool)) $query .= " AND (`school_type` & 1 <> 0) ";
    if(isset($isOurCity)) $query .= " AND (`school_type` & 2 <> 0) ";
    if(isset($isUniversity)) $query .= " AND (`school_type` & 4 <> 0) ";
}

echo $query;//exit();
$res = getQuery($conn, $query);

echo <<<eot
<p>符合条件的学校数量: {$conn->affected_rows}</p>
<table align="center">
<tr class="tblhead">
<td>编号</td>
<td>学校名称(中文)</td>
<td>学校名称(英文)</td>
<td>学校类型</td>
<td>操作</td>
</tr>
eot;

$i = 0;
while($row = $res->fetch_assoc()){
    extract($row);
    if($i & 1) $trclass = "tre";
    else $trclass = "tro";
    $i++;
    $isOurSchool = $school_type & 1 ? "checked" : "";
    $isOurCity = $school_type & 2 ? "checked" : "";
    $isUniversity = $school_type & 4 ? "checked" : "";
    echo <<<eot
<form action="updateschool.php" method="post">
<tr class="$trclass">
<td>$school_id<input type="hidden" name="school_id" value="$school_id"/></td>
<td><input type="text" name="school_name_cn" value="$school_name_cn"/></td>
<td><input type="text" name="school_name_en" value="$school_name_en"/></td>
<td>
<input type="checkbox" name="isOurSchool" $isOurSchool value="1"/>本校
<input type="checkbox" name="isOurCity" $isOurCity value="2"/>本市
<input type="checkbox" name="isUniversity" $isUniversity value="4"/>高校
</td>
<td>
<input type="submit" name="modify" value="修改"/>
<input type="button" onclick="javascript:delschool($school_id,'$school_name_cn')" value="删除"/>
</td>
</tr>
</form>
eot;
}

$trclass = $i & 1 ? "tre" : "tro";
echo <<<eot
<form action="updateschool.php" method="post">
<tr class="$trclass">
<td>新增</td>
<td><input type="text" name="school_name_cn"/></td>
<td><input type="text" name="school_name_en"/></td>
<td>
<input type="checkbox" name="isOurSchool" value="1"/>本校
<input type="checkbox" name="isOurCity" value="2"/>本市
<input type="checkbox" name="isUniversity" value="4"/>高校
</td>
<td><input type="submit" name="add" value="新增"/></td>
</tr>
</form>
</table>
eot;

include("../footer.php");

?>
