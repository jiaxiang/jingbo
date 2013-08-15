<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-关于我们</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<?php
echo html::stylesheet(array
(
 	'media/css/style',
), FALSE);
?>
</head>
<body>
<!--top小目录-->

<!--top小目录_end-->
<!--logo和热线-->
<?php echo View::factory('header')->render();?>
<!--logo和热线_end-->
<!--menu和列表-->
<!--menu和列表_end-->

<!--content1-->
<div class="width">
	<div id="about_menu" class="fl pt5">
    	<h3 class="font14 white" id="about_title">关于我们</h3>
		<div id="about_left" class="fl">
            <ul class=" black">
            <?php if(!empty($about_list)):
					foreach($about_list as $list):?>
                <li class="bold"><a href="/doc/doc_detail/<?php echo $list['id'];?>"><?php echo $list['title'];?></a></li>
            <?php 
				endforeach;
			endif;?>
            </ul>
    </div>
    </div>
    <div class="fl mt5" id="buy_right">
    	<div class="about_box fl">
		  <?php if(!empty($doc_detail)):?>
        	<p class="about_box_tit fl"><span class="font14 orange bold"><?php echo $doc_detail[0]['title'];?></span></p>
            <div class="about_text fl" style="padding:15px;">
        	  <p class="font14 "> <?php echo $doc_detail[0]['content'];?> </p></div>
          <?php endif;?>
        </div>
    </div>
</div>
<!--content1_end-->
<!--copyright-->
<span class="zhangkai"></span>
<!--copyright_end-->
<?php echo View::factory('footer')->render();?>
