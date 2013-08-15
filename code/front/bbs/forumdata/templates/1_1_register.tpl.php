<? if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('register');
0
|| checktplrefresh('D:\wwwphp\web\discuz\././templates/default/register.htm', 'D:\wwwphp\web\discuz\././templates/default/seccheck.htm', 1312281951, '1', './templates/default')
;?><? include template('header', '0', ''); if(!empty($message)) { ?>
<script type="text/javascript" onload="1"><? $bbname = str_replace('\'', '\\\'', $bbname); ?>if(document.body.stat) document.body.stat('register_succeed', '<?=$regname?>');
display('main_messaqge');
display('layer_reg');
display('layer_message');
<? if($regverify == 1) { ?>
$('messageleft1').innerHTML = '<p>感谢您注册 <?=$bbname?></p><p>您的帐号处于非激活状态，请收取邮件激活您的帐号</p>';
$('messageright1').innerHTML = '<a href="memcp.php">个人中心</a><br />如果您没有收到我们发送的系统邮件，请进入个人中心点击“重新验证 Email”或在“密码和安全问题”中更换另外一个 Email 地址。注意：在完成激活之前，根据管理员设置，您将只能以待验证会员的身份访问论坛，您可能不能进行发帖等操作。激活成功后，上述限制将自动取消。';
setTimeout("window.location.href='memcp.php'", <?=$mrefreshtime?>);
<? } elseif($regverify == 2) { ?>
$('messageleft1').innerHTML = '<p>感谢您注册 <?=$bbname?></p><p>请等待管理员审核您的帐号</p>';
$('messageright1').innerHTML = '<a href="memcp.php">个人中心</a>';
setTimeout("window.location.href='memcp.php'", <?=$mrefreshtime?>);
<? } else { if($newbietask) { ?>
$('messageleft1').innerHTML = '<p>感谢您注册 <?=$bbname?></p><p>我们诚邀您参与新手任务 <?=$task['name']?>，现在将转入任务详情页面。</p>';
$('messageright1').innerHTML = '<a href="javascript:;" onclick="location.href=\'task.php?action=view&id=<?=$task['taskid']?>\'">如果页面没有响应，请点这里刷新</a>';
setTimeout('location.href=\'task.php?action=view&id=<?=$task['taskid']?>\'', <?=$mrefreshtime?>);
<? } else { ?>
$('messageleft1').innerHTML = '<p>感谢您注册 <?=$bbname?></p>';
$('messageright1').innerHTML = '<a href="javascript:;" onclick="location.reload()">如果页面没有响应，请点这里刷新</a>';
setTimeout('location.reload()', <?=$mrefreshtime?>);
<? } } if($_DCACHE['settings']['frameon'] && $_DCOOKIE['frameon'] == 'yes') { ?>
if(top != self) {
parent.leftmenu.location.reload();
}
<? } ?>
</script>
<? } else { if(empty($infloat)) { ?>
<div id="nav"><a href="<?=$indexname?>"><?=$bbname?></a> <?=$navigation?></div>
<div id="wrap" class="wrap s_clear">
<div class="main"><div class="content nofloat">
<? } ?>
<div class="fcontent" id="main_messaqge">
<div id="layer_bbrule" class="postbox" style="display: none;">
<div>
<h3><?=$bbname?> 网站服务条款</h3>
<div class="clause"><?=$bbrulestxt?></div>
<button onclick="$('agreebbrule').checked = true;display('layer_reg');display('layer_bbrule');">同意</button> &nbsp; <button onclick="hideWindow('register')">不同意</button>
</div>
</div>
<div id="layer_reg" class="postbox s_clear">
<h3 class="float_ctrl">
<em id="returnmessage4"><? if($action != 'activation') { ?><?=$reglinkname?><? } else { ?>您的帐号需要激活<? } ?></em>
<span>
<? if(!empty($infloat)) { ?><a href="javascript:;" class="float_close" onclick="hideWindow('register')" title="关闭">关闭</a><? } ?>
</span>
</h3>
<form method="post" name="register" id="registerform" onsubmit="ajaxpost('registerform', 'returnmessage4', 'returnmessage4', 'onerror');return false;" action="<?=$regname?>?regsubmit=yes">
<input type="hidden" name="formhash" value="<?=FORMHASH?>" />
<input type="hidden" name="referer" value="<?=$referer?>" />
<? if(!empty($infloat)) { ?><input type="hidden" name="handlekey" value="<?=$handlekey?>" /><? } ?>
<input type="hidden" name="activationauth" value="<? if($action == 'activation') { ?><?=$activationauth?><? } ?>" />
<div class="loginform">
<div id="reginfo_a">
<span id="activation_hidden"<? if($action == 'activation') { ?> style="display:none"<? } ?>>
<? if(!empty($fromuser)) { ?>
<span>
<label><em>推荐人:</em><?=$fromuser?></label>
<input type="hidden" name="fromuser"value="<?=$fromuser?>" />
</span>
<? } ?>
<label><em>用户名:</em><input type="text" id="username" name="username" autocomplete="off" size="25" maxlength="15" value="" onBlur="checkusername()" tabindex="1" class="txt" /> *</label>
<label><em>密码:</em><input type="password" name="password" size="25" id="password" onkeypress="detectCapsLock(event, this)" tabindex="1" class="txt" /> *</label>
<label><em>确认密码:</em><input type="password" name="password2" size="25" id="password2" onkeypress="detectCapsLock(event, this)" tabindex="1" value="" class="txt" /> *</label>
<label><em>Email:</em><input type="text" name="email" autocomplete="off" size="25" id="email" onBlur="checkemail()" tabindex="1" class="txt" /> *</label>
<label><em>&nbsp;</em><a href="https://domains.live.com/members/signup.aspx?domain=<?=$msn['domain']?>" target="_blank" style="float: left; width: 210px;"><? if($msn['on']) { ?>注册 @<?=$msn['domain']?> 超大 Hotmail 邮箱<? } else { ?>注册超大 Hotmail 邮箱<? } ?></a></label>
</span>
<? if($action == 'activation') { ?>
<span id="activation_user">
<label><em>用户名:</em><?=$username?></label>
</span>
<? } if($secqaacheck || $seccodecheck) { ?>
<div class="regsec"><label style="display:inline"><em>验证: </em><? if($secqaacheck) { ?>
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
</script></label></div>
<? } if(($regstatus > 1 && $action != 'activation') || $regstatus == 2) { ?>
<label><em>邀请码:</em><input type="text" name="invitecode" autocomplete="off" size="25" maxlength="16" value="<?=$invitecode?>" id="invitecode" onBlur="checkinvitecode()" tabindex="1" class="txt" /><? if($regstatus == 2) { ?> *<? } ?></label>
<? } ?>
</div>
<div id="reginfo_b"<? if(!empty($infloat)) { ?> style="display:none;"<? } ?>>
<? if($regverify == 2) { ?>
<label><em>注册原因:</em><input name="regmessage" autocomplete="off" size="25" tabindex="1" class="txt" /> *</label>
<? } if(is_array($_DCACHE['fields_required'])) { foreach($_DCACHE['fields_required'] as $field) { ?><label<? if($field['description']) { ?> title="<? echo htmlspecialchars($field['description']); ?>"<? } ?>><em><?=$field['title']?>:</em>
<? if($field['selective']) { ?>
<select name="field_<?=$field['fieldid']?>new" tabindex="1">
<option value="">- 请选择 -</option><? if(is_array($field['choices'])) { foreach($field['choices'] as $index => $choice) { ?><option value="<?=$index?>"<? if($index == $member['field_'.$field['fieldid']]) { ?> selected="selected"<? } ?>><?=$choice?></option><? } } ?></select>
<? } else { ?>
<input type="text" name="field_<?=$field['fieldid']?>new" size="25" value="<?=$member['field_'.$field['fieldid']]?>" tabindex="1" class="txt" />
<? } ?> *
</label><? } } ?></div>
</div>
<div class="logininfo">
<h4>已有帐号？<a href="logging.php?action=login" onclick="hideWindow('register');showWindow('login', this.href);return false;">现在登录</a></h4>
<? if($action == 'activation') { ?>
<p>放弃激活，<a href="javascript:;" onclick="$('registerform').activationauth.value='';$('activation_hidden').style.display='';$('activation_user').style.display='none'">现在<?=$reglinkname?></a></p>
<? } ?>
</div>
<p class="fsubmit s_clear">
<? if($sitemessage['register']) { ?><a href="javascript:;" id="custominfo_register" class="right"><img src="<?=IMGDIR?>/info.gif" alt="帮助" /></a><? } ?>
<span id="reginfo_a_btn">
<? if($action != 'activation') { ?><em>&nbsp;</em><? } if(($field || $regverify == 2) && !empty($infloat)) { ?>
<button class="submit" tabindex="1" onclick="regstep('reginfo_a','reginfo_b'); return false;">下一步</button>
</span>
<span id="reginfo_b_btn" style="display:none">
<em class="regpre"><a href="javascript:;" onclick="regstep('reginfo_b','reginfo_a');">上一步</a></em>
<? } ?>
<button class="submit" id="registerformsubmit" type="submit" name="regsubmit" value="true" tabindex="1"><? if($action == 'activation') { ?>激活<? } else { ?>提交<? } ?></button>
<? if($bbrules) { ?>
<input type="checkbox" class="checkbox" name="agreebbrule" value="<?=$bbrulehash?>" id="agreebbrule" checked="checked" /> <label for="agreebbrule">同意<a href="javascript:;" onclick="display('layer_reg');display('layer_bbrule');">网站服务条款</a></label>
<? } ?>
</span>
</p>
</form>
</div>
</div>
<div id="layer_message" class="fcontent alert_win" style="display: none;">
<h3 class="float_ctrl">
<em>用户登录</em>
<span><? if(!empty($infloat)) { ?><a href="javascript:;" class="float_close" onclick="hideWindow('login')" title="关闭">关闭</a><? } ?></span>
</h3>
<hr class="shadowline" />
<div class="postbox"><div class="alert_right">
<div id="messageleft1"></div>
<p class="alert_btnleft" id="messageright1"></p>
</div>
</div>

<script type="text/javascript" reload="1">
<? if($action != 'activation') { ?>
function initinput_register() {
$('registerform').username.focus();
}
if(BROWSER.ie && BROWSER.ie < 7) {
setTimeout('initinput_register()', 500);
} else {
initinput_register();
}
<? } if($sitemessage['register']) { ?>
showPrompt('custominfo_register', 'click', '<? echo trim($sitemessage['register'][array_rand($sitemessage['register'])]); ?>', <?=$sitemessage['time']?>);
<? } ?>

var profile_username_toolong = '用户名超过 15 个字符';
var profile_username_tooshort = '用户名小于3个字符';
var doublee = parseInt('<?=$doublee?>');
var lastusername = lastpassword = lastemail = lastinvitecode = '';

function messagehandle_register(key, msg) {
$('returnmessage4').className = key == 1 ? 'onerror' : '';
$('returnmessage4').innerHTML = msg;
}

function checkusername() {
var username = trim($('username').value);
if(username == '' || username == lastusername) {
return;
} else {
lastusername = username;
}
var unlen = username.replace(/[^\x00-\xff]/g, "**").length;
if(unlen < 3 || unlen > 15) {
messagehandle_register(1, unlen < 3 ? profile_username_tooshort : profile_username_toolong);
return;
}
        ajaxget('ajax.php?infloat=register&handlekey=register&action=checkusername&username=' + (BROWSER.ie && document.charset == 'utf-8' ? encodeURIComponent(username) : username), 'returnmessage4');
}

function checkemail() {
var email = trim($('email').value);
if(email == '' || email == lastemail) {
return;
} else {
lastemail = email;
}
ajaxget('ajax.php?infloat=register&handlekey=register&action=checkemail&email=' + email, 'returnmessage4');

}
function checkinvitecode() {
var invitecode = trim($('invitecode').value);
if(invitecode == lastinvitecode) {
return;
} else {
lastinvitecode = invitecode;
}
        ajaxget('ajax.php?infloat=register&handlekey=register&action=checkinvitecode&invitecode=' + invitecode, 'returnmessage4');
}
function trim(str) {
return str.replace(/^\s*(.*?)[\s\n]*$/g, '$1');
}
<? if(($field && !empty($infloat)) || $regverify == 2) { ?>
function regstep(obja,objb){
$(obja).style.display = $(obja+'_btn').style.display = 'none';
$(objb).style.display = $(objb+'_btn').style.display = '';
}
<? } if($invitecode) { ?>
ajaxget('ajax.php?infloat=register&handlekey=register&action=checkinvitecode&invitecode=<?=$invitecode?>', 'returnmessage4');
<? } ?>
</script>
<? } updatesession(); if(empty($infloat)) { ?>
</div></div>
</div>
<? } include template('footer', '0', ''); ?>