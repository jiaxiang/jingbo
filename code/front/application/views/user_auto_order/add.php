<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-设置自动跟单</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<script type="text/javascript">
<!--
var lotyid = <?php echo $lotyid?>;
var fid = <?php echo $fid?>;
var play_id = <?php echo $play_id?>;
var ower = '<?php echo $ower?>';
//-->
</script>
<?php
echo html::script(array
(
	'media/js/jquery-1.6.2.min',
    'media/js/yclass',
	'media/js/loginer',
	'media/auto_order/js/autobuy',
), FALSE);
echo html::stylesheet(array
(
 	'media/css/zc',
	'media/css/mask',
    'media/css/style',
    'media/css/css1',
), FALSE);
?>
<style>
*{ padding:0;  margin:0;}
img{ border:none;}
.clear{ clear:both; line-height:0; font-size:0;}
	.tank_gendan{ width:460px; height:auto; font-size:12px; font-family:Verdana, Geneva, sans-serif; border:2px solid #7498c0; margin:20px auto;}
	.gd_title{ overflow:hidden; background:#c0d6ee;line-height:27px;}
	.gd_title h1{ float:left; font-size:14px;  padding-left:8px;}
	.gd_title a{ float: right; padding-right:5px;}
	.title_m{ line-height:25px;  background:#eaf4fe; padding-left:20px;}
	.red{ color:#F00;}
	.set_content p{ line-height:25px; padding-left:10px;}
	.in_txt{ width:50px; border:1px solid #09C; text-align:center; color:#F00; height:16px;}
	.set_gd_con{ border:1px solid #e5c3a7; background:#fffbf0; margin:8px; padding-bottom:5px;}
	
</style>
</head>
<body style="background-image:none;">
<div style="width:475px;" >
     <div class="tips_b">
      <div class="tips_box">
        <div class="tips_title">
        <h2>
        </h2>
        <span class="close"><a href="javascript(void 0)" onclick="top.Y.closeUrl()">关闭</a></span>

        </div>
	    <div class="tips_info tips_info_np">
				<div class="title_m" id="title_m">
      	</div> 
			<div class="set_content">
				<p>每个方案认购&nbsp;<input name="bmoney" id="bmoney" type="text" class="in_txt" />
				元&nbsp;&nbsp;<span class="red">每期可能发起多个方案,系统将根据发单时间依次认购</span></p> 
				<div class="set_gd_con">

			        <p style="margin-top:10px;">对认购的方案金额不做限制</p>
			        <p><input name="ra" id="ra0" type="radio" value="0" checked onclick="javascript:yesselect()"/>是&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			        <input name="ra" id="ra1" type="radio" value="1" onclick="javascript:noselect()"/>否,我要限制&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			        <span id="settxt" style="display:none">认购<input name="minm" id="minm" type="text" class="in_txt" />元 到<input name="maxm" id="maxm" type="text" class="in_txt" />元的方案</span></p>
			    </div>
				<p style="color: #999;" id="history">已定制该发起人<span id="anum" class="red">**</span>次，跟单总金额<span id="amoney" class="red">**</span>元</p>

				<p class="red">注意：您的账户余额小于每次认购金额时，系统将停止自动跟单；<br />当发起人的方案金额小于您定制的“每次认购金额”时，系统不自动认购。</p>
				
			</div>
      	</div>
	  <div class="tips_sbt"><p align="center" style="padding-left:24px">
         <input type="button" class="btn_Lora_b" value="关 闭" onclick="parent.Y.closeUrl()" id="tclose"/>
         <input type="button" class="btn_Dora_b" value="定 制" id="btnAuto" />
      </div>
    </div>

  </div>
</div>

</body>
</html>