<?php
include_once("def.php");
include_once(APP_ROOT."include/config.php");
$now = time();
$signin_begin = str2time($signinbegin);
$begin_time = time2str($signin_begin, "Y年m月d日 H时i分");
$signin_end = str2time($signinend);
$end_time = time2str($signin_end, "Y年m月d日 H时i分");

if($now < $signin_begin){
    echo <<<eot
<div class="textbox">
<div class="textbox-title">友情提示</div>
<div class="textbox-content">
报名尚未开始，报名开始时间是：{$begin_time}。
</div>
</div>
eot;
}else if($now > $signin_end){
    echo <<<eot
<div class="textbox">
<div class="textbox-title">友情提示</div>
<div class="textbox-content">
报名已经结束于{$end_time}。
</div>
</div>
eot;
}else{
?>
<script>
function $(id) {return document.getElementById(id);}
function verify(){
    //check for null input
    var submitbtn = $('submitbtn');
    submitbtn.click();
}
function select_other_high(){
    try{
        var other_high = $('other_high');
        if(other_high) other_high.checked = true;
    }catch(e){alert(e);}
}
</script>
<div class="textbox" style="margin-top:8px;">
<div class="textbox-title">队伍注册</div>
<div class="textbox-content">
<form action="team/register.do.php" method="post">
<table class="tblleft" border="0" style="text-align:left;">
<tr>
    <td colspan="2">
        选择队伍类型: 
        <input type="radio" name="team_type" checked="checked" value="1"/>武汉大学队伍 
        <input type="radio" name="team_type" id="other_high" value="2"/>其他高校队伍 
<?php
echo select_school(-1, 2);
?>
        <input type="radio" name="team_type" value="3"/>高中队伍
  (若列表中无贵校请联系管理员)
    </td>
</tr>
<tr>
    <td>队名</td>
    <td><input type="text" name="team_name" /> (50字符以内)</td>
</tr>
<tr>
    <td>密码</td>
    <td><input type="password" name="password"/> (20字符以内；此密码为明文保存，请不要使用常用密码)</td>
</tr>
<tr>
    <td>邮箱</td>
    <td><input type="text" name="email" value=""/> 务必正确填写此邮箱! 系统将向此邮箱发送验证码<br/>
<span style="color:red;font-weight:bold;">请尽量使用gmail, qq, 163, sina邮箱(若未在收件箱，请查看垃圾邮件)。yahoo邮箱无法收到验证邮件。</span>
    </td>
</tr>
<tr>
    <td>电话</td>
    <td><input type="text" name="telephone" value=""/></td>
</tr>
<tr>
    <td>地址</td>
    <td><input type="text" name="address" value=""/></td>
</tr>
<tr>
    <td>邮编</td>
    <td><input type="text" name="postcode" value=""/></td>
</tr>
<tr>
    <td><input type="button" value="注册" onclick="verify()"/></td>
    <td><input type="checkbox" checked="checked" name="valid_for_final"/>若晋级决赛, 可以前往参加(如不确定可先勾选, 并在确定后及时反馈)</td>
</tr>
</table>
<input type="submit" id="submitbtn" style="display:none;" value="确定"/>
</form>
</div>
</div>
<?php
}
?>

<div class="textbox">
<div class="textbox-title">竞赛报名说明</div>
<div class="textbox-content">
<p>
报名时间：<br/>
<?php echo time2str(str2time($signinbegin), "Y年m月d日 H时i分");?> 至
<?php echo time2str(str2time($signinend), "Y年m月d日 H时i分");?>
</p>
<p>
1、报名方法： <br/>
本次赛事报名由专门的报名系统进行操作，请点击注册进行报名注册，如有相关问题请查看<a href="#faq">常见问题</a>，其他问题请联系 whuacm2009@gmail.com 。<br/>
如果觉得组队困难，可以到珞珈山水BBS分类讨论区的国际大学生程序设计竞赛版面发帖；也可加入 “百度杯”竞赛交流QQ群交流，群号码：50077536。
</p>
<p>
2、精美礼品<br/>
本次赛事得到百度公司的大力支持，在报名过程中，如队伍完全符合如下情况：<br/>
a．队伍信息属实并且符合此次赛事规定，要求见3注意事项；<br/>
b．是第1、10、50支报名队伍；<br/>
c．是第整百支报名的队伍，如第100支报名队伍；<br/>
这些队伍每队将获得由百度公司独家提供的精美礼品一份。我们将在报名工作结束后进行寄送。
</p>
<p>
3、注意事项：<br/>
    a. 报名截止时间为2009年3月10日21:00，逾期不再接受报名；<br/>
    b. 报名必须以队为单位，每队人数为1-3人，队伍名称应为英文；<br/>
    c. 每个人至多只能在一个队伍中，若发现报名者违反此原则，立即取消该参赛者所在队伍的参赛资格；<br/>
    d. 队长请保证能经常登陆队伍账号和队伍邮箱，网络预赛所需ID和密码等各种比赛相关通知都将发至队伍邮箱。<br/>
    e. 有问题请联系 whuacm2009@gmail.com，或者联系以下同学：<br/>
       曾同学  15872351119（武测 7-306） 卢同学 15827496377  (武测7-312)
</p>
<p>
4、参赛费用：<br/>
    报名参加本次比赛不需要缴纳任何参赛费用，但是参加决赛需往返武汉的费用及食宿费用需参赛队伍自行解决。建议校外参赛队伍联系队员所在学校报销此部分经费。
</p>

</div>
</div>
<a name="faq"></a>
<div class="textbox">
    <div class="textbox-title">常见问题</div>
    <div class="textbox-content">
<p>
问：学校列表里面没有我所在的学校如何注册？
<br/>
答：请联系 whuacm2009@gmail.com ，发送一封包含学校中文名和英文名的邮件，管理员会将学校添加至列表并回复通知。
</p>
<p>
问：为什么没有收到验证邮件？
<br/>
答：原因可能包括 1. 被识别为垃圾邮件——将 whuacm2009@gmail.com 添加至联系人即可，以免后续邮件被忽略；2. 被邮件服务提供商拒收，如yahoo mail无法收取该邮件。请更换为其他邮件地址，测试显示gmail/qq/163/sina均可收到验证邮件，推荐使用。
</p>
<p>

问：如何跨校组队？
<br/>
答：仅允许高中队伍跨校组队，在注册时队伍选类型择“高中”，之后在添加成员时分别选择相应的学校即可。
</p>
    </div>
</div>

