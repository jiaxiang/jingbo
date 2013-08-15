<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-用户注册</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<?php
echo html::script(array
(   
    'media/js/jquery.js',
 	'media/js/jquery.validate.js',

), FALSE);
echo html::stylesheet(array
(
 	'media/css/style',
	'media/css/user-new.css',
	'media/css/alert.css',
	'media/css/extension.css',
), FALSE);
?>
<script type="text/javascript">
 jQuery.validator.addMethod("passCheck", function(value, element) {      
     return this.optional(element) || /^[\x20-\x7f]+$/.test(value);      
  }, "密码请勿包含中文");  

$(document).ready(function(){
    $("#register_form").validate({
        errorClass: 'register_error',
		success: function(label) { 
			label.html("").removeClass("register_error").addClass("register_ok"); 
		},
        errorElement: "div",
        rules: {
		   focusCleanup: true,
           lastname:{
			  required: true,
			  maxlength:16,
			  minlength:4,
			  remote:'/user/ajax_checkname/'+$('#lastname').val()
		   },
		   email:{
			  required: true, 
			  email:true
		   },
		   password:{
			  required: true,   
			  maxlength:15,
			  minlength:6,
			  passCheck:true
		   },
		   password_confirm:{
			  required: true, 
			  equalTo:"#password"
		   },
		   secode:{
			   required: true,
			   remote:'/user/ajax_checkrancode/'+$('#secode').val()  
		   }
		   
		  
        },
        messages: {
			lastname:{
			  required:"请添写用户名！",
			  maxlength:'对不起，用户名长度请不要超过16个字符！',
			  minlength:'对不起，用户名长度至少应该为4个字符！',
			  remote:'用户名已存在，请重新输入'
			},
			email:{
			  required:"请添写邮箱！",
			  email:"对不起，请输入正确邮箱地址！"
			},
			password:{
			  required:'请输入密码！',   
			  maxlength:'您输入的密码超过15位，请换个密码',
			  minlength:'您输入的密码不足6位，请重新输入'
		   },
		   password_confirm:{
			  required:"请输入确认密码！", 
			  equalTo:"您两次输入的密码不一致，请重新输入！"
		   },
		   secode:{
			   required:"请输入验证码！",
			   remote:"验证码不正确，请重新输入"  
		   }    
        },
        errorPlacement: function(error, element){
            msg = element.parent().next();msg.html('');error.appendTo(msg);
        }
    });
    
   
});


</script>

</head>
<body>
<?php echo View::factory('header')->render();?>
<!--menu和列表_end-->
<!--注册-->
<div class="width">
	<p id="up_title" class="fl"><span class="fr">已有<?php echo $site_config['site_title'];?>帐号？<font class="blue"><a href="<?php echo url::base();?>user/login" style="text-decoration:underline;">点此登录</a></font></span><span class="font16 bold">会员注册</span></p>	

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl">
<form class="form_list" id="register_form" name="register_form" method="post" action="" >
  <tr>
    <td width="18%" height="44">&nbsp;</td>
    <td width="0%">&nbsp;</td>
    <td colspan="2">&nbsp;  
    <?php 
	if(!empty($error))
	{
	?>
    <div class="err_message"><p><?php echo $error;?></p></div> 
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
<?php if(empty($invitecode)){ ?>
  <tr>
    <td height="26" align="right" valign="middle" class="font14">
    	<span class="black pl10">邀请码：</span></td>
    <td height="26" valign="middle">&nbsp;</td>
    <td height="26" colspan="2" valign="middle">
    	<input type="text" name="invitecode" id="invitecode" class="up_text"  
    	value="<?php if(!empty($post['invitecode'])) echo $post['invitecode']; ?>" /><span >
    		</span></td>
    <td height="26" valign="middle"></td>
  </tr>
  <tr>
    <td align="right" valign="middle">&nbsp;</td>
    <td>&nbsp;</td>
    <td height="34" colspan="2" valign="top" class="graybc">邀请码</td>
    <td>&nbsp;</td>
  </tr>
<?php }; ?>
  
  <tr>
    <td height="26" align="right" valign="middle" class="font14"><span class="red">*</span><span class="black pl10">验证码：</span></td>
    <td height="26" valign="middle">&nbsp;</td>
    <td height="26" colspan="2" valign="middle">
    <input type="text" name="secode" maxlength="4"  id="secode" class="up_text fl" style="width:90px;" />
    <img  alt="验证码"  src="<?php echo url::base();?>site/secoder?id=reg_secoder" id='reg_secoder' /> 
    <span ></span>
    <span onClick="refreshVerify()" style="cursor:pointer;" class="fl pl10">看不清楚？<font class="blue">换一张</font></span></td>
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
  </form>
</table>
   
</div>
<!--注册-->
<!--copyright-->
<?php echo View::factory('footer')->render();?>
<!--copyright_end-->
</body>
</html>
