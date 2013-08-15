function inputcheck(){
	var fm = $('iform'); 
	if(parseInt(fm.priname.value.bitlen()) > 50){
		
		alert('名称不允许多于50字节，当前' + fm.priname.value.bitlen() + '字节。');
		fm.priname.focus();
		return false;
	}

	if(fm.priname.value == ''){
		alert('名称不允许为空!');
		fm.priname.focus();
		return false;
	}
	
	if(fm.priurl.value.length > 200){
		alert('链接地址太长!');
		fm.priurl.focus();
		return false;
	}
	
	return true;
	
}