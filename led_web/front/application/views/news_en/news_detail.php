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
			<div class="pt5"><img src="<?php echo url::base();?>media/images/led/bb6_en.jpg" /></div>
			<div><img src="<?php echo url::base();?>media/images/led/p2.jpg" /></div>
<?php 
echo View::factory('zxdt_en')->render();
?>
		</div>
	</div>
	<!--end head-->
	<div id="innerWrapper">
		<div id="wrapper_left">
			<h3>News Center</h3>
			<div class="l_menu">
				<ul>
					<?php
					if ($news_infor[0]['classid'] == 1) { 
					?>
					<li class="l_on"><p style="color:#FFFFFF">News</p></li>
					<li ><a href="<?php echo url::base();?>en/news/news_list/2"><p>Information</p></a></li>
					<?php
					} 
					else {
					?>
					<li><a href="<?php echo url::base();?>en/news/news_list/1"><p>News</p></a></li>
					<li class="l_on"><p style="color:#FFFFFF">Information</p></li>
					<?php
					} 
					?>
					<!-- <li><a href="#"><p>最新动态</p></a></li> -->
				</ul>
			</div>
		</div>
		<div id="wrapper_right">
			<h3><span>Location：<a href="<?php echo url::base();?>en/index">HOME</a> &gt;&gt; <a href="<?php echo url::base();?>en/news/news_list/<?php echo $news_infor[0]['classid']?>"><?php echo $news_classify?></a> &gt;&gt; <?php echo tool::cut_str($news_infor[0]['title_en'],26)?></span><font class="font_078044"><?php echo $news_classify?> </font><font class="font_666">NEWS</font></h3>
			<div class="content_questions">
				<h1><?php echo $news_infor[0]['title_en']?></h1>
				<h2>Source：<?php echo $news_infor[0]['comefrom_en']?> View Count：<?php echo $news_infor[0]['click']?> Date：<?php echo date( 'Y-m-d h:s',strtotime($news_infor[0]['created']));?> </h2>
				<?php 
      			echo $news_infor[0]['content_en'];
      			?>
			</div>
			<div class="content_questions_n">
Previous：
<?php 
if(isset($previous) && $previous) {
	echo '<a href="/en/news/news_detaile/'.$previous[0]['id'].'" title="'.$previous[0]['title_en'].'">'.tool::cut_str($previous[0]['title_en'],14).'</a>';
}
else {
	echo 'nothing';
}
?>
<br />
Next：
<?php 
if(isset($next) && $next) {
	echo '<a href="/en/news/news_detaile/'.$next[0]['id'].'" title="'.$next[0]['title_en'].'">'.tool::cut_str($next[0]['title_en'],14).'</a>';
}
else {
	echo 'nothing';
}
?>
<br />
Category： <?php echo $news_classify?><br />
Keys：
<?php 
if(isset($key)) {
	foreach($key as $k=>$v) {
		if($k > 0) {
			echo '，';
		}
		echo $v;
	}
}
?>


			</div>
		</div>
	</div>
</div>
<?php 
echo View::factory('footer_en')->render();
?>
</body>
</html>