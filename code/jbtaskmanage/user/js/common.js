
/**
 @function        document.getElementById(a); 的简写
 @author:           QiJunbo
 @copyright
 @a:       类型:String型    含义: 控件的id

**/

function $( a ){
        return document.getElementById(a);
}

/**
 @function     获取字符串的字节数。

*/

String.prototype.bitlen = function() {
  return this.replace(/[^\x00-\xff]/g,"**").length;
}

/**
 @function          选中下拉列表框的指定value。
 @author:           QiJunbo
 @copyright

 @id:       类型:String型    含义: 下拉列表框的id
 @val       类型:String型    含义: 下拉列表框的选项value属性

**/

function setSelected(id,val){
		var obj = $(id);
     	for(var i=0;i<obj.length; i++ ){
     	    if( (obj.options[i].value == val)  ){
     	    	obj.options[i].selected=true;break;
     	    }	
     	}
}


/**
 @function          选中指定的复选框框。
 @author:           QiJunbo
 @copyright

 @name:       类型:String型    含义: 下拉列表框的name
 @val       类型:String型    含义: 下拉列表框的选项value属性

**/

function setSelectedCheckbox(name, val){
	var i ;
    for( i = 0;i < document.all.length; i++ ) {
  		var e=document.all[i];
 		if (e.type == "checkbox" && e.name == name && e.value == val) {
 	   		e.checked = true;
 	   	}
 	}		 
	
}


/**
  @function          改变div的状态。
**/
function transformDiv(id){
	if($(id)){
		if($(id).style.display == 'none'){
			$(id).style.display = 'block'
		}else{
			$(id).style.display = 'none'
		}
	}
}

/**
  @function          数字验证-true:整数;false:非整数。
**/
function _isNumber(ch){	
        var re = /^[0-9]*$/;
        if(re.test(ch)){
           return true;
        }
        return false;
}

/**
  @function          数字验证-true:整数;false:非整数(包含小数,正负)。
**/
function _isNumberAll(str){
	var reg = /^[-\+]?\d+(\.\d+)?$/;
	if(reg.test(str)){
		return true;
	}
	return false;
}

/**
  @function          数字验证-true:整数;false:非整数(包含小数,无正负符号)。
**/
function _isNumberPlus(ch){	
        var re = /^\d+(\.\d+)?$/;
        if(re.test(ch)){
           return true;
        }
        return false;
}

/**
  @function          数字验证-true:整数;false:非整数(包含最多两位小数,无正负符号)。
**/
function _isNumberPlus2(ch){	
        var re = /^\d+(\.\d{1,2})?$/;
        if(re.test(ch)){
           return true;
        }
        return false;
}

/**
  @function          大小写英文和数字验证。
**/
function _isYSAll(ch){	
        var re = /^[A-Za-z0-9]+$/;
        if(re.test(ch)){
           return true;
        }
        return false;
}

/**
  @function          小写英文数字验证。
**/
function _isYSLower(ch){	
        var re = /^[a-z0-9]+$/;
        if(re.test(ch)){
           return true;
        }
        return false;
}

/**
  @function          是否日期格式(yyyy-mm-dd)。
**/
function _isDate(ch){	
        var re = /^(\d{4})-(\d{2})-(\d{2})$/;
        if(re.test(ch)){
           return true;
        }
        return false;
}

/**
  @function          是否日期格式(yyyy-MM-dd HH:mm:ss)。
**/
function _isDateTime(ch){	
        var re = /^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$/;
        if(re.test(ch)){
           return true;
        }
        return false;
}
