<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-单场竞猜-订单详细</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<script language="javascript">
var submit_url = '/bjdc/submit_buy_join';
var join_user_forder = 'bjdc/';
</script>
<?php
echo html::script(array
(
    'media/js/yclass.js',
	'media/js/loginer',
	'media/js/fangan',
), FALSE);
echo html::stylesheet(array
(
 	'media/css/zc',
	'media/css/mask',
    'media/css/style',
    'media/css/css1',
), FALSE);
?>
<script language="javascript">
Y.extend('jsonp', function (url, data, fn){
    window['echo_json_'+data.c_id] = fn;
    Y.use(url);
});
</script>
<SCRIPT language=Javascript>
function openordowndiv(){
	var fanandiv = Y.one('#fanandiv');
	var openbut = Y.one('#openbutten');
	if(fanandiv.style.display=='none'){
		fanandiv.style.display='block';
		openbut.innerHTML = '点击隐藏方案';
		openbut.className = 'p_hide';
	}else{
		fanandiv.style.display='none';
		openbut.innerHTML = '点击显示方案';
		openbut.className = 'p_show';		
	}
}
window.init()
</SCRIPT>
</head>
<body>
<iframe style="position: fixed; display: none; opacity: 0;" frameborder="0"></iframe>
<div style="position: absolute; z-index: 1000000000; display: none; top: 50%; left: 50%; overflow: auto;" id="ckepop"></div>
<div style="position: absolute; z-index: 1000000000; display: none; overflow: auto;" id="ckepop"></div>
<!--header start--> 
<!--top小目录--> 
<?php echo View::factory('header')->render();?> 
<!--menu和列表_end--> 
<!--面包屑导航-->
<div class="width line36 gray68">
	<div style="float:left; margin-left:20px;">
		您所在的位置：
		<a href="<?php echo url::base();?>"><font class="blue">首页</font></a> &gt; 
		<a href="<?php echo url::base();?>bjdc/rqspf"><font class="blue">单场竞猜</font></a> &gt; 订单详细
	</div>
	<div style="float:right; margin-right:20px;">
		<span style="float:right">客服电话：<?php echo $site_config['kf_phone_num'];?></span>
	</div>
	<div style="clear:both;"></div>
</div>
<!--面包屑导航_end-->
<!--header end-->
<div class="mt30" id="bd">
  <div id="main">
    <div class="box_top" style="display:block;">
      <div class="box_top_l"></div>
    </div>
    <div class="box_m">
      <div class="det_t_bg">
        <div class="s-logo zqdc-logo"></div>
        <div class="det_h">
          <?php 
		  
switch($detail['play_method'])
{
	case 501:
		$expect_text="让球胜平负";
		$expect_url="/bjdc/rqspf";
		break;
	case 503:
		$expect_text="总进球数";
		$expect_url="/bjdc/zjqs";
		break;
	case 504:
		$expect_text="比分";
		$expect_url="/bjdc/bf";
		break;		
	case 505:
		$expect_text="半全场";
		$expect_url="/bjdc/bqc";
		break;		
	case 502:
		$expect_text="上下单双";
		$expect_url="/bjdc/sxds";
		break;
}

if($detail['plan_type'] == 0)
{
	$text1="代购";
}
elseif($detail['plan_type'] == 1)
{
	$text1="合买";		
}
else
{
	$text1="参与合买";	
}
				
?>
          <h2></h2>
          <p><span class="m_r25">此方案发起时间：<?php echo $detail['time_stamp'];?></span><span class="m_r25">认购截止时间：<?php echo $detail['time_end'];?></span><span>方案编号：<?php echo $detail['basic_id'];?></span></p>
        </div>
        <a href="/buycenter" class="m_link">返回合买列表&gt;&gt;</a> </div>
      <div id="xx1">
        <div class="det_g_t">方案基本信息</div>
        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="buy_table">
				<tbody>
				  <tr>
					<td class="td_title2">发起人信息</td>
					<td class="con_content">
                        	<?php echo $user['lastname'];?>
                        </td>					
				  </tr>
				  <tr>
					<td class="td_title2">方案信息</td>
					<td class="con_content">
						<div class="tdbback">
							<table width="100%" cellspacing="0" cellpadding="0" border="0" class="tablelay eng">
							<tbody>
							  <tr>
                                <th width="16%">总金额</th>
                                <th width="8%">倍数</th>
                                <th width="7%">份数</th>
                                <th width="10%">每份</th>
                                <th width="13%">发起人提成</th>
                                <th width="11%">彩票标识</th>
                                <th width="24%">保底金额</th>
                                <th width="11%" class="last_th">购买进度</th>	
							  </tr>
							  <tr class="last_tr">
								<td><span class="red">￥<?php echo $detail['total_price']?></span></td>
								<td><?php echo $detail['rate']?>倍</td>
								<td><?php echo $detail['copies']?>份</td>
								<td>￥<?php echo $detail['price_one']?></td>
								<td><?php  if(!empty($detail['deduct'])) {echo $detail['deduct'].'%';} ?></td>
                                <td>
                                <?php
                                if($detail['status'] == 2 || $detail['status'] == 3 || $detail['status'] == 4 || $detail['status'] == 5)
								{
									echo '已出票';
								}
								else
								{
									echo '未出票';
								}
								?>                                
                                <?php /**?><a href="javascript:void(0)" onclick="">已出票</a><?php **/?>
                                </td>
								<td><?php 
								if(empty($detail['baodinum']))
								{
									echo '未保底';
								}
								else
								{
									echo '￥'.$detail['baodinum'] * $detail['price_one'];
								}
								?></td>
								<td class="last_td">
									<span class="red"><?php echo $detail['progress']?>%</span>
								</td>
							  </tr>
							</tbody>
							</table>
						</div>
						<div class="detail_d clearfix">
							<p class="p_xh" style="width:528px">
							  过关方式：
                               <em class="red"><?php echo $detail['typename'];?></em>&nbsp;&nbsp;所选场次<?php echo count($codes);?>场
								<?php /**?><span><br />奖金范围：<span id="prize_predict" class="red"></span> 元 </span><?php **/?>
							</p>
							<a class="tog_fa" href="javascript:void(0)" style="margin-top:45px" onclick="toggle_fanandiv(this)">点击隐藏方案<b class="c_up"></b></a>
						</div>
						<div class="tdbback" id="fanandiv">

							<table width="100%" cellspacing="0" cellpadding="0" border="0" class="tablelay eng">							
							  <tbody>
							  <tr>
							  	<th>赛事编号</th>
								<th>期数</th>
								<th>主队 VS 客队</th>
								<?php
                                if ($detail['play_method'] == 501)
                                {
                                ?>
                                <th>让球数</th>
                                <?php
                                }
                                ?>                                
                                <th>全场比分</th>
								<th>赛果</th>
								<th>您的选择</th>
								<th class="last_th">胆码</th>
							  </tr>

<?php
//var_dump($spenums);
foreach ($codes as  $key=>$value)
//echo $key;
{
?>
<tr class="tr1" mid="<?php echo $matchs[$key]['id'];?>">
<td style="width:8%"><?php echo $matchs[$key]['match_no'];?></td>
<td style="width:8%"><?php echo $matchs[$key]['issue'];?></td>
<td><?php echo $matchs[$key]['home'];?> VS <?php echo $matchs[$key]['away'];?></td>
<?php
if ($detail['play_method'] == 501)
{
?>
<td><?php echo intval($matchs[$key]['goalline']);?></td>
<?php
}
?>
<td style="width:8%"><?php if ($matchs[$key]['bf'] != '') echo $matchs[$key]['bf']; else echo '-';?></td>
<td style="width:7%">
<?php 
if ($matchs[$key]['code'] !== '') {
	$bjdc_config = Kohana::config('bjdc');
	$method = $bjdc_config['play_method'][$detail['play_method']];
	$method_dyj = $bjdc_config['play_method_dyj'][$detail['play_method']];
	//$result_code = array_flip($bjdc_config[$method]);
	//$result = $result_code[$matchs[$key]['code']];
	
	$result_code = array_flip($bjdc_config[$method_dyj]);
	$result = $result_code[$matchs[$key]['code']];
	
	echo $result; 
}
else {
	echo '-';
}
?></td>
<td style="width:200px;word-wrap: break-word;" >
<?php 
if (isset($result)) {
$my_sel = str_replace($result, '<font color="red">'.$result.'('.$final_sp[$key].')</font>', $select[$key]);
echo $my_sel;
}
else {
	echo $select[$key];
}
?>
</td>
<td class="last_td">
<?php if(isset($spenums[$key]) && $spenums[$key]==true)
{
	echo '√';
}
else
{
	echo '×';
}
?></td>
</tr>
<?
	}
	//echo $detail['status'];
?>
<tr class="last_tr">
<td colspan="8">
<table width="100%">
<tr>
<td colspan="5" style="border-right:none;">
<p class="p_tj">
    过关方式：<span class="red"><?php echo $detail['typename'];?></span> 总金额：<span class="eng red">￥<?php echo $detail['total_price'];?></span>元&nbsp;&nbsp;<?php /**?><a href="javascript:void(0)" onclick="">查看拆分明细</a><?php **/?>
<br />
<?php
if ($detail['status'] == 3 || $detail['status'] == 4 || 
		$detail['status'] == 5 ) {
?>
方案税后奖金：<span class="eng red">￥<?php if ($detail['bonus'] == NULL || $detail['bonus'] == '') echo 0;else echo $detail['bonus'];?></span>元
<?php
}
if ($detail['status']==4 || $detail['status']==5)
{
	echo '&nbsp;&nbsp;&nbsp;&nbsp;<span style="cursor:pointer" onClick="Y.openUrl(\''.url::base().'bjdc/bonus_info/'.$detail['basic_id'].'\',700,414)"><font color="#FF6600"><u>查看奖金明细</u></font></span>';
}
?>
</p></td>
<td colspan="3">&nbsp;</td>
</tr>
</table>
</td>
</tr>

							</table>
						</div>
					</td>
				  </tr>
<?php
if ($is_open)
{
?>
<form name="project_form" action="" method="post">
<tr>
<td class="td_title2">我要认购</td>
<td class="con_content">         
<div class="buy_btn">
<a id="submitCaseBtn3" href="javascript:void 0" class="btn_buy_m" title="立即购买">立即购买</a>
</div>
<p><span id="userMoneyInfo">您尚未登录，请先<a href="javascript:void 0" title="" onclick="Yobj.postMsg('msg_login')">登录</a>！</span><br />
还可以认购 <span class="red eng"><?php echo ($detail['surplus']);?></span> 份，我要认购
<input name="buynum" id="buynum" type="text" class="mul" maxlength="6" value="1" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onkeydown="if(event.keyCode==13){checkForm();return false;}"/>
份 总金额<span class="red eng">￥</span><span class="red eng" id="permoney">1.00</span>元</p>							
<p class="read"><span class="hide_sp"><input type="checkbox" checked="checked" id="agreement" value="1"/></span>我已阅读并同意《<a href="javascript:;" onclick="Y.openUrl('/doc/webdoc/gmxy',505,426)">用户合买代购协议</a>》</p>
<input type="hidden" value="1" id="agreement2"/>
</td>
</tr>
<input name="isend" id="isend" type='hidden'  value="<?php if((time() - strtotime($detail['time_end'])) > 0){echo 0;}else{echo 1;}?>" />
<input name="isend" id="isjprizesuc" type='hidden'  value="<?php if((time() - strtotime($detail['time_end'])) > 0){echo 0;}else{echo 1;}?>" />
<input name="pregetmoney" id="pregetmoney" type='hidden'  value="<?php echo $detail['bonus']?>" />
<input name="anumber" id="anumber" type='hidden'  value="<?php echo $detail['copies']?>" />
<input name="order_num" id="lotid" type="hidden" value="<?php echo $detail['basic_id']?>">
<input name="lotid" id="lotid" type="hidden" value="7" />
<!--彩种Id-->
<input name="playid" id="playid" type="hidden" value="<?php echo $detail['play_method'];?>" />
<!--玩法Id-->
<input name="expect" id="expect" type="hidden" value="<?php echo $detail['issue']?>" />
<!--期号-->
<input name="pid" id="pid" type="hidden" value="<?php echo $detail['id']?>" />
<!--彩种Id-->
<input name="senumber" id="senumber" type="hidden" value="<?php echo ($detail['copies']-$detail['buyed'])?>" />
<!--保底份数-->
<input name="onemoney" id="onemoney" type="hidden" value="<?php echo $detail['price_one']?>" />
<!--每份金额-->
<input name="ishm" id="ishm" type='hidden' value="1" />
<!--是否是合买-->
<input name="care_username" id="main_username" type="hidden" value="<?php echo $user['lastname'];?>" />
<input name="buymumber" id="buymumber" type="hidden" value="<?php echo $detail['copies'];?>" /><!--认购份数--> 	
<input name="reload" id="reload" type="hidden" value="1">
<input name="orderstr" id="orderstr" type="hidden" value="1">
<input name="orderby" id="orderby" type="hidden" value="desc">						        		 
</form>
<?php
}
?>
                      <!--开奖后显示开奖号码-->
                      <tr>
                        <td class="td_title2">中奖详情</td>
                        <td class="con_content">
                        	<p>购买详情：<?php
							if ($is_open)
							{
								echo '未满员';
							}
							else
							{
								if($detail['zhushu'] == $detail['buyed'])
								{
									echo '满员,';	
								}
								
								 echo '已结束';		
							}
							?></p>
<p><?php if ($detail['status'] == 3 || $detail['status'] == 4 ||$detail['status'] == 5 ) { ?>税后奖金：<font color=red>￥<?php if ($detail['bonus'] == NULL || $detail['bonus'] == '') echo 0;else echo $detail['bonus'];?></font>，<?php }?>发起人提成<font color=red>￥<?php echo $detail['bonus']*($detail['deduct']/100);?></font>，每份派奖：<font color=red>￥<?php echo $detail['bonus']/$detail['copies'];?></font>&nbsp;&nbsp;&nbsp;&nbsp;<?php /**?><span style="cursor:pointer" onClick=""><font color="#FF6600"><u>查看奖金明细</u></font></span><?php **/?></p>                        </td>
                      </tr>
				</tbody>
				</table>
      </div>
      
      
      <div id="xx2">
        <div class="det_g_t">方案分享信息</div>
        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="buy_table">
				<tbody>
		
				  <tr>
					<td class="td_title2">方案宣传</td>

					<td class="con_content">
						<div class="detail_d clearfix" style="overflow:visible;">
                        
                        <?php
                        /**
						?>
                        <div class="copy_link" style="position:relative; width:200px;">
                         			               <div style="position:absolute; right:-5px; top:-35px;"><div class="yjsd_tip" id="hmltips" style="display:"><span class="">现在可以晒方案啦！<a href="javascript:void(0);" onclick="Y.one('#hmltips').style.display='none'">我知道了</a></span></div>
			                </div><span><a href="javascript:void(0);" class="btn_shaid" title="" style="padding-left:15px;" data-help="一键晒单：将该方案分享到晒单专区或论坛，不仅可以晒自己的方案，还可以晒别人的方案哦！" onclick="Y.postMsg('showdaidan')">一键晒单</a></span><span class="gray"> | </span>
                          </div> 
                         <?php
						 **/
						 ?>
							<p class="gray">方案标题：<?php echo $detail['title'];?></p>
							<p class="gray">方案描述：<?php echo $detail['content'];?></p>
                            
						 </div>
					</td>
				  </tr>
				  <tr class="last_tr">
					<td class="td_title2">合买用户</td>
					<td class="con_content">
                    <p>
                    <?php
                    if ($detail['isset_buyuser']==1)
					{
						echo '该方案对所有网友开放。';	
					}
					elseif ($detail['isset_buyuser']==2)
					{
						echo '该方案对指定网友开放。';	
					}
					?></p>
						<?php 
						/**
						?>
						<div class="yh_tab">
							<ul class="clearfix">
								<li id="joinCount" class="" onclick="javascript:Showan(1,2);">总参与人数<span id="totalCount"></span>人</li>
								<li id="meyBuy" class="an_cur" onclick="javascript:Showan(2,2);">您的认购记录</li>
							</ul>
						</div>
                        <?php
						**/
						?>
						<div id="show_list_div"></div>
					</td>
				  </tr>
				</tbody>
				</table>
      </div>
    </div>
  </div>
</div>
<!--footer start--> 
<?php echo View::factory('footer')->render();?> 
<!--footer end-->
<textarea id="responseJson" style="display: none;">{
	serverTime :  "<?php echo date("Y-m-d H:i:s");?>",   //服务器时间
	endTime :     "<?php echo $detail['time_end'];?>",   //截止时间
	singlePrice : 2,   									 //单注金额
	baseUrl : "<?php echo url::base();?>"  				 //网站根目录
}</textarea>

<div id="ft">
      <!--底部包含文件-->

      <!--未登录提示层-->
      <?php echo View::factory('login')->render();?>
      <!--默认提示层-->
      <div class="tips_m" style="display:none;" id="defLay">
        <div class="tips_b">
          <div class="tips_box">
            <div class="tips_title">
              <h2>温馨提示</h2>
              <span class="close" id="defTopClose"><a href="javascript:void(0);">关闭</a></span> </div>
            <div class="tips_text" id="defConent" style="padding:18px;text-align:center;"></div>
            <div class="tips_sbt" style="padding:8px;text-align:center;height:auto;">
              <input class="btn_Lblue_m" value="关闭" id="defCloseBtn" type="button">
            </div>
          </div>
        </div>
      </div>
      <!--号码示例层-->
      <div class="tips_m" style="display:none;" id="codeTpl">
        <div class="tips_b">
          <div class="tips_box">
            <div class="tips_title">
              <h2>温馨提示</h2>
              <span class="close" id="codeTplClose"><a href="javascript:void(0);">关闭</a></span> </div>
            <div class="tips_text" id="codeTplConent" style="padding:18px;"></div>
            <div class="tips_sbt" style="padding:8px;text-align:center;height:auto;">
              <input class="btn_Lora_b" value="知道了" id="codeTplYes" type="button">
            </div>
          </div>
        </div>
      </div>
      <!--余额不足内容-->
      <div class="tips_m" style="top: 300px; display: none; position: absolute;" id="addMoneyLay">
        <div class="tips_b">
          <div class="tips_box">
            <div style="cursor: move;" class="tips_title">
              <h2>可用余额不足</h2>
              <span class="close" id="addMoneyClose"><a href="javascript:void%200">关闭</a></span> </div>
            <div class="tips_text">
              <p class="pd_l tc f14" id="addMoneyContent">您的可投注余额不足，请充值<br>
                (点充值跳到"充值"页面，点"返回"可进行修改)</p>
            </div>
            <div class="tips_sbt">
              <input value="返 回" class="btn_Lora_b" id="addMoneyNo" type="button">
              <input value="充 值" class="btn_Dora_b" id="addMoneyYes" type="button">
            </div>
          </div>
        </div>
      </div>
      <!--代购确认-->
      <div class="tips_m" style="display: none; position: absolute;" id="b2_dlg">
        <div class="tips_b">
          <div class="tips_box">
            <div style="cursor: move;" class="tips_title">
              <h2 id="b2_dlg_title">确认投注内容</h2>
              <span class="close" id="b2_dlg_close"><a href="#">关闭</a></span> </div>
            <div class="tips_info" id="b2_dlg_content"></div>
            <div class="tips_sbt">
              <input value="取 消" class="btn_Lora_b" id="b2_dlg_no" type="button">
              <input value="确 定" class="btn_Dora_b" id="b2_dlg_yes" type="button">
            </div>
          </div>
        </div>
      </div>
      <!--机选号码列表-->
      <div class="tips_m" style="top:300px;width:300px;display:none;position:absolute" id="jx_dlg">
        <div class="tips_b">
          <div class="tips_box">
            <div class="tips_title">
              <h2>机选号码列表</h2>
              <span class="close" id="jx_dlg_close"><a href="#">关闭</a></span> </div>
            <div class="tips_text">
              <ul class="tips_text_list" id="jx_dlg_list">
              </ul>
            </div>
            <div class="tips_sbt">
              <input value="重新机选" class="btn_gray_b m-r" id="jx_dlg_re" type="button">
              <input value="选好了" class="s-ok s-ok-sp" id="jx_dlg_ok" type="button">
            </div>
          </div>
        </div>
      </div>
      <!--查看胆拖明细列表-->
      <div class="tips_m" style="top: 300px; width: 300px; display: none; position: absolute;" id="split_dlg">
        <div class="tips_b">
          <div class="tips_box">
            <div style="cursor: move;" class="tips_title">
              <h2>查看投注明细</h2>
              <span class="close" id="split_dlg_close"><a href="#">关闭</a></span> </div>
            <div class="tips_text">
              <ul class="tips_text_list" id="split_dlg_list" style="height:284px;overflow:auto;">
              </ul>
            </div>
            <div class="tips_sbt">
              <input value="关 闭" class="s-ok" id="split_dlg_ok" type="button">
            </div>
          </div>
        </div>
      </div>
      <!--温馨提示-->
      <div style="top: 700px; display: none; width: 500px; position: absolute;" class="tips_m" id="info_dlg">
        <div class="tips_b">
          <div class="tips_box">
            <div style="cursor: move;" class="tips_title">
              <h2>温馨提示</h2>
              <span class="close" id="info_dlg_close"><a href="#">关闭</a></span> </div>
            <div class="alert_c">
              <div class="state error">
                <div class="stateInfo f14 p_t10" id="info_dlg_content"></div>
              </div>
            </div>
            <div class="tips_sbt">
              <input class="btn_Dora_b" value="确 定" id="info_dlg_ok" type="button">
            </div>
          </div>
        </div>
      </div>
      <!-- 确认投注内容 -->
      <div class="tips_m" style="width: 700px; display: none; position: absolute;" id="ishm_dlg">
        <div class="tips_b">
          <div class="tips_box">
            <div style="cursor: move;" class="tips_title">
              <h2 id="ishm_dlg_title">方案合买</h2>
              <span class="close"><a href="javascript:void%200" id="ishm_dlg_close">关闭</a></span> </div>
            <div class="tips_info tips_info_np" id="ishm_dlg_content"></div>
            <div class="tips_sbt">
              <input value="确认投注" class="btn_Dora_b" id="ishm_dlg_yes" type="button">
              <a href="javascript:void(0);" class="btn_modifyFont" title="返回修改" id="ishm_dlg_no">返回修改&gt;&gt;</a> </div>
          </div>
        </div>
      </div>
      <!--提示确认-->
      <div class="tips_m" style="display: none; position: absolute;" id="confirm_dlg">
        <div class="tips_b">
          <div class="tips_box">
            <div style="cursor: move;" class="tips_title">
              <h2 id="confirm_dlg_title">温馨提示</h2>
              <span class="close" id="confirm_dlg_close"><a href="#">关闭</a></span> </div>
            <div class="tips_info" id="confirm_dlg_content"></div>
            <div class="tips_sbt">
              <input value="取 消" class="btn_Lora_b" id="confirm_dlg_no" type="button">
              <input value="确 定" class="btn_Dora_b" id="confirm_dlg_yes" type="button">
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--弹窗内容文件-->
  </div>
</div>
<div style="position: absolute; display: none; z-index: 9999;" id="livemargins_control"><img src="images/monitor-background-horizontal.png" style="position: absolute; left: -77px; top: -5px;" height="5" width="77"> <img src="images/monitor-background-vertical.png" style="position: absolute; left: 0pt; top: -5px;"> <img id="monitor-play-button" src="images/monitor-play-button.png" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.5" style="position: absolute; left: 1px; top: 0pt; opacity: 0.5; cursor: pointer;"></div>
<div class="tips_m" style="top: 700px; width: 500px; display: none; position: absolute;" id="yclass_alert">
  <div class="tips_b">
    <div class="tips_box">
      <div style="cursor: move;" class="tips_title">
        <h2 id="yclass_alert_title">温馨提示</h2>
        <span class="close" id="yclass_alert_close"><a href="#">关闭</a></span> </div>
      <div class="alert_c">
        <div class="state error">
          <div class="stateInfo f14 p_t10" id="yclass_alert_content"></div>
        </div>
      </div>
      <div class="tips_sbt">
        <input value="确 定" class="btn_Dora_b" id="yclass_alert_ok" type="button">
      </div>
    </div>
  </div>
</div>
<div class="tips_m" style="display: none; position: absolute;" id="yclass_confirm">
  <div class="tips_b">
    <div class="tips_box">
      <div style="cursor: move;" class="tips_title">
        <h2 id="yclass_confirm_title">温馨提示</h2>
        <span class="close" id="yclass_confirm_close"><a href="#">关闭</a></span> </div>
      <div class="tips_info" id="yclass_confirm_content" style="zoom:1"></div>
      <div class="tips_sbt">
        <input value="取 消" class="btn_Lora_b" id="yclass_confirm_no" type="button">
        <input value="确 定" class="btn_Dora_b" id="yclass_confirm_ok" type="button">
      </div>
    </div>
  </div>
</div>
<div style="display:none;" id="open_iframe">
  <div id="open_iframe_content"></div>
</div>
<div style="opacity: 0.2;" tabindex="-1" class="yclass_mask_panel"></div>
<div style="position: absolute; z-index: 500000; left: -99999px;">
  <div style="min-width: 120px; text-align: center; font: 12px/1.5 verdana; color: rgb(51, 51, 51);"></div>
  <div style="position: absolute; left: 0pt; top: 0pt; display: none; z-index: 9; width: 88%; height: 30px; background: none repeat scroll 0% 0% rgb(238, 238, 238); opacity: 0.1; cursor: move;"></div>
</div>
<div class="notifyicon tip-2">
  <div class="notifyicon_content"></div>
  <div class="notifyicon_arrow"><s></s><em></em></div>
  <div class="notifyicon_space"></div>
</div>

<script type="text/javascript">
var fanandiv = document.getElementById('fanandiv');
function toggle_fanandiv(that) {
	if (fanandiv.style.display == 'none') {
		fanandiv.style.display = '';
		that.getElementsByTagName('b')[0].className = 'c_up';
	} else {
		fanandiv.style.display = 'none';
		that.getElementsByTagName('b')[0].className = 'c_down';
	}
}
Class( {
	ready : true,
	index : function() {
		var max_prize = 0,
			min_prize = 0,
			zygg,  //是否自由过关
			_gg_name,
			issuc     = this.getInt(this.get('#issuc').val()),
			gg_name   = this.get('#gg_name').val(),
			beishu    = this.get('#beishu').val(),
			max_pl    = this.get('#max_pl').val(),
			min_pl    = this.get('#min_pl').val(),
			max_danpl = this.get('#max_danpl').val(),
			min_danpl = this.get('#min_danpl').val();
		if (issuc>0) {
			max_prize = this.get('#max_pl').val();
			min_prize = this.get('#min_pl').val();
			beishu=1;
		} else {
            var dt = this.getDT(this.get('#max_pl').val(), this.get('#min_pl').val());
            var max_t_pl = [], max_d_pl = [],
                 min_t_pl = [], min_d_pl = [],
                 d=dt.d, t=dt.t;
            for(var k in d){
                var pl = d[k];
                pl.sort(Array.up);
                min_d_pl.push(pl[0]);
                max_d_pl.push(pl[pl.length-1]);
            }
            for(k in t){
                var pl = t[k];
                pl.sort(Array.up);
                min_t_pl.push(pl[0]);
                max_t_pl.push(pl[pl.length-1]);
            }
            min_t_pl.sort(Array.up);
            min_d_pl.sort(Array.up);
            var gg = gg_name.split(',').map(function (x){
                return parseInt(x)
            }).sort(Array.up)[0];
            if (gg>min_d_pl.length) {//如果最小命中大于胆SP组的长度, 则取相应长度的拖
                min_t_pl = min_t_pl.slice(0, gg - min_d_pl.length)
            }else{
                min_d_pl = min_d_pl.slice(0, gg);
                min_t_pl = [];
            }
			max_prize = this.postMsg('msg_predict_max_prize', max_t_pl, gg_name, max_d_pl , true).data;//t, type, d, round
			min_prize = this.postMsg('msg_predict_min_prize', min_t_pl, gg_name, min_d_pl, true).data;
		}
		if (min_prize && max_prize) {//显示区间
			this.get('#prize_predict').html('￥' + (min_prize * beishu).toFixed(2) + '-' + (max_prize * beishu).toFixed(2));
		} else {//隐藏
			this.get('#prize_predict').parent('span').hide();
			this.get('a.tog_fa').setStyle('marginTop', 0);
		}
	},
    getDT: function (d, t){//取得胆拖数据
        var d1 = this.string2obj(d);
            all = this.string2obj(t), t2={}, d2={};
            for(var k in all){
                if (k in d1) {
                    d2[k] = all[k]
                }else{
                    t2[k] = all[k]
                }
            }
        return {
            d: d2,
            t: t2
        }
    },
    string2obj: function (str){
        var g, o={};
		if (str.trim()!='') {
			g = str.toString().split('/');
			g.each(function (a, i){
				var x=a.replace(']','').split('[');
				o[x[0]] = x[1].replace(/[^#,]+#/g,'').split(',');
			});
		}
        return o;
    }
} );
window.init();
</script>
<div style="position: absolute; display: none; z-index: 9999;" id="livemargins_control"><img src="faxq_files/monitor-background-horizontal.png" style="position: absolute; left: -77px; top: -5px;" height="5" width="77"> <img src="faxq_files/monitor-background-vertical.png" style="position: absolute; left: 0pt; top: -5px;"> <img id="monitor-play-button" src="faxq_files/monitor-play-button.png" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.5" style="position: absolute; left: 1px; top: 0pt; opacity: 0.5; cursor: pointer;"></div>
<div class="tips_m" style="top: 700px; width: 500px; display: none; position: absolute;" id="yclass_alert">
  <div class="tips_b">
    <div class="tips_box">
      <div style="cursor: move;" class="tips_title">
        <h2 id="yclass_alert_title">温馨提示</h2>
        <span class="close" id="yclass_alert_close"><a href="#">关闭</a></span> </div>
      <div class="alert_c">
        <div class="state error">
          <div class="stateInfo f14 p_t10" id="yclass_alert_content"></div>
        </div>
      </div>
      <div class="tips_sbt">
        <input value="确 定" class="btn_Dora_b" id="yclass_alert_ok" type="button">
      </div>
    </div>
  </div>
</div>
<div class="tips_m" style="display: none; position: absolute;" id="yclass_confirm">
  <div class="tips_b">
    <div class="tips_box">
      <div style="cursor: move;" class="tips_title">
        <h2 id="yclass_confirm_title">温馨提示</h2>
        <span class="close" id="yclass_confirm_close"><a href="#">关闭</a></span> </div>
      <div class="tips_info">
        <div class="stateInfo f14 p_t10" id="yclass_confirm_content" style="zoom:1"></div>
      </div>
      <div class="tips_sbt">
        <input value="取 消" class="btn_Lora_b" id="yclass_confirm_no" type="button">
        <input value="确 定" class="btn_Dora_b" id="yclass_confirm_ok" type="button">
      </div>
    </div>
  </div>
</div>
<div style="display:none;" id="open_iframe">
  <div id="open_iframe_content"></div>
</div>
<div style="opacity: 0.2;" tabindex="-1" class="yclass_mask_panel"></div>
<div style="position: absolute; z-index: 500000; left: -99999px;">
  <div style="min-width: 120px; text-align: center; font: 12px/1.5 verdana; color: rgb(51, 51, 51);"></div>
  <div style="position: absolute; left: 0pt; top: 0pt; display: none; z-index: 9; width: 88%; height: 30px; background: none repeat scroll 0% 0% rgb(238, 238, 238); opacity: 0.1; cursor: move;"></div>
</div>
<div class="notifyicon tip-2">
  <div class="notifyicon_content"></div>
  <div class="notifyicon_arrow"><s></s><em></em></div>
  <div class="notifyicon_space"></div>
</div>
</body>
</html>