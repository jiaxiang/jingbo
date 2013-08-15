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
<div id="member_rtop" class="fl"> <img src="<?php echo url::base();?>media/images/nophoto.gif" width="88" height="88" />
      <p>您好，<span class="red"><?php echo $_user['lastname'];?></span> <a href="/user/profile">修改账户信息</a></p>
      <p class="pt5"><span class="fl">您的账户余额:￥<font class="red bold"><?php echo $_user['user_money'];?></font></span>
      <div class="orange_btn fl white" style="margin-left:10px;"><span><a href="<?php echo url::base();?>user/recharge">充值</a></span></div>
      <div class="tixian_btn fl blue" style="margin:0 10px;"><span><a href="<?php echo url::base();?>user/withdrawals">提现</a></span></div>
      大额一次性取款请联系在线客服或拨打 <span class="red bold"><?php echo $data['site_config']['kf_phone_num'];?></span> 办理
      </p>
      <p class="pt5">上次登录：<?php echo $_user['login_time'];?>　IP:<?php echo $_user['ip'];?>&nbsp;&nbsp;&nbsp;
      <?php
      if ($_user['check_status'] != 2 && date('Y-m-d H:i:s') >= '2011-12-07 19:00:00' && date('Y-m-d H:i:s') <= '2011-12-07 21:00:00' && true) {
      ?>
      <span class="orange" style=" font-size:14px; font-weight:bold;"><a href="<?php echo url::base();?>user/check_mobi_email">马上领取彩金！！</a>（每个用户只能领取一次）</span>
      <?php
      } 
      ?>
      </p>
</div>