<? if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('login');
0
|| checktplrefresh('D:\wwwphp\web\caipiao\code\front\bbs\././templates/default/login.htm', 'D:\wwwphp\web\caipiao\code\front\bbs\././templates/default/seccheck.htm', 1313724973, '1', './templates/default')
;?><? include template('header', '0', ''); if(!empty($message)) { ?>
<?=$ucsynlogin?>
<script type="text/javascript" reload="1">
<? if($message == 2) { ?>
hideWindow('login');
showWindow('register', '<?=$location?>');
<? } elseif($message == 1) { ?>
display('main_messaqge');
display('layer_login');
display('layer_message');
<? if($groupid == 8) { ?>
$('messageleft').innerHTML = '<p>欢迎您回来 <?=$usergroups?> <?=$discuz_user?></p><p>您的帐号处于非激活状态</p>';
$('messageright').innerHTML = '<a href="memcp.php">个人中心</a>';
setTimeout("window.location.href='memcp.php'", <?=$mrefreshtime?>);
<? } else { ?>
$('messageleft').innerHTML = '<p>欢迎您回来 <?=$usergroups?> <?=$discuz_user?></p>';
<? if(!empty($floatlogin)) { ?>
$('messageright').innerHTML = '<a href="javascript:;" onclick="location.reload()">如果页面没有响应，请点这里刷新</a>';
setTimeout('location.reload()', <?=$mrefreshtime?>);
<? } else { $dreferer = str_replace('&amp;', '&', dreferer()); ?>$('messageright').innerHTML = '<a href="<?=$dreferer?>">现在将转入登录前页面</a>';
setTimeout("window.location.href='<?=$dreferer?>'", <?=$mrefreshtime?>);
<? } } if($_DCACHE['settings']['frameon'] && $_DCOOKIE['frameon'] == 'yes') { ?>
if(top != self) {
parent.leftmenu.location.reload();
}
<? } } ?>
</script>
<? } else { if(empty($infloat)) { ?>
<div id="nav"><a href="<?=$indexname?>"><?=$bbname?></a> <?=$navigation?></div>
<div id="wrap" class="wrap s_clear">
<div class="main"><div class="content nofloat">
<? } ?>
<div class="fcontent" id="main_messaqge">
<div id="layer_login">
<h3 class="float_ctrl">
<em id="returnmessage">用户登录</em>
<span><? if(!empty($infloat)) { ?><a href="javascript:;" class="float_close" onclick="hideWindow('login')" title="关闭">关闭</a><? } ?></span>
</h3>
<div class="postbox">
<form method="post" name="login" id="loginform" class="s_clear" onsubmit="<? if($pwdsafety) { ?>pwmd5('password3');<? } ?>pwdclear = 1;ajaxpost('loginform', 'returnmessage', 'returnmessage', 'onerror');return false;" action="logging.php?action=login&amp;loginsubmit=yes<? if(!empty($infloat)) { ?>&amp;floatlogin=yes<? } ?>">
<input type="hidden" name="formhash" value="<?=FORMHASH?>" />
<input type="hidden" name="referer" value="<?=$referer?>" />
<div class="loginform nolabelform">
<div class="float_typeid selectinput" id="account">
<select name="loginfield" style="float:left;width:50px;" id="loginfield">
<option value="username">用户名</option>
<option value="uid">UID</option>
<option value="email">Email</option>
</select>
<input type="text" name="username" autocomplete="off" size="36" class="txt" tabindex="1" value="<?=$username?>" />
</div>
<p class="selectinput loginpsw">
<label for="password3">密　码　：</label>
<input type="password" id="password3" name="password" onfocus="clearpwd()" onkeypress="detectCapsLock(event, this)" size="36" class="txt" tabindex="1" />
</p>

<div id="seccodelayer"><? if($secqaacheck || $seccodecheck) { if($secqaacheck) { ?>
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
</script><? } ?></div>

<div class="float_typeid selecttype">
<select id="questionid" name="questionid" change="if($('questionid').value > 0) {$('answer').style.display='';} else {$('answer').style.display='none';}">
<option value="0">安全提问</option>
<option value="1">母亲的名字</option>
<option value="2">爷爷的名字</option>
<option value="3">父亲出生的城市</option>
<option value="4">您其中一位老师的名字</option>
<option value="5">您个人计算机的型号</option>
<option value="6">您最喜欢的餐馆名称</option>
<option value="7">驾驶执照的最后四位数字</option>
</select>
</div>
<p><input type="text" name="answer" id="answer" style="display:none" autocomplete="off" size="36" class="txt" tabindex="1" /></p>
</div>
<div class="logininfo multinfo">
<h4>没有帐号？<a href="<?=$regname?>" onclick="hideWindow('login');showWindow('register', this.href);return false;" title="注册帐号"><?=$reglinkname?></a></h4>
<p><a href="javascript:;" onclick="display('layer_login');display('layer_lostpw');" title="找回密码">找回密码</a></p>
<p><a href="javascript:;" onclick="ajaxget('member.php?action=clearcookies&formhash=<?=FORMHASH?>', 'returnmessage', 'returnmessage');return false;" title="清除痕迹">清除痕迹</a></p>
</div>
<p class="fsubmit s_clear">
<? if($sitemessage['login']) { ?><a href="javascript:;" id="custominfo_login" class="right"><img src="<?=IMGDIR?>/info.gif" alt="帮助" /></a><? } ?>
<button class="submit" type="submit" name="loginsubmit" value="true" tabindex="1">登录</button>
<input type="checkbox" class="checkbox" name="cookietime" id="cookietime" tabindex="1" value="2592000" <?=$cookietimecheck?> /> <label for="cookietime">记住我的登录状态</label>
</p>
</form>
</div>
</div>
<div id="layer_lostpw" style="display: none;">
<h3 class="float_ctrl">
<em id="returnmessage3">找回密码</em>
<span><? if(!empty($infloat)) { ?><a href="javascript:;" class="float_close" onclick="hideWindow('login')" title="关闭">关闭</a><? } ?></span>
</h3>
<div class="postbox">
<form method="post" id="lostpwform" class="s_clear" onsubmit="ajaxpost('lostpwform', 'returnmessage3', 'returnmessage3', 'onerror');return false;" action="member.php?action=lostpasswd&amp;lostpwsubmit=yes&amp;infloat=yes">
<input type="hidden" name="formhash" value="<?=FORMHASH?>" />
<input type="hidden" name="handlekey" value="lostpwform" />
<div class="loginform">
<label><em>用户名:</em><input type="text" name="username" size="25" value=""  tabindex="1" class="txt" /></label>
<label><em>Email:</em><input type="text" name="email" size="25" value=""  tabindex="1" class="txt" /></label>
</div>
<div class="logininfo multinfo">
<h4>没有帐号？<a href="<?=$regname?>" onclick="hideWindow('login');showWindow('register', this.href);return false;" title="注册帐号"><?=$reglinkname?></a></h4>
<p><a href="javascript:;" onclick="display('layer_login');display('layer_lostpw');">返回登录</a></p>
</div>
<p class="fsubmit s_clear">
<em>&nbsp;</em>
<button class="submit" type="submit" name="lostpwsubmit" value="true" tabindex="100">提交</button>
</p>
</form>
</div>
</div>
</div>
<div id="layer_message" class="fcontent alert_win" style="display: none;">
<h3 class="float_ctrl">
<em>用户登录</em>
<span><? if(!empty($infloat)) { ?><a href="javascript:;" class="float_close" onclick="hideWindow('login')" title="关闭">关闭</a><? } ?></span>
</h3>
<hr class="shadowline" />
<div class="postbox"><div class="alert_right">
<div id="messageleft"></div>
<p class="alert_btnleft" id="messageright"></p>
</div>
</div>

<script src="<?=$jspath?>md5.js?<?=VERHASH?>" type="text/javascript" reload="1"></script>
<script type="text/javascript" reload="1">
var pwdclear = 0;
function initinput_login() {
document.body.focus();
$('loginform').username.focus();
simulateSelect('loginfield');
simulateSelect('questionid');
}
if(BROWSER.ie && BROWSER.ie < 7) {
setTimeout('initinput_login()', 500);
} else {
initinput_login();
}
<? if($sitemessage['login']) { ?>
showPrompt('custominfo_login', 'click', '<? echo trim($sitemessage['login'][array_rand($sitemessage['login'])]); ?>', <?=$sitemessage['time']?>);
<? } if($pwdsafety) { ?>
var pwmd5log = new Array();
function pwmd5() {
numargs = pwmd5.arguments.length;
for(var i = 0; i < numargs; i++) {
if(!pwmd5log[pwmd5.arguments[i]] || $(pwmd5.arguments[i]).value.length != 32) {
pwmd5log[pwmd5.arguments[i]] = $(pwmd5.arguments[i]).value = hex_md5($(pwmd5.arguments[i]).value);
}
}
}
<? } ?>

function clearpwd() {
if(pwdclear) {
$('password3').value = '';
}
pwdclear = 0;
}

function messagehandle_lostpwform(key) {
if(key == 141) {
$('messageleft').innerHTML = '<p>取回密码的方法发送到您的信箱中，请在 3 天之内到论坛修改您的密码。</p>';
$('messageright').innerHTML = '<a href="javascript:;" onclick="hideMenu(\'fwin_login\', \'win\')">关闭</a>';
}
}

</script>
<? } updatesession(); if(empty($infloat)) { ?>
</div></div>
</div>
<? } include template('footer', '0', ''); ?>