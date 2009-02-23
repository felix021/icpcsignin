<?php
//文章

$itemsperpage = 5;
$nowtime = time();
$query = "SELECT COUNT(*) FROM `{tblprefix}_articles` WHERE `pub_time` < $nowtime";
$res = getQuery($conn, $query);
$row = $res->fetch_array();
$articles_c = (int)$row[0];

$pages_c = ceil($articles_c / $itemsperpage);
$page = (int)$_GET['page'];

$listbar = get_listbar($page, $articles_c, $itemsperpage, "index.php");
/*
echo <<<eot
<div class="listbar">共{$pages_c}页{$articles_c}篇 $listbar</div>

eot;
 */

$start = ($page - 1) * $itemsperpage;
$query = "SELECT * FROM `{tblprefix}_articles` "
        ."  WHERE `pub_time` < $nowtime"
        ."  ORDER BY `priority` DESC, `pub_time` DESC"
        ."  LIMIT $start, $itemsperpage";
$res = getQuery($conn, $query);

while($row = $res->fetch_assoc()){
    extract($row, EXTR_OVERWRITE);
    $title = htmlspecialchars($title);
    $pubtime = time2str($pub_time, "Y-m-d H:i");
    date_default_timezone_set("PRC");
    if($pub_time > time()) continue; //定时发布文章, 不显示
    if(time() - $pub_time < 3 * 86400) $newsign = '<span style="color:red;">[NEW!]</span>';
    else $newsign = "";
    if($permission == 0 && !isset($_SESSION['team_id']))
        $content = 'Forbidden: 本文需要登陆后才可查看';
    else{
        $content = symbol2value($content);
        switch($content_type){
        case 0: //PLAIN
            $content = htmlspecialchars($content);
            $content = "<pre class=\"pre_content\">$content</pre>";
            break;
        case 1: //HTML
            break;
        case 2: //UBB
        default:
            $content = ubb2html($content);
        }
    }
    echo <<<eot
<div class="textbox">
    <div class="textbox-title">[$pubtime] {$title} $newsign</div>
    <div class="textbox-content">$content</div>
</div>

eot;
}

if($articles_c > 0){
    echo <<<eot
<div class="listbar">共{$pages_c}页{$articles_c}篇 $listbar</div>

eot;
}
//end of articles
?>
