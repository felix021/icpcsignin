<?php
    include('header.php');
    include('../include/config.php');
    include('verify.php');
    include('../include/function.php');
    include('function.php');
    $conn = new db_operator($dbhost, $dbuser, $dbpass, $dbname);
    if($conn->errno){ adminerror($conn->error); }
    $id = (int)$_GET['id'];
    $info = $conn->fetch_info($id);
    if($conn->errno){  adminerror($conn->error); }
    foreach($info as &$value){
        $value = htmlspecialchars($value);
    }
?>
<div id="title">用户信息</div>
<?php message($_GET['msg']); ?>
<p><a href="manage.php">返回用户列表</a></p>
<table id="userinfo" align="center">
<tbody>
    <tr>
        <td width="100px">id</td>
        <td><?php echo $info['id']; ?></td>
    </tr>
    <tr>
        <td>用户名</td>
        <td><?php echo $info['name']; ?></td>
    </tr>
    <tr>
        <td colspan="2">自我介绍<br/>
        <textarea id="description" name="description"><?php
            echo $info['description'];
        ?></textarea>
        </td>
    </tr>
</tbody>
</table>
<?php include("../include/footer.php"); ?>
