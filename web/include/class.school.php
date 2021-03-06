<?php
/*
 * 学校表类
 */
class school extends table{
    public $school_id;      //学校编号
    public $school_name_cn; //学校中文名称
    public $school_name_en; //学校英文名称
    public $school_type;    //学校类型, 1=本校|外校 2=本市|外地 4=高校|高中

    public $errno; //是否出错(>0为出错)
    public $error; //错误信息

    /*
     * 构造函数，如果给出一个有效的id, 则从表中读取该学校的信息
     */
    public function __construct($id = -1){ if($id >= 0) $this->getById($id); }

    /*
     * 验证函数 添加用户自定义数据完整性验证
     */
    private function validate(){
        $a = strlen($this->school_name_cn);
        if($a <= 0){
            $this->error = "未输入学校名(中文)";
            return false;
        }
        if($a > 50){
            $this->error = "学校名(中文)过长(50字以内)";
            return false;
        }

        $a = strlen($this->school_name_en);
        if($a <= 0){
            $this->error = "未输入学校名(英文)";
            return false;
        }
        if($a > 200){
            $this->error = "学校名(英文)过长(200字以内)";
            return false;
        }

        return true;
    }

    /*
     * 根据id读取学校信息
     * 若不存在该学校，则返回false
     */
    public function getById($id){
        global $conn;
        $id = (int) $id;
        $query = "SELECT * FROM `{tblprefix}_schools`"
                ." WHERE `school_id`={$id}";
        $res = getQuery($conn, $query);
        if($conn->affected_rows == 0){
            $this->errno = 1;
            $this->error = "No such school";
            return false;
        }else{
            $this->errno = 0;
            $result = $res->fetch_assoc();
            $this->school_id = $result['school_id'];
            $this->school_name_cn = $result['school_name_cn'];
            $this->school_name_en = $result['school_name_en'];
            $this->school_type = $result['school_type'];
            return true;
        }
    }

    /*
     * 从表中删除指定id的学校数据
     */
    public static function delById($id){
        global $conn;
        $id = (int) $id;
        $query = "DELETE FROM `{tblprefix}_schools` WHERE `school_id`={$id}";
        getQuery($conn, $query);
        if($conn->affected_rows == 0){
            return false;
        }else{
            return true;
        }
    }

    /*
     * 设置好学校数据后调用此函数，可将学校数据插入数据库中
     */
    public function insert(){
        global $conn;
        if($this->validate() == false){
            $this->errno = 1;
            return false;
        }
        $school_name_cn = $conn->real_escape_string($this->school_name_cn);
        $school_name_en = $conn->real_escape_string($this->school_name_en);
        $school_type = (int)$this->school_type;
        $query = "INSERT INTO `{tblprefix}_schools` "
                ." (`school_name_cn`, `school_name_en`, `school_type`)"
                ."  VALUES ('$school_name_cn', '$school_name_en', '$school_type')";
        $res = getQuery($conn, $query);
        if($conn->affected_rows == 1){
            $this->errno = 0;
            $this->school_id = $conn->insert_id;
            return true;
        }else{
            $this->errno = 2;
            $this->error = "Error in insert()";
            return false;
        }
    }

    /*
     * 修改学校数据后调用此函数可以更新至数据库
     */
    public function update(){
        global $conn;
        if($this->validate() == false){
            $this->errno = 1;
            return false;
        }
        $school_name_cn = $conn->real_escape_string($this->school_name_cn);
        $school_name_en = $conn->real_escape_string($this->school_name_en);
        $query = "UPDATE `{tblprefix}_schools` SET "
                ."  `school_name_cn`='{$school_name_cn}', "
                ."  `school_name_en`='{$school_name_en}', "
                ."  `school_type`='{$this->school_type}' "
                ." WHERE `school_id`='{$this->school_id}'";
        getQuery($conn, $query);
        $this->errno = 0;
        return true;
    }

    /*
     * 判断学校类型，本校|外校，外地|外地，高校|高中
     */
    public function isOurSchool(){ return ($this->school_type & 1 != 0); }
    public function isOurCity(){ return ($this->school_type & 2 != 0); }
    public function isUniversity(){ return ($this->school_type & 4 != 0); }

    /*
     * 设置学校类型
     */
    public function setOurSchool($set = true) {
        $this->school_type |= 1;
        if(!$set) $this->school_type ^= 1;
    }
    public function setOurCity($set = true) {
        $this->school_type |= 2;
        if(!$set) $this->school_type ^= 2;
    }
    public function setUniversity($set = true) {
        $this->school_type |= 4;
        if(!$set) $this->school_type ^= 4;
    }
    public static function getNameByTeamId($team_id){
        global $conn;
        $t = new team($team_id);
        if($t->errno) msgbox($t->error);
        if($t->school_id == -1){//高中队伍
            $name = "高中队伍";
            $query = "SELECT `school_name_cn` "
                    ."  FROM `{tblprefix}_members` a JOIN `{tblprefix}_schools` b"
                    ."  ON a.`school_id` = b.`school_id`"
                    ."  WHERE a.`team_id`={$t->team_id} AND a.`type`>0"
                    ."  ORDER BY a.`type` DESC";
            $res = getQuery($conn, $query);
            if($conn->affected_rows == 0){
                $name .= "(暂无队员)";
            }else{
                $sch = "(";
                while ($row = $res->fetch_assoc()){
                    $sch .= $row['school_name_cn'] . " ";
                }
                $sch = trim($sch) . ")";
                return ($name . $sch);
            }
            return $name;
        }else{
            $s = new school($t->school_id);
            if($s->errno) msgbox($s->error);
            return $s->school_name_cn;
        }
    }
}
?>
