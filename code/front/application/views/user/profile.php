<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-会员中心-修改个人资料</title>
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
		<?php if($_ok==2){?>
			$(".paly_pop_ok").show();	
		<?php }?>
})

</script>
</head>
<body>
<!--top小目录-->
<?php
echo View::factory ( 'header' )->render ();
?>
<!--menu和列表_end-->
<!--面包屑导航-->
<div class="width line36">您所在的位置：<span class="blue"><a href="<?php echo url::base ();?>">首页</a></span> &gt;&gt; <span class="blue"><a href="<?php echo url::base ();?>user">会员中心</a></span> &gt;&gt; <span class="blue">个人信息管理</span>
&gt;&gt; 修改个人资料</div>
<!--面包屑导航_end-->
<!--content1-->
<div class="width">
 <?php
	echo View::factory ( 'user/left' )->render ();
	?>
  <div class="member_right fl">
<div id="recharge" class="fl">
<ul>
	<li class="hover">修改个人资料</li>
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
         		您的资料已成功更新!
		    </div>
		    <div class="tips_sbt" style="overflow-y:auto;padding-left:150px;">
				<span class="xg_gg_bf fhxgai">关闭</span>
            </div>
	    </div>
   </div>
</div>



    <?php  print form::open ( 'user/profile', array ('name' => 'formedit', 'id' => 'formedit' ) );?>
    <table width="753" border="0" cellspacing="0" cellpadding="0">
    <tr>
		<td height="28" bgcolor="#faeee0" class="profile_bottom">&nbsp;</td>
		<td height="28" colspan="4" bgcolor="#faeee0"
			class="font14 profile_bottom orange"><strong>为了最大限度保障您的账户安全，请如实填写以下信息</strong></td>
	</tr>
	<?php
	if (isset($notice) && $notice != '') { 
	?>
	<tr>
		<td height="42"></td>
		<td height="42" colspan="4" class="font14 bold blue"><?php print_r($notice);?></td>
	</tr>
	<?php
	} 
	?>
	<tr>
		<td height="5" colspan="5"></td>
	</tr>
    <tr>
		<td width="2%">&nbsp;</td>
		<td width="13%" height="30" align="right" valign="middle"><span
			class="orange">*</span><span class="black"> 用户名：</span></td>
		<td width="1%" height="30" align="left" valign="middle">&nbsp;</td>
		<td width="27%" align="left" valign="middle">
		<label><?php echo $userinfo['lastname'];?></label>
		</td>
		<td ><div class="Validform_checktip"></div></td>
	</tr>
	<tr>
		<td width="2%">&nbsp;</td>
		<td width="13%" height="30" align="right" valign="middle"><span
			class="orange">*</span><span class="black"> E-mail：</span></td>
		<td width="1%" height="30" align="left" valign="middle">&nbsp;</td>
		<td width="27%" align="left" valign="middle">
        <?php if($error['email']){?>
             <input type="hidden" name="error_email" value="<?php echo $_POST['email'];?>" />
             <?php print form::input('email', $_POST['email'], ' class="huiyuan_text_box Validform_error" datatype="e" recheckno="error_email" nullmsg="请输入您常用的邮箱！" errormsg="请输入您常用的邮箱！" errormsg_recheckno="邮箱已被其它用户使用，请更换邮箱再试！"' );?>
		  	</td>
			<td ><div class="Validform_checktip Validform_wrong"><?php if($error['email']){echo '邮箱已被其它用户使用，请更换邮箱再试！';}?></div></td>
        <?php }else{ ?>
			<?php print form::input('email', $userinfo['email'], ' class="huiyuan_text_box" datatype="e" nullmsg="请输入您常用的邮箱！" errormsg="请输入您常用的邮箱！"');?>
			</td>
			<td ><div class="Validform_checktip"></div></td>
        <?php }?>
		
	</tr>
	<tr>
		<td height="20" colspan="4"></td>
	</tr>
</table>
<table width="753" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height="28" bgcolor="#faeee0" class="profile_bottom">&nbsp;</td>
		<td height="28" colspan="4" bgcolor="#faeee0"
			class="font14 profile_bottom orange"><strong>其他信息建议填写这将帮助我们第一时间与您本人取得联系</strong></td>
	</tr>
	<tr>
		<td height="15" colspan="5"></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td height="30" align="right" valign="middle"><span
			class="black">出生日期：</span></td>
		<td width="1%" height="30" align="left" valign="middle">&nbsp;</td>
		<td width="27%" align="left" valign="middle">
		<?php print form::input('birthday', $userinfo['birthday'], ' size="10" maxlength="10" readonly="true" onFocus="WdatePicker()" class="huiyuan_text_box" ');?>
		</td>
	    <td ><div class="Validform_checktip"></div></td>
	</tr>
	<tr>
		<td width="2%">&nbsp;</td>
		<td width="13%" height="30" align="right" valign="middle"><span class="black"> 性别：</span></td>
		<td height="30" align="left" valign="middle">&nbsp;</td>
		<td height="30" align="left" valign="middle">
		<?php print form::label('sex', '男');?>
		<?php print form::radio('sex','1',$userinfo['sex']);?>
		<?php print form::label('sex', '女');?>
		<?php print form::radio('sex','0',!$userinfo['sex']);?>
		</td>
		<td ><div class="Validform_checktip"></div></td>
	</tr>
	<tr>
		<td width="2%">&nbsp;</td>
		<td width="13%" height="30" align="right" valign="middle"><span class="black">通信地址：</span></td>
		<td height="30" align="left" valign="middle">&nbsp;</td>
		<td height="30" align="left" valign="middle">
		<?php print form::input('address', $userinfo['address'], ' maxlength = "100" class="huiyuan_text_box"');?>
		</td>
		<td ><div class="Validform_checktip"></div></td>
	</tr>
	<tr>
		<td width="2%">&nbsp;</td>
		<td width="13%" height="30" align="right" valign="middle"><span class="black">邮编：</span></td>
		<td height="30" align="left" valign="middle">&nbsp;</td>
		<td height="30" align="left" valign="middle">
		<?php print form::input('zip_code', $userinfo['zip_code'], ' maxlength = "6" class="huiyuan_text_box"');?>
		</td>
		<td ><div class="Validform_checktip"></div></td>
	</tr>
	<tr>
		<td width="2%">&nbsp;</td>
		<td width="13%" height="30" align="right" valign="middle"><span class="black"> 固定电话：</span></td>
		<td height="30" align="left" valign="middle">&nbsp;</td>
		<td height="30" align="left" valign="middle">
		<?php print form::input('tel', $userinfo['tel'], 'class="huiyuan_text_box"');?>
		</td>
		<td ><div class="Validform_checktip"></div></td>
	</tr>
    <tr>
		<td width="2%">&nbsp;</td>
		<td width="13%" height="30" align="right" valign="middle"><span class="black">手机号码：</span></td>
		<td height="30" align="left" valign="middle">&nbsp;</td>
		<td height="30" align="left" valign="middle">
		<?php print form::input('mobile', $userinfo['mobile'], 'class="huiyuan_text_box"  maxlength = "11"');?>
		</td>
		<td ><div class="Validform_checktip"></div></td>
	</tr>
	<tr>
		<td height="5" colspan="5"></td>
	</tr>
	<tr>
		<td width="2%">&nbsp;</td>
		<td width="13%" height="30" align="right" valign="middle">&nbsp;</td>
		<td height="30" align="left" valign="middle"></td>
		<td height="30" align="left" valign="middle">
		<input type='submit' value='确认修改' class="xg_gg_bf fhxgai" style=" margin:0"/>
		</td>
	</tr>
</table>
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
