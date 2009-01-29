<?php 
    ob_start(); 
    session_start(); 
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style type="text/css">
a{color:blue;text-decoration:none;}
a:hover{color:red;text-decoration:underline;}
.tre{background-color:#eee;}
.tro{background-color:#ddd;}
.tblhead{padding:2px;color:#fff;background-color:#000;}
td{text-align:center; padding:2px;}
fieldset{margin:10px;text-align:left;}
.listbar{text-align:center;margin:5px;}
.listbar a{font-weight:bold;}
#links{margin:0px;margin-left:15px;padding-left:0;}
#links li{margin:0px;}

/****** General Styles ******/
body {
	font-size: 12px;
	font-family: Tahoma, Arial;
	margin: 2px;
	padding: 0px;
	margin-bottom: 10px;
	text-align: center;
}

td, div{
	word-break: break-all;
    font-size:12px;line-height:18px;
}

a{ 
    color:#0022ff;
    text-decoration:none; 
}
a:hover{ 
    color:#cc0000;
    text-decoration:underline; 
}

hr {
	height: 1px;
	border: 0;
	border-top: 1px solid #CCCCCC;
}

/* text box */
.textbox{
    text-align: left;
    margin-bottom: 10px;
    border: 1px solid #00a7dd;
}
.textbox-title{
    text-align: left;
    padding-left:5px;
    padding-bottom:5px;
    height:24px;
    line-height:24px;
    font-size:14px;
    font-weight:bold;
    background:#88c7ff;
    word-wrap: break-all;
    padding-top: 2px;
}
.textbox-title a {
    color: #000;
}
.textbox-content{
    text-align: left;
    margin-bottom:10px;
    line-height:20px;
    padding: 5px;
    font-size:14px;
    word-wrap: break-word;
}

/****** Main Layout Styles ******/

#header{
    text-align:center;
    margin-top:10px;
}
#wrapper {
    float:right;
    margin:0 auto;
    width: 800px;
    /*position: relative;*/
    text-align: left;
}
/* nav menu */
#menu {
    margin-top:5px;
    height:30px;
    line-height:30px;
    font-size:14px;
    font-family:Verdana;
    color:#fff;
    text-align:center;
    font-weight:bold;
    background-color:#00aaff;
}
#menu ul{
margin: 0px;
padding: 0px;
}
#menu li{
list-style: none;
width: 100px;
float: left;
text-align: center;
padding: 0px;
margin: 0px;
border-right: 1px solid #fff; /****************/
}
#menu a{
    color: #fff;
    display: block;
    padding-left: 4px;
    padding-right: 4px;
}
#menu a:hover, #menu .activepage a {
    text-decoration: none;
    background-color: #0070dd;
}

/****** Content Layout ******/
#mainWrapper {
	margin-left: 20px;
	margin-right: 40px;
}
/* sidebar */
.sidebar {
	padding-top: 4px;
	padding-left: 5px;
	float: left;
	width: 210px;
}
#innerSidebar {
	padding: 3px;
}
.code{
    font-family: Courier New, monospace, 宋体;
    font-size: 12px;
    border: 1px dashed #00a7dd;
    border-left: 3px solid #00a7dd;
}
.kw{
    font-size: 14px;
    font-weight: bolder;
    color: #d85343;
}

.quote {
    border:1px solid #00a7dd;
	border-left: 2px solid #00a7dd;
	margin: 10px;
    padding: 5px;
}

</style>
</head>
<body>
<center>

