<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-会员中心-充值成功</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<?php
echo html::script(array
(
    'media/js/yclass.js?v=20110509',
	'media/js/tabs',
	'media/js/loginer',
	'media/js/detail',
	'media/js/jczq',
	'media/js/user',
	'media/js/predict',
	'media/js/cardpage',
), FALSE);
echo html::stylesheet(array
(
 	'media/css/zc',
	'media/css/mask',
    'media/css/style',
    'media/css/css1',
), FALSE);
?>
<style type="text/css" media="screen">
body{height: 100%;}
.cover_div, .cover_iframe{ position:absolute; left:0; right:0; top:0; bottom:0; width: 100%; height: 100%; display: none; filter:alpha(opacity=0); -moz-opacity:0.5; background: #000; z-index: 999;}
.cover_iframe{z-index:-1;display: block;}
#alert_tip_content{ position: absolute;z-index: 1000;display: none;margin-top:-75px;}
</style>
</head>
<body>
<?php echo View::factory('header')->render();?>
<!--menu和列表_end-->
<!--面包屑导航-->
<div class="width line36 gray68">您所在的位置：<a href="/"><font class="blue">首页</font></a> &gt; 充值成功</div>
<!--面包屑导航_end-->
<!--content1-->
<!--content1 end-->
<!--header end-->
<div style="opacity: 0.5;" id="alert_tip" class="cover_div">
  <iframe style="opacity: 0.5;" class="cover_iframe"></iframe>
</div>
<div id="alert_tip_content"></div>
<!--add end-->
<div id="bd">
  
  <div id="main">
    <div class="sec_lr clearfix">
      <div class="sec_l">
        <div class="sec_box">
          <div class="sec_n_b">
            <div class="sec_info">
              <h2> <span>您已成功充值 <font color="#FF0000"><?php echo $total_fee;?></font> 元！</span> <a href="/user/recharge/">返回继续充值</a> </h2>
              <p>您的账户余额为 <span class="eng red">￥<?php echo $usermoney;?></span> 元<br>
                您可以继续去 <a href="/user/recharge_records">查看充值记录</a> <a href="/user/capital_changes">资金变动明细</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
 <!--footer start-->
<span class="zhangkai"></span>
<?php echo View::factory('footer')->render();?>
 <!--footer end-->
</body>
</html>
