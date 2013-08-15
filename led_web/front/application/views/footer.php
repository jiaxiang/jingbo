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
<div id="footer">
<p><?php echo $data['site_config']['copyright'];?>  All rights reserved. <?php echo $data['site_config']['company_name'];?> <br />
全国7*24小时服务热线：<?php echo $data['site_config']['kf_phone_num'];?> <?php echo $data['site_config']['kf_phone_num2'];?> <?php echo $data['site_config']['icp'];?></p>
</div>