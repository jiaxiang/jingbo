<? if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('viewpro_classic');
0
|| checktplrefresh('D:\wwwphp\web\discuz\././templates/default/viewpro_classic.htm', 'D:\wwwphp\web\discuz\././templates/default/header.htm', 1312438079, '1', './templates/default')
|| checktplrefresh('D:\wwwphp\web\discuz\././templates/default/viewpro_classic.htm', 'D:\wwwphp\web\discuz\././templates/default/footer.htm', 1312438079, '1', './templates/default')
|| checktplrefresh('D:\wwwphp\web\discuz\././templates/default/viewpro_classic.htm', 'D:\wwwphp\web\discuz\././templates/default/jsmenu.htm', 1312438079, '1', './templates/default')
;?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$charset?>" />
<title><?=$navtitle?> <?=$bbname?> <?=$seotitle?> - Powered by Discuz!</title>
<?=$seohead?>
<meta name="keywords" content="<?=$metakeywords?><?=$seokeywords?>" />
<meta name="description" content="<?=$metadescription?> <?=$bbname?> <?=$seodescription?> - Discuz! Board" />
<meta name="generator" content="Discuz! <?=$version?>" />
<meta name="author" content="Discuz! Team and Comsenz UI Team" />
<meta name="copyright" content="2001-2009 Comsenz Inc." />
<meta name="MSSmartTagsPreventParsing" content="True" />
<meta http-equiv="MSThemeCompatible" content="Yes" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<link rel="archives" title="<?=$bbname?>" href="<?=$boardurl?>archiver/" />
<?=$rsshead?>
<?=$extrahead?><link rel="stylesheet" type="text/css" href="forumdata/cache/style_<?=STYLEID?>_common.css?<?=VERHASH?>" /><link rel="stylesheet" type="text/css" href="forumdata/cache/scriptstyle_<?=STYLEID?>_<?=CURSCRIPT?>.css?<?=VERHASH?>" />
<? if($forum['ismoderator']) { ?>
<link href="forumdata/cache/style_1_moderator.css?q94" rel="stylesheet" type="text/css" />
<? } ?><script type="text/javascript">var STYLEID = '<?=STYLEID?>', IMGDIR = '<?=IMGDIR?>', VERHASH = '<?=VERHASH?>', charset = '<?=$charset?>', discuz_uid = <?=$discuz_uid?>, cookiedomain = '<?=$cookiedomain?>', cookiepath = '<?=$cookiepath?>', attackevasive = '<?=$attackevasive?>', disallowfloat = '<?=$disallowfloat?>', creditnotice = '<? if($creditnotice) { ?><?=$creditnames?><? } ?>', <? if(in_array(CURSCRIPT, array('viewthread', 'forumdisplay'))) { ?>gid = parseInt('<?=$thisgid?>')<? } elseif(CURSCRIPT == 'index') { ?>gid = parseInt('<?=$gid?>')<? } else { ?>gid = 0<? } ?>, fid = parseInt('<?=$fid?>'), tid = parseInt('<?=$tid?>')</script>
<script src="<?=$jspath?>common.js?<?=VERHASH?>" type="text/javascript"></script>
</head>

<body id="<?=CURSCRIPT?>" onkeydown="if(event.keyCode==27) return false;">

<div id="append_parent"></div><div id="ajaxwaitid"></div>

<div id="header">
<div class="wrap s_clear">
<h2><a href="<?=$indexname?>" title="<?=$bbname?>"><?=BOARDLOGO?></a></h2>
<div id="umenu">
<? if($discuz_uid) { ?>
<cite><a href="space.php?uid=<?=$discuz_uid?>" class="noborder"><?=$discuz_userss?></a><? if($allowinvisible) { ?><span id="loginstatus"><? if(!empty($invisible)) { ?><a href="member.php?action=switchstatus" onclick="ajaxget(this.href, 'loginstatus');doane(event);">隐身</a><? } else { ?><a href="member.php?action=switchstatus" title="我要隐身" onclick="ajaxget(this.href, 'loginstatus');doane(event);">在线</a><? } ?></span><? } ?></cite>
<span class="pipe">|</span>
<? if($ucappopen['UCHOME']) { ?>
<a href="<?=$uchomeurl?>/space.php?uid=<?=$discuz_uid?>" target="_blank">空间</a>
<? } elseif($ucappopen['XSPACE']) { ?>
<a href="<?=$xspaceurl?>/?uid-<?=$discuz_uid?>" target="_blank">空间</a>
<? } ?>
<a id="myprompt" href="notice.php" <? if($prompt) { ?>class="new" onmouseover="showMenu({'ctrlid':this.id})"<? } ?>>提醒</a>
<span id="myprompt_check"></span>
<a href="pm.php" id="pm_ntc" target="_blank">短消息</a>
<? if($taskon) { ?>
<a id="task_ntc" <? if($doingtask) { ?>href="task.php?item=doing" class="new" title="您有未完成的任务"<? } else { ?>href="task.php"<? } ?> target="_blank">论坛任务</a>
<? } ?>

<span class="pipe">|</span>
<a href="memcp.php">个人中心</a>
<? if($discuz_uid && $adminid > 1) { ?><a href="modcp.php?fid=<?=$fid?>" target="_blank">管理面板</a><? } if($discuz_uid && $adminid == 1) { ?><a href="admincp.php" target="_blank">管理中心</a><? } ?>
<a href="logging.php?action=logout&amp;formhash=<?=FORMHASH?>">退出</a>
<? } elseif(!empty($_DCOOKIE['loginuser'])) { ?>
<cite><a id="loginuser" class="noborder"><?=$_DCOOKIE['loginuser']?></a></cite>
<a href="logging.php?action=login" onclick="showWindow('login', this.href);return false;">激活</a>
<a href="logging.php?action=logout&amp;formhash=<?=FORMHASH?>">退出</a>
<? } else { ?>
<a href="<?=$regname?>" onclick="showWindow('register', this.href);return false;" class="noborder"><?=$reglinkname?></a>
<a href="logging.php?action=login" onclick="showWindow('login', this.href);return false;">登录</a>
<? } ?>
</div>
<div id="ad_headerbanner"><? if($admode && !empty($advlist['headerbanner'])) { ?><?=$advlist['headerbanner']?><? } ?></div>
<div id="menu">
<ul>
<? if($_DCACHE['settings']['frameon'] > 0) { ?>
<li>
<span class="frameswitch">
<script type="text/javascript">
if(top == self) {
<? if(($_DCACHE['settings']['frameon'] == 2 && !defined('CACHE_FILE') && in_array(CURSCRIPT, array('index', 'forumdisplay', 'viewthread')) && (($_DCOOKIE['frameon'] == 'yes' && $_GET['frameon'] != 'no') || (empty($_DCOOKIE['frameon']) && empty($_GET['frameon']))))) { ?>
top.location = 'frame.php?frameon=yes&referer='+escape(self.location);
<? } ?>
document.write('<a href="frame.php?frameon=yes" target="_top" class="frameon">分栏模式<\/a>');
} else {
document.write('<a href="frame.php?frameon=no" target="_top" class="frameoff">平板模式<\/a>');
}
</script>
</span>
</li>
<? } if(is_array($navs)) { foreach($navs as $id => $nav) { if($id == 3) { if(!empty($plugins['jsmenu'])) { ?>
<?=$nav['nav']?>
<? } if(!empty($plugins['links'])) { if(is_array($plugins['links'])) { foreach($plugins['links'] as $module) { if(!$module['adminid'] || ($module['adminid'] && $adminid > 0 && $module['adminid'] >= $adminid)) { ?><li><?=$module['url']?></li><? } } } } } else { if(!$nav['level'] || ($nav['level'] == 1 && $discuz_uid) || ($nav['level'] == 2 && $adminid > 0) || ($nav['level'] == 3 && $adminid == 1)) { ?><?=$nav['nav']?><? } } } } if(in_array($BASEFILENAME, $navmns)) { $mnid = $BASEFILENAME; } elseif($navmngs[$BASEFILENAME]) { if(is_array($navmngs[$BASEFILENAME])) { foreach($navmngs[$BASEFILENAME] as $navmng) { if($navmng['0'] == array_intersect_assoc($navmng['0'], $_GET)) { $mnid = $navmng['1']; } } } } ?>
</ul>
<script type="text/javascript">
var currentMenu = $('mn_<?=$mnid?>') ? $('mn_<?=$mnid?>') : $('mn_<?=$navmns['0']?>');
currentMenu.parentNode.className = 'current';
</script>
</div>
<? if(!empty($stylejumpstatus)) { ?>
<script type="text/javascript">
function setstyle(styleid) {
str = unescape('<? echo str_replace("'", "\\'", urlencode($_SERVER['QUERY_STRING'])); ?>');
str = str.replace(/(^|&)styleid=\d+/ig, '');
str = (str != '' ? str + '&' : '') + 'styleid=' + styleid;
location.href = '<?=$BASESCRIPT?>?' + str;
}
</script>
<ul id="style_switch"><? if(is_array($styles)) { foreach($styles as $id => $stylename) { ?><li<? if($id == STYLEID) { ?> class="current"<? } ?>><a href="###" onclick="setstyle(<?=$id?>)" title="<?=$stylename?>" style="background: <?=$styleicons[$id]?>;"><?=$stylename?></a></li><? } } ?></ul>
<? } ?>
</div>
<div id="myprompt_menu" style="display:none" class="promptmenu">
<div class="promptcontent">
<ul class="s_clear"><? if(is_array($prompts)) { foreach($prompts as $promptkey => $promptdata) { if($promptkey) { ?><li<? if(!$promptdata['new']) { ?> style="display:none"<? } ?>><a id="prompt_<?=$promptkey?>" href="<? if($promptdata['script']) { ?><?=$promptdata['script']?><? } else { ?>notice.php?filter=<?=$promptkey?><? } ?>" target="_blank"><?=$promptdata['name']?> (<?=$promptdata['new']?>)</a></li><? } } } ?></ul>
</div>
</div>
</div>
<?=$pluginhooks['global_header']?><div id="nav"><a href="<?=$indexname?>"><?=$bbname?></a> &raquo; <? if($discuz_uid == $member['uid']) { ?>我的资料<? } else { ?><?=$member['username']?>的个人资料<? } ?></div>

<script type="text/javascript">var imagemaxwidth = '<?=IMAGEMAXWIDTH?>';</script>

<div id="wrap" class="wrap with_side special s_clear">
<div class="main">
<div id="profilecontent" class="content">
<div class="itemtitle s_clear">
<h1><?=$member['username']?><? if($member['online']) { ?> <img src="<?=IMGDIR?>/online_buddy.gif" title="当前在线" class="online_buddy" /><? } ?></h1>
<ul>
<li>(UID: <?=$member['uid']?>)</li>
</ul>
</div>
<?=$pluginhooks['profile_baseinfo_top']?>
<div id="baseprofile">
<table cellpadding="0" cellpadding="0" class="formtable" style="table-layout:fixed">
<? if($member['allownickname'] && $member['nickname']) { ?>
<tr>
<th>昵称:</th>
<td><?=$member['nickname']?></td>
</tr>
<? } ?>
<tr>
<th width="70">性别:</th>
<td>
<? if($member['gender'] == 1) { ?>男<? } elseif($member['gender'] == 2) { ?>女<? } else { ?>保密<? } ?>
</td>
</tr>

<? if($member['location']) { ?>
<tr>
<th width="70">来自:</th>
<td>
 <?=$member['location']?>
</td>
</tr>
<? } if($member['bday'] != '00-00') { ?>
<tr>
<th width="70">生日:</th>
<td>
<?=$member['bday']?>
</td>
</tr>
<? } if($member['bio']) { ?>
<tr>
<th>自我介绍:</th>
<td style="word-break:all"><?=$member['bio']?></td>
</tr>
<? } ?>
</table>
<table cellpadding="0" cellpadding="0" class="formtable">
<? if($member['site']) { ?>
<tr>
<th>个人网站:</th>
<td><a href="<?=$member['site']?>" target="_blank"><?=$member['site']?></a></td>
</tr>
<? } if($member['showemail'] && $adminid > 0) { ?>
<tr>
<th>Email:</th>
<td><?=$member['email']?></td>
</tr>
<? } if($member['qq']) { ?>
<tr>
<th>QQ:</th>
<td><a href="http://wpa.qq.com/msgrd?V=1&amp;Uin=<?=$member['qq']?>&amp;Site=<?=$bbname?>&amp;Menu=yes" target="_blank"><img src="http://wpa.qq.com/pa?p=1:<?=$member['qq']?>:4"  border="0" alt="QQ" /><?=$member['qq']?></a></td>
</tr>
<? } if($member['icq']) { ?>
<tr>
<th>ICQ:</th>
<td><?=$member['icq']?></td>
</tr>
<? } if($member['yahoo']) { ?>
<tr>
<th>Yahoo:</th>
<td><?=$member['yahoo']?></td>
</tr>
<? } if($member['msn']) { ?>
<tr>
<th>MSN:</th>
<td><? if($member['msn']['1']) { ?><a target="_blank" href="http://settings.messenger.live.com/Conversation/IMMe.aspx?invitee=<?=$member['msn']['1']?>@apps.messenger.live.com&amp;mkt=zh-cn" title="MSN 聊天"><img style="vertical-align:middle" src="http://messenger.services.live.com/users/<?=$member['msn']['1']?>@apps.messenger.live.com/presenceimage?mkt=zh-cn" width="16" height="16" /><em id="imme_status_<?=$member['msn']['1']?>">MSN 聊天</em></a><script src="http://messenger.services.live.com/users/<?=$member['msn']['1']?>@apps.messenger.live.com/presence/?cb=showimmestatus" type="text/javascript"></script><? } if($member['msn']['0']) { ?> <?=$member['msn']['0']?><? } ?></td>
</tr>
<? } if($member['taobao']) { ?>
<tr>
<th>阿里旺旺:</th>
<td><script type="text/javascript">document.write('<a target="_blank" href="http://amos1.taobao.com/msg.ww?v=2&amp;uid='+encodeURIComponent('<?=$member['taobaoas']?>')+'&amp;s=2"><img src="http://amos1.taobao.com/online.ww?v=2&amp;uid='+encodeURIComponent('<?=$member['taobaoas']?>')+'&amp;s=1" alt="阿里旺旺" border="0" /></a>&nbsp;');</script></td>
</tr>
<? } if($member['alipay']) { ?>
<tr>
<th>支付宝账号:</th>
<td><?=$member['alipay']?></td>
</tr>
<? } if(is_array($_DCACHE['fields'])) { foreach($_DCACHE['fields'] as $field) { ?><tr>
<th><?=$field['title']?>:</th>
<td>
<? if($field['selective']) { ?>
<?=$field['choices'][$member['field_'.$field['fieldid']]]?>
<? } else { ?>
<?=$member['field_'.$field['fieldid']]?>
<? } ?>
&nbsp;
</td>
</tr><? } } ?></table>
</div>
<?=$pluginhooks['profile_baseinfo_bottom']?>
<hr class="dashline" />

<h3 class="blocktitle lightlink">用户组: <a href="faq.php?action=grouppermission&amp;searchgroupid=<?=$member['groupid']?>" target="_blank"><?=$member['grouptitle']?></a> <? showstars($member['groupstars']); ?> <? if($member['maingroupexpiry']) { ?><em>有效期至 <?=$member['maingroupexpiry']?></em><? } ?></h3>
<? if($extgrouplist) { ?>
<p>扩展用户组:<? if(is_array($extgrouplist)) { foreach($extgrouplist as $extgroup) { ?><?=$extgroup['title']?><? if($extgroup['expiry']) { ?>&nbsp;(有效期至 <?=$extgroup['expiry']?>)<? } } } ?></p>
<? } if($modforums) { ?><p>管理以下版块: <?=$modforums?></p><? } ?>
<div class="s_clear">
<ul class="commonlist right" style="width: 50%">
<li>注册日期: <?=$member['regdate']?></li>
<li>上次访问: <? if($member['invisible'] && $adminid != 1) { ?>隐身<? } else { ?><?=$member['lastvisit']?><? } ?></li>
<li>最后发表: <?=$member['lastpost']?></li>
<? if($discuz_uid == $member['uid'] || $allowviewip) { ?>
<li>注册 IP: <?=$member['regip']?> - <?=$member['regiplocation']?></li>
<li>上次访问 IP: <?=$member['lastip']?> - <?=$member['lastiplocation']?></li>
<? } ?>
</ul>
<ul class="commonlist">
<li>发帖数级别: <?=$member['ranktitle']?> <? showstars($member['rankstars']); ?></li>
<li>阅读权限: <?=$member['readaccess']?></li>
<li>帖子: <?=$member['posts']?> 篇(占全部帖子的 <?=$percent?>%)</li>
<li>平均每日发帖: <?=$postperday?> 篇</li>
<li>精华: <?=$member['digestposts']?> 篇</li>
<? if($pvfrequence) { ?><li>页面访问量: <?=$member['pageviews']?></li><? } ?>
</ul>
</div>
<? if($oltimespan) { ?><p>在线时间: 总计在线 <em><?=$member['totalol']?></em> 小时, 本月在线 <em><?=$member['thismonthol']?></em> 小时 <? showstars(ceil(($member['totalol'] + 1) / 50)); ?> (升级剩余时间 <span class="bold"><?=$member['olupgrade']?></span> 小时)</p><? } ?>

<hr class="dashline" />

<? if($member['medals']) { ?>
<h3 class="blocktitle lightlink">勋章</h3><? if(is_array($member['medals'])) { foreach($member['medals'] as $medal) { ?><img src="images/common/<?=$medal['image']?>" border="0" alt="<?=$medal['name']?>" title="<?=$medal['name']?>" /> &nbsp;<? } } ?><hr class="dashline" />
<? } ?>

<h3 class="blocktitle lightlink">积分: <?=$member['credits']?></h3>
<p><? $sp = ''; if(is_array($extcredits)) { foreach($extcredits as $id => $credit) { ?><?=$sp?><?=$credit['img']?><?=$credit['title']?>: <?=$member['extcredits'.$id]?> <?=$credit['unit']?><? $sp = ',&nbsp;'; } } ?></p>
<? if($tradeopen) { ?>
<hr class="dashline" />

<h3 class="blocktitle lightlink">信用评价 <a href="eccredit.php?uid=<?=$member['uid']?>" style="font-size: 12px; color: #09C;">(查看详细的信用记录)</a></h3>
<p>
买家信用评价: <?=$member['sellercredit']?> <a href="eccredit.php?uid=<?=$member['uid']?>" target="_blank"><img src="images/rank/seller/<?=$member['sellerrank']?>.gif" border="0" class="absmiddle"></a>
卖家信用评价: <?=$member['buyercredit']?> <a href="eccredit.php?uid=<?=$member['uid']?>" target="_blank"><img src="images/rank/buyer/<?=$member['buyerrank']?>.gif" border="0" class="absmiddle"></a>
</p>
<? } ?>
<?=$pluginhooks['profile_extrainfo']?>

<? if($my_status) { ?>
<style>
.mynarrow { margin: 5px -10px 5px 10px; padding-top: 8px; width: 200px; border-top: 1px dashed #ccc; }
.mynarrow h3.lightlink a { text-decoration: none; }
.with_side .side { width: 220px; }
.with_side .main { margin-left:-220px; }
.with_side .content { margin-left:220px; }
</style><? if(is_array($my_list['wide'])) { foreach($my_list['wide'] as $value) { ?><hr class="dashline" />
<h3 class="blocktitle lightlink"><a href="<?=$value['appurl']?>&from=space"><?=$value['appname']?></a></h3>
<p><? eval($value['myml']); ?></p><? } } } ?>
</div>
</div>
<div class="side">
<div class="profile_side">
<? if($bannedmessages & 2 && ($member['groupid'] == 4 || $member['groupid'] == 5)) { ?>
<div class="avatar">头像被屏蔽</div>
<? } else { ?>
<div class="avatar"><? echo discuz_uc_avatar($member['uid']); ?></div>
<? } ?>
<ul id="profile_act">
<?=$pluginhooks['profile_side_top']?>
<li class="pm"><a href="pm.php?action=new&amp;uid=<?=$member['uid']?>" id="sendpm" prompt="sendpm" onclick="showWindow('sendpm', this.href);return false;">发短消息</a></li>
<li class="buddy"><a href="my.php?item=buddylist&amp;newbuddyid=<?=$member['uid']?>&amp;buddysubmit=yes" id="addbuddy" prompt="addbuddy" onclick="ajaxmenu(this, 3000);doane(event);">加为好友</a></li>
<? if($discuz_uid && $magicstatus) { ?><li class="magic"><a href="magic.php?action=index&amp;username=<?=$member['usernameenc']?>" target="_blank">使用道具</a></li><? } if($allowviewuserthread) { ?>
<li class="searchthread"><a href="my.php?item=threads&amp;uid=<?=$member['uid']?>">查看主题</a></li>
<li class="searchpost"><a href="my.php?item=posts&amp;uid=<?=$member['uid']?>">查看回复</a></li>
<? } else { ?>
<li class="searchpost"><a href="search.php?srchuid=<?=$member['uid']?>&amp;srchfid=all&amp;srchfrom=0&amp;searchsubmit=yes">搜索帖子</a></li>
<? } if($ucappopen['UCHOME']) { ?>
<li class="space"><a href="<?=$uchomeurl?>/space.php?uid=<?=$member['uid']?>" target="_blank">个人空间</a></li>
<? } elseif($ucappopen['XSPACE']) { ?>
<li class="space"><a href="<?=$xspaceurl?>/?uid-<?=$member['uid']?>" target="_blank">个人空间</a></li>
<? } ?>
</ul>
<? if($discuz_uid && $magicstatus && $usemagic['user']) { ?>
<ul><? if(is_array($usemagic['user'])) { foreach($usemagic['user'] as $id => $magic) { ?><a href="magic.php?action=mybox&amp;operation=use&amp;type=1&amp;pid=<?=$post['pid']?>&amp;magicid=<?=$id?>" onclick="showWindow('magics', this.href);doane(event);"><img src="images/magics/<?=$magic['pic']?>" title="对<?=$post['author']?>使用<?=$magic['name']?>"></a><? } } ?></ul>
<? } if($allowbanuser || $allowedituser || $member['adminid'] > 0 && $modworkstatus) { ?>
<ul>
<? if($member['adminid'] > 0 && $modworkstatus) { ?><li><a href="stats.php?type=modworks&amp;uid=<?=$member['uid']?>"><span>工作统计</span></a></li><? } if($allowbanuser || $allowedituser) { ?>
<li>管理此人</li>
<li>
<? if($allowbanuser) { ?><a href="<? if($adminid==1) { ?>admincp.php?action=members&operation=ban&username=<?=$member['usernameenc']?>&frames=yes<? } else { ?>modcp.php?action=members&amp;op=ban&amp;uid=<?=$member['uid']?><? } ?>" target="_blank"><span>禁止</span></a>&nbsp;<? } if($allowedituser) { ?><a href="<? if($adminid == 1) { ?>admincp.php?action=members&amp;username=<?=$member['usernameenc']?>&amp;submit=yes&frames=yes<? } else { ?>modcp.php?action=members&amp;op=edit&amp;uid=<?=$member['uid']?><? } ?>" target="_blank"><span>编辑</span></a>&nbsp;<? } ?>
<a href="modcp.php?action=threads&amp;op=posts&amp;do=search&amp;searchsubmit=1&amp;users=<?=$member['usernameenc']?>" target="_blank">帖子</a>
</li>
<? } ?>
</ul>
<? } if($my_status) { if($my_list['guide']) { ?>
<ul><? if(is_array($my_list['guide'])) { foreach($my_list['guide'] as $value) { ?><li style="background-image: url(http://appicon.manyou.com/icons/<?=$value['appid']?>)"><? eval($value['profilelink']); ?></li><? } } ?></ul>
<? } if(is_array($my_list['narrow'])) { foreach($my_list['narrow'] as $value) { ?><div class="mynarrow">
<h3 class="blocktitle lightlink"><a href="<?=$value['appurl']?>&from=space"><?=$value['appname']?></a></h3><? eval($value['myml']); ?></div><? } } } ?>
</div>
<?=$pluginhooks['profile_side_bottom']?>
</div>
</div><? if(!empty($plugins['jsmenu'])) { ?>
<ul class="popupmenu_popup headermenu_popup" id="plugin_menu" style="display: none"><? if(is_array($plugins['jsmenu'])) { foreach($plugins['jsmenu'] as $module) { ?>     <? if(!$module['adminid'] || ($module['adminid'] && $adminid > 0 && $module['adminid'] >= $adminid)) { ?>
     <li><?=$module['url']?></li>
     <? } } } ?></ul>
<? } if(is_array($subnavs)) { foreach($subnavs as $subnav) { ?><?=$subnav?><? } } if($prompts['newbietask'] && $newbietasks) { include template('task_newbie_js', '0', ''); } if($admode && !empty($advlist)) { ?>
<div class="ad_footerbanner" id="ad_footerbanner1"><?=$advlist['footerbanner1']?></div><? if($advlist['footerbanner2']) { ?><div class="ad_footerbanner" id="ad_footerbanner2"><?=$advlist['footerbanner2']?></div><? } if($advlist['footerbanner3']) { ?><div class="ad_footerbanner" id="ad_footerbanner3"><?=$advlist['footerbanner3']?></div><? } } else { ?>
<div id="ad_footerbanner1"></div><div id="ad_footerbanner2"></div><div id="ad_footerbanner3"></div>
<? } ?>

<?=$pluginhooks['global_footer']?>
<div id="footer">
<div class="wrap s_clear">
<div id="footlink">
<p>
<strong><a href="<?=$siteurl?>" target="_blank"><?=$sitename?></a></strong>
<? if($icp) { ?>( <a href="http://www.miibeian.gov.cn/" target="_blank"><?=$icp?></a>)<? } ?>
<span class="pipe">|</span><a href="mailto:<?=$adminemail?>">联系我们</a>
<? if($allowviewstats) { ?><span class="pipe">|</span><a href="stats.php">论坛统计</a><? } if($archiverstatus) { ?><span class="pipe">|</span><a href="archiver/" target="_blank">Archiver</a><? } if($wapstatus) { ?><span class="pipe">|</span><a href="wap/" target="_blank">WAP</a><? } if($statcode) { ?><span class="pipe">| <?=$statcode?></span><? } ?>
<?=$pluginhooks['global_footerlink']?>
</p>
<p class="smalltext">
GMT<?=$timenow['offset']?>, <?=$timenow['time']?>
<? if(debuginfo()) { ?>, <span id="debuginfo">Processed in <?=$debuginfo['time']?> second(s), <?=$debuginfo['queries']?> queries<? if($gzipcompress) { ?>, Gzip enabled<? } ?></span><? } ?>.
</p>
</div>
<div id="rightinfo">
<p>Powered by <strong><a href="http://www.discuz.net" target="_blank">Discuz!</a></strong> <em><?=$version?></em><? if(!empty($boardlicensed)) { ?> <a href="http://license.comsenz.com/?pid=1&amp;host=<?=$_SERVER['HTTP_HOST']?>" target="_blank">Licensed</a><? } ?></p>
<p class="smalltext">&copy; 2001-2009 <a href="http://www.comsenz.com" target="_blank">Comsenz Inc.</a></p>
</div><? updatesession(); ?></div>
</div>
<? if($_DCACHE['settings']['frameon'] && in_array(CURSCRIPT, array('index', 'forumdisplay', 'viewthread')) && $_DCOOKIE['frameon'] == 'yes') { ?>
<script src="<?=$jspath?>iframe.js?<?=VERHASH?>" type="text/javascript"></script>
<? } output(); ?></body>
</html>