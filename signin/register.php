<?php include("include/header.php"); ?>
<p id="title">注册</p>
<p><a href="index.php">返回登录页面</a></p>
<form action="register.do.php" method="post">
<table id="registertbl" align="center">
<tbody>
    <tr>
        <td>用户名</td>
        <td><input type="text" class="text" id="username" name="username"/></td>
    </tr>
    <tr>
        <td>密码</td>
        <td><input type="password" class="text" id="password" name="password"/></td>
    </tr>
    <tr>
        <td colspan="2">自我介绍<br/>
        <textarea id="description" name="description"></textarea>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <input type="submit" class="btn" value="注册"/>
        </td>
    </tr>
</tbody>
</table>
</form>
<?php
    include("include/footer.php");
?>
