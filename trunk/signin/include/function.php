<?php
    //输出信息
    function message($msg){
        if(empty($msg)) return;
        $msg = nl2br(htmlspecialchars($msg));
        echo '<p><span class="msg"> '.$msg.' </span></p>';
    }
    //转向错误页面，输出错误信息
    function error($msg){
        ob_clean();
        header("location:msg.php?msg=".urlencode($msg));
        exit;
    }
    //数据库操作类
    class db_operator{
        private $conn; //与数据库的连接资源
        public $id;
        public $errno; //错误号
        public $error; //错误信息

        //构造函数，连接数据库
        function __construct($dbhost, $dbuser, $dbpass, $dbname){
            $this->conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
            if ($this->conn){
                $this->errno = 0; //正确
                return true;
            } else {
                $this->errno = 1;
                $this->error = "连接数据库失败!";
                return false;
            }
        }

        //析构函数，断开与数据库的连接
        function __destruct(){
            $this->conn->close();
        }

        //给出sql，查询结果
        function query($query){
            if(empty($query)){
                $this->errno = 8;
                $this->error = "查询语句为空";
                return false;
            }
            $res = $this->conn->query($query);
            if($this->conn->errno){
                $this->errno = $this->conn->errno;
                $this->error = $this->conn->error;
                return false;
            }
            return $res;
        }

        //查询用户总数
        function count(){
            $query = 'SELECT COUNT(*) AS total FROM `info`';
            $res = $this->conn->query($query);
            if($this->conn->errno){
                $this->errno = $this->conn->errno;
                $this->error = $this->conn->error;
                return false;
            }
            $row = $res->fetch_assoc();
            $this->errno = 0;
            return $row['total'];
        }

        //取得一页的用户信息
        function fetch_page($start = 0, $itemsperpage = 10){
            $start = (int)$start;
            $itemsperpage = (int)$itemsperpage;
            $query = "SELECT * FROM `info` LIMIT {$start}, {$itemsperpage}";
            $res = $this->conn->query($query);
            if($this->conn->errno){
                $this->errno = $this->conn->errno;
                $this->error = $this->conn->error;
                return false;
            }
            $ans = array();
            $i = 0;
            while($row = $res->fetch_assoc()){
                $ans[$i] = $row;
                $i++;
            }
            $this->errno = 0;
            return $ans;
        }

        //验证给出的用户名/密码是否正确
        function verify($username, $password){
            //转码，防范SQL注入攻击
            $username = $this->conn->real_escape_string($username);
            $password = $this->conn->real_escape_string($password);
            //密码加密
            $password = md5($password);
            $query = "SELECT `id` FROM `info`"
                    ." WHERE `name`='{$username}'"
                    ." AND `pass`='{$password}'";
            $res = $this->conn->query($query);
            if($this->conn->affected_rows != 1){
                $this->errno = 2;
                $this->error = '用户名或密码错误!';
                return false;
            }
            $row = $res->fetch_assoc();
            $this->id = $row['id'];
            $_SESSION['id'] = $row['id'];
            $this->errno = 0;
            return true;
        }

        //取得用户信息, id为可选, 如不给出，则id为当前登录用户
        function fetch_info($id = false){
            if($id === false) $id = (int)$_SESSION['id'];
            $query = 'SELECT * FROM `info` WHERE `id`=' . $id;
            $res = $this->conn->query($query);
            if($this->conn->affected_rows != 1){
                $this->errno = 3;
                $this->error = 'id有误!';
                return false;
            }
            $this->errno = 0;
            $row = $res->fetch_assoc();
            return $row;
        }

        //注册用户, 给出用户名/密码/用户描述
        function register($username, $password, $description){
            //转码，防范SQL注入攻击
            $username = $this->conn->real_escape_string($username);
            $password = $this->conn->real_escape_string($password);
            $description = $this->conn->real_escape_string($description);

            $password = md5($password);

            //检测是否有同名用户
            $query = "SELECT `id` FROM `info`"
                    ." WHERE `name`='{$username}'"
                    ." LIMIT 1";
            $res = $this->conn->query($query);
            if($this->conn->affected_rows > 0){
                $this->errno = 4;
                $this->error = "用户名已经存在，请重新选择!";
                return false;
            }

            //建立用户
            $query = "INSERT INTO `info` VALUES"
                ."(NULL, '{$username}', '{$password}', '{$description}')";
            $res = $this->conn->query($query);
            if($this->conn->affected_rows != 1){
                $this->errno = 5;
                $this->error = "建立用户失败!";
                return false;
            }
            $_SESSION['id'] = $this->conn->insert_id;
            $this->errno = 0;
            return true;
        }

        //更新用户信息, 给出id/用户名/密码/用户描述
        function update($id, $oldpass, $newpass, $description){
            //转码，防范SQL注入攻击
            $id = (int) $id;
            if(empty($newpass)) $newpass = $oldpass;
            $username = $this->conn->real_escape_string($username);
            $oldpass = $this->conn->real_escape_string($oldpass);
            $newpass = $this->conn->real_escape_string($newpass);
            $description = $this->conn->real_escape_string($description);

            $oldpass = md5($oldpass);
            $newpass = md5($newpass);

            //检测密码是否正确
            $query = "SELECT `pass` FROM `info`"
                    ." WHERE `id`='{$id}'";
            $res = $this->conn->query($query);
            $row = $res->fetch_assoc();
            if($oldpass != $row['pass']){
                $this->errno = 6;
                $this->error = "密码错误!";
                return false;
            }

            //更新信息
            $query = "UPDATE `info` SET "
                    ."`pass`='{$newpass}', "
                    ."`description`='{$description}' "
                    ." WHERE `id`={$id}";
            //echo $query;exit;
            $res = $this->conn->query($query);
            if($this->conn->affected_rows != 1){
                $this->errno = 7;
                $this->error = "更新出错!";
                return false;
            }
            $this->errno = 0;
            return true;
        }
    }
?>
