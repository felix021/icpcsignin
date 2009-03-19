<?php
/*
 * 队伍表类
 */
class team extends table{
    public $team_id;        //队伍编号
    public $school_id;      //学校编号
    public $team_name;      //队伍名称
    public $password;       //密码
    public $vcode;          //验证码

    public $email;          //邮箱
    public $address;        //地址
    public $postcode;       //邮编
    public $telephone;      //电话
    public $contact;        //其他联系方式

    public $valid_for_final = 1;//能否参加决赛
    public $pre_solved = -1;     //预赛出题数
    public $pre_penalty = -1;    //预赛罚时
    public $pre_rank = -1;       //决赛排名

    public $final_id = -1;       //决赛编号
    public $final_solved  = -1;  //决赛出题数
    public $final_penalty = -1;  //决赛罚时
    public $final_rank = -1;     //决赛排名

    public $hotel_id = -1;  //住宿点
    public $hotel_id1 = -1; //首选注册点
    public $hotel_id2 = -1; //备选注册点
    public $requirement;    //附加要求

    public $remark;         //备注

    public $errno; //是否出错(>0为出错)
    public $error; //错误信息

    /*
     * 构造函数，如果给出一个有效的id, 则从表中读取该队伍的信息
     */
    public function __construct($id = -1){ if($id >= 0) $this->getById($id); }

    /*
     * 验证函数 添加用户自定义数据完整性验证
     */
    private function validate(){
        if($this->school_id < -1) {
            $this->error = "错误的学校编号!";
            return false;
        }
        $a = strlen($this->team_name);
        if($a <= 0){
            $this->error = "队名不能为空";
            return false;
        }
        if($a > 50){
            $this->error = "队名过长(50字以内)";
            return false;
        }
        $a = strlen($this->password);
        if($a <= 0){
            $this->error = "密码不能为空";
            return false;
        }
        if($a > 20){
            $this->error = "密码过长(20字以内)";
            return false;
        }
        if(strlen($this->vcode) > 10) 
            $this->vode = substr($this->vcode, 0, 6);
        $email = $this->email;
        if(!ereg(".+@.+\..+", $email)){
            $this->error = "邮箱地址格式错误";
            return false;
        }else if(strlen($email) > 50){
            $this->error = "邮箱地址太长(50字以内)";
            return false;
        }else if($email == ""){
            $this->error = "邮箱不能为空";
            return false;
        }
        $telephone = $this->telephone;
        if(strlen($telephone) > 20){
            $this->error = "电话太长(20字以内)";
            return false;
        }else if($telephone == ""){
            $this->error = "请填写电话";
            return false;
        }
        if(strlen($this->address) > 100){
            $this->error = "地址太长(100字以内)";
            return false;
        }else if($this->address == ""){
            $this->error = "请填写地址";
            return false;
        }
        if(strlen($this->postcode) > 20){
            $this->error = "邮编太长(20字符以内)";
            return false;
        }else if($this->postcode == ""){
            $this->error = "请填写邮编";
            return false;
        }
        $a = strlen($this->contact);
        if($a > 100){
            $this->error = "其他联系方式 过长(100字以内)";
            return false;
        }
        $a = strlen($this->requirement);
        if($a > 1000){
            $this->error = "住宿要求 过长(1000字以内)";
            return false;
        }
        $a = strlen($this->remark);
        if($a > 1000){
            $this->error = "队伍备注 过长(1000字以内)";
            return false;
        }

        return true;
    }


    /*
     * 根据id读取队伍信息
     * 若不存在该队伍，则返回false
     */
    public function getById($id){
        global $conn;
        $id = (int) $id;
        $query = "SELECT * FROM `{tblprefix}_teams`"
                ." WHERE `team_id`={$id}";
        $res = getQuery($conn, $query);
        if($conn->affected_rows == 0){
            $this->errno = 1;
            $this->error = "无效的队伍id";
            return false;
        }else{
            $this->errno = 0;
            $result = $res->fetch_assoc();
            $this->team_id	    =	$result['team_id'];        
            $this->school_id	=	$result['school_id'];      
            $this->team_name	=	$result['team_name'];      
            $this->password	    =	$result['password'];      
            $this->vcode	    =	$result['vcode'];          
            $this->email	    =	$result['email'];          
            $this->address	    =	$result['address'];        
            $this->postcode	    =	$result['postcode'];       
            $this->telephone	=	$result['telephone'];      
            $this->contact	    =	$result['contact'];        
            $this->valid_for_final	=	$result['valid_for_final'];
            $this->pre_solved	=	$result['pre_solved'];     
            $this->pre_penalty	=	$result['pre_penalty'];    
            $this->pre_rank	    =	$result['pre_rank'];       
            $this->final_id	    =	$result['final_id'];       
            $this->final_solved	=	$result['final_solved'];   
            $this->final_penalty=	$result['final_penalty'];  
            $this->final_rank	=	$result['final_rank'];       
            $this->hotel_id	    =	$result['hotel_id'];       
            $this->hotel_id1	=	$result['hotel_id1'];      
            $this->hotel_id2	=	$result['hotel_id2'];      
            $this->requirement	=	$result['requirement'];    
            $this->remark	    =	$result['remark'];         
            return true;
        }
    }

    /*
     * 从表中删除指定id的队伍数据
     */
    public static function delById($id){
        global $conn;
        $id = (int) $id;
        $query = "DELETE FROM `{tblprefix}_teams` WHERE `team_id`={$id}";
        getQuery($conn, $query);
        if($conn->affected_rows == 0){
            return false;
        }else{
            $query = "DELETE FROM `{tblprefix}_messages` WHERE `to_id`={$id} OR `from_id`={$id}";
            getQuery($conn, $query);
            $query = "DELETE FROM `{tblprefix}_members` WHERE `team_id`={$id}";
            getQuery($conn, $query);
            return true;
        }
    }

    /*
     * 生成指定长度的随机数字串作为队伍的验证码
     */
    private function rndstr($length = 4){
        while($length--) $str .= (rand() % 10);
        return $str;
    }

    /*
     * 设置好队伍数据后调用此函数，可将队伍数据插入数据库中
     */
    public function insert(){
        global $conn;
        if($this->validate() == false){
            $this->errno = 1;
            return false;
        }
        $team_name = $conn->real_escape_string(preg_quote($this->team_name));
        $query = "SELECT `team_id` FROM `{tblprefix}_teams`"
                ." WHERE `team_name` REGEXP '^$team_name$'";
        getQuery($conn, $query);
        if($conn->affected_rows != 0){
            $this->errno = 2;
            $this->error = "队名已经存在";
            return false;
        }
        $school_id	=	(int)$this->school_id;      
        $team_name	=	$conn->real_escape_string($this->team_name);      
        $password	=	$conn->real_escape_string($this->password);      
        $this->vcode=   $this->rndstr(6); //生成随机验证码
        $vcode	    =	$conn->real_escape_string($this->vcode);          
        $email	    =	$conn->real_escape_string($this->email);          
        $address	=	$conn->real_escape_string($this->address);        
        $postcode	=	$conn->real_escape_string($this->postcode);       
        $telephone	=	$conn->real_escape_string($this->telephone);      
        $contact	=	$conn->real_escape_string($this->contact);        
        $valid_for_final	=	(int)$this->valid_for_final;
        $pre_solved	=	(int)$this->pre_solved;	
        $pre_penalty=	(int)$this->pre_penalty;
        $pre_rank	=	(int)$this->pre_rank;	
        $final_id	=	(int)$this->final_id;	
        $final_solved	=	(int)$this->final_solved;	
        $final_penalty	=	(int)$this->final_penalty;  
        $final_rank	=	(int)$this->final_rank;	
        $hotel_id	=	(int)$this->hotel_id;	
        $hotel_id1	=	(int)$this->hotel_id1;	
        $hotel_id2	=	(int)$this->hotel_id2;	
        $requirement=	""; //$conn->real_escape_string($this->requirement);    
        $remark	    =	$conn->real_escape_string($this->remark);         
        $query = "INSERT INTO `{tblprefix}_teams` "
                ."  VALUES (NULL, "
                ."  $school_id, "
                ."  '$team_name', "
                ."  '$password', "
                ."  '$vcode', "
                ."  '$email', "
                ."  '$address', "
                ."  '$postcode', "
                ."  '$telephone', "
                ."  '$contact', "
                ."  $valid_for_final, "
                ."  $pre_solved, "
                ."  $pre_penalty, "
                ."  $pre_rank, "
                ."  $final_id, "
                ."  $final_solved, "
                ."  $final_penalty, "
                ."  $final_rank, "
                ."  $hotel_id, "
                ."  $hotel_id1, "
                ."  $hotel_id2, "
                ."  '$requirement', "
                ."  '$remark')";
        $res = getQuery($conn, $query);
        if($conn->affected_rows == 1){
            $this->errno = 0;
            $this->team_id = $conn->insert_id;
            $this->getById($this->team_id);
            return true;
        }else{
            $this->errno = 2;
            $this->error = "插入错误";
            return false;
        }
    }

    /*
     * 修改队伍数据后调用此函数可以更新至数据库
     */
    public function update(){
        global $conn;
        if($this->validate() == false){
            $this->errno = 1;
            return false;
        }
        $school_id	=	(int)$this->school_id;      
        $team_name	=	$conn->real_escape_string($this->team_name);      
        $password	=	$conn->real_escape_string($this->password);      
        $vcode	    =	$conn->real_escape_string($this->vcode);          
        $email	    =	$conn->real_escape_string($this->email);          
        $address	=	$conn->real_escape_string($this->address);        
        $postcode	=	$conn->real_escape_string($this->postcode);       
        $telephone	=	$conn->real_escape_string($this->telephone);      
        $contact	=	$conn->real_escape_string($this->contact);        
        $valid_for_final	=	(int)$this->valid_for_final;
        $pre_solved	=	(int)$this->pre_solved;     
        $pre_penalty=	(int)$this->pre_penalty;    
        $pre_rank	=	(int)$this->pre_rank;       
        $final_id	=	(int)$this->final_id;       
        $final_solved	=	(int)$this->final_solved;   
        $final_penalty  =	(int)$this->final_penalty;  
        $final_rank	=	(int)$this->final_rank;       
        $hotel_id	=	(int)$this->hotel_id;       
        $hotel_id1	=	(int)$this->hotel_id1;      
        $hotel_id2	=	(int)$this->hotel_id2;      
        $requirement=	$conn->real_escape_string($this->requirement);    
        $remark	    =	$conn->real_escape_string($this->remark);         
        $query = "UPDATE `{tblprefix}_teams` SET "
                ."  `school_id`=$school_id, "
                ."  `team_name`='$team_name', "
                ."  `password`='$password', "
                ."  `vcode`='$vcode', "
                ."  `email`='$email', "
                ."  `address`='$address', "
                ."  `postcode`='$postcode', "
                ."  `telephone`='$telephone', "
                ."  `contact`='$contact', "
                ."  `valid_for_final`=$valid_for_final, "
                ."  `pre_solved`=$pre_solved, "
                ."  `pre_penalty`=$pre_penalty, "
                ."  `pre_rank`=$pre_rank, "
                ."  `final_id`=$final_id, "
                ."  `final_solved`=$final_solved, "
                ."  `final_penalty`=$final_penalty, "
                ."  `final_rank`=$final_rank, "
                ."  `hotel_id`=$hotel_id, "
                ."  `hotel_id1`=$hotel_id1, "
                ."  `hotel_id2`=$hotel_id2, "
                ."  `requirement`='$requirement', "
                ."  `remark`='$remark' "
                ." WHERE `team_id`='{$this->team_id}'";
        getQuery($conn, $query);
        $this->errno = 0;
        return true;
    }
}
?>
