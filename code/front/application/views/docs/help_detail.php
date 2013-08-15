<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-帮助中心</title>
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
<!--logo和热线_end-->
<?php echo View::factory('header')->render();?>
<!--menu和列表-->
<!--menu和列表_end-->

<!--content1-->
<div class="width">
	<div id="about_menu" class="fl pt5">
    	<h3 class="font14 white" id="about_title">帮助中心</h3>
		<div id="about_left" class="fl">
            <ul class=" black">
                <li class="bold">购彩帮助</li>
                <?php if(!empty($gcbz)):
						foreach($gcbz as $list):?>
                <li class="bg2"><a href="/doc/help_detail/<?php echo $list['id'];?>"><?php echo $list['title'];?></a></li>
                <?php 
				endforeach;
				endif;?>
                <li class="bold">彩种介绍</li>
                <?php if(!empty($czjs)):
						foreach($czjs as $list):?>
                <li class="bg2"><a href="/doc/help_detail/<?php echo $list['id'];?>"><?php echo $list['title'];?></a></li>
                <?php endforeach;
					endif;?>
            </ul>
    </div>
    </div>

<div class="fl mt5" id="buy_right">
    	<div class="about_box fl">
        	<p id="help_dtit" class="fl heiti"><?php echo $help_detail[0]['title']?></p>
            <div id="heip_detail" class="fl">
              <?php echo $help_detail[0]['content']?>
            </div>
        </div>
    </div>

</div>
<!--content1_end-->
<!--copyright-->
<span class="zhangkai"></span>
<?php echo View::factory('footer')->render();?>