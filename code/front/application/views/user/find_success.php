<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-找回密码成功</title>
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
<span class="zhangkai"></span>
<form name="name" action="/user/find_success" method="post">
<div id="up_success" style="width:700px;">
	<div class="fl"><img src="images/up_right.gif" width="68" height="72" /></div>
<div class="fl pl10" style="width:570px">
    	<p class="font30 orange heiti">找回密码成功</p>
        <p class="font14">我们已经把验证邮件发送至您的邮箱，请在24小时内通过邮件内的链接继续设置新的密码。</p>
        <p class="font14 gray6">如果没有收到邮件？ 到您邮箱的垃圾邮件里找找!</p>
        <p class="gray6" style="line-height:22px; padding-top:20px;">如果有任何疑问，请访问 找回密码帮助，或与 <?php echo $site_config['site_title'];?>客服部取得联系。
          <br />
          客服邮箱：<?php echo $site_config['site_email'];?>
          <br />
          客服热线：<?php echo $site_config['kf_phone_num'];?> (仅收市话费，客服工作时间：8：00-次日凌晨1：00)
		<br />客服传真：<?php echo $site_config['cz_phone_num'];?></p>
    </div>
</div>
</form>
<!--注册-->
<!--copyright-->
<span class="zhangkai"></span>
<?php echo View::factory('footer')->render();?>
<!--copyright_end-->
</body>
</html>