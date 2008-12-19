<?php
/*
 * 成员表类
 */
class member extends table{

	public $member_id;          //成员编号
	public $type;               //成员类型 0=教练 1=队员 2=队长
	public $team_id;            //队伍编号
	public $member_name;        //成员姓名
	public $member_name_pinyin; //姓名的拼音
	public $gender;             //性别
	public $school_id;          //学校编号
	public $faculty_major;      //学院、专业
	public $grade_class;        //年级、班级
	public $stu_number;         //学号
	public $email;              //邮箱
	public $telephone;          //电话
	public $contact;            //其他联系方式
	public $remark;             //备注

    public $errno; //是否出错(>0为出错)
    public $error; //错误信息

    /*
     * 构造函数，如果给出一个有效的id, 则从表中读取该成员的信息
     */
    public function __construct($id = -1){ if($id >= 0) $this->getById($id); }

    /*
     * 根据id读取成员信息
     * 若不存在该成员，则返回false
     */
    public function getById($id){
        global $conn;
        $id = (int) $id;
        $query = "SELECT * FROM `{tblprefix}_members`"
                ." WHERE `member_id`={$id}";
        $res = getQuery($conn, $query);
        if($conn->affected_rows == 0){
            $this->errno = 1;
            $this->error = "无效的成员id";
            return false;
        }else{
            $this->errno = 0;
            $result = $res->fetch_assoc();
			$this->member_id	=	$result['member_id'];
			$this->type	        =	$result['type'];
			$this->team_id	    =	$result['team_id'];
			$this->member_name	=	$result['member_name'];
			$this->member_name_pinyin	=	$result['member_name_pinyin'];
			$this->gender	    =	$result['gender'];
			$this->school_id	=	$result['school_id'];
			$this->faculty_major=	$result['faculty_major'];
			$this->grade_class	=	$result['grade_class'];
			$this->stu_number	=	$result['stu_number'];
			$this->email	    =	$result['email'];
			$this->telephone	=	$result['telephone'];
			$this->contact	    =	$result['contact'];
			$this->remark	    =	$result['remark'];
            return true;
        }
    }

    /*
     * 从表中删除指定id的成员数据
     */
    public static function delById($id){
        global $conn;
        $id = (int) $id;
        $query = "DELETE FROM `{tblprefix}_members` WHERE `member_id`={$id}";
        getQuery($conn, $query);
        if($conn->affected_rows == 0){
            return false;
        }else{
            return true;
        }
    }

    /*
     * 设置好成员数据后调用此函数，可将成员数据插入数据库中
     */
    public function insert(){
        global $conn;
		$member_id	=	(int)$this->member_id;
		$type   	=	(int)$this->type;
		$team_id	=	(int)$this->team_id;
		$member_name=	$conn->real_escape_string($this->member_name);
		$member_name_pinyin	=	$conn->real_escape_string($this->member_name_pinyin);
		$gender	    =	$conn->real_escape_string($this->gender);
		$school_id	=	(int)$this->school_id;
		$faculty_major	=	$conn->real_escape_string($this->faculty_major);
		$grade_class	=	$conn->real_escape_string($this->grade_class);
		$stu_number	=	$conn->real_escape_string($this->stu_number);
		$email	    =	$conn->real_escape_string($this->email);
		$telephone	=	$conn->real_escape_string($this->telephone);
		$contact	=	$conn->real_escape_string($this->contact);
		$remark	    =	$conn->real_escape_string($this->remark);
        $query = "INSERT INTO `{tblprefix}_members` "
                ."  VALUES (NULL, "
				."  $type, "
				."  $team_id, "
				."  '$member_name', "
				."  '$member_name_pinyin', "
				."  $gender, "
				."  $school_id, "
				."  '$faculty_major', "
				."  '$grade_class', "
				."  '$stu_number', "
				."  '$email', "
				."  '$telephone', "
				."  '$contact', "
                ."  '$remark')";
        $res = getQuery($conn, $query);
        if($conn->affected_rows == 1){
            $this->errno = 0;
            $this->member_id = $conn->insert_id;
            $this->getById($this->member_id);
            return true;
        }else{
            $this->errno = 2;
            $this->error = "插入错误";
            return false;
        }
    }

    /*
     * 修改成员数据后调用此函数可以更新至数据库
     */
    public function update(){
        global $conn;
		$member_id	=	(int)$this->member_id;
		$type   	=	(int)$this->type;
		$team_id	=	(int)$this->team_id;
		$member_name=	$conn->real_escape_string($this->member_name);
		$member_name_pinyin	=	$conn->real_escape_string($this->member_name_pinyin);
		$gender	    =	$conn->real_escape_string($this->gender);
		$school_id	=	(int)$this->school_id;
		$faculty_major	=	$conn->real_escape_string($this->faculty_major);
		$grade_class	=	$conn->real_escape_string($this->grade_class);
		$stu_number	=	$conn->real_escape_string($this->stu_number);
		$email	    =	$conn->real_escape_string($this->email);
		$telephone	=	$conn->real_escape_string($this->telephone);
		$contact	=	$conn->real_escape_string($this->contact);
		$remark	    =	$conn->real_escape_string($this->remark);
        $query = "UPDATE `{tblprefix}_members` SET "
				."  `type`=$type, "
				."  `team_id`=$team_id, "
				."  `member_name`='$member_name', "
				."  `member_name_pinyin`='$member_name_pinyin', "
				."  `gender`=$gender, "
				."  `school_id`=$school_id, "
				."  `faculty_major`='$faculty_major', "
				."  `grade_class`='$grade_class', "
				."  `stu_number`='$stu_number', "
				."  `email`='$email', "
				."  `telephone`='$telephone', "
				."  `contact`='$contact', "
				."  `remark`='$remark' "
                ." WHERE `member_id`='{$this->member_id}'";
        getQuery($conn, $query);
        $this->errno = 0;
        return true;
    }
}
?>
