<?php

include("../inc.php");
include("../verifiedmail.php");

$team_id = (int)$_SESSION['team_id'];
$query = "SELECT * FROM `{tblprefix}_messages`"
        ."  WHERE `to_id`={$team_id}";
$res = getQuery($conn, $query);
$msg_recv = $conn->affected_rows;

if($msg_recv == 0){
    echo <<<eot
<div>暂未收到消息</div>
eot;
}else{
    $itemsperpage = 5;
    $page = (int)$_GET['page'];
    $page_c = ceil($msg_recv / $itemsperpage);
    $listbar = get_listbar($page, $msg_recv, $itemsperpage, "msg_recv.php");
    echo <<<eot
<script src="msgfunc.js"></script>
<div id="listbar">
收到: 共{$page_c}页{$msg_recv}条消息 $listbar
</div>
eot;
    $start = ($page - 1) * $itemsperpage;
    $query = "SELECT * FROM `{tblprefix}_messages`"
            ."  WHERE `to_id`={$team_id}"
            ."  ORDER BY `message_id` DESC"
            ."  LIMIT $start, $itemsperpage";
    $res_send = getQuery($conn, $query);
    echo <<<eot
<div>
<table>
<tr class="tblhead">
<td>编号</td>
<td width="400">内容</td>
<td>时间</td>
<td>状态</td>
</tr>

eot;
    $i = 0;
    while ($row = $res_send->fetch_assoc()){
        $trclass = $i & 1 ? "tre" : "tro";
        encodeObject($row);
        extract($row);
        $message_content = cutstr($message_content);
        $read = $read == 1 ? "checked=\"checked\"" : "";
        $replied = $replied == 1 ? "checked=\"checked\"" : "";
        $pubtime = time2str($pub_time);
        echo <<<eot
<tr class="$trclass">
<td>$message_id</td>
<td class="samewidth">
<a href="#" onclick="javascript:readmsg($message_id, 'recv')">$message_content</a>
</td>
<td>$pubtime</td>
<td>
<input type="checkbox" id="{$message_id}_read" $read disabled/>已读
<input type="checkbox" id="{$message_id}_replied" $replied disabled/>已回复
</td>
</tr>

eot;
    }
    echo "</table></div>\n";
}

include("../../include/footer.php");

?>