<?php
/*
 * 文章表类
 */
class article extends table{

	public $article_id;	    //文章编号
	public $pub_time;		//发布时间
	public $title;		    //标题
	public $content;		//内容
	public $content_type=0;	//内容类型 0=plain, 1=html
	public $priority = 0;	//优先级
	public $permission = 1;	//访问权限 0=仅登录后可读, 1=开放阅读
	public $views = 0;	    //访问次数

    public $errno; //是否出错(>0为出错)
    public $error; //错误信息

    /*
     * 构造函数，如果给出一个有效的id, 则从表中读取该文章的信息
     */
    public function __construct($id = -1){ if($id >= 0) $this->getById($id); }

    /*
     * 根据id读取文章信息
     * 若不存在该文章，则返回false
     */
    public function getById($id){
        global $conn;
        $id = (int) $id;
        $query = "SELECT * FROM `{tblprefix}_articles`"
                ." WHERE `article_id`={$id}";
        $res = getQuery($conn, $query);
        if($conn->affected_rows == 0){
            $this->errno = 1;
            $this->error = "无效的文章id";
            return false;
        }else{
            $this->errno = 0;
            $result = $res->fetch_assoc();
            $this->article_id	=	$result['article_id'];
            $this->pub_time	    =	$result['pub_time'];
            $this->title    	=	$result['title'];
            $this->content	    =	$result['content'];
            $this->content_type	=	$result['content_type'];
            $this->priority	    =	$result['priority'];
            $this->permission	=	$result['permission'];
            $this->views	    =	$result['views'];
            return true;
        }
    }

    /*
     * 从表中删除指定id的文章数据
     */
    public static function delById($id){
        global $conn;
        $id = (int) $id;
        $query = "DELETE FROM `{tblprefix}_articles` WHERE `article_id`={$id}";
        getQuery($conn, $query);
        if($conn->affected_rows == 0){
            return false;
        }else{
            return true;
        }
    }

    /*
     * 设置好文章数据后调用此函数，可将文章数据插入数据库中
     */
    public function insert(){
        global $conn;
		$pub_time		=	(int)$this->pub_time;
		$title		    =	$conn->real_escape_string($this->title);
		$content		=	$conn->real_escape_string($this->content);
		$content_type	=	(int)$this->content_type;
		$priority		=	(int)$this->priority;
		$permission	    =	(int)$this->permission;
		$views		    =	(int)$this->views;
        $query = "INSERT INTO `{tblprefix}_articles` "
                ."  VALUES (NULL, "
				."  $pub_time, "
				."  '$title', "
				."  '$content', "
				."  $content_type, "
				."  $priority, "
				."  $permission, "
				."  $views) ";
        $res = getQuery($conn, $query);
        if($conn->affected_rows == 1){
            $this->errno = 0;
            $this->article_id = $conn->insert_id;
            $this->getById($this->article_id);
            return true;
        }else{
            $this->errno = 2;
            $this->error = "插入错误";
            return false;
        }
    }

    /*
     * 修改文章数据后调用此函数可以更新至数据库
     */
    public function update(){
        global $conn;
		$article_id	=	(int)$this->article_id;
		$pub_time		=	(int)$this->pub_time;
		$title		    =	$conn->real_escape_string($this->title);
		$content		=	$conn->real_escape_string($this->content);
		$content_type	=	(int)$this->content_type;
		$priority		=	(int)$this->priority;
		$permission	    =	(int)$this->permission;
		$views		    =	(int)$this->views;
        $query = "UPDATE `{tblprefix}_articles` SET "
				."  `pub_time`=$pub_time, "
				."  `title`='$title', "
				."  `content`='$content', "
				."  `content_type`=$content_type, "
				."  `priority`=$priority, "
				."  `permission`=$permission, "
				."  `views`=$views "
                ." WHERE `article_id`='{$this->article_id}'";
        getQuery($conn, $query);
        $this->errno = 0;
        return true;
    }
}
?>
