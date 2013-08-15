<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-会员中心-身份实名认证</title>
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
	if (isset($error) && $error != false) {
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
&gt;&gt; 身份实名认证</div>
<!--面包屑导航_end-->
<!--content1-->
<div class="width">
<?php
echo View::factory ( 'user/left' )->render ();
?>
<div class="member_right fl">
<div id="recharge" class="fl">
<ul>
	<li class="hover">身份实名认证</li>
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
         		<?php if (isset($error) && $error != false) echo $error;?>
		    </div>
		    <div class="tips_sbt" style="overflow-y:auto;padding-left:150px;">
				<span class="xg_gg_bf fhxgai">关闭</span>
            </div>
	    </div>
   </div>
</div>
    <?php  print form::open ( 'user/user_auth', array ('name' => 'formedit', 'id' => 'formedit' ) );?>
    
<table width="753" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height="28" bgcolor="#faeee0" class="profile_bottom">&nbsp;</td>
		<td height="28" colspan="4" bgcolor="#faeee0" class="font14 profile_bottom orange"><strong>实名绑定非常重要请尽快填写，这将影响您的取款等操作！
		<?php
		if ($userinfo['is_auth'] == 2 && $userinfo['check_status'] != 2 && date('Y-m-d H:i:s') >= '2011-12-07 19:00:00' && date('Y-m-d H:i:s') <= '2011-12-07 21:00:00' && true) { 
		?>
		<a href="<?php echo url::base();?>user/check_mobi_email">快去充值领取彩金吧！</a>
		<?php 
		}
		?>
		</strong></td>
	</tr>
	<tr>
		<td height="15" colspan="5"></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td height="30" align="right" valign="middle"><span class="orange">*</span><span
			class="black"> 真实姓名：</span></td>
		<td width="1%" height="30" align="left" valign="middle">&nbsp;</td>
		<td width="27%" align="left" valign="middle">
        <?php
        if (!empty($userinfo['real_name']) && $userinfo['is_auth'] == 2)
		{
			echo tool::cut_str($userinfo['real_name'], 1);
		}
		else
		{
			print form::input('real_name', $userinfo['real_name'], 'class="huiyuan_text_box" datatype="*"  nullmsg="请填写真实姓名！" ');
		}
		
		?>
		</td>
		<td ><div class="Validform_checktip"></div></td>
	</tr>
	<tr>
		<td width="2%">&nbsp;</td>
		<td width="13%" height="30" align="right" valign="middle"><span
			class="orange">*</span><span class="black"> 身份证：</span></td>
		<td height="30" align="left" valign="middle">&nbsp;</td>
		<td height="30" align="left" valign="middle">
        
        <?php
         if (!empty($userinfo['identity_card']) && $userinfo['is_auth'] == 2)
		 {
			 echo substr($userinfo['identity_card'], 0, 5).'.....'.substr($userinfo['identity_card'], -3, 3);
		 }
		 else
		 {
			print form::input('identity_card', $userinfo['identity_card'], 'class="huiyuan_text_box" datatype="*10-18" nullmsg="请填写您的证件号！" errormsg="错误的身份证号码"');	 
		 }
		?>        		
		</td>
	    <td ><div class="Validform_checktip"></div></td>
	</tr>
    <tr>
		<td height="30" colspan="5"><span class="red">* 注意：非常重要。用户身份认证的有效凭证，请如实填写。设置后不可修改!</span></td>
	</tr>
	<tr>
		<td height="30" colspan="5"><span class="red"><a href="/user/profile">继续完善个人资料</a></span></td>
	</tr>
	<tr>
		<td height="30" colspan="5">&nbsp;</td>
	</tr>
	<?php
	if ($userinfo['is_auth'] != 2) { 
	?>
	<tr>
		<td width="2%">&nbsp;</td>
		<td width="13%" height="30" align="right" valign="middle">&nbsp;</td>
		<td height="30" align="left" valign="middle"></td>
		<td height="30" align="left" valign="middle">
		<input type='submit' value='确认修改' class="xg_gg_bf fhxgai" style=" margin:0"/>
		</td>
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