报名系统示例 by Felix021

说明
1. 本系统采用PHP+MySQL
2. 文件编码为utf-8
3. 需要自行创建数据库，数据库结构存为database.sql
4. 配置文件为 include/config.php

详细文件结构

./
    database.sql    数据库结构
    index.php       用户登录页面(表单)
    login.do.php    验证登录
    logout.php      注销
    manage.php      用户自我管理页面
    msg.php         消息/错误显示页面
    register.php    注册页面(表单)
    register.do.php 注册处理页面
    update.do.php   更新用户信息
    readme.txt      就是我了
    
    admin/  管理员目录
        del.php         删除用户
        details.php     用户详细信息
        function.php    管理公用函数库
        header.php      管理页面公共头部
        index.php       管理登录页面(表单)
        login.do.php    管理登录验证
        manage.php      用户列表页面
        verify.php      验证是否是已登录管理员
    
    include/    公共包含文件
        config.php      配置文件
        footer.php      公共页面尾部
        function.php    公共函数
        header.php      公共页面首部
        style.css       样式表
        
