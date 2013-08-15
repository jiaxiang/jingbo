/* 配置
---------------------------------------------------------------------------------------------------------------*/
Class.C('url-addmoney', '/user/recharge');
Class.C('has_submit', false);

//转换为整数输入框
Class.fn.intInput = function (fn, max, min){
    var min = min === undefined ? 1 : min,
        max = max === undefined ? Number.MAX_VALUE : max;
    this.keyup(check).blur(check).focus(function (){
        setTimeout((function() {
            this.select()
        }).proxy(this),10);
    });
    function check(e, Y){
        var val = Math.max(Y.parseVal(min), Math.min(parseInt(this.value||0, 10)||0, Y.parseVal(max) || Number.MAX_VALUE));
        if (this.value == ''){
            if(e.type != 'keyup') {
                this.value = val
            }                
        }else if(val != this.value){
            this.value = val
        }
        if (this.value != this.preValue) {
             fn.call(this, e, Y);
             this.preValue = this.value
        }
    }
};
//默认值
Class.fn.defaultVal = function (focusCss){
    this.focus(function (e, host){
        if (this.value.trim() == this.defaultValue) {
            this.value = '';
            if (focusCss) {
                host.get(this).addClass(focusCss)
            }
        }
    }).blur(function (e, host){
        if (this.value.trim() == '') {
            this.value = this.defaultValue;
            if (focusCss) {
                host.get(this).removeClass(focusCss)
            }
        }
    })
};
//长度改变事件
Class.fn.lenchange = function (fn, max){
    max = max || Number.MAX_VALUE;
    this.focus(function (e, host){
        var node = this, len = this.value.length;
        host.get(this).data('lenchangeTimer', setInterval(function() {
            var l = node.value.length;
            if (l > max) {
                node.value = node.value.slice(0, max);
                l = max
            }
            if (l != len) {
                fn.call(node, max - l);
                len = l
            }
        },100));
    }).blur(function (e, host){
        clearInterval(host.get(this).data('lenchangeTimer'));
    })
};
/* 合买表单
----------------------------------------------------------------------------------------------------------------*/
Class('HmForm', {
    ready: true,
    bdScale: .2,
    rgScale: .05,
    index:function (opts){
        var hm = this.get('#ishm').val() == 1;
        this.totalmoney = this.getInt(this.qForm('#buyform').totalmoney);
        if (hm) {
            this.ishm = true;
            this._addUI(opts);
            this._bindEvent();
            this._updateMoney(this.totalmoney)            
        }
        this.onMsg('msg-hm-check', function (){
			return this._check()
        })
    },
    _addUI: function (opts){
         var dom = {
            fsN: '#uFs',
            fsM: '#uFsM',
            fsE: '#uFsE',

            tcN: '#uTc',            
           
            rgN: '#uRg',
            rgM: '#uRgM',
            rgS: '#uRgS',
            rgE: '#uRgE',
            
            bdN: '#uBd',
            bdC: '#uBdC',
            bdM: '#uBdM',
            bdS: '#uBdS',
            bdE: '#uBdE',
            
            agree: '#uAgree',

            adC: '#uAd',
            adB: '#case_ad',
            adT: '#uAdT',
            adCo: '#uAdCo',
            
            gk1: '#gk1',
            gk2: '#gk2',
            gk3: '#gk3',
            
            dx: '#uT',
            dx1: '#uT1',
            dx2: '#uT2',
            dxB: '#uFixedbox',
            dxF: '#uFixed'
        }
        for(var k in dom){
            this[k] = this.get(dom[k])
        }
    },
    _updateMoney: function (m){
        var rg;
        this.totalmoney = m;
        this.curFs = m;
        this.curMf = 1;
        //份数
        this.fsN.val(m);
        this.fsM.html((1).rmb());
        this.allFs = m;
        this.fsE.hide();
        //认购
        this._autoRg();
        //保底
        this._autoBd()
    },
    _autoRg: function (){//自动认购5%
        var all = this.getInt(this.fsN.val()),//全部份数
            rg = Math.ceil(all*this.rgScale);
        this.curRg = this.minRg = rg;
        this.rgN.val(rg);
        this.rgM.html((rg*this.curMf).rmb());
        this.rgE.hide();
        this.rgS.html(((rg/all)*100).toFixed(2));        
    },
    _notBd: function (){//无保底
        this.bdN.prop('disabled', true).val(0);
        this.bdS.html('0');
        this.bdE.hide();    
        this.curBd = 0;
    },
    _autoBd: function (){//自动保底20%
        if (this.bdC.prop('checked')) {
            var all = this.getInt(this.fsN.val()),//全部份数
                mf = this.totalmoney/all,
                bd = Math.ceil(all*this.bdScale);//保底份数
            this.curBd = this.minBd = bd;
            this.bdN.val(bd).prop('disabled', false);
            this.bdM.html((bd*mf).rmb());
            this.bdS.html(((bd/all)*100).toFixed(2));
            this.bdE.hide()
        }else{
            this._notBd()
        }
    },
    _showFs: function (){//份数检查
        var fs, fs2;
        fs = this.getInt(this.fsN.val());//用户输入份数
        this.curMf  = fs ? (this.totalmoney/fs) : 0;
        fs2 = this.getfitFs(this.totalmoney, fs);//合适份数
        this.fsM.html(this.curMf.rmb());
        this.fsE.show(fs != fs2);
        this.curFs = fs;
        this.curFs2 = fs2;
    },
    getfitFs: function (a, b){//计算适当份数(totalmoney, fs)
        while((a > b) && a/b - (a/b).toFixed(~~2) !== 0){b++};
        return Math.min(a, b)
    },
    _event_fs_change: function (){
        this._showFs();
        this._autoRg();
        this._autoBd()        
    },
    _event_rg_change: function (input){
        if (input.value < this.minRg) {
            this.rgE.html('至少需要认购' + this.minRg + '份！').show()
        }else{
            this.rgE.hide()
        }
        this.curRg = this.getInt(input.value);
        this.rgS.html(((this.curRg/this.curFs)*100).toFixed(2));
        this.rgM.html((this.curRg*this.curMf).rmb())        
    },
    _event_bd_change: function (input){
        if (input.value < this.minBd) {
            this.bdE.html('至少需要保底' + this.minBd + '份！').show()
        }else{
            this.bdE.hide()
        }
        this.curBd = this.getInt(input.value);
        this.bdM.html((this.curBd*this.curMf).rmb());
        this.bdS.html(((this.curBd/this.curFs)*100).toFixed(2))    
    },
    _bindEvent: function (){
        var host = this;
        this.fsN.intInput(function (){
            host._event_fs_change()
        }, function (){
            return host.totalmoney
        }, 1);
        this.rgN.intInput(function (){
            host._event_rg_change(this)
        }, function (){
            return host.getInt(host.curFs - Math.max(host.curBd, host.bdC.prop('checked')? host.minBd : 0))
        }, 1);
        this.bdN.intInput(function (){
            host._event_bd_change(this)
        }, function (){
            return host.getInt(host.curFs - Math.max(host.curRg, host.minRg))
        }, 1);
        this.adC.click(function (e, that){
            that.adB.show(this.checked);
            that.dx.show(this.checked);
        });
        this.dx1.click(function (e, that){
            that.dxB.hide()
        });
        this.dx2.click(function (e, that){
            that.dxB.show()
        });
        this.bdC.click(function (e, that){
            that._autoBd()
        });
        this.adT.defaultVal();
        this.adCo.defaultVal();
        this.dxF.defaultVal();
        var tip1 = this.adT.next('span');
        this.adT.lenchange(function (len){
            tip1.html('已输入'+this.value.length+'个字符，最多20个')
        }, 20);
        var tip2 = this.adCo.next('span');
        this.adCo.lenchange(function (len){
            tip2.html('已输入'+this.value.length+'个字符，最多200个')
        }, 200);
        this.dxF.lenchange(this.getNoop(), 500);
    },
    _isShow: function (o){
        return o.getStyle('display') != 'none'
    },
    _check: function (){
		
        if (!this.ishm) {
            return this.totalmoney
        }
		 
        var host = this;
        if (this._isShow(this.fsE)) {
            this.confirm('<p style="margin:20px">您好, 您现在分成的份数除不尽方案总金额, 可能会造成误差, 系统建议您分成'+this.curFs2+'份, 要分成'+this.curFs2+'份吗?</p>', function (){
                host.fsN.val(host.curFs2);
                host._event_fs_change()
             })
        }else if(this._isShow(this.rgE)){
            this.alert('您好，您最少必须认购<strong class="red">' + this.minRg + '</strong>份！', function (){
                host.rgN.val(host.minRg);
                host._event_rg_change(host.rgN);
                host.rgN.doProp('select');
            })
        }else if(this._isShow(this.bdE)){
            this.alert('您好，您最少必须保底<strong class="red">' + this.minBd + '</strong>份！', function (){
                host.bdN.val(host.minBd);
                host._event_bd_change(host.bdN);
                host.bdN.doProp('select');
            })            
        }else{//填充表单
            this.get('#allnum').val(this.curFs);
            this.get('#buynum').val(this.curRg);
            this.get('#isbaodi').val(this.bdC.prop('checked') ? 1 : 0);
            this.get('#baodinum').val(this.curBd);
            this.get('#tc_bili').val(this.tcN.val());
            this.get('#title').val(this.adT.val());
            this.get('#content').val(this.adCo.val());
            this.get('#buyuser').val(this.dx2.prop('checked') ? this.dxF.val() : 'all');
            this.get('#isset_buyuser').val(this.dx2.prop('checked') ? 2 : 1);
            pub = this.gk1.prop('checked') ? 0 : (this.gk2.prop('checked') ? 1 : 2);
            this.get('#public').val(pub);
            return (this.curRg+this.curBd)*this.curMf//返回应该付金额(保底+认购)
        }
    }
});
/* 启动
---------------------------------------------------------------------------------------------------------------*/
Class({
    ready: true,
    use: 'mask',
    index:function (){
		
        var ishm = this.get('#ishm').val() == 1,
            isagree = this.get(ishm ? '#uAgree' : '#isagree'),
            bs = this.getInt(this.get('#beishu').val());
        this.createDlg();
        this.get('#dobuy').click(function (e, Y){
		    var noAgree = !isagree.prop('checked') || (bs > 99 && !Y.get('#isoverflow').prop('checked'));
			
            if (noAgree) {
                Y.confirmDlg.pop('<p style="margin:20px">您好，您必须同意我们的协议才能购买！</p>', function (e, btn){
                    if (btn.id == 'confirm_dlg_yes') {
                        isagree.prop('checked', true).get('#isoverflow').prop('checked', true)
                       // Y._dobuy()
                    }
                 })
            }else{
                Y._dobuy()
            }
        });
        this.get('#backedit').click(function (e, Y){
			
            var data = Y.qForm('#buyform'), json = [];
			// data.codes = data.codes.replace(/-|:/g,'').replace(/胜其它/g,'3A').replace(/负其它/g,'0A').replace(/平其它/g,'1A');// bqc bs
			for(var k in data){
                json.push('"'+k+'":"'+data[k]+'"')
            }
            var j2 = '{'+json.join(',')+'}';
            Y.cookie('jczq_back_edit', j2);
			history.back()
        });
        //查看明细
        Y.C('_current_gg_type', this.get('#sgtypestr').val());
        this.getVSData();
        this.lib.PrixList();
    },  
    _dobuy: function (){
		
        //document.getElementById('buyform').submit();
	    //return TRUE;
		
		
        var Y = this, needMoney;
        if (needMoney = this.postMsg('msg-hm-check').data) {
			 
            this.postMsg('msg_login', function (){
							
                Y.checkMoney(needMoney, function (){
					if(Class.C('has_submit')){
					  //this.alert('已经提交您的订单，请稍候...', true, true);
					  return false;	
				    }
					Class.C('has_submit',true);
                    var data = Y.qForm('#buyform');
                    this.alert('正在提交您的订单，请稍候...', false, true);
				    this.ajax({
                        url: '/jczq_v/pute', 
                        type:'POST',
                        data: data,
                        encode: '',
                        end: function (data){
                            this.alert.close();
                            var info;
							if (!data.error) {
                                if (info = this.dejson(data.text)) {
                                    if (info.errcode == 0) {
                                        if (info.headerurl) {//成功跳转
                                            return location.replace(info.headerurl)
                                        }
                                    }
                                    this.alert(info.msg)//其它错误
                                }else{
                                    this.alert('服务器返回错误, 请刷新页面再重试!')
                                }
                            }else{
                                this.alert('服务器返回错误, 请刷新页面再重试!')
                            }
                        }
                    })                       
                })
            })
        }
    },
    getCodeData: function (){
        var str = this.get('#ratelist').val();
        return this.dejson('{'+str.split('/').map(function (a){
            return a.replace(/^(\d+)\|\d+/,'$1:')
                .replace(/([^\[,]+)#([^\],]+)/g,'"$1":"$2"')
                .replace(/\[/g,'{')
                .replace(/\]/g,'"}')
        }).join(',')+'}')
    },
    getVSData: function (){
        var o = this.C('choose_data'), data;
        if (!o) {
            o = [];
            if (data = this.getCodeData()) {
                this.get('#buyTable tr[mid]').each(function (tr){
                    var mid = tr.getAttribute('mid'),
                        idata = data[mid],
                        sg = [],
                        sp = [];
                    for(var k in idata){
                        sg.push(k);
                        sp.push(idata[k])
                    }
                    o.push({
                        "mid":mid,
                        "data":sg,
                        "selectedSP":sp,
                        "date":tr.cells[0].innerHTML,
                        "vs":tr.cells[1].innerHTML,
                        "choose":tr.cells[tr.cells.length-1].innerHTML,
                        "minSP":Math.min.apply(Math, sp),
                        "maxSP":Math.max.apply(Math, sp)
                    })
                });
                this.C('choose_data', o)                
            }
        }
        return o
    },
    createDlg: function (){//创建充值对话框
        this.addMoneyDlg =  this.lib.MaskLay('#addMoneyLay');
        this.addMoneyDlg.addClose('#addMoneyClose a','#addMoneyNo','#addMoneyYes');
        this.addMoney = function (fn, args){
            this.addMoneyDlg.pop(false, function (e, btn){
                    if (typeof fn === 'function' && btn.id == 'addMoneyYes') {
                        fn(args)
                    }
            })
        };
        this.confirmDlg = this.lib.MaskLay('#confirm_dlg','#confirm_dlg_content','#confirm_dlg_title');
        this.confirmDlg.addClose('#confirm_dlg_close a,#confirm_dlg_no,#confirm_dlg_yes');
        this.get('#confirm_dlg div.tips_title').drag('#confirm_dlg');
        var splitDlg = this.lib.MaskLay('#split_example');
        splitDlg.addClose('#split_close');
        Class.extend('showSplit', function (){
            splitDlg.pop()
        })
    },
    checkMoney: function (need, fn){//检查余额
	   
        this.ajax({
            url:'/user/ajax_user_virtual_money',
            end:function (data, i){
                var d;
				if (d = this.dejson(data.text)) {
					if (d.userMoney < need) {
						this.addMoney(function (){
                            window.open(Class.C('url-addmoney'))     
                        })
                    }else{
                        fn.call(this)
                    }
                }else{
                    this.alert('服务器返回错误, 请刷新页面再重试!')
                }
            }
        });
    } 
});