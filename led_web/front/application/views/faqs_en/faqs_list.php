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
			<div class="pt5"><img src="<?php echo url::base();?>media/images/led/bb4_en.jpg" /></div>
			<div><img src="<?php echo url::base();?>media/images/led/p2.jpg" /></div>
<?php 
echo View::factory('zxdt_en')->render();
?>
		</div>
	</div>
	<!--end head-->
	<div id="innerWrapper">
		<div id="wrapper_left">
			<h3>FAQS</h3>
			<div class="l_menu">
				<ul>
					<li <?php if ($news_classify == 33) echo 'class="l_on"';?>><a href="<?php echo url::base();?>en/faqs/faqs_list/33"><p <?php if ($news_classify == 33) echo 'style="color:#FFFFFF"';?>>LED Lighting</p></a></li>
					<li <?php if ($news_classify == 34) echo 'class="l_on"';?>><a href="<?php echo url::base();?>en/faqs/faqs_list/34"><p <?php if ($news_classify == 34) echo 'style="color:#FFFFFF"';?>>Solar Street Light</p></a></li>
					<li <?php if ($news_classify == 35) echo 'class="l_on"';?>><a href="<?php echo url::base();?>en/faqs/faqs_list/35"><p <?php if ($news_classify == 35) echo 'style="color:#FFFFFF"';?>>Solar Power System</p></a></li>
				</ul>
			</div>
		</div>
		<div id="wrapper_right">
			<h3><span>Location：<a href="<?php echo url::base();?>en/index">HOME</a> >> <?php echo $list_title;?></span><font class="font_078044"><?php echo $list_title;?> </font><font class="font_666">FAQS</font></h3>
			<div class="content_questions">
				<ul>
				<?php
				for ($i = 0; $i < count($news); $i++) {
				?>
				<li>
					<p><span><a href="<?php echo url::base();?>en/faqs/faq_detail/<?php echo $news[$i]['id']?>">View Details>></a></span><a href="<?php echo url::base();?>en/faqs/faq_detail/<?php echo $news[$i]['id']?>">> <?php echo $news[$i]['title_en']?></a><font class="news_font"><?php echo date( 'Y-m-d',strtotime($news[$i]['created']));?></font></p>
				</li>
				<?php 
				}
				?>
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="list_page"><?php echo $this->pagination->render('page_html_en'); ?></div>
<?php 
echo View::factory('footer_en')->render();
?>
</body>
</html>