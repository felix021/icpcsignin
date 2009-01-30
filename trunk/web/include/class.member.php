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
     * 验证函数 添加用户自定义数据完整性验证
     */
    private function validate(){
        $type = $this->type;
        if($type < 0 || $type > 2){
            $this->error = "人员类型错误";
            return false;
        }
        $a = strlen($this->member_name);
        if($a <= 0){
            $this->error = "姓名(中文)不能为空!";
            return false;
        }
        if($a > 50){
            $this->error = "姓名(中文)太长(50字以内)";
            return false;
        }
        $a = strlen($this->member_name_pinyin);
        if($a <= 0){
            $this->error = "姓名(拼音)不能为空!";
            return false;
        }
        if($a > 50){
            $this->error = "姓名(拼音)太长(50字以内)";
            return false;
        }
        $gender = $this->gender;
        if($gender != 0 && $gender != 1){
            $this->error = "性别选择错误!";
            return false;
        }
        if($this->school_id <= 0){
            $this->error = "请选择学校!";
            return false;
        }
        $a = strlen($this->faculty_major);
        if($a > 50){
            $this->error = "院系/专业 过长(50字以内)";
            return false;
        }
        $a = strlen($this->grade_class);
        if($a > 50){
            $this->error = "年级/班级 过长(50字以内)";
            return false;
        }
        $a = strlen($this->stu_number);
        if($a > 50){
            $this->error = "学号 过长(50字以内)";
            return false;
        }
        $a = strlen($this->email);
        if(!ereg(".+@.+\..+", $this->email)){
            $this->error = "邮箱地址格式错误";
            return false;
        }
        if($a <= 0){
            $this->error = "邮箱不能为空";
            return false;
        }
        if($a > 50){
            $this->error = "邮箱 过长(50字以内)";
            return false;
        }
        $a = strlen($this->contact);
        if($a > 100){
            $this->error = "其他联系方式 过长(100字以内)";
            return false;
        }
        $a = strlen($this->remark);
        if($a > 1000){
            $this->error = "备注过长(1000字以内)";
            return false;
        }

        return true;
    }


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
        if($this->validate() == false){
            $this->errno = 1;
            return false;
        }
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
        if($this->validate() == false){
            $this->errno = 1;
            return false;
        }
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
