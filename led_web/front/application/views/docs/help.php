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
        	<p class="about_box_tit fl"><span class="font14 orange bold">新手入门</span></p>
            <?php /*?><?php if(!empty($xsrm)):
				foreach($xsrm as $list):?>
                <?php echo $list['title'];?>
                <?php endforeach;
					endif;?><?php */?>
            <p class="help_text fl">
            <img src="<?php echo url::base();?>media/images/help_liuc.gif" width="750" height="68" border="0" usemap="#Map" />
              <map name="Map" id="Map">
                <area shape="rect" coords="2,3,105,48" href="<?php echo url::base();?>user/register" />
                <area shape="rect" coords="131,6,233,48" href="<?php echo url::base();?>user/recharge" />
                <area shape="rect" coords="258,7,360,48" href="<?php echo url::base();?>jczq/rqspf/" />
                <area shape="rect" coords="386,6,488,48" href="<?php echo url::base();?>doc/help_detail/45" />
                <area shape="rect" coords="516,6,616,47" href="<?php echo url::base();?>news" />
                <area shape="rect" coords="644,6,746,47" href="<?php echo url::base();?>user/withdrawals" />
              </map>
            </p>
            <p class="about_box_tit fl"><span class="font14 orange bold">常见问题</span></p>
            <div class="help_list fl">
            	<ul><?php if($cjwt):
						foreach($cjwt as $list):?>
                	<li class="bg2"><a href="/doc/help_detail/<?php echo $list['id'];?>"><?php echo $list['title'];?></a></li>
                    <?php endforeach;
					endif;?>
                </ul>
            </div>
            <p class="about_box_tit fl"><span class="font14 orange bold">购彩帮助</span></p>
            <div id="gc_help" class="fl">
            	<dl>
                	<dt class="black bold">帐户</dt>
                    <dd class="blue">
                    	<div><a href="<?php echo url::base();?>user/register">用户注册</a></div>
                        <div><a href="<?php echo url::base();?>user/getpassword">忘记密码</a></div>
                        <div><a href="<?php echo url::base();?>user/profile">修改资料</a></div>
                        <div><a href="<?php echo url::base();?>user/betting">投注记录</a></div>
                        <div><a href="<?php echo url::base();?>user/today_bets">今日投注</a></div>
                        <div><a href="<?php echo url::base();?>user/recharge">账户充值</a></div>
                        <div><a href="<?php echo url::base();?>user/withdrawals">账户提现</a></div>
                        <div><a href="<?php echo url::base();?>user/recharge_records">充值记录</a></div>
                    </dd>
                </dl>
                <span class="zhangkai"></span>
            </div>
        </div>
    </div>
</div>
<!--content1_end-->
<!--copyright-->
<span class="zhangkai"></span>
<?php echo View::factory('footer')->render();?>