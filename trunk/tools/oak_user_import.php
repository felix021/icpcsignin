<?php
/*
 * OAK用户导入工具
 *   修改下面的变量，传到服务器的web目录下，浏览器执行即可
 */
$pass = "ooxx"; //本工具的密码
$key = "xxoo"; //oak数据库的密钥
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "123456";
$dbname = "noah";

if($_POST['pass'] != $pass){
    echo <<<eot
<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<form method="post">
pass: <input type="password" name="pass" /><br/>
text: user_id ~ email ~ pass~ nick<br/>
<textarea name="content" style="width:800px;height:480px;"></textarea><br/>
<input type="submit" value="import"/>
</form>

eot;
    exit;
}

$content = $_POST['content'];
if(get_magic_quotes_gpc()) $content = stripslashes($content);
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
$data = split("\n", $content);
$i = 1;
foreach($data as $line){
    $line = trim($line);
    if(empty($line)) continue;
    if(!preg_match("/.*\t.*\t.*\t.*/", $line)){
        msgbox("line {$i} format error: {$line}");
        exit;
    }
    $i++;
}

reset($data);
foreach($data as $line){
    $line = trim($line);
    $team = split("\t", $line);
    foreach($team as &$v){
        $v = $conn->real_escape_string($v);
    }
    $query = <<<eot
INSERT INTO user
(user_id, email, pass, nick) VALUES
('{$team[0]}', '{$team[1]}', AES_ENCRYPT('{$team[2]}', '{$key}'), '{$team[3]}')
eot;
    $conn->query($query);
    if($conn->errno){
        echo "Error importing line: $line<br/>\n";
	echo "--Error info: " . mysqli_error($conn) . "<br/>\n";
    }else{
        $query = <<<eot
INSERT INTO privilege(user_id, rightstr)VALUES('{$team[0]}', 'privatecontest');
eot;
        $conn->query($query);
        echo "Successfully imported line: $line<br/>\n";
    }
}
?>
