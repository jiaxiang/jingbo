<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-新闻中心</title>
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
  <div id="news_left" class="fl pt5">
    <div class="news_neir fl">
      <div class="pr5 news_l_left">
        <p id="new_banner" class="fl"><img src="media/images/_img14.jpg" width="362" height="232" /></p>
      </div>
      <div class="news_l_left">
        <div id="review" class="fl">
		<?php 
		if(!empty($newstj)):
				foreach($newstj as $k=>$v):
				if($k==0):				
				?>
          <p id="review_tit" class="tc yahei red"><a href="/news/news_detaile/<?php echo $v['id']?>"><?php echo tool::cut_str($v['title'],18);?></a></p>
		  <?php endif;
		  if($k==1):?>
          <p id="review_tit2" class="font14 bold tc"><a href="/news/news_detaile/<?php echo $v['id']?>"><?php echo tool::cut_str($v['title'],22);?></a></p><ul class="font14 gray68">
		  <?php endif; if($k>1):?>
            <li><a href="/news/news_detaile/<?php echo $v['id']?>"><?php echo tool::cut_str($v['title'],25);?></a></li>
		<?php endif;
			endforeach;
		endif;
		if(count($newstj)>2):
		?>	
		</ul>
		<?php endif;?>
        </div>
      </div>
    </div>
    <div class="news_neir fl">
      <div class="news_l_left pt5 pr5">
        <div class="fl news_tit tc">
          <ul class="blue">
            <li  class="hover"  id="one1" onmouseover="setTab('one',1,2)"><a href="/news/news_list/12">足球单场资讯</a></li>
            <li id="one2" onmouseover="setTab('one',2,2)"><a href="/news/news_list/13">足球单场高预测</a></li>
          </ul>
        </div>
        <div  class="left_newslist fl">
          <ul id="con_one_1">
				  <?php 
				if(!empty($news_list[12])):	
				foreach($news_list[12] as $v):
				?>
					<li><span class="fr blue font11"><?php echo date( 'm-d ',strtotime($v['created']));?></span><a href="/news/news_detaile/<?php echo $v['id']?>"><?php echo tool::cut_str($v['title'],22);?></a></li>
			  <?php endforeach;
			  endif;
			  ?>
          </ul>
          <ul id="con_one_2" style="display:none;">
            <?php 
				if(!empty($news_list[13])):	
				foreach($news_list[13] as $v):
				?>
					<li><span class="fr blue font11"><?php echo date( 'm-d ',strtotime($v['created']));?></span><a href="/news/news_detaile/<?php echo $v['id']?>"><?php echo tool::cut_str($v['title'],22);?></a></li>
			  <?php endforeach;
			  endif;
			  ?>
          </ul>
        </div>
      </div>
      <div class="news_l_left pt5">
        <div class="fl news_tit tc">
          <ul class="blue">
            <li class="hover" id="two1" onmousemove="setTab('two',1,2)"><a href="/news/news_list/14">足球彩讯</a></li>
            <li id="two2" onmousemove="setTab('two',2,2)"><a href="/news/news_list/15">足球预测</a></li>
          </ul>
        </div>
        <div class="left_newslist fl" >
          <ul id="con_two_1">
            <?php 
				if(!empty($news_list[14])):	
				foreach($news_list[14] as $v):
				?>
					<li><span class="fr blue font11"><?php echo date( 'm-d ',strtotime($v['created']));?></span><a href="/news/news_detaile/<?php echo $v['id']?>"><?php echo tool::cut_str($v['title'],22);?></a></li>
			  <?php endforeach;
			  endif;
			  ?>
          </ul>
          <ul id="con_two_2" style="display:none;">
             <?php 
				if(!empty($news_list[15])):	
				foreach($news_list[15] as $v):
				?>
					<li><span class="fr blue font11"><?php echo date( 'm-d ',strtotime($v['created']));?></span><a href="/news/news_detaile/<?php echo $v['id']?>"><?php echo tool::cut_str($v['title'],22);?></a></li>
			  <?php endforeach;
			  endif;
			  ?>
          </ul>
        </div>
      </div>
    </div>
    <div class="news_neir fl mt5" id="new_banner2"><img src="media/images/_img15.jpg" width="733" height="115" /></div>
    <div class="news_neir fl">
      <div class="news_l_left pt5 pr5">
        <div class="fl news_tit tc">
          <ul class="blue">
            <li  class="hover"  id="three1" onmouseover="setTab('three',1,2)"><a href="/news/news_list/16">竞彩足球资讯</a></li>
            <li id="three2" onmouseover="setTab('three',2,2)"><a href="/news/news_list/17">竞彩足球预测</a></li>
          </ul>
        </div>
        <div  class="left_newslist fl">
          <ul id="con_three_1">
            <?php 
				if(!empty($news_list[16])):	
				foreach($news_list[16] as $v):
				?>
					<li><span class="fr blue font11"><?php echo date( 'm-d ',strtotime($v['created']));?></span><a href="/news/news_detaile/<?php echo $v['id']?>"><?php echo tool::cut_str($v['title'],22);?></a></li>
			  <?php endforeach;
			  endif;
			  ?>
          </ul>
          <ul id="con_three_2" style="display:none;">
             <?php 
				if(!empty($news_list[17])):	
				foreach($news_list[17] as $v):
				?>
					<li><span class="fr blue font11"><?php echo date( 'm-d ',strtotime($v['created']));?></span><a href="/news/news_detaile/<?php echo $v['id']?>"><?php echo tool::cut_str($v['title'],22);?></a></li>
			  <?php endforeach;
			  endif;
			  ?>
          </ul>
        </div>
      </div>
      <div class="news_l_left pt5">
        <div class="fl news_tit tc">
          <ul class="blue">
            <li class="hover" id="four1" onmousemove="setTab('four',1,2)"><a href="/news/news_list/18">竞彩篮球资讯</a></li>
            <li id="four2" onmousemove="setTab('four',2,2)"><a href="/news/news_list/19">竞彩篮球预测</a></li>
          </ul>
        </div>
        <div class="left_newslist fl" >
          <ul id="con_four_1">
             <?php 
				if(!empty($news_list[18])):	
				foreach($news_list[18] as $v):
				?>
					<li><span class="fr blue font11"><?php echo date( 'm-d ',strtotime($v['created']));?></span><a href="/news/news_detaile/<?php echo $v['id']?>"><?php echo tool::cut_str($v['title'],22);?></a></li>
			  <?php endforeach;
			  endif;
			  ?>
          </ul>
          <ul id="con_four_2" style="display:none;">
             <?php 
				if(!empty($news_list[19])):	
				foreach($news_list[19] as $v):
				?>
					<li><span class="fr blue font11"><?php echo date( 'm-d ',strtotime($v['created']));?></span><a href="/news/news_detaile/<?php echo $v['id']?>"><?php echo tool::cut_str($v['title'],22);?></a></li>
			  <?php endforeach;
			  endif;
			  ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="fl news_right pt5">
    <div id="right_tit" class="fl tright"><span id="right_biaot" class="red bold fr">足彩</span><span class="fr"><img src="media/images/news_sj.gif" width="8" height="25" /></span></div>
    <div id="new_jieguo" class="fl">
    <?php if(!empty($kaijiang)):
				foreach($kaijiang as $list):?>
      <div class="jieguo_list fl black">
        <p class="bold"><?php echo $list['type'];?> <span class="red"><?php echo $list['issue'];?></span> 期</p>
        <p class="bold"><?php echo $list['number'];?></p>
        <p class="black"><?php echo $list['summary'];?></p>
      </div>
       <?php endforeach;
				endif;?>
    </div>

      <h3 class="orange newlist_biaot mt5"><a href="/news/news_list/5">彩客名人</a></h3>
      <div class="new_newlist fl blue">
        <ul>
        	<?php 
		if(!empty($news_ck)):	
		foreach($news_ck as $v):
		?>
      <li><a href="/news/news_detaile/<?php echo $v['id']?>"><?php echo tool::cut_str($v['title'],19);?></a></li>
	  <?php endforeach;
	  endif;
	  ?>
        </ul>
      </div>
      
      <h3 class="orange newlist_biaot mt5"><a href="/news/news_list/6">体育新闻</a></h3>
      <div class="new_newlist fl blue">
        <ul>
        	<?php 
		if(!empty($news_ty)):	
		foreach($news_ty as $v):
		?>
      <li><a href="/news/news_detaile/<?php echo $v['id']?>"><?php echo tool::cut_str($v['title'],19);?></a></li>
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
