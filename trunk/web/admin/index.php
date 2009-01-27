<?php
session_start();
ob_start();
include("../include/config.php");
if(isset($_POST['password'])){
    extract($_POST);
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

session_destroy();

echo <<<eot
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>后台登录</title>
<style>a{color:blue;text-decoration:none;} a:hover{color:red;text-decoration:underline;}</style>
<script language="javascript">
function change(){ 
try{
    var vcode = document.getElementById('vcode');
    vcode.setAttribute('src', 'vcode.php?'+Math.random());
}catch(e){alert(e);}
}
</script>
</head>
<body>
<p>{$msg}</p>
<form method="post">
password(123456): <input type="password" name="password" size="8"/><br/>
vcode: <input type="text" name="vcode" size="4"/>
<img id="vcode" src="vcode.php" style="cursor:hand;" onclick="change()"/><br/>
<input type="submit" value="login"/>
</form>
</body>
</html>
eot;
?>
