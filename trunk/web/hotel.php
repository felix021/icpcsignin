<?php
if(isset($_SESSION['team_id'])){
    $team_id = (int)$_SESSION['team_id'];
    $t = new team($team_id);
    encodeObject($t);
?>
<div class="textbox">
<div class="textbox-title">住宿代订要求 (留空则表示自行处理)</div>
<div class="textbox-content">
<form action="team/savehotel.php" method="post">
<textarea name="requirement" id="requirement" style="width:600px; height:100px;"><?php echo $t->requirement; ?></textarea>
<br/>
<input type="submit" value="修改"/>
</form>
</div>
</div>
<?php
}
?>
<div class="textbox">
<div class="textbox-title" style="text-align:center;">以下住宿信息仅供参考</div>
</div>

<div class="textbox">
<div class="textbox-title">·如家快捷酒店 （离赛场最近，推荐）</div>
<div class="textbox-content">
<p>价格：双人间 199</p>
<p>服务：宽带 送早餐</p>
<p>地址：武测门口，广埠屯对面。</p>
</div>
</div>

<div class="textbox">
<div class="textbox-title">·豊颐大酒店 三星酒店四星客房</div>
<div class="textbox-content">
<p> 价格：普单（288元  无窗户）大单间（双人398元）人多可以商议价格</p>
<p>服务：普单（无宽带 送一份早餐）  大单（有电脑可以上网, 送两份早餐）</p>
<p> 电话：027-67811888</p>
<p> 地址：武昌八一路336号  ，广八路路口</p>
</div>
</div>

<div class="textbox">
<div class="textbox-title">·思美尔宾馆经济型 </div>
<div class="textbox-content">
<p> 价格：单人（158元）标准双人（168）商务（198）商务套房（288 可以住4-5人）</p>
<p> 服务：免费宽带  早餐不免费</p>
<p> 电话：027-87860627</p>
<p> 地址：武汉市八一路216号武汉大学斜对面(樱花大厦旁)</p>
</div>
</div>

<div class="textbox">
<div class="textbox-title">·瑞安都市酒店  </div>
<div class="textbox-content">
<p>价格：单人（198元）双人（198元）三人（228元）</p>
<p> 服务：免费宽带  送早餐</p>
<p> 电话：027-87666222</p>
<p> 地址：武汉市洪山区武珞路669号</p>
</div>
</div>

<div class="textbox">
<div class="textbox-title">·假日酒店  </div>
<div class="textbox-content">
<p> 价格：单人（150元）双人（150元）</p>
<p> 服务：有电脑  使用要交10元   送早餐</p>
<p> 电话：027-59700888</p>
<p>地址：街道口珞狮南路120号</p>
</div>
</div>

<div class="textbox">
<div class="textbox-title">·樱桂源时尚酒店经济型</div>
<div class="textbox-content">
<p> 价格：单人（188元）  无双人间</p>
<p> 服务：免费宽带   送早餐</p>
<p> 电话：027-51855588</p>
<p> 地址：武汉市洪山区珞瑜路78号-广埠屯电脑城长江传媒大厦</p>
</div>
</div>

