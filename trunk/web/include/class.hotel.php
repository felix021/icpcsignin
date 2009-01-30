<?php
/*
 * 住宿表类
 */
class hotel extends table{

	public $hotel_id;	    //住宿点编号
	public $address;		//地址
	public $telephone;		//联系方式
	public $online_map_pos;	//在线地图地址
	public $price;		    //价格信息
	public $addition;	    //附加信息

    public $errno; //是否出错(>0为出错)
    public $error; //错误信息

    /*
     * 构造函数，如果给出一个有效的id, 则从表中读取该住宿的信息
     */
    public function __construct($id = -1){ if($id >= 0) $this->getById($id); }


    /*
     * 验证函数 添加用户自定义数据完整性验证
     */
    private function validate(){
        $a = strlen($this->address);
        if($a > 50){
            $this->error = "地址过长(50符以内)";
            return false;
        }
        $a = strlen($this->telephone);
        if($a > 20){
            $this->error = "电话过长(20符以内)";
            return false;
        }
        $a = strlen($this->online_map_pos);
        if($a > 100){
            $this->error = "URL过长(100符以内)";
            return false;
        }
        $a = strlen($this->price);
        if($a > 500){
            $this->error = "地址信息过长(500符以内)";
            return false;
        }
        $a = strlen($this->addition);
        if($a > 500){
            $this->error = "附加信息过长(500符以内)";
            return false;
        }
        return true;
    }


    /*
     * 根据id读取住宿信息
     * 若不存在该住宿，则返回false
     */
    public function getById($id){
        global $conn;
        $id = (int) $id;
        $query = "SELECT * FROM `{tblprefix}_hotels`"
                ." WHERE `hotel_id`={$id}";
        $res = getQuery($conn, $query);
        if($conn->affected_rows == 0){
            $this->errno = 1;
            $this->error = "无效的住宿点id";
            return false;
        }else{
            $this->errno = 0;
            $result = $res->fetch_assoc();
			$this->hotel_id	=	$result['hotel_id'];
			$this->address	=	$result['address'];
			$this->telephone	=	$result['telephone'];
			$this->online_map_pos	=	$result['online_map_pos'];
			$this->price	=	$result['price'];
			$this->addition	=	$result['addition'];
            return true;
        }
    }

    /*
     * 从表中删除指定id的住宿数据
     */
    public static function delById($id){
        global $conn;
        $id = (int) $id;
        $query = "DELETE FROM `{tblprefix}_hotels` WHERE `hotel_id`={$id}";
        getQuery($conn, $query);
        if($conn->affected_rows == 0){
            return false;
        }else{
            return true;
        }
    }

    /*
     * 设置好住宿数据后调用此函数，可将住宿数据插入数据库中
     */
    public function insert(){
        global $conn;
        if($this->validate() == false){
            $this->errno = 1;
            return false;
        }
		$address		=	$conn->real_escape_string($this->address);
		$telephone		=	$conn->real_escape_string($this->telephone);
		$online_map_pos	=	$conn->real_escape_string($this->online_map_pos);
		$price		    =	$conn->real_escape_string($this->price);
		$addition		=	$conn->real_escape_string($this->addition);
        $query = "INSERT INTO `{tblprefix}_hotels` "
                ."  VALUES (NULL, "
				."  '$address', "
				."  '$telephone', "
				."  '$online_map_pos', "
				."  '$price', "
				."  '$addition') ";
        $res = getQuery($conn, $query);
        if($conn->affected_rows == 1){
            $this->errno = 0;
            $this->hotel_id = $conn->insert_id;
            $this->getById($this->hotel_id);
            return true;
        }else{
            $this->errno = 2;
            $this->error = "插入错误";
            return false;
        }
    }

    /*
     * 修改住宿数据后调用此函数可以更新至数据库
     */
    public function update(){
        global $conn;
        if($this->validate() == false){
            $this->errno = 1;
            return false;
        }
		$hotel_id		=	(int)$this->hotel_id;
		$address		=	$conn->real_escape_string($this->address);
		$telephone		=	$conn->real_escape_string($this->telephone);
		$online_map_pos	=	$conn->real_escape_string($this->online_map_pos);
		$price		    =	$conn->real_escape_string($this->price);
		$addition		=	$conn->real_escape_string($this->addition);
        $query = "UPDATE `{tblprefix}_hotels` SET "
				."  `address`='$address', "
				."  `telephone`='$telephone', "
				."  `online_map_pos`='$online_map_pos', "
				."  `price`='$price', "
				."  `addition`='$addition' "
                ." WHERE `hotel_id`='{$this->hotel_id}'";
        getQuery($conn, $query);
        $this->errno = 0;
        return true;
    }
}
?>
