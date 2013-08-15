<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-新闻中心-搜索</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<?php
echo html::script(array
(
 	'media/js/jquery',
    'media/js/hdm',
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
<!--content1-->
<div class="width">
<div id="recommend" class="fl mt5">
    	<p id="recommend_tit">您所在的位置：<span class="blue"><a href="/">首页</a></span> &gt;&gt; <a href="/news">新闻搜索</a> &gt;&gt; 你搜索的关键词是：<font color="#FF0000" ><?php echo $keywords;?></font></p>
        <div id="recommend_list" class="fl font14">
        	<ul>
				<?php if(!empty($search_result)):
					foreach($search_result as $list):?>
            	<li><span><?php echo date( 'Y-m-d ',strtotime($list['created']));?></span><a href="/news/news_detaile/<?php echo $list['id'];?>"><?php echo str_replace($keywords,'<font color="#FF0000" >'.$keywords.'</font>',$list['title']);?></a></li>
				<?php endforeach;
				endif;?>
            </ul>
        </div>
        <span class="zhangkai"></span>
		<div class="manu mt15"><?php /*?><?php echo $this->pagination->render('page_html');?><?php */?></div>
  </div>
  <?php echo View::factory('/news/news_menu')->render();?>
</div>
<!--content1_end-->
<!--copyright-->
<span class="zhangkai"></span>
<?php echo View::factory('footer')->render();?>
<!--copyright_end-->
