//排列组合
function plzh(n,m){
	var firstVal=1;
	var secondVal=1;
	if(m > n){return(0);}
	if(m == n){return(1);
	}else{
		for(var i=0;i<m;i++){	
				firstVal *= n-i;
				secondVal *= i+1;	
		}
		var count = firstVal/secondVal;
		return(count);
	}	
}

// 控制表格纵向下拉滚动条
function sendScoll(id) {
	var nDivHight = $("#"+id+"").height();
	$("#"+id+"").scrollTop(99999);
}

function toscale(dight,tag){
  // 验证科学计数法
  var index = (dight+"").indexOf('e');
  if(index>=0)
  {
      return "0.00";
  }   
  // 金额扩大100，四舍五入取整数
  var dight=Math.round(dight*100)
  // 整数缩小100，还原金额
  var money=dight/100;
  
  // 校对 0 为 0.00 和 9 为 9.00
  if(dight%10==0&&dight%100==0)
  {
    money+=".00";
  }
  // 校对0.1为0.10
  if(dight%10==0&&dight%100!=0)
  {
    money+="0";
  }
  return money;
}

/**
 * 小数格式 四舍五入
 */
function tofloat(dight,tag){
  // 验证科学计数法
  var index = (dight+"").indexOf('e');
  if(index>=0)
  {
      return "0.00";
  }   
  // 金额扩大100，四舍五入取整数
  var dight=Math.round(dight*100)
  // 整数缩小100，还原金额
  var money=dight/100;
  
  // 校对 0 为 0.00 和 9 为 9.00
  if(dight%10==0&&dight%100==0)
  {
    money+=".00";
  }
  // 校对0.1为0.10
  if(dight%10==0&&dight%100!=0)
  {
    money+="0";
  }
  var parsemoney = numParse(money);
  return parsemoney;
}

//千位符
function numParse(s){
	if(/[^0-9\.]/.test(s)) return "0.00";
	s=s.replace(/^(\d*)$/,"$1.");
	s=(s+"00").replace(/(\d*\.\d\d)\d*/,"$1");
	s=s.replace(".",",");
	var re=/(\d)(\d{3},)/;
	while(re.test(s))
	        s=s.replace(re,"$1,$2");
	s=s.replace(/,(\d\d)$/,".$1");
	return "￥"+s.replace(/^\./,"0.")
}

//转成int
function numFormat(money){
	var mon = replaceAll(money,",","");
	mon = mon.replace("￥","");
	return parseInt(mon);
}

//replaceAll方法
function replaceAll(str, sptr, sptr1){
	while (str.indexOf(sptr) >= 0)
	{
	   str = str.replace(sptr, sptr1);
	}
	return str;
}

function in_array(needle, haystack, argStrict) {
    // http://kevin.vanzonneveld.net
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // *     example 1: in_array('van', ['Kevin', 'van', 'Zonneveld']);
    // *     returns 1: true

    var found = false, key, strict = !!argStrict;

    for (key in haystack) {
        if ((strict && haystack[key] === needle) || (!strict && haystack[key] == needle)) {
            found = true;
            break;
        }
    }

    return found;
}

//拖拽
(function($){
  $.fn.draggable=function(s){
	  if(this.size()>1) return this.each(function(i,o){$(o).draggable(s)});
	  var t=this,h=s?t.find(s):t,m={},to=false,
	      d=function(v){
			  v.stopPropagation();
			  m={ex:v.clientX,ey:v.clientY,x:t.css("position")=="relative"?parseInt(t.css("left")):t.position().left,y:t.css("position")=="relative"?parseInt(t.css("top")):t.position().top,fw:t.get(0).style.width,w:t.width()};
			  if(t.css("position")=="static") to={"left":m.x,"top":m.y};
			  $(document).mousemove(b).mouseup(e);
		      if(document.body.setCapture) document.body.setCapture(); 
				
			  },
		  b=function(v){
		  	var leftV = v.clientX-m.ex+m.x;var left = leftV<5?10:leftV;//left值
		  	var topV =  v.clientY-m.ey+m.y;var top = topV<5?10:topV;//top值
		  	t.css({"left":leftV,"top":topV});
		  	if(t.css("left")<"5px" || t.css("top")<"5px"){
		  		t.
		  			css({"left":left,"top":top})
		  				.show("fast");
		  	}
		  	return false;
		  	},
		  e=function(v){
		      if(document.body.releaseCapture) document.body.releaseCapture();
			  $(document).unbind("mousemove").unbind("mouseup");
			  };
		  h.mousedown(d);
		  return t;
	  };
})(jQuery);





jQuery.extend({
   /** * @see 将javascript数据类型转换为json字符串 * @param 待转换对象,支持object,array,string,function,number,boolean,regexp * @return 返回json字符串 */
   toJSON: function(object) {
     var type = typeof object;
     if ('object' == type) {
       if (Array == object.constructor) type = 'array';
       else if (RegExp == object.constructor) type = 'regexp';
       else type = 'object';
     }
     switch (type) {
     case 'undefined':
     case 'unknown':
       return;
       break;
     case 'function':
     case 'boolean':
     case 'regexp':
       return object.toString();
       break;
     case 'number':
       return isFinite(object) ? object.toString() : 'null';
       break;
     case 'string':
       return '"' + object.replace(/(\\|\")/g, "\\$1").replace(/\n|\r|\t/g, function() {
         var a = arguments[0];
         return (a == '\n') ? '\\n': (a == '\r') ? '\\r': (a == '\t') ? '\\t': ""
       }) + '"';
       break;
     case 'object':
       if (object === null) return 'null';
       var results = [];
       for (var property in object) {
         var value = jQuery.toJSON(object[property]);
         if (value !== undefined) results.push(jQuery.toJSON(property) + ':' + value);
       }
       return '{' + results.join(',') + '}';
       break;
     case 'array':
       var results = [];
       for (var i = 0; i < object.length; i++) {
         var value = jQuery.toJSON(object[i]);
         if (value !== undefined) results.push(value);
       }
       return '[' + results.join(',') + ']';
       break;
     }
   }
});




