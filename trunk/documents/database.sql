CREATE TABLE `schools`(
    `school_id` int NOT NULL primary key auto_increment,
    `school_name_cn` char(50),
    `school_name_en` char(200),
    `school_type` int
);

CREATE TABLE `teams`(
    `team_id` int NOT NULL primary key auto_increment,
    `school_id` int, 
    `team_name` char(50) ,
    `password` char(50) ,
    `vcode` char(10),
    `email` char(50),
    `address` char(100),
    `postcode` char(20),
    `telephone` char(20),
    `contact` char(100),
    `valid_for_final` int DEFAULT 1,  
    `pre_solved` int,
    `pre_penalty` int,
    `pre_rank` int,
    `final_id` int DEFAULT -1,  
    `final_solved` int,
    `final_penalty` int,
    `hotel_id` int DEFAULT -1, 
    `hotel_id1` int DEFAULT -1, 
    `hotel_id2` int DEFAULT -1,  
    `requirement` varchar(1000),
    `remark` varchar(1000)
);

CREATE TABLE `members`(
    `member_id` int NOT NULL primary key auto_increment,
    `type` int,
    `team_id` int,
    `member_name` char(50),
    `member_name_pinyin` char(50),
    `gender` int,
    `school_id` int,  
    `faculty_major` char(50),
    `grade_class` char(50),
    `stu_number` char(50),
    `email` char(50),
    `telephone` char(20),
    `contact` char(100),
    `remark` varchar(1000)
);

CREATE TABLE `articles`(
    `article_id` int primary key auto_increment,
    `pub_time` int,
    `title` char(100),
    `content` text,
    `content_type` int DEFAULT 1, 
    `priority` int DEFAULT 0, 
    `permission` int DEFAULT 1, 
    `views` int DEFAULT 0
);

CREATE TABLE `messages`(
    `message_id` int primary key auto_increment,
    `pub_time` int,
    `from_id` int, 
    `to_id` int, 
    `message_content` varchar(1000),
    `read` int DEFAULT 0, 
    `replied` int DEFAULT 0
);

CREATE TABLE `hotels`(
    `hotel_id` int primary key auto_increment,
    `address` char(50),
    `telephone` char(20),
    `online_map_pos` char(100), 
    `price` varchar(1000),
    `addition` varchar(1000)
);
