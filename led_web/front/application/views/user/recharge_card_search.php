<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-会员中心-点卡查询</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<?php
echo html::script(array
(
 	'media/js/jquery',
    'media/js/Validform',
	'media/js/My97DatePicker/WdatePicker',
	'media/js/tk',
), FALSE);
echo html::stylesheet(array
(
 	'media/css/style',
	'media/css/alert.css',
	'media/css/validate.css',
    'media/css/public.css',
	'media/css/szc',
	'media/css/mask',
), FALSE);
?>
<script type="text/javascript">
$(function(){
	$("#formedit").Validform({
	  tiptype:2
	});
	<?php
	if (isset($result) && !is_array($result)) {
		echo '$(".paly_pop_ok").show();';
	} 
	?>
})
</script>
<style>
.profile_box {height:400px;}
</style>
</head>
<body>
<!--top小目录-->
<?php
echo View::factory ( 'header' )->render ();
?>
<!--menu和列表_end-->
<!--面包屑导航-->
<div class="width line36">您所在的位置：<span class="blue"><a href="<?php echo url::base ();?>">首页</a></span> &gt;&gt; <span class="blue"><a href="<?php echo url::base ();?>user">会员中心</a></span> &gt;&gt; <span class="blue">个人信息管理</span>
&gt;&gt; 点卡查询</div>
<!--面包屑导航_end-->
<!--content1-->
<div class="width">
<?php
echo View::factory ( 'user/left' )->render ();
?>
<div class="member_right fl">
<div id="recharge" class="fl">
<ul>
<li><a href="<?php echo url::base();?>user_recharge_card/recharge">点卡充值</a></li>
<li><a href="<?php echo url::base();?>user_recharge_card/change">点数兑换</a></li>
<li class="hover">点卡查询</li>
</ul>
</div>
<div class="profile_box fl" style="position:relative">
<div class="paly_pop_ok" style="top:100px; left:120px;">
	<div class="tips_b">
        <div class="tips_box">
            <div class="tips_title">
            <h2>温馨提示</h2>
            <span class="close"><a href="javascript:void(0)">关闭</a></span>
            </div>
            <div class="tips_text" style="overflow-y:auto; line-height:30px;">
         		<?php 
         		if (isset($result) && !is_array($result)) echo $result;
         		?>
		    </div>
		    <div class="tips_sbt" style="overflow-y:auto;padding-left:150px;">
				<span class="xg_gg_bf fhxgai">关闭</span>
            </div>
	    </div>
   </div>
</div>
    <?php  print form::open ( 'user_recharge_card/search', array ('name' => 'formedit', 'id' => 'formedit' ) );?>
<table width="753" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height="28" bgcolor="#faeee0" class="profile_bottom">&nbsp;</td>
		<td height="28" colspan="4" bgcolor="#faeee0" class="font14 profile_bottom orange"><strong>请输入卡片上的管理号！</strong></td>
	</tr>
	<tr>
		<td height="15" colspan="5"></td>
	</tr>
	<tr>
		<td width="2%">&nbsp;</td>
		<td width="13%" height="30" align="right" valign="middle"><span class="black">管理号：</span></td>
		<td height="30" align="left" valign="middle">&nbsp;</td>
		<td height="30" align="left" valign="middle">
        <?php
			print form::input('card_id', '', 'class="huiyuan_text_box" datatype="" nullmsg="请填写管理号！" errormsg="管理号错误！"');	 
		?>        		
		</td>
	    <td ><div class="Validform_checktip"></div></td>
	</tr>
	<tr>
		<td height="30" colspan="5">&nbsp;</td>
	</tr>
	<tr>
		<td width="2%">&nbsp;</td>
		<td width="13%" height="30" align="right" valign="middle">&nbsp;</td>
		<td height="30" align="left" valign="middle"></td>
		<td height="30" align="left" valign="middle">
		<input type='submit' value='确认' class="xg_gg_bf fhxgai" style=" margin:0"/>
		</td>
	</tr>
	<?php
	if (isset($result) && is_array($result)) { 
	?>
	<tr>
		<td height="30" colspan="5">管理号：<?php echo $result['card_id'];?></td>
	</tr>
	<tr>
		<td height="30" colspan="5">密码：刮开见卡上</td>
	</tr>
	<tr>
		<td height="30" colspan="5">点数：<?php echo $result['value'];?>点</td>
	</tr>
	<tr>
		<td height="30" colspan="5">状态：<?php echo $result['status'];?></td>
	</tr>
	<tr>
		<td height="30" colspan="5">截至日期：<?php echo $result['expire'];?></td>
	</tr>
	<?php
	} 
	?>
</table>
<table width="753" border="0" cellspacing="0" cellpadding="0"></table>
<table width="753" border="0" cellspacing="0" cellpadding="0"></table>
<?php print form::close();?>
</div>
</div>
</div>
<!--content1_end-->
<!--copyright-->
<span class="zhangkai"></span>
<div id="alert_tip_content"></div>
<?php
echo View::factory ( 'footer' )->render ();
?>
<!--copyright_end-->
</body>
</html>