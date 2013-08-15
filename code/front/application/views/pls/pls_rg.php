<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0028)http://www.jingbo365.com.cn/ -->
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<title>竞波网-竞彩-足彩-篮彩-足球-彩票合买</title>
<meta name="Keywords" content="竞波,竞彩,足彩,篮彩,足球,彩票合买,caipiao">
<meta name="Description" content="竞波网是一家服务于中国彩民的互联网彩票合买代购交易平台，是当前中国彩票互联网交易行业的领导者。竞波网以服务中国彩民为己任，为彩民提供全国各大联销型彩票的在线合买、代购和彩票软件开发、彩票增值短信业务、彩票WAP移动业务等服务。覆盖了足球彩票，体育彩票，福利彩票等各类中国彩票.">
<script type="text/javascript" async="" src="../images/ga.js"></script><script type="text/javascript" src="../images/jquery.js"></script>
<script type="text/javascript" src="../images/txt_scroll.js"></script>

<link rel="stylesheet" type="text/css" href="../style/style.css">
<link rel="stylesheet" type="text/css" href="../style/rg-style.css">
<style>
#ic7_cr_con ul.ic_cr_con {
    font: 12px/22px "宋体";
    height: 111px;
    overflow: hidden;
}
</style>
</head><body>
<!--top小目录-->
<iframe style="position: fixed; display: none; opacity: 0;" frameborder="0"></iframe>
<div style="position: absolute; z-index: 1000000000; display: none; top: 50%; left: 50%; overflow: auto;" id="ckepop"></div>
<div style="position: absolute; z-index: 1000000000; display: none; overflow: auto;" id="ckepop"></div>
<!--header start-->
<!--top小目录-->

<div id="top_menu">

  <div class="width">
	<div class="fr gray68" id="top_r" style="width:200px;">
	  <ul>
		<li><a href="http://www.jingbo365.com.cn/doc/doc_detail/41">网站地图</a></li>
		<li><a href="http://www.jingbo365.com.cn/doc/help">帮助中心</a></li>
	  </ul>
	</div>
	
     <div class="fl" id="nologin_info" style="width:700px;">
       <span class="gray68"></span><span class="gray68 pl10">
           <a href="http://www.jingbo365.com.cn/user/login" id="top_login_btn">登录</a>
      </span> <span class="grayd0">|</span> <span class="red"><a href="http://www.jingbo365.com.cn/user/register">免费注册</a></span><span class="blue pl10"></span><span class="blue pl10"></span><span class="blue pl10"></span>
    </div>
	
	<div id="top_user_info" style="width:700px;display:none;">
		<ul class="top_user_infor_ul">
			<li id="top_username">您好 ，欢迎您！</li>
			<li class="tuichu"><a href="http://www.jingbo365.com.cn/user/logout" id="logoutLink">退出</a></li>
			<li id="topmyzhhu" class="topmyzhhu" onmousemove="Myaccount(1)" onmouseout="Myaccount(2)"><a href="http://www.jingbo365.com.cn/user/" class="topmya now">我的账户</a>
			<div id="account_inneraa" style="display:none">
					<dl>
						<dt>余额 <em id="money"></em> 元</dt>                                
						<dd>当前未结算的方 <a href="http://www.jingbo365.com.cn/user/" class="lanse" id="fa_lanse"></a> 个</dd>
												<dd><span onclick="postdata()">[刷新]</span><a href="http://www.jingbo365.com.cn/user/" class="textr">进入我的账户&gt;&gt;</a></dd>
					</dl>
       		  </div>
			
			<div class="clearboth"></div>
			</li>
      <li class="chongzhi"><a href="http://www.jingbo365.com.cn/user/recharge">充值</a></li>
			<li class="lanse"><a href="http://www.jingbo365.com.cn/user/withdrawals">提款</a></li>
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
		url='/user/ajax_user_money'
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
  	 <a href="../images/竞波网-竞彩-足彩-篮彩-足球-彩票合买.htm"><img src="../images/logo.gif" alt="竞波网" title="竞波网" class="fl"></a>
     <div class="fl" id="top_banner"><img src="../images/top_banner.jpg"></div>
     <img src="../images/phone.gif" alt="客服电话" class="fr">
    
  </div>
</div>
<!--logo和热线_end-->
<!--menu和列表-->
<div class="width">
  <div id="menu" class="font14 bold">
    <ul>
      <li class="bg2 hover2"><a href="../images/竞波网-竞彩-足彩-篮彩-足球-彩票合买.htm">网站首页</a></li>
      <li><a href="http://www.jingbo365.com.cn/buycenter">合买中心</a></li>
      <li><a href="http://www.jingbo365.com.cn/recommend">专家推荐</a></li>
      <li><a href="http://www.jingbo365.com.cn/jsbf/">即时比分</a></li>
      <li><a href="http://www.jingbo365.com.cn/jsbf/sg_select">赛果查询</a></li>
            <li><a href="http://www.jingbo365.com.cn/news">新闻中心</a></li>
      <li><a href="http://www.jingbo365.com.cn/playmethod">玩法介绍</a></li>
      <li><a href="http://www.jingbo365.com.cn/doc/doc_detail/43">客服中心</a></li> 
      <li><a href="http://www.jingbo365.com.cn/bbs/" target="_blank">交流论坛</a></li>
       <li><a href="http://qun.qq.com/#jointhegroup/gid/177130024" target="_blank"><img src="../images/qq_top2.gif"></a></li>
     <!-- <li><a href="http://xweibo" target="_blank">微博</a></li>-->
    </ul>
  </div>
</div>
<div class="width"> <span class="fl"><img src="../images/top_list.gif" width="3" height="80"></span>
  <div id="top_list" class="fl bold">
    <div id="kuan1" class="fl">
      <dl>
        <dt><img src="../images/jingbo_cp_03.gif"></dt>
        <dd><a href="http://www.jingbo365.com.cn/jczq/rqspf/">胜平负</a></dd>
        <dd><a href="http://www.jingbo365.com.cn/jczq/zjqs/">进球数</a></dd>
        <dd><a href="http://www.jingbo365.com.cn/jczq/bf/">比&nbsp;&nbsp;&nbsp;分</a></dd>
        <dd><a href="http://www.jingbo365.com.cn/jczq/bqc/">半全场</a></dd>
      </dl>
    </div>
    <div class="fl" id="kuan2">
      <dl>
        <dt><img src="../images/jingbo_cp_05.gif"></dt>
		<dd><a href="http://www.jingbo365.com.cn/#">胜&nbsp;&nbsp;&nbsp; 负</a></dd>
        <dd><a href="http://www.jingbo365.com.cn/#">让分胜负</a></dd>
        <dd><a href="http://www.jingbo365.com.cn/#">胜分差</a></dd>
        <dd><a href="http://www.jingbo365.com.cn/#">大小分</a></dd>
              </dl>
    </div>
    <div id="kuan3" class="fl">
      <dl>
        <dt><img src="../images/jingbo_cp_07.gif"></dt>
        <dd><a href="http://www.jingbo365.com.cn/zcsf/sfc_14c">胜负彩</a></dd>
        <dd><a href="http://www.jingbo365.com.cn/zcsf/sfc_4c">进球彩</a></dd>
        <dd><a href="http://www.jingbo365.com.cn/zcsf/sfc_9c">任选九</a></dd>
         <dd><a href="http://www.jingbo365.com.cn/zcsf/sfc_6c">半全场</a></dd>
      </dl>
    </div>
    <div id="kuan4" class="fl">
      <dl>
        <dt><img src="../images/jingbo_cp_09.gif"></dt>
		<dd><a href="http://www.jingbo365.com.cn/bjdc/rqspf">让球胜平负&nbsp;&nbsp;&nbsp;&nbsp;</a></dd>
        <dd><a href="http://www.jingbo365.com.cn/bjdc/zjqs">总进球数</a></dd>
        <dd><a href="http://www.jingbo365.com.cn/bjdc/sxds">上下单双&nbsp;&nbsp;&nbsp;&nbsp;</a></dd>
        <dd><a href="http://www.jingbo365.com.cn/bjdc/bf">比分</a>&nbsp;&nbsp; <a href="http://www.jingbo365.com.cn/bjdc/bqc">半全场</a></dd>
      </dl>
    </div>
    
    <div id="kuan3" class="fl">
      <dl>
        <dt><img src="../images/jingbo_cp_11.gif"></dt>
        <dd><a href="http://www.jingbo365.com.cn/zcsf/sfc_14c">大乐透</a></dd>
        <dd><a href="http://www.jingbo365.com.cn/zcsf/sfc_4c">排列三</a></dd>
        <dd><a href="http://www.jingbo365.com.cn/zcsf/sfc_9c">七星彩</a></dd>
         <dd><a href="http://www.jingbo365.com.cn/zcsf/sfc_6c">排列五</a></dd>
      </dl>
    </div>
  </div>
  <span class="fl"><img src="../images/top_list2.gif" width="3" height="80"></span> </div>
  	
	<div class="clearboth"></div>
		<div class="guide">您现在的位置：<a title="网上买彩票" href="/">首页</a> &gt; <a title="超级大乐透" href="/dlt/">超级大乐透</a>
	</div>

<!--menu和列表_end-->
<!--content1-->
	<div class="width">
		<div id="main">
            <div class="box_top">
                <div class="box_top_l"></div>
            </div>
            <div class="box_m">
              <div class="det_t_bg">
                	<!-- <div  class="s-logo sfc-logo"></div> -->
					<div id="lot-logo" class="s-logo dlt-logo"></div>
               	<div class="det_h">
                    	<h2>超级大乐透 第2011136期   复式合买</h2>
                        <p><span class="m_r25">此方案发起时间：2011-11-16 21:21:57</span><span class="m_r25">认购截止时间：2011-11-19 19:45:00</span><span>方案编号：50102032870</span></p>
                  </div>
                  <a id="hmlist" class="m_link" href="/hemai/project_list.html?lotid=50">返回合买列表&gt;&gt;</a>
                </div>
 
                
                <div id="xx1">
                	<div class="det_g_t">方案基本信息</div>
                    <table cellspacing="0" cellpadding="0" border="0" width="100%" class="buy_table">
                      <tbody><tr id="fqrinfo">
                        <td class="td_title2">发起人信息</td>
                        <td class="con_content">
                        	<div class="detail_d">
                                <p>
                                <span id="cnickid" class="m_r50 record"><a onclick="Y.openUrl('/main/viewjp.html?lotid=50&amp;uid=云阳88&amp;func=award',477,465)" href="javascript: void 0">云阳88</a>&nbsp;&nbsp;&nbsp;</span>
                             
								
							
                                </p>
                                
                            </div>
                        </td>
                      </tr>
                      
          <tr>
                        <td class="td_title2">方案信息</td>
                        <td class="con_content">
                            <div style="width:625px;" class="tdbback" id="fanandiv">
                                <table cellspacing="0" cellpadding="0" border="0" width="100%" class="tablelay eng">
                                  <tbody><tr>
                                    <th>总金额</th>
                                    <th>倍数</th>
                                    <th>份数</th>
                                    <th>每份</th>
                                    <th>彩票标识</th>
                                    <th>保底金额</th>
                                    <th>提成比例</th>
                                    <th class="last_th">购买进度</th>
                                  </tr>
                                  <tr class="last_tr">
                                    <td><span id="tmoney" class="red eng">￥12.00</span>元</td>                                                            
                                    <td id="mulity">1倍</td>
                                    <td id="nums">12份</td>
                                    <td id="smoney">￥1.00元</td>
                                    <td id="icast">出票中</td>
                                    <td id="pnum">未保底</td>
                                    <td id="wrate">5%</td>
                                    <td class="last_td"><span id="jindu" class="red eng">100%</span></td>
                                  </tr>
                                </tbody></table>
                             </div>
                        </td>
                      </tr>
                      <tr>
                         <td class="td_title2 p_tb8">方案内容</td>
                      <td style="word-break:break-all; display: block;" class="con_content p_tb8">
                            <p id="ccodes">您的投注方案尚未上传，<a style="color:#F00;">立即上传</a></p>  
                            <p style="margin-top:10px;">
                            	<form style="float:left;" enctype="multipart/form-data" method="post" action="/main/ajax/suc/project_fqsuc_ds.php" id="suc_form" name="project_form"><input type="file" id="upfile" class="" name="upfile">
                                
								</form>
                              <a class="qr_btn" style=" color:#FFF" title="" href="javascript:void 0">确认上传</a>  
                              <div class="clearfix"></div>
                            </p>   
                                             
                        </td>
                      </tr>
                      
 						<tr style="display:none" id="award_tr">
                              <td class="td_title2 p_tb8">开奖号码</td>
                            <td id="award" class="con_content p_tb8">
                             <b class="ba-red">10</b> <b class="ba-red">11</b> <b class="ba-red">13</b> <b class="ba-red">21</b> <b class="ba-red">27</b> <b class="ba-red">31</b> <b class="ba-blue">01</b>                            
                             </td>
                        </tr>
                        <tr style="display:none" id="wininfo_tr"><td class="td_title2 p_tb8">中奖情况</td>
                           <td id="wininfo" class="con_content p_tb8"><p>未中奖</p></td>
                        </tr> 
                                                                     
                      <tr id="wyrg_tr">
                        <td class="td_title2">我要认购</td>
                        <td class="con_content">                        	    
                        	    <div id="istate" style="display: none;">该方案已停止认购，原因：已满员（时间：2011-11-16 22:19:22）</div>                        	
							<!--   	onclick="Y.openUrl('/trade/main/project_baodi.html?lotid=1&playid=3&pid=13006339',530,220)" -->
                        		<div id="shbd" style="display: none;">
                        			<a href="javascript:void 0">点击此处对该方案保底</a>
                        		</div>
                        		<div id="wyrg" style="display: block;">
	                        		<div class="buy_btn">
	                                    <a title="立即购买" class="btn_buy_m" href="javascript:void 0" id="submitCaseBtn3">立即购买</a>
	                                </div>
	                                
	                                <p id="userMoneyInfo">您尚未登录，请先<a onclick="Yobj.postMsg('msg_login')" title="" href="javascript:void 0">登录</a>！</p>
	                                <p>还可以认购 <span id="lnumstr" class="red eng">888</span> 份，我要认购
	                                <input type="text" onkeydown="if(event.keyCode==13){checkForm();return false;}" onkeyup="this.value=Y.getInt(this.value)" value="1" class="mul" id="buynum" name="buynum">
	                                份 总金额<span class="red eng">￥</span><span id="permoney" class="red eng">1.00</span>元</p>
	                                <p class="read"><span class="hide_sp"><input type="checkbox" value="1" id="agreement" checked="checked"></span>我已阅读并同意《<a id="yhhmxy" href="javascript:void 0">用户合买代购协议</a>》</p>
										<input type="hidden" id="agreement2" value="1">
									<!-- 	onclick="Y.openUrl('http://trade.9188.com/main/agreement.php?lotid=3&playid=3',505,426)" -->
                        		</div>
                          </td>
                     </tr>     
                     
		                <input type="hidden" value="" id="smoney" name="smoney">
		                <input type="hidden" value="0" id="lnum" name="lnum">
		                <input type="hidden" value="50" id="lotid" name="lotid">
		                <input type="hidden" value="50102032870" id="projid" name="projid">    
		                <input type="hidden" value="" id="pnum" name="pnum">
		                <input type="hidden" value="" id="codestr" name="codestr">   
                         
                      </tbody></table>
                </div>
                
               <div id="xx2">
                    <div class="det_g_t">方案分享信息</div>
                    <table cellspacing="0" cellpadding="0" border="0" width="100%" class="buy_table">
   						<tbody><tr id="fqrcd" style="display: none;">
					      <td class="td_title2">发起人撤单</td>
					      <td class="con_content"><a class="btn_dot1" onclick="return main_return_confirm();" href="javascript:void(0)">点击此处对该方案进行撤单</a></td>
					    </tr>
                              
                      <tr id="faxc_tr">
                        <td class="td_title2">方案宣传</td>
                        <td class="con_content">
                            <div class="detail_d clearfix">
                                  <div class="copy_link"><a id="copystr" class="public_Lblue" href="javascript:void(0);"><b>点击复制方案地址</b></a></div>
                               <p id="cname" class="gray">大奖神马都不是浮云，只要有你参与！</p>
                               <p><font style="display:;word-wrap:break-word;" id="allcontent"><span class="gray">方案描述：</span>
                               	</font></p><div id="cdesc"></div><font style="display:;word-wrap:break-word;" id="allcontent">
                               </font>
                                <p></p>
                             </div>   
                                
                        </td>
                      </tr>
                      <tr class="last_tr">
                        <td class="td_title2">合买用户</td>
                        <td class="con_content">
                            <p style="word-wrap:break-word;width:500px;overflow:hidden;">该方案对9188所有网友开放。</p>
                            <div class="yh_tab">
                                <ul class="clearfix">
                                    <li onclick="javascript:Showan(this);" class="" id="joinCount">总参与人数<span id="allnum"></span></li>
                                    <li onclick="javascript:Showan(this);" class="an_cur" id="meyBuy">您的认购记录</li>
                                </ul>
                            </div>
                            <div style="display:;" id="show_list_div"><div style="padding-top: 10px;">暂时没有您的认购信息</div></div>
                        </td>
                      </tr>
                    </tbody></table>
                </div>
            </div>
                
            </div>
           </div>
<!--content1_end-->


<span class="zhangkai"></span>
<!--content2-->

<!--content2_end-->
<!--content3-->

<span class="zhangkai"></span>

<!--content3_end-->
<!--link-->
<div class="width">
	<div id="i_link" class="fl mt5">
    	<div class="fl" id="i_link_c">
       	  <div id="i_link_text" class="fl red">友情链接</div>
            <div id="i_link_list" class="fl blue">
                	<ul>
                                        <li><a href="http://live.188score.com/" target="_blank">188即时比分</a></li>
                                        <li><a href="http://www.bokone.com/" target="_blank">博控彩票网</a></li>
                                        <li><a href="http://jczq.jcbao.com/" target="_blank">竞彩足球</a></li>
                                        <li><a href="http://www.zq.cc/" target="_blank">ZQ体育</a></li>
                                        <li><a href="http://www.zhenghao.cn/" target="_blank">正好彩票网</a></li>
                                        <li><a href="http://www.c393.com/" target="_blank">彩票社区</a></li>
                                        <li><a href="http://www.wanqq.cn/" target="_blank">七天彩吧</a></li>
                                        <li><a href="http://www.bo724.com/" target="_blank">龙虎博百家料</a></li>
                                        <li><a href="http://www.cntvzb.net/" target="_blank">CNTV直播网</a></li>
                                        <li><a href="http://www.bc123.cc/" target="_blank">博彩导航</a></li>
                                        <li><a href="http://bbs.jbyf.net/" target="_blank">足球论坛</a></li>
                                        <li><a href="http://www.5wzq.com/" target="_blank">我玩足球</a></li>
                                        <li><a href="http://www.bo8bbs.com/" target="_blank">博8足讯</a></li>
                                        <li><a href="http://www.zh89.com/" target="_blank">中彩吧</a></li>
                                        <li><a href="http://www.0500wan.com/" target="_blank">中国彩站</a></li>
                                        <li><a href="http://www.lcw86.com/" target="_blank">龙彩网</a></li>
                                        <li><a href="http://www.cm168.cn/" target="_blank">彩民商城</a></li>
                                        <li><a href="http://www.cjcp.com.cn/" target="_blank">彩经网</a></li>
                                        <li><a href="http://www.21spcn.com/" target="_blank">天波网</a></li>
                                        <li><a href="http://bbs.sc021.com/forum.php" target="_blank">申城论坛</a></li>
                                        <li><a href="http://www.80cp.com/" target="_blank">亿彩网</a></li>
                                        <li><a href="http://www.1zuqiu.com/" target="_blank">壹足球</a></li>
                                        <li><a href="http://www.hubo88.com/" target="_blank">互博足球导航</a></li>
                                        <li><a href="http://www.tiqiu123.com/" target="_blank">足球网址之家</a></li>
                                        <li><a href="http://www.88181.net/" target="_blank">彩票研究院</a></li>
                                        <li><a href="http://www.1zuqiu.com/" target="_blank">壹足球</a></li>
                                        <li><a href="http://www.lcw86.com/" target="_blank">大乐透预测</a></li>
                                        <li><a href="http://www.cm168.cn/" target="_blank">彩民商城</a></li>
                                        <li><a href="http://www.cjcp.com.cn/" target="_blank">彩经网</a></li>
                                        <li><a href="http://www.fs0757.com/cp/" target="_blank">佛山彩票</a></li>
                                        <li><a href="http://www.bffcw.com/" target="_blank">北方福彩网</a></li>
                                        <li><a href="http://bbs.17999.net/" target="_blank">金彩网论坛</a></li>
                                        <li><a href="http://www.hy500.com/portal.php" target="_blank">海洋彩票网</a></li>
                                        <li><a href="http://www.xycai.net/" target="_blank">鑫源彩</a></li>
                                        <li><a href="http://www.taocai.cn/" target="_blank">淘彩网</a></li>
                                        <li><a href="http://tb.178cpw.com/" target="_blank">双色球走势图</a></li>
                                        <li><a href="http://www.95590.com/" target="_blank">3d卓伊</a></li>
                                        <li><a href="http://www.fafacp.net/" target="_blank">双色球预测</a></li>
                                        <li><a href="http://www.tbcaipiao.com/" target="_blank">淘宝彩票论坛</a></li>
                                        <li><a href="http://www.zq99.cc/" target="_blank">足球久久</a></li>
                                        </ul>
            </div>
        </div>
    </div>
    <!--div id="foot_menu" class="fl tc"><font class="blue"><a href="about.html">公司简介</a></font>　<font class="grayd0">|</font>　<font class="blue"><a href="contact.html">联系方式</a></font>　<font class="grayd0">|</font>　<font class="blue"><a href="remittance.html">汇款地址</a></font>　<font class="grayd0">|</font>　<font class="blue"><a href="link.html">友情链接</a></font>　<font class="grayd0">|</font>　<font class="blue"><a href="join.html">加盟合作</a></font>　<font class="grayd0">|</font>　<font class="blue"><a href="sitemap.html">网站地图</a></font>　<font class="grayd0">|</font>　<font class="blue"><a href="customer.html">客服信息</a></font></div-->
</div>
<!--link_end-->
<!--copyright-->
<span class="zhangkai"></span>
<div class="width">
 <div id="foot_menu" class="fl tc">
	<font class="blue"><a href="http://www.jingbo365.com.cn/doc/doc_detail/39">公司简介</a></font>　
	<font class="grayd0">|</font>　<font class="blue"><a href="http://www.jingbo365.com.cn/doc/doc_detail/40">联系方式</a></font>　
	<font class="grayd0">|</font>　<font class="blue"><a href="http://www.jingbo365.com.cn/doc/doc_detail/42">汇款地址</a></font>　
	<font class="grayd0">|</font>　<font class="blue"><a href="http://www.jingbo365.com.cn/doc/doc_detail/53">加盟合作</a></font>　
	<font class="grayd0">|</font>　<font class="blue"><a href="http://www.jingbo365.com.cn/doc/doc_detail/41">网站地图</a></font>　
	<font class="grayd0">|</font>　<font class="blue"><a href="http://www.jingbo365.com.cn/doc/doc_detail/43">客服信息</a></font>
	<font class="grayd0">|</font>　<font class="blue"><a href="mailto:siyew@jingbo365.com">友情链接申请</a></font>
	<font class="grayd0">|</font>　<font class="blue"><a href="http://www.jingbo365.com.cn/doc/doc_detail/83">竞波QQ群</a></font>
	
 </div>
</div>
<span class="zhangkai"></span>
<div id="copyright">
	<div class="width">
    	<div class="gray6" id="copyright_text" style="text-align:center">
			<p>Copyright © 2010-2011 竞波365彩票网  上海竞搏信息科技有限公司  All rights reserved. 沪ICP备11025247号  <a href="http://www.surlink.com.cn/" target="_blank">上海思锐</a></p>
            <p>客服热线：400-820-2324(免收长途费) 021-61176880(早8:00-凌晨2:00) 传真号：021-61176883 </p>
            <p>竞波提醒：本网站信息仅供合法购买中国福利彩票和中国体育彩票分析之用，严禁赌博 彩票有风险，购买要适度。不向未满18岁的青少年出售彩票</p>
        </div>
    </div>
    <div class="width" id="copyright_img" style="text-align:center;">
        <a href="http://www.lottery.gov.cn/" target="_blank"><img src="../images/_img10.gif"></a>
        <a href="http://www.swlc.sh.cn/cams/index.html" target="_blank"><img src="../images/_img11.gif"></a>
<!--        <img src="http://www.jingbo365.com.cn/media/../images/_img12.gif"  />-->        
        <!-- a href="http://www.baic.gov.cn/" target="_blank"><img src="http://www.jingbo365.com.cn/media/../images/_img13.gif"  /></a-->
    </div>
</div>

<script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F32ee1b68bd85cc237c55bdf6314d909a' type='text/javascript'%3E%3C/script%3E"));
</script><script src="../images/h.js" type="text/javascript"></script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-18147286-2']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<!--footer end--><!--copyright_end-->

<script src="../images/pv.gif"></script><div class="sogoutip" style="z-index: 2.14748e+009; visibility: hidden; display: none; "></div><div class="sogoubottom"></div><div id="stophi" style="z-index: 2.14748e+009; "><div class="extnoticebg"></div><div class="extnotice"><h2>关闭提示 <a href="http://www.jingbo365.com.cn/#" title="关闭提示" id="closenotice" class="closenotice">关闭</a></h2><p id="sogouconfirmtxt"></p>  <a id="sogouconfirm" href="http://www.jingbo365.com.cn/#" class="extconfirm">确 认</a> <a id="sogoucancel" href="http://www.jingbo365.com.cn/#" class="extconfirm">取 消</a></div></div><div id="TB_overlay" style="display: none; z-index: 2.14748e+009; " class="TB_overlayBG"></div><iframe class="sogou_sugg_feedbackquan" style="background-image: initial; background-attachment: initial; background-origin: initial; background-clip: initial; background-color: transparent; border-top-style: none; border-right-style: none; border-bottom-style: none; border-left-style: none; border-width: initial; border-color: initial; z-index: 2.14748e+009; display: none; background-position: initial initial; background-repeat: initial initial; " frameborder="0" scrolling="no" src="../images/yun1.htm"></iframe></body><style>.sogou_sugg_feedbackquan {
	position:fixed;
	left:0;
	padding:0;
	margin:0;
	bottom:0;
	width: 100%;
	height: 38px;
}
.sogoutip {
	width:199px;
	height:56px;
	padding:10px 20px 0 15px;
	line-height:18px;
	background:url(http://ht.www.sogou.com/../images/extsugg/sogoutip.gif) no-repeat;
	position:fixed;
	font-size:13px;
	bottom:38px;
	left:150px;
	text-align:left;
	color:#000;
}
.closesogoutip {
	width:9px;
	height:8px;
	background:url(http://ht.www.sogou.com/../images/extsugg/sogoutip.gif) no-repeat left -72px;
	line-height:10em;
	overflow:hidden;
	right:8px;
	top:7px;
	position:absolute;
}
.sogoubottom{
	clear:both;
	height:40px;
	width:100%;
	padding:0;
	margin:0;
	position:relative;
	z-index:-99;
}
.extoptboxbg {
	background:url(http://ht.www.sogou.com/../images/extsugg/optbox.png) no-repeat;
	width:144px;
	height:109px;
	position:fixed;
	right:16px;
	bottom:35px;
}
.extoptbox {
	width:127px;
	height:75px;
	position:fixed;
	right:25px;
	bottom:57px;
	line-height:22px;
	font-size:12px;
}
.extoptbox a,.extoptbox a:hover {
	color:#426BBD;
	display:block;
	padding-left:9px;
	text-decoration:none;
	text-align:left;
}
.extoptbox a:hover {
	background-color:#EAF1F5;
}
.extfeedback {
	border-top:1px solid #ccc;
	margin-top:4px;
	padding-top:4px;
}
.extnoticebg {
	margin:0;
	left:0;
	top:0;
	width:418px;
	height:185px;
	background:url(http://ht.www.sogou.com/../images/extsugg/noticebg.png) no-repeat;
	position:absolute;
}
.extnotice {
	width:402px;
	height:169px;
	position:absolute;
	left:8px;
	top:8px;
	font-size:14px;
	text-align:center;
	color:#000;
}
.extnotice h2 {
	line-height:29px;
	padding:0 9px;
	font-size:13px;
	text-align:left;
	color:#000;
}
.extnotice p {
	margin:28px 0 33px;
	color:#000;
}
.extconfirm, .extconfirm:hover {
	width:63px;
	height:23px;
	line-height:23px;
	display:inline-block;
	font-weight:bold;
	color:#515F68;
	margin:0 20px;
	background:#D7E5ED;
	filter:progid:DXImageTransform.Microsoft.gradient(startcolorstr=#ECF2F6,endcolorstr=#D7E5ED,gradientType=0);
	background:-webkit-gradient(linear, left top, left bottom, from(#ECF2F6), to(#D7E5ED));
	text-decoration:none;
	border:1px solid #89B4E1;
}
.closenotice {
	width:14px;
	height:14px;
	background:#fff url(http://ht.www.sogou.com/../images/extsugg/ui2.1.gif) no-repeat 2px -313px;
	border:1px solid #B1CBE8;
	position:absolute;
	right:7px;
	top:7px;
	overflow:hidden;
	line-height:100em;
}
.closenotice:hover {
	background-position: 2px -338px;
}
#TB_overlay {
	position: fixed;
	z-index:100;
	top: 0px;
	left: 0px;
	height:100%;
	width:100%;
}

.TB_overlayMacFFBGHack {background: url(macFFBgHack.png) repeat;}
.TB_overlayBG {
	background-color:#000;
	filter:alpha(opacity=25);
	-moz-opacity: 0.25;
	opacity: 0.25;
}

* html #TB_overlay { /* ie6 hack */
	position: absolute;
	height: expression(document.body.scrollHeight > document.body.offsetHeight ? document.body.scrollHeight : document.body.offsetHeight + 'px');
}

#TB_HideSelect{
	z-index:99;
	position:fixed;
	top: 0;
	left: 0;
	background-color:#fff;
	border:none;
	filter:alpha(opacity=0);
	-moz-opacity: 0;
	opacity: 0;
	height:100%;
	width:100%;
}

* html #TB_HideSelect { /* ie6 hack */
	position: absolute;
	height: expression(document.body.scrollHeight > document.body.offsetHeight ? document.body.scrollHeight : document.body.offsetHeight + 'px');
}

#stophi {
	position: fixed;
	z-index: 102;
	display:none;
	top:50%;
	left:50%;
	width:418px;
	height:185px;
}

* html #stophi { /* ie6 hack */
	position: absolute;
	margin-top: expression(0 - parseInt(this.offsetHeight / 2) + (TBWindowMargin = document.documentElement && document.documentElement.scrollTop || document.body.scrollTop) + 'px');
}
</style></html>