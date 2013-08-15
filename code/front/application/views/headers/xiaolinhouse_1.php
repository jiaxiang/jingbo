<div id="top_menu">
  <div class="width">
    <div style="width:200px;" id="top_r" class="fr gray68">
      <ul>
        <li><a href="<?php echo url::base();?>doc/doc_detail/41">网站地图</a></li>
        <li><a href="<?php echo url::base();?>doc/help">帮助中心</a></li>
      </ul>
    </div>
    <div style="width:700px;<?php if(!empty($_user)){?>display:none;<?php }?>" class="fl" > <span class="gray68 pl10"><a href="<?php echo url::base();?>user/login">登录</a></span> <span class="grayd0">|</span> <span class="red"><a href="<?php echo url::base();?>user/register">免费注册</a></span> </div>
    <div id="top_user_info" style="width:700px;<?php if(empty($_user)){ echo "display:none;";}?>">
		<ul class="top_user_infor_ul">
			<li id="top_username">您好 <?php if(!empty($_user)){echo $_user['lastname'];}?>，欢迎您！</li>
			<li class="tuichu"><a href="<?php echo url::base();?>user/logout" id="logoutLink">退出</a></li>
			<li id="topmyzhhu" class="topmyzhhu" onmousemove='Myaccount(1)' onmouseout='Myaccount(2)'><a href="<?php echo url::base();?>user" class="topmya now">我的账户</a>
			<div id="account_inneraa" style="display:none">
					<dl>
						<dt>余额 <em id="money"><?php if(!empty($_user)){echo $_user['user_money'];}?></em> 元</dt>                                
						<dd>当前未结算的方 <a href="<?php echo url::base();?>user" class="lanse" id="fa_lanse"><?php if(!empty($_user)){echo $_user['outstanding_plan'];}?></a> 个</dd>
						<?php /*<dd>关注的发起人合买 <a href="#" class="lanse">0</a> 个</dd>
						<dd>关注的人有新动态 <a href="#" class="lanse">0</a> 个</dd> */ ?>
						<dd><span onclick="postdata()">[刷新]</span><a href="<?php echo url::base();?>user" class="textr">进入我的账户>></a></dd>
					</dl>
       		  </div>
			
			<div class="clearboth"></div>
			</li>
			<li class="chongzhi"><a href="<?php echo url::base();?>user/recharge">充值</a></li>
			<li class="lanse"><a href="<?php echo url::base();?>user/withdrawals">提款</a></li>
		</ul>
    </div>
    
  </div>
</div>
<script language="javascript">
function Myaccount(hover){
	if(hover==1){
		document.getElementById("account_inneraa").style.display = "";
		document.getElementById("topmyzhhu").style.border = "1px solid #CDC9CA";
		document.getElementById("topmyzhhu").style.padding = "0px";
		document.getElementById("topmyzhhu").style.borderBottom= "none";
		document.getElementById("topmyzhhu").style.background= "#ffffff";
	}else{
		document.getElementById("account_inneraa").style.display = "none";
		document.getElementById("topmyzhhu").style.border = "none";
		document.getElementById("topmyzhhu").style.padding = "1px";
		document.getElementById("topmyzhhu").style.background= "none";
	}
}
function createxmlhttp()
{
	var xmlhttp=false;
	try	{
  		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
 	} 
	catch (e) {
  		try {
   			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  		} 
		catch (e) {
   			xmlhttp = false;
 		}
 	}
	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
  		xmlhttp = new XMLHttpRequest();
				if (xmlhttp.overrideMimeType) {//MiME
			xmlhttp.overrideMimeType('text/xml');
		}
	}	
	return xmlhttp;	
}
function postdata()
{		
		url='<?php echo url::base();?>user/ajax_user_money'
		data='';
		var xmlhttp=createxmlhttp();
		if(!xmlhttp)
		{
			return;
		}
		xmlhttp.open("POST", url, true);
		xmlhttp.onreadystatechange=requestdata;
		xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		xmlhttp.send(data);
		function requestdata()
		{
			//
			//alert(xmlhttp.readyState);
			if(xmlhttp.readyState==4)
			{
				//alert(xmlhttp.status);
				if(xmlhttp.status==200)
				{
					   
						var dataObj=eval("("+xmlhttp.responseText+")");//转换为json对象
						document.getElementById('fa_lanse').innerHTML=dataObj.outstanding_plan;
						document.getElementById('money').innerHTML=dataObj.userMoney;
				}
			}
		}
}
</script>
<div id="header">
  <div class="width">
    <div class="logo fl"><a href="http://www.xiaolinhouse.com/" target="_blank"><img src="<?php echo url::base();?>media/images/xlhouse/logo.jpg" width="186" height="37" alt="小林house足球城" /></a></div>
    <ul class="fl" style="padding: 5px 50px 0;">
      <li><a href="http://www.xiaolinhouse.com/adidas/xie/navi/01.html" target="_blank"><img src="<?php echo url::base();?>media/images/xlhouse/adidas.gif" width="58" height="35" alt="阿迪达斯足球装备" /></a></li>
      <li><a href="http://www.xiaolinhouse.com/nike/xie/navi/01.html" target="_blank"><img src="<?php echo url::base();?>media/images/xlhouse/nike.gif" width="58" height="35" alt="耐克足球装备" /></a></li>
      <li><a href="http://www.xiaolinhouse.com/umbro/fuzhuang/navi/01.html" target="_blank"><img src="<?php echo url::base();?>media/images/xlhouse/umbro.gif" width="58" height="35" alt="茵宝足球装备" /></a></li>
      <li><a href="http://www.xiaolinhouse.com/xiaolinhouse/duifu/navi/01.html" target="_blank"><img src="<?php echo url::base();?>media/images/xlhouse/xiaolin.gif" width="58" height="35" alt="小林house足球装备" /></a></li>
    </ul>
    <p class="fl" style="color:#FFFF00;padding:11px 50px; font-size:16px;"><b>创 建 中 国 最 专 业 的 足 球 城</b></p>
    <p class="fr" style="padding-top:5px;"><a href="http://www.xiaolinhouse.com/liuyan/index.asp" target="_blank"><img src="<?php echo url::base();?>media/images/xlhouse/00.jpg" width="110" height="35" /></a></p>
    <div class="clr"></div>
  </div>
  <div class="menu_resize">
    <div class="menu">
      <ul>
        <li><a class="active" href="http://t.sina.com.cn/1787767453/profile?retcode=0" target="_blank"><span>官方微博</span></a></li>
        <li><a href="http://xiaolinhouse.taobao.com/" target="_blank"><span>淘宝店铺</span></a></li>
        <li><a href="http://www.baidu.com/s?bs=小林house足球&amp;f=8&amp;wd=小林house足球" target="_blank"><span>新闻报道</span></a></li>
        <li><a href="http://caipiao.xiaolinhouse.com" target="_blank"><span>足球彩票</span></a></li>
        <li><a href="http://www.xiaolinhouse.com/bizhi/basaibizhi.html" target="_blank"><span>足球壁纸</span></a></li>
        <li><a href="http://www.xiaolinhouse.com/tiandi/liansai01.html" target="_blank"><span>足球天地</span></a></li>
        <li><a href="http://www.xiaolinhouse.com/liansuo/liansuo.html" target="_blank"><span>连锁加盟 </span></a></li>
        <li><a href="http://www.xiaolinhouse.com/lianxi/lianxi.html" target="_blank"><span>联系我们</span></a></li>
        <li><a href="<?php echo url::base();?>buycenter"><span>合买大厅</span></a></li>
        <li><a href="<?php echo url::base();?>recommend"><span>专家推荐</span></a></li>
        <li><a href="<?php echo url::base();?>jsbf/sg_select"><span>赛果查询</span></a></li>
        <li><a href="<?php echo url::base();?>jsbf/"><span>即时比分</span></a></li>
        <li><a href="http://odds.jingbo365.com/" target="_blank"><span>赔率指数</span></a></li>
        <li><a href="http://info.jingbo365.com/" target="_blank"><span>联赛资料</span></a></li>
        <li><a href="<?php echo url::base();?>bbs/" target="_blank"><span>交流论坛</span></a></li>
        <li><a href="<?php echo url::base();?>doc/doc_detail/83"><span>QQ群</span></a></li>
      </ul>
    </div>
    <div class="clr"></div>
  </div>
  <div class="w" style="margin: 10px 10px 0;">
    <div style="float:left; margin-left:20px;"> 您所在的位置： <a href="<?php echo url::base();?>"><font class="w">首页</font></a> &gt; <a href="<?php echo url::base();?>jczq/rqspf"><font class="w">竞彩足球</font></a> &gt; 让球胜平负 </div>
    <div style="float:right; margin-right:20px;"> <span style="float:right">客服电话：400-820-2324</span> </div>
    <div style="clear:both;"></div>
  </div>
</div>