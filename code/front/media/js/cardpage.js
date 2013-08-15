//显示绑定div
function showBindCardDiv(flag)
{
	TIP.alert({type:'bindcarddiv'});
	if(flag==1){
		$('province').value = $('old_province').value;
		changeCityByProvince($('old_province').value, 'select_city', 'city');
		$('city').value = $('old_city').value;
		$('bankType').value = $('old_bankid').value;
		$('bankname').value = $('old_branchbank').value;
		$('show_cardnumber').innerHTML = $('old_cardnumber').value+' （已绑定）';
		$('act').value='modify';
		$('Submit2').value='保存修改';
		$('bindcardtitle').innerHTML = '修改银行卡资料';
	}else{
		$('act').value='bind';
	}

	//TIP.alert({type:'bindsuc'});
}

function getCookie(n){
	var arr = document.cookie.match(new RegExp("(^| )"+ n +"=([^;]*)(;|$)"));
	if(arr != null) return unescape(arr[2]);
	return null;
}

function showUserDataDiv(flag){
	if(flag==undefined){
		var u = getCookie('');
		var c = getCookie('hiddenAlertDiv'+u);
		var d = new Date(parseInt(c));
		var d0 = new Date();
		if(d.getFullYear() == d0.getFullYear() && d.getMonth() == d0.getMonth() && d.getDate() == d0.getDate()){
			return;
		}
	}
	TIP.alert({type:'userdatadiv'});
	var inputs = ['truename','idnumber','mobile','email'];
	var len = inputs.length;
	if($('old_truename').value!=''){
		$('show_truename').innerHTML = '***（已填写）';
	}
	if($('old_idnumber').value!=''){
		$('show_idnumber').innerHTML = '***（已填写）';
	}
	if($('bind_mobile').value=='1'){
		$('show_mobile').innerHTML = $('old_mobile').value+' （已绑定）';
	}else{
		$('mobile').value = $('old_mobile').value;
	}
	if($('bind_email').value=='1'){
		$('show_email').innerHTML = $('old_email').value+' （已绑定）';
	}else{
		$('email').value = $('old_email').value;
	}
	initInput();
}

function changeBank(bankid){
	if(bankid<4){
		$('banktr').style.display = 'none';
	}else{
		$('banktr').style.display = '';
	}
}

function showWarning(msg){
	TIP.alert(msg);
	//$('msginfo').innerHTML = msg;
}

function queryData(){
	var json = {
		method: 'get',
		url : "/safe/ajax/bindBank.php",
		arg : {'act':'query','ajax':1, '_':Math.random()},
		onsuccess: function(ret){//成功
			showQueryMsg(ret);
		 },
		onfail : function (){
			alert("连接服务器失败！");
		}
	};
	fw.ajax.request(json);
}

function showQueryMsg(ret){
	var json = eval('('+ret+')');
	if(json.code<0){
		showUserDataDiv(1);
	}else{
		showBindCardDiv(0);
	}
}

function checkUserDataForm(){
	var len = inputs.length;
	for(var i=0;i<len;i++){
		if(status[inputs[i]] == false){
			return false;
		}
	}
	/*if(($('truename')&&$('truename').value!='') || ($('idnumber') &&$('idnumber').value!='')){
		saveUserData();
	}else{
		showWarning('请填写真实姓名和身份证号码');
	}*/

	if($('truename') && $('truename').value==''){
		showWarning('请填写真实姓名');
		return false;
	}
	
	var val = $('truename').value;
	if(/^[\u4e00-\uffff]+[\u4e00-\uffff\.·]*[\u4e00-\uffff]+$/.test(val)){
		if(val.length>20){
			showWarning('真实姓名不符合格式');
			return false;
		}
	}else{
		showWarning('请不要输入非法字符');
		return false;		
	}
	if($('idnumber') && $('idnumber').value==''){
		showWarning('请填写身份证号码');
		return false;
	}	
	var val = $('idnumber').value;
	if(/^\d{15}$|^\d{17}[\dXx]{1}$/.test(val)){
	}else{
		showWarning('请正确填写身份证');
		return false;
	}
	
	var val = $('email').value;
	if(val=='' || /^[-a-zA-Z0-9_.]+@([0-9A-Za-z][0-9A-Za-z-]+\.)+[A-Za-z]{2,5}$/.test(val)){
	}else{
		showWarning('请正确填写邮箱');
		return false;
	}

	saveUserData();
}

function checkUserDataForm_trade(){
	var len = inputs.length;
	for(var i=0;i<len;i++){
		if(status[inputs[i]] == false){
			return false;
		}
	}
	/*if(($('truename')&&$('truename').value!='') || ($('idnumber') &&$('idnumber').value!='')){
		saveUserData();
	}else{
		showWarning('请填写真实姓名和身份证号码');
	}*/

	if($('truename') && $('truename').value==''){
		showWarning_trade('请填写真实姓名');
		return false;
	}

	if($('idnumber') && $('idnumber').value==''){
		showWarning_trade('请填写身份证号码');
		return false;
	}

	saveUserData_trade();
}

function checkUserData(){
	var len = inputs.length;
	for(var i=0;i<len;i++){
		if(status[inputs[i]] == false){
			return false;
		}
	}
	if($('truename') && $('truename').value==''){
		showWarning('请填写真实姓名');
		return false;
	}
	
	var val = $('truename').value;
	if(/^[\u4e00-\uffff]+[\u4e00-\uffff\.·]*[\u4e00-\uffff]+$/.test(val)){
		if(val.length>20){
			showWarning('真实姓名不符合格式');
			return false;
		}
	}else{
		showWarning('请不要输入非法字符');
		return false;		
	}
	if($('idnumber') && $('idnumber').value==''){
		showWarning('请填写身份证号码');
		return false;
	}	
	var val = $('idnumber').value;
	if(/^\d{15}$|^\d{17}[\dXx]{1}$/.test(val)){
	}else{
		showWarning('请正确填写身份证');
		return false;
	}

	var val = $('mobile').value;
	if(val=='' || /^1[3|5|8]\d{9}$/.test(val)){
	}else{
		showWarning('请正确填写手机号码');
		return false;
	}	
	
	var val = $('email').value;
	if(val=='' || /^[-a-zA-Z0-9_.]+@([0-9A-Za-z][0-9A-Za-z-]+\.)+[A-Za-z]{2,5}$/.test(val)){
	}else{
		showWarning('请正确填写邮箱');
		return false;
	}
	return true;
}

function checkBindForm(){
	var f = document.bindBankForm;
	if(f.carofbank.value == ''){
		showWarning('请选择开户银行名称');
		return false;
	}
	if(f.province.value == ''){
		showWarning('请选择开户银行所在省或直辖市、自治区');
		return false;
	}
	if(f.city.value == ''){
		showWarning('请选择开户银行所在县市');
		return false;
	}
	if(f.carofbank.value>4 && f.bankname.value == ''){
		showWarning('请填写开户银行支行名称');
		return false;
	}
	if(f.cardnumber.value == ''){
		showWarning('请填写银行卡号');
		return false;
	}
	if(!/^\d{6,}$/.test(f.cardnumber.value)){
		showWarning('请正确填写银行卡号');
		return false;
	}
	if(f.password.value == ''){
		showWarning('请填写您的登录密码以确认您的身份');
		return false;
	}
	saveBankData();
	return false;
}

function saveUserData(){
	var q = buildQuery('userDataForm');
	var o = document.getElementsByTagName("HEAD")[0].appendChild(document.createElement ('SCRIPT'));
	o.src = (typeof(passportsite)=='undefined'?'':passportsite)+'/user/save_userinfo.php?modtype=1&callback=_saveUserData&ajax=1&'+q;
}

function _saveUserData(json){
	if(json.code<0){
		showWarning(json.msg);
	}else{
		TIP.alert({type:'suc',
		reload:1,
		info:'身份证绑定成功！'});
	}
}

function saveUserData_trade(){
	var q = buildQuery('userDataForm');
	var o = document.getElementsByTagName("HEAD")[0].appendChild(document.createElement ('SCRIPT'));
	o.src = (typeof(passportsite)=='undefined'?'':passportsite)+'/user/save_userinfo.php?modtype=1&callback=_saveUserData_trade&ajax=1&'+q;
}

function _saveUserData_trade(json){
	if(json.code<0){
		showWarning_trade(json.msg);
	}else{
		if($('old_email').value!=''){
			TIP.alert({type:'savesuc',info:$('old_email').value});
		}else{
			TIP.alert({type:'savesuc2'});
			//$('email_ads') = $('old_email').value;
		}
	}
}

function showWarning_trade(msg){
	$('msginfo').innerHTML = msg;
}

function buildQuery(form){
	var inpts = $(form).getElementsByTagName('INPUT');
	var len =inpts.length;
	var arr = [];
	for(var i=0;i<len;i++){
		arr.push(inpts[i].name + '=' + inpts[i].value);
	}
	return arr.join('&');
}

function getForm(form) {
	form = typeof(form)=="string" ? document.forms[form] : form;
    var o = {}, t;
    for (var i=0,l=form.elements.length; i<l; i++) {
    	t = form.elements[i];
        t.name!="" && (o[t.name]=t.type=="radio"?fw.dom.getRadio(t.name):encodeURIComponent(t.value));
    }
    return o;
}

function saveBankData(){
	TIP.alert({type:"suc",info:"正在保存信息，请稍候..."});
	//showWarning('正在保存信息，请稍候...');
	var json = {
		method: 'post',
		url : "/safe/ajax/bindBank.php",
		arg : fw.object.merge({'ajax':1,'_':Math.random()},getForm(document.bindBankForm)),
		//form : document.bindBankForm,
		onsuccess: function(ret){//成功
			showReturnMsg(ret);
		 },
		onfail : function (){
			alert("连接服务器失败！");
		}
	};
	fw.ajax.request(json);
}

function showReturnMsg(ret){
	var json = eval('('+ret+')');
	if(json.code>0){
		TIP.alert({type:'suc',reload:1,info:'绑定成功！您可以提出自己的资金到该卡上！'});
	}else{
		showWarning('绑定失败: '+json.msg);
	}
}

function closeReresh(){
	TIP.close();
	location.reload();
}