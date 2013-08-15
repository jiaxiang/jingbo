<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-用户注册</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" /><?php
echo html::script(array
(   
    'media/js/jquery.js',
 	'media/js/jquery.validate.js',
	'media/js/register.js',
), FALSE);
echo html::stylesheet(array
(
 	'media/css/style.css',
	'media/css/user-new.css',
	'media/css/alert.css',
	'media/css/extension.css',
), FALSE);
?>
<script language="javascript">
var flag = 0;
function reload_secoder(id,url){
    flag++;
    $('#'+id).attr("src","<?php echo url::base();?>site/secoder_cn_regisiter/"+id+"/"+flag);
}
</script>
</head>
<body>
<?php echo View::factory('header')->render();?>
<!--menu和列表_end-->
<!--注册-->
<div class="width" >
	<p id="up_title" class="fl">
	<span class="fr">已有<?php echo $site_config['site_title'];?>帐号？<font class="blue">
		<a href="<?php echo url::base();?>user/login" style="text-decoration:underline;">点此登录</a></font></span>
	<span class="font16 bold">会员注册</span>
	</p>
<form class="form_list" id="register_form" name="register_form" method="post" action="" >
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl" >
  <tr>
    <td width="18%" height="44">&nbsp;</td>
    <td width="0%">&nbsp;</td>
    <td colspan="2">&nbsp;  
    <?php 
    //d($remind_data, false);
	if(!empty($error))
	{
	?>
    <div class="err_message"><p><?php echo $error;?></p></div> 
    <?php 
	}
	?>
	<?php 
    //d($remind_data, false);
	if($remind_data != null && isset($remind_data['error'][0])) {
	?>
    <div class="err_message"><p><?php echo $remind_data['error'][0];?></p></div> 
    <?php 
	}
	?>
    </td>
    <td width="55%">&nbsp;</td>
  </tr>
  
  <tr>
    <td height="26" align="right" valign="middle" class="font14"><span class="red">*</span><span class="black pl10">会员名：</span></td>
    <td height="26" valign="middle">&nbsp;</td>
    <td height="26" colspan="2" valign="middle"><input type="text" name="lastname" id="lastname" class="up_text normal" value="<?php if(!empty($post['lastname'])) echo $post['lastname']; ?>" /></td>
    <td height="26" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" valign="middle">&nbsp;</td>
    <td>&nbsp;</td>
    <td height="34" colspan="2" valign="top" class="graybc">登录<?php echo $site_config['site_title'];?>账号，例如：Emma</td>
    <td>&nbsp;</td>
  </tr>
  
  
  <tr>
    <td height="26" align="right" valign="middle" class="font14"><span class="red">*</span><span class="black pl10">邮箱：</span></td>
    <td height="26" valign="middle">&nbsp;</td>
    <td height="26" colspan="2" valign="middle"><input type="text" name="email" id="email" class="up_text" value="<?php if(!empty($post['email'])) echo $post['email']; ?>" /><span ></span></td>
    <td height="26" valign="middle"><div class="up_tis" id="email_err">&nbsp;</div></td>
  </tr>
  <tr>
    <td align="right" valign="middle">&nbsp;</td>
    <td>&nbsp;</td>
    <td height="34" colspan="2" valign="top" class="graybc">也可以用邮箱，不会被公开</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="26" align="right" valign="middle" class="font14"><span class="red">*</span><span class="black pl10">登录密码：</span></td>
    <td height="26" valign="middle">&nbsp;</td>
    <td height="26" colspan="2" valign="middle"><input type="password" name="password" id="password" class="up_text"  value="<?php if(!empty($post['password'])) echo $post['password']; ?>" /><span ></span></td>
    <td height="26" valign="middle"><div class="up_tis" id="password_err">&nbsp;</div></td>
  </tr>
  <tr>
    <td align="right" valign="middle">&nbsp;</td>
    <td>&nbsp;</td>
    <td height="34" colspan="2" valign="top" class="graybc">密码必须是6-12位字符</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="26" align="right" valign="middle" class="font14"><span class="red">*</span><span class="black pl10">确认密码：</span></td>
    <td height="26" valign="middle">&nbsp;</td>
    <td height="26" colspan="2" valign="middle"><input type="password" name="password_confirm" id="password_confirm" class="up_text"  value="<?php if(!empty($post['password_confirm'])) echo $post['password_confirm']; ?>" /><span ></span></td>
    <td height="26" valign="middle"><div class="up_tis" id="password_confirm_err">&nbsp;</div></td>
  </tr>
 <tr>
    <td align="right" valign="middle">&nbsp;</td>
    <td>&nbsp;</td>
    <td height="34" colspan="2" valign="top" class="graybc">密码必须是6-12位字符</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="26" align="right" valign="middle" class="font14"><span class="red">*</span><span class="black pl10">验证码：</span></td>
    <td height="26" valign="middle">&nbsp;</td>
    <td height="26" colspan="2" valign="middle">
    <?php
    include_once WEBROOT.'application/libraries/recaptchalib.php';
    $publickey = "6Lfq09sSAAAAAA2U9H0eoJ307vmcxUZFlMdOEUqs"; // you got this from the signup page
    echo recaptcha_get_html($publickey);
    ?>
    <!--  input type="text" name="secode" maxlength="6"  id="secode" class="up_text fl" style="width:90px;" />
    <img alt="验证码" src="<?php echo url::base();?>site/secoder_cn_regisiter/reg_secoder" id='reg_secoder' onclick="reload_secoder('reg_secoder');" /--> 
    <span ></span>
    <!-- span onclick="reload_secoder('reg_secoder');" style="cursor:pointer;" class="fl pl10">看不清楚？<font class="blue">换一张</font></span--></td>
    <td height="26" valign="middle"><div class="up_tis" id="secode_err">&nbsp;</div></td>
  </tr>
  <tr>
    <td align="right" valign="middle">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right" valign="middle">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">
    <input name="sub" src="<?php echo url::base();?>media/images/btn4.gif" type="image" width="177" height="31" id="subfrm"/>
    </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="31" align="right" valign="middle">&nbsp;</td>
    <td>&nbsp;</td>
    <td width="2%" align="left" valign="middle"><input name="year18" id="year18"  type="checkbox"  checked="checked" /></td>
    <td width="25%" height="50" align="left" valign="middle">我已经年满18岁并同意<span class="blue"><a href="/doc/doc_detail/82" target="_blank">《<?php echo $site_config['site_title'];?>服务条款》</a></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="30" align="right" valign="middle">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2"><p>&nbsp;</p></td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
	<div style="clear:both;"></div>
   
</div>
<!--注册-->
<!--copyright-->
<div >
<?php echo View::factory('footer')->render();?>
</div>
<!--copyright_end-->
</body>
</html>
