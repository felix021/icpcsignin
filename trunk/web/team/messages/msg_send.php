<?php
$relpath = dirname(__FILE__);
include($relpath."/def.php");

include(APP_ROOT."team/inc.php");
include(APP_ROOT."team/verifiedmail.php");

$team_id = (int)$_SESSION['team_id'];
$query = "SELECT * FROM `{tblprefix}_messages`"
        ."  WHERE `from_id`={$team_id}";
$res = getQuery($conn, $query);
$msg_send = $conn->affected_rows;

if($msg_send == 0){
    echo <<<eot
<div>暂未发出消息</div>
eot;
}else{
    $itemsperpage = 5;
    $page = (int)$_GET['page'];
    $page_c = ceil($msg_send / $itemsperpage);
    $listbar = get_listbar($page, $msg_send, $itemsperpage, "msg_send.php");
    echo <<<eot
<script src="msgfunc.js"></script>
<div>发出: 共{$page_c}页{$msg_send}条消息 $listbar</div>
eot;
    $start = ($page - 1) * $itemsperpage;
    $query = "SELECT * FROM `{tblprefix}_messages`"
            ."  WHERE `from_id`={$team_id}"
            ."  ORDER BY `message_id` DESC"
            ."  LIMIT $start, $itemsperpage";
    $res_send = getQuery($conn, $query);
    echo <<<eot
<div>
<table>
<tr class="tblhead">
<td>编号</td>
<td>时间</td>
<td width="400">内容</td>
<td>状态</td>
<td>操作</td>
</tr>

eot;
    $i = 0;
    while ($row = $res_send->fetch_assoc()){
        $trclass = $i++ & 1 ? "tre" : "tro";
        encodeObject($row);
        extract($row);
        $message_content = cutstr($message_content);
        $read = $read == 1 ? "checked=\"checked\"" : "";
        $replied = $replied == 1 ? "checked=\"checked\"" : "";
        $pubtime = time2str($pub_time);
        $content = message::process($message_content);
        echo <<<eot
<tr class="$trclass">
<td>$message_id</td>
<td>$pubtime</td>
<td class="samewidth">$content</td>
<td>
<input type="checkbox" id="{$message_id}_read" $read disabled/>已读
<input type="checkbox" id="{$message_id}_replied" $checked disabled/>已回复
</td>
<td>
<input type="button" value="查看" onclick="javascript:readmsg($message_id, 'send')"/>
<input type="button" value="删除" onclick="javascript:delmsg($message_id)"/>
</td>
</tr>

eot;
    }
    echo "</table></div>\n";
}

include(APP_ROOT."include/footer.php");

?>
