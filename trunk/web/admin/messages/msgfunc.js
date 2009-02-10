function $(id){return document.getElementById(id);}
function readmsg(id, type){
try{
    if(type == 'recv'){
        var read = $(id+'_read');
        if(read != null){
            read.checked = true;
        }
    }
	var viewmsg = parent.document.getElementById('viewmsg');
	viewmsg.src = "viewmessage.php?msg_id=" + id;
    viewmsg.focus();
}catch(e){alert(e);}
}

function reply(msg_id, type, team_id){
try{
    var sendmsg = parent.document.getElementById("sendmsg");
    var msg = sendmsg.contentWindow.document.getElementById('msg');
    var rep_id = sendmsg.contentWindow.document.getElementById('rep_id');
	if(type == 'reply'){
		rep_id.value = msg_id;
		msg.value = "回复" + msg_id + ":\n";
	}else{
		msg.value = "追加" + msg_id + ":\n";
	}
    msg.focus();
}catch(e){alert(e);}
}

function $(id){return document.getElementById(id);}

function getXMLHTTP()
{
    var xmlHttp=null;
    try{
        try{ xmlHttp = new ActiveXObject("Microsoft.XMLHTTP"); }
        catch(e1){ xmlHttp = new ActiveXObject("MSXML2.XMLHTTP");}
    }catch(e2){ xmlHttp=new XMLHttpRequest;}
    return xmlHttp;
}

function delmsg(id){
    if (!confirm("确定删除消息 [" + id + '] 吗?')){
        return;
    }
    var xml = getXMLHTTP();
    if(xml == null){
        alert("您的浏览器不支持Ajax，请使用IE或FireFox");
        return;
    }
    var url = "delmessage.php?msg_id=" + id;
    xml.open("GET", url, true);
    xml.onreadystatechange = function(){
        if(xml.readyState == 4){
            if (xml.status == 200){
                var t = xml.responseText;
                switch(t){
                    case "0":
                        alert("删除成功!");
                        break;
                    case "1":
                        alert("删除失败!");
                        break;
                    case "2":
                        alert("该消息不是发您的, 不能删除!");
                        break;
                    default:
                        alert("未知错误");
                        break;
                }
                window.location.reload();
            }else{
                alert("未知错误");
            }
        }
    }
    xml.send(null);
}
