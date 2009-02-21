<?php
session_start();
ob_start();
$relpath = dirname(__FILE__);
include($relpath."/def.php");

include(APP_ROOT."include/config.php");
if(isset($_POST['password'])){
    extract($_POST, EXTR_SKIP);
    if($password == $adminpass && $vcode == $_SESSION['vcode']){
        $_SESSION['admin'] = true;
        ob_clean();
        header("location: manage.php");
        exit;
    }else{
        if($vcode != $_SESSION['vcode']){
            $msg = "验证码错误";
        }else if($password != $adminpass){
            $msg = "密码错误";
        }else{
            $msg = "莫名其妙的错误";
        }
    }
}

unset($_SESSION['admin']);

echo <<<eot
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>后台登录</title>
<style>
a{color:blue;text-decoration:none;} 
a:hover{color:red;text-decoration:underline;}
body{padding-top:100px;text-align:center;}
td{text-align:center;}
#msg{width:400px; color:red; border:1px solid #ddd;}
#logintbl{
    border:1px solid #00a7dd;
}
</style>
<script language="javascript">
function change(){ 
try{
    var vcode = document.getElementById('vcode');
    vcode.setAttribute('src', 'vcode.php?'+Math.random());
}catch(e){alert(e);}
}
</script>
</head>
<body align="center">
<form method="post" style="display:inline;">
<table align="center" id="logintbl">
<tr><td colspan="2">管理登录</td></tr>
<tr><td colspan="2"> <p id="msg">{$msg}</p> </td></tr>
<tr>
<td width="80">密　码</td>
<td><input type="password" name="password" style="width:200px;"/></td>
</tr>
<tr>
<td>验证码</td>
<td><input type="text" name="vcode" style="width:160px;"/><img id="vcode" src="vcode.php" style="cursor:hand;" onclick="change()"/></td>
</tr>
<tr>
<td colspan="2"><input type="submit" value="登录"/></td>
</tr>
</table>
</form>
</body>
</html>
eot;
?>
