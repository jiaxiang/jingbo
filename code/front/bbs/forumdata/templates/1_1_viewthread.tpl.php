<? if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('viewthread');
0
|| checktplrefresh('D:\wwwphp\web\caipiao\code\front\bbs\././templates/default/viewthread.htm', 'D:\wwwphp\web\caipiao\code\front\bbs\././templates/default/header.htm', 1314755998, '1', './templates/default')
|| checktplrefresh('D:\wwwphp\web\caipiao\code\front\bbs\././templates/default/viewthread.htm', 'D:\wwwphp\web\caipiao\code\front\bbs\././templates/default/viewthread_node.htm', 1314755998, '1', './templates/default')
|| checktplrefresh('D:\wwwphp\web\caipiao\code\front\bbs\././templates/default/viewthread.htm', 'D:\wwwphp\web\caipiao\code\front\bbs\././templates/default/viewthread_fastpost.htm', 1314755998, '1', './templates/default')
|| checktplrefresh('D:\wwwphp\web\caipiao\code\front\bbs\././templates/default/viewthread.htm', 'D:\wwwphp\web\caipiao\code\front\bbs\././templates/default/footer.htm', 1314755998, '1', './templates/default')
|| checktplrefresh('D:\wwwphp\web\caipiao\code\front\bbs\././templates/default/viewthread.htm', 'D:\wwwphp\web\caipiao\code\front\bbs\././templates/default/viewthread_pay.htm', 1314755998, '1', './templates/default')
|| checktplrefresh('D:\wwwphp\web\caipiao\code\front\bbs\././templates/default/viewthread.htm', 'D:\wwwphp\web\caipiao\code\front\bbs\././templates/default/seditor.htm', 1314755998, '1', './templates/default')
|| checktplrefresh('D:\wwwphp\web\caipiao\code\front\bbs\././templates/default/viewthread.htm', 'D:\wwwphp\web\caipiao\code\front\bbs\././templates/default/jsmenu.htm', 1314755998, '1', './templates/default')
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
<link href="forumdata/cache/style_1_moderator.css?MVR" rel="stylesheet" type="text/css" />
<? } ?><script type="text/javascript">var STYLEID = '<?=STYLEID?>', IMGDIR = '<?=IMGDIR?>', VERHASH = '<?=VERHASH?>', charset = '<?=$charset?>', discuz_uid = <?=$discuz_uid?>, cookiedomain = '<?=$cookiedomain?>', cookiepath = '<?=$cookiepath?>', attackevasive = '<?=$attackevasive?>', disallowfloat = '<?=$disallowfloat?>', creditnotice = '<? if($creditnotice) { ?><?=$creditnames?><? } ?>', <? if(in_array(CURSCRIPT, array('viewthread', 'forumdisplay'))) { ?>gid = parseInt('<?=$thisgid?>')<? } elseif(CURSCRIPT == 'index') { ?>gid = parseInt('<?=$gid?>')<? } else { ?>gid = 0<? } ?>, fid = parseInt('<?=$fid?>'), tid = parseInt('<?=$tid?>')</script>
<script src="<?=$jspath?>common.js?<?=VERHASH?>" type="text/javascript"></script>
</head>

<body id="<?=CURSCRIPT?>" onkeydown="if(event.keyCode==27) return false;">

<div id="append_parent"></div><div id="ajaxwaitid"></div>

<div id="header">
<div class="wrap s_clear">
<h2><a href="http://caipiao.surbiz.com/" title="<?=$bbname?>"><?=BOARDLOGO?></a></h2>
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
<a href="http://caipiao.surbiz.com/user/register"  class="noborder"><?=$reglinkname?></a>
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
<?=$pluginhooks['global_header']?><? if($forum['ismoderator']) { ?>
<script src="<?=$jspath?>moderate.js?<?=VERHASH?>" type="text/javascript"></script>
<? } if($thread['special']) { ?>
<link rel="stylesheet" type="text/css" href="forumdata/cache/style_<?=STYLEID?>_special.css?<?=VERHASH?>" />
<? } ?>

<script src="<?=$jspath?>viewthread.js?<?=VERHASH?>" type="text/javascript"></script>
<script type="text/javascript">zoomstatus = parseInt(<?=$zoomstatus?>);var imagemaxwidth = '<?=IMAGEMAXWIDTH?>';var aimgcount = new Array();</script>

<div id="nav">
<? if($forumjump == 1) { ?><a href="<?=$indexname?>" id="fjump" onmouseover="showMenu({'ctrlid':this.id})" class="dropmenu"><?=$bbname?></a><? } else { ?><a href="<?=$indexname?>"><?=$bbname?></a><? } ?><?=$navigation?>
</div>

<?=$pluginhooks['viewthread_top']?>

<? if($admode && !empty($advlist['text'])) { ?><div class="ad_text" id="ad_text"><table summary="Text Ad" cellpadding="0" cellspacing="1"><?=$advlist['text']?></table></div><? } else { ?><div id="ad_text"></div><? } if($forum['ismoderator']) { ?>
<ul class="popupmenu_popup headermenu_popup inlinelist" id="modopt_menu" style="width: 180px; display: none"><? $modopt=0; if($thread['digest'] >= 0) { if($allowdelpost) { $modopt++ ?><li class="wide"><a href="javascript:;" onclick="modthreads(3, 'delete')">删除主题</a></li><? } if($allowbumpthread) { $modopt++ ?><li class="wide"><a href="javascript:;" onclick="modthreads(3, 'down')">提升下沉</a></li><? } if($allowstickthread && ($thread['displayorder'] <= 3 || $adminid == 1)) { $modopt++ ?><li class="wide"><a href="javascript:;" onclick="modthreads(1, 'stick')">主题置顶</a></li><? } if($allowhighlightthread) { $modopt++ ?><li class="wide"><a href="javascript:;" onclick="modthreads(1, 'highlight')">高亮显示</a></li><? } if($allowdigestthread) { $modopt++ ?><li class="wide"><a href="javascript:;" onclick="modthreads(1, 'digest')">设置精华</a></li><? } if($allowrecommendthread && $forum['modrecommend']['open'] && $forum['modrecommend']['sort'] != 1) { $modopt++ ?><li class="wide"><a href="javascript:;" onclick="modthreads(1, 'recommend')">推荐主题</a></li><? } if($allowstampthread) { $modopt++ ?><li class="wide"><a href="javascript:;" onclick="modaction('stamp')">主题鉴定</a></li><? } if($allowclosethread) { $modopt++ ?><li class="wide"><a href="javascript:;" onclick="modthreads(4)">关闭打开</a></li><? } if($allowmovethread) { $modopt++ ?><li class="wide"><a href="javascript:;" onclick="modthreads(2, 'move')">移动主题</a></li><? } if($allowedittypethread) { $modopt++ ?><li class="wide"><a href="javascript:;" onclick="modthreads(2, 'type')">主题分类</a></li><? } if(!$thread['special']) { if($allowcopythread) { $modopt++ ?><li class="wide"><a href="javascript:;" onclick="modaction('copy')">复制主题</a></li><? } if($allowmergethread) { $modopt++ ?><li class="wide"><a href="javascript:;" onclick="modaction('merge')">合并主题</a></li><? } if($allowrefund && $thread['price'] > 0) { $modopt++ ?><li class="wide"><a href="javascript:;" onclick="modaction('refund')">强制退款</a></li><? } } if($allowsplitthread) { $modopt++ ?><li class="wide"><a href="javascript:;" onclick="modaction('split')">分割主题</a></li><? } if($allowrepairthread) { $modopt++ ?><li class="wide"><a href="javascript:;" onclick="modaction('repair')">修复主题</a></li><? } } if($allowremovereward && $thread['special'] == 3) { $modopt++ ?><li class="wide"><a href="javascript:;" onclick="modaction('removereward')">取消悬赏</a></li><? } ?>
</ul>
<? if($allowwarnpost || $allowbanpost || $allowdelpost) { ?>
<div id="modlayer" style="display:none;position:position;width:165px;">
<span>选中</span><strong id="modcount"></strong><span>篇: </span>
<? if($allowwarnpost) { ?>
<a href="javascript:;" onclick="modaction('warn')">警告</a>
<? } if($allowbanpost) { ?>
<a href="javascript:;" onclick="modaction('banpost')">屏蔽</a>
<? } if($allowdelpost) { ?>
<a href="javascript:;" onclick="modaction('delpost')">删除</a>
<? } ?>
</div>
<? } } ?>

<div id="wrap" class="wrap s_clear threadfix">
<div class="forumcontrol">
<table cellspacing="0" cellpadding="0">
<tr>
<td class="modaction">
<? if($forum['ismoderator'] && $modopt) { ?>
<span id="modopt" onclick="$('modopt').id = 'modopttmp';this.id = 'modopt';showMenu({'ctrlid':this.id})" class="dropmenu">主题管理</span>
<? } ?>
</td>
<td>
<?=$multipage?>
<span class="pageback"<? if($visitedforums) { ?> id="visitedforums" onmouseover="$('visitedforums').id = 'visitedforumstmp';this.id = 'visitedforums';showMenu({'ctrlid':this.id})"<? } ?>><a href="<?=$upnavlink?>">返回列表</a></span>
<? if($allowpostreply) { ?>
<span class="replybtn" id="post_reply" prompt="post_reply"><a href="post.php?action=reply&amp;fid=<?=$fid?>&amp;tid=<?=$tid?>" onclick="showWindow('reply', this.href);return false;">回复</a></span>
<? } ?>
<span class="postbtn" id="newspecial" prompt="post_newthread" onmouseover="$('newspecial').id = 'newspecialtmp';this.id = 'newspecial';showMenu({'ctrlid':this.id})"><a href="post.php?action=newthread&amp;fid=<?=$fid?>" onclick="showWindow('newthread', this.href);return false;">发帖</a></span>
</td>
</tr>
</table>
</div>

<? if($allowpost && ($allowposttrade || $allowpostpoll || $allowpostreward || $allowpostactivity || $allowpostdebate || $threadplugins || $forum['threadsorts'])) { ?>
<ul class="popupmenu_popup postmenu" id="newspecial_menu" style="display: none">
<? if(!$forum['allowspecialonly']) { ?><li><a href="post.php?action=newthread&amp;fid=<?=$fid?>" onclick="showWindow('newthread', this.href);doane(event)">发新话题</a></li><? } if($allowpostpoll) { ?><li class="poll"><a href="post.php?action=newthread&amp;fid=<?=$fid?>&amp;special=1">发布投票</a></li><? } if($allowpostreward) { ?><li class="reward"><a href="post.php?action=newthread&amp;fid=<?=$fid?>&amp;special=3">发布悬赏</a></li><? } if($allowpostdebate) { ?><li class="debate"><a href="post.php?action=newthread&amp;fid=<?=$fid?>&amp;special=5">发布辩论</a></li><? } if($allowpostactivity) { ?><li class="activity"><a href="post.php?action=newthread&amp;fid=<?=$fid?>&amp;special=4">发布活动</a></li><? } if($allowposttrade) { ?><li class="trade"><a href="post.php?action=newthread&amp;fid=<?=$fid?>&amp;special=2">发布商品</a></li><? } if($threadplugins) { if(is_array($forum['threadplugin'])) { foreach($forum['threadplugin'] as $tpid) { if(array_key_exists($tpid, $threadplugins) && @in_array($tpid, $allowthreadplugin)) { ?>
<li class="popupmenu_option"<? if($threadplugins[$tpid]['icon']) { ?> style="background-image:url(<?=$threadplugins[$tpid]['icon']?>)"<? } ?>><a href="post.php?action=newthread&amp;fid=<?=$fid?>&amp;specialextra=<?=$tpid?>"><?=$threadplugins[$tpid]['name']?></a></li>
<? } } } } if($forum['threadsorts'] && !$forum['allowspecialonly']) { if(is_array($forum['threadsorts']['types'])) { foreach($forum['threadsorts']['types'] as $id => $threadsorts) { if($forum['threadsorts']['show'][$id]) { ?>
<li class="popupmenu_option"><a href="post.php?action=newthread&amp;fid=<?=$fid?>&amp;extra=<?=$extra?>&amp;sortid=<?=$id?>"><?=$threadsorts?></a></li>
<? } } } if(is_array($forum['typemodels'])) { foreach($forum['typemodels'] as $id => $model) { ?><li class="popupmenu_option"><a href="post.php?action=newthread&amp;fid=<?=$fid?>&amp;extra=<?=$extra?>&amp;modelid=<?=$id?>"><?=$model['name']?></a></li><? } } } ?>
</ul>
<? } ?>

<div id="postlist" class="mainbox viewthread"><? $postcount = 0; if(is_array($postlist)) { foreach($postlist as $post) { ?><div id="post_<?=$post['pid']?>"><? $needhiddenreply = ($hiddenreplies && $discuz_uid != $post['authorid'] && $discuz_uid != $thread['authorid'] && !$post['first'] && !$forum['ismoderator']); ?><table id="pid<?=$post['pid']?>" summary="pid<?=$post['pid']?>" cellspacing="0" cellpadding="0">
<? if(!empty($fav) && $rpid == $post['pid']) { ?>
<tr class="threadad">
<td class="postauthor"></td>
<td class="adcontent">
<div id="ntc_jp">
<div class="s_clear">
<a class="deloption" href="my.php?item=attention&amp;action=remove&amp;tid=<?=$tid?>" id="attention_remove_<?=$post['pid']?>" onclick="ajaxmenu(this, 3000);doane(event);" title="取消关注">取消关注</a>
<em>以下是新回复</em>
<h2><a href="viewthread.php?tid=<?=$tid?>"><?=$thread['subject']?></a></h2>
</div>
</div>
</td>
</tr>
<? } ?>
<tr>
<td class="postauthor" rowspan="2">
<? if($post['authorid'] && $post['username'] && !$post['anonymous']) { if($authoronleft) { ?>
<div class="postinfo">
<a target="_blank" href="space.php?uid=<?=$post['authorid']?>" style="margin-left: 20px; font-weight: 800"><?=$post['author']?></a>
</div>
<? } ?>
<div class="popupmenu_popup userinfopanel" id="userinfo<?=$post['pid']?>" style="display: none; position: absolute;<? if($authoronleft) { ?>margin-top: -11px;<? } ?>">
<div class="popavatar">
<div id="userinfo<?=$post['pid']?>_ma"></div>
<ul class="profile_side">
<li class="pm"><a href="pm.php?action=new&amp;uid=<?=$post['authorid']?>" onclick="hideMenu('userinfo<?=$post['pid']?>');showWindow('sendpm', this.href);return false;" title="发短消息">发短消息</a></li>
<? if($post['msn']['1']) { ?>
<li style="text-indent:0"><a target="_blank" href="http://settings.messenger.live.com/Conversation/IMMe.aspx?invitee=<?=$post['msn']['1']?>@apps.messenger.live.com&amp;mkt=zh-cn" title="MSN 聊天"><img style="border-style: none; margin-right: 5px; vertical-align: middle;" src="http://messenger.services.live.com/users/<?=$post['msn']['1']?>@apps.messenger.live.com/presenceimage?mkt=zh-cn" width="16" height="16" />MSN 聊天</a></li>
<? } ?>
<li class="buddy"><a href="my.php?item=buddylist&amp;newbuddyid=<?=$post['authorid']?>&amp;buddysubmit=yes" target="_blank" id="ajax_buddy_<?=$post['count']?>" title="加为好友" onclick="ajaxmenu(this, 3000);doane(event);">加为好友</a></li>
</ul>
<?=$pluginhooks['viewthread_profileside'][$postcount]?>
</div>
<div class="popuserinfo">
<p>
<a href="space.php?uid=<?=$post['authorid']?>" target="_blank"><?=$post['author']?></a>
<? if($post['nickname']) { ?><em>(<?=$post['nickname']?>)</em><? } if($vtonlinestatus && $post['authorid']) { if(($vtonlinestatus == 2 && $onlineauthors[$post['authorid']]) || ($vtonlinestatus == 1 && ($timestamp - $post['lastactivity'] <= 10800) && !$post['invisible'])) { ?>
<em>当前在线
<? } else { ?>
<em>当前离线
<? } ?>
</em>
<? } ?>
</p>
<? if($post['customstatus']) { ?><p class="customstatus"><?=$post['customstatus']?></p><? } ?>

<dl class="s_clear"><? @eval('echo "'.$customauthorinfo['2'].'";'); ?></dl>
<div class="imicons">
<? if($post['qq']) { ?><a href="http://wpa.qq.com/msgrd?V=1&amp;Uin=<?=$post['qq']?>&amp;Site=<?=$bbname?>&amp;Menu=yes" target="_blank" title="QQ"><img src="<?=IMGDIR?>/qq.gif" alt="QQ" /></a><? } if($post['icq']) { ?><a href="http://wwp.icq.com/scripts/search.dll?to=<?=$post['icq']?>" target="_blank" title="ICQ"><img src="<?=IMGDIR?>/icq.gif" alt="ICQ" /></a><? } if($post['yahoo']) { ?><a href="http://edit.yahoo.com/config/send_webmesg?.target=<?=$post['yahoo']?>&amp;.src=pg" target="_blank" title="Yahoo"><img src="<?=IMGDIR?>/yahoo.gif" alt="Yahoo!"  /></a><? } if($post['taobao']) { ?><a href="javascript:;" onclick="window.open('http://amos.im.alisoft.com/msg.aw?v=2&uid='+encodeURIComponent('<?=$post['taobaoas']?>')+'&site=cntaobao&s=2&charset=utf-8')" title="taobao"><img src="<?=IMGDIR?>/taobao.gif" alt="阿里旺旺" /></a><? } if($ucappopen['UCHOME']) { ?>
<a href="<?=$uchomeurl?>/space.php?uid=<?=$post['authorid']?>" target="_blank" title="个人空间"><img src="<?=IMGDIR?>/home.gif" alt="个人空间"  /></a>
<? } elseif($ucappopen['XSPACE']) { ?>
<a href="<?=$xspaceurl?>/?uid-<?=$post['authorid']?>" target="_blank" title="个人空间"><img src="<?=IMGDIR?>/home.gif" alt="个人空间"  /></a>
<? } if($post['site']) { ?><a href="<?=$post['site']?>" target="_blank" title="查看个人网站"><img src="<?=IMGDIR?>/forumlink.gif" alt="查看个人网站"  /></a><? } ?>
<a href="space.php?uid=<?=$post['authorid']?>" target="_blank" title="查看详细资料"><img src="<?=IMGDIR?>/userinfo.gif" alt="查看详细资料"  /></a>
<?=$pluginhooks['viewthread_imicons'][$postcount]?>
</div>
<div id="avatarfeed"><span id="threadsortswait"></span></div>
</div>
</div>
<? } ?>
<?=$post['newpostanchor']?> <?=$post['lastpostanchor']?>
<? if($post['authorid'] && $post['username'] && !$post['anonymous']) { ?>
<div>
<? if($bannedmessages & 2 && (($post['authorid'] && !$post['username']) || ($post['groupid'] == 4 || $post['groupid'] == 5) || ($post['status'] & 1))) { ?>
<div class="avatar">头像被屏蔽</div>
<? } elseif($post['avatar'] && $showavatars) { ?>
<div class="avatar" onmouseover="showauthor(this, 'userinfo<?=$post['pid']?>')"><a href="space.php?uid=<?=$post['authorid']?>" target="_blank"><?=$post['avatar']?></a></div>
<? } ?>
<p><em><a href="faq.php?action=grouppermission&amp;searchgroupid=<?=$post['groupid']?>" target="_blank"><?=$post['authortitle']?></a></em></p>
</div>
<p><? showstars($post['stars']); ?></p>
<?=$pluginhooks['viewthread_sidetop'][$postcount]?>
<? if($customauthorinfo['1']) { ?><dl class="profile s_clear"><? @eval('echo "'.$customauthorinfo['1'].'";'); ?></dl><? } if($post['medals']) { ?><p><? if(is_array($post['medals'])) { foreach($post['medals'] as $medal) { ?><img src="images/common/<?=$medal['image']?>" alt="<?=$medal['name']?>" title="<?=$medal['name']?>" /><? } } ?></p>
<? } if($discuz_uid && $magicstatus && $usemagic['user']) { ?>
<p><? if(is_array($usemagic['user'])) { foreach($usemagic['user'] as $id => $magic) { ?><a href="magic.php?action=mybox&amp;operation=use&amp;type=1&amp;pid=<?=$post['pid']?>&amp;magicid=<?=$id?>" onclick="showWindow('magics', this.href);doane(event);"><img src="images/magics/<?=$magic['pic']?>" title="对<?=$post['author']?>使用<?=$magic['name']?>"></a><? } } ?></p>
<? } ?>
<?=$pluginhooks['viewthread_sidebottom'][$postcount]?>
<? } else { ?>
<div class="avatar">
<? if(!$post['authorid']) { ?>
<a href="javascript:;">游客 <em><?=$post['useip']?></em></a>
<? } elseif($post['authorid'] && $post['username'] && $post['anonymous']) { if($forum['ismoderator']) { ?><a href="space.php?uid=<?=$post['authorid']?>" target="_blank">匿名</a><? } else { ?>匿名<? } } else { ?>
<?=$post['author']?> <em>该用户已被删除</em>
<? } ?>
</div>
<? } if($allowedituser || $allowbanuser || ($forum['ismoderator'] && $allowviewip && ($thread['digest'] >= 0 || !$post['first']))) { ?>
<hr class="shadowline" />
<p>
管理此人<br />
<? if($forum['ismoderator'] && $allowviewip && ($thread['digest'] >= 0 || !$post['first'])) { ?>
<a href="topicadmin.php?action=getip&amp;fid=<?=$fid?>&amp;tid=<?=$tid?>&amp;pid=<?=$post['pid']?>" onclick="ajaxmenu(this, 0, 1, 2);doane(event)" title="查看 IP" class="lightlink">IP</a>&nbsp;
<? } if($allowedituser) { ?>
<a href="<? if($adminid == 1) { ?>admincp.php?action=members&username=<?=$post['usernameenc']?>&submit=yes&frames=yes<? } else { ?>modcp.php?action=members&op=edit&uid=<?=$post['authorid']?><? } ?>" target="_blank" class="lightlink">编辑</a>&nbsp;
<? } if($allowbanuser) { if($adminid == 1) { ?>
<a href="admincp.php?action=members&amp;operation=ban&amp;username=<?=$post['usernameenc']?>&amp;frames=yes" target="_blank" class="lightlink">禁止</a>&nbsp;
<? } else { ?>
<a href="modcp.php?action=members&amp;op=ban&amp;uid=<?=$post['authorid']?>" target="_blank" class="lightlink">禁止</a>&nbsp;
<? } } ?>
<a href="modcp.php?action=threads&amp;op=posts&amp;do=search&amp;searchsubmit=1&amp;users=<?=$post['usernameenc']?>" target="_blank" class="lightlink">帖子</a>
</p>
<? } ?>
</td>
<td class="postcontent">
<? if($post['first']) { ?><div id="threadstamp"><? if($threadstamp) { ?><img src="images/stamps/<?=$threadstamp['url']?>" title="<?=$threadstamp['text']?>" /><? } ?></div><? } ?>
<div class="postinfo">
<strong><a title="复制本帖链接" id="postnum<?=$post['pid']?>" href="javascript:;" onclick="setCopy('<?=$boardurl?><? if($post['first']) { ?>viewthread.php?tid=<?=$tid?><?=$fromuid?><? } else { ?>redirect.php?goto=findpost&amp;ptid=<?=$tid?>&amp;pid=<?=$post['pid']?><?=$fromuid?><? } ?>', '帖子地址已经复制到剪贴板')"><? if(!empty($postno[$post['number']])) { ?><?=$postno[$post['number']]?><? } else { ?><em><?=$post['number']?></em><?=$postno['0']?><? } ?></a>
<? if(!$postcount) { ?>
<em class="rpostno" title="跳转到指定楼层">跳转到 <input id="rpostnovalue" size="3" type="text" class="txtarea" onkeydown="if(event.keyCode==13) {$('rpostnobtn').click();return false;}" /><span id="rpostnobtn" onclick="window.location='redirect.php?ptid=<?=$tid?>&ordertype=<?=$ordertype?>&postno='+$('rpostnovalue').value">&raquo;</span></em>
<? } if($post['first']) { if($ordertype != 1) { ?>
<a href="viewthread.php?tid=<?=$tid?>&amp;extra=<?=$extra?>&amp;ordertype=1" class="left">倒序看帖</a>
<? } else { ?>
<a href="viewthread.php?tid=<?=$tid?>&amp;extra=<?=$extra?>&amp;ordertype=2" class="left">正序看帖</a>
<? } } ?>
</strong>
<div class="posterinfo">
<div class="pagecontrol">
<? if($post['first']) { ?>
<a href="viewthread.php?action=printable&amp;tid=<?=$tid?>" target="_blank" class="print left">打印</a>
<? if(MSGBIGSIZE) { ?>
<div class="msgfsize right">
<label>字体大小: </label><small onclick="$('postlist').className='mainbox viewthread'" title="正常">t</small><big onclick="$('postlist').className='mainbox viewthread t_bigfont'" title="放大">T</big>
</div>
<? } } elseif($thread['special'] == 5) { ?>
<span class="debatevote poststand_<? echo intval($post['stand']); ?>">
<label><? if($post['stand'] == 1) { ?><a href="viewthread.php?tid=<?=$tid?>&amp;extra=<?=$extra?>&amp;stand=1" title="只看正方">正方</a>
<? } elseif($post['stand'] == 2) { ?><a href="viewthread.php?tid=<?=$tid?>&amp;extra=<?=$extra?>&amp;stand=2" title="只看反方">反方</a>
<? } else { ?><a href="viewthread.php?tid=<?=$tid?>&amp;extra=<?=$extra?>&amp;stand=0" title="只看中立">中立</a><? } ?>
</label>
<? if($post['stand']) { ?>
<span><a href="misc.php?action=debatevote&amp;tid=<?=$tid?>&amp;pid=<?=$post['pid']?>" id="voterdebate_<?=$post['pid']?>" onclick="ajaxmenu(this);doane(event);">支持我</a><?=$post['voters']?></span>
<? } ?>
</span>
<? } ?>
</div>
<div class="authorinfo">
<? if(!$post['anonymous'] && $_DCACHE['groupicon'][$post['groupid']]) { ?>
<img class="authicon" id="authicon<?=$post['pid']?>" src="<?=$_DCACHE['groupicon'][$post['groupid']]?>" onclick="showauthor(this, 'userinfo<?=$post['pid']?>')" />
<? } else { ?>
<img class="authicon" id="authicon<?=$post['pid']?>" src="images/common/online_member.gif" onclick="showauthor(this, 'userinfo<?=$post['pid']?>');" />
<? } if($post['authorid'] && !$post['anonymous']) { if(!$authoronleft) { ?><a href="space.php?uid=<?=$post['authorid']?>" class="posterlink" target="_blank"><?=$post['author']?></a><? } ?><?=$pluginhooks['viewthread_postheader'][$postcount]?><em id="authorposton<?=$post['pid']?>">发表于 <?=$post['dateline']?></em>
<? if(!$authorid) { ?>
 | <a href="viewthread.php?tid=<?=$post['tid']?>&amp;page=<?=$page?>&amp;authorid=<?=$post['authorid']?>" rel="nofollow">只看该作者</a>
<? } else { ?>
 | <a href="viewthread.php?tid=<?=$post['tid']?>&amp;page=<?=$page?>" rel="nofollow">显示全部帖子</a>
<? } } elseif($post['authorid'] && $post['username'] && $post['anonymous']) { ?>
匿名 <?=$pluginhooks['viewthread_postheader'][$postcount]?><em id="authorposton<?=$post['pid']?>">发表于 <?=$post['dateline']?></em>
<? } elseif(!$post['authorid'] && !$post['username']) { ?>
游客 <?=$pluginhooks['viewthread_postheader'][$postcount]?><em id="authorposton<?=$post['pid']?>">发表于 <?=$post['dateline']?></em>
<? } ?>
</div>
</div>
</div>
<div class="defaultpost">
<? if($admode && !empty($advlist['thread2'][$post['count']])) { ?><div class="ad_textlink2" id="ad_thread2_<?=$post['count']?>"><?=$advlist['thread2'][$post['count']]?></div><? } else { ?><div id="ad_thread2_<?=$post['count']?>"></div><? } if($admode && !empty($advlist['thread3'][$post['count']])) { ?><div class="ad_pip" id="ad_thread3_<?=$post['count']?>"><?=$advlist['thread3'][$post['count']]?></div><? } else { ?><div id="ad_thread3_<?=$post['count']?>"></div><? } ?><div id="ad_thread4_<?=$post['count']?>"></div>
<div class="postmessage <? if($post['first']) { ?>firstpost<? } ?>">
<? if($post['warned']) { ?>
<span class="postratings"><a href="misc.php?action=viewwarning&amp;tid=<?=$tid?>&amp;uid=<?=$post['authorid']?>" title="受到警告" onclick="showWindow('viewwarning', this.href);return false;"><img src="<?=IMGDIR?>/warning.gif" border="0" /></a></span>
<? } if($thread['special'] == 3 && $post['first']) { if($thread['price'] > 0) { ?>
<cite class="re_unsolved">未解决</cite>
<? } elseif($thread['price'] < 0) { ?>
<cite class="re_solved">已解决</cite>
<? } if($activityclose) { ?><cite class="re_solved">活动已结束</cite><? } } if($post['first']) { ?>
<div id="threadtitle">
<? if($thread['readperm']) { ?><em>所需阅读权限 <?=$thread['readperm']?></em><? } ?>
<h1><?=$thread['subject']?></h1>
<? if($thread['tags'] || $relatedkeywords) { ?>
<div class="threadtags">
<? if($thread['tags']) { ?><?=$thread['tags']?><? } if($relatedkeywords) { ?><span class="postkeywords"><?=$relatedkeywords?></span><? } ?>
</div>
<? } ?>
</div>
<? } elseif($post['subject']) { ?>
<h2><?=$post['subject']?></h2>
<? } if($adminid != 1 && $bannedmessages & 1 && (($post['authorid'] && !$post['username']) || ($post['groupid'] == 4 || $post['groupid'] == 5))) { ?>
<div class="locked">提示: <em>作者被禁止或删除 内容自动屏蔽</em></div>
<? } elseif($adminid != 1 && $post['status'] & 1) { ?>
<div class="locked">提示: <em>该帖被管理员或版主屏蔽</em></div>
<? } elseif($needhiddenreply) { ?>
<div class="locked">此帖仅作者可见</div>
<? } elseif($post['first'] && $threadpay) { if($thread['freemessage']) { ?>
<div id="postmessage_<?=$pid?>" class="t_msgfont"><?=$thread['freemessage']?></div>
<? } ?>
<div class="locked">
<a href="javascript:;" class="right viewpay" title="购买主题" onclick="showWindow('pay', 'misc.php?action=pay&tid=<?=$tid?>&pid=<?=$post['pid']?>')">购买主题</a>
<em class="right">
已购买人数:<?=$thread['payers']?>&nbsp; <a href="misc.php?action=viewpayments&amp;tid=<?=$tid?>" onclick="showWindow('pay', this.href);return false;">记录</a>
</em>
<? if($thread['price'] > 0) { ?>本主题需向作者支付 <strong><?=$thread['price']?> <?=$extcredits[$creditstransextra['1']]['title']?> </strong> 才能浏览<? } if($thread['endtime']) { ?>本主题购买截止日期为 <?=$thread['endtime']?>，到期后将免费<? } ?>
</div>
</div><? } else { ?>
<?=$pluginhooks['viewthread_posttop'][$postcount]?>
<? if($bannedmessages & 1 && (($post['authorid'] && !$post['username']) || ($post['groupid'] == 4 || $post['groupid'] == 5))) { ?>
<div class="locked">提示: <em>作者被禁止或删除 内容自动屏蔽，只有管理员可见</em></div>
<? } elseif($post['status'] & 1) { ?>
<div class="locked">提示: <em>该帖被管理员或版主屏蔽，只有管理员可见</em></div>
<? } if($post['first']) { if($thread['price'] > 0 && $thread['special'] == 0) { ?>
<div class="locked"><em class="right"><a href="misc.php?action=viewpayments&amp;tid=<?=$tid?>" onclick="showWindow('pay', this.href);return false;">记录</a></em>付费主题, 价格:<strong><?=$extcredits[$creditstransextra['1']]['title']?> <?=$thread['price']?> <?=$extcredits[$creditstransextra['1']]['unit']?> </strong></div>
<? } if($typetemplate) { ?>
<?=$typetemplate?>
<? } elseif($optionlist && !($post['status'] & 1) && !$threadpay) { ?>
<div class="typeoption">
<h4><?=$forum['threadsorts']['types'][$thread['sortid']]?></h4>
<table summary="分类信息" cellpadding="0" cellspacing="0" class="formtable datatable"><? if(is_array($optionlist)) { foreach($optionlist as $option) { ?><tr class="<? echo swapclass('colplural'); ?>">
<th><?=$option['title']?></th>
<td><? if($option['value']) { ?><?=$option['value']?> <?=$option['unit']?><? } else { ?>-<? } ?></td>
</tr><? } } ?></table>
</div>
<? } if($thread['special'] == 1) { include template('viewthread_poll', '0', ''); } elseif($thread['special'] == 3) { include template('viewthread_reward_price', '0', ''); } elseif($thread['special'] == 4) { include template('viewthread_activity_info', '0', ''); } elseif($thread['special'] == 5) { include template('viewthread_debate_umpire', '0', ''); } elseif($threadplughtml) { ?>
<?=$threadplughtml?>
<? } } ?>
<div class="<? if(!$thread['special']) { ?>t_msgfontfix<? } else { ?>specialmsg<? } ?>">
<table cellspacing="0" cellpadding="0"><tr><td class="t_msgfont" id="postmessage_<?=$post['pid']?>"><?=$post['message']?></td></tr></table>
<? if($post['first']) { if($thread['special'] == 2) { include template('viewthread_trade', '0', ''); } elseif($thread['special'] == 3) { if($bapid) { $bestpost = $postlist[$bapid];unset($postlist[$bapid]); } include template('viewthread_reward', '0', ''); } elseif($thread['special'] == 4) { include template('viewthread_activity', '0', ''); } elseif($thread['special'] == 5) { include template('viewthread_debate', '0', ''); } } if($post['attachment']) { ?>
<div class="locked">附件: <em><? if($discuz_uid) { ?>您所在的用户组无法下载或查看附件<? } else { ?>您需要<a href="logging.php?action=login" onclick="showWindow('login', this.href);return false;" class="lightlink">登录</a>才可以下载或查看附件。没有帐号？<a href="<?=$regname?>" onclick="hideWindow('login');showWindow('register', this.href);return false;" title="注册帐号" class="lightlink"><?=$reglinkname?></a><? } ?></em></div>
<? } elseif($hideattach[$post['pid']] && $post['attachments']) { ?>
<div class="locked">附件: <em>本帖附件需要回复才可下载或查看</em></div>
<? } elseif($post['imagelist'] || $post['attachlist']) { ?>
<div class="postattachlist">
<? if($post['imagelist']) { ?>
<?=$post['imagelist']?>
<? } if($post['attachlist']) { ?>
<?=$post['attachlist']?>
<? } ?>
</div>
<? } if($relatedthreadlist && !$qihoo['relate']['position'] && $post['first']) { ?>
<div class="tagrelated">
<h3><em><a href="http://search.qihoo.com/sint/qusearch.html?kw=<?=$searchkeywords?>&amp;sort=rdate&amp;ics=<?=$charset?>&amp;domain=<?=$site?>&amp;tshow=1" target="_blank">更多相关主题</a></em>相关主题</h3>
<ul><? if(is_array($relatedthreadlist)) { foreach($relatedthreadlist as $key => $threads) { if($threads['tid'] != $tid) { ?>
<li>
<? if(!$threads['insite']) { ?>
[站外] <a href="topic.php?url=<? echo urlencode($threads['tid']); ?>&amp;md5=<? echo md5($threads['tid']); ?>&amp;statsdata=<?=$fid?>||<?=$tid?>" target="_blank"><?=$threads['title']?></a>&nbsp;&nbsp;&nbsp;
[ <a href="post.php?action=newthread&amp;fid=<?=$fid?>&amp;extra=<?=$extra?>&amp;url=<? echo urlencode($threads['tid']); ?>&amp;md5=<? echo md5($threads['tid']); ?>&amp;from=direct" style="color: #090" target="_blank">转帖</a> ]
<? } else { ?>
<a href="viewthread.php?tid=<?=$threads['tid']?>&amp;statsdata=<?=$fid?>||<?=$tid?>" target="_blank"><?=$threads['title']?></a>
<? } ?>
</li>
<? } } } ?></ul>
</div>
<? } if($post['first'] && $relatedtagstatus) { ?>
<div id="relatedtags"></div>
<script src="tag.php?action=relatetag&rtid=<?=$tid?>" type="text/javascript" reload="1"></script>
<? } ?>
</div>
<?=$pluginhooks['viewthread_postbottom'][$postcount]?>

<? if(!empty($post['ratelog'])) { ?>
<dl class="newrate">
<dt>
<? if(!empty($postlist[$post['pid']]['totalrate'])) { ?>
<strong><a href="misc.php?action=viewratings&amp;tid=<?=$tid?>&amp;pid=<?=$post['pid']?>" onclick="showWindow('viewratings', this.href);return false;" title="本帖最近评分记录"><? echo count($postlist[$post['pid']]['totalrate']);; ?></a></strong>
<p>评分人数</p>
<? } ?>
</dt>
<dd>
<ul class="s_clear">
<div id="post_rate_<?=$post['pid']?>"></div>
<? if($ratelogon) { ?>
<ul class="s_clear ratelist"><? if(is_array($post['ratelog'])) { foreach($post['ratelog'] as $uid => $ratelog) { ?><li id="rate_<?=$post['pid']?>_<?=$uid?>" class="ratelistavatar">
<a href="space.php?uid=<?=$uid?>" target="_blank"><? echo discuz_uc_avatar($uid, 'small');; ?></a><a href="space.php?uid=<?=$uid?>" target="_blank"><?=$ratelog['username']?>:</a>
<?=$ratelog['reason']?><? if(is_array($ratelog['score'])) { foreach($ratelog['score'] as $id => $score) { if($score > 0) { ?>
<em><?=$extcredits[$id]['title']?> + <?=$score?> <?=$extcredits[$id]['unit']?></em>
<? } else { ?>
<span><?=$extcredits[$id]['title']?> <?=$score?> <?=$extcredits[$id]['unit']?></span>
<? } } } ?></li><? } } ?></ul>
<? } else { if(is_array($post['ratelog'])) { foreach($post['ratelog'] as $uid => $ratelog) { ?><li>
<div id="rate_<?=$post['pid']?>_<?=$uid?>_menu" class="attach_popup" style="display: none;">
<p class="cornerlayger"><?=$ratelog['reason']?> &nbsp;&nbsp;<? if(is_array($ratelog['score'])) { foreach($ratelog['score'] as $id => $score) { if($score > 0) { ?>
<em><?=$extcredits[$id]['title']?> + <?=$score?> <?=$extcredits[$id]['unit']?></em>
<? } else { ?>
<span><?=$extcredits[$id]['title']?> <?=$score?> <?=$extcredits[$id]['unit']?></span>
<? } } } ?></p>
<p class="minicorner"></p>
</div>
<p id="rate_<?=$post['pid']?>_<?=$uid?>" onmouseover="showMenu({'ctrlid':this.id,'pos':'12'})" class="rateavatar"><a href="space.php?uid=<?=$uid?>" target="_blank"><? echo discuz_uc_avatar($uid, 'small');; ?></a></p>
<p><a href="space.php?uid=<?=$uid?>" target="_blank"><?=$ratelog['username']?></a></p>
</li><? } } } ?>
</ul>
</dd>
</dl>
<? } else { ?>
<div id="post_rate_div_<?=$post['pid']?>"></div>
<? } } if($post['first']) { if($lastmod['modaction']) { ?><div class="modact"><a href="misc.php?action=viewthreadmod&amp;tid=<?=$tid?>" title="主题操作记录" onclick="showWindow('viewthreadmod', this.href);return false;">本主题由 <?=$lastmod['modusername']?> 于 <?=$lastmod['moddateline']?> <?=$lastmod['modaction']?></a></div><? } if($lastmod['magicname']) { ?><div class="modact"><a href="misc.php?action=viewthreadmod&amp;tid=<?=$tid?>" title="主题操作记录" onclick="showWindow('viewthreadmod', this.href);return false;">本主题由 <?=$lastmod['modusername']?> 于 <?=$lastmod['moddateline']?> 使用 <?=$lastmod['magicname']?> 道具</a></div><? } ?>
<div class="useraction<? if($allowrecommend && $recommendthread['status']) { ?> nrate<? } ?>">
<a href="javascript:;" onclick="showDialog($('favoritewin').innerHTML, 'info', '收藏/关注')">收藏</a>
<a href="javascript:;" id="share" onclick="showDialog($('sharewin').innerHTML, 'info', '分享')">分享</a>
<? if($allowrecommend && $recommendthread['status']) { ?>
<div id="ajax_recommendlink">
<div id="recommendv" onclick="switchrecommendv()" title="主题评价指数"<? if($recommendthread['defaultshow']) { ?> style="display: none"<? } ?>><?=$thread['recommends']?></div>
<ul id="recommendav" onclick="switchrecommendv()" title="主题评价指数"<? if(!$recommendthread['defaultshow']) { ?> style="display: none"<? } ?> class="recommend_act s_clear">
<li id="recommendv_add" title="<?=$recommendthread['addtext']?>的人数"><?=$thread['recommend_add']?></li>
<li id="recommendv_subtract"  title="<?=$recommendthread['subtracttext']?>的人数"><?=$thread['recommend_sub']?></li>
</ul>
<ul class="recommend_act s_clear">
<li><a id="recommend_add" <? if($discuz_uid) { ?>href="misc.php?action=recommend&amp;do=add&amp;tid=<?=$tid?>" onclick="ajaxmenu(this, 3000, 1, 0, '43', 'recommendupdate(<?=$allowrecommend?>)');;doane(event);"<? } else { ?>href="logging.php?action=login" onclick="showWindow('login', this.href);return false;"<? } ?>><?=$recommendthread['addtext']?></a></li>
<li><a id="recommend_subtract"<? if($discuz_uid) { ?>href="misc.php?action=recommend&amp;do=subtract&amp;tid=<?=$tid?>" onclick="ajaxmenu(this, 3000, 1, 0, '43', 'recommendupdate(-<?=$allowrecommend?>)');;doane(event);"<? } else { ?>href="logging.php?action=login" onclick="showWindow('login', this.href);return false;"<? } ?>><?=$recommendthread['subtracttext']?></a></li>
</ul>
</div>
<? } ?>
<?=$pluginhooks['viewthread_useraction']?>
</div>
<? } ?>
</div>

</div>
</td></tr>
<tr><td class="postcontent postbottom">
<? if($post['signature'] && ($bannedmessages & 4 && (($post['authorid'] && !$post['username']) || ($post['groupid'] == 4 || $post['groupid'] == 5) || ($post['status'] & 1)))) { ?>
<div class="signatures">签名被屏蔽</div>
<? } elseif($post['signature'] && !$post['anonymous'] && $showsignatures) { ?>
<div class="signatures" style="max-height:<?=$maxsigrows?>px;maxHeightIE:<?=$maxsigrows?>px;"><?=$post['signature']?></div>
<? } if($admode && !empty($advlist['thread1'][$post['count']])) { ?><div class="ad_textlink1" id="ad_thread1_<?=$post['count']?>"><?=$advlist['thread1'][$post['count']]?></div><? } else { ?><div id="ad_thread1_<?=$post['count']?>"></div><? } ?>
</td>
</tr>
<tr>
<td class="postauthor"></td>
<td class="postcontent">
<div class="postactions">
<? if($forum['ismoderator'] && ($allowdelpost || $allowbanpost)) { ?>
<span class="right">
<label for="manage<?=$post['pid']?>">
<? if($post['first'] && $thread['digest'] == -1) { ?>
<input type="checkbox" id="manage<?=$post['pid']?>" disabled="disabled" />
<? } else { ?>
<input type="checkbox" id="manage<?=$post['pid']?>" <? if(!empty($modclick)) { ?>checked="checked" <? } ?>onclick="pidchecked(this);modclick(this, <?=$post['pid']?>)" value="<?=$post['pid']?>" />
<? } ?>
管理
</label>
</span>
<? } ?>
<div class="postact s_clear">
<em>
<? if($allowpostreply) { ?>
<a class="fastreply" href="post.php?action=reply&amp;fid=<?=$fid?>&amp;tid=<?=$tid?>&amp;reppost=<?=$post['pid']?>&amp;extra=<?=$extra?>&amp;page=<?=$page?>" onclick="showWindow('reply', this.href);return false;">回复</a>
<? if(!$needhiddenreply) { ?>
<a class="repquote" href="post.php?action=reply&amp;fid=<?=$fid?>&amp;tid=<?=$tid?>&amp;repquote=<?=$post['pid']?>&amp;extra=<?=$extra?>&amp;page=<?=$page?>" onclick="showWindow('reply', this.href);return false;">引用</a>
<? } } if((($forum['ismoderator'] && $alloweditpost && !(in_array($post['adminid'], array(1, 2, 3)) && $adminid > $post['adminid'])) || ($forum['alloweditpost'] && $discuz_uid && $post['authorid'] == $discuz_uid)) && ($thread['digest'] >= 0 || !$post['first'])) { ?>
<a class="editpost" href="post.php?action=edit&amp;fid=<?=$fid?>&amp;tid=<?=$tid?>&amp;pid=<?=$post['pid']?>&amp;page=<?=$page?>"><? if($thread['special'] == 2 && !$post['message']) { ?>添加柜台介绍<? } else { ?>编辑</a><? } } ?>
<?=$pluginhooks['viewthread_postfooter'][$postcount]?>
</em>
<p>
<? if($thread['special'] == 3 && ($forum['ismoderator'] || $thread['authorid'] == $discuz_uid) && $discuz_uid != $post['authorid'] && $post['authorid'] != $thread['authorid'] && $post['first'] == 0 && $thread['price'] > 0) { ?>
<a href="javascript:;" onclick="setanswer(<?=$post['pid']?>)">最佳答案</a>
<? } if($raterange && $post['authorid']) { ?>
<a href="misc.php?action=rate&amp;tid=<?=$tid?>&amp;pid=<?=$post['pid']?>" onclick="showWindow('rate', this.href);return false;">评分</a>
<? } if($post['rate'] && $forum['ismoderator']) { ?>
<a href="misc.php?action=removerate&amp;tid=<?=$tid?>&amp;pid=<?=$post['pid']?>&amp;page=<?=$page?>" onclick="showWindow('rate', this.href);return false;">撤销评分</a>
<? } if(!$forum['ismoderator'] && $discuz_uid && $reportpost && $discuz_uid != $post['authorid']) { ?>
<a href="misc.php?action=report&amp;fid=<?=$fid?>&amp;tid=<?=$tid?>&amp;pid=<?=$post['pid']?>" onclick="showWindow('report', this.href);doane(event);">报告</a>
<? } if($discuz_uid && $magicstatus) { ?>
<a href="magic.php?action=getmagic&amp;fid=<?=$fid?>&amp;pid=<?=$post['pid']?>" id="usermagicopt<?=$post['pid']?>" class="dropmenu" onmouseover="SMAM=setTimeout(function() {ajaxmenu($('usermagicopt<?=$post['pid']?>'), 1000, 1, 2);doane(event);}, 500)" onmouseout="clearTimeout(SMAM)" onclick="if($(this.id + '_menu') && $(this.id + '_menu').style.display == '') {hideMenu(this.id + '_menu')} else {ajaxmenu(this, 1000, 1, 2);}doane(event);">使用道具</a>
<? } if(!$post['first']) { ?>
<a href="javascript:;" onclick="scrollTo(0,0);">TOP</a>
<? } ?>
</p>
</div>
</div>

</td>
</tr>
<tr class="threadad">
<td class="postauthor"></td>
<td class="adcontent">
<? if($post['first'] && $thread['replies']) { if($admode && !empty($advlist['interthread'])) { ?><div class="ad_column" id="ad_interthread"><?=$advlist['interthread']?><? } else { ?><div id="ad_interthread"><? } ?></div><? } ?>
</td>
</tr>
<? if($post['first'] && $thread['special'] == 5 && $stand != '') { ?>
<tr class="threadad stand_select">
<td class="postauthor" style="background: #EBF2F8;"></td>
<td>
<div class="itemtitle s_clear">
<h2>按立场筛选: </h2>
<ul>
<li><a href="viewthread.php?tid=<?=$tid?>&amp;extra=<?=$extra?>" hidefocus="true"><span>全部</span></a></li>
<li <? if($stand == 1) { ?>class="current"<? } ?>><a href="viewthread.php?tid=<?=$tid?>&amp;extra=<?=$extra?>&amp;stand=1" hidefocus="true"><span>正方</span></a></li>
<li <? if($stand == 2) { ?>class="current"<? } ?>><a href="viewthread.php?tid=<?=$tid?>&amp;extra=<?=$extra?>&amp;stand=2" hidefocus="true"><span>反方</span></a></li>
<li <? if($stand == 0) { ?>class="current"<? } ?>><a href="viewthread.php?tid=<?=$tid?>&amp;extra=<?=$extra?>&amp;stand=0" hidefocus="true"><span>中立</span></a></li>
</ul>
</div>
<hr class="solidline" />
</td>
</tr>
<? } ?>
</table>
<? if($aimgs[$post['pid']]) { ?>
<script type="text/javascript" reload="1">aimgcount[<?=$post['pid']?>] = [<? echo implode(',', $aimgs[$post['pid']]);; ?>];attachimgshow(<?=$post['pid']?>);</script>
<? } ?>
<?=$pluginhooks['viewthread_endline'][$postcount]?><? $postcount++; ?></div><? } } ?></div>

<div id="postlistreply" class="mainbox viewthread"><div id="post_new" class="viewthread_table" style="display: none"></div></div>

<form method="post" name="modactions" id="modactions">
<input type="hidden" name="formhash" value="<?=FORMHASH?>" />
<input type="hidden" name="optgroup" />
<input type="hidden" name="operation" />
<input type="hidden" name="listextra" value="<?=$extra?>" />
</form>

<?=$tagscript?>

<div class="forumcontrol s_clear">
<table cellspacing="0" cellpadding="0" <? if($fastpost) { ?>class="narrow"<? } ?>>
<tr>
<td class="modaction">
<? if($forum['ismoderator'] && $modopt) { ?>
<span id="modopttmp" onclick="$('modopt').id = 'modopttmp';this.id = 'modopt';showMenu({'ctrlid':this.id})" class="dropmenu">主题管理</span>
<? } ?>
</td>
<td>
<?=$multipage?>
<span class="pageback"<? if($visitedforums) { ?> id="visitedforums" onmouseover="$('visitedforums').id = 'visitedforumstmp';this.id = 'visitedforums';showMenu({'ctrlid':this.id})"<? } ?>><a href="<?=$upnavlink?>">返回列表</a></span>
<? if(!$fastpost) { ?>
<span class="replybtn"><a href="post.php?action=reply&amp;fid=<?=$fid?>&amp;tid=<?=$tid?>" onclick="showWindow('reply', this.href);return false;">回复</a></span>
<span class="postbtn" id="newspecialtmp" onmouseover="$('newspecial').id = 'newspecialtmp';this.id = 'newspecial';showMenu({'ctrlid':this.id})"><a href="post.php?action=newthread&amp;fid=<?=$fid?>" onclick="showWindow('newthread', this.href);return false;">发帖</a></span>
<? } ?>
</td>
</tr>
</table>
</div>

<?=$pluginhooks['viewthread_middle']?>

<? if($fastpost && $allowpostreply) { ?><script type="text/javascript">
var postminchars = parseInt('<?=$minpostsize?>');
var postmaxchars = parseInt('<?=$maxpostsize?>');
var disablepostctrl = parseInt('<?=$disablepostctrl?>');
</script>

<div id="f_post" class="mainbox viewthread">
<form method="post" id="fastpostform" action="post.php?action=reply&amp;fid=<?=$fid?>&amp;tid=<?=$tid?>&amp;extra=<?=$extra?>&amp;replysubmit=yes<? if($ordertype != 1) { ?>&amp;infloat=yes&amp;handlekey=fastpost<? } ?>" <? if($ordertype != 1) { ?>onSubmit="return fastpostvalidate(this)"<? } ?>>
<table cellspacing="0" cellpadding="0">
<tr>
<td class="postauthor">
<? if($discuz_uid) { ?><div class="avatar"><? echo discuz_uc_avatar($discuz_uid); ?></div><? } ?>
<?=$pluginhooks['viewthread_fastpost_side']?>
</td>
<td class="postcontent">
<?=$pluginhooks['viewthread_fastpost_content']?>
<input type="hidden" name="formhash" value="<?=FORMHASH?>" />
<input type="hidden" name="subject" value="" />
<input type="hidden" name="usesig" value="<?=$usesigcheck?>" />
<? if($uchome['addfeed'] && $ucappopen['UCHOME'] && $forum['allowfeed']) { ?>
<input type="hidden" name="addfeed" value="1" />
<? } ?>

<span id="fastpostreturn"></span>
<? if($thread['special'] == 5 && empty($firststand)) { ?>
<div class="s_clear">
<label class="left">选择观点: </label>
<div class="float_typeid short_select">
<select id="stand" name="stand">
<option value="0">中立</option>
<option value="1">正方</option>
<option value="2">反方</option>
</select>
</div>
<script type="text/javascript">simulateSelect('stand');</script>
</div>
<? } ?>
<div class="editor_tb">
<span class="right">
<a href="post.php?action=reply&amp;fid=<?=$fid?>&amp;tid=<?=$tid?>" onclick="return switchAdvanceMode(this.href)">高级模式</a>
<span class="pipe">|</span>
<span id="newspecialtmp" onmouseover="$('newspecial').id = 'newspecialtmp';this.id = 'newspecial';showMenu({'ctrlid':this.id})"><a href="post.php?action=newthread&amp;fid=<?=$fid?>" onclick="showWindow('newthread', this.href);return false;">发新话题</a></span>
</span><? $seditor = array('fastpost', array('bold', 'color', 'img', 'link', 'quote', 'code', 'smilies')); ?><link rel="stylesheet" type="text/css" href="forumdata/cache/style_<?=STYLEID?>_seditor.css?<?=VERHASH?>" />
<div>
<? if(in_array('bold', $seditor['1'])) { ?>
<a href="javascript:;" title="粗体" class="tb_bold" onclick="seditor_insertunit('<?=$seditor['0']?>', '[b]', '[/b]')">B</a>
<? } if(in_array('color', $seditor['1'])) { ?>
<a href="javascript:;" title="颜色" class="tb_color" id="<?=$seditor['0']?>forecolor" onclick="showColorBox(this.id, 2, '<?=$seditor['0']?>')">Color</a>
<? } if(in_array('img', $seditor['1'])) { ?>
<a href="javascript:;" title="图片" class="tb_img" onclick="seditor_insertunit('<?=$seditor['0']?>', '[img]', '[/img]')">Image</a>
<? } if(in_array('link', $seditor['1'])) { ?>
<a href="javascript:;" title="插入链接" class="tb_link" onclick="seditor_insertunit('<?=$seditor['0']?>', '[url]', '[/url]')">Link</a>
<? } if(in_array('quote', $seditor['1'])) { ?>
<a href="javascript:;" title="引用" class="tb_quote" onclick="seditor_insertunit('<?=$seditor['0']?>', '[quote]', '[/quote]')">Quote</a>
<? } if(in_array('code', $seditor['1'])) { ?>
<a href="javascript:;" title="代码" class="tb_code" onclick="seditor_insertunit('<?=$seditor['0']?>', '[code]', '[/code]')">Code</a>
<? } if(in_array('smilies', $seditor['1'])) { ?>
<a href="javascript:;" class="tb_smilies" id="<?=$seditor['0']?>smilies" onclick="showMenu({'ctrlid':this.id,'evt':'click','layer':2});return false">Smilies</a>
<script src="forumdata/cache/smilies_var.js?<?=VERHASH?>" type="text/javascript" reload="1"></script>
<script type="text/javascript" reload="1">smilies_show('<?=$seditor['0']?>smiliesdiv', <?=$smcols?>, '<?=$seditor['0']?>');</script>
<? } ?>
</div></div>
<textarea rows="5" cols="80" name="message" id="fastpostmessage" onKeyDown="seditor_ctlent(event, <? if($ordertype != 1) { ?>'fastpostvalidate($(\'fastpostform\'))'<? } else { ?>'$(\'fastpostform\').submit()'<? } ?>);" tabindex="4" class="txtarea"></textarea>
<? if($secqaacheck || $seccodecheck) { ?><div class="fastcheck"><? include template('seccheck', '0', ''); ?></div><? } ?>
<p><button type="submit" name="replysubmit" id="fastpostsubmit" value="replysubmit" tabindex="5">发表回复</button>
<? if($ordertype != 1) { ?>
<input id="fastpostrefresh" type="checkbox" /> <label for="fastpostrefresh">回帖后跳转到最后一页</label></p><script type="text/javascript">if(getcookie('discuz_fastpostrefresh') == 1) {$('fastpostrefresh').checked=true;}</script>
<? } ?>
</p>
</td>
</tr>
</table>
</form>
</div><? } if($relatedthreadlist && $qihoo['relate']['position']) { include template('viewthread_relatedthread', '0', ''); } ?>

<?=$pluginhooks['viewthread_bottom']?>

<? if($visitedforums) { ?>
<ul class="popupmenu_popup" id="visitedforums_menu" style="display: none">
<?=$visitedforums?>
</ul>
<? } if($forumjump) { ?>
<div class="popupmenu_popup" id="fjump_menu" style="display: none">
<?=$forummenu?>
</div>
<? } ?>

<div id="favoritewin" style="display: none">
<h5>
<a href="javascript:;" onclick="ajaxget('my.php?item=favorites&tid=<?=$tid?>', 'favorite_msg');return false;" class="lightlink">[收藏此主题]</a>&nbsp;
<a href="javascript:;" onclick="ajaxget('my.php?item=attention&action=add&tid=<?=$tid?>', 'favorite_msg');return false;" class="lightlink">[关注此主题的新回复]</a>
</h5>
<span id="favorite_msg"></span>
</div>

<div id="sharewin" style="display: none">
<h5>
<a href="javascript:;" onclick="setCopy('<?=$threadshare?>\n<?=$boardurl?>viewthread.php?tid=<?=$tid?><?=$fromuid?>', '帖子地址已经复制到剪贴板<br />您可以用快捷键 Ctrl + V 粘贴到 QQ、MSN 里。')" class="lightlink" />[通过 QQ、MSN 分享给朋友]</a><br /><br />
<? if($discuz_uid) { ?>
<a href="javascript:;" class="lightlink" onclick="hideWindow('confirm');showWindow('sendpm', 'pm.php?action=new&operation=share&tid=<?=$tid?>');">[通过站内短消息分享给朋友]</a>
<? } ?>
</h5>
</div>

<? if($maxpage > 1) { ?>
<script type="text/javascript">document.onkeyup = function(e){keyPageScroll(e, <? if($page > 1) { ?>1<? } else { ?>0<? } ?>, <? if($page < $maxpage) { ?>1<? } else { ?>0<? } ?>, 'viewthread.php?tid=<?=$tid?><? if($authorid) { ?>&authorid=<?=$authorid?><? } ?>', <?=$page?>);}</script>
<? } if(!empty($_DCACHE['focus']['data']) && CURSCRIPT == 'viewthread' && empty($_COOKIE['discuz_nofocus'])) { $focus = $_DCACHE['focus'];$focustid = array_rand($focus['data']); ?><div class="focus" id="focus">
<h3 class="float_ctrl">
<em><? if($focus['title']) { ?><?=$focus['title']?><? } else { ?>站长推荐<? } ?></em>
<span><a href="javascript:;" onclick="setcookie('discuz_nofocus', 1, 3600);$('focus').style.display='none'" class="close deloption" title="关闭">关闭</a></span>
</h3>
<hr class="shadowline" />
<div class="detail">
<h4><a href="<?=$focus['data'][$focustid]['url']?>" target="_blank"><?=$focus['data'][$focustid]['subject']?></a></h4>
<p>
<? if($focus['data'][$focustid]['image']) { ?>
<a href="<?=$focus['data'][$focustid]['url']?>" target="_blank">
<img src="<?=$focus['data'][$focustid]['image']?>" width="58" height="58" /></a>
<? } ?>
<?=$focus['data'][$focustid]['summary']?>
</p>
</div>
<hr class="shadowline" />
<a href="<?=$focus['data'][$focustid]['url']?>" class="moreinfo" target="_blank">查看</a>
</div>
<? } ?>
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
</html><? if($relatedthreadupdate) { ?>
<script src="relatethread.php?tid=<?=$tid?>&subjectenc=<?=$thread['subjectenc']?>&tagsenc=<?=$thread['tagsenc']?>&verifykey=<?=$verifykey?>&up=<?=$qihoo_up?>" type="text/javascript"></script>
<? } if($tagupdate) { ?>
<script src="relatekw.php?tid=<?=$tid?>" type="text/javascript"></script>
<? } if($qihoo['relate']['bbsnum'] && $statsdata) { ?>
<img style="display:none;" src="http://pvstat.qihoo.com/dimana.gif?_pdt=discuz&amp;_pg=s100812&amp;_r=<?=$randnum?>&amp;_dim_k=orgthread&amp;_dim_v=<? echo urlencode($boardurl);; ?>||<?=$statsdata?>||0" width="1" height="1" alt="" />
<img style="display:none;" src="http://pvstat.qihoo.com/dimana.gif?_pdt=discuz&amp;_pg=s100812&amp;_r=<?=$randnum?>&amp;_dim_k=relthread&amp;_dim_v=<?=$statskeywords?>||<?=$statsurl?>" width="1" height="1" alt="" />
<? } ?>