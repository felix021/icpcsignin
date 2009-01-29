var isIE = navigator.userAgent.indexOf("MSIE") >= 0 ? true : false;
var keywords = Array(
        "include", "if", "define", "for", "while",
        "switch", "case", "do", "else", "struct",
        "class", "public", "private", "import",
        "default", "int", "long", "char", "unsigned",
        "short", "string", "float", "double", "typedef",
        "return", "try", "catch", "throw", "bool", 
        "true", "false", "using", "namespace", "void",
        "cin", "cout", "printf", "scanf", "static",
        "inline", "friend", "operator", "new", "delete",
        "protected"
    );

function highlighter(){
  try{
    var codes = document.getElementsByTagName("div");
    for(i = 0; i < codes.length; ++i){
        var clsname;
        if(isIE) clsname = codes[i].getAttributeNode('class').value;
        else clsname = codes[i].getAttribute("class");
        if(clsname == "code") highlight(codes[i]);
    }
  }catch(e){alert(e);}
}
function highlight(obj){
  try{
    var str = obj.innerHTML;
    var regs = "\\b(" + keywords + ")\\b";
    regs = regs.replace(/,/g, "|");
    var reg = new RegExp(regs, "g");
    str = str.replace(reg, '<span class="kw">$&</span>');
    obj.innerHTML = str;
  }catch(e){alert(e);}
}
