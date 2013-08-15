<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-足彩胜负-购买成功</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<?php
echo html::script(array
(
    'media/js/yclass.js?v=20110509',
	'media/js/loginer',
	'media/js/fangan',	
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
<?php echo View::factory('/header')->render();?>
<!--menu和列表_end-->
<!--面包屑导航-->
<div class="width line36 gray68">
	<div style="float:left; margin-left:20px;">
		您所在的位置：
		<a href="<?php echo url::base();?>"><font class="blue">首页</font></a> &gt; 
		<a href="<?php echo url::base();?>zcsf/sfc_14c"><font class="blue">足彩胜负</font></a> &gt; 购买成功
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
              <h2> <span>您的方案已提交成功！</span> <a href="/zcsf/sfc_<?php if($play_method==1){echo 14;}elseif($play_method==2){echo 9;}elseif($play_method==3){echo 6;}elseif($play_method==4){echo 4;}?>c">返回继续购买</a> </h2>
              <p>您的账户余额为 <span class="eng red">￥<?php echo $usermoney;?></span> 元<br>
                您可以继续去 <a href="<?php echo '/zcsf/viewdetail/'.$basic_id;?>">查看方案详情</a> <a href="/user/betting">我的购买记录</a></p>
            </div>
            <div class="add_to clearfix">
              <input value="<?php echo url::base();?><?php echo 'zcsf/viewdetail/'.$basic_id;?>" id="writeHiddenUrl" name="writeHiddenUrl" type="hidden">
              <div class="add_to_l">您的方案编号是：<a href="<?php echo '/zcsf/viewdetail/'.$basic_id;?>"><?php echo $basic_id;?></a> <a href="javascript:void(0);" onclick="copyurl('<?php echo url::base();?><?php echo 'zcsf/viewdetail/'.$basic_id;?>')" id="copystr">点击复制</a></div>
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
   <!--余额不足内容-->
  <div class="tips_m" style="top: 300px; display: none; position: absolute;" id="addMoneyLay">
    <div class="tips_b">
      <div class="tips_box">
        <div style="cursor: move;" class="tips_title">
          <h2>可用余额不足</h2>
          <span class="close" id="addMoneyClose"><a href="javascript:void%200">关闭</a></span> </div>
        <div class="tips_text">
          <p class="pd_l tc f14" id="addMoneyContent">您的可投注余额不足，请充值<br>
            (点充值跳到"充值"页面，点"返回"可进行修改)</p>
        </div>
        <div class="tips_sbt">
          <input value="返 回" class="btn_Lora_b" id="addMoneyNo" type="button">
          <input value="充 值" class="btn_Dora_b" id="addMoneyYes" type="button">
        </div>
      </div>
    </div>
  </div>
</body>
</html>