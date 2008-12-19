武汉大学ACM/ICPC协会
华中北区程序设计邀请赛
赛事主页兼报名系统

安装说明

首先应安装好 Apache + MySQL + PHP
推荐Apache 2.2+ & MySQL 5.0+ & PHP 5.2+
其中PHP安装中应保证已经开启以下库:
    gb2
    mbstring
    mysql
    mysqli
magic_quote_gpc 选项最好为 On (默认值)

默认的配置为:
数据库参数:
    主机: locahost
    用户名: root
    密码: 123456
    数据库名: signin
    管理员密码: 123456
其余参数不一一列出

创建一个MySQL数据库; 也可以使用已经创建好的的其他库。
将修改apache的配置文件，增加一个alias signin到web目录
或者直接将web目录复制到网站根目录(假设重命名为signin)
打开浏览器，运行 http://localhost/signin/admin/install.php
如果提示"Please remove lock.txt first"
请先自行删除signin/admin/lock.txt文件然后再运行该脚本
(该文件是为了防止未授权用户再次使用install.php重置系统)
在此，假设已经可以看到安装界面
填入所需的正确信息，点击确定，脚本将自动创建数据库结构
点击"管理员登录"连接即可进入后台管理首页登录，以进行管理。

To be continued...

--------
本系统大致结构为

./
    documents/  存放文档
        requirements/   需求文档
        README.txt      就是我了 :)
        database.txt    数据库结构说明
        database.sql    数据库结构(SQL语句形式)

    web/        存放脚本
        index.php       首页

        admin/          后台管理代码
            install.php     安装脚本
            index.php       登录脚本

        include/        被包含代码
            header.php      共用网页首部
            footer.php      共用网页页脚
            style.css       共用网页样式表
            config.php      配置文件
            classes.php     包含所有的函数、以及以下各类
                class.school.php    school类
                class.team.php      team类
                class.member.php    member类
                class.article.php   article类
                class.message.php   message类
                class.hotel.php     hotel类

    example/    为项目组成员编写的简单示例，可忽略
        login/      一个简单的登录系统
        signin/     一个简单的注册系统(数据库)
