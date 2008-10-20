<?php
    include('header.php');
    include('verify.php');
    include('function.php');
    include('../include/function.php');
    include('../include/config.php');
    $conn = new db_operator($dbhost, $dbuser, $dbpass, $dbname);
    $total = $conn->count();
    $pages = ceil($total / $itemsperpage);

    //当前需要显示第几页
    $page = (int) $_GET['page'];
    if($page < 1) $page = 1;
    if($page > $pages) $page = $pages;
    $start = ($page - 1) * $itemsperpage;

    //取得指定页的用户信息
    $res = $conn->fetch_page($start, $itemsperpage);
    if($conn->errno) adminerror($conn->error);
?>
<p id="title">管理首页</p>
<p><a href="../logout.php">退出登录</a></p>
<p id="toolbar">
<a href="manage.php?page=1">首页</a> -
<a href="manage.php?page=<?php echo ($page - 1);?>">上一页</a> -
[当前第<?php echo $page; ?>页] -
<a href="manage.php?page=<?php echo ($page + 1);?>">下一页</a> -
<a href="manage.php?page=<?php echo $pages;?>">末页</a>
</p>
<?php
    if(!empty($_GET['msg'])) message($_GET['msg']);
    if(count($res) == 0){
        message('尚无用户注册');
        include('../include/footer.php');
    }
?>
<script language="javascript">
    function del(id){
        //确认是否删除
        if(confirm('确实要删除id为'+id+'的用户吗?')){
            window.location = "del.php?id="+id;
        }
    }
</script>
<!--用户信息列表-->
<table id="userlist" border="1" align="center">
<tbody>
<tr class="thead">
    <td width="20">id</td>
    <td width="150">用户名</td>
    <td width="300">自我介绍</td>
    <td width="130">操作</td>
</tr>
<?
    $i = 0;
    foreach($res as $userinfo){
        //相邻行的css class不一样
        $tr_class = $i % 2 == 0? 'tr1' : 'tr2';
        $i++;
        foreach($userinfo as &$value){
            $value = htmlspecialchars($value);
        }
        extract($userinfo);
        $description = mb_substr($description, 0, 20, 'utf-8');
        echo <<<eot
<tr class="{$tr_class}">
    <td>{$id}</td>
    <td>{$name}</td>
    <td>{$description}</td>
    <td>
[<a href="details.php?id={$id}">详情</a>] -
[<a href="javascript:del({$id});">删除</a>]
    </td>
</tr>
eot;
    }
?>
</tbody>
</table>
<?php
    include('../include/footer.php');
?>
