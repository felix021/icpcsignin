function $(id){return document.getElementById(id);}
function readmsg(id, type){
    if(type == 'recv'){
        var read = $(id+'_read');
        read.checked = true;
    }
	var viewmsg = parent.document.getElementById('viewmsg');
	viewmsg.src = "viewmessage.php?msg_id=" + id;
    viewmsg.focus();
}
function reply(id){
try{
    var sendmsg = parent.document.getElementById("sendmsg");
    var msg = sendmsg.contentWindow.document.getElementById('msg');
    var to_id = sendmsg.contentWindow.document.getElementById('to_id');
	to_id.value = id;
    msg.value = "回复" + id + ":\n";
    msg.focus();
}catch(e){alert(e);}
}
