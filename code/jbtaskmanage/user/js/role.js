function inputcheck(){
	
	var fm = $('iform'); 
	if(fm.rolename.value.bitlen()> 20){
		alert('角色名称不允许大于20字节，当前' + fm.rolename.value.bitlen() + '字节。');
		fm.rolename.focus();
		return false;
	}

	if(fm.rolename.value == ''){
		alert('角色名称不允许为空!');
		fm.rolename.focus();
		return false;
	}
	
	return true;
}