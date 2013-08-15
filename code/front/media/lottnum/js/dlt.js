var randomNum = 5;//随机次数
var bdScale = 0.2;//保底比例
var minFsScale = 0.05;//认购比例
var zsMoney = 2; //每注多少钱
var keyup_left = 0;
var keyup_top = 0;
var offset = new Object();
var issue_url = "/lotteryapi/sdata/lotissue";
var fq_url = "/lotteryapi/orderprocess/ordersub";
var kjgg_url = "/lotteryapi/sdata/lotnotice?lottid=8";
//号码对象
var dssc_url = "/lotteryapi/orderprocess/order_fqds";
var fa_title = "大奖神马都不是浮云，只要有你参与！";
var fa_ms = "说点什么吧，让您的方案被更多彩民认可．．．";
var dt_dan = new Array();
var dt_tuo = new Array();
var dt_blue_dan = new Array();
var dt_blue_tuo = new Array();
var numObject = function(){
	var numObj = new Object();
	numObj.red_class = "r-b";
	numObj.blue_class = "b-b";
	numObj.red_hover_class = "r-a";
	numObj.red_hover_class = "b-a";
	return numObj;
}



$(function(){	
	//红色的选择个数
	var b_red_tag = $("#pt_red li b").length;
	//蓝色的选择个数
	var b_blue_tag = $("#pt_blue li b").length;
	//机选前区号码
	$("#pt_red_jx").click(function(){
		//随机前区个数
		var pt_red_sel_val = $("#pt_red_sel").val();
		lotteryDrawings("pt_red",b_red_tag,pt_red_sel_val,"r-b");
		judgment();//选好了按钮状态
	});

	//机选后区号码
	$("#pt_blue_jx").click(function(){
		//随机后区个数
		var pt_blue_sel_val = $("#pt_blue_sel").val();
		lotteryDrawings("pt_blue",b_blue_tag,pt_blue_sel_val,"b-b");
		judgment();//选好了按钮状态
	});


	$("#dt_tuo_jx").click(function(){
		var red_dan_num = new Array();
		$("#dt_dan li b").filter(".r-b").each(function(i){
				red_dan_num[i] = $(this).html();
		});
			
		//随机前区个数
		var dt_red_sel_val = $("#dt_tuo_opts").val();
		$('#dt_red_tuo_num').html(dt_red_sel_val);
		dtlotteryDrawings("dt_tuo",$("#dt_tuo li b").length,dt_red_sel_val,"r-b",red_dan_num);
		dtjudgment();//选好了按钮状态
	});

	$("#dt_blue_jx").click(function(){

		var blue_dan_num = new Array();
		$("#dt_blue li b").filter(".b-b").each(function(i){
			blue_dan_num[i] = $(this).html();
		});
		//随机前区个数
		var dt_blue_sel_val = $("#dt_blue_opts").val();
		$('#dt_blue_tuo_num').html(dt_blue_sel_val);
		dtlotteryDrawings("dt_blue_tuo",$("#dt_blue_tuo li b").length,dt_blue_sel_val,"b-b",blue_dan_num);
		dtjudgment();//选好了按钮状态
	});
	
	//前区号码点击
	$("#pt_red li b").click(function(){
		var red_num = clickCheckNum($(this),"r-b");
	})
	
	//后区号码点击
	$("#pt_blue li b").click(function(){
		var blue_num =clickCheckNum($(this),"b-b");
	})
	
	//清除红区
	$("#pt_red_clear").click(function(){
		clearNum("pt_red");
		$("#red_num").html("0");
	});
	
	//清除蓝区
	$("#pt_blue_clear").click(function(){
		clearNum("pt_blue");
		$("#blue_num").html("0");
	});
	
	//添加到号码栏
	$("#pt_put").click(function(){
		if($(this).attr("class")=="s-ok-sp"){
			var red_num = new Array();
			var blue_num = new Array();
			//添加号码
			//获得前区号码
			$("#pt_red li b").filter(".r-b").each(function(i){
				red_num[i] = $(this).html();
			});
			//获得后区号码
			$("#pt_blue li b").filter(".b-b").each(function(i){
				blue_num[i] = $(this).html();
			});
			//获得注数
			var all_num = $("#all_num").html();
			if(all_num>=10000){
				openInfoDlgDiv("您好，单个方案最大金额为<strong style='color:red'>￥20,000.00</strong>元！");
				return false;
			}
			//总注数
			var total_zs = $("#all_num").html();
			//构造号码栏
			addNumLan(red_num,blue_num,total_zs);
			//选择的注数
			var pt_zs = $("#pt_zs").html();
			pt_zs = parseInt(total_zs)+parseInt(pt_zs); 
			$("#pt_zs").html(pt_zs); //动态改变文本栏中号码的注数
			changeNewNum();//改变用户最终选择的数据 
           	clearNumQu();//清除前后区
			//sendScoll("pt_list");
		}else{
			openInfoDlgDiv("您好，请您至少选择一注投注号码！");
		}
	});
	
	//添加到号码栏
	$("#dt_put").click(function(){
		if($(this).attr("class")=="s-ok-sp"){
			var red_dan_num = new Array();
			var red_tuo_num = new Array();

			var blue_dan_num = new Array();
			var blue_tuo_num = new Array();

			$("#dt_dan li b").filter(".r-b").each(function(i){
				red_dan_num[i] = $(this).html();
			});
			$("#dt_tuo li b").filter(".r-b").each(function(i){
				red_tuo_num[i] = $(this).html();
			});

			$("#dt_blue li b").filter(".b-b").each(function(i){
				blue_dan_num[i] = $(this).html();
			});
			$("#dt_blue_tuo li b").filter(".b-b").each(function(i){
				blue_tuo_num[i] = $(this).html();
			});

			//总注数
			var total_zs = $("#dt_all_num").html();

			//构造号码栏
			dtaddNumLan(red_dan_num,red_tuo_num,blue_dan_num,blue_tuo_num,total_zs);

			//选择的注数
			var dt_zs = $("#dt_zs").html();
			dt_zs = parseInt(total_zs)+parseInt(dt_zs); 
			$("#dt_zs").html(dt_zs); //动态改变文本栏中号码的注数
			
			dtchangeNewNum();//改变用户最终选择的数据 
			clearDtNumQu();//清除前后区
			//sendScoll("pt_list");
		}else{
			openInfoDlgDiv("您好，请您至少选择一注投注号码！");
		}
	});

	//清空全部 选好区
	$("#pt_clear").click(function(){
		clearNumQu();		
	});
	$("#dt_clear_all").click(function(){
		clearDtNumQu();		
	});	
	
	//机选
	$("#pt_jx >b").click(function(){
		$("#jx_dlg_list >li").remove();//清除机选的号码
		var pt_sel_val = $("#pt_sel").val();
		var height = 40;
		if(pt_sel_val==1) height = 40;
		if(pt_sel_val==2) height = 60;
		if(pt_sel_val==5) height = 120;
		if(pt_sel_val==10) height = 220;
		if(pt_sel_val>=20) height = 240;
		$("#jx_dlg_list").css("height",height);
		var offset = $(this).offset();
		var scrollTop = $(document).scrollTop();
		showBgdiv();
		$("#jx_dlg").css("top",scrollTop+height).css("left",offset.left-265).show();//显示机选层
		randomSelection(pt_sel_val);
		//拖拽
		$("#jx_dlg").draggable(".move");
	});
	
	//选好了按钮
	$("#jx_dlg_ok").click(function(){
		//清除号码栏
		var all_zs = $("#pt_sel").val();//机选注数
		//获取机选出的号码
		var pt_zs = parseInt($("#pt_zs").html());
		$("#jx_dlg_list li").each(function(i){
			var red_num = $(this).children("span.red").html().split(",");
			var blue_num = $(this).children("span.blue").html().split(",");
			addNumLan(red_num,blue_num,1);
			pt_zs+=1;
		});
		$("#pt_zs").html(pt_zs);//改变注数
		changeNewNum();//改变用户最终选择的数据 
		$("#jx_dlg_list >li").remove();
		$("#jx_dlg").hide();
		hideBgdiv();
	});
	
	//关闭机选
	$("#jx_dlg_close >a").click(function(){
		$("#jx_dlg").hide();
		hideBgdiv();
	})
	
	//重新机选
	$("#jx_dlg_re").click(function(){
		var pt_sel_val = $("#pt_sel").val();
		//清除号码栏
		$("#jx_dlg_list >li").remove();
		randomSelection(pt_sel_val);
	});
	
	//清空列表-- 清空号码栏
	$("#pt_list_clear").click(function(){
		clearptInfo();
	});

	$("#dt_list_clear").click(function(){
		cleardtInfo();
	});
	
	//点击追加投注 没注*zsMoney
	$("#zjtz23").click(function(){
		zhFunc("zjtz23","zjtz_tab","dssc_zh","zjtz2"); //追号的函数
	});
	$("#zjtz_tab").click(function(){
		zhFunc("zjtz_tab","zjtz23","dssc_zh","zjtz2"); //追号的函数
	});
	$("#dssc_zh").click(function(){
		zhFunc("dssc_zh","zjtz23","zjtz_tab","zjtz2"); //追号的函数
	});

	$("#zjtz2").click(function(){
		zhFunc("zjtz2","zjtz23","zjtz_tab","dssc_zh"); //追号的函数
	});



	/**
	*
	*/

	//前区号码点击
	$("#dt_dan li b").click(function(){
		clickCurrent("dt_tuo",this,'.r-b');
		dtclickCheckNum($(this),"r-b");	
		var dt_red_dan_num = $("#dt_dan li b").filter(".r-b").length;
		if (dt_red_dan_num<1)
		{
			openInfoDlgDiv("您好, 前区最少要选择1个胆码！");
			dtclickCheckNum($(this),"r-b");
			$('#dt_red_dan_num').html(dt_red_dan_num+1);
			return false;
		}
		if (dt_red_dan_num>4)
		{
			openInfoDlgDiv("您好, 前区最多只能选择4个胆码！");
			dtclickCheckNum($(this),"");
			$('#dt_red_dan_num').html(dt_red_dan_num-1);
			return false;
		}


		$('#dt_red_dan_num').html(dt_red_dan_num);
		
		
	});

	$("#dt_tuo li b").click(function(){
		clickCurrent("dt_dan",this,'.r-b');
		dtclickCheckNum($(this),"r-b");
		var dt_red_tuo_num = $("#dt_tuo li b").filter(".r-b").length;
		$('#dt_red_tuo_num').html(dt_red_tuo_num);

	});

	$("#dt_blue li b").click(function(){
		clickCurrent("dt_blue_tuo",this,'.b-b');
		dtclickCheckNum($(this),"b-b");
		var dt_blue_dan_num = $("#dt_blue li b").filter(".b-b").length;
		if (dt_blue_dan_num>1)
		{
			openInfoDlgDiv("您好, 前区最少要选择1个胆码！");
			dtclickCheckNum($(this),"b-b");
			$('#dt_blue_dan_num').html(dt_blue_dan_num-1);
			return false;
		}
		$('#dt_blue_dan_num').html(dt_blue_dan_num);
	});

	$("#dt_blue_tuo li b").click(function(){
		clickCurrent("dt_blue",this,'.b-b');
		dtclickCheckNum($(this),"b-b");
		var dt_blue_tuo_num = $("#dt_blue_tuo li b").filter(".b-b").length;
		$('#dt_blue_tuo_num').html(dt_blue_tuo_num);
	});
	

})
var trim = function(s) { return s.replace(/\s+/g,'');}


var clickCurrent = function (dt,zhe,classname){
		$.each($("#"+dt+" li b").filter(classname),function(){
			if($(zhe).html()==$(this).html()){
				$(this).attr("class","");
				switch(dt){
					case 'dt_dan':
						dt = 'dt_red_dan';
					break;
					case 'dt_tuo':
						dt = 'dt_red_tuo';
					break;
					case 'dt_blue':
						dt = 'dt_blue_dan';
					break;
					case 'dt_blue_tuo':
						dt = 'dt_blue_tuo';
					break;
				}
				$('#'+dt+'_num').html($('#'+dt+'_num').html()-1);
			}
		});
}

/**
	@param t,n t-总数 n-产生个数
	@return array
**/
var getRandomNum = function(t,n){
    var array=new Array(n);	
	for(var i=0;i<n;){
	    var val = Math.floor(Math.random()*(t))+1;
		if(checkRepeat(array,val,i)){

			if(parseInt(val)<10){val = "0"+val;} 
			array[i++]=val;
		}
	}
    return array;
}

var getRandomDanNum = function(t,n,dn){
    var array=new Array(n);	
	var dan= new Array();
		dan = dn.toString().split(",");
	for(var i=0;i<n;){
	    var val = Math.floor(Math.random()*(t))+1;
		if(!in_array(val,dan)&&checkRepeat(array,val,i)){

			if(parseInt(val)<10){val = "0"+val;} 
			array[i++]=val;
		}
	}
    return array;
}

//检查数组是否有重复的数字
var checkRepeat = function(array,t,n){
     for(var i=0;i<n;i++){
	    if(array[i]==t){
		  return false;		
		}
	 }  
     return true;
 }
 
//号码栏添加号码函数
var addNumLan = function(red_num,blue_num,total_zs){
	var blue_num_space = "";
	for(var i = 0; i<blue_num.length;i++){
		blue_num_space += blue_num[i]+" ";
	}
	$("<li class='pointer' condition='"+red_num+"|"+blue_num+"'>" +
			"<span class='num'>"+red_num+"<em class='blue'> | "+blue_num_space+"</em></span>" +
			"<a href='javascript:void 0' class ='del' condition="+total_zs+" >删除</a></li>")
			.appendTo("#pt_list");
}

//号码栏添加号码函数
var dtaddNumLan = function(red_dan_num,red_tuo_num,blue_dan_num,blue_tuo_num,total_zs){
	var blue_num_space = "";
	$('<li style="height: 80px; cursor: pointer;" condition="'+red_dan_num+'$'+red_tuo_num+'|'+blue_dan_num+'$'+blue_tuo_num+'" class="dtpointer" azhushu="'+total_zs+'">'+
		'<div>[<em class="red">前区|胆</em>] <span class="">'+red_dan_num+'</span></div>'+
		'<div>[<em class="green">前区|拖</em>] <span class="">'+red_tuo_num+'</span></div>'+
		'<div>[<em class="red">后区|胆</em>] <span class="">'+blue_dan_num+'</span></div>'+
		'<div><a class="del" href="javascript:void 0" title="" condition="'+total_zs+'">删除</a>'+
		'[<em class="green">后区|拖</em>] <span class="">'+blue_tuo_num+'</span></div></li>').appendTo("#dt_list");
}

//开始摇号码
var lotteryDrawings = function(pt,btag,pt_sel_val,className){
	var numArr= getRandomNum(btag,pt_sel_val);
	$("#"+pt+" li b").attr("class","");
	//前后区显示号码
	pushNumToQu(pt,numArr,className);
	judgment();
}

var dtlotteryDrawings = function(dt,btag,pt_sel_val,className,dan_num){	

			
	var numArr= getRandomDanNum(btag,pt_sel_val,dan_num);
	$("#"+dt+" li b").attr("class","");
	//前后区显示号码
	pushNumToQu(dt,numArr,className);
	dtjudgment();
}

//判断前区和后区所选是否符合条件
var judgment = function (){
	//红色的选中个数
	var b_red_tag = $("#pt_red li b").filter(".r-b").length;
	//蓝色的选中个数
	var b_blue_tag = $("#pt_blue li b").filter(".b-b").length;
	
	if(b_red_tag>=5 && b_blue_tag>=2){
		//选好了
		$("#pt_put").attr("class","s-ok-sp");
	}else{
		$("#pt_put").attr("class","s-ok");
	}
	//显示注数
	changeOldNum(b_red_tag,b_blue_tag);
}


//判断前区和后区所选是否符合条件
var dtjudgment = function (){

	//红色的胆选中个数
	var b_red_dan = $("#dt_dan li b").filter(".r-b").length;
		//红色的拖选中个数
	var b_red_tuo = $("#dt_tuo li b").filter(".r-b").length;


	//蓝色的胆选中个数
	var b_blue_dan = $("#dt_blue li b").filter(".b-b").length;

	//蓝色的拖选中个数
	var b_blue_tuo = $("#dt_blue_tuo li b").filter(".b-b").length;

	var b_blue_tag = b_blue_dan+b_blue_tuo;

	var b_red_tag = (b_red_dan+b_red_tuo);

	if(b_red_dan>=1&&b_red_tuo>=2&&b_red_tag>=6 && b_blue_tuo>=2){
		//选好了
		$("#dt_put").attr("class","s-ok-sp");
		dtchangeOldNum(b_red_dan,b_red_tuo,b_blue_dan,b_blue_tuo);
	}else{
		$("#dt_put").attr("class","s-ok");
	}
	//显示注数
	
}

//点击号码区 返回选择多少个号码
var clickCheckNum = function(pt,className){
	//红色的选中个数
	var b_red_tag = $("#pt_red li b").filter(".r-b").length;
	//蓝色的选中个数
	var b_blue_tag = $("#pt_blue li b").filter(".b-b").length;
	if(pt.attr("class")!=className && className!="b-b"){
		if(b_red_tag>=18){
			openInfoDlgDiv("您好, 前区号码最大可选个数为18个！");
			return false;
		}
	}
	if(pt.attr("class")==className){
		pt.attr("class","");
	}else{
		pt.attr("class",className);
	}
	judgment();//选好了按钮状态
}

//点击号码区 返回选择多少个号码
var dtclickCheckNum = function(dt,className){
	//红色的胆选中个数
	var b_red_dan = $("#dt_dan li b").filter(".r-b").length;
	//红色的拖选中个数

	var b_red_tuo = $("#dt_tuo li b").filter(".r-b").length;
	//蓝色的胆选中个数
	var b_blue_dan = $("#dt_blue li b").filter(".b-b").length;	
	//蓝色的拖选中个数
	var b_blue_tuo = $("#dt_blue_tuo li b").filter(".b-b").length;
	

		if(dt.attr("class")==className){
			dt.attr("class","");
		}else{
			dt.attr("class",className);
		}
		dtjudgment();//选好了按钮状态
	
}

//改变用户选择时信息记录
var changeOldNum = function(redLen,blueLen){
	red_all_num = plzh(redLen,5);
	blue_all_num = plzh(blueLen,2);

	$("#red_num").html(redLen);
	$("#blue_num").html(blueLen);
	$("#all_num").html(red_all_num*blue_all_num);
	$("#all_money").html(tofloat((red_all_num*blue_all_num)*zsMoney,2));
}

//改变用户选择时信息记录
var dtchangeOldNum = function(b_red_dan,b_red_tuo,b_blue_dan,b_blue_tuo){
	red_all_num = plzh(b_red_tuo,5-b_red_dan);
	blue_all_num = plzh(b_blue_tuo,2-b_blue_dan);

	$("#dt_all_num").html(red_all_num*blue_all_num);
	$("#dt_all_money").html(tofloat((red_all_num*blue_all_num)*zsMoney,2));
}

/**dssc_tab
 * 改变用户最终选择信息记录
 * @备注   其中默认1.00元
 */
var changeNewNum = function(){
	var pt_zs = $("#pt_zs").html(); //用户选择号码的总注数
	var pt_bs = $("#pt_bs").val(); //用户输入的倍数
	
	if(pt_bs==0 || pt_bs.length==0){
		pt_bs = 1;
	}
	var all_money = tofloat((pt_zs)*pt_bs*zsMoney,2); //总金额等于 总注数*倍数*没份多少钱
	if($("#userMoneyInfo >strong").html()!=null){
		var userMoneyInfo =  numFormat($("#userMoneyInfo >strong").html());//用户余额
		var all_money_format = numFormat(all_money);
		$("#buySYSpan").html(tofloat((userMoneyInfo-all_money_format),2));//用户购买后余额
	}
	$("#all_money").html(tofloat(parseInt($("#all_num").html())*zsMoney,2));
	$("#pt_money").html(all_money);
	rgbdFunc(numFormat(all_money));
}

var dtchangeNewNum = function(){
	var dt_zs = $("#dt_zs").html(); //用户选择号码的总注数
	var dt_bs = $("#dt_bs").val(); //用户输入的倍数
	
	if(dt_bs==0 || dt_bs.length==0){
		dt_bs = 1;
	}

	var all_money = tofloat((dt_zs)*dt_bs*zsMoney,2); //总金额等于 总注数*倍数*没份多少钱
	if($("#userMoneyInfo >strong").html()!=null){
		var userMoneyInfo =  numFormat($("#userMoneyInfo >strong").html());//用户余额
		var all_money_format = numFormat(all_money);
		$("#buySYSpan").html(tofloat((userMoneyInfo-all_money_format),2));//用户购买后余额
	}
	$("#dt_all_money").html(parseInt($("#dt_all_num").html())*zsMoney);
	$("#dt_money").html(all_money);
	rgbdFunc(numFormat(all_money));
}

//认购保底
var rgbdFunc = function(all_money){
	$("#buyMoneySpan").html(tofloat(all_money));
	if($("#userMoneyInfo >strong").html()!=null){
		var userMoneyInfo =  numFormat($("#userMoneyInfo >strong").html());//用户余额
		var all_money_format = all_money;
		$("#buySYSpan").html(tofloat((userMoneyInfo-all_money_format),2));//用户购买后余额
	}
	$("#fsInput").val(all_money);//我要分为文本框
	if($("#fsInput").val()>=1){
		$("#fsMoney").html("￥1.00");
	}else{
		$("#fsMoney").html("￥0.00");
	}
	var rg_val = all_money*minFsScale;//最低认购的份数
	if(rg_val > parseInt(rg_val)){
		rg_val+=1;
	}
	var rg_int_val = parseInt(rg_val);
	
	$("#rgInput").val(rg_int_val);//认购数
	
	var rg_scale = "";
	//计算比例保证被除数不为0
	if(all_money<=0){
		rg_scale = "0.00";
	}else{
		rg_scale = toscale((rg_int_val/all_money)*100,2);
	}
	$("#rgScale").html(rg_scale);//认购比例
	$("#rgMoney").html(tofloat(rg_int_val*1,2));//认购金额
	//隐藏保底错误信息和认购错误信息
	$("#rgErr").hide(); $("#bdErr").hide();
	//保底
	hmbdVali();
}

//清除合买
var clearhmInfo = function(){
	$(".buy_table").find(":text").not(":last").each(function(){
		$(this).val("0");
	});
	//合买区的可变金额清零
	$(".buy_table").find("span.money").each(function(){
		$(this).html("￥0.00");
	});
	//合买区的可变比例清零
	$(".buy_table").find("span.scale").each(function(){
		$(this).html("0.00");
	});
	//提成选中0
	$("#tcSelect").get(0).selectedIndex=4;
	//公开方式选中0
	$("input[name='gk'][value='0']").attr("checked",true);
	//保底复选默认不被选中并且保底文本框disabled
	$("#isbaodi").removeAttr("checked").parent()
		.nextAll("#bdInput").attr("disabled","disabled").val("0")
		.nextAll("#bdMoney").html("￥0.00").nextAll("#bdScale").html("0.00");
	//清除错误信息			
	$("#rgErr").hide(); $("#bdErr").hide();
}

//清楚用户购买详细信息区及号码栏的所有信息
var clearptInfo = function(){
	//清除号码栏
	$("#pt_list >li").remove();
	//选择注数清零
	$("#pt_zs").html(0);$("#pt_bs").val(1);
	$("#pt_money").html("￥0.00");
	$("#buyMoneySpan").html("￥0.00");
	//合买区域清除
	clearhmInfo();
	
}

var cleardtInfo = function(){
	//清除号码栏
	$("#dt_list >li").remove();
	//选择注数清零
	$("#dt_zs").html(0);$("#dt_bs").val(1);
	$("#dt_money").html("￥0.00");
	$("#buyMoneySpan").html("￥0.00");
	//合买区域清除
	clearhmInfo();
	
}

//清除单式上传区
var clearDssc = function(){
	$("#sc_bs_input").val(1);
	$("#sc_zs_input").val(0);
	$("#buyMoneySpan").val("￥0.00");
	dsscInputKeyUp();
}


/**
 * 清除前后区的号码
 * @param pt //前区,后区
 */
var clearNum = function(pt){
	$("#"+pt+" li b").attr("class","");
	judgment();//选好了按钮状态
}

//清除号码栏
var clearNumQu = function(){
	$("#pt_red li b").attr("class","");
    $("#pt_blue li b").attr("class","");
    $("#red_num").html(0);
	$("#blue_num").html(0);
	$("#all_num").html(0);
	$("#all_money").html("￥0.00");
    $("#pt_put").attr("class","s-ok");
}


//清除胆拖号码栏
var clearDtNumQu = function(){
	$("#dt_dan li b").attr("class","");
    $("#dt_tuo li b").attr("class","");

	$("#dt_blue li b").attr("class","");
    $("#dt_blue_tuo li b").attr("class","");

	$("#dt_red_dan_num").html(0);
	$("#dt_blue_dan_num").html(0);
	$("#dt_red_tuo_num").html(0);
	$("#dt_blue_tuo_num").html(0);
   	$("#dt_all_num").html(0);
	$("#dt_all_money").html("￥0.00");
    $("#dt_put").attr("class","s-ok");
}

/**
 * @ n --记住
 * 机选
 */
var randomSelection = function(n){
	for(var i = 0; i<n ; i++){
		var pt_red_sel_val = getRandomNum(35,5);
		var pt_blue_sel_val = getRandomNum(12,2);
		$("<li><span class='red'>"+pt_red_sel_val+"</span> |" +
				" <span class='blue'>"+pt_blue_sel_val+"</span></li>").appendTo("#jx_dlg_list");
	}
}

//根据号码给号码区赋值显示
var pushNumToQu = function(id,numArr,className){
	for(var j = 0 ; j<numArr.length ; j++){
		$("#"+id+" li b:eq("+(numArr[j]-1)+")").addClass(className);
	}
}

//为现在及将来添加的动态代码添加事件
$(function(){
	//为class为del的a标签
	$('#pt_list >li >a').live('click', function(event) {
		//修改本行删除之后的注数
		var curr_zs = $(this).attr("condition");
		//选择的注数
		var pt_zs = $("#pt_zs").html();
		pt_zs-=parseInt(curr_zs); //减少选择的注数
		$("#pt_zs").html(pt_zs); //页面展示最新注数
		changeNewNum();
		//删除选的号码
		//删除号码栏中点击删除的列
		clearNumQu();
		$(this).parents("li").remove();
		event.stopPropagation();//阻止事件冒泡
	});
	
	//选中本行在号码区显示对应号码
	$("li.pointer").live('click', function() { 
		var all_num = $(this).attr("condition");
		//清除本区其他的颜色
		$("#pt_list >li").each(function(){
			$(this).removeClass("list-Selected");
		})
		//当前行选中 变色
		$(this).addClass("list-Selected");
		
		var red_val = all_num.split("|")[0];
		var blue_val = all_num.split("|")[1];
		clearNumQu();
		var numObj = numObject();
		pushNumToQu("pt_red",red_val.split(","),numObj.red_class);//红区显示
		pushNumToQu("pt_blue",blue_val.split(","),numObj.blue_class);//蓝区显示
		judgment();
	});

	$('#dt_list >li >div >a').live('click', function(event) {
		//修改本行删除之后的注数
		var curr_zs = $(this).attr("condition");
		//选择的注数
		var dt_zs = $("#dt_zs").html();
		dt_zs-=parseInt(curr_zs); //减少选择的注数
		$("#dt_zs").html(dt_zs); //页面展示最新注数
		dtchangeNewNum();
		//删除选的号码
		//删除号码栏中点击删除的列
		clearDtNumQu();
		$(this).parents("li").remove();
		event.stopPropagation();//阻止事件冒泡
	});
	//选中本行在号码区显示对应号码
	$("li.dtpointer").live('click', function() { 
		var all_num = $(this).attr("condition");
		//清除本区其他的颜色
		$("#dt_list >li").each(function(){
			$(this).removeClass("list-Selected");
		})
		//当前行选中 变色
		$(this).addClass("list-Selected");	
		
		var dantuo =  all_num.split("|");
		var red = dantuo[0];
		var blue = dantuo[1];
		var red_dan_num = red.split("$")[0];
		var red_tuo_num = red.split("$")[1];
		var blue_dan_num = blue.split("$")[0];
		var blue_tuo_num = blue.split("$")[1];

		if(blue_dan_num.length<1){
			blue_dan_num_length= 0;
		}
		
		clearDtNumQu();
		var numObj = numObject();
		//alert(red_dan_num);alert(red_tuo_num);alert(blue_dan_num);alert(blue_tuo_num);
		$("#dt_red_dan_num").html(red_dan_num.split(',').length);
		$("#dt_red_tuo_num").html(red_tuo_num.split(',').length);
		$("#dt_blue_dan_num").html(blue_dan_num.split(',').length);
		$("#dt_blue_tuo_num").html(blue_tuo_num.split(',').length);

		pushNumToQu("dt_dan",red_dan_num.split(","),numObj.red_class);//红区显示
		pushNumToQu("dt_tuo",red_tuo_num.split(","),numObj.red_class);//蓝区显示
		pushNumToQu("dt_blue",blue_dan_num.split(","),numObj.blue_class);//红区显示
		pushNumToQu("dt_blue_tuo",blue_tuo_num.split(","),numObj.blue_class);//蓝区显示
		dtjudgment();
	});


});

//根据滚动条获取层显示的top,left -- Answer层
var offsetAnswerObj = function(div_,div_height,div_width,tip1,tip2,offset,direction){
	console.log("jdjdj");
	newPos=new Object();
	var scrollTop = $(document).scrollTop();
	var upTop = offset.top;
	var leftLeft = offset.left;
	newPos.left =  leftLeft - direction;
	if(scrollTop<upTop-div_height){
		newPos.top=offset.top-div_height;
		div_.removeClass().addClass("notifyicon").addClass(tip1);
		div_.children(".notifyicon_content").children().clone(true).appendTo(div_.children(".notifyicon_space"));
		div_.children(".notifyicon_space").attr("class","notifyicon_content");
		div_.children(":last").attr("class","notifyicon_space").html("");
	}else{
		newPos.top=offset.top+div_width;
		div_.removeClass().addClass("notifyicon").addClass(tip2);
		div_.children(".notifyicon_content").children().clone(true).appendTo(div_.children(".notifyicon_space"));
		div_.children(".notifyicon_space").attr("class","notifyicon_content");
		div_.children().eq(0).attr("class","notifyicon_space").html("");
	}
	return newPos;
}


//show answer
//显示问答div
var showAnswerDiv = function(div_,content,offset){
	div_.css("left",offset.left).css("top",offset.top).show().children(".notifyicon_content").html(content);
}

//合买区域验证
$(function(){
	//保底复选
	$("#isbaodi").bind("click",hmbdVali);
	
	//认购验证
	$("#rgInput").keyup(function(){
		if($("#pttz_tab").is(":checked")){
			rgKeyup($("#pt_money"),$("#rgInput"));
		}else{
			rgKeyup($("#sc_money"),$("#rgInput"));
		}
	});
	
	//保底文本框按键的事件
	$("#bdInput").keyup(function(){
		if($("#pttz_tab").is(":checked")){
			bdKeyup($("#pt_money"),$("#bdInput"));
		}else{
			bdKeyup($("#sc_money"),$("#bdInput"));
		}
	});
	
	
	//倍数keyup事件
	$("#pt_bs").keyup(function(){
		//字符验证
		formatMatch($(this),1);
		changeNewNum();
	});
	$("#pt_bs").blur(function(){
		if($(this).val()<1){
			$("#pt_bs").val(1);
		}
	});

	$("#dt_bs").keyup(function(){
		//字符验证
		formatMatch($(this),1);
		dtchangeNewNum();
	});
	$("#dt_bs").blur(function(){
		if($(this).val()<1){
			$("#dt_bs").val(1);
		}
	});




	
	//由多人共同出资购买彩票选项 
	$("#all_form >em").hover(function(){
		var offset = $(this).offset();
		var div = $("#notifyicon_answer");
		var content = "<h5 style='background-position: 0pt -240px;'>代购：</h5>是指方案发起人自己一人全额认购方案的购彩形式。若中奖，" +
				"奖金也由发起人一人独享。<br><br><h5 style='background-position: 0pt -240px;'>" +
				"合买：</h5>由多人共同出资购买同一个方案，如果方案中奖，则按投入比例分享奖金。合买能够实现利益共享、风险共担，是网络购彩的一大优势。" +
				"<br><br><h5 style='background-position: 0pt -240px;'>追号：</h5>追号是选中了一注或一组号码，连续买几期或十几期甚至几十期。"
		var newPos = offsetAnswerObj(div,parseInt(div.css("height")),15,"tip-1","tip-4",offset,300);
		showAnswerDiv(div,content,newPos);
	},
	function(){
		hideInputInfo($('#notifyicon_answer'));
	});
	
});


//我要保底 复选框选中执行的事件
var hmbdVali = function(){
	if($("#isbaodi").is(":checked")){
		var bd_val = $("#bdInput").val();
		var pt_money = "";//所有钱数
		if($("#pttz_tab").attr("checked")==true){ //普通投注
			pt_money = numFormat($("#pt_money").html());//所有钱数
		}else if($("#dssc_tab").attr("checked")==true){ //单式上传
			pt_money = numFormat($("#sc_money").html());//所有钱数
		}
		else if($("#dttz_tab").attr("checked")==true){ //胆拖投注
			pt_money = numFormat($("#dt_money").html());//所有钱数
		}

		var bd_val = pt_money*bdScale;//保底份数
		if(bd_val>parseInt(bd_val)){
			bd_val = parseInt(bd_val)+1;
		}
		var bd_money = tofloat(bd_val*1);//保底金额
		
		var bd_scale = "";
		if(pt_money<=0){//总金额为0  提示用户
			$("#bdErr").show();
			bd_scale = "0.00";
		}else{
			bd_scale = toscale((bd_val/pt_money)*100,2);
		}
		$("#bdInput").val(bd_val).removeAttr("disabled")
		.nextAll("#bdMoney").html(bd_money).nextAll("#bdScale").html(bd_scale);
	}else{
		$("#bdErr").hide();//错误提示隐藏
		$("#isbaodi").removeAttr("checked").parent()
		.nextAll("#bdInput").attr("disabled","disabled").val("0")
		.nextAll("#bdMoney").html("￥0.00").nextAll("#bdScale").html("0.00");
	}
}


//认购按键
var rgKeyup = function(moneyObj,this_){
	//字符验证
	formatMatch(this_,1);
	
	var pt_money = numFormat(moneyObj.html()); //获得投注总金额
	
	//认购数据限制
	if(this_.val()>pt_money){
		$("#rgInput").val(pt_money);
	}		
	var rg_scale = $("#rg_scale").html()/1; //获得认购比例
	
	
	if(pt_money<=0){
		rg_scale = "0.00";
	}else{
		$("#rgMoney").html(tofloat(this_.val()*1));
		var rg_money = numFormat($("#rgMoney").html()); //获得认购金额
		rg_scale = (rg_money/pt_money)*100;			
	}
	$("#rgScale").html(toscale(rg_scale,2));
	//计算至少需要认购多少份
	var fs_val = pt_money*minFsScale;
	if(fs_val > parseInt(fs_val)){
		fs_val+=1;
	}
	//验证认购的份数
	var fs_int_val = parseInt(fs_val)==0?1:parseInt(fs_val);
	if(this_.length==0 || this_.val()==0 ||this_.val()<fs_int_val && pt_money>0){
		$("#rgErr").show().children("b").html(fs_int_val);
	}else{//验证通过
		$("#rgErr").hide();
	}
}

// 保底按键
var bdKeyup = function(moneyObj,this_){
	var pt_money = numFormat(moneyObj.html()); //获得投注总金额
	//字符验证
	formatMatch(this_,1);
	var rg_true_val = pt_money*minFsScale;//认购的份数
	if(rg_true_val > parseInt(rg_true_val)){
		rg_true_val+=1;
	}
	var rg_int_val = parseInt(rg_true_val);//最低认购分数
	//保底数据限制
	if(this_.val()>=pt_money){
		$("#bdInput").val(pt_money);
	}
	
	var bd_scale = $("#bdScale").html()/1; //获得保底比例
	
	if(pt_money<=0){
		$("#bdErr").show();
		bd_scale = "0.00";
	}else{
		$("#bdMoney").html(tofloat(this_.val()*1,2));
		var rg_money = numFormat($("#bdMoney").html()); //获得认购金额
		bd_scale = (rg_money/pt_money)*100;			
	}
	
	$("#bdScale").html(toscale(bd_scale,2));
	//计算至少需要保底多少份
	var bd_val = pt_money*bdScale;
	if(bd_val > parseInt(bd_val)){
		bd_val+=1;
	}
	//验证认购的分数
	var bd_int_val = parseInt(bd_val);
	if(this_.length==0 || this_.val()==0 ||this_.val()<bd_int_val && pt_money>0){
		$("#bdErr").show().children("b").html(20);
	}else{//验证通过
		$("#bdErr").hide();
	}
}

//显示提示信息
var showInputInfo = function(div_,title,content,offset){
	div_.css("left",offset.left).css("top",offset.top).show().children(".notifyicon_content").children("h5").html(title)
		.next().html(content);
}

//隐藏提示信息 --用于其他元素
var hideInputInfo = function(div_){
	div_.hide();
}

//根据滚动条获取层显示的top,left
var offsetObj = function(div_,div_height,div_width,tip1,tip2,offset){
	newPos=new Object();
	newPos.left=offset.left;
	var scrollTop = $(document).scrollTop();
	var upTop = offset.top;
	if(scrollTop<upTop-div_height){
		newPos.top=upTop-div_height;
		div_.removeClass().addClass("notifyicon").addClass(tip1);
		div_.children(".notifyicon_content").children().clone(true).appendTo(div_.children(".notifyicon_space"));
		div_.children(".notifyicon_space").attr("class","notifyicon_content");
		div_.children(":last").attr("class","notifyicon_space").html("");
	}else{
		newPos.top=upTop+div_width;
		div_.removeClass().addClass("notifyicon").addClass(tip2);
		div_.children(".notifyicon_content").children().clone(true).appendTo(div_.children(".notifyicon_space"));
		div_.children(".notifyicon_space").attr("class","notifyicon_content");
		div_.children().eq(0).attr("class","notifyicon_space").html("");
	}
	offset = newPos;
	return newPos;
}

//单式上传，倍数文本框验证
var dssc_vali_input = function(){
	var sc_zs_input = $("#sc_zs_input");
	var sc_bs_input = $("#sc_bs_input");
	if(!$("#dssc_tab").is(":checked")){
		return false;	
	}
	if(sc_zs_input.val()==0 || sc_zs_input.length<1){
		var offset = sc_zs_input.offset();
		newPos = offsetObj($("#tsdiv"),90,24,"tip-2","tip-3",offset);
		var money = "￥"+zsMoney+".00";
		showInputInfo($("#tsdiv"),"投注金额限制","您发起的方案金额不能少于"+money+"元, 请修改!",newPos);
		return false;
	}
	if(sc_bs_input.val()==0 || sc_bs_input.length<1){
		var offset = $(this).offset();
		newPos = offsetObj($("#tsdiv"),90,24,"tip-2","tip-3",offset);
		var money = "￥"+zsMoney+".00";
		showInputInfo($("#tsdiv"),"投注金额限制","您发起的方案金额不能少于"+money+"元, 请修改!",newPos);
		return false;
	}
	return true;
}



/**
 * 单式上传
 */
$(function(){
	//发起方案注数
	$("#sc_zs_input").keyup(function(event){
		matchInput($(this),2);
		var offset = $(this).offset();
		newPos = offsetObj($("#tsdiv"),90,24,"tip-2","tip-3",offset);
		if($(this).val()==0 || $(this).length<=0){
			var money = "￥"+zsMoney+".00";
			showInputInfo($("#tsdiv"),"投注金额限制","您发起的方案金额不能少于"+money+"元, 请修改!",newPos);
		}else{
			hideInputInfo($("#tsdiv"));
		}
		dsscInputKeyUp();
	});
	
	//倍数光标丢失的时候值为1，隐藏提示框
	$("#sc_bs_input").blur(function(){
		if($(this).val()==0 || $(this).length<1){
			$(this).val(1);
		}
		hideInputInfo($("#tsdiv"));
		dsscInputKeyUp();
	});
	
	
	//倍数
	$("#sc_bs_input").keyup(function(){
		matchInput($(this),1);
		var offset = $(this).offset();
		newPos = offsetObj($("#tsdiv"),90,24,"tip-2","tip-3",offset);
		if($(this).val()==0 || $(this).length<=0){
			var money = "￥"+zsMoney+".00";
			showInputInfo($("#tsdiv"),"投注金额限制","您发起的方案金额不能少于"+money+"元, 请修改!",newPos);
		}else{
			hideInputInfo($("#tsdiv"));
		}
		dsscInputKeyUp();
	});
	
	//小提示信息hover
	$("#tsdiv").hover(
		function(){
			$(this).show();
		},
		function(event){
			hideInputInfo($("#tsdiv"));
		}
	);

	//问题hover
	$("#notifyicon_answer").hover(
		function(){
			$(this).show;
		},
		function(event){
			hideInputInfo($("#tsdiv"));
		}
	);
	
	
	//发起后再上传
	$("#scChk").click(function(){
		xfqhscFunc();
	});
	
	//方案宣传
	$("#moreCheckbox").click(function(){
		faxcFunc();
	});
	//追号mouseOver
	$("label.addpricehelp").each(function(){
		$(this).hover(
			function(event){
				zhonMouseOverFunc($(this));
			},
			function(event){
				hideInputInfo($("#tsdiv"));
			}
		)
	});
});

//先发起后上传事件
var xfqhscFunc = function(){
	if($("#scChk").is(":checked")){
		$("#dssc >div >div >ul li:eq(2)").hide();
		$("#uphelp").hide();
		$("#all_form >span.sort >label:eq(0)").hide();
		$("#all_form >span.sort >label:eq(1) >:radio").click();
	}else{
		$("#dssc >div >div >ul li:eq(2)").show();
		$("#uphelp").show();
		$("#all_form >span.sort >label:eq(0)").show();
		$("#all_form >span.sort >label:eq(0) >:radio").click();
	}
}


//单式上传按键事件
var dsscInputKeyUp = function(){
	var sc_zs_input = $("#sc_zs_input").val();
	var sc_bs_input = $("#sc_bs_input").val();//单式上传倍数
	var sc_money = tofloat(sc_zs_input*sc_bs_input*zsMoney,2);
	$("#sc_money").html(sc_money);
	rgbdFunc(numFormat(sc_money));
}

//追号被选中时的事件
var zhFunc = function(zhid1,zhid2,zhid3,zhid4){
	if($("#"+zhid1+"").is(":checked")){
		$("#"+zhid2+"").attr("checked","checked");
		$("#"+zhid3+"").attr("checked","checked");
		$("#"+zhid4+"").attr("checked","checked");
		zsMoney = 3;
	}else{
		$("#"+zhid2+"").removeAttr("checked");
		$("#"+zhid3+"").removeAttr("checked");
		$("#"+zhid4+"").removeAttr("checked");
		zsMoney = 2;
	}

	if($("#pttz_tab").is(":checked")){
		changeNewNum();
	}
	else if($("#dttz_tab").is(":checked")){
		dtchangeNewNum();

	}
	else if($("#dssc_tab").is(":checked")){
		dsscInputKeyUp();
		dssc_vali_input();
		dsscInputKeyUp();
	}
}

//追号mouseOver事件
var zhonMouseOverFunc = function(this_){
	var offset = this_.offset();
	newPos = offsetObj($("#tsdiv"),90,14,"tip-2","tip-3",offset);
	showInputInfo($("#tsdiv"),"追加投注","每注追加1元，单注奖金可增至1600万!!",newPos);
}

//可选 方案宣传与合买对象
var faxcFunc = function(){
	if(!$("#moreCheckbox").is(":checked")){
		$("#case_ad").hide();
	}else{
		$("#case_ad").show();
	}	
}


//切 关闭
$(function(){
	
	$("#pttz_tab").attr("checked","checked");
	//判断是否追号
	if($("#zjtz23").is(":checked")){
		zsMoney =3
	}else{
		zsMoney =2;
	}


	clearPttzDiv();
	clearDttzDiv
	//普通投注
	$("#pttz_tab").click(function(){
		clearPttzDiv();
		clearDttzDiv();
		$("#rd3").attr("checked","checked").click();//默认选中代购
		if(!$("#pttz").is(":visible")){
			$(".c-inner").hide();//关闭class为c-inner的div
			$("#pttz").show();
		}
		clearDssc();
	});
	
	//单式上传
	$("#dssc_tab").click(function(){
		clearPttzDiv();
		clearDttzDiv();
		clearDssc();
		$("#rd3").attr("checked","checked").click();//默认选中代购
		$("#scChk").removeAttr("checked");xfqhscFunc();//先发起后上传
		if(!$("#dssc").is(":visible")){
			$(".c-inner").hide();//关闭class为c-inner的div
			$("#dssc").show();
		}
		//var upfileClone = $("#upfile").clone(true);
		$("#upfile").remove();
		var upfile = "<input type='file' name='upfile' id='upfile' />";
		$(upfile).appendTo("#suc_form");
	});
	//胆拖投注
	$("#dttz_tab").click(function(){
		clearPttzDiv();
		clearDttzDiv();
		clearDssc();
		$("#rd3").attr("checked","checked").click();//默认选中代购
		
		if(!$("#dttz").is(":visible")){
			$(".c-inner").hide();//关闭class为c-inner的div
			$("#dttz").show();
		}

	});

	if($("#zjtz2").is(":checked")){
		zsMoney =3
	}else{
		zsMoney =2;
	}
	
	//代购radio被选中
	$("#rd3").click(function(){
		if(!$("#dg_form").is(":visible")){
			$("div.con >div").hide();//关闭代购所在与之平级的div
			$("#dg_form").show();
		}
	});
	
	//合买radio被选中
	$("#rd4").click(function(){
		if(!$("#hm_form").is(":visible")){
			$("div.con >div").hide();//关闭合买所在与之平级的div
			$("#hm_form").show();
		}
	});
	
	//关闭温馨提示层
	$("#info_dlg_ok").bind("click",closeInfoDlgDiv);
	$("#info_dlg_close").bind("click",closeInfoDlgDiv);
	
	//红区悬浮
	$("#pt_red li b,#dt_dan li b,#dt_tuo li b").hover(
		function(){
			if($(this).attr("class")==""){
				$(this).addClass("r-a");
			}
		},
		function(){
			$(this).removeClass("r-a");
		}
	);	
	//蓝区悬浮
	$("#pt_blue li b,#dt_blue li b,#dt_blue_tuo li b").hover(
		function(){
			if($(this).attr("class")==""){
				$(this).addClass("b-a");
			}
		},
		function(){
			$(this).removeClass("b-a");
		}
	);




	//查看标准格式
	$("#queryGs").click(function(){
		openDiv($("#gsdiv"));
	});
	$("#queryXy").click(function(){
		openDiv($("#xydiv"));
	});
	$("#queryXy2").click(function(){
		openDiv($("#xydiv"));
	});
	$("#closeGs").bind("click",closeGsDiv);
	$("#closeGsDiv").bind("click",closeGsDiv);
	$("#closeXy1").bind("click",closeXyDiv);
	$("#closeXy2").bind("click",closeXyDiv);
	//
	$("#expect_tab >a").live("click",function(){
		$("#expect_tab a").removeClass();
		$(this).addClass("on");
		var etime = $(this).attr("etime");
		$("#endTimeSpan").html(etime);
	});
	
	$("#caseTitle").val(fa_title);
	$("#caseInfo").val(fa_ms);
	
	//方案标题
	$("#caseTitle").focus(function(){
		if($(this).val()==fa_title){
			$(this).val("");
		}
	})
	$("#caseTitle").blur(function(){
		if($(this).val()==""){
			$(this).val(fa_title);
		}
	})
	$("#caseTitle").keyup(function(){
		var length = $(this).val().length;
		$("#zfsz_len").html(length);
		if(length>20){
			var offset = $(this).offset();
			newPos = offsetObj($("#tsdiv"),90,24,"tip-2","tip-3",offset);
			showInputInfo($("#tsdiv"),"字符限制","方案标题最多只能输入20个字符！",newPos);
		}else{
			hideInputInfo($("#tsdiv"));	
		}
	})
	
	$("#caseInfo").focus(function(){
		if($(this).val()==fa_ms){
			$(this).val("");
		}
	})
	$("#caseInfo").blur(function(){
		if($(this).val()==""){
			$(this).val(fa_ms);
		}
	})
	$("#caseInfo").keyup(function(){
		var this_val = $(this).val();
		var length = this_val.length;
		$("#ms_zfsz_len").html(length);
		if(length>200){
			$(this).val("");
			var maxValue = this_val.substring(0,200);
			$("#ms_zfsz_len").html(maxValue.length);
			$(this).val(maxValue);
			return false;
		}	
	});
});

//普通投注初始化
var clearPttzDiv = function(){
	clearNumQu();//清除号码区
	clearptInfo();//清除合买区
	$("#buyMoneySpan").html("￥0.00");	
	$("#rd3").click();
	$("#moreCheckbox").removeAttr("checked");//清除方案宣传与合买对象复选框
	$("#case_ad").hide();
	faxcFunc();
}

//普通投注初始化
var clearDttzDiv = function(){
	clearDtNumQu();//清除号码区
	cleardtInfo();//清除合买区
	$("#buyMoneySpan").html("￥0.00");	
	$("#rd3").click();
	$("#moreCheckbox").removeAttr("checked");//清除方案宣传与合买对象复选框
	$("#case_ad").hide();
	faxcFunc();
}
//ajax方法
var ajax = function(param,url,successCallBack,errorCallBack){
	$.ajax({
		type : "POST",
		url : url,
		dataType : "json",
		data:param,
		success : successCallBack,
		error: errorCallBack
	});
}

//ajaxUpload
var fileUpload = function(datas){
	var data = datas;
	$.ajaxFileUpload
    (
        {
        	type : "POST",
            url:dssc_url,//用于文件上传的服务器端请求地址
            secureuri:false,//一般设置为false
            fileElementId:'upfile',//文件上传空间的id属性  <input type="file" id="file" name="file" />
            dataType: 'json',//返回值类型 一般设置为json
            data:data,
            success: function (data, status)  //服务器成功响应处理函数
            {
				var statu = data.stat;
				if(statu!=200){
					
					openInfoDlgDiv(data.info);
				}else{
					window.location.href=""+data.url+""; 
				}
            }
        }
    )
}

//Ajax
$(function(){
	//获取期号
	var issueParam = "";
	ajax(issueParam,issue_url,issue_success,errorCallBack);
	
	//开奖公告
	var kjggParam = "";
	ajax(kjggParam,kjgg_url,kjgg_success,errorCallBack);
	
	//立即代购
	$("#buy_dg").click(function(){
		Y.postMsg('msg_login',buyNow);
		//buyNow()
	});
	
	//发起合买
	$("#buy_hm").click(function(){
		//buyHm();
		Y.postMsg('msg_login',buyHm);
	});
});

//期号集合
function issue_success(data){
	var issueArr = new Array(3);
	var etimeArr = new Array(3);
	var flag = 0;
	$.each(data, function(index, item) {
		var isnow = item.isnow;
		var allowbuy = item.allowbuy;
		if(isnow == 1 && allowbuy==1){
			issueArr[0] = item.lotissue;etimeArr[0] = item.etime;flag+=1;
			return true;
		}
		if(isnow !=1 && allowbuy==1){
			if(issueArr[1]=="" || issueArr[1]==undefined){
				issueArr[1] = item.lotissue;etimeArr[1] = item.etime;flag+=1;
				return true;
			}
		}
		if(isnow !=1 && allowbuy==1){
			if(issueArr[2]=="" || issueArr[2]==undefined){
				issueArr[2] = item.lotissue;etimeArr[2] = item.etime;flag+=1;
				return true;
			}
		}
	});
	$.each(issueArr,function(index,value){
		var a_ = $('<a href="javascript:void 0" onclick="return false" title="" id="'+issueArr[index]+'" etime="'+etimeArr[index]+'"></a>');
		if(index==0){
			a_.text("当前期"+issueArr[0]+"期").attr("class","on");
		}else{
			if(issueArr[index]!=undefined){ 
				a_.text("预售期"+issueArr[index]+"期").removeAttr("class","on");
			}
		}
		$("#expect_tab").append(a_);
		if(index<flag-1){
			$("#expect_tab").append("|");
		}
		//$("#expect_tab >a:eq("+index+")").attr("id",issueArr[index]).attr("etime",etimeArr[index]).html(issueStr+issueArr[index]+"期");
	});
	var endTime = $("#expect_tab >a").filter(".on").attr("etime");
	$("#endTimeSpan").html(endTime);
}
function errorCallBack(){
	
}

//开奖公告
function kjgg_success(data){
	var tbody = $("<tbody>");
	$.each(data, function(index, item){
		var awardnum = item.awardnum;//开奖号码
		var acc = item.acc; //滚存
		var issue = item.issue;
		
		if(index==0){
			var red_num = awardnum.substring(0,awardnum.indexOf("|")).split(",");
			var blue_num = awardnum.substring(awardnum.indexOf("|")+1,awardnum.length).split(",");
			$("#kj_opcode >b:lt(5)").each(function(i){$(this).html(red_num[i]);});//红号
			$("#kj_opcode >b:gt(4)").each(function(i){$(this).html(blue_num[i]);});//蓝号
			$("#kj_opcode").nextAll("dd").children("em").html(tofloat(acc,2));//滚存
			$("#kj_opcode").prev().children().html("第"+issue+"期开奖号码：");
		}else{
			var red_num = replaceAll(awardnum.substring(0,awardnum.indexOf("|")),","," ");
			var blue_num = replaceAll(awardnum.substring(awardnum.indexOf("|")+1,awardnum.length),","," ");
			var tr = $("<tr>");
			var tds = "";// 定义添加的列
			tds +="<td class='tc'>"+issue+"</td>";
			tds +="<td class='tc'><span style='display: inline-block; color: red'>" +
					""+red_num+"</span>&nbsp;+&nbsp;<span style='display: inline-block; color: blue'>" +
					""+blue_num+"</span></td>";
			var $tds = $(tds);
			$tds.appendTo(tr);
			tr.appendTo(tbody);
		}
	});
	tbody.appendTo(".zj_table");
}

//发起提交
function fq_success(data){
	var statu = data.stat;
	if(statu!=200){
		openInfoDlgDiv(data.info);
	}else{
		window.location.href=""+data.url+""; 
	}
}

//收集单式数据
var getDsParam = function(){
	var lottid = $("#lottid").val();//彩种ID
	var sc_zs_input = $("#sc_zs_input").val();
	var multi = $("#sc_bs_input").val();
	var wtype = 3;
	var qihao = "";
	var amoney = numFormat($("#sc_money").html());
	var scChk = $("#scChk").is(":checked")==true?"0":"1";
	var issue = $("#expect_tab >a.on").attr("id");
	if($("#rd3").is(":checked")){
		show = 0;
		param = {"lottid":lottid,"znum":sc_zs_input,"wtype":wtype,"codes":"","ishm":"0",
		"qihao":issue,"multi":multi,"amoney":amoney,"pmoney":zsMoney,"show":"0","tcratio":"0",
		"nums":"1","rgnum":"1","omoney":amoney
		,"bflag":"0","bnum":"0","isup":scChk};
	}else{
		var gk_val = $("input[name='gk']:checked").val();
		var tc_select_val = $("#tcSelect").val();//提成
		var fs_input_val = $("#fsInput").val();
		var rg_input_val = $("#rgInput").val();
		var bflag = $("#isbaodi").is(":checked")==true?1:0;
		var bd_input_val = $("#bdInput").val();
		var moreCheckbox = $("#moreCheckbox").is(":checked");
		var title = "";var desc = "";
		if(moreCheckbox){
			title = encodeURIComponent($.trim($("#caseTitle").val()));
			desc = encodeURIComponent($.trim($("#caseInfo").val()));
		}
		param = {"lottid":lottid,"znum":sc_zs_input,"wtype":wtype,"codes":"","ishm":"1",
			"qihao":issue,"multi":multi,"amoney":amoney,"pmoney":zsMoney,"show":gk_val,"tcratio":tc_select_val,
			"nums":fs_input_val,"rgnum":rg_input_val,"omoney":"1","bflag":bflag,"bnum":bd_input_val,"isup":scChk,
			"title":title,"desc":desc
		};
	}
	var paramObj = $.toJSON(param);
	return paramObj;
}

//收集复试参数
var getPtParam = function(){
	var fs_input_val = $("#fsInput").val();//分为
	var tc_select_val = $("#tcSelect").val();//提成
	var gk_val = $("input[name='gk']:checked").val();
	var rg_input_val = $("#rgInput").val();
	var bd_input_val = $("#bdInput").val();
	var case_title = $("#caseTitle").val();
	var case_info = $("#caseInfo").val();
	var lottid = $("#lottid").val();//彩种ID
	var pt_zs = $("#pt_zs").html(); //总注数
	var wtype = "1";
	var codes = "";
	$("#pt_list >li").each(function(i){
		codes += $(this).attr("condition");
		codes+=";";
	});
	var radio_g2 = $("input[name='radio_g2']:checked").val();//购买方式
	var issue = $("#Id");
	var multi = $("#pt_bs").val();//倍数
	var amoney = numFormat($("#pt_money").html());//总金额
	var bflag = $("#isbaodi").is(":checked")==true?1:0;
	var param = "";
	var issue = $("#expect_tab >a.on").attr("id");
	if($("#rd3").is(":checked")){
		param = {"lottid":lottid,"znum":pt_zs,"wtype":wtype,"codes":codes,"ishm":radio_g2,
		"qihao":issue,"multi":multi,"amoney":amoney,"pmoney":zsMoney,"show":"0","tcratio":"0",
		"nums":"1","rgnum":"1","omoney":amoney,"bflag":"0","bnum":"0"
		};
	}else{
		var moreCheckbox = $("#moreCheckbox").is(":checked");
		var title = "";var desc = "";
		if(moreCheckbox){
			title = encodeURIComponent($.trim($("#caseTitle").val()));
			desc = encodeURIComponent($.trim($("#caseInfo").val()));
		}
		param = {"lottid":lottid,"znum":pt_zs,"wtype":wtype,"codes":codes,"ishm":radio_g2,
			"qihao":issue,"multi":multi,"amoney":amoney,"pmoney":zsMoney,"show":gk_val,"tcratio":tc_select_val,
			"nums":fs_input_val,"rgnum":rg_input_val,"omoney":""+1,"bflag":bflag,"bnum":bd_input_val,"title":title,
			"desc":desc
		};
	}
	var paramObj = new Object();
	paramObj.data = $.toJSON(param);
	return paramObj;
}

var getDtParam = function(){
	var fs_input_val = $("#fsInput").val();//分为
	var tc_select_val = $("#tcSelect").val();//提成
	var gk_val = $("input[name='gk']:checked").val();
	var rg_input_val = $("#rgInput").val();
	var bd_input_val = $("#bdInput").val();
	var case_title = $("#caseTitle").val();
	var case_info = $("#caseInfo").val();
	var lottid = $("#lottid").val();//彩种ID
	var pt_zs = $("#dt_zs").html(); //总注数
	var wtype = "13";
	var codes = "";
	$("#dt_list >li").each(function(i){
		codes += $(this).attr("condition");
		codes+=";";
	});
	var radio_g2 = $("input[name='radio_g2']:checked").val();//购买方式
	var issue = $("#Id");
	var multi = $("#pt_bs").val();//倍数
	var amoney = numFormat($("#dt_money").html());//总金额
	var bflag = $("#isbaodi").is(":checked")==true?1:0;
	var param = "";
	var issue = $("#expect_tab >a.on").attr("id");
	if($("#rd3").is(":checked")){
		param = {"lottid":lottid,"znum":pt_zs,"wtype":wtype,"codes":codes,"ishm":radio_g2,
		"qihao":issue,"multi":multi,"amoney":amoney,"pmoney":zsMoney,"show":"0","tcratio":"0",
		"nums":"1","rgnum":"1","omoney":amoney,"bflag":"0","bnum":"0"
		};
	}else{
		var moreCheckbox = $("#moreCheckbox").is(":checked");
		var title = "";var desc = "";
		if(moreCheckbox){
			title = encodeURIComponent($.trim($("#caseTitle").val()));
			desc = encodeURIComponent($.trim($("#caseInfo").val()));
		}
		param = {"lottid":lottid,"znum":pt_zs,"wtype":wtype,"codes":codes,"ishm":radio_g2,
			"qihao":issue,"multi":multi,"amoney":amoney,"pmoney":zsMoney,"show":gk_val,"tcratio":tc_select_val,
			"nums":fs_input_val,"rgnum":rg_input_val,"omoney":""+1,"bflag":bflag,"bnum":bd_input_val,"title":title,
			"desc":desc
		};
	}
	var paramObj = new Object();
	paramObj.data = $.toJSON(param);
	return paramObj;
}

//立即购买
var buyNow = function(){
	//普通投注
	if($("#pttz_tab").is(":checked")){
		var buyMoney = numFormat($("#buyMoneySpan").html());
		if(buyMoney == 0){
			openInfoDlgDiv("您好，请您至少选择一注号码再进行购买！");
			return false;
		}
		if(rgbdValidation()){
			openInfoDlgDiv("您好，数据正在提交中，请稍候...",false);
			var param = getPtParam();
			ajax(param,fq_url,fq_success,"");
		}
	}
	else if ($("#dttz_tab").is(":checked"))
	{
		var buyMoney = numFormat($("#buyMoneySpan").html());
		if(buyMoney == 0){
			openInfoDlgDiv("您好，请您至少选择一注号码再进行购买！");
			return false;
		}
		if(rgbdValidation()){
			openInfoDlgDiv("您好，数据正在提交中，请稍候...",false);
			var param = getDtParam();
			ajax(param,fq_url,fq_success,"");
		}
	}
	else{
		if(rgbdValidation()){
			openInfoDlgDiv("您好，数据正在提交中，请稍候...",false);
			var data = getDsParam();
			if($("#scChk").is(":checked")){
				var obj = new Object();
				obj.data = data;
				ajax(obj,fq_url,fq_success,"");
			}else{
				fileUpload(data);
			}
		}
	}
}

//合买
var buyHm = function(){	
	//合买投注
	if($("#pttz_tab").is(":checked")){
		var buyMoney = numFormat($("#buyMoneySpan").html());
		if(buyMoney == 0){
			openInfoDlgDiv("您好，请您至少选择一注号码再进行购买！");
			return false;
		}
		if(rgbdValidation()){
			openInfoDlgDiv("您好，数据正在提交中，请稍候...",false);
			var param = getPtParam();
			ajax(param,fq_url,fq_success,"");
		}
	}
	else if($("#dttz_tab").is(":checked")){
		var buyMoney = numFormat($("#buyMoneySpan").html());
		if(buyMoney == 0){
			openInfoDlgDiv("您好，请您至少选择一注号码再进行购买！");
			return false;
		}
		if(rgbdValidation()){
			openInfoDlgDiv("您好，数据正在提交中，请稍候...",false);
			var param = getDtParam();
			ajax(param,fq_url,fq_success,"");
		}
	}
	else{
		if(rgbdValidation()){
			openInfoDlgDiv("您好，数据正在提交中，请稍候...",false);
			var data = getDsParam();
			if($("#scChk").is(":checked")){
				var obj = new Object();
				obj.data = data;
				ajax(obj,fq_url,fq_success,"");
			}else{
				fileUpload(data);
			}
		}
	}
}

//验证认购，保底
var rgbdValidation = function(){
	var z_money = "";
	var pt_money = "";//所有钱数
	//普通投注
	if($("#pttz_tab").attr("checked")){ 
		pt_money = numFormat($("#pt_money").html());//所有钱数
		z_money = $("#pt_money");
	}
	else if($("#dssc_tab").attr("checked")){ //单式上传
		pt_money = numFormat($("#sc_money").html());//所有钱数
		z_money = $("#sc_money");
	}
	else if ($("#dttz_tab").attr("checked"))
	{
		pt_money = numFormat($("#dt_money").html());//所有钱数
		z_money = $("#dt_money");
	}
	
	var dsistrue = true;
	//单式上传选中状态
	if($("#dssc_tab").is(":checked")){
		//验证先发起后上传
		if(!$("#scChk").is(":checked")){
			if($("#upfile").val()==""){
				openInfoDlgDiv("您好，请选择要上传的方案文件！");
				return false;
			}
		}
		//验证注数 倍数
		dsistrue = dssc_vali_input();
	}
	if(!dsistrue){
		return false;
	}
	if($("#rd4").is(":checked")){ //HM
		var rg_input_val = $("#rgInput").val();
		var rg_val = pt_money*minFsScale;//保底份数
		if(rg_val>parseInt(rg_val)){
			rg_val = parseInt(rg_val)+1;
		}
		
		if(rg_input_val<rg_val){
			openInfoDlgDiv("您至少需要认购"+rg_val+"份！");
			$("#rgInput").val(rg_val);rgKeyup(z_money,$("#rgInput"));
			return false;
		}
		if($("#isbaodi").is(":checked")){
			var bd_input_val = $("#bdInput").val();
			var bd_val = pt_money*bdScale;//保底份数
			if(bd_val>parseInt(bd_val)){
				bd_val = parseInt(bd_val)+1;
			}
			if(bd_input_val<bd_val){
				openInfoDlgDiv("最低保底金额为方案总金额的20%！");
				$("#bdInput").val(bd_val);bdKeyup(z_money,$("#bdInput"));
				return false;
			}
		}
		if(!$("#agreement_hm").is(":checked")){
			openInfoDlgDiv("请先同意《用户合买代购协议》才能发起！");
			return false;
		}
	}else{
		if(!$("#agreement_dg").is(":checked")){
			openInfoDlgDiv("请先同意《用户合买代购协议》才能发起！");
			return false;
		}		
	}
	return true;
}

//显示背景色
var showBgdiv = function(){
     var set = document.getElementById("bgdiv");
	 //var height = window.screen.availHeight;
	 var height = document.body.scrollHeight;
     set.style.cssText="display:block;width:100%; height:"+height+"px; background:#666666; filter: Alpha(Opacity=20); -moz-opacity:0.2; opacity: 0.2; position:absolute;top:0; z-index:99999; left:0;";     
}
//隐藏背景色
var hideBgdiv = function(){
	$("#bgdiv").hide();
}

//打开温馨提示窗口
var openInfoDlgDiv = function(content,flag){
	var height = parseInt($("#info_dlg").css("height"));
	var scrollTop = $(document).scrollTop();
	var x=$(window).width()/2;
	var sleft=$("body").scrollLeft();
	var width = $("#info_dlg").width()/2;
	var left=x-width+sleft+"px";
	$("#info_dlg_content").html(content).parents("#info_dlg").
		css("left",left).css("top",height+scrollTop).draggable(".move").show();
	if(flag==false){		
		$("#info_dlg_ok").hide();	
	}
	if(flag==null || flag==undefined){
		$("#info_dlg_ok").show();
	}	
	showBgdiv();
}


//打开格式窗口
var openDiv = function(div_){
	var height = parseInt((div_).css("height"))/2;
	var x=$(window).width()/2;
	var sleft=$("body").scrollLeft();
	var width = $("#info_dlg").width()/2;
	var left=x-width+sleft+"px";
	var scrollTop = $(document).scrollTop();
	div_.css("top",scrollTop+140).css("left",left)
		.draggable(".move").show();
	showBgdiv();
}

//关闭格式窗口
var closeGsDiv = function(){
	$("#gsdiv").hide();
	hideBgdiv();
}

var closeXyDiv = function(){
	$("#xydiv").hide();
	hideBgdiv();
}

//关闭温馨提示窗口
var closeInfoDlgDiv = function(){
	$("#info_dlg").hide();
	hideBgdiv();
}

//文本框验证
var formatMatch = function(obj,flag){
	var value = $.trim(obj.val());
	var matchs = "";
	if(flag==1) matchs = /^[0-9]*[1-9][0-9]*$/;
	if(flag==2) matchs = /^(\d+)(\.?)(\d{0,2})$/;
	if(value.match(matchs)){
		obj.val(value);
   	}else{
   		if(flag==1)obj.val("1");
   		if(flag==2)obj.val("0");
   	}
}

//发起，倍数专用
var matchInput = function(obj,flag){
	var value = $.trim(obj.val());
	var matchs = "";
	if(flag==1) matchs = /^[0-9]*[1-9][0-9]*$/;
	if(flag==2) matchs = /^(\d+)(\.?)(\d{0,2})$/;
	if(value.match(matchs)){
		obj.val(value);
   	}else{
   		if(flag==1){obj.val("1");}
   		if(flag==2){obj.val("0");}
   		dssc_vali_input();
   		dsscInputKeyUp();
   	}
}

//选中的叫  s-ok-sp 没有选中的叫 s-ok


