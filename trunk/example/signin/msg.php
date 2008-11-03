<?php
    include("include/header.php");
    $msg = nl2br(htmlspecialchars($_GET['msg']));
?>
<p id="title">操作结果</p>
<div id="msgmsg">
<p><?php echo $msg; ?></p>
<p><input type="button" class="btn" value="点击返回"
 onclick="javascript:history.back(1);"/>
</p>
</div>
<?php
    include("include/footer.php");
?>
