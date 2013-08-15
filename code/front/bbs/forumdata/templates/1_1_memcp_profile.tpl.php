<? if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('memcp_profile');
0
|| checktplrefresh('D:\wwwphp\web\discuz\././templates/default/memcp_profile.htm', 'D:\wwwphp\web\discuz\././templates/default/header.htm', 1312521616, '1', './templates/default')
|| checktplrefresh('D:\wwwphp\web\discuz\././templates/default/memcp_profile.htm', 'D:\wwwphp\web\discuz\././templates/default/seccheck.htm', 1312521616, '1', './templates/default')
|| checktplrefresh('D:\wwwphp\web\discuz\././templates/default/memcp_profile.htm', 'D:\wwwphp\web\discuz\././templates/default/personal_navbar.htm', 1312521616, '1', './templates/default')
|| checktplrefresh('D:\wwwphp\web\discuz\././templates/default/memcp_profile.htm', 'D:\wwwphp\web\discuz\././templates/default/footer.htm', 1312521616, '1', './templates/default')
|| checktplrefresh('D:\wwwphp\web\discuz\././templates/default/memcp_profile.htm', 'D:\wwwphp\web\discuz\././templates/default/jsmenu.htm', 1312521616, '1', './templates/default')
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
<?=$pluginhooks['global_header']?><div id="nav"><a href="<?=$indexname?>"><?=$bbname?></a> &raquo; 个人资料</div>
<div id="wrap" class="wrap with_side s_clear">
<div class="main">
<div class="content">
<script src="<?=$jspath?>calendar.js?<?=VERHASH?>" type="text/javascript"></script>
<script src="<?=$jspath?>bbcode.js?<?=VERHASH?>" type="text/javascript"></script>
<script type="text/javascript">
var charset = '<?=$charset?>';
var maxsigsize = parseInt('<?=$maxsigsize?>');
var maxbiosize = parseInt('<?=$maxbiosize?>');
var allowhtml = 0;
var forumallowhtml = 0;
var allowsmilies = 0;
var allowbbcode = 0;
var allowimgcode = 0;
var allowbiobbcode = parseInt('<?=$allowbiobbcode?>');
var allowbioimgcode = parseInt('<?=$allowbioimgcode?>');
var allowsigbbcode = parseInt('<?=$allowsigbbcode?>');
var allowsigimgcode = parseInt('<?=$allowsigimgcode?>');

function parseurl(str, mode) {
str = str.replace(/([^>=\]"'\/]|^)((((https?|ftp):\/\/)|www\.)([\w\-]+\.)*[\w\-\u4e00-\u9fa5]+\.([\.a-zA-Z0-9]+|\u4E2D\u56FD|\u7F51\u7EDC|\u516C\u53F8)((\?|\/|:)+[\w\.\/=\?%\-&~`@':+!]*)+\.(jpg|gif|png|bmp))/ig, mode == 'html' ? '$1<img src="$2" border="0">' : '$1[img]$2[/img]');
str = str.replace(/([^>=\]"'\/@]|^)((((https?|ftp|gopher|news|telnet|rtsp|mms|callto|bctp|ed2k):\/\/)|www\.)([\w\-]+\.)*[:\.@\-\w\u4e00-\u9fa5]+\.([\.a-zA-Z0-9]+|\u4E2D\u56FD|\u7F51\u7EDC|\u516C\u53F8)((\?|\/|:)+[\w\.\/=\?%\-&~`@':+!#]*)*)/ig, mode == 'html' ? '$1<a href="$2" target="_blank">$2</a>' : '$1[url]$2[/url]');
str = str.replace(/([^\w>=\]:"'\.\/]|^)(([\-\.\w]+@[\.\-\w]+(\.\w+)+))/ig, mode == 'html' ? '$1<a href="mailto:$2">$2</a>' : '$1[email]$2[/email]');
return str;
}

function validate(theform) {
<? if($typeid == 2) { if($maxsigsize) { ?>
if(mb_strlen(theform.signaturenew.value) > maxsigsize) {
alert('您的签名长度超过 <?=$maxsigsize?> 字符的限制，请返回修改。');
return false;
}
<? } ?>
if(mb_strlen(theform.bionew.value) > maxbiosize) {
alert('您的自我介绍长度超过 <?=$maxbiosize?> 字符的限制，请返回修改。');
return false;
}
<? if(!$member['signature']) { ?>$('signaturemessage').click();<? } if(!$member['bio']) { ?>$('biomessage').click();<? } } ?>
return true;
}

function updateavatar(updatenewbietask) {
$('avatar').src='<? echo discuz_uc_avatar($discuz_uid, 'middle', TRUE); if($avatarmethod) { ?>?<? } else { ?>&<? } ?>random=1'+Math.random();
<? if($prompts['newbietask'] && $newbietaskid && $newbietasks[$newbietaskid]['scriptname'] == 'uploadavatar') { ?>
if(isUndefined(updatenewbietask)) {
ajaxget('task.php?action=updatenewbietask&scriptname=uploadavatar', 'avatarctrl');
}
<? } ?>
if(document.body.stat) document.body.stat('avatar_update_succeed', 'memcp.php');
}

function updatetextarea(id, msg) {
$(id).updated = 0;
$(id).value = msg;
$(id).style.color = '<?=LIGHTTEXT?>';
$(id).onclick = function(){
this.style.color = '<?=TABLETEXT?>';
this.value = '';
$(id).onclick = null;
}
}
</script>
<form name="reg" method="post" action="memcp.php?action=profile&amp;typeid=<?=$typeid?>" onSubmit="return validate(this)" style="zoom:1">
<input type="hidden" name="formhash" value="<?=FORMHASH?>" />
<? if($typeid == 1) { ?>
<h1>密码和安全问题</h1>
<div class="channelinfo">您必须填写原密码才能修改下面的资料</div>
<table summary="个人资料" cellspacing="0" cellpadding="0" class="formtable">
<? if($secqaacheck || $seccodecheck) { ?>
<tr>
<th><label for="oldpassword">验证</label></th>
<td><? if($secqaacheck) { ?>
<input name="secanswer" id="secanswer" type="text" autocomplete="off" style="width:50px" value="验证问答" class="txt" href="ajax.php?action=updatesecqaa" tabindex="1">
<span id="checksecanswer"><img src="images/common/none.gif" width="16" height="16"></span>
<? } if($seccodecheck) { ?>
<input name="seccodeverify" id="seccodeverify_<?=CURSCRIPT?>" type="text" autocomplete="off" style="width:50px" value="验证码" class="txt" href="ajax.php?action=updateseccode" tabindex="1">
<a href="javascript:;" onclick="updateseccode();doane(event);">换一个</a>
<span id="checkseccodeverify_<?=CURSCRIPT?>"><img src="images/common/none.gif" width="16" height="16"></span>
<? } ?>

<script type="text/javascript" reload="1">
var profile_seccode_invalid = '验证码输入错误，请重新填写。';
var profile_secanswer_invalid = '验证问答回答错误，请重新填写。';
var lastseccode = lastsecanswer = secfocus ='';
var secanswerObj = $('secanswer');
var seccodeObj = $('seccodeverify_<?=CURSCRIPT?>');
var secstatus = {'secanswer':0,'seccodeverify_<?=CURSCRIPT?>':0};

if(secanswerObj) {
secanswerObj.onclick = secanswerObj.onfocus = showIdentifying;
secanswerObj.onblur = function(e) {if(!secfocus) $('secanswer_menu').style.display='none';checksecanswer();doane(e);};
}

if(seccodeObj) {
seccodeObj.onclick = seccodeObj.onfocus = showIdentifying;
seccodeObj.onblur = function(e) {if(!secfocus) $('seccodeverify_<?=CURSCRIPT?>_menu').style.display='none';checkseccode();doane(e);};
}

function showIdentifying(e) {
var obj = BROWSER.ie ? event.srcElement : e.target;
if(!$(obj.id + '_menu')) {
obj.value = '';
ajaxmenu($(obj.id), 0, 1, 3, '12', function() {
secstatus[obj.id] = 1;
$(obj.id + '_menu').onmouseover = function() { secfocus = 1; }
$(obj.id + '_menu').onmouseout = function() { secfocus = '';$(obj.id).focus(); }
});
} else if(secstatus[obj.id] == 1) {
$(obj.id + '_menu').style.display = '';
}
obj.unselectable = 'off';
obj.focus();
doane(e);
}

function updateseccode(op) {
if(isUndefined(op)) {
ajaxget('ajax.php?action=updateseccode', seccodeObj.id + '_menu', 'ajaxwaitid', '', '', '$(seccodeObj.id + \'_menu\').style.display = \'\'');
} else {
window.document.seccodeplayer.SetVariable("isPlay", "1");
}
seccodeObj.focus();
}

function checkseccode() {
var seccodeverify = seccodeObj.value;
if(seccodeverify == lastseccode) {
return;
} else {
lastseccode = seccodeverify;
}
var cs = $('checkseccodeverify_<?=CURSCRIPT?>');
<? if($seccodedata['type'] != 1) { ?>
if(!(/[0-9A-Za-z]{4}/.test(seccodeverify))) {
warning(cs, profile_seccode_invalid);
return;
}
<? } else { ?>
if(seccodeverify.length != 2) {
warning(cs, profile_seccode_invalid);
return;
}
<? } ?>
ajaxresponse('checkseccodeverify_<?=CURSCRIPT?>', 'action=checkseccode&seccodeverify=' + (BROWSER.ie && document.charset == 'utf-8' ? encodeURIComponent(seccodeverify) : seccodeverify));
}

function checksecanswer() {
        var secanswer = secanswerObj.value;
if(secanswer == lastsecanswer) {
return;
} else {
lastsecanswer = secanswer;
}
ajaxresponse('checksecanswer', 'action=checksecanswer&secanswer=' + (BROWSER.ie && document.charset == 'utf-8' ? encodeURIComponent(secanswer) : secanswer));
}

function ajaxresponse(objname, data) {
var x = new Ajax('XML', objname);
x.get('ajax.php?inajax=1&' + data, function(s){
        var obj = $(objname);
        if(s.substr(0, 7) == 'succeed') {
        	obj.style.display = '';
                obj.innerHTML = '<img src="<?=IMGDIR?>/check_right.gif" width="16" height="16" />';
obj.className = "warning";
} else {
warning(obj, s);
}
});
}

function warning(obj, msg) {
if((ton = obj.id.substr(5, obj.id.length)) != 'password2') {
$(ton).select();
}
obj.style.display = '';
obj.innerHTML = '<img src="<?=IMGDIR?>/check_error.gif" width="16" height="16" />';
obj.className = "warning";
}
</script></td>
<td></td>
</tr>
<? } ?>
<tr>
<th><label for="oldpassword">原密码</label></th>
<td><input type="password" name="oldpassword" id="oldpassword" size="25" class="txt" /></td>
<td>必填</td>
</tr>

<tr>
<th><label for="newpassword">新密码</label></th>
<td><input type="password" name="newpassword" id="newpassword" size="25" class="txt" /></td>
<td>如不需要更改密码，此处请留空</td>
</tr>

<tr>
<th><label for="newpassword2">确认新密码</label></th>
<td><input type="password" name="newpassword2" id="newpassword2" size="25" class="txt" /></td>
<td></td>
</tr>

<tr>
<th><label for="emailnew">Email</label></th>
<td><input type="text" name="emailnew" id="emailnew" size="25" value="<?=$member['email']?>" class="txt" /></td>
<td>
<? if($regverify == 1 && (($grouptype == 'member' && $adminid == 0) && $groupid == 8)) { ?> !如更改地址，系统将修改您的密码并重新验证其有效性，请慎用<? } ?>
</td>
</tr>

<tr>
<th><label for="questionidnew">安全提问</label></th>
<td><select name="questionidnew" id="questionidnew">
<? if($discuz_secques) { ?><option value="">保持原有的安全提问和答案</option><? } ?>
<option value="0">无安全提问</option>
<option value="1">母亲的名字</option>
<option value="2">爷爷的名字</option>
<option value="3">父亲出生的城市</option>
<option value="4">您其中一位老师的名字</option>
<option value="5">您个人计算机的型号</option>
<option value="6">您最喜欢的餐馆名称</option>
<option value="7">驾驶执照的最后四位数字</option>
</select>
</td>
<td>如果您启用安全提问，登录时需填入相应的项目才能登录</td>
</tr>

<tr>
<th><label for="answernew">回答</label></th>
<td><input type="text" name="answernew" id="answernew" size="25" class="txt" /></td>
<td>如您设置新的安全提问，请在此输入答案</td>
</tr>

<? } elseif($typeid == 2) { ?>
<link href="forumdata/cache/style_<?=STYLEID?>_seditor.css?<?=VERHASH?>" rel="stylesheet" type="text/css" />
<h1>个人资料</h1>
<table summary="个人资料" cellspacing="0" cellpadding="0" class="formtable">
<? if($secqaacheck || $seccodecheck) { ?>
<tr>
<th><label for="oldpassword">验证</label></th>
<td><? include template('seccheck', '0', ''); ?></td>
</tr>
<? } if($allownickname) { ?>
<tr>
<th><label for="nicknamenew">昵称</label></th>
<td><input type="text" name="nicknamenew" id="nicknamenew" size="25" value="<?=$member['nickname']?>" class="txt" /></td>
</tr>
<? } if($allowcstatus) { ?>
<tr>
<th><label for="cstatusnew">自定义头衔</label></th>
<td><input type="text" name="cstatusnew" id="cstatusnew" size="25" value="<?=$member['customstatus']?>" class="txt" /></td>
</tr>
<? } if($maxsigsize) { ?>
<tr>
<th valign="top"><label for="signaturemessage">个人签名<br /><a href="javascript:;" onclick="allowbbcode = allowsigbbcode;allowimgcode = allowsigimgcode;$('signaturepreview').innerHTML = bbcode2html($('signaturemessage').value)">预览</a></label></th>
<td valign="top">
<div id="signaturepreview"></div>
<? if($allowsigbbcode) { ?>
<div class="editor_tb" style="width: 274px">
<div>
<a href="javascript:;" title="粗体" class="tb_bold" onclick="seditor_insertunit('signature', '[b]', '[/b]')">B</a>
<? if($allowsigimgcode) { ?><a href="javascript:;" title="图片" class="tb_img" onclick="seditor_insertunit('signature', '[img]', '[/img]')">Image</a><? } ?>
<a href="javascript:;" title="插入链接" class="tb_link" onclick="seditor_insertunit('signature', '[url]', '[/url]')">Link</a>
<? if($member['msn']['1']) { ?>
<a href="javascript:;" title="插入我的 MSN 在线通" class="tb_imme" onclick="seditor_insertunit('signature', '[imme]')">Imme</a>
<? } ?>
</div>
</div>
<? } ?>
<textarea rows="8" cols="30" id="signaturemessage" name="signaturenew" class="txtarea" <? if($allowsigbbcode) { ?>style="margin-top; -1px; border-top: none;"<? } ?>><?=$member['signature']?></textarea>
<span class="left">
<a href="faq.php?action=faq&amp;id=5&amp;messageid=18" target="_blank">Discuz!代码</a> <? if($allowsigbbcode) { ?>可用<? } else { ?>禁用<? } ?><br />
[img] 代码 <? if($allowsigimgcode) { ?>可用<? } else { ?>禁用<? } ?>
</span>
</td>
</tr>
<? } ?>

<tr>
<th valign="top"><label for="biomessage">自我介绍<br /><a href="javascript:;" onclick="allowbbcode = allowbiobbcode;allowimgcode = allowbioimgcode;$('biopreview').innerHTML = bbcode2html($('biomessage').value)">预览</a></label></th>
<td>
<div id="biopreview"></div>
<? if($allowsigbbcode) { ?>
<div class="editor_tb" style="width: 274px">
<div>
<a href="javascript:;" title="粗体" class="tb_bold" onclick="seditor_insertunit('bio', '[b]', '[/b]')">B</a>
<? if($allowsigimgcode) { ?><a href="javascript:;" title="图片" class="tb_img" onclick="seditor_insertunit('bio', '[img]', '[/img]')">Image</a><? } ?>
<a href="javascript:;" title="插入链接" class="tb_link" onclick="seditor_insertunit('bio', '[url]', '[/url]')">Link</a>
<? if($member['msn']['1']) { ?>
<a href="javascript:;" title="插入我的 MSN 在线通" class="tb_imme" onclick="seditor_insertunit('bio', '[imme]')">Imme</a>
<? } ?>
</div>
</div>
<? } ?>
<textarea rows="8" cols="30" id="biomessage" name="bionew" class="txtarea" <? if($allowsigbbcode) { ?>style="margin-top; -1px; border-top: none;"<? } ?>><?=$member['bio']?></textarea>
<span class="left">
<a href="faq.php?action=faq&amp;id=5&amp;messageid=18" target="_blank">Discuz!代码</a> <? if($allowbiobbcode) { ?>可用<? } else { ?>禁用<? } ?><br />
[img] 代码 <? if($allowbioimgcode) { ?>可用<? } else { ?>禁用<? } ?>
</span>
</td>
</tr>

<tr>
<th>性别</th>
<td>
<select name="gendernew">
<option value="1" <?=$gendercheck['1']?>>男</option>
<option value="2" <?=$gendercheck['2']?>>女</option>
<option value="0" <?=$gendercheck['0']?>>保密</option>
</select>
</td>
</tr>

<tr>
<th><label for="bdaynew">生日</label></th>
<td><input type="text" name="bdaynew" id="bdaynew" size="25" onclick="showcalendar(event, this)" onfocus="showcalendar(event, this);if(this.value=='0000-00-00')this.value=''" value="<?=$member['bday']?>" class="txt" prompt="modifyprofile_birthday" /></td>
</tr>

<tr>
<th><label for="locationnew">来自</label></th>
<td><input type="text" name="locationnew" id="locationnew" size="25" value="<?=$member['location']?>" class="txt" /></td>
</tr>

<? if(!empty($_DCACHE['fields_required']) || !empty($_DCACHE['fields_optional'])) { if($_DCACHE['fields_required']) { if(is_array($_DCACHE['fields_required'])) { foreach($_DCACHE['fields_required'] as $field) { ?><tr>
<th><?=$field['title']?></th>
<td>
<? if($field['selective']) { ?>
<select name="field_<?=$field['fieldid']?>new" <? if($member['field_'.$field['fieldid']] && $field['unchangeable']) { ?>disabled<? } ?>>
<option value="">- 请选择 -</option><? if(is_array($field['choices'])) { foreach($field['choices'] as $index => $choice) { ?><option value="<?=$index?>" <? if($index == $member['field_'.$field['fieldid']]) { ?>selected="selected"<? } ?>><?=$choice?></option><? } } ?></select>
<? } else { ?>
<input type="text" name="field_<?=$field['fieldid']?>new" size="25" value="<?=$member['field_'.$field['fieldid']]?>" <? if($member['field_'.$field['fieldid']] && $field['unchangeable']) { ?>disabled<? } ?> class="txt" />
<? } if($field['description']) { ?>&nbsp;&nbsp;<?=$field['description']?><? } if($field['unchangeable']) { ?>&nbsp;&nbsp;请认真填写本项目，一旦确定将不可修改<? } ?>
</td>
</tr><? } } } if($_DCACHE['fields_optional']) { if(is_array($_DCACHE['fields_optional'])) { foreach($_DCACHE['fields_optional'] as $field) { ?><tr>
<th><label for="field_<?=$field['fieldid']?>new"><?=$field['title']?></label></th>
<td>
<? if($field['selective']) { ?>
<select name="field_<?=$field['fieldid']?>new" id="field_<?=$field['fieldid']?>new" <? if($member['field_'.$field['fieldid']] && $field['unchangeable']) { ?>disabled<? } ?>>
<option value="">- 请选择 -</option><? if(is_array($field['choices'])) { foreach($field['choices'] as $index => $choice) { ?><option value="<?=$index?>" <? if($index == $member['field_'.$field['fieldid']]) { ?>selected="selected"<? } ?>><?=$choice?></option><? } } ?></select>
<? } else { ?>
<input type="text" name="field_<?=$field['fieldid']?>new" size="25" value="<?=$member['field_'.$field['fieldid']]?>" <? if($member['field_'.$field['fieldid']] && $field['unchangeable']) { ?>disabled<? } ?> class="txt" />
<? } if($field['description']) { ?>&nbsp;&nbsp;<?=$field['description']?><? } if($field['unchangeable']) { ?>&nbsp;&nbsp;请认真填写本项目，一旦确定将不可修改<? } ?>
</td>
</tr><? } } } } ?>

<tr class="sep_space"><th colspan="2"></th></tr>

<tr>
<th><label for="sitenew">个人网站</label></th>
<td><input type="text" name="sitenew" id="sitenew" size="25" value="<? if($member['site']) { ?><?=$member['site']?><? } else { ?>http://<? } ?>" class="txt" /></td>
</tr>

<tr>
<th><label for="qqnew">QQ</label></th>
<td><input type="text" name="qqnew" id="qqnew" size="25" value="<?=$member['qq']?>" class="txt"  prompt="modifyprofile_qq" /></td>
</tr>

<tr>
<th><label for="icqnew">ICQ</label></th>
<td><input type="text" name="icqnew" id="icqnew" size="25" value="<?=$member['icq']?>" class="txt" /></td>
</tr>

<tr>
<th><label for="yahoonew">Yahoo</label></th>
<td><input type="text" name="yahoonew" id="yahoonew" size="25" value="<?=$member['yahoo']?>" class="txt" /></td>
</tr>

<tr>
<th><label for="alipaynew">支付宝账号</label></th>
<td><input type="text" name="alipaynew" id="alipaynew" size="25" value="<?=$member['alipay']?>" class="txt" /></td>
</tr>

<tr>
<th><label for="taobaonew">阿里旺旺</label></th>
<td><input type="text" name="taobaonew" id="taobaonew" size="25" value="<?=$member['taobao']?>" class="txt" /></td>
</tr>

<tr class="sep_space"><th colspan="2"></th></tr>

<tr>
<th><label for="msnnew">MSN</label></th>
<td>
<input type="text" name="msnnew" id="msnnew" size="25" value="<?=$member['msn']['0']?>" class="txt" />
</td>
</tr>

<tr>
<th><label for="imme">MSN 在线通</label></th>
<td>
<? if($member['msn']['1']) { ?>
您已经成功绑定了 MSN&nbsp;&nbsp;
<a href="http://settings.messenger.live.com/applications/websignup.aspx?returnurl=<?=$boardurl?>misc.php?action=imme_binding&amp;privacyurl=<?=$boardurl?>" target="_blank" class="emfont">更换绑定的 MSN 帐号</a>&nbsp;&nbsp;
<a href="<?=$boardurl?>misc.php?action=imme_cancelbinding" target="_blank" class="emfont">取消 MSN 绑定</a>
<? } else { ?>
您还没有绑定 MSN&nbsp;&nbsp;
<a href="http://im.live.cn/imme/index.htm" target="_blank">什么是 MSN 在线通</a><br />
<a href="https://domains.live.com/members/signup.aspx?domain=<?=$msn['domain']?>" target="_blank">注册 MSN ID</a>&nbsp;&nbsp;
<a href="http://im.live.cn" target="_blank">下载 MSN</a>&nbsp;&nbsp;
<a href="http://settings.messenger.live.com/applications/websignup.aspx?returnurl=<?=$boardurl?>misc.php?action=imme_binding&amp;privacyurl=<?=$boardurl?>" target="_blank">启用 MSN 在线通</a>
<? } ?>
</td>
</tr>

<script type="text/javascript">
<? if(!$member['signature'] && $maxsigsize) { ?>updatetextarea('signaturemessage', '<?=$maxsigsize?> 字节以内\n不支持自定义 Discuz! 代码');<? } if(!$member['bio']) { ?>updatetextarea('biomessage', '<?=$maxbiosize?> 字节以内\n不支持自定义 Discuz! 代码');<? } ?>
</script>

<? } elseif($typeid == 3) { ?>
<h1>修改头像</h1>
<table summary="修改头像" cellspacing="0" cellpadding="0" class="formtable">
<tr>
<th></th>
<td>
<div class="avatararea">
<p><img id="avatar" src="images/common/none.gif" onerror="this.onerror=null;this.src='<?=UC_API?>/images/noavatar_middle.gif'" /></p>
</div>
<div id="avatarctrl"><script type="text/javascript">updateavatar(false);document.write(AC_FL_RunContent('<? echo implode("','", $uc_avatarflash);; ?>'));</script></div>
</td>
</tr>

<? } elseif($typeid == 5) { ?>
<h1>论坛个性化设定</h1>
<table summary="个人资料" cellspacing="0" cellpadding="0" class="formtable">
<? if($secqaacheck || $seccodecheck) { ?>
<tr>
<th><label for="oldpassword">验证</label></th>
<td><? include template('seccheck', '0', ''); ?></td>
</tr>
<? } ?>
<tr>
<th>界面风格</th>
<td>
<select name="styleidnew">
<option value="">使用默认</option>
<?=$styleselect?></select>
</td>
</tr>

<tr>
<th>每页主题数</th>
<td>
<label><input type="radio" name="tppnew" value="0" <?=$tppchecked['0']?>> 使用默认</label>
<label><input type="radio" name="tppnew" value="10" <?=$tppchecked['10']?>> 10</label>
<label><input type="radio" name="tppnew" value="20" <?=$tppchecked['20']?>> 20</label>
<label><input type="radio" name="tppnew" value="30" <?=$tppchecked['30']?>> 30</label>
</td>
</tr>

<tr>
<th>每页帖数</th>
<td>
<label><input type="radio" name="pppnew" value="0" <?=$pppchecked['0']?>> 使用默认</label>
<label><input type="radio" name="pppnew" value="5" <?=$pppchecked['5']?>> 5</label>
<label><input type="radio" name="pppnew" value="10" <?=$pppchecked['10']?>> 10</label>
<label><input type="radio" name="pppnew" value="15" <?=$pppchecked['15']?>> 15</label>
</td>
</tr>

<tr class="sep_space"><th colspan="2"></th></tr>

<tr>
<th>签名显示设置</th>
<td>
<label><input type="radio" name="ssnew" value="2" <?=$sschecked['2']?>> 使用默认</label>
<label><input type="radio" name="ssnew" value="1" <?=$sschecked['1']?>> 显示签名</label>
<label><input type="radio" name="ssnew" value="0" <?=$sschecked['0']?>> 不显示签名</label>
</td>
</tr>

<tr>
<th>头像显示设置</th>
<td>
<label><input type="radio" name="sanew" value="2" <?=$sachecked['2']?>> 使用默认</label>
<label><input type="radio" name="sanew" value="1" <?=$sachecked['1']?>> 显示头像</label>
<label><input type="radio" name="sanew" value="0" <?=$sachecked['0']?>> 不显示头像</label>
</td>
</tr>

<tr>
<th>图片显示设置</th>
<td>
<label><input type="radio" name="sinew" value="2" <?=$sichecked['2']?>> 使用默认</label>
<label><input type="radio" name="sinew" value="1" <?=$sichecked['1']?>> 显示图片</label>
<label><input type="radio" name="sinew" value="0" <?=$sichecked['0']?>> 不显示图片</label>
&nbsp;&nbsp;包括上传的附件图片和 [img] 代码图片
</td>
</tr>

<tr>
<th>编辑器模式</th>
<td>
<label><input type="radio" name="editormodenew" value="2" <?=$emcheck['2']?>> 使用默认</label>
<label><input type="radio" name="editormodenew" value="0" <?=$emcheck['0']?>> Discuz! 代码模式</label>
<label><input type="radio" name="editormodenew" value="1" <?=$emcheck['1']?>> 所见即所得模式</label>
</td>
</tr>

<tr class="sep_space"><th colspan="2"></th></tr>

<tr>
<th>时差设定</th>
<td>
<select name="timeoffsetnew">
<option value="9999" <?=$toselect['9999']?>>使用默认</option>
<option value="-12" <?=$toselect['-12']?>>(GMT -12:00) Eniwetok, Kwajalein</option>
<option value="-11" <?=$toselect['-11']?>>(GMT -11:00) Midway Island, Samoa</option>
<option value="-10" <?=$toselect['-10']?>>(GMT -10:00) Hawaii</option>
<option value="-9" <?=$toselect['-9']?>>(GMT -09:00) Alaska</option>
<option value="-8" <?=$toselect['-8']?>>(GMT -08:00) Pacific Time (US &amp; Canada), Tijuana</option>
<option value="-7" <?=$toselect['-7']?>>(GMT -07:00) Mountain Time (US &amp; Canada), Arizona</option>
<option value="-6" <?=$toselect['-6']?>>(GMT -06:00) Central Time (US &amp; Canada), Mexico City</option>
<option value="-5" <?=$toselect['-5']?>>(GMT -05:00) Eastern Time (US &amp; Canada), Bogota, Lima, Quito</option>
<option value="-4" <?=$toselect['-4']?>>(GMT -04:00) Atlantic Time (Canada), Caracas, La Paz</option>
<option value="-3.5" <?=$toselect['-3.5']?>>(GMT -03:30) Newfoundland</option>
<option value="-3" <?=$toselect['-3']?>>(GMT -03:00) Brassila, Buenos Aires, Georgetown, Falkland Is</option>
<option value="-2" <?=$toselect['-2']?>>(GMT -02:00) Mid-Atlantic, Ascension Is., St. Helena</option>
<option value="-1" <?=$toselect['-1']?>>(GMT -01:00) Azores, Cape Verde Islands</option>
<option value="0"  <?=$toselect['0']?>>(GMT) Casablanca, Dublin, Edinburgh, London, Lisbon, Monrovia</option>
<option value="1" <?=$toselect['1']?>>(GMT +01:00) Amsterdam, Berlin, Brussels, Madrid, Paris, Rome</option>
<option value="2" <?=$toselect['2']?>>(GMT +02:00) Cairo, Helsinki, Kaliningrad, South Africa</option>
<option value="3" <?=$toselect['3']?>>(GMT +03:00) Baghdad, Riyadh, Moscow, Nairobi</option>
<option value="3.5" <?=$toselect['3.5']?>>(GMT +03:30) Tehran</option>
<option value="4" <?=$toselect['4']?>>(GMT +04:00) Abu Dhabi, Baku, Muscat, Tbilisi</option>
<option value="4.5" <?=$toselect['4.5']?>>(GMT +04:30) Kabul</option>
<option value="5" <?=$toselect['5']?>>(GMT +05:00) Ekaterinburg, Islamabad, Karachi, Tashkent</option>
<option value="5.5" <?=$toselect['5.5']?>>(GMT +05:30) Bombay, Calcutta, Madras, New Delhi</option>
<option value="5.75" <?=$toselect['5.75']?>>(GMT +05:45) Katmandu</option>
<option value="6" <?=$toselect['6']?>>(GMT +06:00) Almaty, Colombo, Dhaka, Novosibirsk</option>
<option value="6.5" <?=$toselect['6.5']?>>(GMT +06:30) Rangoon</option>
<option value="7" <?=$toselect['7']?>>(GMT +07:00) Bangkok, Hanoi, Jakarta</option>
<option value="8" <?=$toselect['8']?>>(GMT +08:00) Beijing, Hong Kong, Perth, Singapore, Taipei</option>
<option value="9" <?=$toselect['9']?>>(GMT +09:00) Osaka, Sapporo, Seoul, Tokyo, Yakutsk</option>
<option value="9.5" <?=$toselect['9.5']?>>(GMT +09:30) Adelaide, Darwin</option>
<option value="10" <?=$toselect['10']?>>(GMT +10:00) Canberra, Guam, Melbourne, Sydney, Vladivostok</option>
<option value="11" <?=$toselect['11']?>>(GMT +11:00) Magadan, New Caledonia, Solomon Islands</option>
<option value="12" <?=$toselect['12']?>>(GMT +12:00) Auckland, Wellington, Fiji, Marshall Island</option>
</select>
</td>
</tr>

<tr>
<th>时间格式</th>
<td>
<label><input type="radio" name="timeformatnew" value="0" <?=$tfcheck['0']?>> 使用默认</label>
<label><input type="radio" name="timeformatnew" value="1" <?=$tfcheck['1']?>> 12 小时</label>
<label><input type="radio" name="timeformatnew" value="2" <?=$tfcheck['2']?>> 24 小时</label>
</td>
</tr>

<tr>
<th>日期格式</th>
<td>
<label><input type="radio" name="dateformatnew" <?=$dfcheck['0']?>> 使用默认</label><? if(is_array($dateformatlist)) { foreach($dateformatlist as $key => $value) { ?><label><input type="radio" name="dateformatnew" value="<?=$key?>" <?=$dfcheck[$key]?>> <?=$value?></label><? } } ?></td>
</tr>

<? if($dateconvert) { ?>
<tr>
<th>人性化时间格式</th>
<td>
<label><input type="radio" name="dateconvertnew" value="0" <?=$dateconvertchecked['0']?>> 启用</label>
<label><input type="radio" name="dateconvertnew" value="1" <?=$dateconvertchecked['1']?>> 不启用</label>
</td>
</tr>
<? } else { ?>
<input name="dateconvertnew" type="hidden" value="0" />
<? } ?>

<tr class="sep_space"><th colspan="2"></th></tr>

<? if($creditnotice) { ?>
<tr>
<th>积分变动提示</th>
<td>
<label><input type="radio" name="creditnoticenew" value="1" <?=$creditnoticechecked['1']?>> 是</label>
<label><input type="radio" name="creditnoticenew" value="0" <?=$creditnoticechecked['0']?>> 否</label>
</td>
</tr>
<? } ?>
<tr>
<th>提醒</th>
<td><? if(is_array($prompts)) { foreach($prompts as $promptkey => $promptdata) { if($promptkey != 'newbietask') { ?><label class="left" style="width:150px"><input type="checkbox" name="disablepromptnew[<?=$promptkey?>]" value="1" <? if(!in_array($promptkey, $disableprompt)) { ?>checked="checked" <? } ?>/> <?=$promptdata['name']?></label><? } } } ?></td>
</tr>
<tr>
<th>短消息提示音</th>
<td>
<label><input type="radio" value="0" name="pmsoundnew" <?=$pscheck['0']?> /> 无</label>
<label><input type="radio" onclick="soundplayer(1)" value="1" name="pmsoundnew" <?=$pscheck['1']?> /> #1</label>
<label><input type="radio" onclick="soundplayer(2)" value="2" name="pmsoundnew" <?=$pscheck['2']?> /> #2</label>
<label><input type="radio" onclick="soundplayer(3)" value="3" name="pmsoundnew" <?=$pscheck['3']?> /> #3</label>
<div id="soundplayerlayer" style="position:absolute;top:-100000px"></div>
<script type="text/javascript" reload="1">
function soundplayer(file) {
$('soundplayerlayer').innerHTML = AC_FL_RunContent('id', 'pmsoundplayer', 'name', 'pmsoundplayer', 'width', '0', 'height', '0', 'src', '<?=$boardurl?>images/sound/player.swf', 'FlashVars', 'sFile=<?=$boardurl?>images/sound/pm_' + file + '.mp3', 'menu', 'false',  'allowScriptAccess', 'sameDomain', 'swLiveConnect', 'true');
}
</script>
</td>
</tr>
<? if($uchome['addfeed'] && $ucappopen['UCHOME']) { ?>
<tr>
<th>加入事件设置</th>
<td>
<label><input type="radio" value="0" name="customaddfeednew" onclick="$('customaddfeed').style.display = 'none';" <?=$defaultcheck?> class="radio" /> 默认</label>
<label><input type="radio" name="customaddfeednew" onclick="$('customaddfeed').style.display = '';" <?=$customcheck?> class="radio" /> 自定义</label>
<span id="customaddfeed" style="display: <?=$showfeedcheck?>">
<label><input type="checkbox" name="addfeed[1]" value="1" <?=$feedchecks['1']?> class="checkbox" /> 普通主题</label>
<label><input type="checkbox" name="addfeed[2]" value="1" <?=$feedchecks['2']?> class="checkbox" /> 特殊主题</label>
<label><input type="checkbox" name="addfeed[3]" value="1" <?=$feedchecks['3']?> class="checkbox" /> 参与/回复主题</label>
</span>
</td>
</tr>
<? } ?>

<tr>
<th valign="top">其他选项</th>
<td>
<? if($allowinvisible) { ?>
<label><input type="checkbox" name="invisiblenew" value="1" <?=$invisiblechecked?> class="checkbox" /> 在线列表中隐身</label><br />
<? } ?>
<label><input type="checkbox" name="showemailnew" value="1" <?=$emailchecked?> class="checkbox" /> Email 地址可见</label><br />
<label><input type="checkbox" name="newsletternew" value="1" <?=$newschecked?> class="checkbox" /> 同意接收论坛通知 (Email 或短消息)</label><br />
</td>
</tr>
<? } ?>

<?=$pluginhooks['memcp_profilesettings']?>

<? if($typeid != 3) { ?>
<tr>
<th>&nbsp;</th>
<td><button type="submit" class="submit" name="editsubmit" id="editsubmit" value="true" prompt="modifyprofile_submit">提交</button></td>
</tr>
<? } ?>
</table>
</form>
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