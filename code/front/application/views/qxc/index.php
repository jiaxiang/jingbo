<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-七星彩</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<?php
echo html::script(array
(
	'media/lottnum/js/jquery',
	'media/lottnum/js/ajaxfileupload',
	'media/lottnum/js/utils',
    'media/js/yclass.js',
	'media/js/loginer',	
	'media/lottnum/js/choose',
	'media/lottnum/js/qxc.js?v=201110110',
), FALSE);
echo html::stylesheet(array
(
    'media/lottnum/style/style',
	'media/lottnum/style/hxpublic',
    
), FALSE);
?>
<style>
#ic7_cr_con ul.ic_cr_con {
    font: 12px/22px "宋体";
    height: 111px;
    overflow: hidden;
}
</style>
</head><body>
	<!--top小目录-->
	<?php echo View::factory('header')->render();?> 	
	<div class="clearboth"></div>
	<div class="guide">您现在的位置：<a title="网上买彩票" href="/">首页</a> &gt; <a title="七星彩" href="/dlt/">七星彩</a>
	</div>
<!--menu和列表_end-->
<!--content1-->
<div class="width">
	<!--大乐透开始--> 
    	<div class="b-top">
			<div class="b-top-inner">
				<h2 title="七星彩" class="qxc-logo">七星彩</h2>
				<div class="b-top-info">
				<span id="expect_tab"></span>

                <span>2元赢取
<b class="red f14">500万</b>
，每周二、五、日晚20:30开奖！
<b class="bg-xs m-t5"></b>
                                  
                </span>

				</div>
				<dl class="b-top-nav">
				  <dt>
					<a class="on" title="" href="/qxc">选号投注</a>
					<a class="" title="" href="/buycenter/lottnumpub/10/">参与合买</a>
					<!-- <a  title="" class="">定制跟单</a> -->
					<!-- <a target="_blank" href="/useraccount/" class="" title="">我的方案</a> -->
				  </dt>
				 <dd id="playTabsDd">
				   				    <a class="on" title="" href="javascript:void 0"><em>普通投注</em><s></s></a>
				    <a title="" href="javascript:void 0" class=""><em>单式上传</em><s></s></a>
<!-- 				    <a href="javascript:void 0" title=""><em>多期机选</em><s></s></a> -->
				 </dd>
				</dl>
				<div class="b-top-tips">
					<div class="b-top-ql"><!-- <a target="_blank" title="七星彩走势图表" href="/zst/lt/info/jb/30.html">七星彩走势图表</a>|<a title="七星彩玩法介绍" href="/help/help_dlt.html">七星彩玩法介绍</a> -->&nbsp;</div>
					<div class="b-top-time">
					截止时间：
					<span id="endTimeSpan"></span> 
				<span id="countDownSpan"></span></span>
				 </div>
				</div>
			</div>
			<b class="b-left"></b><b class="b-right"></b> 
		</div>     
        
        <div class="main"  id="sd">
        	<div class="content">
				<div class="c-wrap">
                    <div style="display: block;" id="pttz" class="c-inner p-t20 qc-sl-nb">
						<div class="c-select sz-pl-a">
							<div class="c-s-t">
								<h3><em>每位至少选择1个号码球 </em><b class="c-h3-l"></b><b class="c-h3-r fix-ie6-poa"></b></h3>
								<b class="c-t-l"></b>
								<b class="c-t-r"></b>
							</div>
							<div style="top:28px;" class="c-s-side">
								<strong>第一位</strong>
								<!--<strong class="c-s-hide">遗&nbsp;&nbsp;&nbsp;漏</strong>-->
							</div>
							<ul class="c-s-num">
								<li><b>0</b><b>1</b><b>2</b><b>3</b><b class="">4</b><b>5</b><b>6</b><b>7</b><b>8</b><b>9</b><a href="javascript:void 0" title="" class="public_gray m-l-sd"><b>全</b></a><a href="javascript:void 0" title="" class="public_gray"><b>大</b></a><a href="javascript:void 0" title="" class="public_gray"><b>小</b></a><a href="javascript:void 0" title="" class="public_gray"><b>奇</b></a><a href="javascript:void 0" title="" class="public_gray"><b>偶</b></a><a href="javascript:void 0" title="" class="public_gray"><b>清</b></a></li>
								<!--<li><i style="color: rgb(177, 177, 177);">8</i><i style="color: rgb(177, 177, 177);">14</i><i style="color: rgb(177, 177, 177);">4</i><i style="color: red;">49</i><i style="color: rgb(177, 177, 177);">3</i><i style="color: rgb(177, 177, 177);">20</i><i style="color: rgb(177, 177, 177);">0</i><i style="color: rgb(177, 177, 177);">1</i><i style="color: rgb(177, 177, 177);">15</i><i style="color: rgb(177, 177, 177);">2</i></li>-->
							</ul>
						</div>
						<div class="c-select sz-pl-a m-t">
							<div class="c-s-side">
								<strong>第二位</strong>
								<!--<strong class="c-s-hide" style="">遗&nbsp;&nbsp;&nbsp;漏</strong>-->
							</div>
							<ul class="c-s-num">
								<li><b>0</b><b>1</b><b>2</b><b>3</b><b>4</b><b>5</b><b>6</b><b>7</b><b>8</b><b>9</b><a href="javascript:void 0" title="" class="public_gray m-l-sd"><b>全</b></a><a href="javascript:void 0" title="" class="public_gray"><b>大</b></a><a href="javascript:void 0" title="" class="public_gray"><b>小</b></a><a href="javascript:void 0" title="" class="public_gray"><b>奇</b></a><a href="javascript:void 0" title="" class="public_gray"><b>偶</b></a><a href="javascript:void 0" title="" class="public_gray"><b>清</b></a></li>
								<!--<li><i style="color: rgb(177, 177, 177);">2</i><i style="color: rgb(177, 177, 177);">4</i><i style="color: rgb(177, 177, 177);">3</i><i style="color: rgb(177, 177, 177);">19</i><i style="color: rgb(177, 177, 177);">1</i><i style="color: rgb(177, 177, 177);">14</i><i style="color: rgb(177, 177, 177);">0</i><i style="color: red;">29</i><i style="color: rgb(177, 177, 177);">10</i><i style="color: rgb(177, 177, 177);">5</i></li>-->
							</ul>
						</div>
						<div class="c-select sz-pl-a m-t">
							<div class="c-s-side">
								<strong>第三位</strong>
								<!--<strong class="c-s-hide">遗&nbsp;&nbsp;&nbsp;漏</strong>-->
							</div>
							<ul class="c-s-num">
								<li><b>0</b><b>1</b><b>2</b><b>3</b><b>4</b><b>5</b><b>6</b><b>7</b><b>8</b><b>9</b><a href="javascript:void 0" title="" class="public_gray m-l-sd"><b>全</b></a><a href="javascript:void 0" title="" class="public_gray"><b>大</b></a><a href="javascript:void 0" title="" class="public_gray"><b>小</b></a><a href="javascript:void 0" title="" class="public_gray"><b>奇</b></a><a href="javascript:void 0" title="" class="public_gray"><b>偶</b></a><a href="javascript:void 0" title="" class="public_gray"><b>清</b></a></li>
								<!--<li><i style="color: rgb(177, 177, 177);">8</i><i style="color: rgb(177, 177, 177);">2</i><i style="color: rgb(177, 177, 177);">1</i><i style="color: rgb(177, 177, 177);">0</i><i style="color: rgb(177, 177, 177);">29</i><i style="color: rgb(177, 177, 177);">4</i><i style="color: rgb(177, 177, 177);">3</i><i style="color: rgb(177, 177, 177);">12</i><i style="color: rgb(177, 177, 177);">11</i><i style="color: red;">41</i></li>-->
							</ul>
						</div>
						<div class="c-select sz-pl-a m-t">
							<div class="c-s-side">
								<strong>第四位</strong>
								<!--<strong class="c-s-hide" style="">遗&nbsp;&nbsp;&nbsp;漏</strong>-->
							</div>
							<ul class="c-s-num">
								<li><b>0</b><b>1</b><b>2</b><b>3</b><b>4</b><b>5</b><b>6</b><b>7</b><b>8</b><b>9</b><a href="javascript:void 0" title="" class="public_gray m-l-sd"><b>全</b></a><a href="javascript:void 0" title="" class="public_gray"><b>大</b></a><a href="javascript:void 0" title="" class="public_gray"><b>小</b></a><a href="javascript:void 0" title="" class="public_gray"><b>奇</b></a><a href="javascript:void 0" title="" class="public_gray"><b>偶</b></a><a href="javascript:void 0" title="" class="public_gray"><b>清</b></a></li>
								<!--<li><i style="color: rgb(177, 177, 177);">3</i><i style="color: rgb(177, 177, 177);">16</i><i style="color: rgb(177, 177, 177);">2</i><i style="color: rgb(177, 177, 177);">7</i><i style="color: rgb(177, 177, 177);">8</i><i style="color: rgb(177, 177, 177);">10</i><i style="color: rgb(177, 177, 177);">0</i><i style="color: rgb(177, 177, 177);">1</i><i style="color: rgb(177, 177, 177);">19</i><i style="color: red;">30</i></li>-->
							</ul>
						</div>
						<div class="c-select sz-pl-a m-t">
							<div class="c-s-side">
								<strong>第五位</strong>
								<!--<strong class="c-s-hide" style="">遗&nbsp;&nbsp;&nbsp;漏</strong>-->
							</div>
							<ul class="c-s-num">
								<li><b>0</b><b>1</b><b>2</b><b>3</b><b>4</b><b>5</b><b>6</b><b>7</b><b>8</b><b>9</b><a href="javascript:void 0" title="" class="public_gray m-l-sd"><b>全</b></a><a href="javascript:void 0" title="" class="public_gray"><b>大</b></a><a href="javascript:void 0" title="" class="public_gray"><b>小</b></a><a href="javascript:void 0" title="" class="public_gray"><b>奇</b></a><a href="javascript:void 0" title="" class="public_gray"><b>偶</b></a><a href="javascript:void 0" title="" class="public_gray"><b>清</b></a></li>
								<!--<li><i style="color: rgb(177, 177, 177);">1</i><i style="color: rgb(177, 177, 177);">6</i><i style="color: rgb(177, 177, 177);">0</i><i style="color: rgb(177, 177, 177);">5</i><i style="color: rgb(177, 177, 177);">18</i><i style="color: red;">20</i><i style="color: rgb(177, 177, 177);">4</i><i style="color: rgb(177, 177, 177);">9</i><i style="color: rgb(177, 177, 177);">13</i><i style="color: rgb(177, 177, 177);">2</i></li>-->
							</ul>
						</div>
						<div class="c-select sz-pl-a m-t">
							<div class="c-s-side">
								<strong>第六位</strong>
								<!--<strong class="c-s-hide">遗&nbsp;&nbsp;&nbsp;漏</strong>-->
							</div>
							<ul class="c-s-num">
								<li><b>0</b><b>1</b><b>2</b><b>3</b><b>4</b><b>5</b><b>6</b><b>7</b><b>8</b><b>9</b><a href="javascript:void 0" title="" class="public_gray m-l-sd"><b>全</b></a><a href="javascript:void 0" title="" class="public_gray"><b>大</b></a><a href="javascript:void 0" title="" class="public_gray"><b>小</b></a><a href="javascript:void 0" title="" class="public_gray"><b>奇</b></a><a href="javascript:void 0" title="" class="public_gray"><b>偶</b></a><a href="javascript:void 0" title="" class="public_gray"><b>清</b></a></li>
								<!--<li><i style="color: rgb(177, 177, 177);">11</i><i style="color: rgb(177, 177, 177);">4</i><i style="color: rgb(177, 177, 177);">16</i><i style="color: red;">24</i><i style="color: rgb(177, 177, 177);">0</i><i style="color: rgb(177, 177, 177);">5</i><i style="color: rgb(177, 177, 177);">7</i><i style="color: rgb(177, 177, 177);">8</i><i style="color: rgb(177, 177, 177);">1</i><i style="color: rgb(177, 177, 177);">21</i></li>-->
							</ul>
						</div>
						<div class="c-select sz-pl-a m-t">
							<div class="c-s-side">
								<strong>第七位</strong>
								<!--<strong class="c-s-hide" style="">遗&nbsp;&nbsp;&nbsp;漏</strong>-->
							</div>
							<ul class="c-s-num">
								<li><b>0</b><b>1</b><b>2</b><b>3</b><b>4</b><b>5</b><b>6</b><b>7</b><b>8</b><b>9</b><a href="javascript:void 0" title="" class="public_gray m-l-sd"><b>全</b></a><a href="javascript:void 0" title="" class="public_gray"><b>大</b></a><a href="javascript:void 0" title="" class="public_gray"><b>小</b></a><a href="javascript:void 0" title="" class="public_gray"><b>奇</b></a><a href="javascript:void 0" title="" class="public_gray"><b>偶</b></a><a href="javascript:void 0" title="" class="public_gray"><b>清</b></a></li>
								<!--<li><i style="color: rgb(177, 177, 177);">17</i><i style="color: rgb(177, 177, 177);">13</i><i style="color: rgb(177, 177, 177);">3</i><i style="color: rgb(177, 177, 177);">4</i><i style="color: rgb(177, 177, 177);">0</i><i style="color: red;">24</i><i style="color: rgb(177, 177, 177);">6</i><i style="color: rgb(177, 177, 177);">2</i><i style="color: rgb(177, 177, 177);">1</i><i style="color: rgb(177, 177, 177);">10</i></li>-->
							</ul>
						</div>
						<div class="c-result m-t20">
							<p id="pt_showbar" class="tc">【您选择了<b class="red"> 0 </b>注，共<b class="red"> ￥0.00 元</b> 】</p>
							<div style="padding-left:37px" class="c-r-ok c-r-ok-rx tr">
								<a id="pt_put" class="s-ok" title="" href="javascript:void 0"></a><a id="pt_clear" class="gray m-trl" title="" href="javascript:void 0">清空全部</a><select class="c-r-z m-t15" id="pt_jx_opts">
								<option value="1">1</option>
								<option value="2">2</option>
								<option selected="" value="5">5</option>
								<option value="10">10</option>
								<option value="20">20</option>
								<option value="50">50</option>
								<option value="100">100</option>
								</select><a id="pt_jx" class="public_Lblue m-t15" title="" href="javascript:void 0"><b>机选</b></a><a id="dd_jx" href="javascript:void 0" title="" class="public_Lblue m-t15"><b>定胆机选</b></a>
							</div>
							<div class="c-r-bet m-t20">
								<ul id="pt_list" class="betList">
                                </ul>
							</div>
							<div class="c-r-l m-t">
								您选择了<span id="pt_zs">0</span>注， <input type="text" maxlength="6" id="pt_bs" value="1" class="i-a" name="ssq">倍，共 <b id="pt_money" class="red">￥0.00 </b>元 <a id="pt_list_clear" class="btn_gray_s" title="" href="javascript:void 0">清空列表</a>
							</div>
						</div>
					</div>	
                    
                  
<!--单式上传-->
<div style="display: none; background: none repeat scroll 0% 0% rgb(255, 255, 255); border-top: 1px solid rgb(238, 238, 238);" id="dsbox">
				
				<div style="background:none;border:none;margin:10px 0 0 90px;position:relative;top:5px;" id="dsnav" class="c-gjwf">
				<!-- <label id="tolr" class=""><input type="radio" name="gjwf2">手动录入</label> -->
				<label id="tochk" class="b"><input type="radio" checked="checked" name="gjwf2">现在上传</label>
				<label id="tosc" class=""><input type="radio" name="gjwf2">先发起后上传</label>
			</div>


				<!--单式：单式录入-->
					<div style="display:none;" id="dslr" class="c-inner b-t0">


						<div style="margin-top:10px;" class="c-way">
							<ul>
								<li class="c-lr"><a onclick="Y.openUrl('/qxc/yb',420,380)" href="javascript:void 0">查看标准格式样本</a></li>
								<li class="c-sm">
									<textarea id="lr_editor" class="c-sm-t" rows="10" cols="10">最多输入1000注，如果大于1000注，请以.txt文件上件！
请参照标准格式: 2,8,4,6,5,3,4</textarea>
								</li>	
								
							</ul>
						</div>
						<div class="c-result m-t20">
							<p class="tc">【已输入 <b id="lr_num" class="red">0 </b>注，最多输入1000注】</p>
							<div style="padding-left:16px" class="c-r-ok tr">
								<a id="lr_put" class="s-ok" title="" href="javascript:void 0"></a><a id="lr_clear" class="gray m-r60" title="" href="javascript:void 0">清空全部</a><select id="lr_opts" name="c-r-z">
								<option value="1">1</option>
								<option value="2">2</option>
								<option selected="" value="5">5</option>
								<option value="10">10</option>
								<option value="20">20</option>
								<option value="50">50</option>
								<option value="100">100</option>
								</select><a id="lr_jx" class="public_Lblue" title="" href="javascript:void 0"><b>机选</b></a>
							</div>
							<div class="c-r-bet m-t20">
								<ul id="lr_list" class="betList">
                                </ul>
							</div>
							<div class="c-r-l m-t">
								您选择了<span id="lr_zs">0</span>注， <input type="text" maxlength="6" id="lr_bs" value="1" class="i-a" name="ssq">倍，共 <b id="lr_money" class="red">￥0.00 </b>元 <a id="lr_list_clear" class="btn_gray_s" title="" href="javascript:void 0">清空列表</a>
							</div>
						</div>
					</div>
					<!--单式：单式录入结束-->
					<!--单式:现在上传和先发起后上传-->
				<div style="display: none;" id="dssc" class="c-inner">
					<div class="c-way">
						
						<ul id="nowupload" style="display: block;">
							<li class="c-lr">								
								<a id="tolr" class="" title="" href="javascript:void 0"><b></b>
											</a>
											<a class="public_Dblue" title="" href="javascript:void 0"><b>.txt文件上传</b>
											<a onclick="Y.openUrl('/qxc/yb',420,380)" href="javascript:void 0">查看标准格式样本</a>
							</li>
							<li>
											<form enctype="multipart/form-data" method="post"
												action="/filecast.go" id="suc_form" name="project_form">
												<input type="file" id="upfile" class="" name="upfile" />
											</form>
										</li>
							<li style="display:none" id="upfile_view" class="update">
								<div class="u-wrap">
									<div class="hd"><i class="u-ico u-txt"></i><span id="upfile_title">未知文档</span></div>
									<div id="up_step_wrap" class="bd"><span class="ico_loading"></span> 正在上传文件， 请稍候...<a id="up_stop" style="margin-left:20px;" onclick="return false;" title="" href="javascript:void(0);">取消</a></div>
									<div id="up_info" class="bd"></div>
								</div>
							</li>
						</ul>
						
						<ul id="up_data" style="display: block;">
							<li class="">
							<span style="display: inline;" id="loadzs">您选择了0</span>
							<span id="inputzs">发起方案 <input type="text" maxlength="6" id="sc_zs_input" class="i-b" name="ssq"></span>注，<input type="text" maxlength="2" value="1" id="sc_bs_input" class="i-a" name="ssq">倍，共 <span id="sc_money" class="red">￥0.00</span>元。 <input type="checkbox" style="display:none" id="scChk">
							</li><li>						
						</li></ul>
						<ul id="up_help" style="display: block;">
							<li class="c-dis">
								<em><b class="i-tp"></b>上传说明：</em>
								<ul>
									<li>1、请严格参照"标准格式样本"格式上传方案。</li>
									<li>2、文件格式必须是.txt格式，单个文件大小不能超过10M。</li>
									<li>3、由于上传的文件较大，会导致上传时间及在本页停留时间较长，请耐心等待。</li>
								</ul>
							</li>						
						</ul>
					</div>
				</div>
				<!--单式:现在上传和先发起后上传结束-->
				<input name="hasddsh" type="hidden" value=""/>
			<input name="ddsh" type="hidden" value=""/>
			<input name="codes" id="codes" type="hidden" value=''/><!--号码-->
			<input name="zhushu" id="zhushu" type="hidden" value="1"/><!--注数-->
			<input name="beishu" id="beishu" type="hidden" value="1"/><!--注数-->
			<input name="totalmoney" id="totalmoney" type="hidden" value="0"/><!--方案金额-->

			<input name="beishu_list" id="beishu_list" type="hidden" value=""/><!--投注了的倍数列表-->
			<input name="expect_list" id="expect_list" type="hidden" value=""/><!--投注了的期号列表-->
			<!--系统及配置信息-->
			<input name="lottid" id="lottid" type="hidden" value="10"/><!--彩种Id-->
			<input name="lotid" id="lotid" type="hidden" value="10"/><!--彩种Id-->
			<input name="playid" id="playid" type="hidden" value="3"/><!--玩法Id-->
			<input name="wtype" id="wtype" type="hidden" value="3"/><!--玩法Id-->
			<input name="playid2" id="playid2" type="hidden" value="1"/><!--用于图表玩法Id-->			
			<input name="expect" id="expect" type="hidden" value="这里没有赋值"/><!--期号-->
			<input name="isupload" id="isupload" type="hidden" value="1"/>
			<input name="msgmode" id="msgmode" type="hidden" value="1"/>

			<input name="dschk" id="dschk" type="hidden" value="1"/>
			
			<!--其他-->
			<input name="ishm" id="ishm" type="hidden" value="0"/>
			<input name="ischase" id="ischase" type="hidden" value="0"/>
			<input name="isshow" id="isshow" type="hidden" value="0"/>
			<input name="isbaodi" id="isBaodi" type="hidden" value="0"/>
			<input name="tc_bili" id="tc_bili" type="hidden" value="0"/>
			<input name="lastexpect" id="lastexpect" type="hidden" value="11358"/>

			<input name="money_limit" id="money_limit" type="hidden" value="2.0,10000000,,">
		</div>
		<!--单式上传结束-->
<!--多期机先-->
<div style="display:none;padding:0" id="dqjx" class="c-inner">
						<table width="100%" cellspacing="0" cellpadding="0" border="0" class="buy_table">
						  <tbody>
						   <tr>
							<td class="td_title">单期注数</td>
							<td class="td_content"><p class="td-pl">每期机选 <input type="text" maxlength="6" id="dq_zs" class="i-a" name="ssq"> 注 <input type="text" maxlength="6" value="1" id="dq_bs" class="i-a" name="ssq"> 倍 <span class="gray">根据您指定的注数(每期最多10注)，每期系统自动机选不同号码</span></p>
							</td>
						  </tr>
						</tbody>
						</table>
</div>
<!--多期机先结束-->
					<div id="all_form" class="buy_sort">
						<span class="title">购买方式</span>
						<span class="sort">
						<label for="rd3" class="m_r25">
						<input type="radio" name="radio_g2" id="rd3" value="1" checked="checked" class="m_r3">代购</label>
						<label for="rd4" class="m_r25 b">
						<input type="radio" name="radio_g2" id="rd4" value="0" class="m_r3">合买</label>
						</span>
						<em class="r i-qw"></em><span class="r gray">由购买人自行全额购买彩票</span>
					</div>
					<div class="con">
						<div "="" id="dg_form" style="display: block;">
							<table cellspacing="0" cellpadding="0" border="0" width="100%" class="buy_table">
							  <tbody><tr class="last_tr">
								<td class="td_title">确认购买</td>
								<td class="td_content">
									<div class="buy_info">
										<p id="userMoneyInfo">您尚未登录，请先<a onclick="Yobj.postMsg('msg_login')" title="" href="javascript:void 0">登录</a></p>
										<p>本次投注金额为<strong id="buyMoneySpan" class="red eng">￥0.00</strong>元<span style="display:none" class="if_buy_yue">， 购买后您的账户余额为 <strong id="buySYSpan" class="red eng">￥0.00</strong>元</span></p>
										<p><span class="hide_sp"><input type="checkbox" id="agreement_dg" checked=""></span>我已阅读并同意《<a onclick="Y.openUrl('/qxc/agreement',530,500)" href="javascript:void 0">用户合买代购协议</a>》</p>
										<!-- <p class="agreement"><span class="hide_sp"><input type="checkbox" id="agreement_dg2" checked="checked"></span>彩票发行中心对排列三进行<a href="javascript:void 0">限号管理</a>，我已阅读并同意网站<br><a onclick="Y.openUrl('risknotice.html',530,500)" href="javascript:void 0">《排列五投注风险须知》</a></p> -->
									</div>
									<div class="buy_btn">
										<!-- a id="buy_dg" onclick="return false" href="javascript:void 0" class="btn_buy_m" title="立即购买">立即购买</a-->
									</div>
								</td>
							  </tr>
							</tbody></table>
						</div>
						<div "="" id="hm_form" style="display: none;">
							<table cellspacing="0" cellpadding="0" border="0" width="100%" class="buy_table">
							  <tbody><tr>
								<td class="td_title">合买设置</td>
								<td class="td_content">
									<p><span class="hide_sp red eng">*</span><span class="align_sp">我要分为：</span><input disabled='' type="text" id="fsInput" name="allnum" class="mul" value="1" >份，  每份<span id="fsMoney" class="red eng">￥0.00</span>元  <span class="gray">每份至少1元</span><span id="fsErr" style="display:none" class="tips_sp">！每份金额不能除尽，请重新填写份数</span></p>

							<p><span class="hide_sp"></span><span class="align_sp">我要提成：</span><select id="tcSelect" name="tc" class="selt">
							 <option value="0">0</option>
							 <option value="1">1</option>
							 <option value="2">2</option>
							 <option value="3">3</option>
							 <option value="4">4</option>
							 <option value="5" selected="selected">5</option>
							 <option value="6">6</option>
							 <option value="7">7</option>
							 <option value="8">8</option>
							 </select>% <s data-help="&lt;h5&gt;什么是提成？&lt;/h5&gt;&lt;p&gt;发起人提取税后奖金的一定比例作为提成。&lt;/p&gt;
												        &lt;p&gt;&lt;font color='red'&gt;&lt;strong&gt;提成条件：&lt;/strong&gt;&lt;/font&gt;税后奖金&mdash;提成金额&gt;方案金额&lt;/p&gt;
												        &lt;p&gt;&lt;font color='red'&gt;&lt;strong&gt;计算公式：&lt;/strong&gt;&lt;/font&gt;提成金额=盈利部分（税后奖金-方案金额）*提成比例&lt;/p&gt;
												        &lt;p&gt;示例&lt;/p&gt;
												        &lt;p&gt;方案金额：1000元；税后奖金：2000元；&lt;/p&gt;       
												        &lt;p&gt;提成比例：5%；提成金额：(2000-1000)*5%=50元&lt;/p&gt;
												        &lt;p&gt;提成条件判断：2000-100&gt;1000元&lt;/p&gt;
												        &lt;p&gt;实际提成：50元&lt;/p&gt;" class="i-qw"></s>
							</p>
							<p><span class="hide_sp"></span><span class="align_sp">是否公开：</span>
							<label for="gk1" class="m_r25">
							<input type="radio" value="0" name="gk" id="gk1" checked="checked" class="m_r3">完全公开</label>
							<label for="gk2" class="m_r25">
							<input type="radio" value="1" name="gk" id="gk2" class="m_r3">截止后公开</label>
							</p>
							<p><span class="hide_sp"></span><span class="align_sp"></span>
							<label for="gk3" class="m_r25"><input type="radio" value="2" name="gk" id="gk3" class="m_r3">仅对跟单用户公开</label>
							<label for="gk4" class="m_r25"><input type="radio" value="3" name="gk" id="gk4" class="m_r3">截止后对跟单用户公开</label></p>

								</td>
							  </tr>
							  <tr>
								<td class="td_title">认购设置</td>
								<td class="td_content">
									<div class="buy_info p-l0">
										<p><span class="hide_sp"></span><span id="userMoneyInfo2">您尚未登录，请先<a onclick="Yobj.postMsg('msg_login')" title="" href="javascript:void 0">登录</a></span></p>
										<p><span class="hide_sp red eng">*</span><span class="align_sp">我要认购：</span><input type="text" id="rgInput" name="buynum" class="mul" value="1">份，<span id="rgMoney" class="red eng">￥0.00</span>元（<span id="rgScale">0</span>%）<span style="display:none" id="rgErr" class="tips_sp">！至少需要认购3份</span></p>
										<p><span class="hide_sp"><input type="checkbox" id="isbaodi"></span><span class="align_sp">我要保底：</span><input type="text" disabled="" id="bdInput" name="baodinum" class="mul" value="0">份，<span id="bdMoney" class="red eng">￥0.00</span>元（<span id="bdScale">0</span>%）<s data-help="&lt;h5&gt;什么是保底？&lt;/h5&gt;&lt;p&gt;发起人承诺合买截止后，如果方案还没有满员，发起人再投入先前承诺的金额以最大限度让方案成交。最低保底金额为方案总金额的20%。保底时，系统将暂时冻结保底资金，在合买截止时如果方案还未满员的话，系统将会用冻结的保底资金去认购方案。如果在合买截止前方案已经满员，系统会解冻保底资金。&lt;/p&gt;" class="i-qw"></s><span id="bdErr" style="display:none" class="tips_sp">！最低保底20%</span></p>
										<p class="agreement"><span class="hide_sp"><input type="checkbox" id="agreement_hm" checked="checked"></span>我已阅读并同意《<a onclick="Y.openUrl('/qxc/agreement',530,500)" href="javascript:void 0">用户合买代购协议</a>》</p>
										<!-- <p class="agreement"><span class="hide_sp"><input type="checkbox" id="agreement_hm2" checked="checked"></span>彩票发行中心对排列三进行<a target="_blank" title="限号管理" href="xianhao.html">限号管理</a>，我已阅读并同意网站<br><a onclick="Y.openUrl('risknotice.html',530,500)" href="javascript:void 0">《排列五投注风险须知》</a></p> -->
									</div>
									<div class="buy_btn">
										<!-- a id="buy_hm" class="btn_buy_hm" title="发起合买">发起合买</a-->
									</div>
								</td>
							  </tr>
							  <tr>
								<td class="td_ge_t">可选信息</td>
								<td class="td_ge">
									<p class="ge_selt p-l0"><span class="hide_sp"><input type="checkbox" id="moreCheckbox"></span>方案宣传与合买对象</p>
									<p class="ge_tips">帮助您进行方案宣传和选择合买对象。</p>
								</td>
							  </tr>
							  <tr style="display:none" id="case_ad">
								<td class="td_title">方案宣传</td>
								<td class="td_content">
									<p><span class="hide_sp"></span><span class="align_sp">方案标题：</span><input type="text" name="title" id="caseTitle" class="t_input" value="好方案，中大奖木有鸭梨！" maxlength="20"><span class="gray">已输入0个字符，最多20个</span></p>
									<p><span class="hide_sp"></span><span class="align_sp">方案描述：</span><textarea id="caseInfo" cols="10" rows="10" class="p_input" name="content">说点什么吧，让您的方案被更多彩民认可．．．</textarea><span class="gray">已输入0个字符，最多200个</span></p>
									</td>
							  </tr>
							  <!-- <tr style="display:none" id="hm_target" class="last_tr">
								<td class="td_title">合买对象</td>
								<td class="td_content">
									<p><span class="hide_sp"></span><label class="m_r25" for="dx1"><input type="radio" class="m_r3" id="dx1" name="zgdx" checked="checked">竞波所有彩友可以合买</label><label class="m_r25" for="dx2"><input type="radio" class="m_r3" id="dx2" name="zgdx">只有固定的彩友可以合买</label></p>
									<div style="display:none" id="fixobj">
										<p><span class="hide_sp"></span><span class="align_sp"></span><textarea cols="10" rows="10" class="p_input" name="buyuser"></textarea></p>
										<p><span class="hide_sp"></span><span class="gray">[注]限定彩友的格式是：aaaaa,bbbbb,ccccc,ddddd（,为英文状态下的逗号）</span></p>			
									</div>
								</td>
							  </tr> -->
							</tbody></table>
						</div>
						<div "="" id="zh_form" style="display:none">
							<table cellspacing="0" cellpadding="0" border="0" width="100%" class="buy_table">
							  <tbody>
							  <tr>
								<td class="td_title">期数选择</td>
								<td class="td_content">
									<div class="td-pl">
										<p><select class="td_qs m-r" id="zh_opts" name="qs">
											<option checked="" value="10">追10期</option>
											<option value="20">追20期</option>
											<option value="30">追30期</option>
											<option value="50">追50期</option>
										</select>
										
		<select id="tzzh" name="zhflag">
		<option value="0">中奖后不停止</option>
		<option value="1">中奖后停止</option>
		<option selected="" value="2">盈利后停止</option>
		</select>										
										
										
										<a target="_blank" title="" href="/help/help_1_11.html">查看追号规则</a></p>
										
										<div class="qs_list">
											<ul id="zh_list"><li style="color:#0080FF">正在加载追号数据, 请稍后...</li>
											</ul>
										</div>
									</div>
								</td>
							  </tr>
<!-- 							   <tr> -->
<!-- 								<td class="td_title">追号设置</td> -->
<!-- 								<td class="td_content"> -->
<!-- 									<div class="td-pl"> -->
<!-- 										<label><input type="checkbox" name="ssq" class="" id="zh_isstop" /> 单期奖金≥</label> <input type="text" name="ssq" class="i-b" value="0" id="zh_stopInput" disabled /> 元终止追号<s class="i-qw" data-help="<h5>终止追号</h5><p>当你的单期中奖金额大于你设置的金额时，系统将自动停止追号。</p>"></s><br/> -->
<!-- 										<label><input type="checkbox" name="ssq" class="" checked="checked" id="zh_ismsn"/> 追号余额不足手机短信提示 </label> -->
<!-- 									</div> -->
<!-- 								</td> -->
<!-- 							  </tr> -->
							  <tr class="last_tr">
								<td class="td_title">确认购买</td>
								<td class="td_content">
									<div class="buy_info">
										<p id="userMoneyInfo3">您尚未登录，请先<a onclick="Yobj.postMsg('msg_login')" title="" href="javascript:void 0">登录</a></p>
										<p>本次投注金额为<strong id="buyMoneySpan2" class="red eng">￥0.00</strong>元<span style="display:none" class="if_buy_yue">， 购买后您的账户余额为 <strong id="buySYSpan2" class="red eng">￥0.00</strong>元</span></p>
										<p class="agreement"><span class="hide_sp"><input type="checkbox" id="agreement_zh" checked="checked"></span>我已阅读并同意《<a onclick="Y.openUrl('agreement.html',530,500)" href="javascript:void 0">用户合买代购协议</a>》</p>
										<p class="agreement"><span class="hide_sp"><input type="checkbox" id="agreement_zh2" checked="checked"></span>彩票发行中心对排列三进行<a target="_blank" title="限号管理" href="xianhao.html">限号管理</a>，我已阅读并同意网站<br><a onclick="Y.openUrl('risknotice.html',530,500)" href="javascript:void 0">《排列五投注风险须知》</a></p>
									</div>
									<div class="buy_btn">
										<a id="buy_zh" class="btn_buy_m" title="立即购买">立即购买</a>
									</div>
								</td>
							  </tr>
							</tbody>
							</table>
						</div>
					</div>  
                </div>
				<b class="c-l"></b>
				<b class="c-r"></b>
						<!-- 奖金计算说明开始 -->
			  

			</div>
            <!--右边-->
           <div class="side">
           		<div class="s-td">
						<div class="s-td-in">
							<h2><a target="_blank" title="七星彩开奖公告" href="/kaijiang/gkaijiang.html?lotid=51">七星彩开奖公告</a></h2>
							<dl class="s-kj">
								<dt><strong class="red"></strong></dt>
								<!--<dd>开奖时间：2011-05-29 20:37</dd>-->
								<dd id="kj_opcode" class="clearfix">
								<span class="l"><b class="b-org-20"></b><b class="b-org-20"></b><b class="b-org-20"></b><b class="b-org-20"></b><b class="b-org-20"></b><b class="b-org-20"></b><b class="b-org-20"></b></span>
								<!--<a class="r" target="_blank" href="/kaijiang/p5.html" title="">详情</a>-->
								
								</dd>
							</dl>
							<dl id="s-kj-his">
							<table cellspacing="0" cellpadding="0" border="0" width="100%" class="zj_table">
							<colgroup>
								<col width="30%">
									<col width="70%">
							</colgroup>
							<thead>
							<tr><th class="tc">期号</th>
							<th class="tc">开奖号码</th>
							</tr>
							</thead> 

							</table></dl>
							<div id="opencode5"></div>
							<s class="s-td-l"></s>
							<s class="s-td-r"></s>
						</div>
				</div>

				<div class="jjfp">
                	<div class="tips_m" id="priz_table">
					  <div class="">
						<div style=" border:1px solid #FED6A4;" class="">
						  <div class="dz_title">
							<h2>七星彩奖金计算说明</h2>
							 </div>
						  <div>
							<div>
							  <table width="100%" cellspacing="0" cellpadding="0" class="tablelay eng">
								<tbody><tr>
								  <th>奖级</th>
								  <th>中奖条件</th>
								  <th>奖金分配</th>
								</tr>
								  <tr>
									<td>一等奖</td>
									<td>连续七个号码与开奖号码相同</td>
									<td>浮动奖</td>
								  </tr>
								<tr>
								  <td>二等奖</td>
								  <td>连续六个号码与开奖号码相同</td>
								   <td>浮动奖</td>
								  </tr>
								<tr>
								  <td>三等奖</td>
								  <td>连续五个号码与开奖号码相同</td>
								  <td>1800元</td>
								</tr>
								<tr>
								  <td>四等奖</td>
								  <td>连续四个号码与开奖号码相同</td>
								  <td>300元</td>
								</tr>
								<tr>
								  <td>五等奖</td>
								  <td>连续三个号码与开奖号码相同</td>
								  <td>20元</td>
								</tr>
								<tr>
								  <td>六等奖</td>
								  <td>连续二个号码与开奖号码相同</td>
								  <td>5元</td>
								</tr>         
								</tbody>
							  </table>
							</div>
						  </div>
						</div>
					  </div>
					</div>

                </div>
    			
    
           </div>
         <!--右边结束-->   
            
        </div>
    <!--大乐透结束-->
 		
</div>
<!--content1_end-->


<span class="zhangkai"></span>
<!--content2-->

<!--content2_end-->
<!--content3-->

<span class="zhangkai"></span>

<!--content3_end-->
<!--link-->
<?php echo View::factory('footer')->render();?> 
<!--未登录提示层-->
      <?php echo View::factory('login')->render();?>

<!-- 确认投注内容 -->
<div class="tips_m" style="width:700px;display:none;" id="ishm_dlg">
  <div class="tips_b">
    <div class="tips_box">
      <div class="tips_title">
        <h2 id="ishm_dlg_title">方案合买</h2>
        <span class="close"><a href="javascript:void 0"  id="ishm_dlg_close">关闭</a></span> </div>
          <div class="tips_info tips_info_np" id="ishm_dlg_content"></div>

          <div class="tips_sbt">
        <input type="button" value="确认投注" class="btn_Dora_b" id="ishm_dlg_yes" />
        <a href="javascript:void(0);" class="btn_modifyFont" title="返回修改" id="ishm_dlg_no">返回修改&gt;&gt;</a>
      </div>
    </div>
  </div>
</div>
<!--代购确认-->
<div class="tips_m" style="display:none" id="b2_dlg">
    <div class="tips_b">
        <div class="tips_box">
            <div class="tips_title">
                <h2 id="b2_dlg_title">确认投注内容</h2>

                <span class="close" id="b2_dlg_close"><a href="#">关闭</a></span>
            </div>
            <div class="tips_info"  id="b2_dlg_content"></div>
            <div class="tips_sbt">
                <input type="button" value="取 消" class="btn_Lora_b"  id="b2_dlg_no" /><input type="button" value="确 定" class="btn_Dora_b"  id="b2_dlg_yes" />
            </div>
        </div>
    </div>

</div>
<!--余额不足内容-->
<div class="tips_m" style="top:300px;display:none;" id="addMoneyLay">
	<div class="tips_b">
        <div class="tips_box">
            <div class="tips_title">
                <h2>可用余额不足</h2>

                <span class="close" id="addMoneyClose"><a href="javascript:void 0">关闭</a></span>
            </div>
            <div class="tips_text">
                <p class="pd_l tc f14" id="addMoneyContent">您的可投注余额不足，请充值<br/>(点充值跳到“充值”页面，点“返回”可进行修改)</p>
            </div>
            <div class="tips_sbt">
                <input type="button" value="返 回" class="btn_Lora_b" id="addMoneyNo"/><input type="button" value="充 值" class="btn_Dora_b" id="addMoneyYes" />

            </div>
        </div>
    </div>
</div>

<!--机选弹出层-->
<div class="tips_m" id="jx_dlg" style="width: 300px; display: none; z-index: 500004; position: absolute; left: 561px; top: 420px;">
<div class="tips_b">
<div class="tips_box">
<div class="tips_title" style="cursor: move;">
<h2>机选号码列表</h2><span class="close" id="jx_dlg_close"><a href="#">关闭</a></span></div>
<div class="tips_text">
<ul class="tips_text_list" id="jx_dlg_list" style="height: 120px; overflow: hidden;">
</ul></div>
<div class="tips_sbt"><input type="button" value="重新机选" class="btn_gray_b m-r" id="jx_dlg_re"><input type="button" value="选好了" class="s-ok" id="jx_dlg_ok"></div></div></div></div>
<!--机选弹出层结束-->
<!--不能超...过-->
<div style="top:700px;display:none;position:absolute;width: 500px;" class="tips_m" id="info_dlg">
    <div class="tips_b">
        <div class="tips_box">
            <div class="tips_title">
                <h2>温馨提示</h2>
                <span class="close" id="info_dlg_close"><a href="#">关闭</a></span>
            </div>
            <div class="alert_c">
            	<div class="state error">
           		 <div class="stateInfo f14 p_t10" id="info_dlg_content"></div>
       		  </div>
            </div>
            <div class="tips_sbt">
                <input type="button" class="btn_Dora_b" value="确 定" id="info_dlg_ok" />
            </div>
        </div>
    </div>
</div>
<!--不能超...过结束-->
<!--提示确认-->
<div class="tips_m" style="display:none" id="confirm_dlg">
	<div class="tips_b">

        <div class="tips_box">
            <div class="tips_title">
                <h2 id="confirm_dlg_title">温馨提示</h2>
                <span class="close" id="confirm_dlg_close"><a href="#">关闭</a></span>
            </div>
            <div class="tips_info"  id="confirm_dlg_content"></div>
            <div class="tips_sbt">
                <input type="button" value="取 消" class="btn_Lora_b"  id="confirm_dlg_no" /><input type="button" value="确 定" class="btn_Dora_b"  id="confirm_dlg_yes" />

            </div>
        </div>
    </div>
</div>
</html>