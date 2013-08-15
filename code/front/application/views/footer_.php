<?php
$data['site_config'] = Kohana::config('site_config.site');
$host = $_SERVER['HTTP_HOST'];
$dis_site_config = Kohana::config('distribution_site_config');
if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
	$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
	$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
	$data['site_config']['description'] = $dis_site_config[$host]['description'];
} 
?>
<div class="width">
 <div id="foot_menu" class="fl tc">
	<font class="blue"><a href="<?php echo url::base();?>doc/doc_detail/39">公司简介</a></font>　
	<font class="grayd0">|</font>　<font class="blue"><a href="<?php echo url::base();?>doc/doc_detail/40">联系方式</a></font>　
	<font class="grayd0">|</font>　<font class="blue"><a href="<?php echo url::base();?>doc/doc_detail/42">汇款地址</a></font>　
	<font class="grayd0">|</font>　<font class="blue"><a href="<?php echo url::base();?>doc/doc_detail/53">加盟合作</a></font>　
	<font class="grayd0">|</font>　<font class="blue"><a href="<?php echo url::base();?>doc/doc_detail/41">网站地图</a></font>　
	<font class="grayd0">|</font>　<font class="blue"><a href="<?php echo url::base();?>doc/doc_detail/43">客服信息</a></font>
	<font class="grayd0">|</font>　<font class="blue"><a href="mailto:<?php echo $data['site_config']['site_email2'];?>">友情链接申请</a></font>
	<font class="grayd0">|</font>　<font class="blue"><a href="<?php echo url::base();?>doc/doc_detail/83"><?php echo $data['site_config']['site_title2'];?>QQ群</a></font>
	
 </div>
</div>
<span class="zhangkai"></span>
<div id="copyright">
	<div class="width">
    	<div class="gray6" id="copyright_text" style="text-align:center">
			<p ><?php echo $data['site_config']['copyright'];?> <?php echo $data['site_config']['site_title'];?> <?php echo $data['site_config']['company_name'];?>  All rights reserved. <?php echo $data['site_config']['icp'];?>  <a href="http://www.surlink.com.cn" target="_blank">上海思锐</a></p>
            <p >客服热线：<?php echo $data['site_config']['kf_phone_num'];?>(免收长途费) <?php echo $data['site_config']['kf_phone_num2'];?>(早8:00-凌晨2:00) 传真号：<?php echo $data['site_config']['cz_phone_num'];?> </p>
            <p ><?php echo $data['site_config']['site_title2'];?>提醒：本网站信息仅供合法购买中国福利彩票和中国体育彩票分析之用，严禁赌博 彩票有风险，购买要适度。不向未满18岁的青少年出售彩票</p>
        </div>
    </div>
    <div class="width" id="copyright_img" style="text-align:center;">
        <a href="http://www.shlottery.gov.cn/" target="_blank"><img src="<?php echo url::base();?>media/images/_img10.gif" /></a>
        <a href="http://www.swlc.sh.cn/cams/index.html" target="_blank"><img src="<?php echo url::base();?>media/images/_img11.gif"  /></a>
        <a href="http://www.xiaolinhouse.com" target="_blank"><img src="<?php echo url::base();?>media/images/friend_link/xiaolinlogo.gif"  /></a>
    </div>
</div>
<?php
if (!isset($NO_KF)) { 
?>
<script type='text/javascript' src='http://chat.53kf.com/kf.php?arg=jingbo365&style=1'></script>
<?php
} 
?>
<script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F32ee1b68bd85cc237c55bdf6314d909a' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-18147286-2']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>