<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-注册成功</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" /><?php
echo html::script(array
(   
    'media/js/ajax.js',
 	'media/js/reg_new.js',

), FALSE);
echo html::stylesheet(array
(
 	'media/css/style',
	'media/css/user-new.css',
	'media/css/alert.css',
), FALSE);
?>

</head>
<body>
<?php echo $ucsynloginaaa;?>
<?php echo View::factory('header')->render();?>
<!--menu和列表_end-->

<!--注册-->
<span class="zhangkai"></span>
<div id="up_success">
	<div class="fl"><img src="<?php echo url::base();?>media/images/up_right.gif" width="68" height="72" /></div>
<div class="fl pl10" style="width:450px">
        <p class="font14 gray6">我们已发送一封验证邮件 <span style="padding:10px;"><a href="http://mail.<?php if(!empty($email)){ $email = explode('@',$email);print_r ($email[1]);}?>" target="_blank"><?php print_r ($email[0].'@'.$email[1]);?></a></span> 到您的邮箱中，请及时登录邮箱激活帐号，否则无法登录网站!</p>
    </div>
</div>
<!--注册-->
<!--copyright-->
<span class="zhangkai"></span>
<?php echo View::factory('footer')->render();?>
<!--copyright_end-->
</body>
</html>