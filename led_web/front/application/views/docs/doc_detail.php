<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $site_config['site_title'];?></title>
<?php
echo html::script(array
(
 	'media/js/jquery',
), FALSE);
echo html::stylesheet(array
(
 	'media/css/led/style',
), FALSE);
?>
</head>

<body style="background:url(<?php echo url::base();?>media/images/led/wbg2.jpg) top repeat-x">
<div id="wrapper">
	<div id="body_head">
<?php 
echo View::factory('header')->render();
?>
		<div class="banner">
			<div class="pt5">
			<img src="<?php echo url::base();?>media/images/led/bb1.jpg" />
  			</div>
			<div><img src="<?php echo url::base();?>media/images/led/p2.jpg" /></div>
<?php 
echo View::factory('zxdt')->render();
?>
		</div>
	</div>
	<!--end head-->
	<div id="innerWrapper">
		<div id="wrapper_left">
			<h3>关于竞搏</h3>
			<div class="l_menu">
				<ul>
				<?php 
				if(!empty($about_list)) {
					foreach($about_list as $list) {
						if ($list['id'] == $doc_detail[0]['id']) {
				?>
				<li class="l_on"><a href="<?php echo url::base();?>doc/doc_detail/<?php echo $list['id'];?>"><p style="color:#FFFFFF"><?php echo $list['title'];?></p></a></li>
				<?php
						}
						else { 
				?>
				<li><a href="<?php echo url::base();?>doc/doc_detail/<?php echo $list['id'];?>"><p><?php echo $list['title'];?></p></a></li>
           		<?php
           				} 
					}
				}
				?>
				</ul>
			</div>
		</div>
		<div id="wrapper_right">
			<h3><span>您当前的位置：<a href="<?php echo url::base();?>">网站首页</a> >> <?php echo $doc_detail[0]['title'];?></span><font class="font_078044"><?php echo $doc_detail[0]['title'];?></font><font class="font_666">Company introduction</font></h3>
			<div class="content">
			  <?php echo $doc_detail[0]['content'];?>
			</div>
		</div>
	</div>
</div>
<?php 
echo View::factory('footer')->render();
?>
</body>
</html>