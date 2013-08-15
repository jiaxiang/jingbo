<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-竞彩足球-订单详情</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<script language="javascript">
var submit_url = '/jczq/submit_buy_join';
var join_user_forder = 'jczq/';
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
</script>
</head>
<body>
<?php echo View::factory('header')->render();?> 
<!--menu和列表_end--> 
<!--面包屑导航-->
<div class="width line36 gray68">
	<div style="float:left; margin-left:20px;">
		您所在的位置：
		<a href="<?php echo url::base();?>"><font class="blue">首页</font></a> &gt; 
		<a href="<?php echo url::base();?>jczq/rqspf"><font class="blue">竞彩足球</font></a> &gt; 订单详细
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
        <div class="s-logo jczq-logo"></div>
        <div class="det_h">
<?php 
switch($detail['play_method'])
{
	case 1:
		$expect_text="让球胜平负";
		$expect_url="/jczq/rqspf";
		break;
	case 2:
		$expect_text="总进球数";
		$expect_url="/jczq/zjqs";
		break;
	case 3:
		$expect_text="比分";
		$expect_url="/jczq/bf";
		break;		
	case 4:
		$expect_text="半全场";
		$expect_url="/jczq/bqc";
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
<h2>竞彩足球<?php
switch ($detail['play_method'])
{
	case 1:
		echo '让球胜平负';
		break;
	case 2:
		echo '总进球数';
		break;
	case 3:
		echo '比分';
		break;
	case 4:
		echo '半全场';
		break;
}
if ($detail['plan_type']==0)
{
	echo '代购';	
}
else
{
	echo '合买';
}
if ($detail['is_ds'] == true)
{
	echo '（单式上传）';	
}
?></h2>
<!--  -->
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
                        	<?php echo $user['lastname'];

							?>

<?php
if($_user['id']!=$detail['user_id']){
?>
<div id="auto_order">
<span id="zdgd" class="gray">自动跟单：</span>
<a class="btn_dot1" id="auto_order" href="javascript:void 0">我要定制</a>
</div>
<?php } ?>

                        </td>					
				  </tr>
<?php 
if ($detail['is_ds'] == false) {
?>
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
                                <th width="13%">发起人购买</th>
                                <th width="11%">保底金额</th>
                                <th width="11%">彩票标识</th>
                                
                                <th width="11%" class="last_th">购买进度</th>	
							  </tr>
							  <tr class="last_tr">
								<td><span class="red">￥<?php echo $detail['total_price']?></span></td>
								<td><?php echo $detail['rate']?>倍</td>
								<td><?php echo $detail['zhushu']?>份</td>
								<td>￥<?php echo $detail['price_one']?></td>
								<td><?php  if(!empty($detail['deduct'])) {echo $detail['deduct'];} ?></td>
                                <td><?php echo $detail['my_copies']?>份</td>
								<td><?php 
								if(empty($detail['baodinum']))
								{
									echo '未保底';
								}
								else
								{
									echo $detail['baodinum'] * $detail['price_one'];
								}
								?></td>
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
                                <?php /**?><a href="javascript:void(0)" onclick="Y.openUrl('http://trade.500wan.com/main/sign.php?lotid=46&playid=269&pid=3598155&s=1',692,414)">已出票</a><?php **/?>
                                </td>

								<td class="last_td">
									<span class="red"><?php echo $detail['progress']?>%</span>
								</td>
							  </tr>
							</tbody>
							</table>
						</div>
						
						<?php 
						if ($is_public === true) {
						?>
						
						<div class="detail_d clearfix">
							<p class="p_xh" style="width:528px">
							  过关方式：
                               <em class="red"><?php echo $detail['typename'];?></em>&nbsp;&nbsp;所选场次<?php echo count($match_groups);?>场
								<?php /**?><span><br />奖金范围：<span id="prize_predict" class="red"></span> 元 </span><?php **/?>
							</p>
							<a class="tog_fa" href="javascript:void(0)" style="margin-top:45px" onclick="toggle_fanandiv(this)">点击隐藏方案<b class="c_up"></b></a>
						</div>
						<div class="tdbback" id="fanandiv">
							<table width="100%" cellspacing="0" cellpadding="0" border="0" class="tablelay eng">							
							  <tbody>
							  <tr>
								<th>赛事编号</th>
								<th>主队 VS 客队</th>
								<?php
                                if ($detail['play_method'] == 1)
                                {
                                ?>
                                <th>让球数</th>
                                <?php
                                }
                                ?>                                
                                <th>比分</th>
								<th>赛果</th>
								<th>您的选择</th>
								<th class="last_th">胆码</th>
							  </tr>

<?php
foreach ($match_groups as  $key=>$value)
{
	//胜|1:0|1|平胜
?>
<tr class="tr1" mid="<?php if (isset($value['match']['id'])) echo $value['match']['id']; ?>">
<td style="width:8%"><?php if (isset($value['match']['match_info'])) echo $value['match']['match_info'];?></td>
<td><?php if (isset($value['match']['host_name'])) echo $value['match']['host_name'];?> VS <?php if (isset($value['match']['guest_name'])) echo $value['match']['guest_name'];?></td>
<?php
if ($detail['play_method'] == 1)
{
?>
<td><?php if (isset($value['match']['goalline'])) echo intval($value['match']['goalline']);?></td>
<?php
}
?>
<td style="width:8%"><?php if (!empty($value['match_results'][1])) echo $value['match_results'][1]; else echo '-'?></td>
<td style="width:7%">
<?php
$match_result_fs = '-';
if ($detail['play_method'] == 1 && isset($value['match_results'][0])) $match_result_fs = $value['match_results'][0]; 
elseif ($detail['play_method'] == 2 && isset($value['match_results'][2])) $match_result_fs = $value['match_results'][2]; 
elseif ($detail['play_method'] == 3 && isset($value['match_results'][1])) $match_result_fs = $value['match_results'][1]; 
elseif ($detail['play_method'] == 4 && isset($value['match_results'][3])) $match_result_fs = $value['match_results'][3]; 
if ($match_result_fs == 'cancel') echo '取消';
else echo $match_result_fs; 
?>
</td>
<td style="width:200px;word-wrap: break-word;" ><?php
$temparr = array();
if (isset($value['sele'])) {
	foreach ($value['sele'] as $keysele => $valuesele)
	{
		$addodds = '';
		//echo $valuesele;
		if(!empty($odds[$valuesele]))
		{
			$addodds = $odds[$valuesele];
		}
		//选中着色
		$color = '';
		if (!empty($value['match_results']))
		{
			if ($detail['play_method'] == 1)
			{
				if ($keysele == $value['match_results'][0])
				{
					$color = 'red';
				}
			}
			elseif ($detail['play_method'] == 2)
			{
				if ($keysele == $value['match_results'][2])
				{
					$color = 'red';
				}			
			}
			elseif ($detail['play_method'] == 3)
			{
				if ($keysele == $value['match_results'][1])
				{
					$color = 'red';
				}			
			}		
			elseif ($detail['play_method'] == 4)
			{
				if ($keysele == $value['match_results'][3])
				{
					$color = 'red';
				}
			}
		}
		$temparr[] = $color =='red' ? '<font color="red">'.$keysele.'('.$addodds.')</font>' : $keysele.'('.$addodds.')';
	}
}
echo implode('，', $temparr);
?></td>
<td class="last_td">
<?php if(empty($spenums[$key]))
{
	echo '×';
}
else
{
	echo '√';
}
?></td>
</tr>
<?
	}
?>
<tr class="last_tr">
<td colspan="7">
<table width="100%">
<tr>
<td colspan="5" style="border-right:none;">
<p class="p_tj">
    过关方式：<span class="red"><?php echo $detail['typename'];?></span> 总金额：<span class="eng red">￥<?php echo $detail['total_price'];?></span>元&nbsp;&nbsp;<?php /**?><a href="javascript:void(0)" onclick="Y.openUrl('http://trade.500wan.com/jczq/inc/project_detail.php?projectid=3598155',700,414)">查看拆分明细</a><?php **/?>
    <br />
    <?php
    if ($detail['status']==5)
	{
		echo '方案税后奖金：';
		echo '<span class="eng red">￥'.$detail['bonus'].'</span>元';	
	}
	else
	{
		echo '方案最高奖金：';
		echo '<span class="eng red">￥'.$detail['bonus_max'].'</span>元';						
	}
	?>
    								</p></td>
<td colspan="2">&nbsp;</td>
</tr>
</table>
</td>
</tr>
</table>
</div>
<?php
						}
						else {
							echo '<p> '.$is_public.'</p>';
						} 
?>

</td>
</tr>
<?php
} 
else {
?>
<tr>
<td class="td_title2">方案信息</td>
<td class="con_content">
<div class="clearfix">						
<?php
$d_count = count($ds_data);
$total_price = 0;
for ($i = 0; $i < $d_count; $i++) { 
?>
<div class="aff_l">
<div class="tdbback">
<table cellspacing="0" cellpadding="0" border="0" width="100%" class="tablelay eng" id="buyTable">
<tbody>
<tr>
<th>赛事</th>
<th>对阵</th>
<?php
$play_method = $ds_data[$i]['play_type'];
$typename = $ds_data[$i]['typename'];
$rate = $ds_data[$i]['rate'];
$allprice = $ds_data[$i]['money'];
$total_price += $allprice;
if ($play_method == 1)
{
?>
<th>让球数</th>
<?php
}
?>
<th>比分</th>
<th>赛果</th>
<th>您的选择</th>
<th class="last_th">胆码</th>

</tr>
<?php
$match_info = $ds_data[$i]['match_info'];
$match_code = explode('/', $ds_data[$i]['code']);
//var_dump($ds_data[$i]['code']);
for ($j = 0; $j < count($match_info); $j++) {
	$match_detail = $match_info[$j]['info'];
	$match_select = $match_info[$j]['result'];
	if ($match_info[$j]['info']['result'] != NULL) {
		$match_result = explode('|', $match_info[$j]['info']['result']);
	}
	$match_result_str = '';
	if(isset($odds[$match_code[$j]])) {
		$odd = $odds[$match_code[$j]];
	}
?>
<tr class="tr1" mid="<?php echo $match_detail['id'];?>">
<td><?php echo $match_detail['match_info'];?></td>
<td><?php echo $match_detail['host_name'];?> VS <?php echo $match_detail['guest_name'];?></td>
<?php
if ($play_method == 1)
{
?>
<td><?php echo intval($match_detail['goalline']);?></td>
<?php
}
?>
<td style="width:8%"><?php if (isset($match_result)) echo $match_result[1]; ?></td>
<td style="width:7%">
<?php
if ($detail['play_method'] == 1 && isset($match_result[0])) $match_result_str = $match_result[0]; 
elseif ($detail['play_method'] == 2 && isset($match_result[2])) $match_result_str = $match_result[2]; 
elseif ($detail['play_method'] == 3 && isset($match_result[1])) $match_result_str = $match_result[1]; 
elseif ($detail['play_method'] == 4 && isset($match_result[3])) $match_result_str = $match_result[3];
echo $match_result_str;  
?>
</td>
<td style="width:200px;word-wrap: break-word;" ><?php if ($match_select == $match_result_str) echo '<span style="color:red">'.$match_select.'('.$odd.')</span>';else echo $match_select.'('.$odd.')';?></td>
<td class="last_td">×</td>
</tr>
<?php
	}
?>
<tr class="last_tr">
<td colspan="7">
<span class="red" style="display:none">注：单关投注奖金以官方最终公布的奖金为准。</span>
<span class="red">注：过关投注奖金以方案最终出票时刻的奖金为准。</span>
</td>
</tr>
</tbody>
</table>
</div>
</div>

<div class="aff_r">
<div class="tdbback">
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="tablelay eng">
<tbody>
<tr>
<th class="last_th" colspan="2"></th>
</tr>
<tr class="tr1">
<td width="50%">过关方式</td>
<td class="last_td">倍数</td>
</tr>
<tr class="tr1">
<td><?php echo $typename;?></td>
<td class="last_td"><?php echo $rate;?></td>
</tr>
<tr class="last_tr">
<td colspan="2" class="last_td">
<p class="aff_zjr">
总金额：<span class="red">￥<?php echo $allprice;?></span> 元<br />
</p>
</td>
</tr>
</tbody>
</table>
</div>
</div>
<?php
}
?>
</div>
</td>
</tr>
<?php
} 
?>

<form name="project_form" action="" method="post">
<?php
if ($is_open)
{
?>
<tr>
<td class="td_title2">我要认购</td>
<td class="con_content">         
<div class="buy_btn">
<a id="submitCaseBtn3" href="javascript:void 0" class="btn_buy_m" title="立即购买">立即购买</a>
</div>
<p><span id="userMoneyInfo">您尚未登录，请先<a href="javascript:void 0" title="" onclick="Yobj.postMsg('msg_login')">登录</a>！</span><br />
还可以认购 <span class="red eng"><?php echo ($detail['zhushu']-$detail['buyed']);?></span> 份，我要认购
<input name="buynum" id="buynum" type="text" class="mul" maxlength="6" value="1" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onkeydown="if(event.keyCode==13){checkForm();return false;}"/>
份 总金额<span class="red eng">￥</span><span class="red eng" id="permoney">1.00</span>元</p>							
<p class="read"><span class="hide_sp"><input type="checkbox" checked="checked" id="agreement" value="1"/></span>我已阅读并同意《<a href="javascript:;" onclick="Y.openUrl('/doc/webdoc/gmxy',505,426)">用户合买代购协议</a>》</p>
<input type="hidden" value="1" id="agreement2"/>
</td>
</tr>
<?php
}
?>
<input name="isend" id="isend" type='hidden'  value="<?php if((time() - strtotime($detail['time_end'])) > 0){echo 0;}else{echo 1;}?>">
<input name="isend" id="isjprizesuc" type='hidden'  value="<?php if((time() - strtotime($detail['time_end'])) > 0){echo 0;}else{echo 1;}?>">
<input name="pregetmoney" id="pregetmoney" type='hidden'  value="<?php echo $detail['bonus']?>">
<input name="anumber" id="anumber" type='hidden'  value="<?php echo $detail['zhushu']?>">
<input name="order_num" id="lotid" type="hidden" value="<?php echo $detail['basic_id']?>">
<input name="user_id" id="user_id" type="hidden" value="<?php echo $_user['id']?>">
<input name="fuser_id" id="fuser_id" type="hidden" value="<?php echo $detail['user_id']?>">
<input name="lottyid" id="lottyid" type="hidden" value="1">
<!--彩种Id-->
<input name="playid" id="playid" type="hidden" value="<?php echo $detail['play_method'];?>">
<!--玩法Id-->
<input name="expect" id="expect" type="hidden" value="">
<!--期号-->
<input name="pid" id="pid" type="hidden" value="<?php echo $detail['id']?>">
<!--彩种Id-->
<input name="senumber" id="senumber" type="hidden" value="<?php echo ($detail['zhushu']-$detail['buyed'])?>">
<!--保底份数-->
<input name="onemoney" id="onemoney" type="hidden" value="<?php echo $detail['price_one']?>">
<!--每份金额-->
<input name="ishm" id="ishm" type='hidden'  value="1">
<!--是否是合买-->
<input name="care_username" id="main_username" type="hidden" value="<?php echo $user['lastname'];?>" />
<input name="buymumber" id="buymumber" type="hidden" value="<?php echo $detail['zhushu'];?>"><!--认购份数--> 	
<input name="reload" id="reload" type="hidden" value="1">
<input name="orderstr" id="orderstr" type="hidden" value="1">
<input name="orderby" id="orderby" type="hidden" value="desc">
</form>

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
							<p>
    <?php
    if ($detail['status']==5)
	{
		echo '方案税后奖金：';
		echo '<span class="eng red">￥'.$detail['bonus'].'</span>元';
	}
	else
	{
		echo '方案最高奖金：';
		echo '<span class="eng red">￥'.$detail['bonus_max'].'</span>元';						
	}
	
	if ($detail['status']==4 || $detail['status']==5)
	{
		echo '&nbsp;&nbsp;&nbsp;&nbsp;<span style="cursor:pointer" onClick="Y.openUrl(\''.url::base().'jczq/bonus_info/'.$detail['basic_id'].'\',700,414)"><font color="#FF6600"><u>查看奖金明细</u></font></span>';	
	}	
	?>
     </p>
     <?php 
     $plan_basic_obj = Plans_basicService::get_instance();
     $userid = $user['id'];
     if ($plan_basic_obj->is_cancel_plan($detail['basic_id'], $userid) == true) {
     	echo '<a href="/jczq/cancel_plan/'.$detail['basic_id'].'">我要撤单</a>';
     }
     ?>
     					 </td>
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
                            <?php /**?>
							<div class="add_div">
								<span class="shouc_box"><span class="ttitle">分享至：</span><span class="d10 bwidth1"><a class="ushare_button_renren" href="javascript:void 0;" title="分享... "><span style="cursor: pointer;" class="jtico button jtico_renren">人人网</span></a></span><span class="d6 bwidth1"><a class="ushare_button_qzone" href="javascript:void 0;" title="分享... "><span style="cursor: pointer;" class="jtico button jtico_qzone">QQ空间</span></a></span><span class="d8 bwidth2"><a class="ushare_button_tsina" href="javascript:void 0;" title="分享... "><span style="cursor: pointer;" class="jtico button jtico_tsina">新浪微博</span></a></span><span class="more bwidth3"><a class="ushare" href="http://union.500wan.com/ushare/share.html" style="">更多</a></span></span>
								<script type="text/javascript" src="http://www.500wancache.com/public/js/public/core_jq.js"></script>
								<script charset="gbk" src="http://union.500wan.com/ushare/add.js" type="text/javascript"></script>
							</div>
							<?php **/?>
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
						<div class="yh_tab">
							<ul class="clearfix">
								<li id="joinCount" class="" onclick="javascript:Showan(1,2);">总参与人数<span id="totalCount"></span>人</li>
								<li id="meyBuy" class="an_cur" onclick="javascript:Showan(2,2);">您的认购记录</li>
							</ul>
						</div>
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
<?php echo View::factory('login')->render();?>
<div class="notifyicon tip-2">
  <div class="notifyicon_content"></div>
  <div class="notifyicon_arrow"><s></s><em></em></div>
  <div class="notifyicon_space"></div>
</div>
</body>
</html>
