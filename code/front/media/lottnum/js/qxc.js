var randomNum = 5;//随机次数
var bdScale = 0.2;//保底比例
var minFsScale = 0.05;//认购比例
var zsMoney = 2; //每注多少钱
var keyup_left = 0;
var keyup_top = 0;
var offset = new Object();
//获取期号
var issue_url = "/lotteryapi/sdata/lotissue?lottid=10";
var fq_url = "/lotteryapi/orderprocess/ordersub?lottid=10";
//开奖公告
var kjgg_url = "/lotteryapi/sdata/lotnotice?lottid=10";
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
		var acc = item.acc; //滚存
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
			$("#expect_tab").append("|");
		}
		//$("#expect_tab >a:eq("+index+")").attr("id",issueArr[index]).attr("etime",etimeArr[index]).html(issueStr+issueArr[index]+"期");
	});
	var endTime = $("#expect_tab >a").filter(".on").attr("etime");
	$("#endTimeSpan").html(endTime);
}
function errorCallBack(){
	
}




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
    Class.config('lot-ch-name', '七星彩'); 
    Class.config('play-ch-name', '复式投注');
    Class.config('page-config', {});//页面隐藏配置
    //Class.config('divExpect', [10125, 10130]);//追号期号标红
    Class.config('hasddsh', false);//是否定胆
    Class.config('last-ddsh', '-/-');
    Class.config('dssc_url', '/lotteryapi/orderprocess/order_fqds');

    /*
    'pt,lr,hz' - 1
    'zhx,z6,z3' - 2
    */
    Class.extend('getPlayText', function (play_name){
        var map, map2;
        map = {
            'pt': '复式',
            'lr': '单式',
            'sc': '单式',
            'dq': '多期机选'
        };
        return map[Class.C('play_name')] + ['代购','合买','追号'][Class.C('buy_type')];
    });
    // 自动生成playid
    Class.extend('getPlayId', function (play_name){
        var pn = Class.config('play_name');
        return pn=='lr' || pn == 'sc' ? 3 : 1
    });

    Class.extend('exportCode', function (){
        // 传入号码
        var import_code, arrCodes, short_code;
        if (import_code = Yobj.get('#codes').val()) {
			if (typeof this.dejson(import_code) == 'object') return;
            arrCodes = import_code.split('$').map(function (c){
                var rb = c.split('|'), w = [], zs = 1;
                rb.each(function (x, i){
                    w[i] = x.split('');
                    zs *= x.length
                });
                w.push(w.length < 5 ? 0 : zs);
                return w
            }).filter(function (c){
                if (c[c.length - 1] == 0) {//zs
                    short_code = c//残缺号码
                }else{
                    return true
                }
            });
            if (arrCodes.length) {//完整号码显示到列表
                 this.postMsg('msg_put_code', arrCodes);
                 this.moveToBuy()
            }
            if (short_code && short_code.length) {// 残缺号码显示到球区
                this.postMsg('msg_redraw_code', short_code)
            }
        }
    });

//验证认购，保底
var rgbdValidation = function(){
	var z_money = "";
	var pt_money = "";//所有钱数
	//普通投注
	if($("#pttz_tab").attr("checked")){ 
		pt_money = numFormat($("#pt_money").html());//所有钱数
		z_money = $("#pt_money");
	}else if($("#dssc_tab").attr("checked")){ //单式上传
		pt_money = numFormat($("#sc_money").html());//所有钱数
		z_money = $("#sc_money");
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

//打开温馨提示窗口
var openInfoDlgDiv = function(content,flag){
	var height = parseInt($("#info_dlg").css("height"));
	var scrollTop = $(document).scrollTop();
	var x=$(window).width()/2;
	var sleft=$("body").scrollLeft();
	var width = $("#info_dlg").width()/2;
	var left=x-width+sleft+"px";

	$("#info_dlg_content").html(content).parents("#info_dlg").
		css("left",left).css("top",height+scrollTop+'px').draggable(".move").show();

	if(flag==false){	

		$("#info_dlg_ok").hide();	
	}
	if(flag==null || flag==undefined){

		$("#info_dlg_ok").show();
	}	

	showBgdiv();
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
    /*
    begin
    */
    Class({
        use: 'tabs,dataInput,mask',
        ready: true,

        index:function (){
            //this.Type = 'App_index';
            this.createTabs();
            this.createSub();
            /*this.lib.PLHotCoolChart({
                xml: '/static/info/qxc/omit/wzyl_100.xml'
            });
            this.getTiDian({//提点与专家
                kj: '/static/info/kaijiang/xml/qxc/index.xml',
                kj5: '/static/info/kaijiang/xml/qxc/list5.xml',
                ph: '/static/info/paihang/qxc/months/{1}{2}_1.xml'
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
                return this.postMsg('msg_get_list_data_'+Class.C('play_name')).data;
            });

            this.onMsg('msg_put_code', function (code){//自动匹配不同的号码列表进行消息转发
                this.moveToBuy();
                return this.postMsg('msg_put_code_'+Class.C('play_name'), code).data;
            });

            this.onMsg('msg_rnd_code', function (code){//自动匹配不同的号码列表进行消息转发
                return this.postMsg('msg_rnd_code_'+Class.C('play_name'), code).data;
            });

            this.onMsg('msg_clear_code', function (code){//自动匹配不同的号码列表进行消息转发
                return this.postMsg('msg_clear_code_'+Class.C('play_name'))
            });

            this.onMsg('msg_redraw_code', function (code){//自动匹配不同的选择器进行消息转发
                return this.postMsg('msg_redraw_code_'+Class.C('play_name'), code)
            });

            this.onMsg('msg_list_change', function (data){//自动匹配不同的号码列表
                this.get('#buyMoneySpan').html(data.totalmoney.rmb());
                this.get('#buySYSpan').html(Math.max(0, Class.C('userMoney') - data.totalmoney).rmb() );                
            });
            this.onMsg('msg_auto_kill_num', function (auto){//自动杀号
                Class.C('auto-kill', auto)           
            });
            // plw直选
            Y.lib.PLChoose({
                msgId: 'pt',
                balls: '#pttz ul.c-s-num',
                showbar: '#pt_showbar',
                putBtn: '#pt_put',
                rndOpts:'#pt_jx_opts',
                clearBtn:'#pt_clear',
                rnd: '#pt_jx',
				ddRnd: '#dd_jx'
               
            });
            // 直选列表
            Y.lib.PLCodeList({
                msgId: 'pt',
                panel:'#pt_list',
                bsInput:'#pt_bs',
                moneySpan: '#pt_money',
                zsSpan: '#pt_zs',
                clearBtn: '#pt_list_clear'
            });

            Y.lib.Dlg();
            Y.lib.HmOptions();
            setTimeout(function() {
                Y.lib.BuySender();
            },500);            

            this.setBuyFlow();
        },

       setBuyFlow: function (){
           this.get('#buy_dg,#buy_hm,#buy_zh').click(function (e, y){
               var data, msg;
                if (Yobj.C('isEnd')) {
                    Yobj.alert('您好，'+Yobj.C('lot-ch-name')+Yobj.C('expect')+'期已截止！');
                    return false                }
               y.postMsg('msg_login', function (){
                   if (Class.config('play_name') == 'sc' && y.postMsg('msg_check_sc_err').data) {
                       return false// 上传额外检测
                   }else if(Class.config('play_name') == 'dq' && y.postMsg('msg_dq_check_err').data){
                       return false//多期额外检测
                   }else if (data = y.postMsg('msg_get_list_data_'+Class.config('play_name')).data) {//索取要提交的参数
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

        createZhOptions: function (el){//延迟实现
           var Y = this;
           setTimeout(function() {
               Y.lib.ZhOptions()
           },100)  
           Y.createZhOptions = this.getNoop()
        },
        createDs: function (){
           Y.lib.PLCodeEditor({
                lineNum: 7,
                textarea: '#lr_editor',
                msgId: 'lr',
                lr_num: '#lr_num',
                putBtn:'#lr_put',
                clearBtn: '#lr_clear',
                rndSelect: '#lr_opts',
                rndBtn: '#lr_jx'
            });
            // 录入列表
            list_lr = Y.lib.PLCodeList({
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

        createDq: function (){
             Y.lib.Dq_Random({
                zsInput: '#dq_zs',    
                bsInput: '#dq_bs'
            });
            this.createDq = this.getNoop()
        },

        createTabs: function (){

            var playTabs, subPlayTabs,dsTabs, buyTabs, pn, pn2,  playid, runSub, Y, reqiTabs;
            Y = this;

            //主玩法
            playTabs = this.lib.Tabs({// zx / z6 / z3
                items:'#playTabsDd A',
                contents: '#pttz,#dsbox',
                focusCss: 'on'
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
                //this.get('#up_data').insert('#nowupload', 'next').hide();
            }

            dsTabs = this.lib.Tabs({
                focusCss:'b',
                items:'#tolr,#tochk,#tosc',
                contents:'#dslr,#dssc,#dssc' 
            });

            pn = 'pt,lr,dq'.split(',');

            //top3玩法
            playTabs.onchange = function (a, b){
                Class.config('play_name', pn[b]);
                Class.config('playid', 1);
                this.postMsg('msg_clear_code');//通知清除选择
                this.get('#all_form').hide(b==2);
                this.get('#dssc').hide();
                if (b==1) {
                    Y.createDs();
                    dsTabs.focus(1)
                }else if(b==2){
                    Y.createDq()
                }else{
                    Y.createZhOptions(this.btns.nodes[b])
                }
                buyTabs.btns.show();
                //buyTabs.btns.slice(-1).hide(b==1);
                buyTabs.focus(b==2?2:0);
                this.loadEndTime();//同步变换截止时间
            };
            playTabs.focus(0);

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
                     !c && this.moveToBuy(function (){
                          Y.createZhOptions(this.btns.nodes[b])
                     });
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
				codes.msgId = 'pt';
				if (+codes.ishm) {
					buyTabs.focus(1);
				} else if (+codes.ischase) {
					buyTabs.focus(2);
					buyTabs.onchange(2, 2);
				} else {
					buyTabs.focus(0);
				}
				var new_codes = [];
				codes.codes.split('$').each( function(c) {
					var _codes = c.split('|').each(function(_c){this.push(_c.split(''))},[]), zs = 1;
					_codes.each(function(_c){zs*=_c.length});
					_codes.push(zs);
					new_codes.push( _codes );
				});
				codes.codes = new_codes;
				this.postMsg('show_continue_buy_data', codes);  //重现继续购买的其他数据
			}
		
		}
    });  
})()