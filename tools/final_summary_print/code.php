<?php
include_once("pc2.php");
$teamid = stripslashes(trim($_POST['teamid']));
$teamid = str_replace("team", "", $teamid);
$password = stripslashes(trim($_POST['password']));
$code = stripslashes($_POST['code']);
if(empty($teamid)) $teamid = "team";
if(!empty($code))
{
    if(!verify($teamid, $password))
    {
        $msg = "登陆ID或密码不正确.\r\n 你输入的是: \"$teamid\" & \"$password\".";
        $password = "";
    }
    else
    {
        $_SESSION['teamid'] = $teamid;
        $_SESSION['password'] = $password;
        if(!file_exists("codes"))@mkdir("codes");
        $filename = "codes/".time()."_$teamid.txt";
        @file_put_contents($filename,"Teamid: ".$teamid."\r\n--------------\r\n\r\n".$code);
        if(file_exists($filename))
        {
            $msg = "代码已经成功提交，稍后我们的工作人员会将代码送至。";
        }
        else
        {
            $msg = "未知错误。若多此错误重复出现多次，请告知工作人员。";
        }
    }
}// end of if(!empty($code))

$teamid = htmlspecialchars($_SESSION['teamid']);
$password = htmlspecialchars($_SESSION['password']);
?>
<script language="javascript">
function submit_code()
{
    var code = document.getElementById("code");
    if(code.value.length < 20){
        alert("代码太短!")
        code.focus();
        return false;
    } else {
        var div_status = document.getElementById("div_status");
        div_status.innerHTML = '<img src="images/loading.gif"/>';
        setTimeout("really_submit()", 1000);
    }
}

function really_submit()
{
    var submitbtn = document.getElementById("submitbtn");
    submitbtn.click();
}
</script>
<p style="text-align:center;font-size:24px">代码打印服务</p>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>?page=code">
<table align="center">
<tr>
    <td>
        登陆ID：
        <input style="width:200px;" type="text" id="teamid" name="teamid" value="<?php echo $teamid;?>"/>
    </td>
    <td>
        初始登陆密码：
        <input value="<?php echo $password;?>" type="password" id="password" name="password" style="width:200px;"/>
    </td>
    <td>
        <input type="button" value="提交打印" class="button" onclick="submit_code()"/>
    </td>
</tr>
</table>
<div style="text-align:center;font-size:14px;color:red" id="div_status"><?php echo $msg;?></div><br/>
<textarea id="code" style="background:url(images/baidubg.jpg);font-family:courier new;width:800px;height:380px;" name="code"></textarea>
<input type="submit" style="display:none;" id="submitbtn"/>
</form>
