<?php
$relpath = dirname(__FILE__);
include($relpath."/def.php");
include_once(APP_ROOT."include/config.php");

?>
<style type="text/css">
.actions a{text-decoration:none;}
.actions a:hover{background-color: #8080ff;}
</style>
<script language="javascript" src="<?php echo $installDir;?>/editor/myubb.js"></script>
<div>
内容类型:
<input type="radio" <?php echo $plain;?> onclick="javascript:hide('actions');" name="content_type" value="0">纯文本
<input type="radio" <?php echo $html;?> onclick="javascript:hide('actions');" name="content_type" value="1">HTML代码
<input type="radio" <?php echo $ubb;?> onclick="javascript:disp('actions');" name="content_type" value="2">UBB代码
</div>
<div id="actions" class="actions" style="display:<?php echo $display;?>;">
<a href="javascript:addtag('b');" title="粗体"><img src="<?php echo $installDir;?>/editor/images/bold.gif" border="0"/></a>
<a href="javascript:addtag('i');" title="斜体"><img src="<?php echo $installDir;?>/editor/images/italic.gif" border="0"/></a>
<a href="javascript:addtag('u');" title="下划线"><img src="<?php echo $installDir;?>/editor/images/underline.gif" border="0"/></a>
<a href="javascript:addtag('sup');" title="上标"><img src="<?php echo $installDir;?>/editor/images/superscript.gif" border="0"/></a>
<a href="javascript:addtag('sub');" title="下标"><img src="<?php echo $installDir;?>/editor/images/subscript.gif" border="0"/></a>
<a href="javascript:addtag('center');" title="居中"><img src="<?php echo $installDir;?>/editor/images/center.gif" border="0"/></a>
<a href="javascript:addlink();" title="插入链接"><img src="<?php echo $installDir;?>/editor/images/link.gif" border="0"/></a>
<a href="javascript:addimg();" title="插入图片"><img src="<?php echo $installDir;?>/editor/images/img.gif" border="0"/></a>
<a href="javascript:addtag('code');" title="插入代码"><img src="<?php echo $installDir;?>/editor/images/code.gif" border="0"/></a>
<a href="javascript:addtag('quote');" title="插入引用"><img src="<?php echo $installDir;?>/editor/images/quote.gif" border="0"/></a>
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
<div>
加入符号: 
<input type="button" value="队名" onclick="javascript:addsymbol('team_name');"/>
<input type="button" value="学校" onclick="javascript:addsymbol('school');"/>
<input type="button" value="编号" onclick="javascript:addsymbol('team_id');"/>
<input type="button" value="密码" onclick="javascript:addsymbol('password');"/>
<input type="button" value="电话" onclick="javascript:addsymbol('telephone');"/>
</div>
<textarea name="content" id="content" cols="80" rows="20"><?php echo $content; ?></textarea>
<br/>
<input type="submit" value="提交"/>
<iframe style="scrolling:none;" src="<?php echo $installDir;?>/editor/uploadform.php" frameborder="0" width="600" height="25" scrolling="none"></iframe>
