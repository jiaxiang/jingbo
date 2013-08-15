//获取期号
var issue_url = "/lotteryapi/sdata/lotissue?lottid=11";
var fq_url = "/lotteryapi/orderprocess/ordersub?lottid=11";
//开奖公告
var kjgg_url = "/lotteryapi/sdata/lotnotice?lottid=11";
//号码对象
var dssc_url = "/lotteryapi/orderprocess/order_fqds";
var fa_title = "大奖神马都不是浮云，只要有你参与！";
var fa_ms = "说点什么吧，让您的方案被更多彩民认可．．．";
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

//Ajax
$(function(){
	//获取期号
	var issueParam = "";
	ajax(issueParam,issue_url,issue_success,errorCallBack);	
		//开奖公告
	var kjggParam = "";
	ajax(kjggParam,kjgg_url,kjgg_success,errorCallBack);

});
//开奖公告
function kjgg_success(data){
	var tbody = $("<tbody>");
	$.each(data, function(index, item){


		var awardnum = item.awardnum.split(',');//开奖号码
		//var acc = item.acc; //滚存
		var issue = item.issue;

		if(index==0){
		
			$("#kj_opcode >span >b").each(function(i){$(this).html(awardnum[i]);});
			//$("#kj_opcode").nextAll("dd").children("em").html(tofloat(acc,2));//滚存
			$("#kj_opcode").prev().children().html("第"+issue+"期开奖号码：");
		}else{

			var red_num = item.awardnum.replace(RegExp(',', "g")," ");
			var tr = $("<tr>");
			var tds = "";// 定义添加的列
			tds +="<td class='tc'>"+issue+"</td>";
			tds +="<td class='tc'><span style='display: inline-block; color: red'>" +
					""+red_num+"</span></td>";
			var $tds = $(tds);
			$tds.appendTo(tr);
			tr.appendTo(tbody);
		}
	});
	tbody.appendTo(".zj_table");
}

function issue_success(data){
	var issueArr = new Array(3);
	var etimeArr = new Array(3);
	var flag = 0;
	$.each(data, function(index, item) {

		var isnow = item.isnow;
		var allowbuy = item.allowbuy;

		if(isnow == 1 && allowbuy==1){
			issueArr[0] = item.lotissue;
			etimeArr[0] = item.etime;flag+=1;
			return true;
		}
		if(isnow !=1 && allowbuy==1){
			if(issueArr[1]=="" || issueArr[1]==undefined){
				issueArr[1] = item.lotissue;
				etimeArr[1] = item.etime;flag+=1;
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
			$('#expect').val(issueArr[0]);
			a_.text("当前期"+issueArr[0]+"期").attr("class","on");
		}else{
			if(issueArr[index]!=undefined){ 
				a_.text("预售期"+issueArr[index]+"期").removeAttr("class","on");
			}
		}
		$("#expect_tab").append(a_);
		if(index<flag-1){
			$("#expect_tab").append(';');
		}
		//$("#expect_tab >a:eq("+index+")").attr("id",issueArr[index]).attr("etime",etimeArr[index]).html(issueStr+issueArr[index]+"期");
	});
	var endTime = $("#expect_tab >a").filter(".on").attr("etime");
	$("#endTimeSpan").html(endTime);
}
function errorCallBack(){
	
}

/*
和值映射表, 组三组六合并和值
--------------------------------------------------------------------------------------------*/
Class.C('zxhzQuery', {1:1,2:2,3:2,4:4,5:5,6:6,7:8,8:10,9:11,10:13,11:14,12:14,13:15,14:15,15:14,16:14,17:13,18:11,19:10,20:8,21:6,22:5,23:4,24:2,25:2,26:1});
Class.config('hzQuery',{
    "z3" : Class.C('zxhzQuery'),
    "z6" : Class.C('zxhzQuery'),
    "zhx" : {0:1,1:3,2:6,3:10,4:15,5:21,6:28,7:36,8:45,9:55,10:63,11:69,12:73,13:75,14:75,15:73,16:69,17:63,18:55,19:45,20:36,21:28,22:21,23:15,24:10,25:6,26:3,27:1},
    "z3kd" : {1:18,2:16,3:14,4:12,5:10,6:8,7:6,8:4,9:2},
    "z6kd" : {2:8,3:14,4:18,5:20,6:20,7:18,8:14,9:8},
    "zhxkd" : {0:10,1:54,2:96,3:126,4:144,5:150,6:144,7:126,8:96,9:54}
});
Class.extend('checkSingle', function (fn, otherInfo){
    var has = this.postMsg('msg_get_list_data').data;
    otherInfo = otherInfo || '';
    if (has && has.zhushu > 0) {
        this.confirm('您好, '+otherInfo+'您确定清除以前的投注吗?', function (){
             fn.call(this)
        })
    }else{
        fn.call(this, true);
    }
});
/*
组6组3直选
*/

Class('Choose_base>Z6Choose',{
    showTxt: '【您选择了<b class="red"> {$zhushu} </b>注，共<b class="red"> {$totalmoney} 元</b> 】',
    rndtpl: '<li><span class="blue">{1}</span></li>',
    index:function (ini){
        var hoverCss, focusCss, Y, showbar, startNum;
        Y = this;
        hoverCss = 'o-a';
        focusCss = 'o-b';
        this.balls = [];
        this.addNoop('onchange');
        showbar = this.get(ini.showbar);
        startNum = ini.startNum || 0;
        this.ball = new this.lib.Choose({
            items: ini.balls,
            startNum: startNum,
            focusCss: focusCss,
            hoverCss: hoverCss
        });
       this.ball.onchange = _change;
        this.bindEvent(ini);
        this.base(ini);
        function _change(){
            var zs, info;
            zs = Y.getCount();
            info = {
                zhushu: zs,
                totalmoney: (zs*Class.config('price')).rmb()            
            };
            Y.highlightBtn(zs);
            if (showbar) {// 刷新显示板
                showbar.html(Y.showTxt.tpl(info, '0'))
            }
            Y.onchange(info)
        }
    },
    getCount: function (){
        return Class.config('play_name2') == 'z6' ? Math.c(this.ball.data.length, 3) : Math.c(this.ball.data.length, 2)*2
    },
    getType: function (){
       return Class.config('play_name2') 
    },
    bindEvent: function (ini){
        var rnd, opts, all_rnd_sel, Y;
        Y = this;
        //输出按扭
        Y.need(ini.putBtn).click(function (){
            var code, mincode;
            if (Y.getCount()>0) {
                Y.chkLimitCode(Y.ball.data.join(','), function (){
                    if (Y.Type == 'Z6Choose') {//放开只许投一注
                            code = Y.getChooseCode();
                            Y.postMsg('msg_put_code', code);//广播号码输出消息, 列表框应该监听此消息                           
                    }else{//子类如跨度
                        Y.checkSingle(function (){
                            code = Y.getChooseCode();
                            this.postMsg('msg_clear_code');
                            Y.postMsg('msg_put_code', code);//广播号码输出消息, 列表框应该监听此消息                           
                        })                           
                    }                
                })
            }else{
                mincode = Class.C('play_name') == 'kd' ? 1 : (Y.getType()=='z6' || Class.C('play_name')=='zh' ? 3 :  2);
                Y.postMsg('msg_show_dlg', '请您至少选择'+mincode+'个号码后再添加！')
            }            
        });
        // 随机选取
        if (ini.rndOpts) {
            this.rndOpts = opts = this.need(ini.rndOpts);
            Y.need(ini.rnd).click(function (){
                Y.random(opts.val());
                return false
            });            
        }
       // 清除
        Y.get(ini.clearBtn).click(function (){
            Y.clearCode()
        }); 
    },
    getChooseCode: function (){
        var code = [[this.ball.data.slice(), this.getCount()]];
        this.clearCode();
        return code
    },
    clearCode: function (){
        this.ball.clearCode(true)
    },
    random: function (n){// 随机生成号码, [[red],[blue]]
        var a, b, code, id, len, zs, type;
        n = ~~n;
        code = [];
        b = this.repeat(10);
        type = Class.C('play_name2');
        len = type == 'z3' ? 2 : 3;//组三是两个号码
        zs = len == 3 ? 1 : 2;// 组三是两注
        zs = Class.C('play_name') == 'zh' ? 6 : zs;//组合玩法是6注
        for (var i = n; i--;) {
            code[i] = [b.random(-len).sort(Array.up), zs]
        }
        id = this.msgId;
        this.postMsg('msg_show_jx', code, function (e, btn){
              if (btn.id == 'jx_dlg_re') {
                    this.postMsg('msg_rnd_code')
               }else if(btn.id == 'jx_dlg_ok'){
                    this.postMsg('msg_put_code', code);//广播号码输出消息, 号码列表监听此消息    
               }
        }, this.rndtpl, true)                
    },
    redrawCode: function (code){//重现号码
        this.clearCode();
        this.ball.importCode(code[0]);
    }
});
/*
跨度选号
*/
Class('Z6Choose>KdChoose',{
    getCount: function (){
        var type, sum, map;
        type = Class.config('play_name2');
        map = Class.C('hzQuery')[type+'kd'];
        return this.ball.data.reduce(function (a, b){
            return a + map[b]
        }, 0)
    }
});
/*
组合选号
*/
Class('Z6Choose>ZuHeChoose',{
    getCount: function (){
        return Math.p(this.ball.data.length, 3)
    }
});
/*
和值
*/
Class('Choose_base>HzChoose', {
    showTxt: '【您选择了<b class="red"> {$zhushu} </b>注，共<b class="red"> {$totalmoney} 元</b> 】',
    rndtpl: '<li><span class="blue">{1}</span></li>',
    index:function (ini){
        var hoverCss, focusCss, Y, showbar;
        Y = this;
        hoverCss = 'o-a';
        focusCss = 'o-b';
        this.addNoop('onchange');
        showbar = this.get(ini.showbar);
        this.ball = new this.lib.Choose({
            items: ini.items,
            startNum: ini.startNum,
            focusCss: focusCss,
            hoverCss: hoverCss
        });
        this.ball.onchange = _change;
        this.bindEvent(ini);
        this.base(ini);
        function _change(){
            var zs, info;
            zs = Y.getCount();
            info = {
                zhushu: zs,
                totalmoney: (zs*Class.config('price')).rmb()            
            };
            Y.highlightBtn(zs);
            if (showbar) {// 刷新显示板
                showbar.html(Y.showTxt.tpl(info, '0'))
            }
            Y.onchange(info)
        }
    },
    getCount: function (){
        var map, zs, type;
        type = Class.C('play_name2');
        map = Class.C('hzQuery')[type];
        zs = 0;
        this.ball.data.each(function (item, n){
            zs += map[item]
        });
        return zs
    },
    bindEvent: function (ini){
        var Y = this;
        //输出按扭
        Y.need(ini.putBtn).click(function (){
            var code;
            if (Class.config('play_name2') == 'zhx') {
                if (Y.ball.data.length == 1 && (Y.ball.data[0]==0 || Y.ball.data[0]==27)) {
                    return Y.postMsg('msg_show_dlg', '您好, 不能只单选0或只单选27进行投注，请您修改您的投注号码！');
                }                
            }else{
                if (Y.ball.data.length == 1 && (Y.ball.data[0]==1 || Y.ball.data[0]==26)) {
                    return Y.postMsg('msg_show_dlg', '您好, 不能只单选1或只单选26进行投注，请您修改您的投注号码！');
                }                     
            }
            if (Y.getCount()>0) {
                Y.chkLimitCode(Y.getChkCode(), function (){
                    Y.checkSingle(function (){
                        code = Y.getChooseCode();
                        this.postMsg('msg_clear_code');
                        Y.postMsg('msg_put_code', code);//广播号码输出消息, 列表框应该监听此消息                           
                    })              
                })
            }else{
                Y.postMsg('msg_show_dlg', '请您至少选择一注号码后再添加！')
            }            
        });
        Y.need(ini.clear).click(function (){
            Y.clearCode()
        })
    },
    getChooseCode: function (){
        var code = [[this.ball.data.slice(), this.getCount()]];
        this.clearCode();
        return code
    },
    getChkCode: function (){
        return this.ball.data.join(',')
    },
    clearCode: function (){
        this.ball.clearCode()
    },
    redrawCode: function (code){//重现号码
        this.clearCode();
        this.ball.importCode(code[0]);
    }  
});
/*
号码框
*/
Class('CodeList>SDCodeList', {
    noZero: true,
    lineTpl: '<span class="num" style="color:#333">{1} {2}</span><a href="javascript:void 0" class="del">删除</a>',
    createLine: function (code){//创建一行
        var type, fs;
        var text = this.getPlay();
        switch(this.getType()){
            case 'zhx':
                fs = code[0].length > 1 || code[1].length > 1 || code[2].length > 1 ;
                return this.createNode('LI', this.panel).html(this.lineTpl.format([code[0].join(''), code[1].join(''), code[2].join('')].join(','), text));
            case 'z6':
                return this.createNode('LI', this.panel).html(this.lineTpl.format(code.slice(0,-1).join(','), text));
            default:
                return this.createNode('LI', this.panel).html(this.lineTpl.format(code.slice(0,-1).join(','),  text));
        }
    },
    getType: function (){
       return Class.config('play_name2') 
    },
    formatCode: function (d){//用于投注参数
        return '{1}|{2}|{3}'.format(d[0].join(''), d[1].join(''), d[2].join(''))
    }
});
/*
和值号码框
*/
Class('CodeList>HzCodeList', { 
    noZero: true,
    lineTpl: '<span class="num" style="color:#333">{1} {2}</span><a href="javascript:void 0" class="del">删除</a>',
    createLine: function (code){//创建一行
        return this.createNode('LI', this.panel).html(this.lineTpl.format(code[0].join(','), this.getPlay()));
    },
    formatCode: function (d){//用于投注参数
        return '{1}'.format(d[0].join(','))
    }
});
/*
组六组三普通号码框
*/
Class('CodeList>Z6CodeList', {
    noZero: true,
    lineTpl: '<span class="num" style="color:#333">{1} {2}</span> {3}<a href="javascript:void 0" class="del">删除</a>',
    createLine: function (code){//创建一行
        return this.createNode('LI', this.panel).html(this.lineTpl.format(code[0].join(','), this.getPlay()));
    },
    getType: function (){
       return Class.config('play_name2') 
    },
    formatCode: function (d){//用于投注参数
        return '{1}'.format(d[0].join(','))
    }
});
/*
跨度号码框
*/
Class('Z6CodeList>KdCodeList', {
    createLine: function (code){//创建一行
        var t, t2;
        t = this.getType();
        t2 = Class.C('play_name');
        return this.createNode('LI', this.panel).html(this.lineTpl.format(code[0].join(','), this.getPlay()));
    }
});
/*
胆拖
*/
Class('Choose_base>Choose_dt', {
    statusTpl: '【您选择了<b class="red"> {$zhushu} </b>注，共<b class="red"> {$m} 元</b> 】',
    minNum: 4,
    maxDan: 2,
    index:function (ini){
        this.bindDom(ini);
        this.base(ini);
        this.getChooseCode = this.getCount;
    },
    bindDom: function (ini){
       var Y = this;
        hoverCss = 'o-a';
        focusCss = 'o-b';
        //选号
        this.dan = this.lib.Choose({
            items: ini.dan,
            focusCss: focusCss,
            hoverCss: hoverCss,
            startNum: 0
        });
        this.tuo = this.lib.Choose({
            items: ini.tuo,
            focusCss: focusCss,
            hoverCss: hoverCss,
            startNum: 0
        });
        this.dan.onbeforeselect = function (ball){
           if (this.data.length > Y.maxDan -1) {
               this.postMsg('msg_show_dlg', '最多只能选择'+Y.maxDan+'个胆码！');
               return false
           }
           Y.tuo.unselect(Y.getInt(ball.innerHTML))//互斥
        };
        this.tuo.onbeforeselect = function (ball){
           if (this.data.length > 9) {
               this.postMsg('msg_show_dlg', '最多只能选择9个拖码！');
               return false
           }
           Y.dan.unselect(Y.getInt(ball.innerHTML))           
        };
        this.dan.onchange =
        this.tuo.onchange = function (){
            Y.change()
        }
        //清除
        this.get(ini.clearAll).click(function (e, Y){
            Y.clearCode();
        });
          //选定
         this.get(ini.putBtn).click(function (e, Y){
              var msg, data = Y.getCount();
              if (data.d < 1) {
                  msg = '至少要选取一个胆码！'
              }else if(data.t < 2){
                  msg = '拖码至少要有2个！'
              }else if(data.d + data.t < Y.minNum){
                  msg = '您好，胆码加拖码个数必须大于或者等于'+Y.minNum+'！'
              }
              if (msg) {
                  Y.postMsg('msg_show_dlg', msg)
              }else{
                 Y.chkLimitCode('[D:'+Y.dan.data+'][T:'+Y.tuo.data+']', function (){
                    Y.checkSingle(function (){
                        this.postMsg('msg_clear_code');
                        Y.postMsg('msg_put_code', data.code);//广播号码输出消息, 列表框应该监听此消息
                        Y.clearCode();                        
                    })
                 }) 
              }
          });
         this.statusbar = this.need(ini.showbar)
    },
    getCount: function (){
       var  d, t, b, zs;
       d = this.dan.data.length;
       t = this.tuo.data.length;
       zs = Math.dt(d, t, 3)*6*(d > 0 && (d + t) > 3 ? 1 : 0);//必须有胆码才计算注数
       return {
           code:[[this.dan.data.slice(),this.tuo.data.slice(), zs]],
           d:d,
           t:t,
           zhushu: zs
       }
    },
    clearCode: function (){
        this.dan.clearCode();
        this.tuo.clearCode()
    },
    change: function (){
        var data = this.getCount();
        this.zhushu = data.zhushu;
        data.m = (data.zhushu*Class.config('price')).rmb();
        this.highlightBtn(this.zhushu);
        this.statusbar.html(this.statusTpl.tpl(data))
    },
    redrawCode: function (code){//重现号码
        this.clearCode();
        this.dan.importCode(code[0]);
        this.tuo.importCode(code[1])
    },
    codeTpl:'<li style="height:auto;"><div>[<em class="red">胆</em>] <span class="num red">{1}</span></div>'+
        '<div>[<em class="green">拖</em>] <span class="num red">{2}</span></div></li>'
});
/*
组六胆拖
*/
Class('Choose_dt>Choose_Z6dt',{
    getCount: function (){
       var  d, t, b, zs;
       d = this.dan.data.length;
       t = this.tuo.data.length;
       zs = Math.dt(d, t, 3)*(d > 0 && (d + t) > 3 ? 1 : 0);//必须有胆码才计算注数
       return {
           code:[[this.dan.data.slice(),this.tuo.data.slice(), zs]],
           d:d,
           t:t,
           zhushu: zs
       }
    }
});
/*
组三胆拖
*/
Class('Choose_dt>Choose_Z3dt',{
    minNum: 3,
    maxDan: 1,
    getCount: function (){
       var  d, t, b, zs;
       d = this.dan.data.length;
       t = this.tuo.data.length;
       zs = Math.dt(d, t, 2)*2*(d > 0 && (d + t) > 2 ? 1 : 0);//必须有胆码才计算注数
       return {
           code:[[this.dan.data.slice(),this.tuo.data.slice(), zs]],
           d:d,
           t:t,
           zhushu: zs
       }
    }
});
/*
胆拖列表
*/
Class('CodeList>CodeList_dt', {
    noZero: true,
    liTpl:'<div>[<em class="red">胆</em>] <span class="">{1}</span></div>'+
        '<div><a title="" href="javascript:void 0" class="del">删除</a>[<em class="green">拖</em>] <span class="">{2}</span></div>',
    createLine: function (code){//创建一行
        return this.createNode('LI', this.panel).setStyle('height:42px').html(this.liTpl.format(code[0], code[1]));
    },
    formatCode: function (d){
        return '[D:{1}][T:{2}]'.format(d[0].join(','),d[1].join(','))
    }
});
/*
单式录入
*/
Class('CodeEditor>SDCodeEditor', {
    rndtpl: '<li><span class="blue">{1}</span> | <span class="blue">{2}</span> | <span class="blue">{3}</span></li>',
    getCode: function (){
        var codes, llines, val, msg, tmp, reg,c, ty;
        ty = this.getType();
        reg = this.getTester(ty);
        codes = [];
        val = this.editor.val().trim();
        if (val == '' || val == this.editor.one().defaultValue) {
            this.postMsg('msg_show_dlg','号码输入框不能为空');
        }else{
            lines = val.split('\n');
            if (lines.length > this.maxLine) {
                this.postMsg('msg_show_dlg','手动录入号码已超过'+this.maxLine+'行，请删除多余行或者选用txt文件上传！');
                return false
            }
            msg='';
            lines.each(function (a, b){
                var t = a.replace(/\s/g,''), _code;
                if(!reg.test(t)){
                    msg = '号码格式有误，请检查！';
                }else if(this.isReCode(t)){
                    msg = '号码中有重复数字，请检查！';
                }
                if(msg != ''){
                   this.postMsg('msg_show_dlg', "第"+(b+1)+"行"+msg, (function (){
                       this.editor.selectLine(b+1)
                   }).proxy(this));
                  return false;
                }
                c = t.indexOf(',') > -1 ? ',' : (t.indexOf(',') > -1 ? ',':'');
                tmp = t.split(c);
                switch(ty){
                    case 'zhx':
                        _code = [[tmp[0]], [tmp[1]], [tmp[2]], 1];
                        break;
                    case 'z3':
                    case 'z6':
                        tmp.sort(Array.up);
                        _code = [[tmp[0]], [tmp[1]], [tmp[2]], 1];
                }
                codes.push(_code)
           }, this);
           return msg ? false : codes
        }  
    },
    getChkCode: function (code){
        var s = this.getType() == 'zhx' ? ',' : ',';
        var cc=[];
        code.each(function (c){
            cc.push(c.slice(0,3).join(s))
        })
        return cc.join(';')
    },
    getType: function (){
       return Class.config('play_name2') 
    },
    getTester: function (ty){//匹配更多的动态项
        var reg = ty == 'zhx' ? /^\s*\d([\|,]?)\d\1\d\s*$/ : (ty == 'z6' ? /^(\s*\d[\|,]\d[\|,]\d\s*|\s*\d{3}\s*)$/ : /^(?:\d(\d)\1|(\d)\2\d|(\d)\d\3|\d[\|,](\d)[\|,]\4|(\d)[\|,]\5[\|,]\d|(\d)[\|,]\d[\|,]\6)$/);
        return reg
    },    
    isReCode: function (str){// 重复号码检查,只对组六
        var type, reg;
        type = this.getType();
        if (type != 'zhx') {
            reg = type == 'z6' ? /(\d)\1/ : /(\d)\1\1/;
            str = str.indexOf(',') > -1 ? str.split(',') : str.split('')
            return reg.test(str.sort(Array.up).join(''))
        }
        return false        
    },
    random: function (n){// 随机生成号码, [[red],[blue]]
        var a, b, code, ty, c;
        n = ~~n;
        code = [];
        a = this.repeat(10);
        ty = this.getType();
        for (var i = n; i--;) {
            switch(ty){
            case 'zhx':
                var r = parseInt(Math.random()*9), r1 = r+1;
                code[i] = [a.random(r, r1), a.random(r, r1), a.random(r, r1), 1];
                this.rndtpl= '<li><span class="blue">{1}</span> , <span class="blue">{2}</span> , <span class="blue">{3}</span></li>';
                break;
            case 'z6':
                c = a.random(-3).sort(Array.up);
                code[i] = [[c[0]], [c[1]], [c[2]], 1];
                this.rndtpl= '<li><span class="blue">{1}</span> , <span class="blue">{2}</span> , <span class="blue">{3}</span></li>';
                break;
            case 'z3':
                c = a.random(-2).sort(Array.up);
                code[i] = [[c[0]], [c[0]], [c[1]], 1];
                this.rndtpl= '<li><span class="blue">{1}</span> , <span class="blue">{2}</span> , <span class="blue">{3}</span></li>';
                break;
            }            
        }
        this.postMsg('msg_show_jx', code, function (e, btn){
              if (btn.id == 'jx_dlg_re') {
                    this.postMsg('msg_rnd_code')
               }else if(btn.id == 'jx_dlg_ok'){
                    this.postMsg('msg_put_code', code);//广播号码输出消息, 号码列表监听此消息    
               }
        }, this.rndtpl, true)                
    },
    redrawCode: function (code){//重现号码
        this.editor.val(code.slice(0,-1).join(','))
    }
});
/*
Main
*/
(function (){
    Class.config('price', 2);
    Class.config('play_name', 'pt');
    Class.config('play_name2', 'zhx');
    Class.config('buy_type', 0);
    Class.config('playid', 1);
    Class.config('root', 'http://'+location.host+'/');
    Class.config('fsfq', 'http://'+location.host+'/lotteryapi/orderprocess/ordersub');
    Class.config('dsfq', 'http://'+location.host+'/lotteryapi/orderprocess/ordersub');
    Class.config('pageParam',{});
    Class.config('userMoney', 0);
    Class.config('lower-limit', .1);//认购下限
    Class.config('lot-ch-name', '排列三');
    Class.config('play-ch-name', '复式投注');
    Class.config('page-config', {});//页面隐藏配置
   // Class.config('divExpect', [10125, 10130]);//追号期号标红
    Class.config('hasddsh', false);//是否定胆
    Class.config('last-ddsh', '-/-');
    Class.config('limit-code-url', '/check_code/limitcode');
    /*
    'pt,lr,hz' - 1
    'zhx,z6,z3' - 2
    */
    Class.extend('getPlay', function (){
        var map, map2;
        map = {
            'pt': '复式',
            'lr': '单式',
            'sc': '单式',
            'hz': '和值',
            'zxhz': '和值',
            'kd': '跨度',
            'zh': '组合',
            'dt':'胆拖',
            'zhdt': '组合胆拖',
            'dq': '多期机选'
        };
        map2 = {
            zhx: '直选',
            z6: '组六',
            z3: '组三'
        }
        var p1 = Class.C('play_name');
        var p2 = Class.C('play_name2');
        if ((p1 == 'lr' || p2 == 'sc') && p2 != 'zhx') {
            return '组选单式'
        }else{
            return map2[p2] + map[p1]
        }
    });
    Class.extend('getPlayText', function (play_name){
        return this.getPlay(play_name) //+ ['代购','合买','追号'][Class.C('buy_type')];
    });
    // 自动生成playid
    Class.extend('getPlayId', function (play_name){
        var pn, bt, pid,map;
        pn = Class.config('play_name');
        pn2 = Class.config('play_name2');
        bt = Class.config('buy_type');
        switch(pn2){
            case 'zhx':
                return {'pt':1, 'sc': 3, 'hz': 4, 'lr':1}[pn]
            case 'z6':
                return {'pt':5, 'sc': 6, 'zxhz': 7, 'dt':8, 'lr':5}[pn]
            case 'z3':
                return {'pt':9, 'sc': 10, 'zxhz': 11,'dt':12, 'lr':9}[pn]
        }
        return 1
    });
    Class.extend('exportCode', function (){
        // 传入号码9|8|8$2|5|7
        var import_code, arrCodes, short_code, pid = this.get('#playid2').val() || 1;
        var type = pid == 28 ? 'Z3' : ( pid == 29 ? 'Z6' : 'Zhx');
        if (import_code = Yobj.get('#codes').val()) {
			if (typeof this.dejson(import_code) == 'object') return;
            arrCodes = import_code.split(';').map(function (c){
                var w = c.split(','), q, b, g;
                switch(type){
                    case 'Z3':
                        return [w.sort(Array.up), Math.c(w.length, 2) * 2]
                        break;
                    case 'Z6':
                        return [w.sort(Array.up), Math.c(w.length, 3)]
                        break;
                    default:
                        q = w[0] ? w[0].split('') : [];
                        b = w[1] ? w[1].split('') : [];
                        g = w[2] ? w[2].split('') : [];
                        zs = q.length*b.length*g.length;                        
                }
                return [q.sort(Array.up), b.sort(Array.up), g.sort(Array.up), zs]
            }).filter(function (c){
                if (c[c.length - 1] == 0) {//zs
                    short_code = c//残缺号码
                }else{
                    return true
                }
            });
            Y.postMsg('msg_change_play', pid == 28 ? 2 : (pid == 29 ? 1 : 0));
            if (arrCodes.length) {//完整号码显示到列表
                 this.postMsg('msg_put_code_pt_'+type.toLowerCase(), arrCodes);
                 this.moveToBuy()
            }
            if (short_code && short_code.length) {// 残缺号码显示到球区
                this.postMsg('msg_redraw_code_pt_'+type.toLowerCase(), short_code)
            }
        }
    });
    /*
    begin
    */
    Class({
        use: 'tabs,dataInput,mask',
        ready: true,

        index:function (){
            this.Type = 'App_index';
            this.createTabs();
            this.createSub();
			
           /* this.lib.PLHotCoolChart({
                xml: '/static/info/pls/omit/wzyl_100.xml',
                hzXml: '/static//info/pls/omit/hzyl_hz_100.xml'
            });*/
            /*this.getTiDian({//提点与专家
                kj: '/static/info/kaijiang/xml/pls/index.xml',
                td1: '/static/info/pls/omit/remind.xml',
                //td2: '/static/public/pls/xml/yilou/yl_zuxuan.xml',
                td2: '/static/info/pls/omit/zxyl_all.xml',
                zj: '/static/info/szpl/news/szplzjtj/zhuanjia.xml'
            })*/
        },

        createSub: function (){
            var Y, choose_pt, list_pt, choose_dt, choose_dd, list_dd;
            Y = this;
            this.onMsg('msg_toggle_case', function (sender){
                 var a, b;
                 a = this.get('a', sender);
                 b = this.hasClass(a.nodes[0], 'p_hide');
                 a.html(b ? '显示方案' : '隐藏方案');
                 a.nodes[0].className = b ? 'p_show' : 'p_hide';
                 this.get('#case_list').hide( b);
            });

            this.onMsg('msg_get_list_data', function (){//自动匹配不同的号码列表进行消息转发
                var msg = Class.C('play_name') == 'lr' || Class.C('play_name') == 'sc' ? '' : '_'+Class.C('play_name2');//单式是共用的, 不再分发
                return this.postMsg('msg_get_list_data_'+Class.C('play_name')+msg).data;
            });

            this.onMsg('msg_put_code', function (code){//自动匹配不同的号码列表进行消息转发
                this.moveToBuy();
                var msg = Class.C('play_name') == 'lr' || Class.C('play_name') == 'sc' ? '' : '_'+Class.C('play_name2');
                return this.postMsg('msg_put_code_'+Class.C('play_name')+msg, code).data;
            });

            this.onMsg('msg_rnd_code', function (code){//自动匹配不同的号码列表进行消息转发
                var msg = Class.C('play_name') == 'lr' || Class.C('play_name') == 'sc' ? '' : '_'+Class.C('play_name2');
                return this.postMsg('msg_rnd_code_'+Class.C('play_name')+msg, code).data;
            });

            this.onMsg('msg_clear_code', function (code){//自动匹配不同的号码列表进行消息转发
                var msg = Class.C('play_name') == 'lr' || Class.C('play_name') == 'sc' ? '' : '_'+Class.C('play_name2');
                return this.postMsg('msg_clear_code_'+Class.C('play_name')+msg)
            });

            this.onMsg('msg_redraw_code', function (code){//自动匹配不同的选择器进行消息转发
                var msg = Class.C('play_name') == 'lr' || Class.C('play_name') == 'sc' ? '' : '_'+Class.C('play_name2');
                return this.postMsg('msg_redraw_code_'+Class.C('play_name')+msg, code)
            });

            this.onMsg('msg_list_change', function (data){//自动匹配不同的号码列表
                this.get('#buyMoneySpan').html(data.totalmoney.rmb());
                this.get('#buySYSpan').html(Math.max(0, Class.C('userMoney') - data.totalmoney).rmb() );                
            });
            this.onMsg('msg_auto_kill_num', function (auto){//自动杀号
                Class.C('auto-kill', auto)           
            });
            // 3d直选
            Y.lib.PLChoose({
                msgId: 'pt_zhx',
                balls: '#pttz ul.c-s-num',
                showbar: '#zhx_showbar',
                putBtn: '#zhx_pt_put',
                rndOpts:'#zhx_pt_jx_opts',
                clearBtn:'#zhx_pt_clear',
                rnd: '#zhx_pt_jx',
				ddRnd: '#zhx_dd_jx'
               /* yl:[{
                    width: 10,
                    xml: '/static/info/pls/omit/wzyl_all.xml',
                    dom: '#pttz ul i'
                }]*/
            });
            // 直选列表
            Y.lib.PLCodeList({
                msgId: 'pt_zhx',
                panel:'#zhx_pt_list',
                bsInput:'#zhx_pt_bs',
                moneySpan: '#zhx_pt_money',
                zsSpan: '#zhx_pt_zs',
                clearBtn: '#zhx_pt_list_clear'
            });

            Y.lib.Dlg();
            Y.lib.HmOptions();
            setTimeout(function() {
                Y.lib.BuySender();
                Y.exportCode()
            },500);            

            this.setBuyFlow()
        },
        createZhOptions: function (el){//延迟实现
           var Y = this;
           setTimeout(function() {
               Y.lib.ZhOptions()
           },99);           
           Y.createZhOptions = this.getNoop()
        },
        createDs: function (){
           Y.lib.SDCodeEditor({
                textarea: '#lr_editor',
                msgId: 'lr',
                lr_num: '#lr_num',
                putBtn:'#lr_put',
                clearBtn: '#lr_clear',
                rndSelect: '#lr_opts',
                rndBtn: '#lr_jx'
            });
            // 录入列表
            list_lr = Y.lib.SDCodeList({
                msgId: 'lr',
                panel:'#lr_list',
                bsInput:'#lr_bs',
                moneySpan: '#lr_money',
                zsSpan: '#lr_zs',
                clearBtn: '#lr_list_clear'
            });
            //单式上传
            var opts = {
                zsInput: '#sc_zs_input',
                bsInput: '#sc_bs_input',
                moneySpan: '#sc_money',
                scChk: '#scChk',
                upfile:'#upfile'
            };
            if (Yobj.C('isDsChk')) {
                Y.lib.DsChkUpload(opts);
            }else{
                Y.lib.DsUpload(opts);
            }  
            this.createDs = this.getNoop()
        },
        // 直选和值
        createZhHz: function (){
            // 3d和值
            Y.lib.HzChoose({
                msgId: 'hz_zhx',
                items: '#zhxhz li b',
                showbar: '#zhxhz_showbar',
                putBtn: '#zhxhz_put',
                clear: '#zhxhz_clear',
               /* yl:[{
                    xml: '/static/info/pls/omit/hzyl_hz_all.xml',
                    name:'curyl',
                    dom: '#zhxhz li.dqyl i'
                },{
                    xml: '/static/info/pls/omit/hzyl_hz_all.xml',
                    dom: '#zhxhz li.llyl i',
                    name: 'cycle'
                }],*/
                startNum: 0
            });
            // 和值列表
            Y.lib.HzCodeList({
                msgId: 'hz_zhx',
                panel:'#zhxhz_list',
                bsInput:'#zhxhz_bs',
                moneySpan: '#zhxhz_money',
                zsSpan: '#zhxhz_zs',
                clearBtn: '#zhxhz_list_clear'
            });
            this.createZhHz = this.getNoop()
        },

        createZ6: function (){
            // z6直选
            Y.lib.Z6Choose({
                msgId: 'pt_z6',
                balls: '#z6pt_ball b',
                showbar: '#z6pt_showbar',
                putBtn: '#z6pt_put',
                //rndOpts:'#z6pt_jx_opts',
                clearBtn:'#z6pt_clear',
                rnd: '#z6pt_jx'
            });
            // z6直选列表
            Y.lib.Z6CodeList({
                msgId: 'pt_z6',
                panel:'#z6pt_list',
                bsInput:'#z6pt_bs',
                moneySpan: '#z6pt_money',
                zsSpan: '#z6pt_zs',
                clearBtn: '#z6pt_list_clear'
            });
           this.createZ6 = this.getNoop() 
        },

        createZ6Hz: function (){
            // z6和值
            Y.lib.HzChoose({
                msgId: 'zxhz_z6',
                items: '#z6hz li b',
                showbar: '#z6hz_showbar',
                putBtn: '#z6hz_put',
                clear: '#z6hz_clear',
              /*  yl:[{
                    xml: '/static/info/pls/omit/hzyl_hz_all.xml',
                    dom: '#z6hz li.dqyl i',
                    //sort: 'hezhi',
                    offset: 1
                },{
                    xml: '/static/info/pls/omit/hzyl_hz_all.xml',
                    dom: '#z6hz li.llyl i',
                    offset: 1,
                    name: 'cycle'
                }],*/
                startNum: 3
            });
            // 和值列表
            Y.lib.HzCodeList({
                msgId: 'zxhz_z6',
                panel:'#z6hz_list',
                bsInput:'#z6hz_bs',
                moneySpan: '#z6hz_money',
                zsSpan: '#z6hz_zs',
                clearBtn: '#z6hz_list_clear'
            });
            this.createZ6Hz = this.getNoop()
        },

        createZ3: function (){
            // z3直选
            Y.lib.Z6Choose({
                msgId: 'pt_z3',
                balls: '#z3fs li b',
                showbar: '#z3pt_showbar',
                putBtn: '#z3pt_put',
                //rndOpts:'#z3pt_jx_opts',
                clearBtn:'#z3pt_clear',
                rnd: '#z3pt_jx'
            });
            // z3直选列表
            Y.lib.Z6CodeList({
                msgId: 'pt_z3',
                panel:'#z3pt_list',
                bsInput:'#z3pt_bs',
                moneySpan: '#z3pt_money',
                zsSpan: '#z3pt_zs',
                clearBtn: '#z3pt_list_clear'
            });
           this.createZ3 = this.getNoop() 
        },

        createZ3Hz: function (){
            // z3和值
            Y.lib.HzChoose({
                msgId: 'zxhz_z3',
                items: '#z3hz li b',
                showbar: '#z3hz_showbar',
                putBtn: '#z3hz_put',
                clear: '#z3hz_clear',
               /* yl:[{
                    xml: '/static/info/pls/omit/hzyl_hz_all.xml',
                    dom: '#z3hz li.dqyl i',
                    //sort: 'hezhi',
                    offset: 1
                },{
                    xml: '/static/info/pls/omit/hzyl_hz_all.xml',
                    dom: '#z3hz li.llyl i',
                    offset: 1,
                    name: 'cycle'
                }],*/
                startNum: 1
            });
            // 和值列表
            Y.lib.HzCodeList({
                msgId: 'zxhz_z3',
                panel:'#z3hz_list',
                bsInput:'#z3hz_bs',
                moneySpan: '#z3hz_money',
                zsSpan: '#z3hz_zs',
                clearBtn: '#z3hz_list_clear'
            });
            this.createZ3Hz = this.getNoop()
        },

        createZhxKd: function (){
            Y.lib.KdChoose({
                msgId: 'kd_zhx',
                balls: '#zhxkd li b',
                showbar: '#zhxkd_showbar',
                putBtn: '#zhxkd_put',
                clearBtn:'#zhxkd_clear',
                /*yl:[{
                    xml: '/static/info/pls/omit/kdyl_all.xml',
                    dom: '#zhxkd li i',
                    sort: 'kuadu'
                }],*/
                startNum: 0
            });
            Y.lib.KdCodeList({
                msgId: 'kd_zhx',
                panel:'#zhxkd_list',
                bsInput:'#zhxkd_bs',
                moneySpan: '#zhxkd_money',
                zsSpan: '#zhxkd_zs',
                clearBtn: '#zhxkd_list_clear'
            });
            this.createZhxKd = this.getNoop()
        },

        createZ6Kd: function (){
            Y.lib.KdChoose({
                msgId: 'kd_z6',
                balls: '#z6kd li b',
                showbar: '#z6kd_showbar',
                putBtn: '#z6kd_put',
                clearBtn:'#z6kd_clear',
               /* yl:[{
                    xml: '/static/public/pls/xml/yilou/yl_z6kuadu.xml',
                    dom: '#z6kd li i',
                    sort: 'kuadu'
                }],*/
                startNum: 2
            });
            Y.lib.KdCodeList({
                msgId: 'kd_z6',
                panel:'#z6kd_list',
                bsInput:'#z6kd_bs',
                moneySpan: '#z6kd_money',
                zsSpan: '#z6kd_zs',
                clearBtn: '#z6kd_list_clear'
            });
            this.createZ6Kd = this.getNoop()
        },

        createZ3Kd: function (){
            Y.lib.KdChoose({
                msgId: 'kd_z3',
                balls: '#z3kd li b',
                showbar: '#z3kd_showbar',
                putBtn: '#z3kd_put',
                clearBtn:'#z3kd_clear',
                /*yl:[{
                    xml: '/static/public/pls/xml/yilou/yl_z3kuadu.xml',
                    dom: '#z3kd li i',
                    sort: 'kuadu'
                }],*/
                startNum: 1
            });
            Y.lib.KdCodeList({
                msgId: 'kd_z3',
                panel:'#z3kd_list',
                bsInput:'#z3kd_bs',
                moneySpan: '#z3kd_money',
                zsSpan: '#z3kd_zs',
                clearBtn: '#z3kd_list_clear'
            });
            this.createZ3Kd = this.getNoop()
        },

        createZuHe: function (){
            Y.lib.ZuHeChoose({
                msgId: 'zh_zhx',
                balls: '#zhxzh li b',
                showbar: '#zhxzh_showbar',
                putBtn: '#zhxzh_put',
                clearBtn:'#zhxzh_clear',
                //rndOpts: '#zhxzh_jx_opts',
                rnd: '#zhxzh_jx'
               /* yl:[{
                    xml: '/static/public/pls/xml/yilou/yl_zhixuan.xml',
                    dom: '#zhxzh li i',
                    sort: 'num'
                }]*/
            });
            Y.lib.KdCodeList({
                msgId: 'zh_zhx',
                panel:'#zhxzh_list',
                bsInput:'#zhxzh_bs',
                moneySpan: '#zhxzh_money',
                zsSpan: '#zhxzh_zs',
                clearBtn: '#zhxzh_list_clear'
            });
            this.createZuHe = this.getNoop()
        },


        createDt: function (){
            Y.lib.Choose_dt({
                msgId: 'zhdt_zhx',
                dan: '#zhxdt_dan li b',
                tuo: '#zhxdt_tuo li b',
                showbar: '#zhxdt_showbar',
                putBtn: '#zhxdt_put',
                clearAll: '#zhxdt_clear'
                /*yl:[{
                    xml: '/static/info/pls/omit/dxyl_dsxs_all.xml',
                    sort: 'object',
                    dom: '#zhxdt_dan li i'
                },{
                    xml: '/static/info/pls/omit/dxyl_dsxs_all.xml',
                    sort: 'object',
                    dom: '#zhxdt_tuo li i'
                }]*/
            });
            Y.lib.CodeList_dt({
                msgId: 'zhdt_zhx',
                panel:'#zhxdt_list',
                bsInput:'#zhxdt_bs',
                moneySpan: '#zhxdt_money',
                zsSpan: '#zhxdt_zs',
                clearBtn: '#zhxdt_list_clear'
            });
            this.createDt = this.getNoop()
        },

        createZ6Dt: function (){
            Y.lib.Choose_Z6dt({
                msgId: 'dt_z6',
                dan: '#z6dt_dan li b',
                tuo: '#z6dt_tuo li b',
                showbar: '#z6dt_showbar',
                clearAll: '#z6dt_clear',
               /* yl:[{
                    xml: '/static/public/pls/xml/yilou/yl_z6.xml',
                    dom: '#z6dt_dan li i',
                    sort: 'num'
                },{
                    xml: '/static/public/pls/xml/yilou/yl_z6.xml',
                    dom: '#z6dt_tuo li i',
                    sort: 'num'
                }],*/
                putBtn: '#z6dt_put'
            });
            Y.lib.CodeList_dt({
                msgId: 'dt_z6',
                panel:'#z6dt_list',
                bsInput:'#z6dt_bs',
                moneySpan: '#z6dt_money',
                zsSpan: '#z6dt_zs',
                clearBtn: '#z6dt_list_clear'
            });
            this.createZ6Dt = this.getNoop()
        },

        createZ3Dt: function (){
            Y.lib.Choose_Z3dt({
                msgId: 'dt_z3',
                dan: '#z3dt_dan li b',
                tuo: '#z3dt_tuo li b',
                showbar: '#z3dt_showbar',
                clearAll: '#z3dt_clear',
               /* yl:[{
                    xml: '/static/public/pls/xml/yilou/yl_z3.xml',
                    dom: '#z3dt_dan li i',
                    sort: 'num'
                },{
                    xml: '/static/public/pls/xml/yilou/yl_z3.xml',
                    dom: '#z3dt_tuo li i',
                    sort: 'num'
                }],*/
                putBtn: '#z3dt_put'
            });
            Y.lib.CodeList_dt({
                msgId: 'dt_z3',
                panel:'#z3dt_list',
                bsInput:'#z3dt_bs',
                moneySpan: '#z3dt_money',
                zsSpan: '#z3dt_zs',
                clearBtn: '#z3dt_list_clear'
            });
            this.createZ3Dt = this.getNoop()
        },

        setBuyFlow: function (){
           this.get('#buy_dg,#buy_hm,#buy_zh').click(function (e, y){
               var data, msg;
                if (Yobj.C('isEnd')) {
                    Yobj.alert('您好，'+Yobj.C('lot-ch-name')+Yobj.C('expect')+'期已截止！');
                    return false                }
               y.postMsg('msg_login', function (){
                   msg = Class.config('play_name') == 'lr' || Class.config('play_name') == 'sc' ? '' : '_'+Class.config('play_name2');
                   if (Class.config('play_name') == 'sc' && y.postMsg('msg_check_sc_err').data) {
                       return false// 上传额外检测
                   }else if(Class.config('play_name') == 'dq' && y.postMsg('msg_dq_check_err').data){
                       return false//多期额外检测
                   }else if (data = y.postMsg('msg_get_list_data_'+Class.config('play_name')+msg).data) {//索取要提交的参数
                        if (data.zhushu === 0 ) {
                            y.postMsg('msg_show_dlg', '请至少选择一注号码再进行购买！')
                        }else if(data.beishu === 0){
                            y.postMsg('msg_show_dlg', '对不起，请您至少要购买 <strong class="red">1</strong> 倍！')                    
                        }else if(data.totalmoney <= 0){
                            y.postMsg('msg_show_dlg', '发起方案的金额不能为 <strong class="red">0</strong> ！')                       
                        }else{
                            switch(Class.config('buy_type')){// 分派到购买方式
                             case 0: 
                                 Y.postMsg('msg_buy_dg', data)//代购
                                 break;
                             case 1: 
                                 Y.postMsg('msg_buy_hm', data)// 合买
                                 break;
                             case 2: 
                                 Y.postMsg('msg_buy_zh', data)//追号
                            }                    
                        }                            
                   }                   
               });
               e.end();
               return false;
           }) 
        },

        createTabs: function (){

            var playTabs, subPlayTabs,dsTabs, buyTabs, pn, pn2,  playid, runSub, Y, reqiTabs;
            Y = this;

            //主玩法
            playTabs = this.lib.Tabs({// zx / z6 / z3
                items:'#playTabsDd A',
                focusCss: 'on'
            });
            //子玩法
            subPlayTabs = this.lib.Tabs({// 
                items:'#nav_normal label',
                focusCss: 'b'
            });
            //购买方式
            buyTabs = this.lib.Tabs({
                items:'#all_form label',
                focusCss:'b',
                contents: '#dg_form, #hm_form,#zh_form'
            });
            //单式
            var isdschk = this.get('#dschk').val() == 1;
            this.C('isDsChk', isdschk);
            if (isdschk) {
                this.get('#up_data').insert('#nowupload', 'next').hide();
            }

            dsTabs = this.lib.Tabs({
                focusCss:'b',
                items:'#tolr,#tochk,#tosc',
                contents:'#dslr,#dssc,#dssc' 
            });

            //pn = 'pt,lr,hz,zxhz,kd,zh,dt,zhdt'.split(',');
            pn = 'pt,lr,hz,zxhz,dt'.split(',');
            pn2 = 'zhx,z6,z3'.split(',');
            playid = {
                pt:1,
                lr:3,
                sc:1,
                dq: 1
            };

            var p_all = this.get('#pttz,#zhxhz,#zhxkd,#zhxzh,#zhxzhdt'+
                ',#dsbox,'+
                '#z6fs,#z6hz,#z6kd,#z6dt,'+
                '#z3fs,#z3hz,#z3kd,#z3dt');

            //top3玩法
            playTabs.onchange = function (a, b){
                p_all.hide();
                this.get('#pttz').show(b===0);
                this.get('#z6fs').show(b===1);
                this.get('#z3fs').show(b===2);
                Class.config('play_name', 'pt');
                Class.config('play_name2', pn2[b]);
                Class.config('playid', 1);
                this.postMsg('msg_clear_code');//通知清除选择
               // this.get('#nav_normal label').slice(-3).hide(b>0).end().slice(-2, -1).show(b>0)// 共用子玩法栏
                this.get('#nav_normal label').slice(-1).hide(b>0);
				this.get('#zxhz_label').show(b>0).prev().hide(b>0);
                subPlayTabs.focus(0)//子玩法定位到第一个
            };
            playTabs.focus(0);

            this.onMsg('msg_change_play', function (x){
                playTabs.focus(x)// 配合导入号码
            });

            var zhx_all = this.get('#pttz,#dslr,#zhxhz,#z6hz,#zhxkd,#zhxzh,#z6dt,#zhxzhdt'),
                z6_all = this.get('#z6fs,#dslr,#zhxhz,#z6hz,#z6kd,#zhxzh,#z6dt'),
                z3_all = this.get('#z3fs,#dslr,#zhxhz,#z3hz,#z3kd,#zhxzh,#z3dt');

            //子玩法 pt/ds/hz
            subPlayTabs.onchange = function (a, b){
                var tmp;
                this.get('#dsbox').hide();
                var play_name = Class.config('play_name2');
                switch(play_name){
                case 'zhx':
                    zhx_all.hide().slice(b, b+1).show();
                    if (b==2) {
                        Y.createZhHz()//直选和值
                    }else if(b==4){
                        Y.createZhxKd()
                    }else if(b==5){
                        Y.createZuHe()
                    }else if(b==7){
                        Y.createDt()
                    }
                    this.get('#hz_tj').show(b==2);
                    this.get('#lr_tj').hide(b==2);
                    this.get('#uphelp ul').show().slice(-1).hide();
                    break;
                case 'z6':
                    z6_all.hide().slice(b,b+1).show();
                    if (b==0) {
                        Y.createZ6()
                    }else if(b==3){
                        Y.createZ6Hz()
                    }else if (b==4) {
                        //Y.createZ6Kd()
						Y.createZ6Dt()
                    }/*else if(b==6){
                        Y.createZ6Dt()
                    }*/
                    this.get('#hz_tj').show(b==3);
                    this.get('#lr_tj').hide(b==3);
                    this.get('#uphelp ul').hide().slice(-1).show();
                    break;
                case 'z3':
                    z3_all.hide().slice(b,b+1).show();
                    if (b==0) {
                        Y.createZ3()
                    }else if(b==3){
                        Y.createZ3Hz()
                    }else if (b==4) {
                        //Y.createZ3Kd()
						Y.createZ3Dt()
                    }/*else if(b==6){
                        Y.createZ3Dt()
                    }*/
                    this.get('#hz_tj').show(b==3);
                    this.get('#lr_tj').hide(b==3);
                    this.get('#uphelp ul').hide().slice(-1).show();
                }
                Class.config('play_name', pn[b]);
                if (b==1) {
                    Y.createDs()//创建单式-共用
                    Y.get('#help_li_zx').hide(play_name == 'zhx');
                    this.get('#dsbox').show();
                    dsTabs.focus(1);
                }
                Class.C('stop-last-check-limit', b > 1); //提交时不检测限号
                buyTabs.btns.show();
                //buyTabs.btns.slice(-1).hide(b==1);
                buyTabs.focus(0);
                this.postMsg('msg_clear_code');
                var tipId = ('#'+Class.config('play_name2')+pn[b]+'_tips').replace(/z\dzxhz/,'zxhz').replace('lr', 'pt');
                this.get('#sd_tips p').hide().get(tipId).show();//奖金说明栏
                this.loadEndTime();//同步变换截止时间
            };

            //单式
            dsTabs.onchange = function (a, b){
                this.get('#dslr').hide(b>0).get('#dssc').hide(b==0);
                this.get('#nowupload').hide(b==2);
                this.get('#up_help').show(b==1);
                if (isdschk) {
                    this.get('#up_data').show(b==2||b==1);
                    this.get('#loadzs').hide(b==2||b==1);
                    this.get('#inputzs').show(b==2||b==1);                    
                }
                Class.config('play_name', b == 0 ? 'lr' : 'sc' );
                this.postMsg('msg_clear_code');
                this.one('#scChk').checked = b==2;
                buyTabs.btns.slice(0,2).show();//恢复可能由稍后上传隐藏的代购
                if (b==2) {
                    buyTabs.btns.slice(0, 1).hide();//稍后上传只能合买
                    buyTabs.focus(1);
                }else{
                    buyTabs.focus(0);
                }
            };
            //购买方式
            this.get('#all_form em.i-qw').tip(false, 5, '<h5>代购：</h5>'+
                '是指方案发起人自己一人全额认购方案的购彩形式。若中奖，奖金也由发起人一人独享。<br/><br/>'+
                '<h5>合买：</h5>'+
                '由多人共同出资购买同一个方案，如果方案中奖，则按投入比例分享奖金。合买能够实现利益共享、风险共担，是网络购彩的一大优势。<br/><br/>'+
                '<h5>追号：</h5>追号是选中了一注或一组号码，连续买几期或十几期甚至几十期。');
            buyTabs.onchange = function (a, b, c){
                 Class.config('buy_type', b );
                 this.get('#ishm').val(b==1? 1 : 0);
                 this.get('#ischase').val(b==2? 1 : 0);
                 if (b==2) {
                     //!c && this.moveToBuy(function (){
                          Y.createZhOptions(this.btns.nodes[b])
                     //});
                     this.postMsg('toggle-zh')// 通知倍数框限制倍数
                 }else{
                     !c && this.moveToBuy()
                 }
                 this.get('#all_form span.r').html(['由购买人自行全额购买彩票','由多人共同出资购买彩票','连续多期购买同一个（组）号码。'][b]);
            };
            if (location.href.indexOf('type=hm')>-1) {
                 buyTabs.focus(1)
            }else{
                buyTabs.focus(0)
            } 

			//以下是继续购买所做的修改
			var codes = this.dejson(this.get('#codes').val());
			if (codes && typeof codes == 'object') {
				//log(codes);return;
				var playid = +codes.playid,
					play_map = {zhx:[20,30,138,136,137],z6:[29,31,140,142],z3:[28,139,141]},
					subplay_pos_map = {20:0,30:2,138:4,136:5,137:7,29:0,31:3,140:4,142:6,28:0,139:4,141:6},
					msgid_map = {20:'pt_zhx',30:'hz_zhx',138:'kd_zhx',136:'zh_zhx',137:'zhdt_zhx',29:'pt_z6',31:'zxhz_z6',140:'kd_z6',142:'dt_z6',28:'pt_z3',139:'kd_z3',141:'dt_z3'};
				if (play_map.z6.indexOf(playid) !== -1) {
					playTabs.focus(1);
					playTabs.onchange(1, 1);
				} else if (play_map.z3.indexOf(playid) !== -1) {
					playTabs.focus(2);
					playTabs.onchange(2, 2);
				}
				subPlayTabs.focus(subplay_pos_map[playid]);
				subPlayTabs.onchange(subplay_pos_map[playid], subplay_pos_map[playid]);
				if (+codes.ishm) {
					buyTabs.focus(1);
				} else if (+codes.ischase) {
					buyTabs.focus(2);
					buyTabs.onchange(2, 2);
				}
				codes.msgId = msgid_map[playid];

				var new_codes = [];
				switch (playid) {
					case 20:
						codes.codes.split(';').each( function(c) {
							var _codes = c.split(','),
								bw = _codes[0].split(''),
								sw = _codes[1].split(''),
								gw = _codes[2].split(''),
								zs = bw.length * sw.length * gw.length;
							new_codes.push( [bw, sw, gw, zs] );
						});
						break;
					case 30:
						var _codes = codes.codes.split(','),
							zs = 0;
						_codes.each( function(c) {
							zs += Y.C('hzQuery').zhx[c];
						}, this);
						new_codes.push( [_codes, zs] );
						break;
					case 138:
						var _codes = codes.codes.split(','),
							zs = 0;
						_codes.each( function(c) {
							zs += Y.C('hzQuery').zhxkd[c];
						}, this);
						new_codes.push( [_codes, zs] );
						break;
					case 136:
						var _codes = codes.codes.split(','),
							zs = Math.p(_codes.length, 3);
						new_codes.push( [_codes, zs] );
						break;
					case 137:
						var d  = codes.codes.match(/\[D:([^\]]*)/)[1].split(','),
							t  = codes.codes.match(/\[T:([^\]]*)/)[1].split(','),
							zs = Math.c(t.length, 3 - d.length) * Math.p(3, 3);
						new_codes.push( [d, t, zs] );
						break;
					case 29:
						codes.codes.split(';').each( function(c) {
							var _codes = c.split(','),
								zs = Math.c(_codes.length, 3);
							new_codes.push( [_codes, zs] );
						});
						break;
					case 31:
						var _codes = codes.codes.split(','),
							zs = 0;
						_codes.each( function(c) {
							zs += Y.C('zxhzQuery')[c];
						}, this);
						new_codes.push( [_codes, zs] );
						break;
					case 140:
						var _codes = codes.codes.split(','),
							zs = 0;
						_codes.each( function(c) {
							zs += Y.C('hzQuery').z6kd[c];
						}, this);
						new_codes.push( [_codes, zs] );
						break;
					case 142:
						var d  = codes.codes.match(/\[D:([^\]]*)/)[1].split(','),
							t  = codes.codes.match(/\[T:([^\]]*)/)[1].split(','),
							zs = Math.c(t.length, 3 - d.length);
						new_codes.push( [d, t, zs] );
						break;
					case 28:
						codes.codes.split(';').each( function(c) {
							var _codes = c.split(','),
								zs = Math.c(_codes.length, 2) * 2;
							new_codes.push( [_codes, zs] );
						});
						break;
					case 139:
						var _codes = codes.codes.split(','),
							zs = 0;
						_codes.each( function(c) {
							zs += Y.C('hzQuery').z3kd[c];
						}, this);
						new_codes.push( [_codes, zs] );
						break;
					case 141:
						var d  = codes.codes.match(/\[D:([^\]]*)/)[1].split(','),
							t  = codes.codes.match(/\[T:([^\]]*)/)[1].split(','),
							zs = Math.c(t.length, 1) * 2;
						new_codes.push( [d, t, zs] );
						break;
				}
				codes.codes = new_codes;
				//log(codes);return;
				this.postMsg('show_continue_buy_data', codes);  //重现继续购买的其他数据
			}

        }
    }); 


    Class('CodeSkep>plsSkep', {
        ready: true,
        use:' mask',
        ptTpl: ' <li>{1}</li>',
        dtTpl: ' <li>【胆】{1}【拖】{2}</li>',
        ddPlayid: 294,
        getSubType: function (){
            return '_'+this.C('play_name2');
        },
        data2Html: function (data){//显示在添加列表中的HTML
            var curType = this.C('play_name');
            this.codeTpl = this.ptTpl;
            switch(curType+this.getSubType()){
            case 'pt_zhx':
                if (this.dataSrc == 'list') {
                    var codes = data.codes.split(';');
                    return codes.map(function (code){
                        var rb = code.split(',');
                        return this.codeTpl.format(rb[0]+','+rb[1]+','+rb[2])
                    }, this);                  
                }else{
                    return data.map(function (code){
                        return this.codeTpl.format((code[0].join(',')||'-')+','+(code[1].join(',')||'-')+','+( code[2].join(',')||'-')) 
                    }, this);                          
                }
                break;
            case 'zhdt_zhx':case 'dt_z6':case 'dt_z3':
                this.codeTpl = this.dtTpl;
                if (this.dataSrc == 'list') {
                    var codes = data.codes.split(';');
                    return codes.map(function (code){
                        var dt = code.match(/\[D:([^\]]+)\]\[T:([^\]]+)\]/);
                        return this.codeTpl.format(dt[1], dt[2])
                    }, this);                       
                }else{
                    var c=data.code;
                    return c.map(function (code){
                        return this.codeTpl.format(code[0].join(',')||'-', code[1].join(',')||'-') 
                    }, this);                      
                }
                break;
          default:
                if (this.dataSrc == 'list') {
                    var codes = data.codes.split(';');
                    return codes.map(function (code){
                        var rb = code.split(',');
                        return this.codeTpl.format(rb[0])
                    }, this);                  
                }else{
                    return data.map(function (code){
                        return this.codeTpl.format(code[0].join(',')) 
                    }, this);                          
                }
                break;
            }
        },
        checkCode: function (data){//从页面导入号码时检测是否可以收藏
            var curType = this.C('play_name');
            //log(data, curType+this.getSubType())
            if (this.dataSrc == 'list') {
                if (data.zhushu == 0) {
                    return curType == 'ai' ? '您好, 请选择一注号码进行过滤!' : '您好, 请选择一注号码再添加到号码篮!'
                }                   
            }else{//源于选号器
                switch(curType+this.getSubType()){
                case 'pt_zhx':
                    if (data[0][0].length == 0 || data[0][1].length == 0 || data[0][2].length == 0) {
                        return '您好，请您至少在百、十、个位上各选择1个号码！'
                    }    
                    break;
                case 'zhdt_zhx':case 'dt_z6':case 'dt_z3':
                    data = data.code;
                    var t = curType == 'zhdt' ? 4 : 2;
                    if (data[0][0].length == 0){
                        return '您好，请您至少选择1个胆码！'
                    }else if(t == 4 && (data[0][1].length + data[0][0].length < t )) {
                        return '您好，胆码加上拖码的数量必须大于或者等于'+t+'！'
                    }else if(t == 2 && data[0][1].length < 2){
                        return '您好，请您至少选择2个拖码！'
                    }
                    break;
                default:
                    if (data[0][1] == 0) {
                        return '您好，请您至少选择1注号码！'
                    }    
                    break;
                }
            }
        },
        formatSaveCode: function (data){//保存到号码篮前的号码序列化
            if (this.dataSrc == 'list') {
                return data
            }else{
                var curType = this.C('play_name');
                switch(curType+this.getSubType()){
                case 'pt_zhx':return {
                        codes:data[0][0].join('')+','+data[0][1].join('')+','+data[0][2].join(''), 
                        zhushu: data[0][3],
                        isfull: data[0][3] > 0 ? 1 : 0
                    };
                case 'zhdt_zhx': case 'dt_z6': case 'dt_z3':
                    return {
                        codes:'[D:'+data.code[0][0].join(',')+'][T:'+data.code[0][1].join(',')+']', 
                        zhushu: data.code[0][2],
                        isfull: data.code[0][2] > 0 ? 1 : 0                        
                    };
                default:
                    return {
                        codes:data[0][0].join(','), 
                        zhushu: data[0][1],
                        isfull: data[0][1] > 0 ? 1 : 0
                    };
                }
            }
        },
        parseCode: function (arr){//解析从号码篮来的号码 ['code($code2)*(, 'code($code2)*')*]
            var curType = this.C('play_name'), codes = [], err=0, stype = this.getSubType();
            arr.each(function (_case, i){
                var oCase = [];
                _case.code.split(';').map(function (code){// now: ['r|b', 'r|b']
                    var arr;
                    switch(curType+stype){
                    case 'pt_zhx':
                        arr = code.match(/^(\d+(?:,\d+)*)\|(\d+(?:,\d+)*)\|(\d+(?:,\d+)*)$/);
                        if (arr) {
                            arr = arr.slice(1).map(function (rb){
                                return rb.split(',');
                            });
                            oCase.push(arr.concat(arr[0].length*arr[1].length*arr[2].length));
                        }else{
                            err++;
                        }                        
                        break;
                    case 'zhdt_zhx':case 'dt_z6':case 'dt_z3'://[D:06,08,10,22,23][T:04,05,14,16]
                        arr = code.match(/\[D:(\d+(?:,\d+)*)\]\[T:(\d+(?:,\d+)*)\]/);
                        if (arr) {
                            arr = arr.slice(1).map(function (c){
                                return c.split(',')
                            });
                            var minB = 3, zsB = 6, selB = 3;
                            if (stype == '_z6') {
                                minB = 2;
                                zsB = 1;                                
                            }else if(stype == '_z3'){
                                minB = 2;
                                zsB = 2; 
                                selB = 2;
                            }
                            if (arr[0].length+arr[1].length>minB ) {
                                oCase.push(arr.concat(Math.dt(arr[0].length, arr[1].length, selB)*zsB))
                            }
                        }else{
                            err++;
                        }
                        break;
               default:
                        arr = code.match(/^(\d+(?:,\d+)*)$/);
                        if (arr) {
                            arr = arr.slice(1).map(function (rb){
                                return rb.split(',');
                            });
                            switch(curType+stype){
                            case 'zh_zhx':
                                oCase.push(arr.concat(Math.p(arr[0].length, 3)));
                                break;
                            case 'pt_z6':
                                oCase.push(arr.concat(Math.c(arr[0].length, 3)));
                                break;
                            case 'pt_z3':
                                oCase.push(arr.concat(Math.c(arr[0].length, 2)*2));
                                break;
                            default://zxhz_z6, kd_z6
                                var map, zs, type;
                                type = Class.C('play_name2');
                                map = Class.C('hzQuery')[type+(curType == 'kd' ? 'kd' : '')];
                                zs = 0;
                                arr[0].each(function (item, n){
                                    zs += map[item];
                                });
                                oCase.push(arr.concat(zs));   
                            }
                        }else{
                            err++;
                        }        
                    }                    
                });
                if (oCase.length) {
                    codes.push(oCase);
                }else{
                    codes.push(false);//占位
                }
            });
            codes.err = err;//无效个数
            codes.type = curType+stype;
            return codes;
        },
        put2List: function (codes){//投递到号码框
            var info = '该玩法一个方案只支持一注号码, ';
            codes.each(function (_case){
                if (codes.type == 'kd_zhx' 
                    || codes.type == 'kd_z6' 
                    || codes.type == 'kd_z3' 
                    || codes.type == 'zh_zhx' 
                    || codes.type == 'zhdt_zhx' 
                    || codes.type == 'hz_zhx' 
                    || codes.type == 'zxhz_z3' 
                    || codes.type == 'zxhz_z6' ) {//一个方案只能有一注号码
                    this.checkSingle(function (){
                        this.postMsg('msg_clear_code');
                        this.postMsg('msg_put_code', _case);                            
                    }, info );
                    return false;
                }else{
                    this.postMsg('msg_put_code', _case);
                }                
            }, this);
        }
    });


})()