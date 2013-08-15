<? if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('search');
0
|| checktplrefresh('D:\wwwphp\web\caipiao\code\front\bbs\././templates/default/search.htm', 'D:\wwwphp\web\caipiao\code\front\bbs\././templates/default/header.htm', 1313764849, '1', './templates/default')
|| checktplrefresh('D:\wwwphp\web\caipiao\code\front\bbs\././templates/default/search.htm', 'D:\wwwphp\web\caipiao\code\front\bbs\././templates/default/search_threads.htm', 1313764849, '1', './templates/default')
|| checktplrefresh('D:\wwwphp\web\caipiao\code\front\bbs\././templates/default/search.htm', 'D:\wwwphp\web\caipiao\code\front\bbs\././templates/default/search_sort.htm', 1313764849, '1', './templates/default')
|| checktplrefresh('D:\wwwphp\web\caipiao\code\front\bbs\././templates/default/search.htm', 'D:\wwwphp\web\caipiao\code\front\bbs\././templates/default/footer.htm', 1313764849, '1', './templates/default')
|| checktplrefresh('D:\wwwphp\web\caipiao\code\front\bbs\././templates/default/search.htm', 'D:\wwwphp\web\caipiao\code\front\bbs\././templates/default/header.htm', 1313764849, '1', './templates/default')
|| checktplrefresh('D:\wwwphp\web\caipiao\code\front\bbs\././templates/default/search.htm', 'D:\wwwphp\web\caipiao\code\front\bbs\././templates/default/footer.htm', 1313764849, '1', './templates/default')
|| checktplrefresh('D:\wwwphp\web\caipiao\code\front\bbs\././templates/default/search.htm', 'D:\wwwphp\web\caipiao\code\front\bbs\././templates/default/jsmenu.htm', 1313764849, '1', './templates/default')
|| checktplrefresh('D:\wwwphp\web\caipiao\code\front\bbs\././templates/default/search.htm', 'D:\wwwphp\web\caipiao\code\front\bbs\././templates/default/jsmenu.htm', 1313764849, '1', './templates/default')
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
<?=$pluginhooks['global_header']?><div id="nav"><a href="<?=$indexname?>"><?=$bbname?></a> &raquo; 搜索</div>
<div id="wrap" class="wrap">
<form class="searchform" method="post" action="search.php"<? if($qihoo['status']) { ?> target="_blank"<? } ?>>
<input type="hidden" name="formhash" value="<?=FORMHASH?>" />
<? if(!empty($srchtype)) { ?><input type="hidden" name="srchtype" value="<?=$srchtype?>" /><? } ?>

<label for="srchtxt" class="searchlabel">
搜索
<strong>
<? if($srchtype == 'threadsort') { ?>
分类信息
<? } elseif($srchtype == 'trade') { ?>
商品
<? } elseif($srchtype == 'qihoo') { ?>
奇虎全文
<? } else { ?>
帖子
<? } ?>
</strong>
</label>

<? if($srchtype != 'threadsort') { ?>
<p class="searchkey">
<input type="text" id="srchtxt" name="srchtxt" prompt="search_kw" size="45" maxlength="40" value="<?=$keyword?>" class="txt" tabindex="1" />
<script type="text/javascript">$('srchtxt').focus();</script>
<? if($checkarray['posts']) { ?>
<select name='srchtype'>
<option value="title">标题</option>
<? if(!$disabled['fulltext']) { ?><option value="fulltext">全文</option><? } ?>
</select>
<? } ?>
<button type="submit" name="searchsubmit" id="searchsubmit" value="true" prompt="search_submit">搜索</button>
<? if($checkarray['posts']) { ?>
<a href="javascript:;" onclick="userdisplay = $('search_option').style.display == '' ? '0' : '1'; display('search_option'); ajaxget('ajax.php?action=displaysearch_adv&display='+userdisplay);">高级</a>
<? } ?>
</p>
<? } ?>

<p>
<input type="radio" name="st" onclick="window.location=('search.php')" <?=$checkarray['posts']?> id="srchtypeposts"/> <label for="srchtypeposts">帖子</label>
<input type="radio" name="st" onclick="window.location=('search.php?srchtype=trade')" <?=$checkarray['trade']?> id="srchtypetrade"/> <label for="srchtypetrade">商品</label>
<? if($qihoo['status']) { ?><input type="radio" name="st" onclick="window.location=('search.php?srchtype=qihoo')" <?=$checkarray['qihoo']?> id="srchtypeqihoo" /> <label for="srchtypeqihoo">奇虎全文</label><? } ?>
<input type="radio" name="st" onclick="window.location=('search.php?srchtype=threadsort')" <?=$checkarray['threadsort']?> id="srchtypesort"/> <label for="srchtypesort">分类信息</label>
</p><? $policymsgs = $p = ''; if(is_array($creditspolicy['search'])) { foreach($creditspolicy['search'] as $id => $policy) { ?><?
$policymsg = <<<EOF

EOF;
 if($extcredits[$id]['img']) { 
$policymsg .= <<<EOF
{$extcredits[$id]['img']} 
EOF;
 } 
$policymsg .= <<<EOF
{$extcredits[$id]['title']} {$policy} {$extcredits[$id]['unit']}
EOF;
?><? $policymsgs .= $p.$policymsg;$p = ', '; } } if($policymsgs) { ?><p>每进行一次搜索将扣除 <?=$policymsgs?></p><? } if($srchtype != 'qihoo') { ?>
<div id="search_option" <? if($checkarray['posts'] && empty($_DCOOKIE['displaysearch_adv'])) { ?>style="display: none;"<? } ?>>
<hr class="shadowline"/>
<h3>搜索选项</h3>
<table summary="搜索" cellspacing="0" cellpadding="0" class="formtable">
<? if($srchtype == 'threadsort') { ?>
<tr>
<th><label for="typeid">分类信息</label></th>
<td>
<select name="sortid" onchange="ajaxget('post.php?action=threadsorts&sortid='+this.options[this.selectedIndex].value+'&operate=1&sid=<?=$sid?>', 'threadsorts', 'threadsortswait')">
<option value="0">无</option><?=$threadsorts?>
</select>
<span id="threadsortswait"></span>
</td>
</tr>
<tbody id="threadsorts"></tbody>
<? } if($checkarray['posts'] || $srchtype == 'trade') { ?>
<tr>
<td>作者</td>
<td><input type="text" id="srchname" name="srchuname" size="45" maxlength="40" class="txt" /></td>
</tr>

<tr>
<td>主题范围</td>
<td>
<label><input type="radio" name="srchfilter" value="all" checked="checked" /> 全部主题</label>
<label><input type="radio" name="srchfilter" value="digest" /> 精华主题</label>
<label><input type="radio" name="srchfilter" value="top" /> 置顶主题</label>
</td>
</tr>
<? } if($checkarray['posts']) { ?>
<tr>
<td>特殊主题</td>
<td>
<label><input type="checkbox" name="special[]" value="1" /> 投票主题</label>
<label><input type="checkbox" name="special[]" value="2" /> 商品主题</label>
<label><input type="checkbox" name="special[]" value="3" /> 悬赏主题</label>
<label><input type="checkbox" name="special[]" value="4" /> 活动主题</label>
<label><input type="checkbox" name="special[]" value="5" /> 辩论主题</label><? if(is_array($threadplugins)) { foreach($threadplugins as $pluginid => $threadplugin) { ?><label><input type="checkbox" name="specialplugin[]" value="<?=$threadplugin['iconid']?>" /> <?=$threadplugin['name']?></label><? } } ?></td>
</tr>
<? } if($srchtype == 'trade') { ?>
<tr>
<td>商品类别</td>
<td>
<select name="srchtypeid"><option value="">全部</option><? if(is_array($tradetypes)) { foreach($tradetypes as $typeid => $typename) { ?><option value="<?=$typeid?>"><?=$typename?></option><? } } ?></select>
</td>
</tr>
<? } if($checkarray['posts'] || $srchtype == 'trade') { ?>
<tr>
<th><label for="srchfrom">搜索时间</label></th>
<td>
<select id="srchfrom" name="srchfrom">
<option value="0">全部时间</option>
<option value="86400">1 天</option>
<option value="172800">2 天</option>
<option value="604800">1 周</option>
<option value="2592000">1 个月</option>
<option value="7776000">3 个月</option>
<option value="15552000">6 个月</option>
<option value="31536000">1 年</option>
</select>
<label><input type="radio" name="before" value="" checked="checked" /> 以内</label>
<label><input type="radio" name="before" value="1" /> 以前</label>
</td>
</tr>

<tr>
<td><label for="orderby">排序类型</label></td>
<td>
<select id="orderby1" name="orderby">
<option value="lastpost" selected="selected">回复时间</option>
<option value="dateline">发布时间</option>
<option value="replies">回复数量</option>
<option value="views">浏览次数</option>
</select>
<select id="orderby2" name="orderby" style="position: absolute; display: none" disabled>
<option value="dateline" selected="selected">发布时间</option>
<option value="price">商品价格</option>
<option value="expiration">剩余时间</option>
</select>
<label><input type="radio" name="ascdesc" value="asc" /> 按升序排列</label>
<label><input type="radio" name="ascdesc" value="desc" checked="checked" /> 按降序排列</label>
</td>
</tr>
<? } ?>

<tr>
<td valign="top"><label for="srchfid">搜索范围</label></td>
<td>
<select id="srchfid" name="srchfid[]" multiple="multiple" size="10" style="width: 26em;">
<option value="all"<? if(!$srchfid) { ?> selected="selected"<? } ?>>全部版块</option>
<?=$forumselect?>
</select>
</td>
</tr>

<? if($srchtype == 'threadsort') { ?>
<tr>
<th>&nbsp;</th>
<td><button class="submit" type="submit" name="searchsubmit" value="true">搜索</button></td>
</tr>
<? } ?>
</table>
</div>
<? } if(empty($srchtype) && empty($keyword)) { ?>
<hr class="shadowline"/>
<h3>便捷搜索</h3>
<table cellspacing="4" cellpadding="0" width="100%">
<tr>
<td><a href="search.php?srchfrom=3600&amp;searchsubmit=yes">1 小时以内的新帖</a></td>
<td><a href="search.php?srchfrom=14400&amp;searchsubmit=yes">4 小时以内的新帖</a></td>
<td><a href="search.php?srchfrom=28800&amp;searchsubmit=yes">8 小时以内的新帖</a></td>
<td><a href="search.php?srchfrom=86400&amp;searchsubmit=yes">24 小时以内的新帖</a></td>
</tr>
<tr>
<td><a href="search.php?srchfrom=604800&amp;searchsubmit=yes">1 周内帖子</a></td>
<td><a href="search.php?srchfrom=2592000&amp;searchsubmit=yes">1 月内帖子</a></td>
<td><a href="search.php?srchfrom=15552000&amp;searchsubmit=yes">6 月内帖子</a></td>
<td><a href="search.php?srchfrom=31536000&amp;searchsubmit=yes">1 年内帖子</a></td>
</tr>
</table>
<? } ?>
</form>

<? if(!empty($searchid) && submitcheck('searchsubmit', 1)) { if($checkarray['posts']) { ?><div class="searchlist threadlist datalist">
<div class="itemtitle s_clear">
<h1><? if($keyword) { ?>结果: <em>找到 “<span class="emfont"><?=$keyword?></span>” 相关主题 <?=$index['threads']?> 个</em><? } else { ?>结果: <em>找到相关主题 <?=$index['threads']?> 个</em><? } ?></h1>
<? if(!empty($multipage)) { ?><?=$multipage?><? } ?>
</div>
<table summary="搜索" cellspacing="0" cellpadding="0" width="100%" class="datatable">
<thead>
<tr class="colplural">
<td class="folder">&nbsp;</td>
<td class="icon">&nbsp;</td>
<th>标题</th>
<td class="forum">版块</td>
<td class="author">作者</td>
<td class="nums">回复/查看</td>
<td class="lastpost"><cite>最后发表</cite></td>
</tr>
</thead><? if(is_array($threadlist)) { foreach($threadlist as $thread) { ?><tbody>
<tr>
<td class="folder">
<a href="viewthread.php?tid=<?=$thread['tid']?>&amp;highlight=<?=$index['keywords']?>" title="新窗口打开" target="_blank">
<? if($thread['folder'] == 'lock') { ?>
<img src="<?=IMGDIR?>/folder_lock.gif" /></a>
<? } else { ?>
<img src="<?=IMGDIR?>/folder_<?=$thread['folder']?>.gif" /></a>
<? } ?>
</td>
<td class="icon">
<? if($thread['special'] == 1) { ?>
<img src="<?=IMGDIR?>/pollsmall.gif" alt="投票" />
<? } elseif($thread['special'] == 2) { ?>
<img src="<?=IMGDIR?>/tradesmall.gif" alt="商品" />
<? } elseif($thread['special'] == 3) { ?>
<img src="<?=IMGDIR?>/rewardsmall.gif" alt="悬赏" />
<? } elseif($thread['special'] == 4) { ?>
<img src="<?=IMGDIR?>/activitysmall.gif" alt="活动" />
<? } elseif($thread['special'] == 5) { ?>
<img src="<?=IMGDIR?>/debatesmall.gif" alt="辩论" />
<? } else { ?>
<?=$thread['icon']?>
<? } ?>
</td>
<th class="subject">
<label>
<? if($thread['digest'] > 0) { ?>
<img src="<?=IMGDIR?>/digest_<?=$thread['digest']?>.gif" alt="精华 <?=$thread['digest']?>" />
<? } ?>
&nbsp;
</label>
<a href="viewthread.php?tid=<?=$thread['tid']?>&amp;highlight=<?=$index['keywords']?>" target="_blank" <?=$thread['highlight']?>><?=$thread['subject']?></a>
<? if($thread['attachment'] == 2) { ?>
<img src="images/attachicons/image_s.gif" alt="图片附件" class="attach" />
<? } elseif($thread['attachment'] == 1) { ?>
<img src="images/attachicons/common.gif" alt="附件" class="attach" />
<? } if($thread['multipage']) { ?><span class="threadpages"><?=$thread['multipage']?></span><? } ?>
</th>
<td class="forum"><a href="forumdisplay.php?fid=<?=$thread['fid']?>"><?=$thread['forumname']?></a></td>
<td class="author">
<cite>
<? if($thread['authorid'] && $thread['author']) { ?>
<a href="space.php?uid=<?=$thread['authorid']?>"><?=$thread['author']?></a>
<? } else { if($forum['ismoderator']) { ?><a href="space.php?uid=<?=$thread['authorid']?>">匿名</a><? } else { ?>匿名<? } } ?>
</cite>
<em><?=$thread['dateline']?></em>
</td>
<td class="nums"><strong><?=$thread['replies']?></strong> / <em><?=$thread['views']?></em></td>
<td class="lastpost">
<cite><? if($thread['lastposter']) { ?><a href="space.php?username=<?=$thread['lastposterenc']?>"><?=$thread['lastposter']?></a><? } else { ?>匿名<? } ?></cite>
<em><a href="redirect.php?tid=<?=$thread['tid']?>&amp;goto=lastpost<?=$highlight?>#lastpost"><?=$thread['lastpost']?></a></em>
</td>
</tr>
</tbody><? } } if(empty($threadlist)) { ?>
<tbody><tr><th colspan="7">对不起，没有找到匹配结果。</th></tr></tbody>
<? } ?>

</table>
<? if(!empty($multipage)) { ?><div class="pages_btns s_clear"><?=$multipage?></div><? } ?>
</div>
<? } elseif($checkarray['threadsort']) { ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
<?=$pluginhooks['global_header']?><div id="nav">
<a href="<?=$indexname?>"><?=$bbname?></a> &raquo; 分类信息
</div>

<div id="wrap" class="wrap s_clear">
<div class="main">
<div class="content">
<div class="searchlist threadlist datalist">
<div class="itemtitle s_clear">
<h1>结果: <em>找到相关主题 <?=$index['threads']?> 个</em></h1>
<? if(!empty($multipage)) { ?><?=$multipage?><? } ?>
</div>
<table summary="搜索" cellspacing="0" cellpadding="0" width="100%" class="datatable">
<thead>
<tr class="colplural">
<td class="icon">&nbsp;</td>
<td>标题</td><? if(is_array($optionlist)) { foreach($optionlist as $var) { ?><td style="width: 10%"><?=$var?></td><? } } ?><td style="width: 15%">发布时间</td>
</tr>
</thead>
<? if($resultlist) { if(is_array($resultlist)) { foreach($resultlist as $tid => $value) { ?><tbody>
<tr>
<td class="icon"><?=$value['icon']?></td>
<th><a href="viewthread.php?tid=<?=$tid?>" target="_blank"><?=$value['subject']?></a></th><? if(is_array($optionlist)) { foreach($optionlist as $identifier => $var) { ?><td style="width: 10%"><? if($value['option'][$identifier]) { ?><?=$value['option'][$identifier]?><? } else { ?>&nbsp;<? } ?></td><? } } ?><td style="width: 15%"><?=$value['dateline']?></td>
</tr>
</tbody><? } } } else { ?>
<tr><td colspan="<?=$colspan?>">对不起，没有找到匹配结果。</td></tr>
<? } ?>
</table>
<? if(!empty($multipage)) { ?><div class="pages_btns s_clear"><?=$multipage?></div><? } ?>
</div>
</div>
</div>
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
</html><? } } ?>

</div>


<script type="text/javascript">
<? if($sortid) { ?>
ajaxget('post.php?action=threadsorts&sortid=<?=$sortid?>&operate=1&inajax=1', 'threadsorts', 'threadsortswait');
<? } ?>
</script>
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