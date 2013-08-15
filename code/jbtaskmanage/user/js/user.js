function inputcheck(){
	var fm = $('iform');
	if(fm.username.value == null){
		alert('用户名不允许为空！');
		fm.username.focus();
		return false;
	}
	if(fm.password.value ==''){
		alert('密码不允许为空！');
		fm.password.focus();
		return false;
	}
	if(fm.repassword.value ==''){
		alert('重复密码不允许为空！');
		fm.repassword.focus();
		return false;
	}
	if(fm.password.value != fm.repassword.value){
		alert('两次录入的密码不一致！');
		fm.repassword.focus();
		return false;
	}
	return true;
}