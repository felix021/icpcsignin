<?php
    $team_id = (int)$_SESSION['team_id'];
    $t = new team($team_id);
    encodeObject($t);
?>
<div class="textbox">
<div class="textbox-title">住宿代订要求 (留空则表示自行处理)</div>
<div class="textbox-content">
<form action="team/savehotel.php" method="post">
<textarea name="requirement" id="requirement" style="width:600px; height:100px;"><?php echo $t->requirement; ?></textarea>
<br/>
<input type="submit" value="修改"/>
</form>
</div>
</div>

<div class="textbox">
<div class="textbox-title">住宿信息</div>
<div class="textbox-content">(暂无)</div>
</div>
