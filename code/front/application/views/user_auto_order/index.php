<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-自动跟单</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<?php
echo html::script(array
(
 	'media/js/yclass',
	'media/js/loginer',
 	'media/js/jquery-1.4.2.min.js',
	'media/js/jquery.validate',
), FALSE);
echo html::stylesheet(array
(
 	'media/css/style',
	'media/css/szc',
	'media/css/mask',
), FALSE);

?>
</head>
<body>
<!--top小目录-->
<?php echo View::factory('header')->render();?>
<!--menu和列表_end-->
<!--面包屑导航-->
<div class="width line36">您所在的位置：<span class="blue"><a href="/">首页</a></span> &gt;&gt; <span class="blue"><a href="/user">会员中心</a></span> &gt;&gt; <span class="blue"><a href="#">投注管理</a></span> &gt;&gt; 自动跟单</div>
<!--面包屑导航_end-->
<!--content1-->
<div class="width">
<?php echo View::factory('user/left')->render();?>    
<div class="member_right fl">
<iframe height="500px" frameborder="0" align="middle" width="100%" scrolling="no" src="/user_auto_order/myfollow" name="mainframe" id="mainframe" style="border: 0pt none; height: 416px;" allowtransparency="true"></iframe>
<div>




 </div>
  </div>
</div>
<!--content1_end-->
<!--copyright-->
<span class="zhangkai"></span>
<?php echo View::factory('footer')->render();?>
<!--copyright_end-->
</body>
</html>
