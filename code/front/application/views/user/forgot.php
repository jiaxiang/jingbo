<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-找回密码</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<?php
echo html::script(array
(
 	'media/js/jquery',
), FALSE);
echo html::stylesheet(array
(
 	'media/css/style',
), FALSE);
?>
</head>
<body>
<!--top小目录-->
<?php echo View::factory('header')->render();?>
<!--menu和列表_end-->

<!--注册-->
<div class="width">
	<p id="up_title" class="fl font16 bold">找回密码</p>	
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl" height="300">
    <form name="name" action="/user/getpassword" method="post">
  <tr>
    <td width="42%" height="44">&nbsp;</td>
    <td width="1%">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td width="31%">&nbsp;</td>
  </tr>
  <tr>
    <td height="26" align="right" valign="middle" class="font14"></td>
    <td height="26" valign="middle">&nbsp;</td>
    <td height="26" colspan="2" valign="middle"><?php if(!empty($notice))echo $notice;?></td>
    <td height="26" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td height="26" align="right" valign="middle" class="font14">注册的Email地址：</td>
    <td height="26" valign="middle">&nbsp;</td>
    <td height="26" colspan="2" valign="middle"><input type="text" name="email" id="email" class="up_text" /></td>
    <td height="26" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td height="15" colspan="5" align="right" valign="middle"></td>
  </tr>
  <tr>
    <td height="26" align="right" valign="middle" class="font14">注册的用户名：</td>
    <td height="26" valign="middle">&nbsp;</td>
    <td height="26" colspan="2" valign="middle"><input type="text" name="lastname" id="lastname" class="up_text" /></td>
    <td height="26" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" valign="middle">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2"><input  type="submit"  alt="重置密码" value="重置密码"/></td>
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
<span class="zhangkai"></span>
<?php echo View::factory('footer')->render();?>
<!--copyright_end-->
</body>
</html>
