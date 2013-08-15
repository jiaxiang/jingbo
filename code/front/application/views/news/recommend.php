<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-专家推荐</title>
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
    	<p id="recommend_tit">您所在的位置：<span class="blue"><a href="/">首页</a></span> &gt; 专家推荐 </p>
        <div id="recommend_list" class="fl font14">
        	<ul>
				<?php if(!empty($recommend)):
					foreach($recommend as $list):?>
            	<li><span><?php echo date( 'Y-m-d ',strtotime($list['created']));?></span><a href="/news/news_detaile/<?php echo $list['id'];?>"><?php echo $list['title'];?></a></li>
				<?php endforeach;
				endif;?>
            </ul>
        </div>
        <span class="zhangkai"></span>
		<div class="manu mt15"><?PHP  echo $this->pagination->render('page_html'); ?></div>
  </div>
  <div id="recommend_right" class="fl">
  	<div class="news_serach fl mt5">
    <form name="search" action="/news/news_search" method="get">
  	  <input name="search" type="text" class="fl news_serachtext" id="search"  />
      <input  type="submit"  alt="搜索" value="搜  索"/>
      </form>
  	</div>
    <div class="news_list fl mt5">
    	<ul class="blue">
        	<?php 
				if(!empty($list1)):	
				foreach($list1 as $v):
				?>
					<li><a href="/news/news_detaile/<?php echo $v['id']?>"><?php echo tool::cut_str($v['title'],22);?></a></li>
			  <?php endforeach;
			  endif;
			  ?>
        </ul>
    </div>
    <p class="zj_right fl mt5"><span class="fr blue"><a href="<?php echo url::base();?>news/zxtj">更多 &gt;&gt;</a></span><span class="blue font14 bold">推荐新闻</span></p>
    <div class="zj_right_box fl blue">
    	<ul>
        	<?php 
				if(!empty($list2)):	
				foreach($list2 as $v):
				?>
					<li><a href="/news/news_detaile/<?php echo $v['id']?>"><?php echo tool::cut_str($v['title'],22);?></a></li>
			  <?php endforeach;
			  endif;
			  ?>
        </ul>
    </div>
  </div>
</div>
<!--content1_end-->
<!--copyright-->
<span class="zhangkai"></span>
<?php echo View::factory('footer')->render();?>
<!--copyright_end-->
