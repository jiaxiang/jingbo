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
echo View::factory('header_en')->render();
?>
		<div class="banner">
			<div class="pt5">
			<img src="<?php echo url::base();?>media/images/led/bb1_en.jpg" />
  			</div>
			<div><img src="<?php echo url::base();?>media/images/led/p2.jpg" /></div>
<?php 
echo View::factory('zxdt_en')->render();
?>
		</div>
	</div>
	<!--end head-->
	<div id="innerWrapper">
		<div id="wrapper_left">
			<h3>about us</h3>
			<div class="l_menu">
				<ul>
				<?php 
				if(!empty($about_list)) {
					foreach($about_list as $list) {
						if ($list['id'] == $doc_detail[0]['id']) {
				?>
				<li class="l_on"><a href="<?php echo url::base();?>en/doc/doc_detail/<?php echo $list['id'];?>"><p style="color:#FFFFFF"><?php echo $list['title_en'];?></p></a></li>
				<?php
						}
						else { 
				?>
				<li><a href="<?php echo url::base();?>en/doc/doc_detail/<?php echo $list['id'];?>"><p><?php echo $list['title_en'];?></p></a></li>
           		<?php
           				} 
					}
				}
				?>
				</ul>
			</div>
		</div>
		<div id="wrapper_right">
			<h3><span>Location：<a href="<?php echo url::base();?>en/index">HOME</a> >> <?php echo $doc_detail[0]['title_en'];?></span><font class="font_078044"><?php echo $doc_detail[0]['title_en'];?></font><font class="font_666">Company introduction</font></h3>
			<div class="content">
			  <?php echo $doc_detail[0]['content_en'];?>
			</div>
		</div>
	</div>
</div>
<?php 
echo View::factory('footer_en')->render();
?>
</body>
</html>