<? if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('notice');
0
|| checktplrefresh('D:\wwwphp\web\discuz\././templates/default/notice.htm', 'D:\wwwphp\web\discuz\././templates/default/personal_navbar.htm', 1312359848, '1', './templates/default')
;?><? include template('header', '0', ''); ?><div id="nav"><a href="<?=$indexname?>"><?=$bbname?></a> &raquo; 提醒</div>

<div id="wrap" class="wrap with_side s_clear">
<div class="main">
<div class="content">
<div class="itemtitle s_clear">
<h1>提醒</h1>
</div>

<div class="pm_header colplural itemtitle s_clear">
<ul>
<li<? if(!$filter) { ?> class="current"<? } ?>><a href="notice.php" hidefocus="true"><span>全部</span></a></li><? if(is_array($prompts)) { foreach($prompts as $promptkey => $promptdata) { if(!$promptdata['script']) { ?><li<? if($filter == $promptkey) { ?> class="current"<? } ?>><a href="notice.php?filter=<?=$promptkey?>"><span><?=$promptdata['name']?><? if($promptdata['new']) { ?>(<?=$promptdata['new']?>)<? } ?></span></a></li><? } } } ?></ul>
</ul>
</div>

<? if($pmlist) { ?>
<ul class="feed"><? if(is_array($pmlist)) { foreach($pmlist as $key => $pm) { ?><li class="s_clear"><?=$pm['message']?></li><? } } ?></ul>
<div><?=$multipage?></div>
<? } else { ?>
<p class="nodata">暂无数据</p>
<? } ?>
</div>
</div>
<div class="side"><h2>个人中心</h2>
<div class="sideinner">
<ul class="tabs">
<? if($regverify == 1 && $groupid == 8) { ?>
<li<? if(CURSCRIPT=='memcp' && $action == 'emailverify') { ?> class="current"<? } ?>><a href="member.php?action=emailverify">重新验证 Email</a></li>
<? } if($regverify == 2 && $groupid == 8) { ?>
<li<? if(CURSCRIPT=='memcp' && $action == 'validating') { ?> class="current"<? } ?>><a href="memcp.php?action=validating">账户审核</a></li>
<li<? if(CURSCRIPT=='memcp' && $action == 'profile' && $typeid == '2') { ?> class="current"<? } ?>><a href="memcp.php?action=profile&amp;typeid=2">个人资料</a></li>
<? } else { ?>
<li<? if(CURSCRIPT=='memcp' && $action == 'profile' && $typeid == '3') { ?> class="current"<? } ?>><a href="memcp.php?action=profile&amp;typeid=3" id="uploadavatar" prompt="uploadavatar">修改头像</a></li>
<li<? if(CURSCRIPT=='memcp' && $action == 'profile' && $typeid == '2') { ?> class="current"<? } ?>><a href="memcp.php?action=profile&amp;typeid=2">个人资料</a></li>
<li<? if(CURSCRIPT=='pm') { ?> class="current"<? } ?>><a href="pm.php">短消息</a></li>
<li<? if(CURSCRIPT=='notice') { ?> class="current"<? } ?>><a href="notice.php">提醒</a></li>
<li<? if(CURSCRIPT=='my' && $item == 'buddylist') { ?> class="current"<? } ?>><a href="my.php?item=buddylist&amp;<?=$extrafid?>">我的好友</a></li>
<? if($regstatus > 1) { ?><li><a href="invite.php">邀请注册</a></li><? } if($ucappopen['UCHOME']) { ?>
<li><a href="<?=$uchomeurl?>/space.php?uid=<?=$discuz_uid?>" target="_blank">我的空间</a></li>
<? } elseif($ucappopen['XSPACE']) { ?>
<li><a href="<?=$xspaceurl?>/?uid-<?=$discuz_uid?>" target="_blank">我的空间</a></li>
<? } } ?>
</ul>
</div>

<? if($groupid != 8) { ?>
<hr class="shadowline" />

<div class="sideinner">
<ul class="tabs">
<li<? if(CURSCRIPT=='my' && in_array($item, array('threads', 'posts', 'polls', 'reward', 'activities', 'debate', 'buytrades', 'tradethreads', 'selltrades', 'tradestats'))) { ?> class="current"<? } ?>><a href="my.php?item=threads<?=$extrafid?>">我的帖子</a></li>
<li<? if(CURSCRIPT=='my' && $item == 'favorites') { ?> class="current"<? } ?>><a href="my.php?item=favorites&amp;type=thread<?=$extrafid?>">我的收藏</a></li>
<li<? if(CURSCRIPT=='my' && $item == 'attention') { ?> class="current"<? } ?>><a href="my.php?item=attention&amp;type=thread<?=$extrafid?>">我的关注</a></li>
<? if(!empty($plugins['plinks_my'])) { if(is_array($plugins['plinks_my'])) { foreach($plugins['plinks_my'] as $module) { if(!$module['adminid'] || ($module['adminid'] && $adminid > 0 && $module['adminid'] >= $adminid)) { ?><li<? if(CURSCRIPT == 'plugin' && $_GET['id'] == $module['id']) { ?> class="current"<? } ?>><?=$module['url']?></li><? } } } } ?>
</ul>
</div>

<hr class="shadowline" />

<div class="sideinner">
<ul class="tabs">
<li<? if(CURSCRIPT=='memcp' && $action == 'credits') { ?> class="current"<? } ?>><a href="memcp.php?action=credits">积分</a></li>
<li<? if(CURSCRIPT=='memcp' && $action == 'usergroups') { ?> class="current"<? } ?>><a href="memcp.php?action=usergroups">用户组</a></li>
<li<? if(CURSCRIPT=='task') { ?> class="current"<? } ?>><a href="task.php">论坛任务</a></li>
<? if($medalstatus) { ?><li<? if(CURSCRIPT=='medal') { ?> class="current"<? } ?>><a href="medal.php">勋章</a></li><? } if($magicstatus) { ?><li<? if(CURSCRIPT=='magic') { ?> class="current"<? } ?>><a href="magic.php">道具</a></li><? } if(!empty($plugins['plinks_tools'])) { if(is_array($plugins['plinks_tools'])) { foreach($plugins['plinks_tools'] as $module) { if(!$module['adminid'] || ($module['adminid'] && $adminid > 0 && $module['adminid'] >= $adminid)) { ?><li<? if(CURSCRIPT == 'plugin' && $_GET['id'] == $module['id']) { ?> class="current"<? } ?>><?=$module['url']?></li><? } } } } ?>
</ul>
</div>
<? } ?>

<hr class="shadowline" />

<div class="sideinner">
<ul class="tabs">
<li<? if(CURSCRIPT=='memcp' && $action == 'profile' && $typeid == '5') { ?> class="current"<? } ?>><a href="memcp.php?action=profile&amp;typeid=5">论坛个性化设定</a></li>
<li<? if(CURSCRIPT=='memcp' && $action == 'profile' && $typeid == '1') { ?> class="current"<? } ?>><a href="memcp.php?action=profile&amp;typeid=1">密码和安全问题</a></li>
</ul>
</div>

<hr class="shadowline" />

<div class="sideinner">
<ul class="tabs">
<li>积分: <?=$credits?></li><? if(is_array($extcredits)) { foreach($extcredits as $id => $credit) { ?><li><?=$credit['title']?>: <?=$GLOBALS['extcredits'.$id]?> <?=$credit['unit']?></li><? } } ?></ul>
</div>
<?=$pluginhooks['memcp_side']?></div>

</div><? include template('footer', '0', ''); ?>