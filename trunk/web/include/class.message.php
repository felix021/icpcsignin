<?php
/*
 * 消息表类
 */
class message extends table{

	public $message_id;	    //消息编号
	public $pub_time;		//发布时间
	public $from_id;		//发送者id, -1表示管理员
	public $to_id;		    //接收者id, -1表示管理员，-2表示所有队伍
	public $message_content;//消息内容
	public $read = 0;	    //已经阅读
	public $replied = 0;	//已经回复

    public $errno; //是否出错(>0为出错)
    public $error; //错误信息

    /*
     * 构造函数，如果给出一个有效的id, 则从表中读取该消息的信息
     */
    public function __construct($id = -1){ if($id >= 0) $this->getById($id); }

    /*
     * 验证函数 添加用户自定义数据完整性验证
     */
    private function validate(){
        $a = $this->from_id;
        if($a < -1) {
            $this->error = "错误的发送者编号";
            return false;
        }
        $a = $this->to_id;
        if($a < -2) {
            $this->error = "错误的接收者编号";
            return false;
        }
        $a = strlen($this->message_content);
        if($a <= 0){
            $this->error = "未输入消息内容";
            return false;
        }
        if($a > 1000){
            $this->error = "消息内容过长(1000字以内)";
            return false;
        }

        return true;
    }


    /*
     * 根据id读取消息信息
     * 若不存在该消息，则返回false
     */
    public function getById($id){
        global $conn;
        $id = (int) $id;
        $query = "SELECT * FROM `{tblprefix}_messages`"
                ." WHERE `message_id`={$id}";
        $res = getQuery($conn, $query);
        if($conn->affected_rows == 0){
            $this->errno = 1;
            $this->error = "无效的消息id";
            return false;
        }else{
            $this->errno = 0;
            $result = $res->fetch_assoc();
			$this->message_id	=	$result['message_id'];
			$this->pub_time	=	$result['pub_time'];
			$this->from_id	=	$result['from_id'];
			$this->to_id	=	$result['to_id'];
			$this->message_content	=	$result['message_content'];
			$this->read	    =	$result['read'];
			$this->replied	=	$result['replied'];
            return true;
        }
    }

    /*
     * 从表中删除指定id的消息数据
     */
    public static function delById($id){
        global $conn;
        $id = (int) $id;
        $query = "DELETE FROM `{tblprefix}_messages` WHERE `message_id`={$id}";
        getQuery($conn, $query);
        if($conn->affected_rows == 0){
            return false;
        }else{
            return true;
        }
    }

    /*
     * 设置好消息数据后调用此函数，可将消息数据插入数据库中
     */
    public function insert(){
        global $conn;
        if($this->validate() == false){
            $this->errno = 1;
            return false;
        }
		$pub_time	=	(int)$this->pub_time;
		$from_id	=	(int)$this->from_id;
		$to_id		=	(int)$this->to_id;
		$message_content	=	$conn->real_escape_string($this->message_content);
		$read		=	(int)$this->read;
		$replied	=	(int)$this->replied;
        $query = "INSERT INTO `{tblprefix}_messages` "
                ."  VALUES (NULL, "
				."  $pub_time, "
				."  $from_id, "
				."  $to_id, "
				."  '$message_content', "
				."  $read, "
				."  $replied) ";
        $res = getQuery($conn, $query);
        if($conn->affected_rows == 1){
            $this->errno = 0;
            $this->message_id = $conn->insert_id;
            $this->getById($this->message_id);
            return true;
        }else{
            $this->errno = 2;
            $this->error = "插入错误";
            return false;
        }
    }

    /*
     * 修改消息数据后调用此函数可以更新至数据库
     */
    public function update(){
        global $conn;
        if($this->validate() == false){
            $this->errno = 1;
            return false;
        }
		$message_id	=	(int)$this->message_id;
		$pub_time	=	(int)$this->pub_time;
		$from_id	=	(int)$this->from_id;
		$to_id		=	(int)$this->to_id;
		$message_content	=	$conn->real_escape_string($this->message_content);
		$read		=	(int)$this->read;
		$replied	=	(int)$this->replied;
        $query = "UPDATE `{tblprefix}_messages` SET "
				."  `pub_time`=$pub_time, "
				."  `from_id`=$from_id, "
				."  `to_id`=$to_id, "
				."  `message_content`='$message_content', "
				."  `read`=$read, "
				."  `replied`=$replied "
                ." WHERE `message_id`='{$this->message_id}'";
        getQuery($conn, $query);
        $this->errno = 0;
        return true;
    }

    public function teamsend($team_id, $content){
        $this->pub_time = time();
        $this->from_id = $team_id;
        $this->to_id = -1;
        $this->message_content = $content;
        $this->read = 0;
        $this->replied = 0;
        return $this->insert();
    }

    public function adminsend($team_id, $content){
        $this->pub_time = time();
        $this->from_id = -1;
        $this->to_id = $team_id;
        $this->message_content = $content;
        $this->read = 0;
        $this->replied = 0;
        return $this->insert();
    }

    public static function process($content){
        $pattern = array(
            "/回复(\\d+?):/is",
            "/追加(\\d+?):/is"
        );
        $replace = array(
            "回复<a href=\"javascript:readmsg(\\1,'send')\"><b>\\1</b></a>:",
            "追加<a href=\"javascript:readmsg(\\1,'recv')\"><b>\\1</b></a>:"
        );
        $t = preg_replace($pattern, $replace, $content);
        return $t;
    }
}
?>
