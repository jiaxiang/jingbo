<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-超级大乐透</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<?php
echo html::script(array
(
	//'media/js/fangan',
	'media/lottnum/js/jquery',
    'media/lottnum/js/dlt',
    'media/lottnum/js/ajaxfileupload',
    'media/lottnum/js/utils',
    'media/js/yclass.js',
	'media/js/loginer'
), FALSE);
echo html::stylesheet(array
(
 	//'media/css/public',
	//'media/css/mask',
    //'media/css/style',
    //'media/css/css1',
    'media/lottnum/style/style',
	//'media/lottnum/style/dltstyle',
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
</head>
<body>
<!--top小目录-->
<?php echo View::factory('header')->render();?> 
		<div class="clearboth"></div>
		<div class="guide">
		<div style="float:left; margin-left:20px;">
			您现在的位置：
			<a title="网上买彩票" href="/">首页</a> &gt;
			<a title="超级大乐透" href="/dlt/">超级大乐透</a>
			</div>
			<div style="float:right; margin-right:20px;">
			<span style="float:right">客服电话：<?php echo $site_config['kf_phone_num'];?></span>
			</div>
			<div class="clearboth"></div>
		</div>
		<!--menu和列表_end-->
		<!--content1-->
		<div class="width">
			<!--大乐透开始-->
			<div class="b-top">
				<div class="b-top-inner">
					<h2 title="超级大乐透" class="dlt-logo">
						超级大乐透
					</h2>
					<div class="b-top-info">
						<span id="expect_tab"></span>
						<span><b>超级大乐透</b>每周一、三、六晚20:30开奖，单注最高奖金<b class="red f14">1600万</b>元</span>
						<!--                  <span> <b class="bg-kj m-t5"></b></span>  -->
					</div>
					<dl class="b-top-nav">
						<dt>
							<a class="on" title="" href="/dlt">选号投注</a>
							<a class="" title=""
								href="/buycenter/lottnumpub/8/">参与合买</a>
							<!-- 					<a  title="" class="">定制跟单</a> 
							<a target="_blank" href="/useraccount/" class="" title="">我的方案</a>-->
						</dt>
						<dd id="playTabsDd">
							<a class="on" title="" href="javascript:void 0"><em>标准选号</em>
							</a>
						</dd>
					</dl>
					<div class="b-top-tips">
						<div class="b-top-ql" >&nbsp;
							 <!-- <a target="_blank" title="超级大乐透走势图表"
								href="/zst/lt/info/jb/30.html">超级大乐透走势图表</a>|
							<a title="超级大乐透玩法介绍" href="/help/help_dlt.html">超级大乐透玩法介绍</a> -->
						</div>
						<div class="b-top-time">
							截止时间：
							<span id="endTimeSpan">2011-11-16 19:45:00</span>
							
							</span>
						</div>
					</div>
				</div>
				<b class="b-left"></b><b class="b-right"></b>
			</div>




			<div class="main">
				<div class="content">
					<div class="c-wrap">
						<div id="nav_normal" class="c-gjwf">
							<label class="m-r nav_hot" for="pttz_tab">
								<input type="radio" checked="checked" id="pttz_tab" name="gjwf">
									普通投注
							</label>
							<label class="m-r" for="dssc_tab">
								<input type="radio" id="dssc_tab" name="gjwf">
									单式上传
							</label>
							<label for="dttz_tab" class="m-r"><input type="radio" name="gjwf" id="dttz_tab" />胆拖投注</label> 
							<!-- 						<label for="ddsh_tab" class="m-r"><input type="radio" name="gjwf" id="ddsh_tab"/>定胆杀号</label> -->
							<!-- 						<label for="dqjx_tab" class="m-r"><input type="radio" name="gjwf" id="dqjx_tab"/>多期机选</label> -->
							<label
								data-help="&lt;h5&gt;追加投注&lt;/h5&gt;加奖期间，每注追加1元，单注最高奖金可增至2400万!"
								rel="" class="m-r addpricehelp" for="zjtz_tab" style="">
								<input type="checkbox" rel="addPrice" id="zjtz_tab" class="zh" class="m_r3">
								<em class="red">追加投注</em>
							</label>
						</div>
						<div style="display: none" id="nav_12x2" class="c-gjwf">
							<label class="m-r" for="pttz_tab12">
								<input type="radio" checked="checked" id="pttz_tab12"
									name="gjwf">
								<b>普通投注</b>
							</label>
							<label class="m-r" for="dssc_tab12">
								<input type="radio" id="dssc_tab12" name="gjwf">
									单式录入
							</label>
						</div>
						
						

						<!-- 胆拖投注 -->
						<div style="display: none;" id="dttz" class="c-inner b-t0">
						<div class="c-select">
							<div class="c-s-t">
								<h3><strong>前区胆码区 我认为必出的号码</strong><em>至少选择1个，最多4个</em><b class="c-h3-l"></b><b class="c-h3-r"></b></h3>
								<b class="c-t-l"></b>
								<b class="c-t-r"></b>
							</div>
							<div class="c-s-side">
								<strong>前区胆码</strong>
								<strong class="c-s-hide">遗&nbsp;&nbsp;&nbsp;漏</strong>
							</div>
							<ul id="dt_dan" class="c-s-num">
								<li><b class="">01</b><b class="">02</b><b class="">03</b><b class="">04</b><b>05</b><b>06</b><b class="">07</b><b class="">08</b><b class="">09</b><b class="">10</b><b class="">11</b><b class="">12</b><b>13</b><b>14</b><b>15</b><b>16</b><b>17</b><b>18</b><b>19</b></li>
								
								<li class="m-t"><b>20</b><b class="">21</b><b>22</b><b>23</b><b>24</b><b class="">25</b><b>26</b><b class="">27</b><b class="">28</b><b class="">29</b><b class="">30</b><b class="">31</b><b class="">32</b><b>33</b><b>34</b><b>35</b></li>
							
							</ul>
						</div>
						<div class="c-select c-b-tm m-t20">
							<div class="c-s-t">
								<h3><strong>前区拖码区 我认为可能出的号码</strong><em>至少选择2个</em><b class="c-h3-l"></b><b class="c-h3-r"></b></h3>
								<b class="c-t-l"></b>
								<b class="c-t-r"></b>
							</div>
							<div class="c-s-side">
								<strong>前区拖码</strong>
								<strong class="c-s-hide" style="">遗&nbsp;&nbsp;&nbsp;漏</strong>
							</div>
							<ul id="dt_tuo" class="c-s-num">
								<li><b class="">01</b><b>02</b><b class="">03</b><b class="">04</b><b class="">05</b><b class="">06</b><b class="">07</b><b class="">08</b><b class="">09</b><b class="">10</b><b class="">11</b><b class="">12</b><b class="">13</b><b class="">14</b><b class="">15</b><b class="">16</b><b class="">17</b><b class="">18</b><b class="">19</b></li>
								
								<li class="m-t"><b class="">20</b><b>21</b><b class="">22</b><b class="">23</b><b class="">24</b><b class="">25</b><b class="">26</b><b class="">27</b><b class="">28</b><b class="">29</b><b class="">30</b><b>31</b><b class="">32</b><b class="">33</b><b class="">34</b><b class="">35</b></li>
								
							</ul>
							<div class="c-s-n-op c-s-n-op-a"><select id="dt_tuo_opts">
							    <option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option selected="" value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
								<option value="13">13</option>
								<option value="14">14</option>
								<option value="15">15</option>
								<option value="16">16</option>
								<option value="17">17</option>
								<option value="18">18</option>
								<option value="19">19</option>
								<option value="20">20</option>
								<option value="21">21</option>
								<option value="22">22</option>
								<option value="23">23</option>
								<option value="24">24</option>
								<option value="25">25</option>
								<option value="26">26</option>
								<option value="27">27</option>
								<option value="28">28</option>
								<option value="29">29</option>
								<option value="30">30</option>
								<option value="31">31</option>
								<option value="32">32</option>
								<option value="33">33</option>
								<option value="34">34</option>
								<option value="35">35</option>
								</select> <a id="dt_tuo_jx" href="javascript:void 0" title="" class="public_Lblue"><b>机选</b></a></div>
						</div>
						<div class="c-select c-b-blue m-t20">
							<div class="c-s-t">
								<h3><strong>后区胆码区 我认为必出的号码</strong><em>至多选择1个</em><b class="c-h3-l"></b><b class="c-h3-r"></b></h3>
								<b class="c-t-l"></b>
								<b class="c-t-r"></b>
							</div>
							<div class="c-s-side">
								<strong>后区胆码</strong>
								<strong class="c-s-hide" style="">遗&nbsp;&nbsp;&nbsp;漏</strong>
							</div>
							<ul id="dt_blue" class="c-s-num">
								<li><b>01</b><b>02</b><b>03</b><b>04</b><b>05</b><b class="">06</b><b>07</b><b class="">08</b><b class="">09</b><b class="">10</b><b class="">11</b><b>12</b></li>
								
							</ul>
						</div>
						<div class="c-select c-b-tm m-t20">
							<div class="c-s-t">
								<h3><strong>后区拖码区 我认为可能出的号码</strong><em>至少选择2个</em><b class="c-h3-l"></b><b class="c-h3-r"></b></h3>
								<b class="c-t-l"></b>
								<b class="c-t-r"></b>
							</div>
							<div class="c-s-side">
								<strong>后区拖码</strong>
								<strong class="c-s-hide">遗&nbsp;&nbsp;&nbsp;漏</strong>
							</div>
							<ul id="dt_blue_tuo" class="c-s-num">
								<li><b class="">01</b><b>02</b><b>03</b><b>04</b><b>05</b><b>06</b><b>07</b><b class="">08</b><b class="">09</b><b class="">10</b><b class="">11</b><b class="">12</b></li>
								
							</ul>
							<div class="c-s-n-op c-s-n-op-c"><select id="dt_blue_opts">
							    <option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option selected="" value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
								</select> <a id="dt_blue_jx" href="javascript:void 0" title="" class="public_Lblue"><b>机选</b></a></div>
						</div>
						<div class="c-result m-t20">
							<p class="tc"><span id="dt_status">【前区：胆 <b class="red" id="dt_red_dan_num"> 0 </b> 码，拖 <b class="red" id="dt_red_tuo_num"> 0 </b> 码，后区：胆码 <b class="blue" id="dt_blue_dan_num"> 0 </b> 个，拖码 <b class="blue" id="dt_blue_tuo_num"> 0 </b> 个，共 <b class="red" id="dt_all_num"> 0 </b> 注，共 <b class="red" id='dt_all_money'> ￥0.00 </b> 元】</span> <!-- <a class="hml_ico add2Skep_s" href="javascript:;">加入号码篮</a> --></p>
							<div style="padding-tip:60px;" class="c-r-ok tc">
								<a id="dt_put" class="s-ok" title="" href="javascript:void 0"></a><a id="dt_clear_all" class="gray m-r" title="" href="javascript:void 0">清空全部</a>
							</div>
							<div class="c-r-bet m-t20">
							    <ul id="dt_list" class="betList">
                                <!-- <li style="height: 80px; cursor: pointer;"><div>[<em class="red">前区|胆</em>] <span class="">08,09,11</span></div><div>[<em class="green">前区|拖</em>] <span class="">19,33,35</span></div><div>[<em class="red">后区|胆</em>] <span class="">08</span></div><div><a class="del" href="javascript:void 0" title="">删除</a>[<em class="green">后区|拖</em>] <span class="">01,11</span></div></li> --></ul>
							</div>
							<div class="c-r-l m-t">
									<label data-help="&lt;h5&gt;追加投注&lt;/h5&gt;每注追加1元，单注最高奖金可增至&lt;span class='red'&gt;1600&lt;/span&gt;万!" rel="" class="m-r addpricehelp" for="zjtz2" style=""><input type="checkbox" rel="addPrice" class="i-cr" id="zjtz2" name="gjwf"><em class="red">追加投注</em></label>您选择了<span id="dt_zs">0</span>注 <input type="text" maxlength="3" id="dt_bs" value="1" class="i-a" name="tzbs">倍，共<b id="dt_money" class="red">￥0.00</b>元  <a id="dt_look_more" class="m-r" title="" href="javascript:void 0">查看投注明细</a>
								<!--codeSkep-->
									<!-- <a onclick="return false;" href="javascript:;" title="把号码框中的号码保存到您的号码篮中" class="public_Lblue add2Skep_l"><b><i class="add_ico"></i>加入号码篮</b></a> <a onclick="return false;" href="javascript:;" title="从您的号码篮中选择号码导入到号码框" class="public_Lblue fromSkep"><b><i class="dr_ico"></i>导入号码篮</b></a> -->
								<!--codeSkep-End-->
									<a id="dt_list_clear" class="btn_gray_s" title="" href="javascript:void 0">清空列表</a>
							</div>
						</div>
					</div>
<!-- 胆拖投注结束 -->

						<div style="display: block;" id="pttz" class="c-inner">
							<div class="clearfix">
								<div class="c-red c-dlt-red">
									<div class="c-select">
										<div class="c-s-t">
											<h3>
												<strong>前区</strong><em>至少选择5个号码</em><b class="c-h3-l"></b><b
													class="c-h3-r"></b>
											</h3>
											<b class="c-t-l"></b>
											<b class="c-t-r"></b>
										</div>
										<div class="c-s-side">
											<strong>选择号码</strong>
											<!--遗漏  <strong class="c-s-hide" style="">遗&nbsp;&nbsp;&nbsp;漏</strong> -->
										</div>
										<ul id="pt_red" class="c-s-num">
											<li>
												<b class="">01</b><b class="">02</b><b class="">03</b><b>04</b><b
													class="">05</b><b>06</b><b>07</b><b>08</b><b>09</b><b>10</b><b
													class="">11</b><b class="">12</b>
											</li>

											<li class="m-t">
												<b class="">13</b><b class="">14</b><b class="">15</b><b>16</b><b
													class="">17</b><b>18</b><b>19</b><b>20</b><b>21</b><b>22</b><b
													class="">23</b><b>24</b>
											</li>

											<li class="m-t">
												<b>25</b><b>26</b><b>27</b><b class="">28</b><b class="">29</b><b>30</b><b>31</b><b>32</b><b>33</b><b>34</b><b>35</b>
											</li>

										</ul>
									</div>
									<div class="c-p-a tr">
										<select id="pt_red_sel" name="sele">
											<option selected="" value="5">
												5
											</option>
											<option value="6">
												6
											</option>
											<option value="7">
												7
											</option>
											<option value="8">
												8
											</option>
											<option value="9">
												9
											</option>
											<option value="10">
												10
											</option>
											<option value="11">
												11
											</option>
											<option value="12">
												12
											</option>
											<option value="13">
												13
											</option>
											<option value="14">
												14
											</option>
											<option value="15">
												15
											</option>
											<option value="16">
												16
											</option>
											<option value="17">
												17
											</option>
											<option value="18">
												18
											</option>
										</select>
										<a id="pt_red_jx" href="javascript:void 0" title=""
											class="btn_gray_s">机选前区</a><a id="pt_red_clear"
											href="javascript:void 0" title="" class="a-q"><s
											class="dn"></s>
										</a>
									</div>
								</div>
								<div class="c-blue c-dlt-blue">
									<div class="c-select c-b-blue">
										<div class="c-s-t dlt">
											<h3>
												<strong>后区</strong><em>至少选择2个号码</em><b class="c-h3-l"></b><b
													class="c-h3-r"></b>
											</h3>
											<b class="c-t-l"></b>
											<b class="c-t-r"></b>
										</div>
										<ul id="pt_blue" class="c-s-num">
											<li>
												<b>01</b><b class="">02</b><b>03</b><b>04</b>
											</li>

											<li class="m-t">
												<b>05</b><b>06</b><b class="">07</b><b>08</b>
											</li>

											<li class="m-t">
												<b>09</b><b>10</b><b>11</b><b>12</b>
											</li>

										</ul>
									</div>
									<div class="tr c-p-a">
										<select id="pt_blue_sel" name="sele">
											<option selected="" value="2">
												2
											</option>
											<option value="3">
												3
											</option>
											<option value="4">
												4
											</option>
											<option value="5">
												5
											</option>
											<option value="6">
												6
											</option>
											<option value="7">
												7
											</option>
											<option value="8">
												8
											</option>
											<option value="9">
												9
											</option>
											<option value="10">
												10
											</option>
											<option value="11">
												11
											</option>
											<option value="12">
												12
											</option>
										</select>
										<a id="pt_blue_jx" href="javascript:void 0" title=""
											class="btn_gray_s">机选后区</a><a id="pt_blue_clear"
											href="javascript:void 0" title="" class="a-q"><s
											class="dn"></s>
										</a>
									</div>
								</div>
							</div>
							<div class="c-result m-t20">
								<p id="pt_choose_info" class="tc">
									【您选择了
									<b class="red" id="red_num">0</b> 个前区号码，
									<b class="red" id="blue_num">0</b> 个后区号码，共
									<b class="red" id="all_num">0</b> 注，共
									<b class="red"></b><b class="red" id="all_money"> 0.00 </b>元 】
								</p>
								<div style="padding-left: 15px" class="c-r-ok c-r-ok-rx tr p-l">
									<a id="pt_put" href="javascript:void 0" title="" class="s-ok"></a><a
										id="pt_clear" href="javascript:void 0" title=""
										class="gray m-trl">清空全部</a>
									<select id="pt_sel" name="c-r-z" class="c-r-z m-t15">
										<option value="1">
											1
										</option>
										<option value="2">
											2
										</option>
										<option selected="" value="5">
											5
										</option>
										<option value="10">
											10
										</option>
										<option value="20">
											20
										</option>
										<option value="50">
											50
										</option>
										<option value="100">
											100
										</option>
									</select>
									<a id="pt_jx" href="javascript:void 0" title=""
										class="public_Lblue m-t15"><b>机选</b>
									</a>
								</div>
								<div class="c-r-bet m-t20">
									<ul id="pt_list" class="betList">

									</ul>


								</div>
								<div class="c-r-l m-t">
									<label
										data-help="&lt;h5&gt;追加投注&lt;/h5&gt;加奖期间，每注追加1元，单注最高奖金可增至2400万!"
										rel="" class="m-r addpricehelp" for="zjtz23" style="">
										<input type="checkbox" rel="addPrice" class="i-cr" id="zjtz23"
											name="gjwf">
										<em class="red">追加投注</em>
									</label>
									您选择了
									<span id="pt_zs">0</span>注
									<input type="text" maxlength="2" id="pt_bs" value="1"
										class="i-a" name="tzbs" />
									倍，共
									<b class="red"></b><b id="pt_money" class="red">0.00</b>元
									<a id="pt_list_clear" class="btn_gray_s" title=""
										href="javascript:void 0">清空列表</a>
								</div>
							</div>
						</div>
						<div style="display: none;" id="dslr" class="c-inner">
							<div class="c-way">
								<ul>
									<li class="c-lr">
										<a class="public_Dblue" title="" href="javascript:void 0"><b>手动录入</b>
										</a><a id="toup" class="public_gray" title=""
											href="javascript:void 0"><b>.txt文件上传</b>
										</a><a onclick="Y.openUrl('bzgs.html',420,380)"
											href="javascript:void 0">查看标准格式样本</a>
									</li>
									<li class="c-sm">
										<textarea id="lr_editor" class="c-sm-t" rows="10" cols="10">最多输入1000注，如果大于1000注，请以.txt文件上件！
请参照标准格式: 06,17,22,26,28|02,33
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;兼容格式: 06 17 22 26 28|02 33</textarea>
									</li>
								</ul>
							</div>
							<div class="c-result m-t20">
								<p class="tc">
									【已输入
									<b id="lr_num" class="red">0 </b>注，最多输入1000注】
								</p>
								<div style="padding-left: 15px" class="c-r-ok tr">
									<a id="lr_put" class="s-ok" title="" href="javascript:void 0"></a><a
										id="lr_clear" class="gray m-r60" title=""
										href="javascript:void 0">清空全部</a>
									<select id="lr_opts" name="c-r-z">
										<option value="1">
											1
										</option>
										<option value="2">
											2
										</option>
										<option selected="" value="5">
											5
										</option>
										<option value="10">
											10
										</option>
										<option value="20">
											20
										</option>
										<option value="50">
											50
										</option>
										<option value="100">
											100
										</option>
									</select>
									<a id="lr_jx" class="public_Lblue" title=""
										href="javascript:void 0"><b>机选</b>
									</a>
								</div>
								<div class="c-r-bet m-t20">
									<ul id="lr_list" class="betList">
									</ul>
								</div>
								<div class="c-r-l m-t">
									<label
										data-help="&lt;h5&gt;追加投注&lt;/h5&gt;加奖期间，每注追加1元，单注最高奖金可增至2400万!"
										rel="" class="m-r addpricehelp" for="zjtz2">
										<input type="checkbox" rel="addPrice" class="i-cr" id="zjtz">
										<em class="red">追加投注</em>
									</label>
									您录入了
									<span id="lr_zs">0</span>注，
									<input type="text" maxlength="2" id="lr_bs" value="1"
										class="i-a" name="ssq">
										倍，共 
									<b id="lr_money" class="red">￥4.00 </b>元
									<a id="lr_list_clear" class="btn_gray_s" title=""
										href="javascript:void 0">清空列表</a>
								</div>
							</div>
						</div>
						<!--单式投注单式上传-->
						<div style="display: none" id="dssc" class="c-inner  b-t0">
							<div class="c-result c-result-t">
								<div class="c-way">
									<ul>
										<li class="c-lr">
											<!-- 									<a href="javascript:void 0" title="" class="public_gray" id="tolr"><b>手动录入</b></a> -->
											<a id="tolr" class="" title="" href="javascript:void 0"><b></b>
											</a>
											<a class="public_Dblue" title="" href="javascript:void 0"><b>.txt文件上传</b>
											</a><a onclick="return false;" href="javascript:void 0"
												id="queryGs">查看标准格式样本</a>
										</li>
										<li class="c-fq">
											发起方案
											<input type="text" maxlength="6" id="sc_zs_input" class="i-b"
												name="ssq" />
											注，
											<input type="text" maxlength="2" id="sc_bs_input" class="i-a"
												name="ssq" />
											倍，共
											<span class="red"></span><span id="sc_money" class="red">0.00</span>元。
											<label
												data-help="&lt;h5&gt;追加投注&lt;/h5&gt;加奖期间，每注追加1元，单注最高奖金可增至2400万!"
												rel="" class="m-r addpricehelp" for="dssc_zh">
												<input type="checkbox" id="dssc_zh" rel="addPrice"
													name="ssq" style=" vertical-align: -3px;"/>
													追加投注
											</label>
											<label for="scChk">
												<input type="checkbox" id="scChk" name="ssq" style=" vertical-align: -3px;" />
													发起后再上传
											</label>
										</li>
										<li>
											<form enctype="multipart/form-data" method="post"
												action="/filecast.go" id="suc_form" name="project_form">
												<input type="file" id="upfile" class="" name="upfile" />
											</form>
										</li>
										<li id="uphelp" class="c-dis">
											<em><b class="i-tp"></b>上传说明：</em>
											<ul>
												<li class="red">
													1、选择倍投注时只需上传单倍方案；上传的方案注数必须跟填写的一致，否则可能无法出票。
												</li>
												<li>
													2、请严格参照“标准格式样本”格式上传方案，否则网站不保证为您做过关统计以及历史战绩统计。
												</li>
												<li>
													3、文件格式必须是文本文件。
												</li>
												<li>
													4、由于上传的文件较大，会导致上传时间及在本页停留时间较长，请耐心等待。
												</li>
											</ul>
										</li>
									</ul>
								</div>
							</div>
						</div>
						<!--多期机选-->

						<div style="display: none;" id="dslr12" class="c-inner">
							<div class="c-way">
								<ul>
									<li class="c-lr">
										<a class="public_Dblue" title="" href="javascript:void 0"><b>手动录入</b>
										</a><a title="" onclick="Y.openUrl('bzgs_12x2.html',420,380)"
											href="javascript:void 0">查看标准格式样本</a>
									</li>
									<textarea id="lr12_editor" class="c-sm-t" rows="10" cols="10">最多输入1000注，如果大于1000注，请以.txt文件上件！ 
请参照标准格式: 06,12</textarea>
								</ul>
							</div>
							<div class="c-result m-t20">
								<p class="tc">
									【已输入
									<b id="lr12_num" class="red">0 </b>注，最多输入1000注】
								</p>
								<div style="padding-left: 13px" class="c-r-ok tr">
									<a id="lr12_put" class="s-ok" title="" href="javascript:void 0"></a><a
										id="lr12_clear" class="gray m-r60" title=""
										href="javascript:void 0">清空全部</a>
									<select id="lr12_opts" name="c-r-z">
										<option value="1">
											1
										</option>
										<option value="2">
											2
										</option>
										<option selected="" value="5">
											5
										</option>
										<option value="10">
											10
										</option>
										<option value="20">
											20
										</option>
										<option value="50">
											50
										</option>
										<option value="100">
											100
										</option>
									</select>
									<a id="lr12_jx" class="public_Lblue" title=""
										href="javascript:void 0"><b>机选</b>
									</a>
								</div>
								<div class="c-r-bet m-t20">
									<ul id="lr12_list" class="betList">
									</ul>
								</div>
								<div class="c-r-l m-t">
									您录入了
									<span id="lr12_zs">0</span>注，
									<input type="text" maxlength="2" id="lr12_bs" value="1"
										class="i-a" name="ssq">
										倍，共 
									<b id="lr12_money" class="red">￥4.00 </b>元
									<a id="lr12_list_clear" class="btn_gray_s" title=""
										href="javascript:void 0">清空列表</a>
								</div>
							</div>
						</div>
						<div id="all_form" class="buy_sort">
							<span class="title">购买方式</span>
							<span class="sort"><label for="rd3" class="m_r25 b">
									<input type="radio" name="radio_g2" id="rd3" value="0"
										checked="checked" class="m_r3">
										代购
								</label>
								<label for="rd4" class="m_r25">
									<input type="radio" name="radio_g2" id="rd4" value="1"
										class="m_r3">
										合买
								</label>
							</span>
							<em class="r i-qw" style=""></em><span class="r gray">由购买人自行全额购买彩票</span>
						</div>
						<div class="con">
							<div id="dg_form" style="display: block;">
								<table cellspacing="0" cellpadding="0" border="0" width="100%"
									class="buy_table">
									<tbody>
										<tr class="last_tr">
											<td class="td_title">
												确认购买
											</td>
											<td class="td_content">
												<div class="buy_info">
													<p id="userMoneyInfo">
														您尚未登录，请先
														<a onclick="Yobj.postMsg('msg_login')" title=""
															href="javascript:void 0">登录</a>
													</p>
													<p>
														本次投注金额为
														<strong id="buyMoneySpan" class="red eng">￥0.00</strong>元
														<span style="display: none" class="if_buy_yue">，
															购买后您的账户余额为 <strong id="buySYSpan" class="red eng">￥0.00</strong>元</span>
													</p>
													<p>
														<input type="checkbox" id="agreement_dg" checked="">
															我已阅读并同意《
														<a onclick="return fasle" id="queryXy"
															href="javascript:void 0">用户合买代购协议</a>》
													</p>
												</div>
												<div class="buy_btn">
										<!-- a id="buy_dg" onclick="return false" href="javascript:void 0" class="btn_buy_m" title="立即购买">立即购买</a-->
									</div>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<!--合买在这里 隐藏了哦-->
							<div id="hm_form" style="display: none;">
								<table cellspacing="0" cellpadding="0" border="0" width="100%"
									class="buy_table">
									<tbody>
										<tr>
											<td class="td_title">
												合买设置
											</td>
											<td class="td_content">
												<p>
													<span class="hide_sp red eng">*</span><span
														class="align_sp">我要分为：</span>
													<input type="text" id="fsInput" name="allnum" class="mul"
														value="1" disabled="">
														份， 每份
													<span id="fsMoney" class="red eng money">￥0.00</span>元
													<span class="gray">每份至少1元</span><span id="fsErr"
														style="display: none" class="tips_sp">！每份金额不能除尽，请重新填写份数</span>
												</p>

												<p>
													<span class="hide_sp"></span><span class="align_sp">我要提成：</span>
													<select id="tcSelect" name="tc" class="selt">
														<option value="0">
															0
														</option>
														<option value="1">
															1
														</option>
														<option value="2">
															2
														</option>
														<option value="3">
															3
														</option>
														<option value="4">
															4
														</option>
														<option value="5" selected="selected">
															5
														</option>
														<option value="6">
															6
														</option>
														<option value="7">
															7
														</option>
														<option value="8">
															8
														</option>
													</select>
													%
													<s
														data-help="&lt;h5&gt;什么是提成？&lt;/h5&gt;&lt;p&gt;发起人提取税后奖金的一定比例作为提成。&lt;/p&gt;
												        &lt;p&gt;&lt;font color='red'&gt;&lt;strong&gt;提成条件：&lt;/strong&gt;&lt;/font&gt;税后奖金&mdash;提成金额&gt;方案金额&lt;/p&gt;
												        &lt;p&gt;&lt;font color='red'&gt;&lt;strong&gt;计算公式：&lt;/strong&gt;&lt;/font&gt;提成金额=盈利部分（税后奖金-方案金额）*提成比例&lt;/p&gt;
												        &lt;p&gt;示例&lt;/p&gt;
												        &lt;p&gt;方案金额：1000元；税后奖金：2000元；&lt;/p&gt;       
												        &lt;p&gt;提成比例：5%；提成金额：(2000-1000)*5%=50元&lt;/p&gt;
												        &lt;p&gt;提成条件判断：2000-100&gt;1000元&lt;/p&gt;
												        &lt;p&gt;实际提成：50元&lt;/p&gt;"
														class="i-qw"></s>
												</p>
												<p>
													<span class="hide_sp"></span><span class="align_sp">是否公开：</span>
													<label for="gk1" class="m_r25">
														<input type="radio" value="0" name="gk" id="gk1"
															checked="checked" class="m_r3">
															完全公开
													</label>
													<label for="gk2" class="m_r25">
														<input type="radio" value="1" name="gk" id="gk2"
															class="m_r3">
															截止后公开
													</label>
												</p>
												<p>
													<span class="hide_sp"></span><span class="align_sp"></span>
													<label for="gk3" class="m_r25">
														<input type="radio" value="2" name="gk" id="gk3"
															class="m_r3">
															仅对跟单用户公开
													</label>
													<label for="gk4" class="m_r25">
														<input type="radio" value="3" name="gk" id="gk4"
															class="m_r3">
															截止后对跟单用户公开
													</label>
												</p>


											</td>
										</tr>
										<tr>
											<td class="td_title">
												认购设置
											</td>
											<td class="td_content">
												<div class="buy_info p-l0">
													<p>
														<span class="hide_sp"></span><span id="userMoneyInfo2">您尚未登录，请先<a
															onclick="Yobj.postMsg('msg_login')" title=""
															href="javascript:void 0">登录</a>
														</span>
													</p>
													<p>
														<span class="hide_sp red eng">*</span><span
															class="align_sp">我要认购：</span>
														<input type="text" id="rgInput" name="buynum" class="mul"
															value="1">
															份，
														<span id="rgMoney" class="red eng money">￥0.00</span>元（
														<span id="rgScale" class="scale">0</span>%）
														<span style="display: none" id="rgErr" class="tips_sp">！至少需要认购<b></b>份</span>
													</p>
													<p>
														<span class="hide_sp"><input type="checkbox"
																id="isbaodi">
														</span><span class="align_sp">我要保底：</span>
														<input type="text" disabled="" id="bdInput"
															name="baodinum" class="mul" value="0">
															份，
														<span id="bdMoney" class="red eng money">￥0.00</span>元（
														<span class="scale" id="bdScale">0</span>%）
														<s
															data-help="&lt;h5&gt;什么是保底？&lt;/h5&gt;&lt;p&gt;发起人承诺合买截止后，如果方案还没有满员，发起人再投入先前承诺的金额以最大限度让方案成交。最低保底金额为方案总金额的20%。保底时，系统将暂时冻结保底资金，在合买截止时如果方案还未满员的话，系统将会用冻结的保底资金去认购方案。如果在合买截止前方案已经满员，系统会解冻保底资金。&lt;/p&gt;"
															class="i-qw"></s><span id="bdErr" style="display: none"
															class="tips_sp">！最低保底20%</span>
													</p>
													<p class="agreement">
														<span class="hide_sp"><input type="checkbox"
																id="agreement_hm" checked="checked">
														</span>我已阅读并同意《
														<a onclick="return false" id="queryXy2"
															href="javascript:void 0">用户合买代购协议</a>》
													</p>
												</div>
												<div class="buy_btn">
													<!-- a id="buy_hm" href="javascript:void 0" class="btn_buy_hm" title="发起合买">发起合买</a-->
												</div>
											</td>
										</tr>
										<tr>
											<td class="td_ge_t">
												可选信息
											</td>
											<td class="td_ge">
												<p class="ge_selt p-l0">
													<span class="hide_sp"><input type="checkbox"
															id="moreCheckbox">
													</span>方案宣传与合买对象
												</p>
												<p class="ge_tips">
													帮助您进行方案宣传和选择合买对象。
												</p>
											</td>
										</tr>
										<tr style="display: table-row" id="case_ad">
											<td class="td_title">
												方案宣传
											</td>
											<td class="td_content">
												<p>
													<span class="hide_sp"></span><span class="align_sp">方案标题：</span>
													<input type="text" name="title" id="caseTitle"
														class="t_input" value="大奖神马都不是浮云，只要有你参与！" maxlength="20">
													<span class="gray">已输入<span id="zfsz_len">0</span>个字符，最多20个</span>
												</p>
												<p>
													<span class="hide_sp"></span><span class="align_sp">方案描述：</span>
													<textarea id="caseInfo" cols="10" rows="10" class="p_input"
														name="content">说点什么吧，让您的方案被更多彩民认可．．．</textarea>
													<span class="gray">已输入<span id="ms_zfsz_len">0</span>个字符，最多200个</span>
												</p>
											</td>
										</tr>
										<tr style="display: none" id="hm_target" class="last_tr">
											<td class="td_title">
												合买对象
											</td>
											<td class="td_content">
												<p>
													<span class="hide_sp"></span>
													<label class="m_r25" for="dx1">
														<input type="radio" class="m_r3" id="dx1" name="zgdx"
															checked="checked">
															所有彩友可以合买
													</label>
													<label class="m_r25" for="dx2">
														<input type="radio" class="m_r3" id="dx2" name="zgdx">
															只有固定的彩友可以合买
													</label>
												</p>
												<div style="display: none" id="fixobj">
													<p>
														<span class="hide_sp"></span><span class="align_sp"></span>
														<textarea cols="10" rows="10" class="p_input"
															name="buyuser"></textarea>
													</p>
													<p>
														<span class="hide_sp"></span><span class="gray">[注]限定彩友的格式是：aaaaa,bbbbb,ccccc,ddddd（,为英文状态下的逗号）</span>
													</p>
												</div>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div id="zh_form" style="display: none">
								<table cellspacing="0" cellpadding="0" border="0" width="100%"
									class="buy_table">
									<tbody>
										<tr>
											<td class="td_title">
												期数选择
											</td>
											<td class="td_content">
												<div class="td-pl">
													<p>
														<select class="td_qs m-r" id="zh_opts" name="qs">
															<option checked="" value="10">
																追10期
															</option>
															<option value="20">
																追20期
															</option>
															<option value="30">
																追30期
															</option>
															<option value="50">
																追50期
															</option>
														</select>


														<select id="tzzh" name="zhflag">
															<option value="0">
																中奖后不停止
															</option>
															<option value="1">
																中奖后停止
															</option>
															<option selected="" value="2">
																盈利后停止
															</option>
														</select>


														<a target="_blank" title="" href="/help/help_1_11.html">查看追号规则</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														<!-- 										<span class="red">提示：</span>红色显示期号为加奖期<a class="i-qw" title="什么是加奖？" target="_blank" href="http://zx.9188.com/dlt/n_dt/gz/20110505_254975.shtml"></a> -->
													</p>

													<div class="qs_list">
														<ul id="zh_list">
															<li style="color: #0080FF">
																正在加载追号列表, 请稍后...
															</li>
														</ul>
													</div>
												</div>
											</td>
										</tr>

										<tr class="last_tr">
											<td class="td_title">
												确认购买
											</td>
											<td class="td_content">
												<div class="buy_info">
													<p id="userMoneyInfo3">
														您尚未登录，请先
														<a onclick="Yobj.postMsg('msg_login')" title=""
															href="javascript:void 0">登录</a>
													</p>
													<p>
														本次投注金额为
														<strong id="buyMoneySpan2" class="red eng">￥0.00</strong>元
														<span style="display: none" class="if_buy_yue">，
															购买后您的账户余额为 <strong id="buySYSpan2" class="red eng">￥0.00</strong>元</span>
													</p>
													<p class="agreement">
														<input type="checkbox" id="agreement_zh" checked="checked">
															我已阅读并同意《
														<a onclick="return false" id="queryXy1"
															href="javascript:void 0">用户合买代购协议</a>》
													</p>
												</div>
												<div class="buy_btn">
													<a id="buy_zh" href="javascript:void 0" class="btn_buy_m"
														title="立即购买">立即购买</a>
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
							<h2>
								<a target="_blank" title="超级大乐透开奖公告"
									href="/kaijiang/gkaijiang.html?lotid=50">超级大乐透开奖公告</a>
							</h2>
							<dl class="s-kj">
								<dt>
									<strong class="red">第期开奖号码：</strong>
								</dt>
								<!--<dd>开奖时间：2011-05-29 20:37</dd>-->
								<dd id="kj_opcode" class="clearfix">
									<b class="b-red-20"></b><b class="b-red-20"></b><b
										class="b-red-20"></b><b class="b-red-20"></b><b
										class="b-red-20"></b><b class="b-blue-20"></b>
									<b class="b-blue-20"></b>
									<!-- <a target="_blank" href="/kaijiang/dlt.html" title="">详情</a> -->
								</dd>
								<!-- 			<dd>
				奖池滚存：<em class="red">432,770,570</em>元
				</dd> -->
								<dd>
									奖池滚存：
									<em class="red"></em>元
								</dd>
							</dl>
							<dl id="s-kj-his">
								<table cellspacing="0" cellpadding="0" border="0" width="100%"
									class="zj_table">
									<colgroup>
										<col width="30%">
										<col width="70%">
									</colgroup>
									<thead>
										<tr>
											<th class="tc">
												期号
											</th>
											<th class="tc">
												开奖号码
											</th>
										</tr>
									</thead>
									
								</table>
							</dl>
							<s class="s-td-l"></s>
							<s class="s-td-r"></s>
						</div>
					</div>
					<div class="jjfp">
						<div id="priz_table" class="">
							<div class="">
								<div class="" style="border: 1px solid #FED6A4;">
									<div class="dz_title">
										<h2>
											大乐透奖金对照表
										</h2>
									</div>
									<div>
										<div>
											<table cellspacing="0" cellpadding="0" width="100%"
												class="tablelay eng">
												<tbody>
													<tr>
														<th rowspan="2">
															奖级
														</th>
														<th colspan="2">
															中奖条件
														</th>
														<th rowspan="2">
															奖金分配
														</th>
													</tr>
													<tr>
														<th>
															前区
														</th>
														<th>
															后区
														</th>
													</tr>
													<tr>
														<td>
															一等奖
														</td>
														<td>
															<span class="red_qiu"></span><span class="red_qiu"></span><span
																class="red_qiu"></span><span class="red_qiu"></span><span
																class="red_qiu"></span>
														</td>
														<td>
															<span class="blue_qiu"></span><span class="blue_qiu"></span>
														</td>
														<td>
															浮动奖
														</td>
													</tr>
													<tr>
														<td>
															二等奖
														</td>
														<td>
															<span class="red_qiu"></span><span class="red_qiu"></span><span
																class="red_qiu"></span><span class="red_qiu"></span><span
																class="red_qiu"></span>
														</td>
														<td>
															<span class="blue_qiu"></span>
														</td>
														<td>
															浮动奖
														</td>
													</tr>
													<tr>
														<td>
															三等奖
														</td>
														<td>
															<span class="red_qiu"></span><span class="red_qiu"></span><span
																class="red_qiu"></span><span class="red_qiu"></span><span
																class="red_qiu"></span>
														</td>
														<td>
															&nbsp;
														</td>
														<td>
															浮动奖
														</td>
													</tr>
													<tr>
														<td>
															四等奖
														</td>
														<td>
															<span class="red_qiu"></span><span class="red_qiu"></span><span
																class="red_qiu"></span><span class="red_qiu"></span>
														</td>
														<td>
															<span class="blue_qiu"></span><span class="blue_qiu"></span>
														</td>
														<td>
															3000元
														</td>
													</tr>
													<tr>
														<td>
															五等奖
														</td>
														<td>
															<span class="red_qiu"></span><span class="red_qiu"></span><span
																class="red_qiu"></span><span class="red_qiu"></span>
														</td>
														<td>
															<span class="blue_qiu"></span>
														</td>
														<td>
															600元
														</td>
													</tr>
													<tr>
														<td rowspan="2">
															六等奖
														</td>
														<td>
															<span class="red_qiu"></span><span class="red_qiu"></span><span
																class="red_qiu"></span><span class="red_qiu"></span>
														</td>
														<td>
															&nbsp;
														</td>
														<td rowspan="2">
															100元
														</td>
													</tr>
													<tr>
														<td class="zjtj">
															<span class="red_qiu"></span><span class="red_qiu"></span><span
																class="red_qiu"></span>
														</td>
														<td class="zjtj">
															<span class="blue_qiu"></span><span class="blue_qiu"></span>
														</td>
													</tr>
													<tr>
														<td rowspan="2">
															七等奖
														</td>
														<td>
															<span class="red_qiu"></span><span class="red_qiu"></span><span
																class="red_qiu"></span>
														</td>
														<td>
															<span class="blue_qiu"></span>
														</td>
														<td rowspan="2">
															10元
														</td>
													</tr>
													<tr>
														<td class="zjtj">
															<span class="red_qiu"></span><span class="red_qiu"></span>
														</td>
														<td class="zjtj">
															<span class="blue_qiu"></span><span class="blue_qiu"></span>
														</td>
													</tr>
													<tr>
														<td rowspan="4">
															八等奖
														</td>
														<td>
															<span class="red_qiu"></span><span class="red_qiu"></span><span
																class="red_qiu"></span>
														</td>
														<td>
															&nbsp;
														</td>
														<td rowspan="4">
															5元
														</td>
													</tr>
													<tr>
														<td class="zjtj">
															<span class="red_qiu"></span>
														</td>
														<td class="zjtj">
															<span class="blue_qiu"></span><span class="blue_qiu"></span>
														</td>
													</tr>
													<tr>
														<td class="zjtj">
															<span class="red_qiu"></span><span class="red_qiu"></span>
														</td>
														<td class="zjtj">
															<span class="blue_qiu"></span>
														</td>
													</tr>
													<tr>
														<td class="zjtj"></td>
														<td class="zjtj">
															<span class="blue_qiu"></span><span class="blue_qiu"></span>
														</td>
													</tr>
													<tr>
														<td>
															12选2
														</td>
														<td></td>
														<td>
															<span class="blue_qiu"></span><span class="blue_qiu"></span>
														</td>
														<td>
															60元
														</td>
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
		<!--机选弹出层-->
		<div class="tips_m" id="jx_dlg"
			style="width: 300px; display: none; z-index: 500004; position: absolute; left: 561px; top: 420px; overflow: auto;">
			<div class="tips_b">
				<div class="tips_box">
					<div class="tips_title move">
						<h2>
							机选号码列表
						</h2>
						<span class="close" id="jx_dlg_close"><a
							href="javascript:void 0">关闭</a>
						</span>
					</div>
					<div class="tips_text">
						<ul class="tips_text_list" id="jx_dlg_list"
							style="height: 120px; overflow: auto;">
							<li>
								<span class="red">02,07,20,22,23</span> |
								<span class="blue">01,09</span>
							</li>
							<li>
								<span class="red">08,11,12,26,35</span> |
								<span class="blue">06,09</span>
							</li>
							<li>
								<span class="red">02,05,13,14,23</span> |
								<span class="blue">01,07</span>
							</li>
							<li>
								<span class="red">07,12,18,20,26</span> |
								<span class="blue">04,09</span>
							</li>
							<li>
								<span class="red">13,20,21,29,34</span> |
								<span class="blue">02,11</span>
							</li>
						</ul>
					</div>
					<div class="tips_sbt">
						<input type="button" value="重新机选" class="btn_gray_b m-r"
							id="jx_dlg_re">
						<input type="button" value="选好了" class="s-ok" id="jx_dlg_ok">
					</div>
				</div>
			</div>
		</div>
		<!--机选弹出层结束-->

		<!--不能超...过-->
		<div class="tips_m" id="info_dlg"
			style="display: none; z-index: 500003; position: absolute; left: 421px; top: 437px;_width:370px;">
			<div class="tips_b">
				<div class="tips_box">
					<div class="tips_title move">
						<h2>
							温馨提示
						</h2>
						<span class="close" id="info_dlg_close"><a
							href="javascript:void 0">关闭</a>
						</span>
					</div>
					<div class="tips_text">
						<div class="tips_ts" id="info_dlg_content" style="ZOOM: 1">
						</div>
					</div>
					<div class="tips_sbt">
						<input type="button" value="确 定" class="btn_Dora_b"
							id="info_dlg_ok">
					</div>
				</div>
			</div>
		</div>
		<!--不能超...过结束-->


		<!--滑过-->
		<div style="position: absolute; z-index: 500000; left: -99999px;">
			<div style="min-width: 120px; text-align: center; font: 12px/ 1.5 verdana; color: rgb(51, 51, 51);"></div>
			<div style="position: absolute; left: 0pt; top: 0pt; display: block; z-index: 9; width: 88%; height: 30px; background: none repeat scroll 0% 0% rgb(238, 238, 238); opacity: 0.1; cursor: move;"></div>
		</div>


		<div class="notifyicon tip-2" id="tsdiv"
			style="width: auto; overflow: visible; top: 171px; left: -9999px;">
			<div class="notifyicon_content">
				<h5 style="background-position: 0pt -672px;">
					追加投注
				</h5>
				<span id="input_info">每注追加1元，单注奖金可增至1600万!</span>
			</div>
			<div class="notifyicon_arrow">
				<s></s><em></em>
			</div>
			<div class="notifyicon_space"></div>
		</div>



		<div class="notifyicon tip-4" id="notifyicon_answer"
			style="width: 320px; overflow: hidden; top: 842px; left: -9999px;">
			<div class="notifyicon_content">
				<h5 style="background-position: 0pt -240px;">
					代购：
				</h5>
				是指方案发起人自己一人全额认购方案的购彩形式。若中奖，奖金也由发起人一人独享。
				<br>
				<br>
				<h5 style="background-position: 0pt -240px;">
					合买：
				</h5>
				由多人共同出资购买同一个方案，如果方案中奖，则按投入比例分享奖金。合买能够实现利益共享、风险共担，是网络购彩的一大优势。
				<br>
				<br>
				<h5 style="background-position: 0pt -240px;">
					追号：
				</h5>
				追号是选中了一注或一组号码，连续买几期或十几期甚至几十期。
			</div>
			<div class="notifyicon_arrow">
				<s></s><em></em>
			</div>
			<div class="notifyicon_space"></div>
		</div>
		<!---->

		<input type="hidden" id="lottid" name="lottid" value="8" />
		<!-- 彩种编号 -->
		<div id="bgdiv"></div>


		<!--登录-->
		<div class="tips_m" id="loginLay"
			style="width: 360px; display: none; z-index: 500003; position: absolute; left: 531px; top: 645px;">
			<div class="tips_b">
				<div class="tips_box">
					<div class="tips_title" style="cursor: move;">
						<h2 style="background: none;">
							用户登录
						</h2>
						<span class="close" id="flclose"><a
							href="javascript:void(0);">关闭</a>
						</span>
					</div>
					<div class="tips_text">
						<div class="dl_tips" id="error_tips" style="DISPLAY: none">
							<b class="dl_err"></b>您输入的账户名和密码不匹配，请重新输入。
						</div>
						<form action="/login/login.html" method="post"
							onsubmit="return false;" id="loginForm">
							<table cellspacing="0" cellpadding="0" border="0" width="100%"
								class="dl_tbl">
								<colgroup>
									<col width="52" />
									<col width="180" />
									<col>
								</colgroup>
								<tbody>
									<tr>
										<td>
											用户名：
										</td>
										<td>
											<input name="uid" class="tips_txt text_on" id="uid">
										</td>
										<td class="t_ar">
											<a target="_blank" href="/user/" tabindex="-1">免费注册</a>
										</td>
									</tr>
									<tr>
										<td>
											密&nbsp;&nbsp;码：
										</td>
										<td>
											<input type="password" value="" name="pwd" class="tips_txt"
												id="pwd">
										</td>
										<td class="t_ar">
											<a tabindex="-1" target="_blank" href="/user/getpwd.html">忘记密码</a>
										</td>
									</tr>
									<tr>
										<td>
											验证码：
										</td>
										<td colspan="2">
											<input name="c" class="tips_yzm" id="yzmtext">
											<img src="" alt="验证码" id="yzmimg"
												style="width: 60px; display: inline; height: 25px; cursor: pointer;">
											<a href="javascript:void 0" class="kbq" id="yzmup">看不清，换一张</a>
										</td>
									</tr>
									<tr>
										<td></td>
										<td colspan="2">
											<input type="button" value="登 录" class="btn_Dora_b"
												id="floginbtn" style="MARGIN-RIGHT: 18px">
												<!--<a href="javascript:void 0" id="tenpaylogin">QQ登录</a> <span class="gray">|</span> <a href="javascript:void 0" id="zfblogin">支付宝登录</a>-->
										</td>
										<td></td>
									</tr>

								</tbody>
							</table>
							<input type="hidden" value="1" name="t">
							<input type="hidden" name="rw" id="rw">
							<input type="hidden" value="0" name="islogin">
						</form>
					</div>
				</div>
			</div>
		</div>
		<!--登录层结束-->

		<!--标准样式-->
		<div id="gsdiv"
			style="width: 390px; margin-top: 5px; margin-left: 5px; display: none; position: absolute; z-index: 1000000">
			<div class="tips_b">

				<div class="tips_box">
					<div class="tips_title move">
						<h2>
							大乐透标准格式样本
						</h2>
						<span class="close"><a id="closeGs" onclick="return false;"
							href="javascript(void 0)">关闭</a>
						</span>
					</div>
					<div class="tips_text">
						06,11,21,25,28|01,02
						<br />

						01,13,22,24,28|03,08
						<br />
						04,16,24,26,28|01,04
						<br />
						08,18,23,24,28|02,09
						<br />
						05,12,24,25,27|01,05
						<br />
						03,18,22,25,26|02,09
						<br />
						05,19,23,25,28|05,06
						<br />

						09,14,22,25,29|06,07
						<br />
					</div>
					<div class="tips_sbt">
						<p align="center" style="padding-left: 28px">
							<input type="button" id="closeGsDiv" onclick="return false;"
								value="知道了" class="btn_Lora_b" />
						</p>
					</div>
				</div>
			</div>
		</div>
		<!--标准样式结束-->

		<!-- 用户协议 -->
		<div
			style="width: 500px; position: absolute; display: none; z-index: 8000000"
			id="xydiv">
			<div class="tips_b">
				<div class="tips_box">
					<div class="tips_title move">
						<h2>
							大乐透用户协议
						</h2>
						<span class="close"><a onclick="return false" id="closeXy1"
							href="javascript(void 0)">关闭</a>
						</span>
					</div>

					<div style="height: 300px; overflow-y: auto" class="tips_text">
						<ul id="msg_content" class="tips_info_list">
							<span lang="EN-US"><span lang="EN-US"
								style="FONT-SIZE: 10pt; mso-bidi-font-family: Calibri; mso-bidi-font-size: 11.0pt; mso-fareast-font-family: Calibri; mso-fareast-theme-font: minor-latin; mso-bidi-theme-font: minor-latin"><span
									style="mso-list: Ignore"><font face="Calibri"><span
											lang="EN-US"
											style="FONT-SIZE: 10pt; FONT-FAMILY: 宋体; mso-bidi-font-family: 宋体; mso-font-kerning: 0pt">
												<p
													style="MARGIN: 0cm 0cm 0pt 21pt; TEXT-INDENT: -21pt; tab-stops: list 18.0pt; mso-list: l0 level1 lfo1; mso-char-indent-count: 0"
													class="MsoListParagraph">
													<span lang="EN-US"
														style="FONT-SIZE: 10pt; mso-bidi-font-family: Calibri; mso-bidi-font-size: 11.0pt; mso-fareast-font-family: Calibri; mso-fareast-theme-font: minor-latin; mso-bidi-theme-font: minor-latin"><span
														style="mso-list: Ignore"><font face="Calibri">1、</font><span
															style="FONT: 7pt Times New Roman"><font size="2">&nbsp;
															</font>
														</span>
													</span>
													</span><span
														style="FONT-FAMILY: 宋体; mso-fareast-font-family: 宋体; mso-ascii-font-family: Calibri; mso-hansi-font-family: Calibri; mso-fareast-theme-font: minor-fareast; mso-ascii-theme-font: minor-latin; mso-hansi-theme-font: minor-latin">本网站立足于服务彩民，所有用户发起、认购彩票方案，网站均不收取任何手续费。</span>
													<span lang="EN-US"> </span>
												</p>
												<p
													style="MARGIN: 0cm 0cm 0pt 21pt; TEXT-INDENT: -21pt; tab-stops: list 18.0pt; mso-list: l0 level1 lfo1; mso-char-indent-count: 0"
													class="MsoListParagraph">
													<span lang="EN-US"
														style="FONT-SIZE: 10pt; mso-bidi-font-family: Calibri; mso-bidi-font-size: 11.0pt; mso-fareast-font-family: Calibri; mso-fareast-theme-font: minor-latin; mso-bidi-theme-font: minor-latin"><span
														style="mso-list: Ignore"><font face="Calibri">2、</font><span
															style="FONT: 7pt Times New Roman"><font size="2">&nbsp;
															</font>
														</span>
													</span>
													</span><span
														style="FONT-FAMILY: 宋体; mso-fareast-font-family: 宋体; mso-ascii-font-family: Calibri; mso-hansi-font-family: Calibri; mso-fareast-theme-font: minor-fareast; mso-ascii-theme-font: minor-latin; mso-hansi-theme-font: minor-latin">网站用户须同意本网站代理购买、保管彩票、领取奖金和派发奖金的有关事宜。</span><span
														lang="EN-US"><o:p></o:p>
													</span>
												</p>
												<p
													style="MARGIN: 0cm 0cm 0pt 21pt; TEXT-INDENT: -21pt; tab-stops: list 18.0pt; mso-list: l0 level1 lfo1; mso-char-indent-count: 0"
													class="MsoListParagraph">
													<span lang="EN-US"
														style="FONT-SIZE: 10pt; mso-bidi-font-family: Calibri; mso-bidi-font-size: 11.0pt; mso-fareast-font-family: Calibri; mso-fareast-theme-font: minor-latin; mso-bidi-theme-font: minor-latin"><span
														style="mso-list: Ignore"><font face="Calibri">3、</font><span
															style="FONT: 7pt Times New Roman"><font size="2">&nbsp;
															</font>
														</span>
													</span>
													</span><span
														style="FONT-FAMILY: 宋体; mso-fareast-font-family: 宋体; mso-ascii-font-family: Calibri; mso-hansi-font-family: Calibri; mso-fareast-theme-font: minor-fareast; mso-ascii-theme-font: minor-latin; mso-hansi-theme-font: minor-latin">发起人可自行设置税后奖金盈利部分</span><span
														lang="EN-US"><font face="Calibri">0%-8%</font>
													</span><span
														style="FONT-FAMILY: 宋体; mso-fareast-font-family: 宋体; mso-ascii-font-family: Calibri; mso-hansi-font-family: Calibri; mso-fareast-theme-font: minor-fareast; mso-ascii-theme-font: minor-latin; mso-hansi-theme-font: minor-latin">做为方案提成，网站保留提成比例调整的权利。</span><span
														lang="EN-US"><o:p></o:p>
													</span>
												</p>

												<p
													style="MARGIN: 0cm 0cm 0pt 21pt; TEXT-INDENT: -21pt; tab-stops: list 18.0pt; mso-list: l0 level1 lfo1; mso-char-indent-count: 0"
													class="MsoListParagraph">
													<span lang="EN-US"
														style="FONT-SIZE: 10pt; mso-bidi-font-family: Calibri; mso-bidi-font-size: 11.0pt; mso-fareast-font-family: Calibri; mso-fareast-theme-font: minor-latin; mso-bidi-theme-font: minor-latin"><span
														style="mso-list: Ignore"><font face="Calibri">4、</font><span
															style="FONT: 7pt Times New Roman"><font size="2">&nbsp;
															</font>
														</span>
													</span>
													</span><span
														style="FONT-FAMILY: 宋体; mso-fareast-font-family: 宋体; mso-ascii-font-family: Calibri; mso-hansi-font-family: Calibri; mso-fareast-theme-font: minor-fareast; mso-ascii-theme-font: minor-latin; mso-hansi-theme-font: minor-latin">用户有权自由发起方案，合买代购方案不限制。</span>
												</p>
												<p
													style="MARGIN: 0cm 0cm 0pt 21pt; TEXT-INDENT: -21pt; tab-stops: list 18.0pt; mso-list: l0 level1 lfo1; mso-char-indent-count: 0"
													class="MsoListParagraph">
													<span lang="EN-US"
														style="FONT-SIZE: 10pt; mso-bidi-font-family: Calibri; mso-bidi-font-size: 11.0pt; mso-fareast-font-family: Calibri; mso-fareast-theme-font: minor-latin; mso-bidi-theme-font: minor-latin"><span
														style="mso-list: Ignore"><font face="Calibri">5、</font><span
															style="FONT: 7pt Times New Roman"><font size="2">&nbsp;
															</font>
														</span>
													</span>
													</span><span
														style="FONT-FAMILY: 宋体; mso-fareast-font-family: 宋体; mso-ascii-font-family: Calibri; mso-hansi-font-family: Calibri; mso-fareast-theme-font: minor-fareast; mso-ascii-theme-font: minor-latin; mso-hansi-theme-font: minor-latin">为保证方案发起的严肃性，方案最低发起金额为</span><span
														lang="EN-US"><font face="Calibri">2</font>
													</span><span
														style="FONT-FAMILY: 宋体; mso-fareast-font-family: 宋体; mso-ascii-font-family: Calibri; mso-hansi-font-family: Calibri; mso-fareast-theme-font: minor-fareast; mso-ascii-theme-font: minor-latin; mso-hansi-theme-font: minor-latin">元，合买方案发起人须先购买至少</span><span
														lang="EN-US"><font face="Calibri">5%</font>
													</span><span
														style="FONT-FAMILY: 宋体; mso-fareast-font-family: 宋体; mso-ascii-font-family: Calibri; mso-hansi-font-family: Calibri; mso-fareast-theme-font: minor-fareast; mso-ascii-theme-font: minor-latin; mso-hansi-theme-font: minor-latin">。</span><span
														lang="EN-US"><o:p></o:p>
													</span>
												</p>
												<p
													style="MARGIN: 0cm 0cm 0pt 21pt; TEXT-INDENT: -21pt; tab-stops: list 18.0pt; mso-list: l0 level1 lfo1; mso-char-indent-count: 0"
													class="MsoListParagraph">
													<span lang="EN-US"
														style="FONT-SIZE: 10pt; mso-bidi-font-family: Calibri; mso-bidi-font-size: 11.0pt; mso-fareast-font-family: Calibri; mso-fareast-theme-font: minor-latin; mso-bidi-theme-font: minor-latin"><span
														style="mso-list: Ignore"><font face="Calibri">6、</font><span
															style="FONT: 7pt Times New Roman"><font size="2">&nbsp;
															</font>
														</span>
													</span>
													</span><span
														style="FONT-FAMILY: 宋体; mso-fareast-font-family: 宋体; mso-ascii-font-family: Calibri; mso-hansi-font-family: Calibri; mso-fareast-theme-font: minor-fareast; mso-ascii-theme-font: minor-latin; mso-hansi-theme-font: minor-latin">为确保方案正常出票，</span><span
														lang="EN-US"><font face="Calibri">19:00</font>
													</span><span
														style="FONT-FAMILY: 宋体; mso-fareast-font-family: 宋体; mso-ascii-font-family: Calibri; mso-hansi-font-family: Calibri; mso-fareast-theme-font: minor-fareast; mso-ascii-theme-font: minor-latin; mso-hansi-theme-font: minor-latin">以后单式方案单倍金额上限为</span><span
														lang="EN-US"><font face="Calibri">20,000</font>
													</span><span
														style="FONT-FAMILY: 宋体; mso-fareast-font-family: 宋体; mso-ascii-font-family: Calibri; mso-hansi-font-family: Calibri; mso-fareast-theme-font: minor-fareast; mso-ascii-theme-font: minor-latin; mso-hansi-theme-font: minor-latin">元。</span><span
														lang="EN-US"><o:p></o:p>
													</span>
												</p>

												<p
													style="MARGIN: 0cm 0cm 0pt 21pt; TEXT-INDENT: -21pt; tab-stops: list 18.0pt; mso-list: l0 level1 lfo1; mso-char-indent-count: 0"
													class="MsoListParagraph">
													<span lang="EN-US"
														style="FONT-SIZE: 10pt; mso-bidi-font-family: Calibri; mso-bidi-font-size: 11.0pt; mso-fareast-font-family: Calibri; mso-fareast-theme-font: minor-latin; mso-bidi-theme-font: minor-latin"><span
														style="mso-list: Ignore"><font face="Calibri">7、</font><span
															style="FONT: 7pt Times New Roman"><font size="2">&nbsp;
															</font>
														</span>
													</span>
													</span><span
														style="FONT-FAMILY: 宋体; mso-fareast-font-family: 宋体; mso-ascii-font-family: Calibri; mso-hansi-font-family: Calibri; mso-fareast-theme-font: minor-fareast; mso-ascii-theme-font: minor-latin; mso-hansi-theme-font: minor-latin">方案进度（含保底）超过</span><span
														lang="EN-US"><font face="Calibri">80%</font>
													</span><span
														style="FONT-FAMILY: 宋体; mso-fareast-font-family: 宋体; mso-ascii-font-family: Calibri; mso-hansi-font-family: Calibri; mso-fareast-theme-font: minor-fareast; mso-ascii-theme-font: minor-latin; mso-hansi-theme-font: minor-latin">的发起人、认购人均不能撤单。当期彩票截止后，未合买成功方案系统将进行撤单返款处理。</span><span
														lang="EN-US"><o:p></o:p>
													</span>
												</p>
												<p
													style="MARGIN: 0cm 0cm 0pt 21pt; TEXT-INDENT: -21pt; tab-stops: list 18.0pt; mso-list: l0 level1 lfo1; mso-char-indent-count: 0"
													class="MsoListParagraph">
													<span lang="EN-US"
														style="FONT-SIZE: 10pt; mso-bidi-font-family: Calibri; mso-bidi-font-size: 11.0pt; mso-fareast-font-family: Calibri; mso-fareast-theme-font: minor-latin; mso-bidi-theme-font: minor-latin"><span
														style="mso-list: Ignore"><font face="Calibri">8、</font><span
															style="FONT: 7pt Times New Roman"><font size="2">&nbsp;
															</font>
														</span>
													</span>
													</span><span
														style="FONT-FAMILY: 宋体; mso-fareast-font-family: 宋体; mso-ascii-font-family: Calibri; mso-hansi-font-family: Calibri; mso-fareast-theme-font: minor-fareast; mso-ascii-theme-font: minor-latin; mso-hansi-theme-font: minor-latin">奖金分配：代购方案所中取的奖金，均属于此方案发起人所有。合买方案中奖后，发起人按照事先约定的方式、比例进行提成，其余奖金按照此方案各用户认购比例进行分配，除不尽的部分归方案发起人所有。</span><span
														lang="EN-US"><o:p></o:p>
													</span>
												</p>
												<p
													style="MARGIN: 0cm 0cm 0pt 21pt; TEXT-INDENT: -21pt; tab-stops: list 18.0pt; mso-list: l0 level1 lfo1; mso-char-indent-count: 0"
													class="MsoListParagraph">
													<span lang="EN-US"
														style="FONT-SIZE: 10pt; mso-bidi-font-family: Calibri; mso-bidi-font-size: 11.0pt; mso-fareast-font-family: Calibri; mso-fareast-theme-font: minor-latin; mso-bidi-theme-font: minor-latin"><span
														style="mso-list: Ignore"><font face="Calibri">9、</font><span
															style="FONT: 7pt Times New Roman"><font size="2">&nbsp;
															</font>
														</span>
													</span>
													</span><span
														style="FONT-FAMILY: 宋体; mso-fareast-font-family: 宋体; mso-ascii-font-family: Calibri; mso-hansi-font-family: Calibri; mso-fareast-theme-font: minor-fareast; mso-ascii-theme-font: minor-latin; mso-hansi-theme-font: minor-latin">彩票开奖后，网站将代为办理兑奖、派奖事宜，并在一个工作日内把税后奖金添入中奖用户之预付款帐户。</span><span
														lang="EN-US"><o:p></o:p>
													</span>
												</p>
												<p
													style="MARGIN: 0cm 0cm 0pt 21pt; TEXT-INDENT: -21pt; tab-stops: list 18.0pt; mso-list: l0 level1 lfo1; mso-char-indent-count: 0"
													class="MsoListParagraph">
													<span lang="EN-US"
														style="FONT-SIZE: 10pt; mso-bidi-font-family: Calibri; mso-bidi-font-size: 11.0pt; mso-fareast-font-family: Calibri; mso-fareast-theme-font: minor-latin; mso-bidi-theme-font: minor-latin"><span
														style="mso-list: Ignore"><font face="Calibri">10、</font><span
															style="FONT: 7pt Times New Roman"><font size="2">
															</font>
														</span>
													</span>
													</span><span
														style="FONT-FAMILY: 宋体; mso-fareast-font-family: 宋体; mso-ascii-font-family: Calibri; mso-hansi-font-family: Calibri; mso-fareast-theme-font: minor-fareast; mso-ascii-theme-font: minor-latin; mso-hansi-theme-font: minor-latin">如因彩票中心网络异常、赛事提前截止、停电、网站网络中断、出票服务器维护等特殊原因，网站有随时调整截止时间的权利。如因上述意外因素导致本站未能够出票完毕，本站将在开奖前对未出票方案做撤单返款处理，并发公告通知网友。除此之外，本站不再承担其他责任。</span><span
														lang="EN-US"><o:p></o:p>
													</span>
												</p>

												<p align="left"
													style="MARGIN-LEFT: 21pt; TEXT-INDENT: -21pt; TEXT-ALIGN: left"
													class="MsoNormal">
													<span><span><span lang="EN-US"
															style="FONT-FAMILY: 宋体"><font size="2"><span>13、本网站保留变更本协议条款的权利。<br>
																			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																</span><span>&nbsp;&nbsp;&nbsp;</span>
															</font><span><font size="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>
															</span>
														</span>
													</span>
													</span>
												</p>
												<p align="right"
													style="MARGIN: 13pt 0cm; mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; mso-pagination: widow-orphan"
													class="MsoNormal">
													<span lang="EN-US"
														style="FONT-SIZE: 10pt; FONT-FAMILY: 宋体; mso-bidi-font-family: 宋体; mso-font-kerning: 0pt"><a
														target="_blank" href="http://<?php echo $site_config['name'];?>/"><span
															style="COLOR: blue; mso-bidi-font-size: 11.0pt"><?php echo $site_config['site_title'];?></span>
													</a>
													<br>
													</span><span
														style="FONT-SIZE: 10pt; FONT-FAMILY: 宋体; mso-bidi-font-family: 宋体; mso-font-kerning: 0pt">客服热线：<span
														lang="EN-US"><?php echo $site_config['kf_phone_num'];?><br />
													</span>
													</span><span lang="EN-US"
														style="FONT-SIZE: 12pt; FONT-FAMILY: 宋体; mso-bidi-font-family: 宋体; mso-font-kerning: 0pt">
													</span>
												</p>
										</span>
									</font>
								</span>
							</span>
							</span>
							<font face="Calibri"> </font>
						</ul>
						<font face="Calibri"> </font>
					</div>
					<font face="Calibri">
						<div class="tips_sbt">
							<input type="button" onclick="return false" id="closeXy2"
								value="关 闭" class="btn_Lora_b">
						</div> </font>
				</div>
				<font face="Calibri"> </font>
			</div>
		</div>
		<!-- 用户协议结束 -->


		<!--footer end-->
		<!--copyright_end-->

		<script src="images/pv.gif"></script>
		<div class="sogoutip"
			style="z-index: 2.14748e +009; visibility: hidden; display: none;"></div>
		<div class="sogoubottom"></div>
		<div id="stophi" style="z-index: 2.14748e +009;">
			<div class="extnoticebg"></div>
			<div class="extnotice">
				<h2>
					关闭提示
					<a href="http://<?php echo $site_config['name'];?>/#" title="关闭提示"
						id="closenotice" class="closenotice">关闭</a>
				</h2>
				<p id="sogouconfirmtxt"></p>
				<a id="sogouconfirm" href="http://<?php echo $site_config['name'];?>/#"
					class="extconfirm">确 认</a>
				<a id="sogoucancel" href="http://<?php echo $site_config['name'];?>/#"
					class="extconfirm">取 消</a>
			</div>
		</div>
		<div id="TB_overlay" style="display: none; z-index: 2.14748e +009;"
			class="TB_overlayBG"></div>
		<iframe class="sogou_sugg_feedbackquan"
			style="background-image: initial; background-attachment: initial; background-origin: initial; background-clip: initial; background-color: transparent; border-top-style: none; border-right-style: none; border-bottom-style: none; border-left-style: none; border-width: initial; border-color: initial; z-index: 2.14748e +009; display: none; background-position: initial initial; background-repeat: initial initial;"
			frameborder="0" scrolling="no" src="images/yun1.htm"></iframe>
	</body>
	<style>
.sogou_sugg_feedbackquan {
	position: fixed;
	left: 0;
	padding: 0;
	margin: 0;
	bottom: 0;
	width: 100%;
	height: 38px;
}

.sogoutip {
	width: 199px;
	height: 56px;
	padding: 10px 20px 0 15px;
	line-height: 18px;
	background: url(http://ht.www.sogou.com/images/extsugg/sogoutip.gif)
		no-repeat;
	position: fixed;
	font-size: 13px;
	bottom: 38px;
	left: 150px;
	text-align: left;
	color: #000;
}

.closesogoutip {
	width: 9px;
	height: 8px;
	background: url(http://ht.www.sogou.com/images/extsugg/sogoutip.gif)
		no-repeat left -72px;
	line-height: 10em;
	overflow: hidden;
	right: 8px;
	top: 7px;
	position: absolute;
}

.sogoubottom {
	clear: both;
	height: 40px;
	width: 100%;
	padding: 0;
	margin: 0;
	position: relative;
	z-index: -99;
}

.extoptboxbg {
	background: url(http://ht.www.sogou.com/images/extsugg/optbox.png)
		no-repeat;
	width: 144px;
	height: 109px;
	position: fixed;
	right: 16px;
	bottom: 35px;
}

.extoptbox {
	width: 127px;
	height: 75px;
	position: fixed;
	right: 25px;
	bottom: 57px;
	line-height: 22px;
	font-size: 12px;
}

.extoptbox a,.extoptbox a:hover {
	color: #426BBD;
	display: block;
	padding-left: 9px;
	text-decoration: none;
	text-align: left;
}

.extoptbox a:hover {
	background-color: #EAF1F5;
}

.extfeedback {
	border-top: 1px solid #ccc;
	margin-top: 4px;
	padding-top: 4px;
}

.extnoticebg {
	margin: 0;
	left: 0;
	top: 0;
	width: 418px;
	height: 185px;
	background: url(http://ht.www.sogou.com/images/extsugg/noticebg.png)
		no-repeat;
	position: absolute;
}

.extnotice {
	width: 402px;
	height: 169px;
	position: absolute;
	left: 8px;
	top: 8px;
	font-size: 14px;
	text-align: center;
	color: #000;
}

.extnotice h2 {
	line-height: 29px;
	padding: 0 9px;
	font-size: 13px;
	text-align: left;
	color: #000;
}

.extnotice p {
	margin: 28px 0 33px;
	color: #000;
}

.extconfirm,.extconfirm:hover {
	width: 63px;
	height: 23px;
	line-height: 23px;
	display: inline-block;
	font-weight: bold;
	color: #515F68;
	margin: 0 20px;
	background: #D7E5ED;
	filter: progid : DXImageTransform . Microsoft .
		gradient(startcolorstr = #ECF2F6, endcolorstr = #D7E5ED, gradientType =
		0);
	background: -webkit-gradient(linear, left top, left bottom, from(#ECF2F6),
		to(#D7E5ED) );
	text-decoration: none;
	border: 1px solid #89B4E1;
}

.closenotice {
	width: 14px;
	height: 14px;
	background: #fff url(http://ht.www.sogou.com/images/extsugg/ui2.1.gif)
		no-repeat 2px -313px;
	border: 1px solid #B1CBE8;
	position: absolute;
	right: 7px;
	top: 7px;
	overflow: hidden;
	line-height: 100em;
}

.closenotice:hover {
	background-position: 2px -338px;
}

#TB_overlay {
	position: fixed;
	z-index: 100;
	top: 0px;
	left: 0px;
	height: 100%;
	width: 100%;
}

.TB_overlayMacFFBGHack {
	background: url(macFFBgHack.png) repeat;
}

.TB_overlayBG {
	background-color: #000;
	filter: alpha(opacity = 25);
	-moz-opacity: 0.25;
	opacity: 0.25;
}

* html #TB_overlay { /* ie6 hack */
	position: absolute;
	height: expression(document . body . scrollHeight >   document . body .
		offsetHeight ?   document . body . scrollHeight :   document . body .
		offsetHeight +   'px');
}

#TB_HideSelect {
	z-index: 99;
	position: fixed;
	top: 0;
	left: 0;
	background-color: #fff;
	border: none;
	filter: alpha(opacity = 0);
	-moz-opacity: 0;
	opacity: 0;
	height: 100%;
	width: 100%;
}

* html #TB_HideSelect { /* ie6 hack */
	position: absolute;
	height: expression(document . body . scrollHeight >   document . body .
		offsetHeight ?   document . body . scrollHeight :   document . body .
		offsetHeight +   'px');
}

#stophi {
	position: fixed;
	z-index: 102;
	display: none;
	top: 50%;
	left: 50%;
	width: 418px;
	height: 185px;
}

* html #stophi { /* ie6 hack */
	position: absolute;
	margin-top: expression(0 -   parseInt(this . offsetHeight/ 2) +   (
		TBWindowMargin =   document . documentElement &&   document .
		documentElement . scrollTop ||   document . body . scrollTop ) +  
		'px' );
}
</style>
</html>