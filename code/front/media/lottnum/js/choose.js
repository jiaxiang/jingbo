(function (){
    var isdgTpl, iszhTpl, jxTpl, ishmTpl;

    jxTpl = '<li><span class="red">{1}</span> | <span class="blue">{2}</span></li>';

    iszhTpl = '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="faTable">'+
        '<tr><th>方案信息</th><td><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr class="tr1">'+
        '<td>玩法</td><td>追号期数</td><td>开始期号</td><td>单期注数</td>{$iszj}<td>追号总金额</td><td>中奖后自动停止</td></tr><tr>'+
        '<td>{$type}</td><td>共{$expectnum}期</td><td>{$startExpect}</td><td>每期{$zhushu}注</td>{$iszj2}<td>{$allmoney}元</td><td>{$stop}</td></tr>'+
        '</table></td></tr><tr><th>投注内容 </th><td class="t2"><div class="faContent" id="faContent2"  style="overflow:auto">{$codelist}</div></td></tr><tr><th>认购信息</th>'+
        '<td class="t2">您本次购买需消费<strong class="eng red">{$totalmoney}</strong>元</td></tr></table>';
    isdgTpl = '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="faTable">'+
        '<tr><th>方案信息</th><td><table width="100%" border="0" cellspacing="0" cellpadding="0">'+
        '<tr class="tr1"><td width="25%">玩法</td><td width="20%">注数</td><td width="20%">倍数</td>{$iszj}<td>总金额</td></tr>'+
        '<tr><td>{$type}</td><td>{$zhushu}</td><td>{$beishu}</td>{$iszj2}<td>{$totalmoney}元</td></tr></table></td></tr><tr><th>投注内容<br /></th>'+
        '<td class="t1"><div class="faContent" id="faContent2"  style="overflow:auto">{$codelist}</div></td></tr><tr><th>认购信息</th>'+
        '<td class="t2">您本次购买需消费<strong class="eng red">{$totalmoney}</strong>元</td></tr></table>';
    ishmTpl ='<table width="100%" border="0" cellspacing="0" cellpadding="0" class="faTable">'+
        '<tr><th>方案信息</th><td><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr class="tr1">'+
        '<td>玩法</td><td>注数</td><td>倍数</td>{$iszj}<td>总金额</td><td>每份</td><td>保底</td><td>提成</td><td>保密类型</td></tr><tr>'+
        '<td>{$play}</td><td>{$zhushu}</td><td>{$beishu}</td>{$iszj2}<td>{$allmoney}元</td><td>{$unitmoney}元</td><td>{$bdscale}</td><td>{$tc}%</td><td>{$hidetype}</td></tr>'+
        '</table></td></tr><tr><th>投注内容<br /></th><td class="t1"><div class="faContent" id="faContent"  style="overflow:auto">{$codelist}</div></td>'+
        '</tr><tr><th>认购信息</th><td class="t2">您本次认购份数为<strong class="eng">{$buymun}</strong>份，'+
        '需消费<strong class="eng red">{$needmoney}</strong>元</td></tr></table>';

	islimitTpl = '{$limitcode}存在限号';
    Class.C('url-addmoney', 'user/recharge');
    Class.C('min-rengou', .05);//最低认购
    Class.C('lr-max-line', 1000);//最多行数
    Class.C('useraccount', '/user');
    Class.C('netError', '由于网络不稳定, 您本次投注未能得到服务器的正常响应, 为避免重复投注给您造成损失, 请先到<a href="'+Class.C('useraccount')+'">帐户明细</a>确认您的本次投注是否成功!');

    Class.extend('checkMaxMoney', function (money, fn){//检测最大金额是否超出
        var limit, LM, pe;
        limit = this.getLimit();
        if (money > limit.max) {
        //this.getTip().show(showNode, '<h5>超过最大金额</h5>您好，单个方案最大金额为<strong style="color:red">'+Number(limit.max).rmb()+'</strong>元！').setIco(9);
            this.postMsg('msg_show_dlg',' 您好，单个方案最大金额为<strong style="color:red">'+Number(limit.max).rmb()+'</strong>元！')
            if (this.isFunction(fn)) {
                fn.call(this, money, limit.max)
            }
            return false
        }else{
            this.getTip().hide()
        }
        return true
    });
    Class.extend('moveToBuy', function (fn){//购买按钮可见
        var h, ph, a, b;
        h = this.getXY(this.one('#all_form'));
        ph  = this.getSize();
        a = Math.max(document.documentElement.scrollTop,document.body.scrollTop);
        c = h.y - ph.offsetHeight + 45 + this.get('#all_form').next('div').one().offsetHeight;
        if (false && a < c) {
            this.fx(function (f, i){
                document.documentElement.scrollTop = document.body.scrollTop = f(a,c)
            }, {end: fn})     
        }else{
            this.isFunction(fn) ? fn.call(this) : null
        }
    });
    Class.extend('getLimit', function (){//读取购买限额
        var l, limit;
        limit = Class.C('limit');
        if (!limit) {
            limit = [{//默认
                min: 2,
                max: 200000
            },{
                min: 15,
                max:300000
            }];
            if (l = this.get('#money_limit').val()) {
                l = l.replace(/\s/g,'').split(',');
                if (l[0]) {//防止为空
                    limit = [{
                        min: Yobj.getInt(l[0]),
                        max: Yobj.getInt(l[1], Number.MAX_VALUE)
                    },{
                        min: Yobj.getInt(l[2]),
                        max:Yobj.getInt(l[3], Number.MAX_VALUE)
                    }] 
                }
            }
           Class.C('limit', limit);//[{min,max},{}]
        }
        return Class.C('price') == 2 ? limit[0] : limit [1]
    });
    Class.extend('loadEndTime', function (){// 变换截止时间
       /* this.ajax({
            url:'/main/ajax/endtime.php',
            data:{
                lotid: this.get('#lotid').val(),
                playid: this.getPlayId(),
                expect: this.get('#expect').val()
            },
            end:function (data, i){
                var json;
                if (json = this.dejson(data.text)) {
                    Class.C('limit', [{min:Math.min(2, this.getInt(json.minmoney, 2)), max:this.getInt(json.maxmoney)||200000}, {min:Math.min(2, this.getInt(json.minmoney)), max:this.getInt(json.maxmoney)|| 200000}]);
                    this.postMsg('msg_endtime_change', json.endtime, json.servicetime)
                }
            }
        })*/
    });
    Class.extend('chkLimitCode', function (code, fn){
		fn.call(this);
		
/*
        var url, ischecking;//限号检查
        if (url = Class.config('limit-code-url')) {
            if (ischecking = Class.C('is-limit-check-ing')) {
                return this.alert('您好， 正在检查限号，请稍候...')
            }else{
                Class.C('is-limit-check-ing', true)
            };
			log(this.getPlayId());
			log('调用了限号!');
            this.ajax({
                url:url,
                type: 'POST',
                data: {
                    lotid: 5,
                    playid: this.getPlayId(),
                    expect: this.get('#expect').val(),
                    code: code
                },
                end:function (data, i){
                    var json;
                    Class.C('is-limit-check-ing', false);
                    var Y = this;
                    if (json = this.dejson(data.text)) {
                        if (json.code!=0) {
                            if (json.code == 1) {
                                this.alert(json.msg)
                            }else{
                                this.alert.close();
                                this.postMsg('msg_show_confirem', json.msg, function (e, btn){
                                     if (btn.id=='b2_dlg_yes') {
                                         fn.call(Y)
                                     }
                                });                                
                            }
                        }else{

                            fn.call(Y)
                        }
                    }
                }
            });        
        }else{
            fn.call(this)
        }   */    
    });
//对话框类
    Class('Dlg', {
        index:function (){
             //通用
		////alert("我被调用了1");
            this.dlg = this.lib.MaskLay('#info_dlg','#info_dlg_content');
            this.dlg.addClose('#info_dlg_close a,#info_dlg_ok');
            this.get('#info_dlg div.tips_title').drag('#info_dlg');
				////alert("我被调用了2");
        //确认
            //this.confirm = this.lib.MaskLay('#b2_dlg','#b2_dlg_content','#b2_dlg_title');
            //this.confirm.addClose('#b2_dlg_close a,#b2_dlg_no,#b2_dlg_yes');
            //this.get('#b2_dlg div.tips_title').drag('#b2_dlg');
			//alert("我被调用了3");
        //通用确认
            //this.confirm2 = this.lib.MaskLay('#confirm_dlg','#confirm_dlg_content','#confirm_dlg_title');
            //this.confirm2.addClose('#confirm_dlg_close a,#confirm_dlg_no,#confirm_dlg_yes');
            //this.get('#confirm_dlg div.tips_title').drag('#confirm_dlg');
			//alert("我被调用了4");
        //机选
            this.jxDlg =  this.lib.MaskLay('#jx_dlg','#jx_dlg_list');
            this.jxDlg.addClose('#jx_dlg_close a','#jx_dlg_re','#jx_dlg_ok');
            this.get('#jx_dlg div.tips_title').drag('#jx_dlg');
			//alert("我被调用了5");
        //合买确认
            this.isBuy = this.lib.MaskLay('#ishm_dlg','#ishm_dlg_content', '#ishm_dlg_title');
            this.isBuy.addClose('#ishm_dlg_close,#ishm_dlg_no,#ishm_dlg_yes');
            this.get('#ishm_dlg div.tips_title').drag('#ishm_dlg');
			//alert("我被调用了6");
        //胆拖拆分明细
            //this.splitDlg =  this.lib.MaskLay('#split_dlg','#split_dlg_list');
            //this.splitDlg.addClose('#split_dlg_close a','#split_dlg_ok');
            //this.get('#split_dlg div.tips_title').drag('#split_dlg');
			//alert("我被调用了7");
        //充值
            this.addMoneyDlg =  this.lib.MaskLay('#addMoneyLay');
            this.addMoneyDlg.addClose('#addMoneyClose a','#addMoneyNo','#addMoneyYes');
            this.get('#addMoneyLay div.tips_title').drag('#addMoneyLay');
			//alert("我被调用了8");
            this.bindMsg()
        },
        bindMsg: function (){
            this.onMsg('msg_show_dlg', function (msg, fn){
                this.dlg.pop.apply(this.dlg, arguments)
            });
            this.onMsg('msg_show_confirem', function (msg, fn){
                this.confirm.pop.apply(this.confirm, arguments)
            });
            this.onMsg('msg_show_is', function (msg, fn, title, btn2){
                if (title) {
                    this.confirm2.title.html(title)
                }
                this.get('#confirm_dlg_yes').val(btn2||'确定');
                this.confirm2.pop(msg, fn)
            });
        // 机选框
            this.onMsg('msg_show_jx', function (codeList, fn, tpl, noZero){
                var html, zhushu;
                zhushu = 0;
                tpl = tpl || jxTpl;
                html = codeList.each(function (arr, i){
                    if (!noZero) {
                        arr = arr.map(function (item){
                            return item instanceof Array ? String.zero(item.join(',')) : item
                        })
                    }
                    this[i] = tpl.format.apply(tpl, arr);
                    zhushu += arr[2]
                }, []);
                if(html.length > 10){
                	Y.get('#jx_dlg_list').setStyle('height','240px').setStyle('overflow','auto');
                }else{
                	var heightx = html.length*20+20;
                	Y.get('#jx_dlg_list').setStyle('height',heightx+'px').setStyle('overflow','hidden');
                }
                this.jxDlg.pop(html.join(''), fn)
            });
        // 机选框
            this.onMsg('msg_show_split', function (codeList, fn, tpl){
                var html, zhushu;
                zhushu = 0;
                tpl = tpl || jxTpl;
                html = codeList.each(function (arr, i){
                    this[i] = tpl.format(arr[0].join(' , ').replace(/\b\d\b/g,'0$&'), arr[1].join(' , ').replace(/\b\d\b/g,'0$&'), arr[2] instanceof Array ? arr[2].join(' , ').replace(/\b\d\b/g,'0$&') : '');
                    zhushu += arr[2]
                }, []);
                this.splitDlg.pop(html.join(''), fn)
            });
        //购买确认消息
            this.onMsg('msg_isbuy', function (msg, fn){
                this.isBuy.title.html(this.C('lot-ch-name') + '第' + this.get('#expect').val() + '期方案' + ['代购', '合买', '追号'][this.C('buy_type')]);
   				this.isBuy.pop.apply(this.isBuy, arguments);
		
            });
        //充值
            this.onMsg('msg_show_addmoney', function (fn, args){
                this.addMoneyDlg.pop(false, function (e, btn){
                    if (typeof fn === 'function' && btn.id == 'addMoneyYes') {
                        fn(args)
                    }
                    Yobj.postMsg('msg_close_addmoneydlg');
                })
            });
        }
    });
//合买表单类, 输出合买参数
    Class('HmOptions', {
        index:function (){
            var limit, yobj;
            limit = Class.C('min-rengou');
            yobj = this;
            yobj.low = 1;
            this.fs = this.fit = this.rg = 1;
            this.bd = 0;
            this.data = {beishu:0, zhushu:0, totalmoney:0};
        //份数
            this.fsInput = this.lib.DataInput({
                input:'#fsInput',
                initVal: 1,
                min:1,
                overflowFix:true
            });
            this.fsInput.onchange = function (){
                var list, d, fs;
                yobj.fs  = fs = this.getInt(this.val());
                this.need('#fsMoney').html((fs ===0 ? 0 : yobj.data.totalmoney / fs).rmb());
                d = yobj.getfitFs(yobj.data.totalmoney, fs);
                if (yobj.data.totalmoney < fs) {
                    this.need('#fsErr').html('每份金额必须大于等于1！').show()
                }else if(yobj.data.totalmoney > 0 && d!==fs){
                    this.need('#fsErr').html('每份金额不能除尽，请重新填写份数！').show();
                }else{
                    this.need('#fsErr').hide()
                }                
                yobj.fit = d;
                yobj.low = Math.ceil(fs*limit);
                this.postMsg('msg_fs_change', fs)
            };
            this.fsInput.onMsg('msg_list_change', function (data){
                yobj.data =data;
                this.val(yobj.data.totalmoney);
                this.onchange()
            });
			this.onMsg('msg_force_change_fs', function(fs) {
				this.fsInput.val(fs);
				this.fsInput.onchange();
			});
            this.fsInput.onchange();
        //认购
            this.rgInput = this.lib.DataInput({
                input:'#rgInput',
                initVal: 1,
                min:1
            });
            this.rgInput.onchange = function (){
                var d, fs, low;
                yobj.rg = fs = this.getInt(this.val());
                this.need('#rgMoney').html((fs === 0 || yobj.fs === 0 ? 0 : yobj.data.totalmoney / yobj.fs * fs).rmb());
                this.need('#rgScale').html(yobj.fs ===0 ? 0 : (fs/yobj.fs*100).toFixed(2));
                if (fs < yobj.low) {
                    this.need('#rgErr').html('您至少需要认购'+yobj.low+'份');//，共计'+(yobj.low * Class.C('price')).rmb()+'元！');
                }
                this.need('#rgErr').show(fs < yobj.low)
            };
            this.rgInput.onMsg('msg_fs_change',function (){
                this.val(yobj.low);
                this.onchange()
            });
			this.onMsg('msg_force_change_rg', function(rg) {
				this.rgInput.val(rg);
				this.rgInput.onchange();
			});
        //保底
            this.bdInput = this.lib.DataInput({
                input:'#bdInput',
                initVal: 0,
                min:1
            });
            this.bdInput.onchange = function (){
                var d, fs, sl;
                yobj.bd = fs = this.getInt(this.val());
                this.need('#bdMoney').html((fs ===0 ? 0 : yobj.data.totalmoney / yobj.fs * fs).rmb());
                sl = yobj.fs === 0 ? 0 : (fs/yobj.fs*100).toFixed(2);
                this.need('#bdScale').html(sl);
                this.need('#bdErr').show(this.one('#isbaodi').checked && sl < 20);
            };
            this.bdInput.onMsg('msg_fs_change',function (){
                if (this.get('#isbaodi').one().checked) {
                    yobj.need('#bdInput').val(Math.ceil(yobj.fs*.2))
                     this.onchange()
                }           
            });
            this.get('#isbaodi').click(function (){
                yobj.need('#bdInput').val(this.checked ? Math.ceil(yobj.fs*.2) : 0).nodes[0].disabled = !this.checked;
                yobj.bdInput.onchange()
            }).prop('checked', false);
            this.get('#bdInput').val(0);
			this.onMsg('msg_force_change_bd', function(isbd, bd) {
				if (+isbd) {
					this.bdInput.val(bd);
					this.get('#isbaodi').prop('checked', true);
					this.bdInput.onchange();
				}
				this.get('#bdInput').prop('disabled', !+isbd);
			});
            this.get('#moreCheckbox').click(function (){
                yobj.get('#case_ad,#hm_target').show(this.checked);
                yobj.moveToBuy();
            });
        //招股对象
            this.get('#dx2,#dx1').click(function (e, Y){
                yobj.get('#fixobj').show(this.id =='dx2');
                yobj.moveToBuy();
                if (this.id == 'dx2') {
                   // yobj.get('#fixobj textarea').one().select()
                }
            });
            yobj.get('#fixobj textarea').val('最多输入500个字符').focus(function (){
                if (this.value.indexOf('多输入500个字')>-1) {
                    this.value = ''
                }
            }).blur(function (){
                if (this.value.trim() =='') {
                    this.value = '最多输入500个字符'
                }
                if (this.value.length > 500) {
                    this.value = this.value.slice(0,500)
                }
            }).keyup(function (){
                if (this.value.length > 500) {
                    this.value = this.value.slice(0,500)
                }                
            });
            this.onMsg('msg_get_hm_param', function (data){
                return this.getParam(data)
            });
        },
        getfitFs: function (a, b){//计算适当份数
            while((a > b) && a/b - (a/b).toFixed(~~2) !== 0){b++};
            return Math.min(a, b)
        },
        getParam: function (data){
              var yobj, isshow, param, tmp;
              yobj = this;
            if (!this.one('#agreement_hm').checked) {
                 this.postMsg('msg_show_is', '<p style="text-align:center">您好, 您是否同意《用户合买代购协议》?</p>', function (e, btn){
                      if (btn.id === 'confirm_dlg_yes') {
                         yobj.one('#agreement_hm').checked = true ;
                         yobj.postMsg('msg_buy_hm', data)
                      }
                  }, false, '同意')
            }else if(this.get('#agreement_hm2').size() && !this.one('#agreement_hm2').checked){
                 var lot = Yobj.C('lot-ch-name');
                 this.postMsg('msg_show_is', '<p style="text-align:center">彩票发行中心对'+lot+'进行限号管理，您是否同意网站《'+lot+'投注风险须知》?</p>', function (e, btn){
                      if (btn.id === 'confirm_dlg_yes') {
                         this.one('#agreement_hm2').checked = true;
                         yobj.postMsg('msg_buy_hm', data)                         
                      }
                  }, lot+'投注风险须知', '同意') ;
            }else if (this.fs < 1) {
                 this.postMsg('msg_show_dlg', '每份金额必须大于等于1！', function (){
                     yobj.fsInput.input.doProp('select')
                 })
             }else if(this.fs > yobj.data.totalmoney){
                  this.postMsg('msg_show_dlg', '对不起, 您分成的每份金额不能小于1！', function (){
                     yobj.fsInput.input.doProp('select')
                 })            
             }else if (this.fs != this.fit) {
                  yobj.postMsg('msg_show_is', '&nbsp;&nbsp;&nbsp;&nbsp;您现在分成的份数除不尽方案总金额, 可能会造成误差, 系统建议您分成<strong style="color:red">'+this.fit
                      +'</strong>份, 要分成<strong style="color:red">'+this.fit+'</strong>份吗?', function (e, btn){
                      if (btn.id === 'confirm_dlg_yes') {
                         yobj.fsInput.val(yobj.fit);
                         yobj.fsInput.onchange();                      
                      }else{
                          yobj.fsInput.input.doProp('select')
                      }
                  }, '份数不能整除')
             }else if(this.rg < this.low){
                 this.postMsg('msg_show_dlg', '您至少要认购'+this.low+'份！', function (){
                     yobj.rgInput.input.val(yobj.low).doProp('select')
                 })
             }else if(this.rg > this.fs){
                 this.postMsg('msg_show_dlg', '您要认购的份数不能大于所分的份数！', function (){
                     yobj.rgInput.input.doProp('select')
                 })         
             }else if(this.one('#isbaodi').checked && this.getInt(this.one('#bdScale').innerHTML)<20){
                 var minrgfs =  Math.ceil(this.fs*.2);
                 this.postMsg('msg_show_dlg', '保底金额至少为总金额的20%,至少' +minrgfs + '份！', function (){
                      yobj.bdInput.input.val(minrgfs).doProp('select')
                 })
            }else{
                isshow = this.one('#gk1').checked ? 0 : (this.one('#gk2').checked ? 1 : (this.one('#gk3').checked ? 2 : 3));
                tmp = this.need('#caseInfo').one();
                var mfm = this.data.totalmoney/this.fs;
                return {//合买参数
                    allnum: this.fs,
                    buynum: this.rg,
                    isbaodi: this.one('#isbaodi').checked ? 1 : 0,
                    baodinum: this.bd,
                    isshow: isshow,
                    totalmoney: this.data.totalmoney,
                    money: mfm*(parseInt(this.rg) + parseInt(this.bd)),
                    tc_bili: this.get('#tcSelect').val(),
                    title: this.need('#caseTitle').val(),
                    content: tmp.value == tmp.defaultValue ? '' : tmp.value,
                    buyuser: this.one('#dx2').checked ? this.need('#fixobj textarea').val() : 'all',
                    isset_buyuser: this.one('#dx2').checked ? 2 : 1
                }  
            }
         }
    });
//单行追号
    Class('ZhLine', {
        index:function (wrap, data){
            var Y = this;
            this.chk = this.need(':checkbox', wrap);
            this.expect = this.chk.val();
            this.wrap = this.get(wrap);
            this.data =this.mix({}, data);
            var  lotid = this.get('#lotid').val(),
                len = (lotid == 3 || lotid == 28) ? 3 : 2;
            this.bsInput = new this.lib.DataInput({
                input:this.one(':text', wrap),
                min: 1,
                max: len==2?99:500,
                len: len,
                overflowFix: true
            });
            this.bsInput.onchange = function (){
                if (len==3 && this.val() > 500) {
                    this.val(500)
                }
                Y.data.beishu = this.getInt(this.val());
                Y.moneySpan.html((Y.data.beishu*Y.data.zhushu*Class.C('price')).rmb());
                Y.postMsg('msg_zhline_change');
            };
            this.moneySpan = this.need('span', wrap);
        // 响应号码列表框数据变化
            this.onMsg('msg_list_change', function (data){
                if (this.wrap.getStyle('display') == 'none' ) {
                    return false // 如果隐藏则中止消息下传
                }
                if (this.hasChange(data)) {//有变动的时候才更新
                    this.data.zhushu = data.zhushu;
                    if (this.chk.one().checked) {
                        this.bsInput.val(data.beishu);
                        this.data.beishu = data.beishu;
                        this.moneySpan.html(data.totalmoney.rmb());
                        Y.postMsg('msg_zhline_change');
                    } 
                }
            });
        // 响应追加注数变化
            this.onMsg('msg_update_list_dq', function (){
                if (this.wrap.getStyle('display') == 'none' ) {
                    return false // 如果隐藏则中止消息下传
                }
                if (this.chk.one().checked) {
                    this.moneySpan.html((this.data.zhushu*this.data.beishu*Class.config('price')).rmb());
                    Y.postMsg('msg_zhline_change');
                }
            });
            this.chk.click(function (e, y){
                var d;
                y.bsInput.input.nodes[0].disabled = !this.checked;
                if (this.checked) {
                   d = Y.postMsg('msg_get_list_data').data;
                    y.data.beishu = d.beishu;
                    Y.data.zhushu = d.zhushu;
                }else{
                    y.data.beishu = 0;
                }
                y.bsInput.val(y.data.beishu);
                y.moneySpan.html((this.checked ? Y.data.beishu*Y.data.zhushu*Class.config('price') : 0).rmb())
                y.postMsg('msg_zhline_change');
            })
        },
        hasChange: function (d){
           return !(d.beishu === this.data.beishu && d.zhushu === this.data.zhushu && d.totalmoney === this.data.totalmoney)
        },
        show: function (data){
            this.data = this.mix({}, data);
            this.chk.nodes[0].checked = true;
            this.bsInput.input.nodes[0].disabled = false;
            this.bsInput.val(data.beishu);
            this.moneySpan.html((data.beishu*data.zhushu*Class.config('price')).rmb());
            this.wrap.show();
        },
         hide: function (){
             this.wrap.hide()
         },
         getData: function (){
            return {
                expect: this.expect,
                 beishu: this.data.beishu
            }
         }
    });
//追号列表
    Class('ZhOptions', {
        index:function (inited){
            this.numOpts = this.need('#zh_opts');
            this.list = this.need('#zh_list');
            this.isstopChk = this.need('#zh_isstop');
            this.stopInput = this.need('#zh_stopInput');
            this.issmsChk = this.need('#zh_ismsn');
            this.agreementChk = this.need('#agreement_zh');
            this.createList();
            this.defineMsg();
            this.bindEvent();
            if (this.isFunction(inited)) {
                inited.call(this)
            }
        },
        defineMsg: function (){
           this.onMsg('msg_get_zh_param', function (data){
               if (!this.agreementChk.nodes[0].checked) {
                 this.postMsg('msg_show_is', '<p style="text-align:center">您是否同意《用户合买代购协议》?</p>', function (e, btn){
                      if (btn.id === 'confirm_dlg_yes') {
                         this.one('#agreement_zh').checked = true;
                         this.postMsg('msg_buy_zh', data)
                      }
                  }, '温馨提示' , '同意')
                }else if(this.get('#agreement_zh2').size() && !this.one('#agreement_zh2').checked){
                     var lot = Yobj.C('lot-ch-name');
                     this.postMsg('msg_show_is', '<p style="text-align:center">彩票发行中心对'+lot+'进行限号管理，您是否同意网站《'+lot+'投注风险须知》?</p>', function (e, btn){
                          if (btn.id === 'confirm_dlg_yes') {
                             this.one('#agreement_zh2').checked = true;
                             this.postMsg('msg_buy_zh', data)
                          }
                      }, lot+'投注风险须知', '同意') ;
                }else{
                    var param = this.getParam();
                    if (this.getInt(param.realnum) == 0) {
                        this.postMsg('msg_show_dlg', '您至少要追号 1 期！')
                    }else{
                        return param
                    }                     
                }
           });
           this.onMsg('msg_zhline_change', this.upBuyMoney.proxy(this).slow(100));
        },
        upBuyMoney: function (){//更新假定购买后的余额
            var beishu, p, need;
            p = this.postMsg('msg_get_list_data').data;// 号码框
            beishu = 0;
            if (p.zhushu>0) {//如果有号码,则计算追号注数
                this.lines.slice(0, 1).each(function (line, i){//只计算第一期
                    if (line.wrap.getStyle('display') != 'none') {
                        var d=line.getData();
                        beishu+=d.beishu             
                    }
                })
            }
            need = p.zhushu*beishu*Class.C('price');
            this.get('#buyMoneySpan2').html(need.rmb());
            this.get('#buySYSpan2').html(Math.max(0, Class.config('userMoney') - need).rmb());     
        },
        bindEvent: function (){
        // 追号下拉框
            this.numOpts.change(function (e,y){
                var data =  y.postMsg('msg_get_list_data').data;
                y.lines.each(function (line, i){
                    if (i < this.value) {
                        line.show(data)
                    }else{
                        line.hide()    
                    }
                }, this);
                y.postMsg('msg_zhline_change');
            });
        //短信通知
            this.isstopChk.click(function (e, Y){
                Y.stopInput.one().disabled = !this.checked;
                Y.stopInput.val(this.checked ? 1000 : 0);
            });
            this.stopVal = this.lib.DataInput({
                input:this.stopInput.one(),
                len:9,
                min:1,
                initVal: 0
            });
        },
        createList: function (){
               var tpl, html, start, code_list_data, last, myList, timer,Y, zi, len, tmp, expect;
               tpl = '<li style="display:{$show}"><em>{$index}</em><label style="color:{$hotcss}"><input type="checkbox" value="{$expect}" checked  /> {$expect}期 </label>'+
                   '<input type="text" class="i-a" value="{$beishu}" />倍 <span>{$totalmoney}</span>元</li>';
               html = [];
               code_list_data = this.postMsg('msg_get_list_data').data;
               tmp = this.one('#expect').value;
               len = tmp.length;
               start = this.getInt(tmp);
               last = this.getInt(this.need('#lastexpect').val());
               nextYear = Class.config('page-config').serverTime;
               for (var i = 0; i < 100; i++) {
                   expect = start+'';
                   if (expect.length < len) {//匹配期号长度, 不足前加0
                       expect = ('000000000000'+expect).slice(-len)
                   }
                   html.push(tpl.tpl({
                        index: (i<9 ? '0' : '') + (i+1) + '.',
                        hotcss: this.addHot(start,last),
                        expect: expect,
                        show: i > 9 ? 'none' : '',
                        totalmoney: this.getInt(code_list_data.totalmoney).rmb(),
                        beishu: code_list_data.beishu
                   }));
                   start++;
                   if (start-1 === last) {
                       if (!nextYear) {
                           break
                       }
                       start = +((this.getDate(nextYear).getFullYear()+1+'').slice(-2)+'001')//跨年期号
                   }
               }
               this.list.html(html.join(''));
               this.lines = [];
           //创建追号列表项对象
               this.get('li', this.list).each(function (li){
                   this.lines.push(this.lib.ZhLine(li, code_list_data))
               }, this);
               this.upBuyMoney()
         },
         addHot: function (expect,last){//期号标红
             var d = Class.config('divExpect');
             if (d) {
             	 if(expect > last){
             	 	expect = last + this.getInt((expect+'').slice(2));
             	 }
                 return expect - d[0] > (d[1] - 1) || expect < d[0] ? '' : 'red'
             }else{
                 return ''
             }
         },
         getParam: function (){
            var bl, el, beishu, list_data, real;
            bl = [];
            el = [];
            real = beishu = 0;
            list_data = this.postMsg('msg_get_list_data').data;// 列表数据
            this.lines.slice(0, this.numOpts.val()).each(function (line, i){
                if (line.wrap.getStyle('display') != 'none') {
                    var d=line.getData();
                    bl.push(d.beishu);
                    el.push(d.expect);
                    beishu+=d.beishu;
                    if (d.beishu>0) {
                        real++//有效期数
                    }                    
                }
            });
            return {// 合成追号数据
                beishu_list: bl.join(','),
                expect_list: el.join(','),
                ischase: 1,
                realnum: real,
                issms: this.issmsChk.one().checked ? 1 : 0,
                isone: this.isstopChk.one().checked ? 1 : 0,
                isstop: this.isstopChk.one().checked ? 1 : 0,//3d
                onemaxmoney: this.stopInput.val()
            }
         }
    });
//购买请求
    Class('BuySender', {
        index:function (){
           Class.C('expect', this.need('#expect').val());
           if (this.get('#case_ad textarea').size()) {
               this.lib.DataInput({
                    input:'#case_ad textarea',
                    type: 'default',
                    max: 200,
                    change: function (val){
                        var len, tip;
                        tip = this.input.next('span');
                        len = val.length;
                        tip.html('已输入'+len+'个字符，最多200个');
                    }
               })               
           };
           if (this.get('#case_ad input').size()) {
               this.lib.DataInput({
                    input:'#case_ad input',
                    type: 'default',
                    len: 20,
                    change: function (val){
                        this.input.next('span').html('已输入'+val.length+'个字符，最多20个')
                    }
               })               
           };
			//代购
            this.onMsg('msg_buy_dg', function (listParam){
                this.overflowMoney(listParam.totalmoney) && this.doDg(listParam)
            });   
			//合买
            this.onMsg('msg_buy_hm', function (listParam){//号码列表参数
                var hm = this.postMsg('msg_get_hm_param', listParam);// 取得合买参数
                 if (hm.data) {
                      this.overflowMoney(listParam.totalmoney) && this.doHm(listParam, hm.data)                 
                 }
            });

            this.onMsg('msg_buy_zh', function (listParam){
                var zh = this.postMsg('msg_get_zh_param', listParam);
                 if (zh.data) {
                     this.overflowMoney(listParam.totalmoney) && this.doZh(listParam, zh.data)
                 }
            });            
        },
        overflowMoney: function (totalmoney){
            if (this.C('isEnd')) {
                this.postMsg('msg_show_dlg', '您好，'+this.C('lot-ch-name')+this.C('expect')+'期已截止！');
                return false
            }
            var limit = Class.C('limit')[0];
            var type = this.getPlayText();
            if (totalmoney < limit.min) {
                 this.postMsg('msg_show_dlg', '您好，'+type+'的单个方案最小金额为'+Number(limit.min).rmb()+'元！');
                 return false
            }else if(totalmoney > limit.max){
                 this.postMsg('msg_show_dlg', '您好，'+type+'的单个方案最大金额为'+Number(limit.max).rmb()+'元！');
                 return false                
            }else{
                return true
            }
        }, 
        codeFormat: function (code){
            if (code.indexOf(']|[D:') > -1) {//dlt
                return code.split(';').map(function (str){
                    return str.replace(/^\[D:([\d,]+)\]\[T:([\d,]+)\]/g, '【<span class="red">前区|胆</span>】$1<br>【<span class="green">前区|拖</span>】$2<br>')
                    .replace(/\|\[D:([\d,]+)\]\[T:([\d,]+)\]/g, '【<span class="red">后区|胆</span>】$1<br/>【<span class="green">后区|拖</span>】$2')   
                }).join('<div class="line"></div>')
            }else if(code.indexOf('[D:')>-1){//ssq
                return code.split(';').map(function (str){
                    return str.replace(/\[D:([\d,]+)\]/g, '【<span class="red">胆</span>】$1<br>')
                    .replace(/\[T:([\d,]+)\]/g, '【<span class="green">拖</span>】$1<br>')
                    .replace(/\|([\d,]+)/g, '【<span class="blue">蓝</span>】$1')   
                }).join('<div class="line"></div>')
            }
            return code.replace(/\$/g, '<br/>')//other
        },
        doDg: function (list_param){
            var Y = this;
            if (!this.get('#agreement_dg').nodes[0].checked) {
                 this.postMsg('msg_show_is', '<p style="text-align:center">您是否同意《用户合买代购协议》?</p>', function (e, btn){
                      if (btn.id === 'confirm_dlg_yes') {
                         this.one('#agreement_dg').checked = true;
                         Y.doDg(list_param)//再次调用自己
                      }
                  }, '温馨提示', '同意')
            }else if(this.get('#agreement_dg2').size() && !this.one('#agreement_dg2').checked){
                 var lot = Yobj.C('lot-ch-name');
                 this.postMsg('msg_show_is', '<p style="text-align:center">彩票发行中心对'+lot+'进行限号管理，您是否同意网站《'+lot+'投注风险须知》?</p>', function (e, btn){
                      if (btn.id === 'confirm_dlg_yes') {
                         this.one('#agreement_dg2').checked = true;
                         Y.doDg(list_param)//再次调用自己
                      }
                  }, lot+'投注风险须知', '同意') ;
            }else{
				
					  this.getMoney(list_param, function (){
                      var param;
					
                      param = this.mix(this.getParam(), list_param);// 由列表参数+基本参数
				          if (Class.config('play_name') == 'lr') {
                          param.isdslr = 1;
                      }
					  
                      this.postMsg('msg_isbuy', isdgTpl.tpl({
                            iszj: param.lotid == 28 ? '<td width="100">追加</td>' : '',
                            iszj2: param.lotid == 28 ? '<td>'+(this.C('price') > 2 ? '是' : '否')+'</td>' : '',
                            expect: param.expect,
                            totalmoney: param.totalmoney.rmb(),
                            beishu:param.beishu,
                            zhushu:param.zhushu,
                            codelist: this.codeFormat(param.codes),
                            lot:Class.config('lot-ch-name'),                        
                            type: this.getPlayText()
                      }), function (e, btn){
								//点击  确认投注
					
                          if (btn.id == 'ishm_dlg_yes') {
							  // 是 <上传> 还是 <普通>
                              Class.config('play_name') == 'sc' ? Y.doSc(param) : Y.doBuy(param)           
                          }
                      })                  
                 })
            }
        },
			//合买
        doHm: function (list_data, hm_param){
             this.mix(list_data, hm_param);
             this.getMoney(list_data, function (){
                  var y, param, codes, ext;
                   y = this;
				
                  param = this.mix(this.getParam(), list_data);// 列表+合买+基本参数
				
                  codes = param.codes.replace(/D/g,'胆').replace(/T/g,'拖').split(';');
                  if (Class.config('play_name') == 'lr') {
                      param.isdslr = 1;
                  }
              //确认合买
                  this.postMsg('msg_isbuy', ishmTpl.tpl({
                        iszj: param.lotid == 28 ? '<td width="100">追加</td>' : '',
                        iszj2: param.lotid == 28 ? '<td>'+(this.C('price') > 2 ? '是' : '否')+'</td>' : '',
                        expect: param.expect,
                        play: this.getPlayText(),
                        zhushu: param.zhushu,
                        beishu: param.beishu,
                        allmoney: param.totalmoney.rmb(),
                        unitmoney: (param.totalmoney/ param.allnum).rmb(),
                        buymun: param.buynum,
                        buyscale: (param.buynum/param.allnum*100).toFixed(2),
                        needmoney: (param.totalmoney/param.allnum*param.buynum).rmb(),
                        baodi: param.baodinum,
                        bdscale: param.baodinum ? (param.baodinum/param.allnum*100).toFixed(2) + '%' : '未保底',
                        tc: param.tc_bili,
                        hidetype: ['完全公开','截止后公开','仅对跟单用户公开'][param.isshow] || '',
                        codelist: this.codeFormat(param.codes)
                  }), function (e, btn){
                      if (btn.id == 'ishm_dlg_yes') {
                               Class.config('play_name') == 'sc' ? y.doSc(param) : y.doBuy(param)                      
                      }
                  })                  
             })
        },
		// 追号
        doZh: function (list_data, zh_data){
             this.mix(zh_data, list_data);
             this.getMoney(list_data, function (){
                  var y, param, firstMoney;
                   y = this;
                  param = this.mix(this.getParam(), zh_data);
                  if (Class.config('play_name') == 'dq') {
                      param.codetype = 1;
                  }
                  var start = 0, allmoney = 0;
                  param.beishu_list.split(',').each(function (bs, i){
                      if (parseInt(bs)>0) {
                          if (!start) {
                              start = i;
                          }
                          allmoney += parseInt(bs)*param.zhushu*Yobj.C('price')
                      }
                  });
                  firstMoney = this.getInt(param.beishu_list.split(',')[0]) * param.zhushu * this.C('price'); // 第一期消费金额(可能为0)
                  this.postMsg('msg_isbuy', iszhTpl.tpl({
                        iszj: param.lotid == 28 ? '<td width="100">追加</td>' : '',
                        iszj2: param.lotid == 28 ? '<td>'+(this.C('price') > 2 ? '是' : '否')+'</td>' : '',
                        expectnum: param.realnum,
                        allmoney: allmoney.rmb(),
                        totalmoney: firstMoney.rmb(),
                        stop: param.isone == 0 ? '否'  : ('单期奖金≥<span style="red">'+zh_data.onemaxmoney+'</span>元'),
                        zhushu:param.zhushu,
                        lot:Class.config('lot-ch-name'),   
                        startExpect: param.expect_list.split(',')[start],
                        codelist: this.codeFormat(param.codes),
                        type: this.getPlayText()
                  }), function (e, btn){
                      if (btn.id == 'ishm_dlg_yes') {
                          y.doBuy(param)
                      }
                  })                  
             })
        },
		//单式上传
        doSc: function (param){//合买分支
	        Y=this;
            if (Class.C('buy-sending')) {return;}
            Class.C('buy-sending', true);
            param = this.mix(this.getParam(), param);//添加基本参数
				param2 = {
				"lottid":param.lotid,//彩种ID
				"znum":param.zhushu,//注数
				"wtype":param.playid,//玩法ID
				"codes":param.codes,//
				"ishm":param.ishm,//是否合买
				"qihao":param.expect,//期号
				"multi":param.beishu,//倍数
				"amoney":param.totalmoney,//总金额
				"pmoney":2,//每张价格
				"show":param.isshow,//合买设置：是否公开
				"tcratio":param.tc_bili,//提成比例
				"nums":param.allnum?param.allnum:1,//总份数
				"rgnum":param.buynum,//认购份数
				"omoney":""+1,//每份金额
				"bflag":param.isbaodi,//是否保底
				"bnum":param.baodinum,//保底份数
				"title":param.title,//方案标题
				"desc":param.content,//方案描述
				"isup":param.isup,
				"passlimit":param.passlimit//
					};
			 var paramObj = new Object();
			 paramObj.data = $.toJSON(param2);
            this.postMsg('msg_show_dlg', '正在提交您的订单, 请稍后...', false, true);
            var post = {
                form:'#suc_form',
                url: '/lotteryapi/orderprocess/order_fqds',
                data: paramObj,
                end: function (data){
                    var j;
                    if (j = this.dejson(data.text)) {

                        if (j.stat == 200 && j.headerurl) {
                           window.location.replace(j.headerurl);
                        }
						/*else if (j.stat==500)
						{
							
							param = this.mix(param, {passlimit:true});
							   this.postMsg('msg_isbuy', islimitTpl.tpl({
								limitcode:j.info
							  }), function (e, btn){
										//点击  确认投注
							
								  if (btn.id == 'ishm_dlg_yes') {
									  // 是 <上传> 还是 <普通>
										  Class.config('play_name') == 'sc' ? Y.doSc(param) : Y.doBuy(param)           
								  }
							  })
						}*/
						else{
							//this.postMsg('msg_show_dlg', j.info, function (){location.reload();});
							
							   
								this.postMsg('msg_show_dlg', j.info);
								if(j.stat==101){
									this.one("#sc_zs_input").focus();
								}
								
                        }
						Class.C('buy-sending', false);
                    }else{
                        this.postMsg('msg_show_dlg', Class.C('netError'), function (){
                            location.replace(Class.C('useraccount'));
                        });
                    }
                }
            }
            if (param.fid) {// 同步检测模式
                post.form = false;
            }
            this.sendForm(post);
        },
        getMoney: function (list_param, fn){//检查余额
            var money = list_param.money || list_param.totalmoney;//有合买与代购之分
            /*this.ajax({
                url:Class.config('root') + 'main/ajax/zcyh_index.php',
                end:function (data, i){
                    var d;
                    if (d = this.dejson(data.text)) {
                        if (d.userMoney < money) {
                        //充值d.userMoney, o.money
                            this.postMsg('msg_show_addmoney',function (){
                                window.open(Class.C('url-addmoney'))     
                            })
                        }else{
                            fn.call(this)
                        }
                    }
                }
            });*/
		
			fn.call(this)

        },
        getParam: function (info){
			//基本参数
            var base = {
                expect: this.need('#expect').val(),//得到期号
                lotid: this.need('#lottid').val(),//得到彩种ID
                playid: this.getPlayId(),//得到玩法号
                ischase: 0, //默认无追号
                isupload: 0,//默认无上传
                ishm: Class.config('buy_type') == 1 ? 1 : 0//是否合买
            };
			////是否定胆
            if (Class.config('hasddsh')) {
                base.hasddsh = 1;
                base.ddsh = Class.config('last-ddsh')
            };
			//单式提成比例
            if (this.get('#tcSelect').size() == 1){
                base.tc_bili = this.getInt(this.get('#tcSelect').val());
            } else {
                if (this.C('auto-ds-tc') !== false && (Class.config('play_name') == 'lr' || Class.config('play_name') == 'sc')) {
                    base.tc_bili = 4//单式的提成自动为4%, 如未指定
                }                
            }
            return base
         },
         doBuy: function (param){
			  //限号检测
			 //alert(param.codes);
              if (!this.C('stop-last-check-limit')) {
                  this.chkLimitCode(param.codes, function (){
                      this.lastBuy(param)
                  })                   
              }else{
                  this.lastBuy(param)
              }
         },
		 
         lastBuy: function (param){
			var url, type;
			Y=this;
			//得到购买状态，开始认为没有购买
			if (Class.C('buy-sending')) {return;}
			//设置标记为正在购买
			Class.C('buy-sending', true);
			//显示等待对话框
			//this.postMsg('msg_show_dlg', '正在提交您的订单，请稍后...', null, true);

			type = Class.config('play_name');             
			if (type == 'dq') {
			  delete param.codes
			}
		
			/*
			*参数转成JSON格式
			*/
			param2 = {
				"lottid":param.lotid,//彩种ID
				"znum":param.zhushu,//注数
				"wtype":param.playid,//玩法ID
				"codes":param.codes,//
				"ishm":param.ishm,//是否合买
				"qihao":param.expect,//期号
				"multi":param.beishu,//倍数
				"amoney":param.totalmoney,//总金额
				"pmoney":2,//每张价格
				"show":param.isshow,//合买设置：是否公开
				"tcratio":param.tc_bili,//提成比例
				"nums":param.allnum?param.allnum:1,//总份数
				"rgnum":param.buynum,//认购份数
				"omoney":""+1,//每份金额
				"bflag":param.isbaodi,//是否保底
				"bnum":param.baodinum,//保底份数
				"title":param.title,//方案标题
				"desc":param.content,//方案描述
				"passlimit":param.passlimit//
			};
			 var paramObj = new Object();
			 paramObj.data = $.toJSON(param2);

			 //根据类型来确定处理url
             url = type == 'lr' ? Class.C('dsfq') : Class.config('fsfq');

			
             this.ajax({
                 url: url,
                 type: 'POST',
                 data: paramObj,
                 end: function (data, i){
                        var j;	
						//转化返回值为JSON
                        if(j = this.dejson(data.text)){	
							Class.C('buy-sending', false);
							//stat为200表示成功
                            if (j.stat == 200) {//成功
                                this.postMsg('msg_buy_success');
						        if (j.headerurl) {
                                    location.replace(j.headerurl)//跳转
                                }else{
                                    this.postMsg('msg_show_dlg', j.info);
                                    this.postMsg('msg_update_userMoney');//刷新余额，如果跳转，可能被浏览器取消                            

                                }
                            }
                            /*else if (j.stat==500)
							{
			
							
								param = this.mix(param, {passlimit:true});
		
								   this.postMsg('msg_isbuy', islimitTpl.tpl({
									limitcode:j.info
								  }), function (e, btn){
											//点击  确认投注
										
									  if (btn.id == 'ishm_dlg_yes') {
										  // 是 <上传> 还是 <普通>

										  if(Class.config('play_name') == 'sc') {
										
											 Y.doSc(param);
										  }else{
							
											  Y.doBuy(param) ;
												  
										  }
									  }
								  })
							}*/
								else{//不成功
                                 this.postMsg('msg_show_dlg', j.info);
                                 
                            }
                        }else{
                            this.postMsg('msg_show_dlg', Class.C('netError'), function (){
                                location.replace(Class.C('useraccount'));
                            });
                        }
                    }
             });             
         }
    });
//球区选择
    Class('Choose', {
        startNum: 1,
        index:function (config){
            this.items = this.need(config.items);
            this.focusCss = config.focusCss || 'selected';
            this.killCss = config.killCss;// 有杀号功能
            this.hasKill = !!config.killCss;
            this.data = [];
            this.killData = [];
            this.addNoop('onchange, onbeforeselect');
            this.items.mousedown(function (e, Y){
                var isUnselect, o;
                o = Y.need(this);
                isUnselect = Y.hasKill ? Y.hasClass(this, Y.killCss) : Y.hasClass(this, Y.focusCss);// 是否取消选择行为
                if (isUnselect || !isUnselect && Y.onbeforeselect(this, Y.hasClass(this, Y.focusCss)) !== false) {//选中下一个前事件
                    if (Y.hasKill) {
                        if (Y.hasClass(this, Y.focusCss)) {
                            o.swapClass(Y.focusCss, Y.killCss)
                        }else if(Y.hasClass(this, Y.killCss)){
                            o.removeClass(Y.killCss)
                        }else{
                            o.addClass(Y.focusCss);
                        }
                    }else{
                        o.toggleClass(Y.focusCss);
                    }            
                    Y.change(this)                
                }
            });

            if (config.hoverCss) {
                this.items.hover(function (e, Y){
                    Y.get(this).addClass(config.hoverCss)
                },function (){
                     Y.get(this).removeClass(config.hoverCss)
                });            
            }

            if (config.group) {//组选按扭
                this.group = this.need(config.group);
                this.group.each(function (b, i){
                    this.need(b).mousedown(function (e, Y){
                        Y.batSelect(this.innerHTML.replace(/<[^>]+>/g,'').trim())
                    })
                }, this)
            }
            
            if (!isNaN(config.startNum)) {//有些彩种从0开始
                this.startNum = config.startNum
            }
        },
        change: function (){//变化时收集选与杀数组
            this.data = [];
            this.killData = [];
            this.items.each(function (el){//统计选中数
                if (this.hasClass(el, this.focusCss)) {
                    this.data.push(this.getInt(el.innerHTML))//选中组
                }else if(this.hasKill && this.hasClass(el, this.killCss)){
                    this.killData.push(this.getInt(el.innerHTML))//杀号组
                }
            }, this);
            this.onchange()
        },
        importCode: function (num, iskill){//导入号码
            num = typeof num == 'string' ? num.split(',') : num instanceof Array ? num : [];
            var css=iskill ? this.killCss : this.focusCss;
            num.each(function (i, j){
                var index, ball;
                index = this.getInt(i- this.startNum).range(0,1/0);
                if (ball = this.items.nodes[index]) {
                    this.get(ball).addClass(css)
                }
            }, this);
            this.change(null)
        },
        random: function (n, kill){// (6), 随机生成号码
            var n, l, rndCode;
            l = this.items.size();
            n = (~~n).range(1, l);
            this.clearCode();//清除胆码
            kill = kill || this.killData;
            rndCode = this.repeat(l, 1).remove(kill).random(-n);
            this.importCode(rndCode)//在剩余的号码中打乱后选出n个
        },
        batSelect: function (type){//按特征组选号
            var cmd, fn, odd;
            odd = this.startNum == 0 ? [0, 1] : [1, 0];
            switch(type){
            case '全': 
                cmd = 'return true';
                break;
            case '大': 
                cmd = 'return n > 5';
                break;
            case '小':
                cmd = "return n <= 5";
                break;
            case '奇':
                cmd = "return n % 2 == "+odd[0];
                break;
            case '偶':
                cmd = "return n % 2 == "+odd[1];
                break;
            default:// 清
                cmd = 'return false';
            }
            fn = new Function('n', cmd);
            this.items.each(function (el, i){
                if (fn(i+1)) {
                    this.need(el).addClass(this.focusCss)
                }else{
                    this.need(el).removeClass(this.focusCss)
                }
            }, this);
            this.change()
        },
        unselect: function (n){// 清除指定号码, n = string|number|array
            var n = this.isArray(n) ? n : [n];
            this.items.each(function (el){
                var c = this.getInt(el.innerHTML);
                if (n.indexOf(c) > -1) {
                    this.get(el).removeClass(this.focusCss).removeClass(this.killCss);
                }
            }, this);
            this.change()
        },
        killCode: function (el){
            this.get(el).removeClass(this.focusCss).addClass(this.killCss);
            this.change()        
        },
        clearCode: function (hasKill){//清空, 是否包含killCss
            this.items.each(function (el){
                this.need(el).removeClass(this.focusCss);
                if (hasKill && this.hasKill) {
                    this.need(el).removeClass(this.killCss)
                }
            }, this);
            this.change(null)
        }
    });
//号码列表
    Class('CodeList', {
        splitChar: ',',
        rightSplit: ',',
        noZero: false,
        lineTpl: '<span class="num ssq">{1}{2}<em class="blue">{3}</em></span><a href="javascript:void 0" class="del">删除</a>',
        index:function (config){
            var func;
            this.zhushu = this.totalmoney = 0;
            this.beishu = 1;
            this.panel = this.need(config.panel);
            this.bindEvent(config);
            this.msgId = config.msgId || '';
            this.stopRedraw = config.stopRedraw;//是否回显号码
            this.onMsg( 'msg_put_code_' + this.msgId, function (code){
				//log(this.msgId, code);
                this.addCode(code);
				return this.zhushu;
            });
            this.onMsg( 'msg_get_list_data_' + this.msgId, function (){
                return this.getData()
            });
             this.onMsg('msg_clear_code_' + this.msgId, function (){
                 this.clearLine();
             });
             this.onMsg('msg_update_list_' + this.msgId, function (){
                 this.change(this.zhushu);// 追加投注时同步命令
             });
             this.addStyle('.betList li.list-Selected{background-color:#D9F1FF}')
            this.tip = this.lib.NotifyIcon()
        },
        bindEvent: function (config){
            var Y = this, lotid = this.get('#lotid').val(),
                len = (lotid == 3 || lotid == 28) ? 3 : 2;//双色球大乐透开放500倍
            this.zsInput = new this.lib.DataInput({
                input: config.bsInput,
                len: len,
                max: 500,
                min: 1,
                initVal:1
            });
        //倍数变化
            this.zsInput.onchange = function (){
                if (len == 2 ) {
                    if (Class.C('buy_type') == 2  && this.val() > 99) {
                        this.val(99)
                    }                    
                }else{
                    if (this.val() > 500) {
                        this.val(500)
                    }                    
                }
                Y.beishu = Y.getInt(this.val());
                Y.change(Y.zhushu)
            };
			this.onMsg('msg_force_change_bs', function(bs, zs) {
				this.zsInput.val(bs);
				this.zhushu = zs;
				this.zsInput.onchange();
			});
            this.onMsg('toggle-zh', function (){
              //  this.zsInput.onchange()
            });
            this.moneySpan = this.need(config.moneySpan);
            this.zsSpan = this.need(config.zsSpan);
            this.clearBtn = this.need(config.clearBtn);
            this.clearBtn.click(function (e, Y){
                Y.clearLine();
            });
        //选中行
            this.prevSelectedLine = null;
            this.panel.live('li', 'click', function (e, y){
                if (!Y.prevSelectedLine || Y.prevSelectedLine != this) {
                    Y.get(Y.prevSelectedLine).removeClass('list-Selected').get(this).addClass('list-Selected');
                    Y.prevSelectedLine = this
                }
                if (!Y.stopRedraw) {
                    Y.postMsg('msg_redraw_code', Y.get(this).data('code'))
                }            
            })
        },
        addCode: function (code){
            var one, li;
            if (code.length) {
                if (!this.isArray(code[0])) {
                    code = [code]
                }
                for (var i = 0, j = code.length; i < j; i++) {
                    one = code[i]; // [red, blue, count];
                    li = this.createLine(one);
                    li.data('code', one.slice());
                    li.setStyle('cursor:pointer');
                    this.need('a', li).click(function (e, Y){
                        Y.removeLine(Y.get(this).parent(function (el){
                            return el.nodeName.toLowerCase() == 'li'
                        }));
                        e.stop();
                        e.end();
                        return false
                    })
                }
                this.change(this.getCount())
            }
        },
        createLine: function (code){//创建一行
            return this.createNode('LI', this.panel).html(this.lineTpl.format(String.zero(code[0].join(',')), this.splitChar, String.zero(code[1].join(this.rightSplit))));
        },
        removeLine: function (li){//删除一行
            if (li == this.prevSelectedLine) {
                this.prevSelectedLine = null
            }
            this.removeNode(li);
            this.change(this.getCount())
        },
        clearLine: function (){//清空列表
            this.panel.empty();
            this.change(0);
            this.get('#ai_all_zs').html(0);//过滤用到
            this.prevSelectedLine = null
        },
        change: function (zhushu){//变化
            this.zsSpan.html(zhushu);
            this.zhushu = zhushu;
            this.totalmoney = this.zhushu*this.beishu*Class.config('price');
            this.moneySpan.html(this.totalmoney.rmb());
            this.checkMaxMoney(this.totalmoney);

            this.postMsg('msg_list_change', {
                zhushu: zhushu,
                beishu: this.beishu,
                totalmoney: this.totalmoney
            })// 广播注数变化消息, 购买选项类应该监听这个消息
        },
        getCount: function (){//计算总注数
            var Y = this;
            return this.get('li', this.panel).nodes.reduce(function (a, b){
                return a + Y.attr(b, 'code').slice(-1)[0]//总是把注数放到最后一个元素
            }, 0)
        },
        formatCode: function (d){
            return '{1}|{2}'.format(d[0].join(','), d[1].join(','))
        },
        getData: function (){//03,07,10,18,21,22|08$10,13,15,18,20,25,30|05,08,15
            var arr = [];
            this.get('li', this.panel).each(function (a){
                var d = this.get(a).data('code');
                arr.push(this.formatCode(d))
            }, this);
            return {
                codes: this.noZero ? arr.join(';') : String.zero(arr.join(';')),
                zhushu: this.zhushu,
                beishu: this.beishu,
                totalmoney: this.totalmoney
            }
        }
    });
//选择基础类
    Class('Choose_base', {
        index:function (config){
            this.putBtn = this.get(config.putBtn).concat(this.get(config.aiBtn).nodes);
        //接收随机选号命令
            this.onMsg('msg_rnd_code_'+config.msgId, function (){
                this.random(this.rndOpts.val());
            });
             this.onMsg('msg_clear_code_'+config.msgId, function (){
                 this.clearCode();
             });
             this.onMsg('msg_redraw_code_'+config.msgId, function (code){
                 this.redrawCode(code);
             });
             this.onMsg('msg_get_choose_code_'+config.msgId, function (isKeepCode){
                 return this.getChooseCode(isKeepCode);
             });
             this.onMsg('msg_update_list_' + this.msgId, function (){
                 this.updateShow();// 追加投注时同步命令
             });
             this.addNoop('redrawCode,getChooseCode');//子类重载
         //遗漏
             if (config.yl) {
                 config.yl.each(function (o){
                     this.loadYL(o)
                 }, this)
             }
        },
        highlightBtn: function (zs){
            if (zs) {
               this.putBtn.addClass('s-ok-sp')
            }else{
               this.putBtn.removeClass('s-ok-sp')
            }
        },
        random: function (n){// 随机生成号码, [[red],[blue]]
            var a, b, code, id;
            n = ~~n;
            code = [];
            a = this.leftMax ? this.repeat(this.leftMax, 1) : false;
            b = this.rightMax ? this.repeat(this.rightMax, 1) : false;
            for (var i = n; i--;) {
                code[i] = [];
                if (a) {
                    code[i].push(a.random(-this.leftNum).sort(Array.up))
                }
                if (b) {
                    code[i].push(b.random(-this.rightNum).sort(Array.up))
                }
                code[i].push(1)
            }
            id = this.msgId;
            this.postMsg('msg_show_jx', code, function (e, btn){
                  if (btn.id == 'jx_dlg_re') {
                        this.postMsg('msg_rnd_code')
                   }else if(btn.id == 'jx_dlg_ok'){
                        this.postMsg('msg_put_code', code);//广播号码输出消息, 号码列表监听此消息    
                   }
            }, this.rndtpl)                
        },
        loadYL: function (o){// 加载遗漏[xml, 呈现节点, 宽度(排列型用到), 取属性名]
            var yl, Y;
            Y = this;
            o.url = o.xml;    
            if (yl = Class.config(o.url)) {
                setYLVal(yl, o)          
            }else{
                this.ajax({
                    url:o.xml,
                    end:function (data, i){
                        var yl = [], max, dom;
                        this.qXml('//row', data.xml, function (node, x){
                            yl.push(node.items)
                        });
                        Class.config(o.xml, yl)//缓存到全局
                        setYLVal(yl, o);// yl is Array
                    }
                });                
            };
            function setYLVal(yl, o){
                var len, max, curMax, vals;
                yl = yl.slice();
                if (o.sort) {
                    yl.sort(function (a, b){
                        return parseInt(a[o.sort]) - parseInt(b[o.sort]) > 0 ? 1 : -1
                    })
                }
                max = [];
                offset = o.offset || 0;
                name = o.name || 'curyl';
                vals = yl.map(function (item){//按属性名映射出值
                    return Math.round(item[name])
                }).slice(offset);
                len = vals.length;
                width = ~~o.width || len;
                for (var i = 0; i < len; i+=width) {//多位排列进行折算行最大值
                    max.push(Math.max.apply(Math.max,vals.slice(i, i+width)))
                }
                  Y.get(o.dom).each(function (el, i){//填充到页面
                    if (i in vals) {
                        el.innerHTML = vals[i];
                        curMax = max[Y.getInt(i/width)];
                        el.style.color = vals[i] == curMax ? 'red' : '#B1B1B1'                    
                    }
                });            
            }
        }
    });
//双色球选号器
    Class('Choose_base>Choose_pt', {
        showTxt:'【您选择了<b class="red"> {$dan} </b>个红球，<b class="red">  {$blue} </b>个蓝球，共<b class="red"> {$zhushu} </b>注，共<b class="red"> {$totalmoney}元</b> 】',
        noCodeMsg: '您好，请您至少选择6个红球和1个蓝球！',
        leftNum: 6,
        rightNum: 1,
        leftMax: 33,
        rightMax: 16,
        leftChooseMax: 20,
        leftname: '红球',
        index:function (config){
            var red, blue, showbar, Y;
            Y = this;
            this.msgId = config.msgId || '';
            this.red = red = this.lib.Choose(config.red);
            this.blue = blue = this.lib.Choose(config.blue);
            this.leftChooseMax = config.leftChooseMax || this.leftChooseMax;
            this.red.onbeforeselect = function (ball){
               if (this.data.length > Y.leftChooseMax-1) {
                   this.postMsg('msg_show_dlg', '您好, ' + Y.leftname+ '最大可选个数为' +Y.leftChooseMax+'个！');
                   return false
               }
            };
            showbar = this.need(config.showbar);
            this.addNoop('onchange')
            this.updateShow = red.onchange = blue.onchange = function (){// 红蓝选择有变化时
                var zhushu, info;
                zhushu = Y.getCount();
                info = {
                    dan: red.data.length,
                    kill: red.killData.length,
                    blue: blue.data.length,
                    zhushu: zhushu,
                    totalmoney: (zhushu*Class.config('price')).rmb()            
                };
                Y.highlightBtn(info.zhushu);
                if (showbar) {// 刷新显示板
                    showbar.html(Y.showTxt.tpl(info, '0'))
                }
                Y.onchange(info)
            };
            this.bindEvent(config);
            this.base(config)
        },
        bindEvent: function (config){
            var red_rnd_sel, blue_rnd_sel, all_rnd_sel, Y;
            Y = this;
        //输出按扭
            Y.get(config.putBtn).click(function (){
                var code, count;
                count = Y.getCount();
                if (Y.leftMax==33 && count*Class.C('price') > 100000) {
                    return Y.alert('您好， 单个方案金额不能超过10万元！')
                }
                if (Y.checkMaxMoney(count*Class.C('price')) ){
                    if(count > 0) {
                        code = Y.getChooseCode();
                        Y.postMsg('msg_put_code', code);//广播号码输出消息, 列表框应该监听此消息
                    }else if(Y.red.data.length == 0 && Y.blue.data.length == 0){
                        Y.postMsg('msg_show_dlg', '您好，请您至少选择一注投注号码！')
                    }else{
                        Y.postMsg('msg_show_dlg', Y.noCodeMsg)
                    }             
                }           
            });
        // 随机选取
            red_rnd_sel = this.need(config.red.rndSelect);
            blue_rnd_sel = this.need(config.blue.rndSelect);
            this.rndOpts = all_rnd_sel = this.get(config.rndSelect);
            Y.need(config.red.rndBtn).click(function (){
                Y.red.random(red_rnd_sel.val());
                return false
            });
            Y.need(config.blue.rndBtn).click(function (){
                Y.blue.random(blue_rnd_sel.val());
                return false
            });
            Y.get(config.rndBtn).click(function (){
                Y.random(all_rnd_sel.val());
                return false            
            });
           Y.onMsg('msg_rnd_ssq_'+this.msgId, function (fn){//智能过滤时对未选号码进行自动选号, 1w注内
                Y.red.random(14);  
                Y.blue.random(3);
                fn && fn(Y.red.data, Y.blue.data)     
           })
       // 清除
           Y.need(config.red.clearBtn).click(function (){
                Y.red.clearCode(true)
            });
            Y.need(config.blue.clearBtn).click(function (){
                Y.blue.clearCode(true)
            }); 
            Y.get(config.clearBtn).click(function (){
                Y.clearCode()
            }); 
        },
        getChooseCode: function (isKeepCode){
            var code = [[this.red.data.slice(), this.blue.data.slice(), this.getCount()]];
            if (!isKeepCode) {
                this.red.clearCode(true);
                this.blue.clearCode(true);
            }
            return code    
        },
        clearCode: function (){
            this.blue.clearCode(true);
            this.red.clearCode(true)            
        },
        getCount: function (){//计算注数
            var r, b;
            r = this.red.data.length;
            b = this.blue.data.length;
            return r<this.leftNum || b<this.rightNum ? 0 :  Math.c(r, this.leftNum) * Math.c(b, this.rightNum)
        },
        redrawCode: function (code){//重现号码
            this.clearCode();
            this.red.importCode(code[0]);
            this.blue.importCode(code[1])
        }
    });
//扩展节点方法
    Y.fn.selectLine = function (n){
        var codes, s1, s2, count, startPos, endPos, node, r;
        if (node = this.one()) {
            codes = (node.value + "\n").replace(/\n+$/, "\n");
            s1 = codes.match(eval("/^(.+\\n){" + (n - 1) + "}/ig"));
            if (s1) {
                s2 = codes.match(eval("/^(.+\\n){" + n + "}/ig"));
                count = codes.match(/.+\n/ig).length + 5;
                startPos = s1[0].length;
                endPos = s2[0].length;
                if (node.createTextRange) {
                    r = node.createTextRange();
                    r.collapse();
                    r.moveStart('character', startPos - n + 1);
                    r.moveEnd('character', endPos - startPos - 1);
                    r.select();
                } else {
                    node.selectionStart = startPos;
                    node.selectionEnd = endPos;
                    node.scrollTop = node.scrollHeight / count * (n - 1);
                    node.focus();
                }
            }        
        }
        return this
    };
//单式录入类
    Class('Choose_base>CodeEditor', {
        leftNum: 6,//最少号码
        rightNum: 1,
        leftMax: 33,//候选号码
        rightMax: 16,
        codeTest: /^(?:0?[1-9]|[12][0-9]|3[0-3])(?:[, ](?:0?[1-9]|[12][0-9]|3[0-3])){5}[\|\+](?:0?[1-9]|1[0-6])$/,

        index:function (ini){
            this.addNoop('getChkCode');
            this.maxLine = Class.C('lr-max-line') || 1000;
            this.editor = this.need(ini.textarea);
            this.msgId = ini.msgId;
            this.lr_num = this.need(ini.lr_num);
            this.putBtn = this.need(ini.putBtn);
            this.clearBtn = this.need(ini.clearBtn);
            this.rndOpts = this.need(ini.rndSelect);
            this.rndBtn = this.need(ini.rndBtn);
            this.bindEvent();
            this.defineMsg();
            this.base(ini);
        },

        bindEvent: function (){
            var Y = this, checkTimer;
            this.editor.focus(function (e){
                 if (this.value.match(/[a-z]/i)) {
                    this.value = ''
                }           
                this.style.color = '#333';
                checkTimer = setInterval(function() {
                    Y.showLine()
                },100);
            }).blur(function (){
                if (this.value.trim() == '') {
                    this.value =  this.defaultValue
                }
                this.style.color = '#999';
                clearInterval(checkTimer);
            }).keydown(function (e){
                if (!e.ctrlKey && e.keyCode > 64 && e.keyCode < 91) {
                    return false
                }
            })
            this.putBtn.click(function (){
                var code = Y.getCode();
                if (code) {
                    Y.chkLimitCode(Y.getChkCode(code), function (){
                        Y.postMsg('msg_put_code', code);
                        Y.clearCode();                    
                    })
                }
            });
           this.rndBtn.click(function (){
                Y.random(Y.rndOpts.val());
                return false            
            });
       // 清除
           this.clearBtn.click(function (){
                Y.clearCode()
            });
        },

        defineMsg: function (){
             this.onMsg('msg_clear', function (){
                 this.clearCode();
             });
        },

        getTester: function (){//匹配更多的动态项
            return this.codeTest
        },

        getCode: function (){
            var codes, llines, val, msg, tmp;
            codes = [];
            val = this.editor.val().trim();
            if (val == '' || val == this.editor.one().defaultValue) {
                this.postMsg('msg_show_dlg','您好，请您输入号码！');
            }else{
                lines = val.split('\n');
                if (lines.length > this.maxLine) {
                    this.postMsg('msg_show_dlg','您好, 手动录入号码已超过' + this.maxLine + '行，请删除多余行或者选用txt文件上传！');
                    return false
                }
                msg='';
                lines.each(function (a, b){
                    var t = this.format(a), _code;
                    if(!this.getTester().test(t)){
                        msg = '号码格式有误，请检查！';
                    }else if(this.isReCode(t)){
                        msg = '号码中有重复数字，请检查！';
                    }
                    if(msg != ''){
                       this.postMsg('msg_show_dlg', "您好, 您输入的第"+(b+1)+"行"+msg, (function (){
                           this.editor.selectLine(b+1)
                       }).proxy(this));
                      return false;
                    }
                    tmp = t.split(',');
                    _code = [tmp[0].split(','), 1];
                    if (tmp[1]) {
                        _code.splice(1,0, tmp[1].split(','))//某些彩种没有前后两组号码
                    }
                    codes.push(_code)
               }, this);
               return msg ? false : codes
            }  
        },

        format: function (str){
            return str.trim().replace(/\s*[+|]\s*/g,',').replace(/ +/g, ',').split(',').map(function (x){
                return x.split(',').sort(function(a,b){return parseInt(a, 10)>parseInt(b, 10)?1:-1}).join(',').replace(/\b\d\b/g,'0$&')
            }).join(',')        
        },

        redrawCode: function (code){//重现号码
            this.clearCode();
            this.editor.val(code[0]+(this.leftNum >0 && this.rightNum >0 ? ','+code[1] : ''));
            this.showLine(1);
        },

    // 重复号码检查
        isReCode: function (str){
            var error;
            str.split(',').each(function (s){
                if (/\b(\d+),\1\b/g.test(s.split(',').sort(function(a,b){return a>b?1:-1}).join(','))) {
                    error = true;
                    return false
                }
            });
            return error
        },

        clearCode: function (){
           this.editor.val(this.editor.one().defaultValue);
           this.showLine(0)        
        },

        showLine: function (n){
            var s = this.editor.val().replace(/^\s*$/gim,'');
            var zs = isNaN(n) ? (s=='' ? 0 : s.split('\n').length) : n;
            this.lr_num.html(zs);
            this.highlightBtn(zs);
        }
    });
//单式上传类
    Class('DsUpload', {
        state: {},
        index:function (config){
            this.addElements(config);
            this.defineMsg();
        },

        addElements: function (config){
            var Y = this;
            this.moneySpan = this.need(config.moneySpan);
            this.scChk = this.need(config.scChk);
            this.upfile = this.need(config.upfile);
            this.reBind();
            if (!this.C('isDsChk')) {//如果是原始方式上传
                this.scChk.click(function (e, Y){//显示稍候上传说明
                    Y.get(config.upfile).parent().hide(this.checked);
                    Y.get('#uphelp').hide(this.checked);
                    Y.clearFileInput('#upfile');
                    Y.postMsg('msg_toogle_nosc', this.checked)//同步购买方式
                });                
            }
            this.zsInput = new this.lib.DataInput({
                input: config.zsInput,
                initVal: 0,
                min:0
            });
            this.bsInput = new this.lib.DataInput({
                input: config.bsInput,
                initVal: 1,
                min:1
            });
            var sInput = this.bsInput.input;
            this.priceChange = this.bsInput.onchange = this.zsInput.onchange = function (){
                var limit, data = {
                    zhushu: Y.getInt(Y.zsInput.val()),
                    beishu: Y.getInt(Y.bsInput.val()),
                    totalmoney:Y.getInt(Y.zsInput.val()*Y.bsInput.val()*Class.config('price'))
                }
                Y.moneySpan.html((data.totalmoney).rmb());
                Y.postMsg('msg_list_change', data);
                limit = this.getLimit();
                var base = this.input.getXY().x > 10 ? this.input : sInput;
                if(base.getXY().x < 10){return;}
                if (data.totalmoney < limit.min) {
                    Y.getTip().show(base,'<h5>投注金额限制</h5>您发起的方案金额不能少于'+limit.min.rmb()+'元, 请修改!').setIco(3);
                }else if(data.totalmoney > limit.max){
                    Y.getTip().show(base,'<h5>投注金额限制</h5>您发起的方案金额不能大于'+limit.max.rmb()+'元, 请修改!').setIco(3);
                }else{
                    Y.getTip().hide()
                }
            }
        },
        
        defineMsg: function (){
            this.onMsg('msg_check_sc_err', function (){// 检查上传表单
                var err, file, input, zs, bs, money, min, max, pe;
                file = this.one('#upfile');
                zs = this.getInt(this.zsInput.val());
                bs = this.getInt(this.bsInput.val());
                money = zs*bs*pe;
                limit = this.getLimit();
	
                if (!this.scChk.one().checked) {
                    var hasFile = file.value;
                    if (!hasFile) {
                         err = this.state.hasupload ? '您好，您刚才上传的文件有错误，请修改后重新上传!' :
                             '您好，请选择要上传的方案文件！'
                    }else if(!hasFile.match(/\.te?xt$/i)){
                         this.clearFileInput(file);
                         this.one('#upfile').focus();
                         err =  '您好，上传文件只支持txt格式，请重新选择文件上传！'
                    }
                } 
                if(!err){
                    if (!zs) {
                        err = '您好，您发起方案的注数不能为0！';
                        input = this.zsInput;
                    }else if (!bs) {
                        err = '您好，您发起方案的倍数不能为0！';
                        input = this.bsInput;
                    }else if(money < limit.min){
                        err = '您好，您发起方案的金额不能小于'+limit.min.rmb()+'元！';
                        input = this.bsInput;                
                    }else if(money > limit.max){
                        err = '您好，您发起方案的金额不能大于'+limit.max.rmb()+'元！';
                        input = this.bsInput;                
                    }                 
                }
                if (err) {
                    this.postMsg('msg_show_dlg',  err, function (){
                        input && input.input.one().select()
                    });
                } 
		
                return !!err
            });
            this.onMsg('msg_get_list_data_sc', function (){
				
                var after = this.scChk.one().checked,
                    param =  {
					isup:after ? 0 : 1,
                    codes: after ? '稍后上传' : '文本文件上传',
                    isupload: this.scChk.one().checked ? 0 : 1,
                    zhushu: this.getInt(this.zsInput.val()),
                    beishu: this.getInt(this.bsInput.val()),
                    totalmoney:this.getInt(this.zsInput.val()*this.bsInput.val()*Class.config('price'))
                }

                if (this.C('isDsChk') && !after) {//只有检测模式中的上传有这个参数
                    param.fid = this.state.fid;
                }
				return param;
            });
             this.onMsg('msg_update_list_sc', function (){
                 this.priceChange();// 追加投注时同步命令
             });
             this.onMsg('msg_clear_code_sc', (function (){
                 this.clearCode();
             }).proxy(this))
        },

        clearCode: function (){
            this.zsInput.val('');
            this.bsInput.val(1);
            this.clearFileInput('#upfile');
            this.moneySpan.html('￥0.00');
            this.scChk.one().checked = false;
            this.get('#uphelp').show();
            this.get('#upfile').parent().show();
            this.postMsg('msg_list_change', {
                zhushu: 0,
                beishu: 1,
                totalmoney: 0
            });
            Yobj.getTip().hide();
            this.clearOther();
        },
        clearOther: function(){},

        clearFileInput: function (f){
            var f = this.one(f);
            if (this.ie) {
                f.outerHTML = f.outerHTML
            }else{
                f.value = ''    
            }
            this.reBind();
        },

        reBind: function (){
            var self = this;
            this.one('#upfile').onchange = function (){
                var file = this;
                if(!this.value.match(/\.te?xt$/i)){
                     self.clearFileInput(this);
                     self.alert('您好，上传文件只支持txt格式，请重新选择文件！');
                }else{
                    Yobj.getTip().show(this.parentNode,'<h5>选择方案文件</h5>您待上传文件为: <span style="color:blue">'+ this.value.replace(/^.*\\/g,''), 3000+'</span>').setIco(10);
                }
            } 
        }
    });
//同步检测单式上传类
    Class('DsUpload>DsChkUpload', {
        index: function (opts){
            this.base(opts);
            this.get('#wait_info').show();
            var self = this;
            this.get('#up_info').live('strong', 'mouseover', function (){
                self.tipErr(this);
            });
            this.get('#up_stop').click(this.stop);
        },
        stop: function (){
           win = document.getElementById('yclass_send_iframe');
           if (win && confirm('有一个方案文件正在上传，您确定要取消上传吗?')) {
               Yobj.C('user-cancal', true);
               win.src = 'about:blank';
           }
        },
        tipErr: function (el){
            if(!el){return;}
            var err = el.getAttribute('data-err');
            if (err) {
                Yobj.getTip().show(el,'<h5>方案内容错误</h5>'+err, 3000).setIco(2);
            }	    
        },
        clearOther: function (){
            this.state = {};
            this.get('#wait_info').show();
            this.get('#upfile_view').hide();
            this.get('#loadzs').html('您选择了0');
        },
        reBind: function (){
            var self = this;
            this.one('#upfile').onchange = function (){
                var file = this;
                if(!this.value.match(/\.te?xt$/i)){
                     self.clearFileInput(this);
                     self.one('#upfile').focus();
                     self.alert('您好，上传文件只支持txt格式，请重新选择文件！');
                }
				
				/*else if(self.state.loading){
                    self.alert('您好，有文件正在上传，请稍候...')
                }else if(self.state.fid){
                    var dlg = self.confirm('您好，重新上传文件会覆盖以前的文件，您确定要重新上传吗?', false, '重新上传');
                    dlg.onclose = function (e, btn){
                        if(btn.id == 'yclass_confirm_no'){
                            self.clearFileInput(file);
                        }else{
                            //Yobj.postMsg('msg_login', function (){
                                self.doUpload(file.value);
                           // });
                        }
                    }
                }*/else{
                   // Yobj.postMsg('msg_login', function (){
                        self.doUpload(file.value);
                   // });                    
                }
            }
        },
        tpl: {
            err: '<i class="u-ico u-fail"></i>{$msg}{$detail} 请重新上传或者<a href="{$kf}" target="_blank">联系客服</a>',
            ok: '<i class="u-ico u-suc"></i><em class="red m-r">上传成功</em> 共{$size} {$zs}注 | <a href="{$fid}" title="" target="_blank">查看详情</a>&nbsp;&nbsp;<span class="gray">上传时间：{$time}</span>'
        },
        doUpload: function (fileName){
			return true;
            var fname = (fileName+'').replace(/^.*\\/g, '');
            this.state.loading = true;
            this.get('#up_data').hide();
            this.get('#up_help').show();
            this.get('#wait_info').hide();
            this.get('#upfile_view').show();
            this.get('#up_step_wrap').show();
            this.get('#upfile_title').html(fname);
            this.get('#up_info').html('');
            this.sendForm({
                form:'#suc_form',
                url: '/check_code/index',
                data: {
                    lottid: this.get('#lotid').val(),
                    playid: this.getPlayId(),
                    expect: this.get('#expect').val(),
                    nowupload: 1
                },
                end: function (data){
                    this.state.loading = false;
                    var info = this.dejson(data.text), html;
                    this.get('#up_step_wrap').hide();
                    var zs = 0;
                    this.state.fid = false;
                    this.state.hasupload = true;
                    var kfURL = Y.get('#kf').val();
                    html = '<i class="u-ico u-fail"></i><em class="">上传失败, 可能是文件超过了限定大小，请重新上传或者</em><a href="'+kfURL+'" target="_blank">联系客服</a>';
                    if(Yobj.C('user-cancal')){
                        Yobj.C('user-cancal', false);
                        html = '<i class="u-ico u-fail"></i>文件上传失败,<em class="red"> 上传已被用户终止</em>';
                    }
                    if (info) {
                        info.name = fname;
                        info.kf = kfURL;
                        if (info.ret != 0) {
                            if (!info.msg) {
                                info.msg = '文件上传失败, ';
                            }
                            if(info.err){
                                if (info.detail) {
                                    var detail = [];
                                    for(var k in info.detail){
                                        detail.push('<li>第'+k+'行: '+info.detail[k]+'</li>');
                                    }
                                    if (info.err > 5) {
                                        detail.push('<li>...</li>');
                                    }
                                    info.detail = ', 共发现<strong class="red" data-err="<ol>'+detail.join('')+'</ol>" class="red">'+info.err+'处错误</strong>,';
                                }				        
                            }                           	
                            html = this.tpl.err.tpl(info);
                        }else{
                            html = this.tpl.ok.tpl(info);
                            zs = info.zs;
                            this.state.fid = info.fid;
                            this.get('#up_data').show();
                            this.get('#up_help').hide();
                        }
                    }
                    this.get('#loadzs').html('您上传了'+zs);
                    this.zsInput.val(zs);
                    this.zsInput.onchange(zs);
                    this.get('#up_info').html(html);
                    this.tipErr(this.get('#up_info strong').one());
                    this.clearFileInput('#upfile');
                }
            })
        }
    });
//多期机选
    Class('Dq_Random', {
        index:function (ini){
            var Y = this;
            this.beishu = 1;
            this.zhushu = 1;
            this.zsInput = this.lib.DataInput({
                input: ini.zsInput,
                max: 10,
                min: 1,
                len:2,
                initVal: 1,
                change: function (){
                    Y.zhushu = this.val();
                    Y.upMsg();
                    if (Y.zhushu>10) {
                        Y.getTip().show(this.input,'<h5>注数限制</h5>多期机选每期最多10注, 请修改注数!').setIco(3);
                    }else{
                        Y.getTip().hide()
                    }
                }
            });
           var  lotid = this.get('#lotid').val(),
                len = (lotid == 3 || lotid == 28) ? 3 : 2;
            this.bsInput = this.lib.DataInput({
                input: ini.bsInput,
                initVal: 1,
                len: len,
                change: function (){
                    if (len==3&& this.val()>500) {
                        this.val(500)
                    }
                    Y.beishu = this.getInt(this.val());
                    Y.upMsg();
                }
            });
            Y.upMsg();
            this.defineMsg()
        },
        defineMsg: function (){
            this.onMsg('msg_get_list_data_dq', function (){
                return {
                    codes:'系统自动为您机选',
                    zhushu: this.zhushu,
                    beishu: this.beishu,
                    totalmoney: this.zhushu*this.beishu*Class.config('price')
                }  
            });
            this.onMsg('msg_dq_check_err', function (){
                var msg, input;
                if (!this.zsInput.val()) {
                    msg = '多期机选的注数不能为0！';
                    input = this.zsInput;
                }else if(!this.bsInput.val()){
                    msg = '多期机选的倍数不能为0！';
                    input = this.bsInput
                }
                if (msg) {
                    this.postMsg('msg_show_dlg', msg, function (){
                        input.select()
                    })
                }
                return msg
            });
             this.onMsg('msg_clear_code_dq', (function (){
                 this.clearCode();
             }).proxy(this))
        },
        clearCode: function (){
           this.zsInput.val(1); 
           this.bsInput.val(1);
           this.beishu = this.zhushu = 1;
           this.upMsg();
        },
        upMsg: function (){//切换到时通知列表更新
            this.postMsg('msg_list_change', {
                zhushu: this.zhushu,
                beishu: this.beishu,
                totalmoney: this.zhushu*this.beishu*Class.config('price')
            })        
        }
    });
//排列直选选择器
    Class('Choose_base>PLChoose',{
        showTxt: '【您选择了<b class="red"> {$zhushu} </b>注，共<b class="red"> {$totalmoney} 元</b> 】',
        maxZs: 10000,
        index:function (ini){
            var hoverCss, focusCss, Y, showbar, startNum;
            Y = this;
            hoverCss = ini.hoverCss || 'o-a';
            focusCss = ini.focusCss || 'o-b';
            this.balls = [];
            this.addNoop('onchange');
            showbar = this.get(ini.showbar);
            startNum = ini.startNum || 0;
            this.get(ini.balls).each(function (ul, i){
                var tmp = new this.lib.Choose({
                    items: this.get('li>b', ul),
                    group: this.get('li a', ul),
                    startNum: startNum,
                    focusCss: focusCss,
                    hoverCss: hoverCss
                });
                this.balls[i] = tmp;
                tmp.onchange = _change;
            }, this);
            this.rndtpl = '<li>' + this.repeat(this.balls.length, function (i){
                return '<span class="blue">{'+(i+1)+'}</span>'
            }).join(' , ') + '</li>';
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
            var zs = 1;
            this.balls.each(function (item, n){
                zs *= item.data.length
            });
            return zs
        },
        bindEvent: function (ini){
            var rnd, opts, all_rnd_sel, Y, cn;
            Y = this;
        //输出按扭

            Y.need(ini.putBtn).click(function (){
                var code, count;
                count = Y.getCount();
                if (count > Y.maxZs){
                      Y.postMsg('msg_show_dlg', '您好, 单个方案不能超过'+Y.maxZs+'注！')
                }else if (count>0) {
                    Y.chkLimitCode(Y.getChkCode(), function (){
                        code = Y.getChooseCode();
                        Y.postMsg('msg_put_code', code);//广播号码输出消息, 列表框应该监听此消息                        
                    })
                }else{
                    cn = Y.balls.length > 5 ? '一二三四五六七'.split('').map(function(x){return '第'+x}) : '万千百十个'.split('');
                    var dw;
                    Y.balls.each(function (b, i){
                        if (b.data.length==0) {
                            dw=cn.slice(-Y.balls.length)[i];
                            return false
                        }
                    })
                    Y.postMsg('msg_show_dlg', '您好, 您还没有选择'+dw+'位上的号码, 请选择！')
                }            
            });
        // 随机选取
            this.rndOpts = opts = this.need(ini.rndOpts);
            Y.need(ini.rnd).click(function (){
                Y.random(opts.val());
                return false
            });
			//定胆机选
			Y.get(ini.ddRnd).click( function() {
				var _len, _line, _zs, code, line_tip;
				_len = 0;
				_line = [];
				code = Y.getChooseCode(true)[0];
				_zs = code[code.length - 1];
				switch (code.length) {
					case 4: line_tip = ['百位', '十位', '个位']; break;
					case 6: line_tip = ['万位', '千位', '百位', '十位', '个位']; break;
					case 8: line_tip = ['一', '二', '三', '四', '五', '六', '七'];
				}
				for (var i = 0; i < code.length - 1; i++) {
					_len += code[i].length;
					code[i].length > 1 && _line.push(line_tip[i]);
				}
				if (_len == 0) {
					Y.postMsg('msg_show_dlg', '您好，请您至少选择一个胆码！')
				} else if (_line.length > 0) {
					if (code.length == 8) {
						Y.postMsg('msg_show_dlg', '您好，第' + _line.join('、') + '位胆码数量超出，每位最多只能选择一个胆码！');
					} else {
						Y.postMsg('msg_show_dlg', '您好，' + _line.join('、') + '胆码数量超出，每位最多只能选择一个胆码！');
					}
				} else if (_zs > 0) {
					Y.postMsg('msg_show_dlg', '您好，您选择的胆码数可以组成一注，请删减！');
				} else {
					Y.randomDD(opts.val(), code);
				}
				return false;
			} );
       // 清除
            Y.get(ini.clearBtn).click(function (){
                Y.clearCode()
            }); 
        },
        getChooseCode: function (keep){
            var code=[];
			keep = keep || false;
            this.balls.each(function (b, i){
                code[i] = b.data.slice()
            });
            code.push(this.getCount());
            !keep && this.clearCode();
            return [code]
        },
        getChkCode: function (){
            var code=[];
            this.balls.each(function (b, i){
                code[i] = b.data.join('')
            });
            return code.join(',')
        },
        clearCode: function (){
            this.balls.each(function (o){
                o.clearCode(true)
            })         
        },
        random: function (n){// 随机生成号码, [[red],[blue]]
            var a, b, code, id, lines;
            n = ~~n;
            code = [];
            b = this.repeat(10);
            lines = this.balls.length;
            for (var i = n; i--;) {
                code[i] = [];
                for (var j =  lines; j--;) {
                    var r = Math.random()*j;
                    code[i].push(b.random(r, r + 1));
                }
                code[i].push(1)
            }
            id = this.msgId;
			this.get('#jx_dlg h2').html('机选号码列表');
            this.postMsg('msg_show_jx', code, function (e, btn){
                  if (btn.id == 'jx_dlg_re') {
                        this.postMsg('msg_rnd_code')
                   }else if(btn.id == 'jx_dlg_ok'){
                        this.postMsg('msg_put_code', code);//广播号码输出消息, 号码列表监听此消息    
                   }
            }, this.rndtpl, true)                
        },
		randomDD : function(n, danma) { //定胆机选n注
			var a, b, code, id, lines, Y = this;
            n = ~~n;
            code = [];
            b = this.repeat(10);
            lines = this.balls.length;
            for (var i = n; i--;) {
                code[i] = [];
                for (var j = 0; j < lines; j++) {
                    var r;
					if (danma[j].length) {
						code[i].push(danma[j]);  //该位定胆
					} else {
						r = Math.random()*j;
						code[i].push(b.random(r, r + 1));  //该位机选
					}
                }
                code[i].push(1)
            }
            id = this.msgId;
			this.get('#jx_dlg h2').html('定胆机选号码列表');
            this.postMsg('msg_show_jx', code, function (e, btn){
                  if (btn.id == 'jx_dlg_re') {
                        Y.randomDD(n, danma);
                   }else if(btn.id == 'jx_dlg_ok'){
                        this.postMsg('msg_put_code', code);//广播号码输出消息, 号码列表监听此消息    
                   }
            }, this.rndtpl, true) 
		},
        redrawCode: function (code){//重现号码
            this.clearCode();
            this.balls.each(function (b, i){
                b.importCode(code[i]);
            })
        }
    });
//排列号码框
    Class('CodeList>PLCodeList', {
        noZero: true,
        lineTpl: '<span class="num" style="color:#333">{1}&nbsp;&nbsp;{2}</span> <a href="javascript:void 0" class="del">删除</a>',
        createLine: function (code){//创建一行
            var tc, type, pn;
            tc = [];
            pn=Class.C('play_name2');
            type = this.getPlay ? this.getPlay() : '';
            code.slice(0,-1).each(function (d, i){
                tc[i]=d.join('')
            });
            return this.createNode('LI', this.panel).html(this.lineTpl.format(tc.join(','), type));
        },
        formatCode: function (d){//用于投注参数
            return d.slice(0,-1).map(function (a){
                return a.join('')
            }).join(',')
        }
    });
//排列型单式录入
    Class('CodeEditor>PLCodeEditor', {    
        index: function (ini){
            this.base.apply(this, arguments);
            this.lineNum = ini.lineNum || 3;
            this.maxLine = Class.C('lr-max-line') || 1000;
            this.rndtpl = '<li>' + this.repeat(this.lineNum, function (i){
                return '<span class="blue">{'+(i+1)+'}</span>'
            }).join(' , ') + '</li>';
        },
        getCode: function (){
            var codes, llines, val, msg, tmp, reg,c;
            reg = this.getTester();
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
                    var t = a.trim(), _code;
                    if(!reg.test(t)){
                        msg = '号码格式有误，请检查！';
                    }
                    if(msg != ''){
                       this.postMsg('msg_show_dlg', "第"+(b+1)+"行"+msg, (function (){
                           this.editor.selectLine(b+1)
                       }).proxy(this));
                      return false;
                    }
                    c = t.indexOf(',') > -1 ? ',' : (t.indexOf(',') > -1 ? ',':'');
                    _code = t.split(c).map(function (x){
                        return [x]
                    }).concat(1);
                    codes.push(_code)
               }, this);
               return msg ? false : codes
            }  
        },

        getTester: function (ty){//匹配更多的动态项
            return new RegExp('^\\s*\\d([\\|,]?\\d){'+(this.lineNum-1)+'}\\s*$');
        },    
        random: function (n){// 随机生成号码, [[red],[blue]]
            var a, b, code, ty, c, len;
            n = ~~n;
            code = [];
            a = this.repeat(9);
            len = this.lineNum;
            for (var i = n; i--;) {
               code[i] =  this.repeat(len, function (){
                    return a.random(-1)
                }).concat(1)
            };
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
    //计算百分比
    Class.extend('getPercent', function (a, b){
        return ((this.getInt(a)/this.getInt(b))*100).toFixed(2)+'%'
    })
//号码统计图表
    Class('CountChart', {
        use:'mask',
        index:function (ini){
            this.options = this.mix({}, ini);
            this.expect = this.need('#expect').val();
            this.rqXml = ini.rqXml.format(this.expect);
            this.leftXml = ini.leftXml;
            this.rightXml = ini.rightXml;
            this.lot = ini.lot;
            this.get('strong.c-s-hide').each(function (el){
                var tip = '<h5>什么叫遗漏</h5>遗漏是指该' + (el.parentNode.innerHTML.indexOf('跨') > -1 ? '跨度' : '号码') + '上次开出至本期未出现的期数';
                if (el.innerHTML.indexOf('遗')>0) {
                    tip = '<h5>什么叫'+el.innerHTML+'</h5>'+ (el.innerHTML.indexOf('理论')>-1 ? '该和值理论上应该未出现的期数。' :  '指该和值自上期开出至本期未出现的期数。');
                }
                this.get(el).tip(false, 1, tip)
            }, this);
            if (this.rqXml) {
                this.loadRq();
            }
            this.loadCoolHot()
        },
        loadRq: function (xml){
            var r, b;
            this.ajax({
                url: this.rqXml,
                end:function (data, i){
                    var n = this.lot == 'dlt' ? ['fore','back'] : ['red','blue'];
                    r = this.getTwo(n[0], data.xml, 3);
                    b = this.getTwo(n[1], data.xml, 1);
                    this.full('#renqi', r, b)
                }
            });
        },
        getTwo: function (nodeName, xml, n){
            var r = [];
            this.qXml('//'+nodeName+'/row', xml, function (a){
                r.push(a.items)
            });
            r.sort(function (a, b){
                return parseFloat(a.count) > parseFloat(b.count) ? -1 : 1
            });
            return r.slice(0, n ||1 )        
        },
        full: function (wrap, r, b){
            this.get('tr', wrap).slice(0, 3).each(function (tr, i){
                if (r[i]) {
                    this.get('b', tr).html(r[i].num);
                    this.get('s', tr).setStyle('width: '+r[i].percent);
                    this.get('span', tr).html(r[i].count);                
                }
            }).end().slice(3, 4).each(function (tr, i){
                if (b[i]) {
                    this.get('b', tr).html(b[i].num);
                    this.get('s', tr).setStyle('width: '+b[i].percent);
                    this.get('span', tr).html(b[i].count);                  
                }                  
            })        
        },
        loadCoolHot: function (xml){
            var red, blue, rc, bc;
            red = {};
            blue = {};
            this.ajax({
                url: this.leftXml,
                end:function (data, i){
                    var tmp = [];
                    this.qXml('//row', data.xml, function (o){
                        tmp.push(o.items)
                    });
                    tmp.sort(function (a, b){
                        return parseFloat(a.count) > parseFloat(b.count) ? -1 : 1                    
                    });
                    rc = tmp.reduce(function (a, b){
                        return a +parseInt(b.count)
                    }, 0)
                    red.hot = tmp.slice(0,3);
                    red.cool = tmp.slice(-3);
                }
            },{
                url: this.rightXml,
                end: function (data){
                    var tmp = [];
                    this.qXml('//row', data.xml, function (o){
                        tmp.push(o.items)
                    });
                    tmp.sort(function (a, b){
                        return parseFloat(a.count) > parseFloat(b.count) ? -1 : 1                    
                    });
                    bc = tmp.reduce(function (a, b){
                        return a+parseInt(b.count)
                    }, 0)
                    blue.hot = tmp.slice(0,1);
                    blue.cool = tmp.slice(-1);
                    this.full2('#hot', red.hot, blue.hot, rc, bc);
                    this.full2('#cold', red.cool, blue.cool, rc, bc);
                }
            });
        },
        full2: function (wrap, r, b, rc, bc){
            this.get('tr', wrap).slice(0, 3).each(function (tr, i){
                if (r[i]) {
                    this.get('b', tr).html(r[i].object);
                    this.get('s', tr).setStyle('width: ' + this.ns.getPercent(r[i].count, rc));
                    this.get('span', tr).html(r[i].count);                    
                }
            }).end().slice(3, 4).each(function (tr, i){
                if (b[i]) {
                    this.get('b', tr).html(b[i].object);
                    this.get('s', tr).setStyle('width: ' + this.ns.getPercent(b[i].count, bc));
                    this.get('span', tr).html(b[i].count);                       
                }                 
            })        
        }
    });
//左侧图表
    Class('PLHotCoolChart', {
        index:function (ini){
            this.expect = this.need('#expect').val();
            this.xml = ini.xml;
            ini.single ? this.loadSingleXml() : this.loadXml();
            if (ini.hzXml) {
                this.loadHz(ini.hzXml)
            }
            this.lib.Tabs({
                items: '#cool_hot li',
                contents: '#r1,#r2',
                focusCss: 'tab_cur',
                delay:100
            });
            this.get('strong.c-s-hide').each(function (el){
                var tip = '<h5>什么叫遗漏</h5>遗漏是指该'+ (el.parentNode.innerHTML.indexOf('跨') > -1 ? '跨度' : '号码') +'自上次开出至本期未出现的期数';
                if (el.innerHTML.indexOf('遗')>0) {
                    tip = '<h5>什么叫'+el.innerHTML+'</h5>'+ (el.innerHTML.indexOf('理论')>-1 ? '该和值理论上应该未出现的期数。' :  '指该和值自上期开出至本期未出现的期数。');
                }
                this.get(el).tip(false, 1, tip)
            }, this);
        },
        loadSingleXml: function (){// 非排列, eexw, plc
            this.ajax({
                url:this.xml,
                end:function (data, i){
                    var d, sum;
                    d = [];
                    this.qXml('//row', data.xml, function (o2){
                        d.push(o2.items)
                    });
                    d.sort(function (x, y){//组排序
                        return parseInt(x.count) > parseInt(y.count) ? -1 : 1
                    });
                   sum = d.reduce(function (a, b){
                        return a + parseInt(b.count)
                    },0);                
                    this.get('#r1 tr').each(function (tr, i){// 热号
                        if (i<d.length) {
                            var row = d[i];
                             this.get('b', tr).html(row.object);
                            this.get('s', tr).setStyle('width:' + this.ns.getPercent(row.count, sum));
                            this.get('.tr', tr).html(row.count + '次');                        
                        }
                    });
                    d.reverse();
                    this.get('#r2 tr').each(function (tr, i){//冷号
                        if (i<d.length) {
                            var row = d[i];
                             this.get('b', tr).html(row.object);
                            this.get('s', tr).setStyle('width:' + this.ns.getPercent(row.count, sum));
                            this.get('.tr', tr).html(row.count + '次');                        
                        }                   
                    })
                }
            });
        },
        loadXml: function (){// sd, pls, plw, qxc
            this.ajax({
                url:this.xml,
                end:function (data, i){
                    var d;
                    d = [];
                    this.qXml('/xml/*', data.xml, function (o){
                        if (o.node.nodeName != 'head') {
                            var s = [];
                            this.qXml('row', data.xml, function (o2){
                                s.push(o2.items)
                            }, o.node);
                            d.push(s)
                        }
                    }); 
                    d.each(function (a){// n 组
                        a.sort(function (x, y){//组排序
                            return parseInt(x.count) > parseInt(y.count) ? -1 : 1
                        })
                    });

                    this.get('#r1 tr').each(function (tr, i){// 热号
                        if (i<d[i].length) {
                            var row = d[i][0];
                            d[i].sum = d[i].reduce(function (a, b){
                                return a + parseInt(b.count)
                            },0);
                            this.get('b', tr).html(row.object);
                            this.get('s', tr).setStyle('width:' + this.ns.getPercent(row.count, d[i].sum));
                            this.get('.tr', tr).html(row.count + '次');                        
                        }
                    }); 
                    this.get('#r2 tr').each(function (tr, i){//冷号
                        if (i<d[i].length) {
                            var row = d[i][d[i].length-1];
                            this.get('b', tr).html(row.object);
                            this.get('s', tr).setStyle('width:' + this.ns.getPercent(row.count, d[i].sum));
                            this.get('.tr', tr).html(row.count + '次');                        
                        }
                    })
                }
            });
        },
        loadHz: function (xml){// 和值统计, 只有3D和pls有
            this.ajax({
                url: xml,
                end:function (data, i){
                    var d = [];
                    this.qXml('//row', data.xml, function (o2){
                        d.push(o2.items)
                    });
                    d.sort(function (x, y){
                        return parseInt(x.count) > parseInt(y.count) ? -1 : 1
                    });
                    var doms = this.get('#hz_tj tr').slice(1)// 第一行是标题
                    var sum = d.slice(0, doms.size()).reduce(function (a, b){
                        return a + parseInt(b.curyl)
                    },0);
                    doms.each(function (tr, i){
                        if (i<d.length) {
                            this.get('b', tr).html(d[i].object);
                            this.get('s', tr).setStyle('width:' + this.ns.getPercent(d[i].count, sum));
                            this.get('.tr', tr).html(d[i].count + '次'); 
                        }
                    });
                }
            });        
        }
    });

    var djphTableTpl =['<table width="100%" cellspacing="0" cellpadding="0" border="0" class="zj_table">'+
    '<colgroup>'+
    '    <col width="20%"/>'+
    '    <col width="40%"/>'+
    '    <col/>'+
    '</colgroup>'+
    '<thead>'+
    '    <tr>'+
    '        <th class="tc">排名</th>'+
    '        <th class="tc">用户</th>'+
    '        <th class="tr" align="center">中奖奖金</th>'+
    '    </tr>'+
    '</thead>'+
    '<tbody>',
    '  <tr>'+
    '    <td class="tc"><span class="{$topCss}">{$index}</span></td>'+
    '    <td class="tc"><a target="_blank" href="{$space}" title="{$username}">{$username2}</a></td>'+
    '    <td class="tr"><em class="red">{$getmoney}</em><i class="gray">元</i></td>'+
    '  </tr>',
    '</tbody></table>'];
//提点
    Class.extend('getTiDian', function (ini){
        var Y, info;
        Y = this;
        info = [];
        if (ini.kj5) {//开奖公告
            this.ajax({
                url:ini.kj5,
                end:function (data, i){
                    var html = ["<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" class=\"zj_table m-t\"><colgroup><col width=\"20%\"/><col width=\"30%\"/><col width=\"50%\"/></colgroup><thead><tr><th class=\"tc\">时间</th><th class=\"tc\">期号</th><th class=\"tc\">开奖号码</th></tr></thead><tbody>"];
                    Y.qXml('//row', data.xml, function(node,i){
                        if (i>0) {//去掉第一期
                            html.push("<tr><td class=\"tc\">"+node.items['opentime'].substr(5,5).replace(/\D/g,'/')+"</td><td class=\"tc\"><span class=\"gray\">"+node.items['expect']+"</span></td><td class=\"tc\"><em class=\"red\">"+node.items['opencode']+"</em></td></tr>") 
                        }
                    });
                    html.push("</tbody></table>");
                    this.get('#opencode5').html(html.join(''));
                }
            })
        }
        if (ini.td1) {//提点
            this.ajax({
                url: ini.td1,
                type:'GET',
                end:function(data){
                    var tmp = {};
                    Y.qXml('//row', data.xml, function(node,i){
                        info.push(node.items)                
                    });
                    if (info.length == 0) {// ssq
                        Y.qXml('//TiDian', data.xml, function(node,i){
                            tmp = node.items                
                        });
                        for(var k in tmp){
                            info.push(tmp[k])
                        };
                         return this.get('#tidian').html( info.random(0,3).map(function (x){
                             return '<li>'+x+'</li>'
                         }).join(''))
                    }
                    if (ini.td2) {
                        this.ajax({
                            url:ini.td2,
                            end:function(data){
                                var html, temparr, map;
                                Y.qXml('//row', data.xml, function(node){
                                    if(node.items.type == 'Baozi')return;
                                    info.push(node.items);
                                });
                                fullTd.call(this)
                            }
                        })
                    }else{
                         fullTd.call(this)
                    }
                }
            });        
        }
        function fullTd(){
            var map;
            info.sort(function (a,b){
                return parseFloat(a.yuchu) > parseFloat(b.yuchu) ? -1 : 1
            });
            map = {
                weizhi_baiwei: "百位号码",
                weizhi_shiwei: "十位号码",
                weizhi_gewei: "个位号码",
                da: "大数",
                xiao: "小数",
                ji: "奇数",
                ou: "偶数",
                zhi: "质数",
                he: "合数",
                hzyl_hz: "和值",
                kdyl: "跨度",
                BaoZi: '豹子',
                '豹子': '豹子',
                ZuXuan3: "组选三",
                '组三': "组三",
                ZuXuan6: "组选六",
                '组六': "组六",
                zxyl: '直选遗漏',
                kdyl: '跨度遗漏'
            };
           var html= [], dy6;
             info.random().each(function(item, i){
                  if ('type' in item) {// 3 opts
                      html.push('<li>'+map[item['type']]+'<em class=\"red\"> '+item['object']+' </em>已有'+item['curyl']+'期未开出</li>'); 
                  }else{// 2 opts
                      if (item['object'] == '组三' && item['curyl'] >= 6) {
                            html.unshift('<li><em class=\"red\">组三</em>已连续<em class=\"red\">'+item['curyl']+'</em>期未开出</li>');
                            Yobj.get('#sd_z3yl').show();      
                            dy6 = true;
                      }else{
                           html.push('<li>'+item['object']+'已有'+item['curyl']+'期未开出</li>'); 
                      }
                  }   
            });
            this.get('#tidian').html(html.slice(0, 3).join(''))            
        }
        if (ini.zj) {//专家
            this.ajax({
                url: ini.zj,
                end:function(data){
                    var outstr = [];
                    this.qXml('//row', data.xml, function(node){
                        outstr[node.items.index] = "<dl class=\"s-zj-box\"><dt><a href=\""+node.items.personurl+"\" title=\"\" target=\"_blank\"><img src=\""+node.items.personimageurl+"\" alt=\"\" title=\"\" style='width:59px;height:61px' />"+node.items.personname+"</a></dt><dd><a href=\""+node.items.url+"\" title=\""+node.items.title+"\" target=\"_blank\"><h4 class=\"red\">"+node.items.title+"</h4></a><p>"+node.items.redcode+"</p><p>"+node.items.bluecode+"</p></dd></dl>";
                    });
                    this.get('#comm_content').html("<p style='padding:0;margin:0;height:0;overflow:hidden'></p>"+outstr.join(''));
                }
            })         
        }
        if (ini.ph) {// 大奖排行        
            var a, b, c, info;
            now = new Date;
            a = ini.ph.format(now.getFullYear(), ('0'+(now.getMonth()+1)).slice(-2));
            now.setMonth(now.getMonth()-1);
            b = ini.ph.format(now.getFullYear(), ('0'+(now.getMonth()+1)).slice(-2));
            now.setMonth(now.getMonth()-1);
            c = ini.ph.format(now.getFullYear(), ('0'+(now.getMonth()+1)).slice(-2));
            info = [];
            findPh(a, function (arr){
                if (arr.length<5) {
                    findPh(b, function (arr){
                        if (arr.length<5) {
                            findPh(c, function (){showPh(arr)})
                        }else{
                            showPh(arr)
                        }
                    })
                }else{
                    showPh(arr)
                }
            })
        }
        function findPh(xml, fn){//取数据
            Y.ajax({
                url: a,
                end:function (data, i){
                    this.qXml('//row', data.xml, function (node){
                        info.push(node.items)
                    });
                    fn.call(this, info)
                }
            });        
        }
        function showPh(objArr){//填充
            var html = [djphTableTpl[0]];
            objArr.slice(0,5).each(function (a, i){
                a.index = i+1;
                a.topCss = i<3 ? 'top3_num' : 'num_bg';
                a.space = Class.C('url-space')+'?u='+a.username;
                a.username2 = Yobj.sliceB(a.username, 14)
                html.push(djphTableTpl[1].tpl(a))
            });
            html.push(djphTableTpl[2]);
            Y.get('#djph').html(html.join(''))
        }
    });

	Class('continueBuy', {
		ready : true,
		index : function() {
			var Y = this;
			this.onMsg('show_continue_buy_data', function(data) {
				//log(data)
				setTimeout(function() {
					var zs = Y.postMsg('msg_put_code_' + data.msgId, data.codes).data;
					Y.postMsg('msg_force_change_bs', data.beishu, zs);
					if (+data.ishm) {
						Y.postMsg('msg_force_change_fs', data.allnum);
						Y.get('#tcSelect').prop('selectedIndex', +data.ticheng);
						Y.get('#gk' + (+data.isshow + 1)).prop('checked', true);
						Y.postMsg('msg_force_change_rg', +data.regnum);
						Y.postMsg('msg_force_change_bd', data.isbaodi, data.baodinum);
						if (data.title.trim() || data.content.trim() || data.setbuyuser != 'all') {
							Y.get('#moreCheckbox').prop('checked', true);
							Y.get('#case_ad,#hm_target').show();
							data.title.trim() && Y.get('#caseTitle').val(data.title.trim());
							data.content.trim() && Y.get('#caseInfo').val(data.content.trim());
							if (data.setbuyuser != 'all') {
								Y.get('#dx2').prop('checked', true);
								Y.get('#fixobj').show().find('textarea').val(data.setbuyuser);
							}
						}
					}
				}, 200);
			});
		}
	});
    //号码篮 **********************************************************************************
    //创建翻页条
    Class.extend('createPageBar', function (count, cur, w){
        var a=1,b=count+1,html=[];
        cur = Math.min(count, cur || 1);
        w = w || 7, s=Math.floor(w/2);
        if (cur <=s ) {
            b=Math.min(w+1, b)
        }else if (count < w) {
        }else if(cur > count - w){
            a=count-w;
        }else{
            a=cur-s;
            b=cur+(w-s)
        }
        for (a=Math.max(a,1); a < b; a++) {
            if (a==cur) {
                html.push('<a href="javascript:void 0" onclick="return false" title="" style="background:#0080ff;color:#fff;padding:0, 5px;cursor:default" >&nbsp;'+a+'&nbsp;</a>')
            }else{
                html.push('<a href="javascript:void 0" onclick="return false" class="page_num">'+a+'</a> ')
            }        
        }
        return html.join('')
    });

    Class.extend('lotid2en', function (){
        var map = {
            1:['sfc', '足彩胜负'],
            10000:['rcjc','任选9场'],
            3:['ssq','双色球'],
            4:['qxc','七星彩'],
            5:['pls','排列三'],
            10001:['plw','排列五'],
            7:['sd','福彩3D'],
            8:['eexw', '22选5'],
            9:['bjdc','足球单场'],
            11:['qlc', '七乐彩'],
            15:['zc6', '6场半'],
            17:['jq4', '4场进球'],
            28:['dlt', '大乐透'],
            29:['ssc', '时时彩'],
            45:['dlc', '11选5']
        }
        return map[this.get('#lotid').val()] || [];
    });

    Class('CodeSkep', {
        index:function (){
            var mod = this;
            this.skepUrl = '/main/getapicode.php';
            try{this._addDlg();}catch(e){return}
            setTimeout(function() {
                Yobj.getTip && Yobj.getTip().panel.setStyle('zIndex', 999999);
            },1000);
            this._initTag();
            this.onMsg('msg_close_addmoneydlg', function (){
                var isNotMoney = true;
                mod.addSkep(true, isNotMoney);
            });
            this.get('a').filter(function (el){
                var cls = el.className;
                if (cls.indexOf('add2Skep_l')>-1) {
                    this.get(el).click(function (){
                        __this.postMsg('msg_click_listen', 'jyq');
                        Y.postMsg('msg_login', function (){
                             mod.addSkep(true)
                        });
                    });
                }else if(cls.indexOf('add2Skep_s')>-1){
                    this.get(el).click(function (){
                        __this.postMsg('msg_click_listen', 'jyq');
                        Y.postMsg('msg_login', function (){
                            mod.addSkep();
                         });
                    });                    
                }else if(cls.indexOf('fromSkep')>-1){
                    this.get(el).click(function (){
                        __this.postMsg('msg_click_listen', 'drhm');
                        Y.postMsg('msg_login', function (){
                            mod.loadCodes();
                         });
                    });                    
                }                
            }, this);
            var __this = this, murl = Class.C('url-trade') +'/useraccount/default.php?url=',
                hmlUrl = murl + Class.C('url-space')+'/pages/userbasket/';
            this.get('#lookskep,#lookskep2').attr('href', hmlUrl);
            this.get('#share2lt').click(function (){
                var url = Class.C('url-space')+'/pages/userbasket/index.php?act=ajax&mod=sharebbs&callback=share_end&id=' + __this.C('skepid');
                __this.postMsg('msg_click_listen', 'fxbbs');
                window['share_end'] = function (json){
                    var state, kankan	=	Yobj.getSubDomain('bbs')+'/forum.php?mod=viewthread&tid='+json['tid'];
                    switch(json.msg){
                    case 1:
                        clearTimeout(__this.dlgSmallTimer);
                        __this.dlgSmall.pop('分享成功，立刻去<a href="'+kankan+'" target="_blank" style="blue">看看</a>！');
                        __this.get('#share2lt').hide();
                        __this.dlgSmallTimer = setTimeout(function() {
                            __this.dlgSmall.close();
                        },3000);
                        break;
                    case 2:
                        __this.dlgSmall.pop('分享成功, 正在等待审核');
                        __this.get('#share2lt').hide();
                        break;
                    case -7:
                        __this.alert('您好, 您已经分享过此方案！');
                        break;
                    default:
                        __this.alert('分享失败');
                    }
                }
                __this.use(url);
            });
        },
        getTitle: function (str){
            var lot = this.lotid2en(),
                exp = this.get('#expect').val(),
                type = this.getPlayText();
            return (lot[1]||'')+'第 '+ exp+' 期'+type+' - ' + str; 
        },
        _addDlg: function (){
            this.dlgfind = this.lib.MaskLay('#dlg_fromSkep');
            this.dlgfind.addClose('#dlg_fromSkep_k');

            this.dlgSmall = this.lib.MaskLay('#dlg_small', '#dlg_small_c');
            this.dlgSmall.addClose('#dlg_small_k,#share2lt');

            this.dlgOk = this.lib.MaskLay('#lay_hmlend');
            this.dlgOk.addClose('#lay_hmlend_c');

            //导入面板复选框控制
            this.get('#s_allSkepCase').click(function (e, __this){
                __this.get('#dlg_fromSkep_c :checkbox').prop('checked', this.checked)
            });
            this.get('#dlg_fromSkep_c').live(':checkbox', 'click', function (e, __this){
                if (this.checked) {
                    var nsel;
                    __this.get('#dlg_fromSkep_c :checkbox').each(function (el){
                        if (!el.checked) {
                            nsel=true;
                            return false
                        }
                    });
                   __this.get('#s_allSkepCase').prop('checked', !nsel)
                }else{
                    __this.get('#s_allSkepCase').prop('checked', false)
                }
            });
            //确定添加到号码框
            this.get('#dlg_fromSkep_y').click(function (e, __this){
                var selData=[], hasErr;
                __this.get('#dlg_fromSkep_c :checkbox').each(function (el, i){
                    if (el.checked) {
                        if (this.pageCodes[i]) {
                            selData.push(this.pageCodes[i])
                        }else if(!hasErr){
                            hasErr = true;
                        }                   
                    }
                }, __this);
                if (selData.length > 0) {
                    selData.type = __this.pageCodes.type;
                    __this.put2List(selData);
                    __this.dlgfind.close();
                }else if(__this.pageCodes.length){
                    __this.alert('您好, 请至少选择一个'+(hasErr?'有效的':'')+'方案再导入!');
                }else{
                    __this.dlgfind.close();
                }
            });
            //显示和隐藏更多号码
            this.get('#dlg_fromSkep_c').live('a', 'click', function (e, __this){
                if (this.getAttribute('open')=='1') {
                   __this.get(this.parentNode).nexts().hide();
                   this.setAttribute('open', '0');
                   this.innerHTML = '显示更多('+this.getAttribute('more')+')';
                }else{
                   __this.get(this.parentNode).nexts().show();    
                   this.setAttribute('open','1');
                   this.innerHTML = '隐藏';
                }
            });
            //翻页控制
            this.get('#s_prev_page').click(function (e, __this){
                 __this.changePage(__this.currentPage-1);
            });
            this.get('#s_next_page').click(function (e, __this){
                __this.changePage(__this.currentPage+1);         
            });
            this.get('#s_page_num_box').live('a', 'click', function (e, __this){
                __this.changePage(this.innerHTML);
            });
        },
        errTip: function (txt){
            var tag = this.get('#tag_over');
            tag.html(txt).show(!!txt);
            Y.get('#tag_ok').hide();
        },
        _initTag: function (){
            var mod=this;
            this.userTags = [];
            var text = this.get('#lay_2Skep_tagInput'), t,
                tt=text.one();
            text.focus(function (){//标签输入框
                if (this.value.trim() == this.defaultValue) {
                    this.value = '';
                }
                var This = this;
                t=setInterval(function() {
                    var s=This.value.trim().replace(/\s+/g,' '),
                        a=only(s.split(' '), 10)
                    if(This.value.trim().length == 0){
                        mod.errTip('标签不能为空');
                    }else if (a.length>3) {
                         mod.errTip('标签个数超过3个');
                    }else if(/\S{10,}/.test(This.value.trim())){
                        mod.errTip('标签长度超过个10个字符');
                    }else{
                        mod.errTip();
                    }                    
                    mod.userTags = a//.slice(0, 3);
                },100);
            }).blur(function (){
                clearInterval(t);
                if (this.value.trim() == '') {
                    mod.userTags = [];
                    return this.value = this.defaultValue;
                }
                this.value=mod.userTags.join(' ');
            });
            this.get('#lay_2Skep_tags').live('a', 'click', function (e){//添加系统标签
                mod.userTags.push(this.innerHTML);
                mod.userTags = only(mod.userTags, 10);
                mod.errTip(mod.userTags.length > 3 ? '标签个数超过3个' : false);
                tt.value = mod.userTags.join(' ');
                e.end();
                e.stop();
                return false;
            });
            this.get('#lay_2Skep_chtag').click(function (){//更换可选标签
                mod._rndTag();
            });
            this.get('#btn_saveTag').click(function (){
                if (mod.userTags.length>3) {
                    return text.doProp('select');
                }else{
                    var err = mod.userTags.filter(function (a){
                        return a.length>10
                    });
                    if (err.length) {
                       return  text.doProp('select');
                    }
                }
                mod.sendTag();
            });
            function only(arr, len){//唯一化标签
                var o={}, b=[];
                arr.each(function (k){
                    if (!o[k]) {
                        o[k] = 1;
                        b.push(k)
                    }
                });
                return b;
            }
        },
        showSkep: function (){
            this.dlgfind.pop();
        },
        _saveList:[],//刚收藏的号码
        _sendAdd: function (isNotMoney){//收藏号码
            var d = this.formatSaveCode(this.currentData);
            if (isNotMoney && this._saveList.indexOf(this.getPlayId()+'~'+d.codes) > -1) {
                return; //this.alert('您好, 你刚刚已经收藏过这组号码!');
            }
            var data = {
                type:2,
                lotid: this.get('#lotid').val(),
                playid: this.C('play_name') == 'dd' && this.dataSrc== "choose" ? this.ddPlayid : this.getPlayId(),
                expect: this.get('#expect').val(),
                code: d.codes,
                complete: this.dataSrc=='list' ? 1 : d.isfull,
                //tag:encodeURIComponent(this.userTags.join(',')),
                allmoney: d.zhushu*2,
                remark:''
            };
            !isNotMoney && this.alert('正在将号码保存到您的号码篮...', false, true);
            this.ajax({
                url:this.skepUrl,
                type: 'POST',
                data: data,
                end:function (data, i){
                    var info, err = '收藏号码失败, 请重试!';
                    this.alert.close();
                    if (!data.error) {
                        if (info = this.dejson(data.text)) {
                            switch(info.code){
                            case 1:
                                this._saveList.push(this.getPlayId()+'~'+d.codes);
                                this.dlgSmall.noMask = true;
                                //this.get('#share2lt').show();
                                this.C('skepid', info.str);
                                if (isNotMoney) {
                                    this.dlgSmall.pop('已成功加入号码篮, 您可以稍候购买');
                                }else{
                                    this.dlgOk.pop()
                                }
                                var This = this, t;
                                this.postMsg('msg.hml.save.success');
                                return this.dlgSmallTimer = setTimeout(function() {
                                     This.dlgSmall.close();
                                }, 4000);
                                break;
                            case 2:
                                 var murl = Class.C('url-trade') +'/useraccount/default.php?url=',
                                    hmlUrl = murl + Class.C('url-space')+'/pages/userbasket/';
                                err = '您好，号码篮今日容量已满，请清空<a href="'+ hmlUrl+'" target="_blank" style="blue" onclick="Yobj.alert.close()">号码篮</a>后再收藏';
                            }   
                        }
                    }
                    this.alert(err);
                }
            });
        },
        _rndTag: function (){//更换标签
            if (this.C('query_tag')) {
                return;
            }
             this.get('#lay_2Skep_chtag').addClass('ico_loading');
             this.C('query_tag', true);
            this.ajax({
                url:this.skepUrl+'?type=3&num=3&lotid='+this.get('#lotid').val(),
                end:function (data, i){
                    var info, tags;
                    this.get('#lay_2Skep_chtag').removeClass('ico_loading');
                    this.C('query_tag', false);
                    if (!data.error) {
                        if (info=this.dejson(data.text)) {
                            tags = info.str;
                            if (tags instanceof Array) {
                                this.get('#lay_2Skep_tags a').empty(true);//删除原有
                                this.isInitTags = true;
                                tags.each(function (tag){
                                    this.get('<a class="tag" href="javascript:;">'+tag+'</a>').insert('#lay_2Skep_tags');
                                }, this)
                            }
                        }
                    }
                }
            });
        },
        sendTag: function (){
            if (this.C('sendTag')) {return;}
            if (this.userTags.length == 0) {
                this.errTip('标签不能为空');
                return this.one('#lay_2Skep_tagInput').select(); 
            }
            this.C('sendTag', true);
            this.get('#ico_tagadd').addClass('ico_loading');
            this.get('#tag_ok').hide();
            clearTimeout(this.tagOkTimer);
            this.ajax({
                url:this.skepUrl+'?type=4&cid='+this.C('skepid')+'&lotid='+this.get('#lotid').val(),
                type: 'POST',
                data: {
                    type: 4,
                    cid: this.C('skepid'),
                    tag: encodeURIComponent(this.userTags.join(','))
                },
                end:function (data, i){
                    var info, tags;
                    this.get('#ico_tagadd').removeClass('ico_loading');
                    this.C('sendTag', false);
                    if (!data.error) {
                        if (info=this.dejson(data.text)) {
                            if (info.code == 1) {
                                this.get('#tag_ok').show();
                                this.tagOkTimer = setTimeout(function() {
                                    Y.get('#tag_ok').hide();
                                },2000);
                                return this.clearTag();
                            }
                        }
                    }
                    this.alert('添加标签失败，请重试!');
                }
            });            
        },
        clearTag: function (){
            var t=this.one('#lay_2Skep_tagInput');
            this.get('#tag_over').hide();
            this.userTags = [];
            t.value = t.defaultValue;
            t.blur();            
        },
        codeTpl: '',
        isInitTags: false,
        getSubType: function(){return ''},
        addSkep: function (isListCode, isNotMoney){
            var curType = this.C('play_name'), msg, data;
            if (isListCode) {
                data = this.postMsg('msg_get_list_data').data;
                this.dataSrc = 'list';
            }else{
                data = this.postMsg('msg_get_choose_code_'+curType+this.getSubType(), true).data;
                this.dataSrc = 'choose';
            }
            if (msg = this.checkCode(data)) {
                return this.alert(msg);
            }
            if (!this.isInitTags) {
                this._rndTag();
            }
            this.currentData = data;
            this.userTags = [];
            this.clearTag();
            this._sendAdd(isNotMoney);
        },
        thead:'<table width="100%" border="0" cellspacing="0" cellpadding="0" class=""><colgroup><col width="50px"><col><col width="110px"><col width="130px"></colgroup>',
        rowtpl:'<tr><td><input name="input" type="checkbox" value="" /></td><td><ul class="dr_hml">{$list}</ul></td><td class="red">{$money} </td><td>{$time}</td></tr>',
        pageCodes: [],//当前页导入号码提取js数据
        showCodeToDlg: function (codes){
            var noCode = '<tr><td height="80" colspan="4">你号码篮没有符合要求的方案！</td></tr></table>';
            this.get('#skep_import_h').html(this.getTitle('导入到号码篮'));
            if (codes.total == 0) {
                this.get('#dlg_fromSkep_c').html(this.thead+noCode);
                this.pageCodes = [];
                this.get('#s_page_bar').hide();
                this.get('#s_skep_foot').hide();
                this.get('#dlg_fromSkep_y').val('关 闭');
            }else{
                var html = [], row = this.rowtpl, _case=[];
                this.get('#s_skep_foot').show();
                this.get('#dlg_fromSkep_y').val('导入选中号码');
                codes.list.each(function (o){//所有方案
                    var code = o.code.split(';'), list=[];
                    for (var i = 0, j = code.length; i < j; i++) {//一个方案多注号码
                        list.push('<li '+(i==0?'':'style="display:none"')+'>'+code[i]+(j>1&&i==0?' <a href="javascript:void(0)" more="'+j+'">显示更多('+j+')</a>':'')+'</li>')
                    }
                    html.push(row.tpl({
                        lotname : this.lotName,
                        list: list.join(''),
                        money: this.getInt(o.allmoney,0).rmb(),
                        time:o.lasttime
                    }));
                }, this);
                this.pageCodes = this.parseCode(codes.list);// [方案=[号码=[r=[],b=[],zs=[]]]].err无效个数
                this.get('#dlg_fromSkep_c').html(this.thead+html.join('')+'</table>');
                //翻页
                this.pageCount = Math.ceil(codes.total/this.pageSize);
                if (codes.total > this.pageSize) {
                    this.get('#s_page_bar').show();
                    var numHtml = this.createPageBar(this.pageCount, this.currentPage, 6);
                    this.get('#s_page_num_box').html(numHtml);
                }else{
                    this.get('#s_page_bar').hide()
                }
                this.get('#s_allSkepCase').prop('checked', false);
            }
            this.showSkep();
        },
        pageSize: 10,
        pageCount: Number.MAX_VALUE,
        currentPage: -1,
        loadCodes: function (){
            this.alert('正在从您的号码篮中导入号码, 请稍候...', false, true);
            this.currentPage = -1;
            this.changePage(1);
        },
        changePage: function (n){
            n=Math.max(1, Math.min(this.pageCount, parseInt(n, 10) || 1));
            if (n != this.currentPage) {
                this.currentPage = n;
                this.ajax({
                    url:'/main/getapicode.php?type=1&lotid='+this.get('#lotid').val()+'&complete=1&playid='+this.getPlayId()+'&num='
                        +this.pageSize+'&page='+this.currentPage,
                    end:function (data, i){
                        var info, codes;
                        if (!data.error) {
                            if (info = this.dejson(data.text)) {
                                if (info.code == 1) {
                                    this.alert.close();
                                    return this.showCodeToDlg(info.str);
                                }
                            }
                        }
                        this.alert('导入失败， 请重试!');
                    }
                });                
            }
        },
        put2List: function (codes){//投递到号码框
            codes.each(function (_case){
                this.postMsg('msg_put_code', _case)
            }, this);            
        },
        data2Html: function (data){return [];},
        checkCode: function (data){}
    });

    //点击统计
    Class({
       ready: true,
       index: function (){
          this.onMsg('msg_click_listen', function (type){
              var id = this.lotid2en()[0] + '_' + type,
                lid = this.getId(id);
              if (lid) {
                  this.dcsMultiTrack(lid)
              }          
          });
       },
       dcsMultiTrack:function (id){
            if (typeof(dcsMultiTrack) == 'function') {
                dcsMultiTrack(
                    'DCSext.button_t',
                    id.slice(0,2)+'000000',
                    'DCSext.button_w',
                    id.slice(0,4)+'0000',
                    'DCSext.button_b',
                    id.slice(0,6)+'00',
                    'DCSext.button_c',
                     id,
                    'DCSext.button_n',
                    'ssyg_gm'
                );
            }       
       },
       getId: (function (){
            var listenId = {
                "sfc_fxbbs": "10910101",
                "rj_fxbbs": "10910102",
                "bjdc_fxbbs": "10910103",
                "jczq_fxbbs": "10910104",
                "ssq_fxbbs": "10910105",
                "dlt_fxbbs": "10910106",
                "sd_fxbbs": "10910107",
                "pls_fxbbs": "10910108",
                "sfc_jyq": "10910109",
                "rj_jyq": "10910110",
                "bjdc_jyq": "10910111",
                "jczq_jyq": "10910112",
                "ssq_jyq": "10910113",
                "dlt_jyq": "10910114",
                "sd_jyq": "10910115",
                "pls_jyq": "10910116",
                "sfc_faxq": "10910117",
                "rj_faxq": "10910118",
                "bjdc_faxq": "10910119",
                "jczq_faxq": "10910120",
                "ssq_faxq": "10910121",
                "dlt_faxq": "10910122",
                "sd_faxq": "10910123",
                "pls_faxq": "10910124",
                "sfc_drhm": "10910125",
                "rj_drhm": "10910126",
                "bjdc_drhm": "10910127",
                "jczq_drhm": "10910128",
                "ssq_drhm": "10910129",
                "dlt_drhm": "10910130",
                "sd_drhm": "10910131",
                "pls_drhm": "10910132",
                "hml_wzdb": "10910133"
            };
            return function (key){
                return listenId[key];
            }
       })()
    });


})()