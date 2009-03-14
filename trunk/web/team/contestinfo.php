<?php
include_once("def.php");
include_once(APP_ROOT."team/inc.php");
include_once(APP_ROOT."team/verifiedmail.php");

$team_id = (int)$_SESSION['team_id'];
$t = new team($team_id);
if ($t->errno){
    msgbox($t->error);
}

if($t->pre_solved < 0) {
    $pre_solved = "暂缺";
    $pre_penalty = "暂缺";
    $pre_rank = "暂缺";
}else{
    $pre_solved = $t->pre_solved;
    $pre_penalty = int2timestr($t->pre_penalty);
    $pre_rank = $t->pre_rank;
}
if($t->pre_rank < 0) $pre_rank = "暂缺";

if($t->final_solved < 0) {
    $final_solved = "暂缺";
    $final_penalty = "暂缺";
    $final_rank = "暂缺";
}else{
    $final_solved = $t->final_solved;
    $final_penalty = int2timestr($t->final_penalty);
    $final_rank = $t->final_rank;
}
if($t->final_id < 0){
    $final_id = "暂缺";
}else{
    $final_id = $t->final_id;
}
if($t->final_rank < 0) $final_rank = "暂缺";
?>
<div class="textbox">
    <div class="textbox-title">预赛信息</div>
    <div class="textbox-content">
    <table>
    <tr><td class="tdl">开始时间</td><td class="tdr"><?php echo $prebegin;?></td></tr>
    <tr><td class="tdl">预赛题数</td><td class="tdr"><?php echo $pre_solved;?></td></tr>
    <tr><td class="tdl">总罚时</td><td class="tdr"><?php echo $pre_penalty;?></td></tr>
    <tr><td class="tdl">预赛排名</td><td class="tdr"><?php echo $pre_rank;?></td></tr>
    </table>
    </div>
</div>
<div class="textbox">
    <div class="textbox-title">决赛信息</div>
    <div class="textbox-content">
    <table>
    <tr><td class="tdl">开始时间</td><td class="tdr"><?php echo $finalbegin;?></td></tr>
    <tr><td class="tdl">决赛编号</td><td class="tdr"><?php echo $final_id;?></td></tr>
    <tr><td class="tdl">决赛题数</td><td class="tdr"><?php echo $final_solved;?></td></tr>
    <tr><td class="tdl">总罚时</td><td class="tdr"><?php echo $final_penalty;?></td></tr>
    <tr><td class="tdl">决赛排名</td><td class="tdr"><?php echo $final_rank;?></td></tr>
    </table>
    </div>
</div>
