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
			<div class="pt5"><img src="<?php echo url::base();?>media/images/led/bb2.jpg" /></div>
			<div><img src="<?php echo url::base();?>media/images/led/p2.jpg" /></div>
<?php 
echo View::factory('zxdt')->render();
?>
		</div>
	</div>
	<!--end head-->
	<div id="innerWrapper">
		<div id="wrapper_left">
			<h3>产品展示</h3>
			<div class="l_menu">
				<ul>
					<li <?php if ($news_classify == 36 || $news_classify == 37) echo 'class="l_on"';?>><a href="#"><p <?php if ($news_classify == 36 || $news_classify == 37) echo 'style="color:#FFFFFF"';?>>led照明</p></a></li>
					<div class="l_menu_02">
						<ul>
							<li><a href="<?php echo url::base();?>products/products_list/36"><p>> 室内照明</p></a></li>
							<li><a href="<?php echo url::base();?>products/products_list/37"><p>> 室外照明</p></a></li>
						</ul>
					</div>
					<li <?php if ($news_classify == 26) echo 'class="l_on"';?>><a href="<?php echo url::base();?>products/products_list/26"><p <?php if ($news_classify == 26) echo 'style="color:#FFFFFF"';?>>太阳能路灯</p></a></li>
					<li <?php if ($news_classify == 27) echo 'class="l_on"';?>><a href="<?php echo url::base();?>products/products_list/27"><p <?php if ($news_classify == 27) echo 'style="color:#FFFFFF"';?>>太阳能发电系统</p></a></li>
				</ul>
			</div>
		</div>
		<div id="wrapper_right">
			<h3><span>您当前的位置：<a href="<?php echo url::base();?>">网站首页</a> >> <?php echo $list_title;?></span><font class="font_078044"><?php echo $list_title;?> </font><font class="font_666">LED Lighting</font></h3>
			<div class="content">
				<ul>
				<?php
				for ($i = 0; $i < count($news); $i++) { 
				?>
				<li>
				<div class="content_img_box">
				<a href="<?php echo url::base();?>products/product_detail/<?php echo $news[$i]['id']?>">
				<img src="<?php $new_pic = explode('.', $news[$i]['newpic']); echo $new_pic[0].'s1.'.$new_pic[1];?><?php //echo $news[$i]['newpic'];?>" /><!-- width="222" height="274" -->
				</a>
				<p><a href="<?php echo url::base();?>products/product_detail/<?php echo $news[$i]['id']?>"><?php echo $news[$i]['title']?></a></p>
				</div>
				</li>
				<?php 
				}
				?>
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="list_page"><?php echo $this->pagination->render('page_html'); ?></div>
<?php 
echo View::factory('footer')->render();
?>
</body>
</html>