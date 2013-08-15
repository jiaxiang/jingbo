<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>卡卡拍</title>
<meta name="description" content="卡卡拍"/>
<meta name="keywords" content="竞拍、体验、商品、晒宝"/>
<link href="css/style.css" rel="stylesheet" type="text/css" />

<?php
echo html::script(array
(
    'media/js/jquery',
	'media/js/jquery.validate',
	'media/js/register',
), FALSE);
echo html::stylesheet(array
(
	'media/css/zc',
    'media/css/mask',
    'media/css/css1',
), FALSE);
?>
</head>
<body>
<?php //include('top.html');?>

<div class="width_box">
<p class="mt12"><img src="images/dl1.gif" /></p>	
<div id="login_left" class="fl">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="gray3">
  <form class="form_list" id="login_form" method="post" action="">
    <tr>
      <td height="15" colspan="4"></td>
      </tr>
    <tr>
      <td width="4%">&nbsp;</td>
      <td colspan="3" align="left" valign="middle" class="font14 bold" style="font-family:'微软雅黑'; color:#b0b0b0;">如果您已经是我们的会员，请通过如下表单登录</td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td width="22%" height="140">&nbsp;</td>
      <td colspan=2 class='error'>&nbsp;</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td height="30" align="right" valign="middle">邮箱：</td>
    <td width="2%" height="30" valign="middle">&nbsp;</td>
    <td width="72%" height="30" valign="middle"><input type="text" name="email" id="email" class="login_box"/><span></span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td height="30" align="right" valign="middle">密码：</td>
    <td height="30" valign="middle">&nbsp;</td>
    <td height="30" valign="middle"><input name="password" id="password" type="password" class="login_box"/><span></span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td height="30" align="right" valign="middle">验证码：</td>
    <td height="30" valign="middle">&nbsp;</td>
    <td height="30" valign="middle">
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="28%" align="left" valign="middle"><input type="text" name="secode" class="up_yzm" /><span></span></td>
        <td width="17%" align="left" valign="middle"><img src="/site/secoder?id=login_secoder" id='login_secoder' /></td>
        <td width="55%" align="left" valign="middle" class="gray"><span style="cursor:pointer;" onClick="reload_secoder('login_secoder');">看不清，换一张</span></td>
        </tr>
      </table>
      
      </td>
  </tr>  
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan=2 class='error'>&nbsp;<?php echo isset($login_error)?$login_error:''; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="30%" align="left" valign="middle">
          
          <input type='image' src="images/btn_login.gif"  />
          </td>
          <td width="70%" align="left" valign="middle"><a href="/find-password">忘记密码</a>？</td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    </form>
  </table>
</div>
<div id="login_right" class="fl">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="gray3">
<form class="form_list" id="register_form" method="post" action="<?php echo route::action('register').url::query_string();?>">
  <tr>
    <td height="15" colspan="4"></td>
    </tr>
  <tr>
    <td width="4%">&nbsp;<div style='display:none;'><?php remind::widget(); ?></div></td>
    <td colspan="3" align="left" valign="middle" class="font14 bold"  style="font-family:'微软雅黑'; color:#b0b0b0;">不是我们的会员？还不马上注册！</td>
    </tr> 
  <tr>
    <td>&nbsp;</td><td width="22%">&nbsp;</td><td colspan=2>&nbsp;&nbsp;&nbsp;&nbsp;<font color=red><?php echo isset($error)?$error:''; ?></font></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td height="30" align="right" valign="middle">Email地址：</td>
    <td width="2%" height="30" valign="middle">&nbsp;</td>
    <td width="72%" height="30" valign="middle"><input type="text" name="email"  id="email" value="<?php isset($user_reg) && print($user_reg['email']);?>" class="up_box"/><span></span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td height="30" align="right" valign="middle">&nbsp;</td>
    <td height="30" valign="middle">&nbsp;</td>
    <td height="30" align="left" valign="middle" class=" gray4">请填写有效的 Email，我们会给这个地址发送您的帐户信息、<br />
      订单通知等。
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td height="30" align="right" valign="middle">密码：</td>
    <td height="30" valign="middle">&nbsp;</td>
    <td height="30" valign="middle"><input type="password" name="password" id="passwordreg" value="<?php isset($user_reg) && print($user_reg['password']);?>" autocomplete='off' class="up_box"/><span></span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td height="30" align="right" valign="middle">&nbsp;</td>
    <td height="30" valign="middle">&nbsp;</td>
    <td height="30" valign="middle" class="gray4">密码请设为6-16位字母或数字</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td height="30" align="right" valign="middle">确认密码：</td>
    <td height="30" valign="middle">&nbsp;</td>
    <td height="30" valign="middle"><input type="password" name="password_confirm" id="password_confirm" value="<?php isset($user_reg) && print($user_reg['password_confirm']);?>" autocomplete='off' class="up_box"/><span></span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td height="30" align="right" valign="middle">昵称：</td>
    <td height="30" valign="middle">&nbsp;</td>
    <td height="30" valign="middle"><input type="text" name="lastname" id="lastname" value="<?php isset($user_reg) && print($user_reg['lastname']);?>" class="up_box"/><span></span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td height="30" align="right" valign="middle">&nbsp;</td>
    <td height="30" valign="middle">&nbsp;</td>
    <td height="30" valign="middle" class="gray4">请输入中英文、数字、下划线或它们的组合</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td height="30" align="right" valign="middle">验证码：</td>
    <td height="30" valign="middle">&nbsp;</td>
    <td height="30" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="28%" align="left" valign="middle"><input type="text" name="secode" class="up_yzm" /><span></span></td>
        <td width="17%" align="left" valign="middle"><img src="/site/secoder/reg_secoder" id='reg_secoder' /></td>
        <td width="55%" align="left" valign="middle" class="gray"><span style="cursor:pointer;" onClick="reload_secoder('reg_secoder');">看不清，换一张</span></td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><img onclick="javascript:$('#register_form').submit();" src="images/btn5.gif" style='cursor:pointer;' /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="gray">阅读《<a href="cms.php?k=30" target='_blank'>用户注册协议</a>》 </td>
  </tr>
  </form>
</table>
        
</div>
        <p><img src="images/dl2.gif" /></p>	
</div>
</body>
</html>
