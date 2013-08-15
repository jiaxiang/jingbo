<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-注册激活成功</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<?php
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
    	<p class="font30 orange heiti">您的账户<font color="#0000FF"><a href="<?php echo url::base();?>user/login"><?php echo $_username;?></a></font>已经成功激活，现在可以登录网站了！</p>
        <p class="font14"><span class="gray6"></span> <span class="blue"></span></p>
        <p><span class="orange"><a href="<?php echo url::base();?>user">去会员中心</a></span> <span class=" graybc">|</span> <span class="orange"><a href="<?php echo url::base();?>">去首页</a></span> <span class=" graybc">|</span> </p>
    </div>
</div>
<!--注册-->
<!--copyright-->
<span class="zhangkai"></span>
<?php echo View::factory('footer')->render();?>
<!--copyright_end-->
</body>
</html>
