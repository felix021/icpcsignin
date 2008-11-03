<?php
    //包含另一个文件并解析它
    //这个脚本进行一些处理并输出共同的开头的一部分内容
    include("header.php"); 
?>
<p id="title">报名系统后台管理登录</p>
<p>测试用户名为a 密码为a</p>
<form action="login.do.php" method="post">
<table id="logintbl" align="center">
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
        <td colspan="2">
            <input type="submit" class="btn" value="登录"/>
        </td>
    </tr>
</tbody>
</table>
</form>
<?php
    //包含页面底部的一些共同的输出
    include("../include/footer.php");
?>
