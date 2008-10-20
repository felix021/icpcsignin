DROP TABLE IF EXISTS `info`;
create table `info`(
    `id` int primary key auto_increment, 
    `name` varchar(50), 
    `pass` char(35), 
    `description` varchar(1000) 
)DEFAULT CHARSET=utf8;
