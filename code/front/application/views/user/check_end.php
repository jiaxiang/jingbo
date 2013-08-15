<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-领取彩金</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<?php
echo html::script(array
(
 	'media/js/jquery',
    'media/js/Validform',
	'media/js/My97DatePicker/WdatePicker',
), FALSE);
echo html::stylesheet(array
(
 	'media/css/style',
	'media/css/alert.css',
	'media/css/validate.css',
    'media/css/public.css',
), FALSE);
?>
</head>
<body>
<!--top小目录--><?php
echo View::factory ( 'header' )->render ();
?>
<!--menu和列表_end-->

<!--注册-->
<div class="width">
<div id="huodong" class="fl mt5">
		<p><img src="<?php echo url::base();?>media/images/home_03.jpg" width="986" height="80" /></p>
    <div id="hd_ts" class="fl">
<div id="hd_tsbg" class="fl  red">
            	<p>1、请填写真实的姓名和身份证信息，以免影响您兑奖！</p>
                <p>2、请填写正确的手机和邮件地址，只有通过验证才能领取彩金。</p>
            </div>
      </div>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl">
      <form name="name" action="/user/check_mobi_email" method="post">

    <td colspan="4" align="center" valign="middle"  class="blue heiti" style="font-size:24px; line-height:46px;"><img src="<?php echo url::base();?>media/images/up_right.gif" width="68" height="72" />　恭喜您！身份验证成功！<br />彩金已经打入您的账户,请查收！</td>
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
    <td height="100">&nbsp;</td>
  </tr>
  </form>
  </table>
 	</div>
</div>
<!--注册-->
<!--copyright-->
<span class="zhangkai"></span>
<?php
echo View::factory ( 'footer' )->render ();
?>
<!--copyright_end-->
</body>
</html>
