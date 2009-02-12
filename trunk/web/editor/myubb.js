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
    if(confirm("是否要指定图像的大小?")){
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


function AddText(myValue) { //From QuickTags
	var myField= $('content');
	//IE support
	if (document.selection) {
		myField.focus();
		sel = document.selection.createRange();
		sel.text = myValue;
		myField.focus();
	}
	//MOZILLA/NETSCAPE support
	else if (myField.selectionStart || myField.selectionStart == '0') {
		var startPos = myField.selectionStart;
		var endPos = myField.selectionEnd;
		var scrollTop = myField.scrollTop;
		myField.value = myField.value.substring(0, startPos)
		              + myValue 
                      + myField.value.substring(endPos, myField.value.length);
		myField.focus();
		myField.selectionStart = startPos + myValue.length;
		myField.selectionEnd = startPos + myValue.length;
		myField.scrollTop = scrollTop;
	} else {
		myField.value += myValue;
		myField.focus();
	}
}

function addsymbol(sym){
    AddText('{'+sym+'}');
}

function hide(id){
    $(id).style.display = "none";
}
function disp(id){
    $(id).style.display = "block";
}
