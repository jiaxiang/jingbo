<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-会员中心-代理服务-即时结算报表详细</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<?php
echo html::script(array
(
 	'media/js/jquery',
    'media/js/hdm',
	'media/js/tk',
	'media/js/My97DatePicker/WdatePicker',
), FALSE);
echo html::stylesheet(array
(
 	'media/css/style',
	'media/css/szc',
	'media/css/mask',
), FALSE);	
?>
<script language="javascript">
</script>
</head>
<body>
<!--top小目录-->
<?php echo View::factory('header')->render();?>
<!--menu和列表_end-->
<!--面包屑导航-->
<div class="width line36">
	您所在的位置：
	<span class="blue"><a href="<?php echo url::base();?>">首页</a></span> &gt;&gt; 
	<span class="blue"><a href="<?php echo url::base();?>user">会员中心</a></span> &gt;&gt; 
	<span class="blue"><a href="#">代理服务</a></span> &gt;&gt; 即时结算报表详细
</div>
<!--面包屑导航_end-->

<!--content1-->
<div class="width">
	<?php echo View::factory('user/left')->render();?>
	
	<div class="member_right fl" style="position:relative">
		<?php //弹出窗口?>
		<div class="paly_pop_ok" style="top:40px; left:120px;">
		<div class="tips_b">
			<div class="tips_box">
				<div class="tips_title">
				<h2>温馨提示</h2>
				<span class="close"><a href="/user/login">关闭</a></span>
				</div>
				<div class="tips_text" style="overflow-y:auto; line-height:30px;"></div>
				<div class="tips_sbt" style="overflow-y:auto; padding-left:30px;">
					<a class="xg_gg_bf fhxgai" href="/user/login">重新登陆</a>
				</div>
			</div>
		</div>
		</div>

<!-- Content Core Start -->
	<div class="member_right fl">
		<div id="member_tit" class="fl">
			<ul>
				<li class="hover">即时结算报表详细</li>
			</ul>
		</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl" style="border-left: solid 1px #c5ddf5; border-right: solid 1px #c5ddf5;">
      <form action="?" method="GET" name="search_form" id="search_form">
      <tr>
        <td width="5%" height="33" align="center" valign="middle" bgcolor="#e8f2ff">&nbsp;</td>
        <td width="5%" align="center" valign="middle" bgcolor="#e8f2ff">时间</td>
        <td width="10%" align="left" valign="middle" bgcolor="#e8f2ff"><input name="begintime" id="begintime" onFocus="WdatePicker({maxDate:'#F{$dp.$D(\'endtime\')||\'2030-10-01\'}'})" type="text" class="hasDatepicker" value="<?php echo !empty($pre_get['begintime']) ? $pre_get['begintime'] : ''; ?>"  style="width:100px;" /></td>
        <td width="5%" align="center" valign="middle" bgcolor="#e8f2ff">至</td>
        <td width="10%" valign="middle" bgcolor="#e8f2ff"><input name="endtime" id="endtime" onFocus="WdatePicker({minDate:'#F{$dp.$D(\'begintime\')}',maxDate:'2030-10-01'})" type="text" value="<?php echo !empty($pre_get['endtime']) ? $pre_get['endtime'] : '';?>"  style="width:100px;" /></td>
        <td width="5%" align="center" valign="middle" bgcolor="#e8f2ff"></td>
        <td width="40%" valign="middle" bgcolor="#e8f2ff"></td>
        <td width="10%" align="center" valign="middle" bgcolor="#e8f2ff"></td>
        <td width="10%" align="left" valign="middle" bgcolor="#e8f2ff"><div class="orange_btn fl white"><span><a href="#" onclick="javascript:document.getElementById('search_form').submit()">查询</a></span></div></td>
      </tr>
      </form>
      <tr>
            <td height="1" colspan="6"  align="left" valign="middle" bgcolor="#ffffff"></td>
      </tr>
    </table>
    
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl member_box" 
			style="border:solid 1px #c5ddf5; border-bottom:0;">
			<tr height="33">
				<td width="10%" align="center" valign="middle" bgcolor="#f3f3f3">结算时间</td>
				<!-- 
				<td width="10%" align="center" valign="middle" bgcolor="#f3f3f3">合约号</td>
				 -->
				<td width="10%" align="center" valign="middle" bgcolor="#f3f3f3">客户</td>
				<td width="10%" align="center" valign="middle" bgcolor="#f3f3f3">彩种</td>
				<td width="10%" align="center" valign="middle" bgcolor="#f3f3f3">订单金额</td>
				<td width="05%" align="center" valign="middle" bgcolor="#f3f3f3">下家返点</td>
				<!-- 
				<td width="15%" align="center" valign="middle" bgcolor="#f3f3f3">订单号</td>
				<td width="05%" align="center" valign="middle" bgcolor="#f3f3f3">返点率</td>
				<td width="05%" align="center" valign="middle" bgcolor="#f3f3f3">状态</td>
				 -->
			</tr>
		</table>
		<?php if (is_array($dataList) && count($dataList)) {?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl member_box">
			<?php foreach ($dataList as $stlDtl) { ?>
			<tr height="33">
				<td width="10%" align="center" valign="middle"><?php echo $stlDtl['settletime'];?>&nbsp;</td>
				<!-- 
				<td width="10%" align="center" valign="middle"><?php echo $stlDtl['rcid'];?>&nbsp;</td>
				 -->
				<td width="10%" align="center" valign="middle"><?php echo $stlDtl['lastnameMark'];?><a href='/distribution/settle_realtime_dtl/qry/<?php echo $stlDtl['user_id'];?>' style="color:red">[查看该用户]</a>&nbsp;</td>
				<td width="10%" align="center" valign="middle"><?php echo $stlDtl['ticket_type'];?>&nbsp;</td>
				<td width="10%" align="center" valign="middle">￥<?php echo $stlDtl['fromamt'];?>&nbsp;</td>
				<td width="05%" align="center" valign="middle"><?php echo $stlDtl['client_retamt'];?>&nbsp;</td>
				<!-- 
				<td width="15%" align="center" valign="middle"><?php //echo $stlDtl['order_num'];?>&nbsp;</td>
				<td width="05%" align="center" valign="middle"><?php //echo $stlDtl['rate'];?>&nbsp;</td>
				<td width="05%" align="center" valign="middle"><?php //echo $stlDtl['flag'];?>&nbsp;</td>
				 -->
			</tr>
			<?php };?>
		</table>
		<?php }else {?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl member_box">
			<tr><td height="33" align="left" valign="middle" style="padding-left:20xp;">&nbsp;没有相应的记录&nbsp;</td></tr>
		</table>
		<?php }?>
            
		<div class="recharge_box fl" style="padding-top:5px;">
			<div class="manu mt15">
				<?PHP  echo $this->pagination->render('page_html');?>
	        </div>
		</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl" 
    	style="border-left: solid 0px #c5ddf5; border-right: solid 0px #c5ddf5;border-bottom: solid 1px #c5ddf5;">
      <form action="?" method="get" name="search_form" id="search_form">
      <tr>
        <td width="5%" height="33" align="center" valign="middle" bgcolor="#e8f2ff">&nbsp;</td>
        <td width="12%" height="33" align="center" valign="middle" bgcolor="#e8f2ff">本次查询返点合计</td>
        <td width="20%" height="33" align="center" valign="middle" bgcolor="#e8f2ff"><?php echo $clientretsum; ?></td>
        <td width="63%" height="33" align="center" valign="middle" bgcolor="#e8f2ff"
        style="border-right: solid 1px #c5ddf5;"
        >&nbsp;</td>
      </tr>
      <tr>
            <td height="1" colspan="6"  align="left" valign="middle" bgcolor="#ffffff"></td>
      </tr>
      </form>
    </table>
	</div>
<!-- Content Core End -->
	</div>
</div>
<!--content1_end-->

<!--copyright-->
<span class="zhangkai"></span>
<?php echo View::factory('footer')->render();?>
<!--copyright_end-->
</body>
</html>