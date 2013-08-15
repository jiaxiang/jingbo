String.prototype.isEmail = function(){
	return /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/.test(this);
};
/**
 * 
 */
var $_base_s = {};// ----处理函数
var $_user = {}; // ---用户
var $_trade = {}; // ---交易
var $_sys = {}; // 系统相关
var $_cache ={};//缓存相关

$_base_s.getStrLen = function(str) {// 含中文的字符串长度
	var len = 0;
	var cnstrCount = 0;
	for ( var i = 0; i < str.length; i++) {
		if (str.charCodeAt(i) > 255)
			cnstrCount = cnstrCount + 1;
	}
	len = str.length + cnstrCount;
	return len;
};

$_base_s.uniq= function(arr){//数组去重复	
	 var temp = {}, len = arr.length;
     for(var i=0; i < len; i++)  {  
         if(typeof temp[arr[i]] == "undefined") {
             temp[arr[i]] = 1;
         }  
     }  
     arr.length = 0;
     len = 0;
     for(var i in temp) {  
    	 arr[len++] = i;
     }  
     return arr;  
};

String.prototype.isDate = function() {
	var r = this.match(/^(\d{1,4})(-|\/)(\d{1,2})\2(\d{1,2})$/);
	if (r == null)
		return false;
	var d = new Date(r[1], r[3] - 1, r[4]);
	return (d.getFullYear() == r[1] && (d.getMonth() + 1) == r[3] && d.getDate() == r[4]);
};

String.prototype.getParam = function(n){
	var r = new RegExp("[\?\&]"+n+"=([^&?]*)(\\s||$)", "gi");
	var r1=new RegExp(n+"=","gi");
	var m=this.match(r);
	if(m==null){
		return "";
	}else{
		return typeof(m[0].split(r1)[1])=='undefined'?'':decodeURIComponent(m[0].split(r1)[1]);
	}
};

String.prototype.replaceAll = function(search, replace){ 
	 var regex = new RegExp(search, "g"); 
	 return this.replace(regex, replace); 
};  

Number.prototype.rmb = function(prevfix, n) {
	return (prevfix === false ? '' : '\uffe5') + this.toFixed(n === void 0 ? 2 : n).toString().replace(/(\d)(?=(\d{3})+($|\.))/g, '$1,');
};
//
//// getDate: function(date, def) {
//// var date = new Date(this.isString(date) ? date.replace(/-/g, '/') : date);
//// return isNaN(date) ? def: date
//// },
//
Date.prototype.format = function(tpl) {
	var strs, w, keys, year, val;
	strs = [];
	tpl = tpl || 'YY\u5e74MM\u6708DD\u65e5 \u661f\u671fdd';
	w = 'FullYear,Month,Date,Hours,Minutes,Seconds,Day'.split(',');
	keys = [ /YY/g, /Y/g, /MM/g, /M/g, /DD/g, /D/g, /hh/g, /h/g, /mm/g, /m/g, /ss/g, /s/g, /dd/g, /d/g ];
	for ( var i = 0; i < 7; i++) {
		val = this['get' + w[i]]() + (w[i] === 'Month' ? 1 : 0);
		strs.push(('0' + val).slice(-2), val);
	}
	year = [ strs[1], strs[0] ].concat(strs.slice(2, -2));
	year.push('\u65e5\u4e00\u4e8c\u4e09\u56db\u4e94\u516d'.substr(strs.slice(-1), 1), strs.slice(-1));
	for ( var i = 0; i < 14; i++) {
		tpl = tpl.replace(keys[i], year[i]);
	}
	return tpl;
};

Date.prototype.dateadd = function(strInterval, Number) {
	var dtTmp = this;
	switch (strInterval) {
	case 's':
		return new Date(Date.parse(dtTmp) + (1000 * Number));
	case 'n':
		return new Date(Date.parse(dtTmp) + (60000 * Number));
	case 'h':
		return new Date(Date.parse(dtTmp) + (3600000 * Number));
	case 'd':
		return new Date(Date.parse(dtTmp) + (86400000 * Number));
	case 'w':
		return new Date(Date.parse(dtTmp) + ((86400000 * 7) * Number));
	case 'q':
		return new Date(dtTmp.getFullYear(), (dtTmp.getMonth()) + Number * 3, dtTmp.getDate(), dtTmp.getHours(), dtTmp.getMinutes(), dtTmp.getSeconds());
	case 'm':
		return new Date(dtTmp.getFullYear(), (dtTmp.getMonth()) + Number, dtTmp.getDate(), dtTmp.getHours(), dtTmp.getMinutes(), dtTmp.getSeconds());
	case 'y':
		return new Date((dtTmp.getFullYear() + Number), dtTmp.getMonth(), dtTmp.getDate(), dtTmp.getHours(), dtTmp.getMinutes(), dtTmp.getSeconds());
	}
};

// +---------------------------------------------------
// | 比较日期差 dtEnd 格式为日期型或者 有效日期格式字符串
// +---------------------------------------------------
Date.prototype.datediff = function(strInterval, dtEnd) {
	var dtStart = this;
	if (typeof dtEnd == 'string')// 如果是字符串转换为日期型
	{
		dtEnd = StringToDate(dtEnd);
	}
	switch (strInterval) {
	case 's':
		return parseInt((dtEnd - dtStart) / 1000);
	case 'n':
		return parseInt((dtEnd - dtStart) / 60000);
	case 'h':
		return parseInt((dtEnd - dtStart) / 3600000);
	case 'd':
		return parseInt((dtEnd - dtStart) / 86400000);
	case 'w':
		return parseInt((dtEnd - dtStart) / (86400000 * 7));
	case 'm':
		return (dtEnd.getMonth() + 1) + ((dtEnd.getFullYear() - dtStart.getFullYear()) * 12) - (dtStart.getMonth() + 1);
	case 'y':
		return dtEnd.getFullYear() - dtStart.getFullYear();
	}
};

//Array.prototype.remove = function(s) {
//	for ( var i = 0; i < this.length; i++) {
//		if (s == this[i])
//			this.splice(i, 1);
//	}
//};

// 图片及样式
var $_img = "";
var $_css = "";

// 用户相关key
$_user.key = {
	uid : "uid",
	pwd : "pwd",
	upwd : "upwd",
	lotyid:"lotyid",
	play_id:"play_id",
	realName : "realName",
	idCardNo : "idCardNo",
	mailAddr : "mailAddr",
	rid : "rid",// 问题编号
	aid : "aid",// 答案
	tid : "tid",// 交易
	gid : "gid",// 彩种
	gender : "gender",// 性别
	provid : "provid",// 省份
	cityid : "cityid",// 城市
	imNo : "imNo",// 即时通信
	mobileNo : "mobileNo",// 电话号码
	stime : "stime",// 开始时间
	etime : "etime",// 结束时间
	newValue : "newValue",// 新的值
	bankCode : "bankCode",// 银行代码
	bankCard : "bankCard",// 银行卡号
	bankName : "bankName",// 银行名称
	pn : "pn",// 页码
	ps : "ps",// 页面大小
	tp : "tp",// 总页数
	tr : "tr",// 总记录数
	tkMoney:"tkMoney", //提款金额
	qtype:"qtype"
};

// 用户相关url配置
$_user.url = {	
	myfollow : "/user_auto_order/query/myfollow/",// 自动跟单
	followme : "/user_auto_order/query/followme/",// 跟我的跟单
	followhist : "/user_auto_order/query/followhist/",// 跟单记录
	followhistone : "/user/query.go?flag=22"// 查询单笔跟单记录

};

// 用户修改配置
$_user.modify = {
	autostate : "/user_auto_order/modify/changestat/" // 自动跟单状态
		
};

//页面导航
$_user.daohang = {
	addmoney : "/useraccount/?url=/useraccount/addmoney/add.html", // 充值
	touzhulist : "/useraccount/?url=/useraccount/usertouzhu/touzhu.html", // 投注记录
	zhanghulist : "/useraccount/?url=/useraccount/userpaylog/particular.html" // 账户明细
};


//交易相关key
$_trade.key = {
	gid : "gid", // 彩种
	pid : "pid",//期次编号
	hid : "hid",//合买编号
	bid : "bid",//认购编号
	zid : "zid",//追号编号
	did : "did"//明细编号
	
};

$_trade.url = {
	pcast : "/trade/pcast.go",// 发起方案
	jcast : "/trade/jcast.go",// 竞技彩发起方案
	pjoin:"/trade/pjoin.go",//参与方案
	pcancel:"/trade/pcancel.go",//发起人撤单
	pshbd:"/trade/pshbd.go",//发起人事后保底
	pb2g:"/trade/pb2g.go",//保底转认购
	jcancel:"/trade/jcancel.go",//认购撤销	
	zcast: "/trade/zcast.go",//发起追号
	zcancel: "/trade/zcancel.go",//追号撤销
	plist:"/trade/plist.go",//方案列表
	hlist:"/trade/hlist.go",//热门方案列表
	ulist:"/trade/ulist.go",//合买名人列表
	pinfo:"/trade/pinfo.go",//查询方案信息
	jlist:"/trade/jlist.go",//查询方案合买信息
	ai:"/trade/ai.go",//中奖明细
	
	saleperiod : "/trade/s.go",// 追号用期次列表
	cacheperiod : "/trade/c.go",// 合买用缓存期次列表 
	cachematch : "/trade/m.go",// 对阵列表   1 胜平负任九 2 进球彩 3 半全场 4北单 5竟彩足球 6竟彩蓝球	
	qcode:"/trade/qcode.go",//查询开奖号码
	qmoney:"/trade/qmoney.go",//查询开奖公告	
	qtoday:"/trade/qtoday.go",//查询今天开奖	
	
	tquery:"/trade/tquery.go",//查询列表
	
	systime : "/trade/time.go",// 获取服务器时间	
	filecast:"/filecast.go"//单式文本发起方案	
};

$_sys.base={
	kfdh:"400-673-9188",
	zhmx:"说明：<SPAN class=gray>&nbsp;&nbsp;&nbsp;1.您可以查询您的账户最近3个月内的账户明细。<BR>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2.如果您添加了预付款，银行账户钱扣了，网站账户还没有加上，请及时与我们联系，我们将第一时间为您处理！<BR>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3.如需要查询全部明细，请联系网站客服：400-673-9188。</SPAN>"
};

$_sys.url = {
	viewpath : "/jczq/viewdetail/", //		
	hmlist : "/hemai/project_list.html" //		
};

$_sys.autobuy = function (lotid,uid){
	 Y.postMsg('msg_login',function(){
         Y.openUrl('/main/autobuy.html?lotid='+lotid+'&owner='+uid,475,404);
	 });	
};



$_sys.showcode = function (lotid,ccodes){
	var html="";
	var codes = ccodes.split(";");
	for ( var i = 0; i < codes.length; i++) {
		if(lotid==90 ||lotid==91 ||lotid==92 ||lotid==93 || lotid==85 ||lotid==86 ||lotid==87 ||lotid==88 ||lotid==89){
			tmpCode = codes[i].split("|");
			html += '[' + $_sys.getplayname(lotid, lotid, lotid) + ']|' + tmpCode[1]+'|'+tmpCode[2].replaceAll("\\*","串");
		}else{
			tmpCode = codes[i].split(":");
			pm = tmpCode[1];
			cm = tmpCode[2];
			if (lotid=="04"){
				html += '[' + $_sys.getplayname(lotid, pm, cm) + ']';
				if(Y.getInt(pm)==6){
					//大小单双：大用2 表示,小用1 表示,单用5 表示,双用4 表示
					var tc = tmpCode[0].split(",");
					for(var ii=0; ii<tc.length; ii++){
						html +=tc[ii].replace("2","大").replace("1","小").replace("5","单").replace("4","双")+" ";
					}
				}else{
					html +=tmpCode[0];
				}
			}else if (lotid=="20"){
				html += '[' + $_sys.getplayname(lotid, pm, cm) + ']';
				if(Y.getInt(pm)==11){
					//大小单双：大用2 表示,小用1 表示,单用5 表示,双用4 表示
					var tc = tmpCode[0].split(",");
					for(var ii=0; ii<tc.length; ii++){
						html +=tc[ii].replace("2","大").replace("1","小").replace("5","单").replace("4","双")+" ";
					}
				}else{
					html +=tmpCode[0];
				}
			}else if (lotid=="54" || lotid=="55" || lotid=="03" || lotid=="53"){
				html += '[' + $_sys.getplayname(lotid, pm, cm) + ']' + tmpCode[0];
			}else{
				html += tmpCode[0];
			}
		}	
		if (i != codes.length - 1) {
			html += '<br/>';
		}
	}
	return html;
};

$_sys.showzhanjii = function (lotid,uid,au,ag,func){
    //	/trade/main/viewjp.html?lotid=01&uid=abcd&func=award     jp
	if (typeof(func)=='undefined'){
		func='';
	}
	return uid=='******'?$_sys.showzhanji(au,ag):('<a href="javascript: void 0" onclick="Y.openUrl(\'/main/viewjp.html?lotid='+lotid+'&uid='+uid+'&func='+func+'\',477,465)">'+$_sys.showzhanji(au,ag)+'</a>');
};

$_sys.showzhanjiname = function (lotid,uid,func){
    //	/trade/main/viewjp.html?lotid=01&uid=abcd&func=award     jp
	if (typeof(func)=='undefined'){
		func='';
	}
	return '<a href="javascript: void 0" onclick="Y.openUrl(\'/main/viewjp.html?lotid='+lotid+'&uid='+uid+'&func='+func+'\',477,465)">'+uid+'</a>';
};

$_sys.showzhanji= function(au,ag){
	var html="";
	 var yb='<img src="/img/public/zhanji/jin_yb_$1.gif" border="0" />';//金元宝
	 var zhuan='<img src="/img/public/zhanji/jin_zhuan_$1.gif" border="0" />';//金砖
	 var zuan='<img src="/img/public/zhanji/jin_zuan_$1.gif" border="0" />';//金钻 
	 if (Math.floor(au / 100) > 0){//如果有金钻
		 html+=zuan.replace('$1', Math.floor(au/100));//金钻个数
		 var a=au % 100;//金钻后的余数
		 if (a >0){
			 if (Math.floor(a/10)>0){//余数后可以有砖
				 html+=zhuan.replace('$1', Math.floor(a/10));			 
				 var b= a % 10;
				 if (b>0){
					 html+=yb.replace('$1',b);
				 }
			 }else{
				 html+=yb.replace('$1', a);
			 }
		 }	 
	 }else if (Math.floor(au/10) >0){
		 html+=zhuan.replace('$1', Math.floor(au/10));		 
		 var a= au % 10;
		 if (a>0){
			 html+=yb.replace('$1',a);
		 }	
	 }else if (au >0){	
			html+=yb.replace('$1', au);	
	 }
	 return html;
};



$_sys.lot = [];

$_sys.lot.push([1, "竞彩足球-让球胜平负","jczq-logo" ,1]);
$_sys.lot.push([2, "竞彩足球-总进球数","jczq-logo" ,1]);
$_sys.lot.push([3, "竞彩足球-比分","jczq-logo" ,1]);
$_sys.lot.push([4, "竞彩足球-半全场","jczq-logo",1]);

$_sys.lot.push([1, "竞彩蓝球-胜负","jclq-logo" ,6]);
$_sys.lot.push([2, "竞彩蓝球-让分胜负","jclq-logo" ,6]);
$_sys.lot.push([3, "竞彩蓝球-胜分差","jclq-logo" ,6]);
$_sys.lot.push([4, "竞彩蓝球-大小分","jclq-logo",6]);

$_sys.lot.push([1, "足彩胜负-胜负彩","zcsf-logo" ,2]);
$_sys.lot.push([2, "足彩胜负-九场胜负彩","zcsf-logo" ,2]);
$_sys.lot.push([3, "足彩胜负-六场半全","zcsf-logo" ,2]);
$_sys.lot.push([4, "足彩胜负-进球彩","zcsf-logo",2]);



//$_sys.lot.push([501, "单场竞猜-胜平负","bjdc-logo" ,7]);
//$_sys.lot.push([502, "单场竞猜-上下盘","bjdc-logo" ,7]);
//$_sys.lot.push([503, "单场竞猜-进球数","bjdc-logo" ,7]);
//$_sys.lot.push([504, "单场竞猜-过关比分","bjdc-logo",7]);
//$_sys.lot.push([505, "单场竞猜-半全场","bjdc-logo",7]);

$_sys.lottype = [];

$_sys.lottype.push([ "竞彩足球", "jczq", "1,2,3,4" ,'1' ]);
$_sys.lottype.push([ "竞彩蓝球", "jclq", "1,2,3,4" ,'6' ]);
$_sys.lottype.push([ "足彩胜负", "zcsf", "1,2,3,4" ,'2' ]);
//$_sys.lottype.push([ "单场竞猜", "bjdc", "501,502,503,504,505" ,'7' ]);

$_sys.lottype.istype = function (lotid,type){
	for (var i=0;i<$_sys.lottype.length;i++){
		if ($_sys.lottype[i][1]==type){
			var tmp=$_sys.lottype[i][2].split(",");
			for(var i=0;i<tmp.length;i++){
				if (parseFloat(lotid)==parseFloat(tmp[i])){
					return true;
					break;
				}
			}
			break;
		}
	}
	return false;
};


$_sys.lotpath = [];
$_sys.lotpath.push([ 1, "/ssq/" ]);
$_sys.lotpath.push([ 3, "/3d/" ]);
$_sys.lotpath.push([ 4, "/ssc/" ]);
$_sys.lotpath.push([ 7, "/qlc/" ]);
$_sys.lotpath.push([ 20, "/jxssc/" ]);

$_sys.lotpath.push([ 50, "/dlt/" ]);
$_sys.lotpath.push([ 51, "/qxc/" ]);

$_sys.lotpath.push([ 52, "/p5/" ]);
$_sys.lotpath.push([ 53, "/p3/" ]); 
$_sys.lotpath.push([ 54, "/11x5/" ]);
$_sys.lotpath.push([ 55, "/gd11x5/" ]);

$_sys.lotpath.push([ 80, "/sfc/" ]);
$_sys.lotpath.push([ 81, "/r9/" ]);
$_sys.lotpath.push([ 82, "/jqc/" ]);
$_sys.lotpath.push([ 83, "/bqc/" ]);

$_sys.lotpath.push([ 85, "/bjdc/" ]);
$_sys.lotpath.push([ 86, "/bjdc/" ]);
$_sys.lotpath.push([ 87, "/bjdc/" ]);
$_sys.lotpath.push([ 88, "/bjdc/" ]);
$_sys.lotpath.push([ 89, "/bjdc/" ]);

$_sys.lotpath.push([ 90, "/jczq/" ]);
$_sys.lotpath.push([ 91, "/jczq/" ]);
$_sys.lotpath.push([ 92, "/jczq/" ]);
$_sys.lotpath.push([ 93, "/jczq/" ]);



$_sys.zhflag = [];
$_sys.zhflag.push([ "中奖后不停止" ]);// 0
$_sys.zhflag.push([ "中奖后停止" ]);// 1
$_sys.zhflag.push([ "中奖后盈利停止" ]);// 2

//0 未完成 1 已投注完成 2 中奖停止 3 用户手工停止 reason
$_sys.zhreason =[];
$_sys.zhreason.push(["未完成"]);
$_sys.zhreason.push(["已投注完成"]);
$_sys.zhreason.push(["中奖停止"]);
$_sys.zhreason.push(["用户手工停止"]);

//0 对所有人公开 1 截止后公开 2 对参与人员公开 3 截止后对参与人公开
$_sys.iopen=[];
$_sys.iopen.push(["对所有人公开"]);
$_sys.iopen.push(["截止后公开"]);
$_sys.iopen.push(["对参与人员公开"]);
$_sys.iopen.push(["截止后对参与人公开"]);

$_sys.getlotname = function(f,n) {
	if (typeof(n)=='undefined'){n=1;};
	for ( var i = 0; i < $_sys.lot.length; i++) {
		if ($_sys.lot[i][0] == f) {
			return $_sys.lot[i][n];
		}
	}
};

$_sys.getlotyname = function(l,p,n) {
	if (typeof(n)=='undefined'){n=1;};
	for ( var i = 0; i < $_sys.lot.length; i++) {
		if ($_sys.lot[i][0] == p&&$_sys.lot[i][3] == l) {
			return $_sys.lot[i][n];
		}
	}
};

$_sys.getViewPath = function(l) {
	for ( var i = 0; i < $_sys.lottype.length; i++) {
		if ($_sys.lottype[i][3] == l) {
			return $_sys.lottype[i][1];
		}
	}
};

$_sys.getlotid = function(f) {
	for ( var i = 0; i < $_sys.lot.length; i++) {
		if ($_sys.lot[i][1] == f) {
			return $_sys.lot[i][0];
		}
	}
};

$_sys.getlotpath = function(f,n) {
	if (typeof(n)=='undefined'){n=1;};
	for ( var i = 0; i < $_sys.lotpath.length; i++) {
		if ($_sys.lotpath[i][0] == Y.getInt(f)) {
			return $_sys.lotpath[i][n];
		}
	}
};

$_sys.showerr = function(desc){
	alert(desc);
	if (history.length == 0) {
		window.opener = '';
		window.close();
	} else {
		history.go(-1);
	}	
};

// 交易类型定义
$_sys.inm = [];
$_sys.inm.push([ 200, "用户充值" ]);
$_sys.inm.push([ 201, "代购中奖" ]);
$_sys.inm.push([ 202, "跟单中奖" ]);
$_sys.inm.push([ 203, "中奖提成" ]);
$_sys.inm.push([ 204, "追号中奖" ]);
$_sys.inm.push([ 210, "代购撤单返款" ]);
$_sys.inm.push([ 211, "认购撤单返款" ]);
$_sys.inm.push([ 212, "追号撤销返款" ]);
$_sys.inm.push([ 213, "提现撤销返款" ]);
$_sys.inm.push([ 215, "保底返款" ]);
$_sys.inm.push([ 216, "红包派送" ]);

$_sys.outm = [];
$_sys.outm.push([ 100, "代购" ]);
$_sys.outm.push([ 101, "认购" ]);
$_sys.outm.push([ 102, "追号" ]);
$_sys.outm.push([ 103, "保底认购" ]);
$_sys.outm.push([ 104, "提现" ]);
$_sys.outm.push([ 105, "保底冻结" ]);
$_sys.outm.push([ 99, "转账" ]);

$_sys.bar = [];
$_sys.bar.push([ 1, "xxx.9188.com" ]);
$_sys.bar.push([ 2, "0574.9188.com" ]);


$_sys.barbool = function(h) {
	for ( var i = 0; i < $_sys.bar.length; i++) {
		if ($_sys.bar[i][1] == h) {
			return true;
		}
	}
	return false;
};


$_sys.biztype = function(f) {
	if (f >= 200) {
		for ( var i = 0; i < $_sys.inm.length; i++) {
			if ($_sys.inm[i][0] == f) {
				return $_sys.inm[i][1];
			}
		}
	} else {
		for ( var i = 0; i < $_sys.outm.length; i++) {
			if ($_sys.outm[i][0] == f) {
				return $_sys.outm[i][1];
			}
		}
	}
	return "未定义";
};


$_sys.addmoneytype = [];
$_sys.addmoneytype.push([ 1, "快钱" ]);
$_sys.addmoneytype.push([ 2, "财付通" ]);
$_sys.addmoneytype.push([ 3, "支付宝" ]);
$_sys.addmoneytype.push([ 4, "百付宝" ]);
$_sys.addmoneytype.push([ 5, "手机充值卡" ]);
$_sys.addmoneytype.push([ 6, "银联手机支付" ]);

$_sys.getaddmoneyname=function(f){
	for ( var i = 0; i < $_sys.addmoneytype.length; i++) {
		if ($_sys.addmoneytype[i][0] == f) {
			return $_sys.addmoneytype[i][1];
		}
	}
};

$_sys.bankid_def = [];
$_sys.bankid_def.push([1,"快钱支付"]);
$_sys.bankid_def.push([3,"支付宝支付"]);
$_sys.bankid_def.push([5,"手机充值卡"]);
$_sys.bankid_def.push([6,"银联手机支付"]);
$_sys.bankid_def.push([99,"手工加款"]);
$_sys.bankid_def.push([998,"红包派送"]);
$_sys.bankid_def.push([999,"网吧充值"]);

$_sys.getbankid = function(f, n) {
	if (typeof (n) == 'undefined') {
		n = 1;
	};
	for ( var i = 0; i < $_sys.bankid_def.length; i++) {
		if ($_sys.bankid_def[i][0] == f) {
			return $_sys.bankid_def[i][n].split(",");
		}
	}
};


$_sys.showcmemo = function (ibiztype,cmemo){
	var memo={};	
	ibiztype=Y.getInt(ibiztype);
	var memoarr=cmemo.split('|');
	if (memoarr.length>1){	
		switch (ibiztype){					
		case 200:
			memo.title=$_sys.getaddmoneyname(memoarr[0])+'充值  订单号:' +memoarr[1];
			memo.href='<font style="color:blue">'+memo.title+'</font>';
			break;				
		case 100:
		case 101:
		case 103:
		case 105:
			memo.title=$_sys.getlotname(memoarr[0])+$_sys.biztype(ibiztype);
			memo.href='<a href="/main/viewpath.html?lotid='+memoarr[0]+'&projid='+memoarr[1]+'" target="_blank" >'+$_sys.getlotname(memoarr[0])+$_sys.biztype(ibiztype)+'</a>';
			break;
		case 201:		
		case 202:
		case 203:	
		case 210:
		case 211:	
		case 215:			
			memo.title=$_sys.getlotname(memoarr[0])+$_sys.biztype(ibiztype);
			memo.href='<a href="/main/viewpath.html?lotid='+memoarr[0]+'&projid='+memoarr[1]+'" target="_blank" >'+$_sys.getlotname(memoarr[0])+$_sys.biztype(ibiztype)+'</a>';
			break;				
		case 102:	
		case 212:
			memo.title=$_sys.getlotname(memoarr[0])+$_sys.biztype(ibiztype);
			memo.href='<a href="/useraccount/usertouzhu/xchase.html?tid='+memoarr[1]+'&lotid='+memoarr[0]+'"          >'+$_sys.getlotname(memoarr[0])+$_sys.biztype(ibiztype)+'</a>';
			break;	
		case 204:	
			memo.title=$_sys.getlotname(memoarr[0])+$_sys.biztype(ibiztype);
			memo.href='<a href="/useraccount/usertouzhu/xchase.html?tid='+memoarr[2]+'&lotid='+memoarr[0]+'"          >'+$_sys.getlotname(memoarr[0])+$_sys.biztype(ibiztype)+'</a>';
			break;			
		case 213:				
		default:
			break;
		}
	}
	return memo;
};


$_sys.castdef = [];
$_sys.castdef.push([ 1, "单式" ]);
$_sys.castdef.push([ 2, "复式" ]);
$_sys.castdef.push([ 3, "包号" ]);
$_sys.castdef.push([ 4, "和值" ]);
$_sys.castdef.push([ 5, "胆拖" ]);

$_sys.getcastdefname = function(f) {
	for ( var i = 0; i < $_sys.castdef.length; i++) {
		if ($_sys.castdef[i][0] == f) {
			return $_sys.castdef[i][1];
		}
	}
};

$_sys.getplayname = function(lotid, playid, castdef) {
	var s = "";	
	lotid=Y.getInt(lotid);
	playid=Y.getInt(playid);
	castdef=Y.getInt(castdef);
	switch (lotid) {
	case 85:
		s = "让球胜平负";
		break;
	case 86:
		s = "比分";
		break;
	case 87:
		s = "半全场";
		break;
	case 88:
		s = "上下单双";
		break;	
	case 89:
		s = "总进球数";
		break;			
	case 90:
		s = "让球胜平负";
		break;
	case 91:
		s = "比分";
		break;
	case 92:
		s = "半全场";
		break;
	case 93:
		s = "总进球数";
		break;
	case 4:
		switch (playid) {
		case 1:
			s = "五星";
			break;
		case 3:
			s = "三星";
			break;
		case 4:
			s = "两星";
			break;
		case 5:
			s = "一星";
			break;
		case 6:
			s = "大小单双";
			break;
		case 7:
			s = "二星组选";
			break;
		case 12:
			s = "五星通选";
			break;
		case 13:
			s = "五星复选";
			break;
		case 15:
			s = "三星复选";
			break;
		case 16:
			s = "两星复选";
			break;
		}
		break;
	case 20:
		switch (playid) {
		case 1:
			s = "一星";
			break;
		case 2:
			s = "二星";
			break;
		case 3:
			s = "三星";
			break;
		case 4:
			s = "四星";
			break;
		case 5:
			s = "五星";
			break;
		case 6:
			s = "二星组合";
			break;
		case 7:
			s = "三星组合";
			break;
		case 8:
			s = "四星组合";
			break;
		case 9:
			s = "五星组合";
			break;
		case 10:
			if(castdef=="1"){
				s = "二星组选单式";
			}else{
				s = "二星组选包号";
			}
			break;
		case 11:
			s = "大小单双";
			break;
		case 12:
			s = "五星通选";
			break;
		case 13:
			s = "任选一";
			break;
		case 14:
			s = "任选二";
			break;
		case 15:
			if(castdef=="1"){
				s = "三星组三单式";
			}else{
				s = "三星组三包号";
			}
			break;
		case 16:
			if(castdef=="1"){
				s = "三星组六单式";
			}else{
				s = "三星组六包号";
			}
			break;
		}
		break;
	case 3:
	case 53://castdef---playid
		switch (castdef) {
		case 1:
		case 2:
		case 3:
		case 5:
			if(playid=="1"){
				s = "直选";
			}else if(playid=="2"){
				s = "组三";
			}else{
				s = "组六";
			}
			break;
		case 4:
			if(playid=="1"){
				s = "直选和值";
			}else if(playid=="2"){
				s = "组三和值";
			}else{
				s = "组六和值";
			}
			break;
		}
		break;
	case 54:
	case 55:
		switch (playid) {
		case 1:
			s = "任选一";
			break;
		case 2:
			s = "任选二";
			break;
		case 3:
			s = "任选三";
			break;
		case 4:
			s = "任选四";
			break;
		case 5:
			s = "任选五";
			break;
		case 6:
			s = "任选六";
			break;
		case 7:
			s = "任选七";
			break;
		case 8:
			s = "任选八";
			break;
		case 9:
			s = "前二直选";
			break;
		case 10:
			s = "前三直选";
			break;
		case 11:
			s = "前二组选";
			break;
		case 12:
			s = "前三组选";
			break;
		}
		break;
	}
	return s;
};

$_cache.qcode = function(gid, pid) {
	var cawardcode = "";
	var data = $_trade.key.gid + "=" + encodeURIComponent(gid) + "&" + $_trade.key.pid + "=" + encodeURIComponent(pid) + "&rnd=" + Math.random();
	$.ajax({
		url : $_trade.url.qcode,
		type : "POST",
		dataType : "xml",
		data : data,
		success : function(xml) {
			var R = $(xml).find("Resp");
			var code = R.attr("code");
			var desc = R.attr("desc");
			if (code == "0") {
				var r = R.find("row");
				cawardcode = r.attr("cawardcode");
				$("#"+gid+"_"+pid+"cawardcode").html(cawardcode);
			} else {
			}
		},
		error : function() {
		}
	});
	return cawardcode;
};

//合作网站白名单
$_sys.hezuolist = [];
$_sys.hezuolist.push([ "hao123.com", "hao123" ]);
$_sys.hezuolist.push([ "rising.cn", "rising" ]);
$_sys.hezuolist.push([ "726.com", "726" ]);
$_sys.hezuolist.push([ "baidu.com", "baidu" ]);
$_sys.hezuolist.push([ "google.com.hk", "google" ]);
$_sys.hezuolist.push([ "youdao.com", "youdao" ]);
$_sys.hezuolist.push([ "soso.com", "soso" ]);
$_sys.hezuolist.push([ "sogou.com", "sogou" ]);
$_sys.hezuolist.push([ "bing.com", "bing" ]);
$_sys.hezuolist.push([ "2345.com", "2345" ]);
$_sys.hezuolist.push([ "titan24.com", "000888" ]);

$_sys.gethezuolistname = function(f) {
	for ( var i = 0; i < $_sys.hezuolist.length; i++) {
		if ($_sys.hezuolist[i][0] == f) {
			return $_sys.hezuolist[i][1];
		}
	}
};

$_sys.getURLdomain = function(f) {
	var s = f.indexOf("//") + 1;
	f = f.substring(s + 1, f.length);
	s = f.indexOf("/");
	f = f.substring(0, s);
	return f;
};

$_sys.getFirstdomain = function(f) {
	var s = f.lastIndexOf(".");
	var last = f.substring(s + 1, f.length);
	f = f.substring(0, s);
	s = f.lastIndexOf(".");
	var b = f.substring(s + 1, f.length);
	return b + "." + last;
};

jQuery.cookie = function(name, value, options) {
	if (typeof value != 'undefined') { // name and value given, set cookie
		options = options || {};
		if (value === null) {
			value = '';
			options.expires = -1;
		}
		var expires = '';
		if (options.expires
				&& (typeof options.expires == 'number' || options.expires.toUTCString)) {
			var date;
			if (typeof options.expires == 'number') {
				date = new Date();
				date.setTime(date.getTime()
						+ (options.expires * 24 * 60 * 60 * 1000));
			} else {
				date = options.expires;
			}
			expires = '; expires=' + date.toUTCString(); // use expires
															// attribute,
															// max-age is not
															// supported by IE
		}
		var path = options.path ? '; path=' + options.path : '';
		var domain = options.domain ? '; domain=' + options.domain : '';
		var secure = options.secure ? '; secure' : '';
		document.cookie = [ name, '=', encodeURIComponent(value), expires,
				path, domain, secure ].join('');
	} else { // only name given, get cookie
		var cookieValue = null;
		if (document.cookie && document.cookie != '') {
			var cookies = document.cookie.split(';');
			for ( var i = 0; i < cookies.length; i++) {
				var cookie = jQuery.trim(cookies[i]);
				// Does this cookie string begin with the name we want?
				if (cookie.substring(0, name.length + 1) == (name + '=')) {
					cookieValue = decodeURIComponent(cookie
							.substring(name.length + 1));
					break;
				}
			}
		}
		return cookieValue;
	}
};
function getcookie(name) {
	var cookie_start = document.cookie.indexOf(name);
	var cookie_end = document.cookie.indexOf(";", cookie_start);
	return cookie_start == -1 ? '' : unescape(document.cookie.substring(
			cookie_start + name.length + 1,
			(cookie_end > cookie_start ? cookie_end : document.cookie.length)));
}

function setcookie(cookieName, cookieValue, seconds, path, domain, secure) {
	var expires = new Date();
	expires.setTime(expires.getTime() + seconds);
	document.cookie = escape(cookieName) + '=' + escape(cookieValue)
			+ (expires ? '; expires=' + expires.toGMTString() : '')
			+ (path ? '; path=' + path : '/')
			+ (domain ? '; domain=' + domain : '') + (secure ? '; secure' : '');
}

//提供方便方法操作cookie :
//	$.cookie('the_cookie'); // 获得cookie
//	$.cookie('the_cookie', 'the_value'); // 设置cookie
//	$.cookie('the_cookie', 'the_value', { expires: 7 }); //设置带时间的cookie  7天
//	$.cookie('the_cookie', '', { expires: -1 }); // 删除
//	$.cookie('the_cookie', null); // 删除 cookie
//
//	设置cookie的名值对，有效期，路径，域，安全
//	$.cookie(’name’, ‘value’, {expires: 7, path: ‘/’, domain: ‘jquery.com’, secure: true});

//var s = $_sys.getFirstdomain($_sys.getURLdomain("http://s.9188.com/index.html"));
var s = $_sys.getFirstdomain($_sys.getURLdomain(document.referrer));
var b = $_sys.gethezuolistname(s);
if (b!=undefined){
	$.cookie("regfrom", b, {expires: 7, path: "/", domain: "9188.com", secure: false});
	//setcookie("regfrom",b,7*24*60*60*1000,"/","9188.com",true)
}
