var inputs_register = ['lastname','email','password','password_confirm','secode'];
var inputs_register_submit = ['lastname','email','password','password_confirm','secode'];
var inputs_login = ['username','password'];
var tips = {};
var _status = {};
var type='register';
function $(o){
	return document.getElementById(o);
}

function showTerms(){
	$('layer2').style.display = 'inline';
}

function hideTerms(){
	$('layer2').style.display = 'none';
}

function showErr(input, msg){
	$(input+'_err').className="up_tis";
	$(input+'_err').style.display="block";
	$(input+'_err').innerHTML = msg;
	
}

function showOK(input,msg){
	
	$(input+'_err').className="up_tisok";
	$(input+'_err').style.display="block";
	$(input+'_err').innerHTML = msg;
}

function refreshVerify(){
	$("reg_secoder").src = "/site/secoder?id=reg_secoder&rnd="+Math.random();
}

function checkForm(type){
	
	if(type=='login'){
	  inputs=inputs_login;
	  type='login';
	}
	else{
	  if($('year18').checked==false){
		alert('您必须同意我们的服务条款才可以注册');
		return false;
	  }
	  inputs=inputs_register_submit;
	}
	var len = inputs.length;
	for(var i=0;i<len;i++){
		if(!_status[inputs[i]]){
			$(inputs[i]).focus();
			return !!checkInput(inputs[i]);
		}
	}
	$('subfrm').disabled = "disabled";
	
	if(typeof(dcsMultiTrack)=='function'){
		dcsMultiTrack('DCSext.button_t','03000000','DCSext.button_w','03050000','DCSext.button_b','03050100','DCSext.button_c','03050103','DCSext.button_n','reg_new_button');
	}
	
	return true;
}

function checkInput(input){
	switch(input){
		case 'lastname':
		    _status['lastname'] = checkUsername();
			break;
		case 'username':
		    _status['username'] = checkUsername2();
			break;
		case 'password':
		   _status['password'] = checkPassword();
			break;
		case 'password_confirm':
			_status['password_confirm'] = checkPassword2();
			break;
		case 'secode':
			_status['secode'] = checkVerifycode();
			break;
		case 'email':
		     
			_status['email'] = checkEmail();
			break;			
	}
	return _status[input];
}

//含中文的字符串长度
function getStrLen(str){
	var len = 0;
	var cnstrCount = 0;
	for(var i = 0 ; i < str.length ; i++){
		if(str.charCodeAt(i)>255)
		cnstrCount = cnstrCount + 1 ;
	}
	len = str.length + cnstrCount;
	return len;
}

function checkUsername(){
	var user = $('lastname').value;
	var len = getStrLen(user);
	if(len < 4){
		return _checkUsername({'code':-1, 'msg':'对不起，用户名长度至少应该为4个字符！'});
	}else if(len > 16){
		return _checkUsername({'code':-1, 'msg':'对不起，用户名长度请不要超过16个字符！'});
	}
	var o = document.getElementsByTagName("HEAD")[0].appendChild(document.createElement ('SCRIPT'));
	o.src = '/user/ajax_check_name/_checkUsername/'+user+'/1/'+Math.random();

	return false;
}

function checkUsername2(){
    var user = $('username').value;
	var len = getStrLen(user);
	if(len < 4 || len > 16){
		showErr('username', '格式错误！');
	}
	else{
	  showOK('username','');
   }
}

function _checkUsername(json){
	if(json.code<0){
		if(json.msg==''){
		   json.msg='用户名不可用!';	
		}
		showErr('lastname', json.msg);
	}else{
	    showOK('lastname','可以注册！');
	}
	_status['lastname'] = json.code > 0;
	return json.code > 0 ? true : false;
}

function setUsername(user){
	$('lastname').value = user;
	showOK('lastname');
	_status['lastname']=true;
}

function checkPassword(){
	
	if(type=='register'){
		var user = $('lastname').value;
	}
	var pwd = $('password').value;
	var len = pwd.length;
	if(len == 0){
		showErr('password','请输入密码');
		return false;
	}
	else if(len<6){
		showErr('password','您输入的密码不足6位，请重新输入');
		return false;
	}else if(len>15){
		showErr('password','您输入的密码超过15位，请换个密码');
		return false;
	} else if (pwd==user && type=='register')
	{
		showErr('password','对不起，密码不能够与用户名一致！请重新输入。');
		return false;
	}
	var cat = /^[\x20-\x7f]+$/;
	if(!(cat.test(pwd))) {
		showErr('password','密码请勿包含中文');
		return false;
	}
	showOK('password','');
	if(type=='register'){
		showPassLevel();
	}
	return true;
}

function showPassLevel(){
	var lvl = results('password');
	var lvlName = {1:'很弱',2:'弱',3:'中',4:'强',5:'很强'};
	if(lvl)
	$('password_err').innerHTML = '<div class="p_level_h"><span class="p_level_'+lvl+'">'+lvlName[lvl]+'</span><span class="msg"></span></div>';
}

function checkPassword2(){
	if($('password_confirm').value == ''){
		showErr('password_confirm','请再输入一次以确认您的密码');
		return false;
	}
	if($('password').value != $('password_confirm').value){
		showErr('password_confirm','您两次输入的密码不一致，请重新输入');
		return false;
	}else{
		showOK('password_confirm','密码正确!');
		return true;
	}
}

/******检查邮箱**********/
function checkEmail()
{
    
	var email = $('email').value;
	var len = getStrLen(email);
	if(len < 4){
		if(type=='login'){
		  return _checkEmail({'code':-1, 'msg':'格式错误！'});
		}else{
		  return _checkEmail({'code':-1, 'msg':'对不起，请输入正确邮箱地址！'});
		}
	}else if(email.indexOf('@')==-1){
		return _checkEmail({'code':-1, 'msg':'对不起，请输入正确邮箱地址！！'});
	}
	if(type=='login'){_checkEmail({'code':1, 'msg':''});};
	email = email.toLowerCase();
	$('email').value = email;
	var o = document.getElementsByTagName("HEAD")[0].appendChild(document.createElement ('SCRIPT'));
	o.src = '/user/ajax_check_name/_checkEmail/'+email+'/0/'+Math.random();
	return false;
}

/****检查完成后，回调函数*****/
function _checkEmail(json){
	if(json.code<0){
		showErr('email', json.msg);
	}else{
		showOK('email',json.msg);
	}
	_status['email'] = json.code>0;
	return json.code>0 ? true : false;
}
/******邮箱检查完毕******/


/******验证码检查开始*********/
function checkVerifycode(){
	var code = $('secode').value;
	
	if(code == ''){
		
		return _checkVerifycode({'code':-1, 'msg':'请输入验证码'});
	}
	else if(code.length < 4){
		return _checkVerifycode({'code':-1, 'msg':'验证码不正确，请重新输入'});
	}
	var o = document.getElementsByTagName("HEAD")[0].appendChild(document.createElement ('SCRIPT'));
	o.src = '/user/ajax_check_rancode/_checkVerifycode/'+code+'/'+Math.random();
	
	return false;
}

function checkVerifycode2(){
	
	var code = $('secode').value;
	if(code.length == 4){
		var o = document.getElementsByTagName("HEAD")[0].appendChild(document.createElement ('SCRIPT'));
		o.src = 'ajax_reg_check_new.php?type=3&back=_checkVerifycode&&inputdata='+code;
	}
	return false;
}

function _checkVerifycode(json){
	if(json.code<0){
		showErr('secode', json.msg);
		refreshVerify();
		///验证码检查失败，刷新验证码
		//setTimeout('refreshVerify()',1000);
	}else{
		showOK('secode','正确！');
	}
	_status['secode'] = json.code>0;
	return json.code>0 ? true : false;
}


/********验证码检查结束**********/


function InputOnFocus(e){
	var srcEle=e.srcElement?e.srcElement:e.target;
	srcEle.className = srcEle.className.replace(/normal/,'active');
	var tip = $((srcEle.id+'_tip'));
	if(tip){
		tip.className = tip.className.replace(/normal/,'active');
	}
}

function InputOnBlur(e){
	var srcEle=e.srcElement?e.srcElement:e.target;
	srcEle.className = srcEle.className.replace(/active/,'normal');
	return checkInput(srcEle.name);
}

function initInput(type){
	
	if(type=='login')
	{
	   inputs = inputs_login;
	   type='login';
	}
	else{
	   inputs = inputs_register;	
	}

	var len = inputs.length;
    
	for(var i=0;i<len;i++){
		var inpt = $(inputs[i]);
		
		if(window.addEventListener){  //FF
		
			inpt.addEventListener("focus",InputOnFocus,false);
			if(inputs[i]=='secode'){
				
				inpt.addEventListener("blur",checkVerifycode,false);
			}else{
			
				inpt.addEventListener("blur",InputOnBlur,false);
			}
		}else{  //IE chrome
			
			inpt.attachEvent("onfocus",InputOnFocus);
			
			if(inputs[i]=='secode'){
				
				inpt.attachEvent("onblur",checkVerifycode);
			}else{
				
				inpt.attachEvent("onblur",InputOnBlur);
			}
		}
	
		_status[inputs[i]] = false;
	}
	//setTimeout(function(){$('lastname').focus();}, 100);
}

function results(pwdinput){
	var maths,smalls,bigs,corps,cat,num;
	var str = $(pwdinput).value
	var len = str.length;

	var cat = /.{16}/g
	if(len == 0)return 1;
	if(len > 16){$(pwdinput).value = str.match(cat)[0];}
	cat = /.*[\u4e00-\u9fa5]+.*$/
	if(cat.test(str)) {
		showErr('password','密码请勿包含中文');
		return false;
	}
	cat = /\d/;
	var maths = cat.test(str);
	cat = /[a-z]/;
	var smalls = cat.test(str);
	cat = /[A-Z]/;
	var bigs = cat.test(str);
	var corps = corpses(pwdinput);
	var num = maths+smalls+bigs+corps;

	if(len<6){return 1;}

	if(len>=6&&len<=8){
        if(num == 1) return  1;
	    if(num == 2 || num == 3) return  2;
	    if(num == 4) return  3;
	}

	if(len>8 && len<=11){
        if(num == 1) return 2;
		if(num == 2) return 3;
		if(num == 3) return 4;
		if(num == 4) return 5;
	}

	if(len>11){
		if(num == 1) return 3;
		if(num == 2) return 4;
		if(num  > 2) return 5;
	}
}

function corpses(pwdinput){
	var cat = /./g
	var str = $(pwdinput).value;
	var sz = str.match(cat)
	for(var i=0;i<sz.length;i++){
		cat = /\d/;
		maths_01 = cat.test(sz[i]);
		cat = /[a-z]/;
		smalls_01 = cat.test(sz[i]);
		cat = /[A-Z]/;
		bigs_01 = cat.test(sz[i]);
		if(!maths_01&&!smalls_01&&!bigs_01){return  true;}
	}
	return false;
}

var alertEmail = {
	
	alertWindow : 'layer2',
	background : 'bgDiv',
	email : '',
	canSend : true,
	createBg : function(){
		var bgDiv = $(this.background);
		if(bgDiv)return bgDiv;
		
		bgDiv = document.createElement('div');
		bgDiv.id = this.background;
		bgDiv.style.cssText = 'background:rgb(119, 119, 119);position:absolute;left:0;top:0;z-index:999;filter:Alpha(Opacity=30);opacity:0.3;\
			width:'+document.documentElement.clientWidth+'px;height:'+document.documentElement.clientHeight+'px;display:none;';
		
		document.body.appendChild(bgDiv);
		
		return bgDiv;
	},
	pop : function(type,id){
	
		if(!this.canSend || id){
			
			var error = $(id || 'layer3');
			$(this.alertWindow).id = id || 'layer3';
			error.id = 'layer2';
			error.style.height = '150px';
			var bgDiv = this.createBg();
		
			bgDiv.style.display = 'block';
			error.style.display = 'block';
			return;
		}
		
		$("error_email").style.display = 'none';
		$("error_verify").style.display = 'none';
		
		if(type){
			$('modify_email').style.display = "";
		}
		else $('modify_email').style.display = 'none';
		
		var alertWindow = $(this.alertWindow),bgDiv = this.createBg();
		
		bgDiv.style.display = 'block';
		alertWindow.style.display = 'block';
		
		if(typeof(dcsMultiTrack)=='function'){
		dcsMultiTrack('DCSext.button_t','03000000','DCSext.button_w','03060000','DCSext.button_b',
		'03060100','DCSext.button_c','0306010'+(type?"4":"3"),'DCSext.button_n',(type?'modify_email':'resend_email'));
		}
		
	},
	close : function(flag){
		
		$(this.alertWindow).style.display = 'none';
		$(this.background).style.display = 'none';
		if(flag){
			var error = $(flag);
			$(this.alertWindow).id = flag;
			error.id = 'layer2';
			error.style.height='200px';
		}
	},
	send : function(obj){
		
		var email = $('modify_email_value').value,secode = $('secode').value;
		var url = location.href; 
		if(email.indexOf('@') <0){
			$("error_email").style.display = '';
			//alert('请输入正确格式的电子邮箱！');
			return;
		}
		else $("error_email").style.display = 'none';
		
		if(secode.length != 4){
			$("error_verify").style.display = '';
			//alert('请输入正确格式的验证码！');
			return;
		}
		else $("error_verify").style.display = 'none';
		if(url.indexOf("?")!=-1){
		ad='&'+url.substring(url.indexOf("?")+1,url.length)		
		}
		else ad='';
		obj.disabled = 'disabled';
		this.email = email;

		var script = document.body.appendChild(document.createElement('script'));
		script.src = 'ajax_reg_check_new.php?type=4&back=alertEmail.callback'+ad+'&inputdata='+window.userName+'|'+email+'|'+secode+'|'+window.sendNum+'&'+Math.random();
	},
	callback : function(json){

		$('sendbtn').disabled = '';
		this.reloadCode();
		if(json.code<0){
		
			$("error_email").style.display = 'none';
			$("error_verify").style.display = 'none';
			
			if(json.code == -2){
				this.close();
				this.pop(true,'layer5');
			}
			else if(json.msg.indexOf("验证码") >= 0){
				$("error_verify").style.display = '';
			}
			else if(json.msg.indexOf("邮箱") >= 0) $("error_email").style.display = '';
			else alert(json.msg);
		}else{
			this.close();
			
			this.pop(true,'layer4');
			
			window.userEmail = this.email;
			
			window.sendNum++;
			
			if(window.sendNum >= 3)this.canSend = false;
			$('user_email').innerHTML=window.userEmail;
		}
	},
	getEmailHttp :function (email)
	{
		var emailType =email.substring(email.indexOf('@')+1),emailUrl = '',html = '';
		emailType = emailType.toLowerCase();
		switch(emailType)
		{
			case 'qq.com':
			case 'vip.qq.com':
			case 'foxmail.com':
				emailUrl = 'http://mail.qq.com/';
				break;
			case '163.com':
			case '126.com':
			case 'yeah.net':
			case 'vip.163.com':
			case '188.com':
				emailUrl = 'http://email.163.com/';
				break;
			case 'tom.com':
				emailUrl = 'http://mail.tom.com/';
				break;
			case 'sina.com':
			case 'vip.sina.com':
			case 'sina.com.cn':
				emailUrl = 'http://mail.sina.com.cn/';
				break;
			case 'sohu.com':
			case 'souhu.com':
			case 'vip.sohu.com':
				emailUrl = 'http://mail.sohu.com/';
				break;
			case '139.com':
			case '136.com':
				emailUrl = 'http://mail.10086.cn/';
				break;
			case 'gmail.com':
				emailUrl = 'http://mail.google.com/';
				break;
			case 'hotmail.com':
			case 'msn.com':
			case 'live.cn':
			case 'live.com':
			case 'msn.cn':
			case 'hotmail.com.cn':
				emailUrl = 'https://login.live.com/';
				break;
			case 'yahoo.com.cn':
			case 'yahoo.cn':
			case 'yahoo.com':
				emailUrl = 'http://mail.cn.yahoo.com/';
				break;
			case '21cn.com':
			case '21cn.net':
				emailUrl = 'http://mail.21cn.com/';
				break;
			case 'sogou.com':
				emailUrl = 'http://mail.sogou.com/';
				break;
			case '189.cn':
				emailUrl = 'http://www.189.cn/';
				break;
			case 'eyou.com':
				emailUrl = 'http://www.eyou.com/';
				break;
			default:
				emailUrl = 'http://www.'+emailType+'/';
		}
		return emailUrl;
	},
	reloadCode : function(){
		$('verifyImg').src ='../comm/regcode.php?rnd=1&'+Math.random();
	}
}












