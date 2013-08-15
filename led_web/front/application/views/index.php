<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $site_config['site_title'];?></title>
<?php
echo html::script(array
(
 	'media/js/jquery',
), FALSE);
echo html::stylesheet(array
(
 	'media/css/led/style',
), FALSE);
?>
</head>

<body>
<div id="wrapper">
<div class="language_change"><a href="<?php echo url::base();?>"><img src="<?php echo url::base();?>media/images/led/but_chinese.jpg" /></a><a href="<?php echo url::base();?>en/index"><img src="<?php echo url::base();?>media/images/led/but_english.jpg" /></a></div>
	<div id="body_head">
<?php 
echo View::factory('header')->render();
?>
		<div class="banner">
			<div class="pt5">
			        
<script type=text/javascript>
var swf_width=979;
var swf_height=375;
var src="";
var files=src+'<?php echo url::base();?>media/banner/b1.jpg'+'|'+src+'<?php echo url::base();?>media/banner/b2.jpg'+'|'+src+'<?php echo url::base();?>media/banner/b3.jpg';
var src="";
var links='/'+'|'+'/'+'|'+'/'+'|'+'/'+'|'+'/';
var texts='';
document.write('<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="'+ swf_width +'" height="'+ swf_height +'">');
document.write('<param name="movie" value="<?php echo url::base();?>media/images/led/tupian.swf"><param name="quality" value="high">');
document.write('<param name="menu" value="false"><param name=wmode value="opaque">');
document.write('<param name="FlashVars" value="bcastr_file='+files+'&bcastr_link='+links+'&bcastr_title">');
document.write('<embed src="<?php echo url::base();?>media/images/led/tupian.swf" wmode="opaque" FlashVars="bcastr_file='+files+'&bcastr_link='+links+'&bcastr_title='+texts+'& menu="false" quality="high" width="'+ swf_width +'" height="'+ swf_height +'" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />'); document.write('</object>'); 
</script>
			</div>
			<div><img src="<?php echo url::base();?>media/images/led/pp.jpg" /></div>
<?php 
echo View::factory('zxdt')->render();
?>
		</div>
	</div>
	<div id="innerWrapper">
		<div class="guanyuJB">
			<h3><img src="<?php echo url::base();?>media/images/led/b_gyjb.jpg" width="151" height="39" alt="" /></h3>
			<p><img src="<?php echo url::base();?>media/images/led/p_jj.jpg" width="500" height="87" alt="" /></p>
			<p style="text-indent:2em; padding-right:40px">上海竞搏信息科技有限公司成立于2010年，位于国际化大都市上海，注册资金5000万元，是一家专业从事光电产品、节能设备的技术开发、技术服务、技术转让、技术咨询，以及照明系统的设计安装，节能环保工程的承接和综合技术服务为一体的高新技术和综合运营服务企业。  <a href="<?php echo url::base();?>doc/doc_detail/2">[了解更多]</a></p>
		</div>
		<div class="zuixinCP">
			<h3><span><a href="<?php echo url::base();?>products/products_list/36"><img src="<?php echo url::base();?>media/images/led/more.jpg" width="43" height="17" alt="" /></a></span><img src="<?php echo url::base();?>media/images/led/b_zxcp.jpg" width="202" height="39" alt="" /></h3>
			<div><img src="<?php echo url::base();?>media/images/led/bg1.jpg" width="490" height="23" alt="" /></div>
			<!-- <div class="cp_but_l"><img src="media/images/led/b_left.jpg" width="24" height="24" alt=""></div> -->
			<div class="cp_list">
				<ul>
				<?php
				for ($i = 0; $i < 3; $i++) {
				?>
				<li><a href="<?php echo url::base();?>products/product_detail/<?php echo $product_news[$i]['id'];?>"><img src="<?php echo $product_news[$i]['pic'];?>" width="115" height="137" alt="" /></a><p><a href="<?php echo url::base();?>products/product_detail/<?php echo $product_news[$i]['id'];?>"><?php echo $product_news[$i]['title'];?></a></p></li>
				<?php
				} 
				?>
				</ul>
			</div>
			<!-- <div class="cp_but_r"><img src="media/images/led/b_right.jpg" width="24" height="24" alt=""></div> -->
		</div>
	</div>
	<div><a href="<?php echo url::base();?>cases/cases_list/30"><img src="<?php echo url::base();?>media/images/led/l_01.jpg" alt="" /></a><a href="<?php echo url::base();?>faqs/faqs_list/33"><img src="<?php echo url::base();?>media/images/led/l_02.jpg" alt="" /></a><a href="<?php echo url::base();?>doc/doc_detail/3"><img src="<?php echo url::base();?>media/images/led/l_03.jpg" alt="" /></a></div>
</div>
<?php 
echo View::factory('footer')->render();
?>
</body>
</html>