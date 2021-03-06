<?php
include_once("def.php");
include_once(APP_ROOT."include/header.php");
include_once(APP_ROOT."include/classes.php");
include_once(APP_ROOT."include/config.php");
echo <<<eot
<table width="1024" align="center">
<tr>
<td>
<div id="header">
<img src="images/title.jpg" border="0"/>
    <div id="menu">
        <ul>
<li><a href="index.php">首页</a></li>

eot;

if(!isset($_SESSION['team_id'])){
    echo '<li><a href="index.php?page=register">注册</a></li>';
}else{
    echo '<li><a href="team_logout.php">注销</a></li>';
}

echo <<<eot

<li><a href="index.php?page=intro">竞赛介绍</a></li>
<li><a href="index.php?page=rule">竞赛规则</a></li>
<!-- <li><a href="index.php?page=faq">使用说明</a></li> -->
<li><a href="index.php?page=map">赛场地图</a></li>
<li><a href="index.php?page=hotel">住宿信息</a></li>
<li><a href="http://acm.whu.edu.cn/" target="_blank">whuacm</a></li>
<li><a href="http://acm.whu.edu.cn/woj" target="_blank">WOJ</a></li>
<li><a href="index.php?page=sponsor">关于百度</a></li>

        </ul>
<form style="display:inline" method="get" action="http://www.baidu.com/s">
<input type="hidden" name="ie" value="utf-8"/>
<input type="text" value="" name="word" style="width:150px;"/>
<input type="submit" value="百度一下" style="margin-top:3px;"/>
</form>
    </div>
</div>
<div id="wrapper">
    <div id="mainWrapper">

eot;

if (!isset($_GET['page'])) $_GET['page'] = null;

switch($_GET['page']){
case 'register':
    require_once("team/register.php");
    break;

case 'intro':
    require_once("intro.php");
    break;

case 'rule':
    require_once("rule.php");
    break;

case 'hotel':
    require_once("hotel.php");
    break;

case 'map':
    require_once("map.php");
    break;

case 'faq':
    require_once('faq.php');
    break;

case 'sponsor':
    require_once('sponsor.php');
    break;

case 'team_info':
    require_once('team/teaminfo.php');
    break;

case 'team_member':
    require_once('team/members/members.php');
    break;

case 'team_del':
    require_once('team/unsetteam.php');
    break;

case 'contest_info':
    require_once('team/contestinfo.php');
    break;

case 'article':
default:
    require_once("article.php");    
}


echo <<<eot
        </div>
    </div>

eot;

//右列表
echo <<<eot

    <div style="display: block;" id="sidebar" class="sidebar">
        <div id="innerSidebar">

eot;

$notice = @file_get_contents("include/notice.txt");
echo <<<eot
<div class="textbox">
<div class="textbox-title" style="text-align:center;">公告</div>
<div class="textbox-content">
$notice
</div>
</div>

eot;

if(isset($_SESSION['team_id'])){
    include(APP_ROOT."team_index.php");
}else{
    echo <<<eot
        <div class="textbox">
            <div class="textbox-title">队伍登录</div>
            <div class="textbox-content">
                <form action="login.do.php" method="post" style="display:inline;">
                <table style="display:inline;">
                <tr>
                    <td>队名</td>
                    <td><input type="text" name="team_name" style="width:120px;"/></td>
                </tr>
                <tr>
                    <td>密码</td>
                    <td><input type="password" name="password" style="width:120px;"/></td>
                </tr>
                <tr>
                    <td colspan="2">
                    <input type="submit" value="登陆"/>
                    <a href="index.php?page=register">注册新队伍!</a>
                    </td>
                </tr>
                </table>
                </form>
            </div>
        </div>

eot;
}

$signinbegin = time2str(str2time($signinbegin), "m月d日H:i");
$signinend = time2str(str2time($signinend), "m月d日H:i");
$prebegin = time2str(str2time($prebegin), "m月d日H:i");
$finalbegin = time2str(str2time($finalbegin), "m月d日H:i");
echo <<<eot
<div class="textbox">
<div class="textbox-title">大赛各阶段时间安排</div>
<div class="textbox-content">
<table algin="center" width="200">
<tr><td>报名开始</td><td>{$signinbegin}</td></tr>
<tr><td>报名结束</td><td>{$signinend}</td></tr>
<tr><td>预赛</td><td>{$prebegin}</td></tr>
<tr><td>决赛</td><td>{$finalbegin}</td></tr>
</table>
</div>
</div>

eot;

include(APP_ROOT."include/links.html");

echo <<<eot
        </div>
    </div>
</div>
</td>
</tr>
</table>
<div id="ft">
  <hr size="1" width="979">
  <a href="http://www.whu.edu.cn" tppabs="http://www.whu.edu.cn/" target="_blank"><img border="0" src="images/whu.gif" tppabs="http://acm.whu.edu.cn/08cc/images/whu.gif" alt="武汉大学" width="181" height="50"></a><br>
  Copyright © 2009 ACM/ICPC Association of Wuhan University. All rights reserved.<br>
  Please <a class="link" href="mailto:acm@whu.edu.cn"><u><b>contact us</b></u><b></b></a> if you have any question.<br><br>
</div>
<hr width="1010"/>
<script src="include/hl.js"></script>
<script>
highlighter();
</script>
</center>
</body>
</html>
eot;
?>
