<?php
    include("include/header.php"); 
    include("include/config.php"); 
    include("include/function.php"); 
    $conn = new db_operator($dbhost, $dbuser, $dbpass, $dbname);
    if($conn->errno){ error($conn->error); }
    $info = $conn->fetch_info();
    if($conn->errno){ error($conn->error); }
    foreach($info as &$value){
        $value = htmlspecialchars($value);
    }
?>
<div id="title">我的信息</div>
<?php message($_GET['msg']); ?>
<p><a href="logout.php">退出登录</a></p>
<form action="update.do.php" method="post">
<table id="updatetbl" align="center">
<tbody>
    <tr>
        <td>用户名</td>
        <td><?php echo $info['name']; ?></td>
    </tr>
    <tr>
        <td>旧密码</td>
        <td><input type="password" class="text" id="oldpass" name="oldpass"/></td>
    </tr>
    <tr>
        <td>新密码(不改则留空)</td>
        <td><input type="password" class="text" id="newpass" name="newpass"/></td>
    </tr>
    <tr>
        <td>重复新密码</td>
        <td><input type="password" class="text" id="newpass1" name="newpass1"/></td>
    </tr>
    <tr>
        <td colspan="2">自我介绍<br/>
        <textarea id="description" name="description"><?php
            echo $info['description'];
        ?></textarea>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <input type="submit" class="btn" value="修改"/>
        </td>
    </tr>
</tbody>
</table>
</form>
<?php include("include/footer.php"); ?>
