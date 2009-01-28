<?php

if(isset($a)){
    $content = $a->content;

    switch($a->content_type){
    case 0:
        $plain = "checked=\"checked\"";
        $display = "none";
        break;
    case 1:
        $html = "checked=\"checked\"";
        $display = "none";
        break;
    default:
    case 2:
        $ubb = "checked=\"checked\"";
        $display = "block;";
        break;
    }
}else{
    $ubb = "checked=\"checked\"";
    $display = "block;";
}

?>
<style type="text/css">
.actions a{text-decoration:none;}
.actions a:hover{background-color: #8080ff;}
</style>
<script language="javascript">
/*
 * Simple PHP UBB Editor By Felix021 
 * 2009-01-29 @ http://www.felix021.com
 */

var textarea_id = "content";

function $(id){return document.getElementById(id);}

function addtag(tag){ //普通html标签
    add(tag, "", false);
}

function addlink(){ //添加链接
    var sel = "", url = "", newsel = false;
    sel = getSelectedText();
	url = sel;
    if(sel == "") newsel = true;
    if(newsel){
        url = window.prompt("请输入链接地址:", "http://");
        if(url == null) return;
		sel = window.prompt("请输入链接文字:", url);
    }else{
        if(url.substring(0, 3) == "www.")
            url = "http://" + url;
		url = window.prompt("请输入链接地址:", url);
		if(url == null) return;
    }
    if(newsel){
        $(textarea_id).value += '[a href="'+url+'"]'+sel+'[/a]';
    }else{
        add('a', 'href="'+url+'"', false);
    }
}

function addimg(){ //添加图片 
    var url;
    var newurl = false;
    url = getSelectedText();
    if(url == "") newurl = true;
    var property = "";
    if(newurl){
        url = window.prompt("请输入链接:", "http://");
        if(url == null) return;
    }else{
        if(url.substring(0, 3) == "www.")
            url = "http://" + url;
    }
    if(confirm("是否要置顶图像显示的大小?")){
        var width = window.prompt("图像宽度(留空则不指定)", "640");
        if(width != "" && width != null) property += ' width="'+width+'"';
        var height = window.prompt("图像高度(留空则不指定)", "480");
        if(height != "" && height != null) property += ' height="'+height+'"';
    }
    if(newurl){
        $(textarea_id).value += '[img src="'+url+'"'+property+']';
    }else{
        add('img', 'src="'+url+'"'+property, true);
    }
}

function addfontcolor(){
    var name = $('fontname').value;
    var size = $('fontsize').value;
    var color = $('fontcolor').value;
	if(name == "" && size == "" && color == "") return;
    var style = 'style="';
    if(name != "") style += "font-family:" + name + ";";
    if(size != "") style += "font-size:" + size + ";";
    if(color != "") style += "color:" + color + ";";
    style += '"';
    add('span', style);
}

function getSelectedText(){
    if(document.selection){ //IE
        var sel = document.selection;
        var range = sel.createRange();
        if(sel.type == "Text" && range.parentElement().id==textarea_id)
            return range.text;
        else
            return "";
    }else{ //FireFox
        var obj = $(textarea_id);
        var selStart = obj.selectionStart;
        var selEnd = obj.selectionEnd;
        if(selStart == selEnd) return false;
        else return obj.value.substring(selStart, selEnd);
    }
}

function add(tag, property, closetag, encodeHTML){
    if(property != "") property = " " + property;
    if(document.selection){ //IE
        var sel = document.selection;
        var range = sel.createRange();
        if(sel.type == "Text" && range.parentElement().id==textarea_id) {
            text = range.text;
            if(!closetag)
                range.text = "["+tag+property+"]"+text+"[/"+tag+"]";
            else
                range.text = "["+tag+property+"]";
        }
    }else{ //FireFox
        var obj = $(textarea_id);
        var selStart = obj.selectionStart;
        var selEnd = obj.selectionEnd;
        if(selStart == selEnd) return;
        var a = obj.value.substring(0, selStart);
        var b = obj.value.substring(selStart, selEnd);
        var c = obj.value.substring(selEnd, obj.value.length);
        if(!closetag)
            obj.value=a+"["+tag+property+"]"+b+"[/"+tag+"]"+c;
        else
            obj.value=a+"["+tag+property+"]";
    }
}


function hide(id){
    $(id).style.display = "none";
}
function disp(id){
    $(id).style.display = "block";
}

</script>
<div>
内容类型:
<input type="radio" <?php echo $plain;?> onclick="javascript:hide('actions');" name="content_type" value="0">纯文本
<input type="radio" <?php echo $html;?> onclick="javascript:hide('actions');" name="content_type" value="1">HTML代码
<input type="radio" <?php echo $ubb;?> onclick="javascript:disp('actions');" name="content_type" value="2">UBB代码
</div>
<div id="actions" class="actions" style="display:<?php echo $display;?>;">
<a href="javascript:addtag('b');" title="粗体"><img src="imgs/bold.gif" border="0"/></a>
<a href="javascript:addtag('i');" title="斜体"><img src="imgs/italic.gif" border="0"/></a>
<a href="javascript:addtag('u');" title="下划线"><img src="imgs/underline.gif" border="0"/></a>
<a href="javascript:addtag('sup');" title="上标"><img src="imgs/superscript.gif" border="0"/></a>
<a href="javascript:addtag('sub');" title="下标"><img src="imgs/subscript.gif" border="0"/></a>
<a href="javascript:addtag('center');" title="居中"><img src="imgs/center.gif" border="0"/></a>
<a href="javascript:addlink();" title="插入链接"><img src="imgs/link.gif" border="0"/></a>
<a href="javascript:addimg();" title="插入图片"><img src="imgs/img.gif" border="0"/></a>
<a href="javascript:addtag('code');" title="插入代码"><img src="imgs/code.gif" border="0"/></a>
<a href="javascript:addtag('quote');" title="插入引用"><img src="imgs/quote.gif" border="0"/></a>
<select id="fontname">
<option value="" selected>字体</option>
<option value="宋体">宋体</option>
<option value="楷体_GB2312">楷体</option>
<option value="Arial">Arial</option>
<option value="Times New Roman">Times New Roman</option>
<option value="Bookman Old Style">Book Antiqua</option>
<option value="Comic Sans MS">Comic Sans MS</option>
<option value="Courier New">Courier New</option>
</select>
<select id="fontsize">
<option value="" selected>字号</option>
<option value="8px">8px</option>
<option value="10px">10px</option>
<option value="12px">12px</option>
<option value="16px">16px</option>
<option value="24px">24px</option>
<option value="36px">36px</option>
<option value="48px">48px</option>
<option value="60px">60px</option>
</select>
<select id="fontcolor">
<option value="" selected>颜色</option>
<option value="#FF0000" style="color:#FF0000">红</option>
<option value="#008000" style="color:#008000">绿</option>
<option value="#0000FF" style="color:#0000FF">蓝</option>
<option value="#C0C0C0" style="color:#C0C0C0">银</option>
<option value="#DC143C" style="color:#DC143C">深红</option>
<option value="#4169E1" style="color:#4169E1">品蓝</option>
<option value="#B22222" style="color:#B22222">棕</option>
<option value="#8B0000" style="color:#8B0000">暗红</option>
<option value="#800080" style="color:#800080">紫色</option>
</select>
<input type="button" value="字体&颜色属性" onclick="javascript:addfontcolor()"/>
</div>
<textarea name="content" id="content" cols="80" rows="20"><?php echo $content; ?></textarea>
