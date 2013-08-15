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
			<div class="pt5"><img src="<?php echo url::base();?>media/images/led/bb6.jpg" /></div>
			<div><img src="<?php echo url::base();?>media/images/led/p2.jpg" /></div>
<?php 
echo View::factory('zxdt')->render();
?>
		</div>
	</div>
	<!--end head-->
	<div id="innerWrapper">
		<div id="wrapper_left">
			<h3>新闻中心</h3>
			<div class="l_menu">
				<ul>
					<?php
					if ($news_classify == 1) { 
					?>
					<li class="l_on"><p style="color:#FFFFFF">竞搏动态</p></li>
					<li ><a href="<?php echo url::base();?>news/news_list/2"><p>行业咨询</p></a></li>
					<?php
					} 
					else {
					?>
					<li><a href="<?php echo url::base();?>news/news_list/1"><p>竞搏动态</p></a></li>
					<li class="l_on"><p style="color:#FFFFFF">行业咨询</p></li>
					<?php
					} 
					?>
					<!-- <li><a href="#"><p>最新动态</p></a></li> -->
				</ul>
			</div>
		</div>
		<div id="wrapper_right">
			<h3><span>您当前的位置：<a href="<?php echo url::base();?>">网站首页</a> >> <?php echo $list_title;?></span><font class="font_078044"><?php echo $list_title;?> </font><font class="font_666">NEWS</font></h3>
			<div class="content_questions">
				<ul>
				<?php
				for ($i = 0; $i < count($news); $i++) {
				?>
				<li>
					<p><span><a href="<?php echo url::base();?>news/news_detail/<?php echo $news[$i]['id']?>">查看详情>></a></span><a href="<?php echo url::base();?>news/news_detail/<?php echo $news[$i]['id']?>">> <?php echo $news[$i]['title']?></a><font class="news_font"><?php echo date( 'Y-m-d',strtotime($news[$i]['created']));?></font></p>
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