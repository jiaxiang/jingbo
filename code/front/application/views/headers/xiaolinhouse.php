<?php
echo html::stylesheet(array
(
	'media/css/style.css?v=201110120',
	'media/css/style/style.css?v=201110120',
	//'media/css/headers/xlhouse/201110120.css?v=201110120',
	'media/css/headers/xlhouse/new_g.css?v=201110120',
), FALSE);
?>
<style type="text/css">
.width{width:990px;margin:0 auto;}
</style>
<div style="position: absolute; z-index: 1000000000; display: none; top: 50%; left: 50%; overflow: auto;" id="ckepop"></div>
<div style="position: absolute; z-index: 1000000000; display: none; overflow: auto;" id="ckepop"></div>
<!--header start-->
<!--top小目录-->
<div id="top_menu">
  <div class="width">
	<div class="fr gray68" id="top_r" style="width:200px;">
	  <ul>
		<li><a href="<?php echo url::base();?>doc/doc_detail/41" >网站地图</a></li>

		<li><a href="<?php echo url::base();?>doc/help" >帮助中心</a></li>
	  </ul>
	</div>
	
     <div class="fl" id="nologin_info" style="width:700px;<?php if(!empty($_user)){?>display:none;<?php }?>">
       <span class="gray68"></span><span class="gray68 pl10">
           <a href="<?php echo url::base();?>user/login" id="top_login_btn" >登录</a>
      </span> <span class="grayd0">|</span> <span class="red"><a href="<?php echo url::base();?>user/register">免费注册</a></span><span class="blue pl10"></span><span class="blue pl10"></span><span class="blue pl10"></span>

    </div>
	
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
<!--top小目录_end-->

<!--logo和热线-->
<div style="background-color:#FFFFFF; margin-left: auto;margin-right: auto;margin-top: 5px; width: 1016px;background:url('<?php echo url::base();?>media/images/headers/xlhouse/bgimg.png') repeat-y 0 0;">
<div class="clearboth"></div>
<table width="1016" cellspacing="0" cellpadding="0" border="0" align="center">
  <tbody><tr>
    <td width="240" bgcolor="#111111"><a href="http://www.xiaolinhouse.com/" target="_blank"><img width="184" height="35" border="0" alt="小林house足球城" src="<?php echo url::base();?>media/images/headers/xlhouse/xiaolinlogo.gif"></a></td>
    <td width="269" bgcolor="#111111">
    <a href="http://www.xiaolinhouse.com/adidas/xie/navi/01.html" target="_blank"><img src="<?php echo url::base();?>media/images/headers/xlhouse/adidas.gif" alt="阿迪达斯足球装备" width="58" height="35" border="0"></a>
    <a href="http://www.xiaolinhouse.com/nike/xie/navi/01.html" target="_blank"><img width="58" height="35" border="0" alt="耐克足球装备" src="<?php echo url::base();?>media/images/headers/xlhouse/nike.gif"></a>
    <a href="http://www.xiaolinhouse.com/umbro/fuzhuang/navi/01.html" target="_blank"><img width="58" height="35" border="0" alt="茵宝足球装备" src="<?php echo url::base();?>media/images/headers/xlhouse/umbro.gif"></a>
    <a href="http://www.xiaolinhouse.com/xiaolinhouse/duifu/navi/01.html" target="_blank"><img width="58" height="35" border="0" alt="小林house足球装备" src="<?php echo url::base();?>media/images/headers/xlhouse/xiaolinlogo02.gif"></a>
    </td>
    <td width="379" bgcolor="#111111" align="center"><span class="STYLE8">足 球 精 品 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;冠 绝 全 场</span></td>
    <td width="128" bgcolor="#111111" align="center" class="STYLE20" bordercolor="0"><a href="http://www.xiaolinhouse.com/liuyan/index.asp" target="_blank"><img width="110" height="35" border="0" align="right" src="<?php echo url::base();?>media/images/headers/xlhouse/00.jpg"></a></td>
  </tr>
</tbody></table>

<table width="1016" cellspacing="0" cellpadding="0" border="0" align="center" id="top_list01">
  <tbody><tr>
    <td width="125" height="40" bgcolor="#333333" align="center" class="STYLE10"><a class="wenzi" href="http://t.sina.com.cn/1787767453/profile?retcode=0" target="_blank">官方微博</a></td>
    <td width="125" height="25" bgcolor="#333333" align="center" class="wenzi"><a class="Fontsize" href="http://xiaolinhouse.taobao.com/" target="_blank">淘宝店铺</a></td>
    <td width="125" height="25" bgcolor="#333333" align="center" class="wenzi"><a class="Fontsize" href="http://www.baidu.com/s?bs=小林house足球&amp;f=8&amp;wd=小林house足球" target="_blank">新闻报道</a></td>
    <td width="125" height="25" bgcolor="#333333" align="center" class="wenzi" bordercolor="0"><a class="Fontsize" href="http://caipiao.xiaolinhouse.com" target="_blank">足球彩票</a></td>
    <td width="125" height="25" bgcolor="#333333" align="center" class="wenzi" bordercolor="0"><a class="Fontsize" href="http://www.xiaolinhouse.com/bizhi/basaibizhi.html" target="_blank">足球壁纸</a></td>
    <td width="125" height="25" bgcolor="#333333" align="center" class="wenzi"><a class="Fontsize" href="http://www.xiaolinhouse.com/tiandi/liansai01.html" target="_blank">足球天地</a></td>
    <td width="125" height="25" bgcolor="#333333" align="center" class="wenzi"><a class="Fontsize" href="http://www.xiaolinhouse.com/liansuo/liansuo.html" target="_blank">连锁加盟</a></td>
    <td width="125" height="25" bgcolor="#333333" align="center" class="wenzi"><a class="Fontsize" href="http://www.xiaolinhouse.com/lianxi/lianxi.html" target="_blank">联系我们</a></td>
  </tr>
</tbody></table>

<table width="1016" cellspacing="0" cellpadding="0" border="0" align="center" id="top_list01">
  <tbody><tr>
    <td width="125" height="40" bgcolor="#333333" align="center" class="STYLE10"><a href="<?php echo url::base();?>buycenter" class="wenzi" >合买大厅</a></td>
    <td width="125" height="25" bgcolor="#333333" align="center" class="wenzi"><a href="<?php echo url::base();?>recommend" class="Fontsize" >专家推荐</a></td>
    <td width="125" height="25" bgcolor="#333333" align="center" class="wenzi"><a href="<?php echo url::base();?>jsbf/sg_select" class="Fontsize" >赛果查询</a></td>
    <td width="125" height="25" bgcolor="#333333" align="center" bordercolor="0" class="wenzi"><a href="<?php echo url::base();?>jsbf/" class="Fontsize" >即时比分</a></td>
    <td width="125" height="25" bgcolor="#333333" align="center" bordercolor="0" class="wenzi"><a href="http://odds.jingbo365.com/" class="Fontsize" target="_blank">赔率指数</a></td>
    <td width="125" height="25" bgcolor="#333333" align="center" class="wenzi"><a href="http://info.jingbo365.com/" class="Fontsize" target="_blank">联赛资料</a></td>
    <td width="125" height="25" bgcolor="#333333" align="center" class="wenzi"><a href="<?php echo url::base();?>bbs/" class="Fontsize" target="_blank">交流论坛</a></td>
    <td width="125" height="25" bgcolor="#333333" align="center" class="wenzi"><a href="<?php echo url::base();?>doc/doc_detail/83" class="Fontsize" >QQ群</a></td>
  </tr>
</tbody></table>
<!--logo和热线_end-->
<!--menu和列表-->


<div class="width"> <span class="fl"><img src="<?php echo url::base();?>media/images/top_list.gif" width="3" height="80"></span>
  <div id="top_list" class="fl bold">
    <div id="kuan1" class="fl">
      <dl>

        <dt><img src="<?php echo url::base();?>media/images/jingbo_cp_03.gif"></dt>
        <dd><a href="<?php echo url::base();?>jczq/rqspf/" >胜平负</a></dd>
        <dd><a href="<?php echo url::base();?>jczq/zjqs/" >进球数</a></dd>
        <dd><a href="<?php echo url::base();?>jczq/bf/" >比&nbsp;&nbsp;&nbsp;分</a></dd>
        <dd><a href="<?php echo url::base();?>jczq/bqc/" >半全场</a></dd>
      </dl>

    </div>
    <div class="fl" id="kuan2">
      <dl>
        <dt><img src="<?php echo url::base();?>media/images/jingbo_cp_05.gif"></dt>
		<dd><a href="<?php echo url::base();?>jclq/sf" >胜&nbsp;&nbsp;&nbsp;负</a></dd>
        <dd><a href="<?php echo url::base();?>jclq/rfsf" >让分胜负</a></dd>
        <dd><a href="<?php echo url::base();?>jclq/sfc" >胜分差</a></dd>

        <dd><a href="<?php echo url::base();?>jclq/dxf" >大小分</a></dd>
	  </dl>
    </div>
    <div id="kuan3" class="fl">
      <dl>
        <dt><img src="<?php echo url::base();?>media/images/jingbo_cp_07.gif"></dt>
        <dd><a href="<?php echo url::base();?>zcsf/sfc_14c" >胜负彩</a></dd>
        <dd><a href="<?php echo url::base();?>zcsf/sfc_4c" >进球彩</a></dd>

        <dd><a href="<?php echo url::base();?>zcsf/sfc_9c" >任选九</a></dd>
         <dd><a href="<?php echo url::base();?>zcsf/sfc_6c" >半全场</a></dd>
      </dl>
    </div>
    <div id="kuan4" class="fl">
      <dl>
        <dt><img src="<?php echo url::base();?>media/images/jingbo_cp_09.gif"></dt>
		<dd><a href="<?php echo url::base();?>bjdc/rqspf" >让球胜平负</a></dd>

        <dd><a href="<?php echo url::base();?>bjdc/zjqs" >总进球数</a></dd>
        <dd class="sxds"><a href="<?php echo url::base();?>bjdc/sxds" >上下单双&nbsp;&nbsp;&nbsp;&nbsp;</a></dd>
        <dd><a href="<?php echo url::base();?>bjdc/bf" >比分</a>&nbsp;<a href="<?php echo url::base();?>bjdc/bqc" >半全场</a></dd>
      </dl>
    </div>
    
    <div id="kuan3" class="fl">
      <dl>
        <dt><img src="<?php echo url::base();?>media/images/jbtc.gif"></dt>
        <dd><a href="<?php echo url::base();?>dlt" >大乐透</a></dd>
        <dd><a href="<?php echo url::base();?>pls">排列三</a></dd>
        <dd><a href="<?php echo url::base();?>qxc">七星彩</a></dd>
         <dd><a href="<?php echo url::base();?>plw">排列五</a></dd>
      </dl>
    </div>

  </div>
  <span class="fl"><img src="<?php echo url::base();?>media/images/top_list2.gif" width="3" height="80"></span> </div>
<div class="clearboth"></div>