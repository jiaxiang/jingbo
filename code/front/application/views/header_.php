<?php
echo html::stylesheet(array
(
	'media/css/style/style.css?v=201110120',
	//'media/lottnum/style/style',
), FALSE); 
$data['site_config'] = Kohana::config('site_config.site');
$host = $_SERVER['HTTP_HOST'];
$dis_site_config = Kohana::config('distribution_site_config');
if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
	$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
	$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
	$data['site_config']['description'] = $dis_site_config[$host]['description'];
}
?>
<div style="position: absolute; z-index: 1000000000; display: none; top: 50%; left: 50%; overflow: auto;" id="ckepop"></div>
<div style="position: absolute; z-index: 1000000000; display: none; overflow: auto;" id="ckepop"></div>
<!--header start-->
<!--top小目录-->
<div id="top_menu">
  <div class="width">
	<div class="fr gray68" id="top_r" style="width:200px;">
	  <ul>
		<li><a href="<?php echo url::base();?>doc/doc_detail/41">网站地图</a></li>
		<li><a href="<?php echo url::base();?>doc/help">帮助中心</a></li>
	  </ul>
	</div>
	
     <div class="fl" id="nologin_info" style="width:700px;<?php if(!empty($_user)){?>display:none;<?php }?>">
       <span class="gray68"></span><span class="gray68 pl10">
           <a href="<?php echo url::base();?>user/login" id="top_login_btn">登录</a>
      </span> <span class="grayd0">|</span> <span class="red"><a href="<?php echo url::base();?>user/register">免费注册</a></span><span class="blue pl10"></span><span class="blue pl10"></span><span class="blue pl10"></span>
    </div>
	
	<div id="top_user_info" style="width:700px;<?php if(empty($_user)){ echo "display:none;";}?>">
		<ul class="top_user_infor_ul">
			<li id="top_username">您好 <?php if(!empty($_user)){echo $_user['lastname'];}?>，欢迎您！</li>
			<li class="tuichu"><a href="<?php echo url::base();?>user/logout" id="logoutLink">退出</a></li>
			<li id="topmyzhhu" class="topmyzhhu" onmousemove='Myaccount(1)' onmouseout='Myaccount(2)'><a href="<?php echo url::base();?>user/" class="topmya now">我的账户</a>
			<div id="account_inneraa" style="display:none">
					<dl>
						<dt>余额 <em id="money"><?php if(!empty($_user)){echo $_user['user_money'];}?></em> 元</dt>                                
						<dd>当前未结算的方 <a href="<?php echo url::base();?>user/" class="lanse" id="fa_lanse"><?php if(!empty($_user)){echo $_user['outstanding_plan'];}?></a> 个</dd>
						<?php /*<dd>关注的发起人合买 <a href="#" class="lanse">0</a> 个</dd>
						<dd>关注的人有新动态 <a href="#" class="lanse">0</a> 个</dd> */ ?>
						<dd><span onclick="postdata()">[刷新]</span><a href="<?php echo url::base();?>user/" class="textr">进入我的账户>></a></dd>
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
<!--top小目录_end-->

<!--logo和热线-->
<div class="clearboth"></div>
<div id="head">
  <div class="width">
  	 <a href="<?php echo url::base();?>"><img src="<?php echo url::base();?>media/images/logo.gif" alt="<?php echo $data['site_config']['site_title'];?>" title="<?php echo $data['site_config']['site_title'];?>" class="fl"></a>
     <div class="fl" id="top_banner"><img src="<?php echo url::base();?>media/images/top_banner.jpg"></div>
     <div class="float_r"><img src="<?php echo url::base();?>media/images/phone.gif" alt="客服电话" ></div>    
  </div>
</div>
<!--logo和热线_end-->
<!--menu和列表-->
<div class="width">
  <div id="menu" class="font14 bold">
    <ul>
      <li <?php if(empty($_topnav) || $_topnav=='is_home') echo 'class="bg2 hover2"';else echo 'style="margin-left:0px;"';?>><a href="<?php echo url::base();?>">网站首页</a></li>
      <li <?php if(!empty($_topnav) && $_topnav=='is_hemai') echo 'class="bg2 hover2" style="margin-left:2px;"'?>><a href="<?php echo url::base();?>buycenter">合买中心</a></li>
      <li <?php if(!empty($_topnav) && $_topnav=='is_zhuanjia') echo 'class="bg2 hover2" style="margin-left:2px;"'?>><a href="<?php echo url::base();?>recommend">专家推荐</a></li>
      <li <?php if(!empty($_topnav) && $_topnav=='is_news') echo 'class="bg2 hover2" style="margin-left:2px;"'?>><a href="<?php echo url::base();?>news">新闻中心</a></li>
      <li <?php if(!empty($_topnav) && $_topnav=='is_sgcx') echo 'class="bg2 hover2" style="margin-left:2px;"'?>><a href="<?php echo url::base();?>jsbf/sg_select">赛果查询</a></li>
      
      <li <?php if(!empty($_topnav) && $_topnav=='is_live') echo 'class="bg2 hover2" style="margin-left:2px;"'?>><a href="http://live.jingbo365.com/?controller=cplive&lotyid=6" target="_blank">即时比分</a></li>
      <li <?php if(!empty($_topnav) && $_topnav=='is_odds') echo 'class="bg2 hover2" style="margin-left:2px;"'?>><a href="http://odds.jingbo365.com/" target="_blank">赔率指数</a></li>
      <li <?php if(!empty($_topnav) && $_topnav=='is_league_info') echo 'class="bg2 hover2" style="margin-left:2px;"'?>><a href="http://info.jingbo365.com/" target="_blank">联赛资料</a></li>
      		
      <li><a href="<?php echo url::base();?>bbs/" target="_blank">竞波论坛</a></li>
      <li><a href="<?php echo url::base();?>doc/doc_detail/83" target="_blank">竞波QQ群</a></li>
      <!-- <li><a href="<?php echo url::base();?>doc/doc_detail/83"><img style="vertical-align:top;" src="<?php echo url::base();?>media/images/qq_top2.jpg" /></a></li>
     <li><a href="http://xweibo" target="_blank">微博</a></li>-->
    </ul>
  </div>
</div>

<div class="width"> <span class="fl"><img src="<?php echo url::base();?>media/images/top_list.gif" width="3" height="80"></span>
  <div id="top_list" class="fl bold">
    <div id="kuan1" class="fl">
      <dl>
        <dt><img src="<?php echo url::base();?>media/images/jingbo_cp_03.gif"></dt>
        <dd><a href="<?php echo url::base();?>jczq/rqspf/">胜平负</a></dd>
        <dd><a href="<?php echo url::base();?>jczq/zjqs/">进球数</a></dd>
        <dd><a href="<?php echo url::base();?>jczq/bf/">比&nbsp;&nbsp;&nbsp;分</a></dd>
        <dd><a href="<?php echo url::base();?>jczq/bqc/">半全场</a></dd>
      </dl>
    </div>
    <div class="fl" id="kuan2">
      <dl>
        <dt><img src="<?php echo url::base();?>media/images/jingbo_cp_05.gif"></dt>
		<dd><a href="<?php echo url::base();?>jclq/sf">胜&nbsp;&nbsp;&nbsp;负</a></dd>
        <dd><a href="<?php echo url::base();?>jclq/rfsf">让分胜负</a></dd>
        <dd><a href="<?php echo url::base();?>jclq/sfc">胜分差</a></dd>
        <dd><a href="<?php echo url::base();?>jclq/dxf">大小分</a></dd>
		</dl>
    </div>
    <div id="kuan3" class="fl">
      <dl>
        <dt><img src="<?php echo url::base();?>media/images/jingbo_cp_07.gif"></dt>
        <dd><a href="<?php echo url::base();?>zcsf/sfc_14c">胜负彩</a></dd>
        <dd><a href="<?php echo url::base();?>zcsf/sfc_4c">进球彩</a></dd>
        <dd><a href="<?php echo url::base();?>zcsf/sfc_9c">任选九</a></dd>
         <dd><a href="<?php echo url::base();?>zcsf/sfc_6c">半全场</a></dd>
      </dl>
    </div>
    <div id="kuan4" class="fl">
      <dl>
        <dt><img src="<?php echo url::base();?>media/images/jingbo_cp_09.gif"></dt>
		<dd><a href="<?php echo url::base();?>bjdc/rqspf">让球胜平负</a></dd>
        <dd><a href="<?php echo url::base();?>bjdc/zjqs">总进球数</a></dd>
        <dd class="sxds"><a href="<?php echo url::base();?>bjdc/sxds">上下单双&nbsp;&nbsp;&nbsp;&nbsp;</a></dd>
        <dd><a href="<?php echo url::base();?>bjdc/bf">比分</a>&nbsp;<a href="<?php echo url::base();?>bjdc/bqc">半全场</a></dd>
      </dl>
    </div>
    
    <div id="kuan3" class="fl">
      <dl>
        <dt><img src="<?php echo url::base();?>media/images/jbtc.gif"></dt>
        <dd><a href="<?php echo url::base();?>dlt">大乐透</a></dd>
        <dd><a href="<?php echo url::base();?>pls">排列三</a></dd>
        <dd><a href="<?php echo url::base();?>qxc">七星彩</a></dd>
         <dd><a href="<?php echo url::base();?>plw">排列五</a></dd>
      </dl>
    </div>
  </div>
  <span class="fl"><img src="<?php echo url::base();?>media/images/top_list2.gif" width="3" height="80"></span> </div>
<div class="clearboth"></div>