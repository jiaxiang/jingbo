<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-单场竞猜-购买成功</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<?php
echo html::script(array
(
    'media/js/yclass.js?v=20110509',
	'media/js/tabs',
	'media/js/loginer',
	'media/js/detail',
	'media/js/bjdc',
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
<script language="javascript">
//复制方案地址
function copyIt(id) {
	var o = Y.one('#'+id);
	if (document.all) {
		o.select();
		window.clipboardData.clearData();
		window.clipboardData.setData("text",o.value);
		alert('网址复制成功！');
	} else {
		alert('您的浏览器不支持脚本复制,请尝试手动复制');
		o.select();
	}
}
</script>
</head>
<body>
<?php echo View::factory('header')->render();?>
<!--menu和列表_end-->
<!--面包屑导航-->
<div class="width line36 gray68">
	<div style="float:left; margin-left:20px;">
		您所在的位置：
		<a href="<?php echo url::base();?>"><font class="blue">首页</font></a> &gt; 
		<a href="<?php echo url::base();?>bjdc/rqspf"><font class="blue">单场竞猜</font></a> &gt; 购买成功
	</div>
	<div style="float:right; margin-right:20px;">
		<span style="float:right">客服电话：<?php echo $site_config['kf_phone_num'];?></span>
	</div>
	<div style="clear:both;"></div>
</div>
<!--面包屑导航_end-->
<!--content1-->
<!--content1 end-->
<!--header end-->
<!--用户未填写个人资料时弹出提示层 add by yeqh 2010-4-28-->
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
              <h2> <span>您的方案已提交成功！</span> <a href="<?='/bjdc/'.$back_url?>">返回继续购买</a> </h2>
              <p>您的账户余额为 <span class="eng red">￥<?php echo $usermoney;?></span> 元<br>
                您可以继续去 <a href="<?php echo '/bjdc/viewdetail/'.$basic_id;?>">查看方案详情</a> <a href="/user/betting">我的购买记录</a></p>
            </div>
            <div class="add_to clearfix">
              <input value="<?php echo url::base();?><?php echo '/bjdc/plan/'.$id;?>" id="writeHiddenUrl" name="writeHiddenUrl" type="hidden">
              <div class="add_to_l">您的方案编号是：<a href="<?php echo '/bjdc/viewdetail/'.$basic_id;?>"><?php echo $basic_id;?></a> <a href="javascript:void(0);" onclick="copyurl('<?php echo url::base();?><?php echo '/bjdc/viewdetail/'.$basic_id;?>')" id="copystr">点击复制</a></div>
              <div class="add_to_r">

              </div>
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