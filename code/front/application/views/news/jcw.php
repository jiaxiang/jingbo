<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-第一届竞波竞猜王</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<?php
echo html::stylesheet(array
(
	'media/css/style',
 	'media/jcw1/guess',
), FALSE);
?>
</head>
<body>
<?php echo View::factory('header')->render();?>
<div class="guess">
	<div class="guess_top"></div>
  <div class="guess_content">
        <p><span class="text_title">活动介绍：</span></p>
      <p><span class="text_red">网络购彩纷纷叫停，竞波为了迎合广大彩民的需要，特别举办第一届竞波竞猜王活动，让您能在网络购彩的冬天里也感受到一丝丝暖意。活动最高奖励更是高达2000元！！！还不快呼朋唤友齐加入？</span></p>
        <p>&nbsp;</p>
        <p><span class="text_title">活动方式：</span>竞彩足球</p>
        <p>&nbsp;</p>
        <p><span class="text_title">活动场次：</span>2-8场</p>
        <p>&nbsp;</p>
        <p><span class="text_title">活动形式：</span>任意场次</p>
        <p>&nbsp;</p>
        <p><span class="text_title">报名时间：</span>由于报名人数不足暂不截止</p>
        <p>&nbsp;</p>
        <p><span class="text_title">报名方式：</span>登陆论坛进入足球竞猜送彩金版块，回复第一届竞波竞猜王进行报名。<span class="text_red"><a href="/bbs/viewthread.php?tid=3326&extra=page%3D1" target="_blank">点击进入报名</a></span></p>
        <p>&nbsp;</p>
        <p><span class="text_title">活动时间：</span>另行通知</p>
        <p>&nbsp;</p>
    <p><span class="text_title">活动具体规则：</span></p>
        <p>1、每位会员账户内均可获得10000竞波币作为初始投注虚拟币，通过虚拟币进行投注，每月评选出前3名用户进行奖励。</p>
        <p>2、竞猜的截止时间按第一场比赛的截止时间为准。</p>
        <p>3、每月至少消费10000竞波币且进行10天以上的投注，以防部分用户凭借初始虚拟币来参加评选。</p>
        <p>4、通过竞波币投注中奖奖金作为竞波币可继续用作接下来的投注使用。</p>
        <p>&nbsp;</p>
    <p><span class="text_title">评选标准:</span></p>
        <p>1、每月剩余竞波币最多的前3名用户将分别获得冠亚季军。</p>
        <p>2、参加评选的用户账号竞波币必须大于初始的10000竞波币。</p>
        <p>3、如本月无人中奖奖金将滚存至下期活动中。</p>
        <p>&nbsp;</p>
        <p><span class="text_title">活动奖励：</span></p>
        <p>每月奖项设置冠亚季军分别奖励：1、冠军：2000元彩金 2、亚军：1000元彩金 3、季军500元彩金。</p>
        <p>&nbsp;</p>
        <p>请各位尚未注册的用户，注册的时候完善个人资料，方便我们这边派奖。因没有完善个人资料而导致未领到彩金的用户，竞波网概不负责，这样防止多次领取。本活动最终解释权归竞波网所有 本次活动从4月10日开始。</p>
        <p>&nbsp;</p>
    <p><span class="text_title">参加活动方法：</span></p>
        <p>1、	登录自己的账号，完善账号内的个人详细资料</p>
        <p>2、	进入竞猜胜平负</p>
        <p><img src="<?php echo url::base();?>media/jcw1/images/step1.jpg" width="273px" height="129px" /></p>
        <p>点击进入<a href="<?php echo url::base();?>jczq_v/rqspf">虚拟投注</a>，开始参加活动</p>
        <p>3、	点击资金变动明细</p>
        <p><img src="<?php echo url::base();?>media/jcw1/images/step2.jpg" width="614px" height="709px"  /></p>
        <p>点击竞波币明细查询个人账户余额</p>
  </div>
    <div class="guess_bottom"></div>
</div>
<?php echo View::factory('footer')->render();?>
</body>
</html>