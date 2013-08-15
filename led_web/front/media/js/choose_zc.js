(function (){
	
    var tpl_ishm = '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="faTable">'+
        '<tr><th>方案信息</th><td><table width="100%" border="0" cellspacing="0" cellpadding="0">'+
        '<tr class="tr1"><td>玩法</td><td>注数</td><td>倍数</td><td>总金额</td><td>份数</td>'+
        '<td>保底</td><td>提成</td><td>保密类型</td></tr><tr>'+
        '<td>{$play}</td>'+
        '<td>{$zhushu}</td>'+
        '<td>{$beishu}</td>'+
        '<td>{$allmoney}元</td>'+
        '<td>{$buymun}份</td>'+
        '<td>{$bdscale}</td>'+
        '<td>{$tc_bili}</td>'+
        '<td>{$hidetype}</td>'+
        '</tr></table></td></tr><tr><th>投注内容 </th><td class="t2">{$ytcase}<div class="tdbback" style="width:auto;display:{$codesHidden};">'+
        '<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablelay eng">'+
        '<tr>'+
        '<tr><th>场次</th>{$index}</tr>'+
        '<tr><td>对阵</td>{$vsName}</tr>'+
        '<tr><td>选号</td>{$code}</tr>'+
        '<tr style="display:none">'+
        '<tr style="display:{$dthidden}"><td>胆拖</td>{$dan}</tr></table></div></td></tr><tr style="display:{$rghidden}"><th>认购信息</th>'+
        '<td class="t2">您本次购买需消费<strong class="eng red">{$buymoney}</strong>元</td></tr></table>';
    var tpl_isdg =  '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="faTable">'+
        '<tr><th>方案信息</th><td><table width="100%" border="0" cellspacing="0" cellpadding="0">'+
        '<tr class="tr1"><td>玩法</td><td>注数</td><td>倍数</td><td>总金额</td></tr><tr>'+
        '<td>{$play}</td>'+
        '<td>{$zhushu}</td>'+
        '<td>{$beishu}</td>'+
        '<td>{$buymoney}元</td>'+
        '</tr></table></td></tr><tr><th>投注内容 </th><td class="t2">{$ytcase}<div class="tdbback" style="width:auto;display:{$codesHidden};">'+
        '<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablelay eng">'+
        '<tr>'+
        '<tr><th>场次</th>{$index}</tr>'+
        '<tr><td>对阵</td>{$vsName}</tr>'+
        '<tr><td>选号</td>{$code}</tr>'+
        '<tr style="display:{$dthidden}"><td>胆拖</td>{$dan}</tr></table></div></td></tr><tr><th>认购信息</th>'+
        '<td class="t2">您本次购买需消费<strong class="eng red">{$buymoney}</strong>元</td></tr></table>';

    Class.C('passport', "http://passport.boss.com");
    Class.C('root', 'http://'+location.host+'/');
    Class.C('add-money-url', '/useraccount/default.php?url='+Class.C('passport')+'/useraccount/addmoney/add.php');
    Class.C('min-rengou', .05);//最低认购
    Class.C('fsfq', Class.C('root')+'zcsf/submit_buy');   //普通投注
    Class.C('bxfq', Class.C('root')+'zcsf/submit_updata');         
    Class.C('dsfq', Class.C('root')+'zcsf/submit_buy');   //单式投注
    Class.C('has_submit', false);
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
                        max: Yobj.getInt(l[1], Number.MAX)
                    },{
                        min: Yobj.getInt(l[2]),
                        max:Yobj.getInt(l[3])
                    }]                
                }
            }
           Class.C('limit', limit);//[{min,max},{}]
        }
        return Class.C('price') == 2 ? limit[0] : limit [1]
    });
    Class.extend('loadEndTime', function (){// 变换截止时间
        this.ajax({
            url:'/main/ajax/endtime.php',
            data:{
                ticket_type: this.get('#ticket_type').val(),
                play_method: this.get('#play_method').val(),
                expect: this.get('#expect').val()
            },
            end:function (data, i){
                var json;
                if (json = this.dejson(data.text)) {
                    Class.C('limit', [{min:this.getInt(json.minmoney), max:this.getInt(json.maxmoney)}, {min:this.getInt(json.minmoney), max:this.getInt(json.maxmoney)}]);
                    this.postMsg('msg_endtime_change', json.endtime, data.date)
                }
            }
        })
    });
    Class.extend('chkLimitCode', function (code, fn){
        var url;//限号检查
        if (url = Class.C('limit-code-url')) {
            this.ajax({
                url:'/main/inc/limitcode.php',
                data: {
                    ticket_type: 5,
                    play_method: this.get('#play_method').val(),
                    expect: this.get('#expect').val(),
                    code: code
                },
                end:function (data, i){
                    var json;
                    if (json = this.dejson(data.text)) {
                        if (json.code!=0) {
                            Y.postMsg('msg_isdg', json.msg, function (e, btn){
                                 if (btn.id=='b2_dlg_yes') {
                                     fn.call(this)
                                 }
                            });
                        }else{
                            fn.call(this)
                        }
                    }
                }
            });        
        }else{
            fn.call(this)
        }
    });
    Class.extend('updateBalance', function (money){//更新余额
         var bl = Math.max(0, Class.config('userMoney') - money).rmb();
          this.get('#buyMoneySpan').html(money.rmb());
          this.get('#buySYSpan').html(bl);     
    });
    Class.extend('getLotInfo', function (){
        var map = {
            1:{ name: '胜负彩', vsLen: 14},
            2: {name: '任选九场', vsLen: 14},
            3:{name: '6场半', vsLen: 12},
            4:{name: '4场进球', vsLen: 8}
        };
       return map[this.get('#play_method').val()] || {}
    });
//对话框类
    Class('Dlg', {
        index:function (){
            //通用
			
            this.dlg = this.lib.MaskLay('#info_dlg','#info_dlg_content');
            this.dlg.addClose('#info_dlg_close a,#info_dlg_ok');
            this.get('#info_dlg div.tips_title').drag('#info_dlg');
            //确认
            this.confirm = this.lib.MaskLay('#b2_dlg','#b2_dlg_content','#b2_dlg_title');
            this.confirm.addClose('#b2_dlg_close a,#b2_dlg_no,#b2_dlg_yes');
            this.get('#b2_dlg div.tips_title').drag('#b2_dlg');
            //通用确认
            this.confirm2 = this.lib.MaskLay('#confirm_dlg','#confirm_dlg_content','#confirm_dlg_title');
            this.confirm2.addClose('#confirm_dlg_close a,#confirm_dlg_no,#confirm_dlg_yes');
            this.get('#confirm_dlg div.tips_title').drag('#confirm_dlg');
            //合买确认
            this.isBuy = this.lib.MaskLay('#ishm_dlg','#ishm_dlg_content', '#ishm_dlg_title');
            this.isBuy.addClose('#ishm_dlg_close,#ishm_dlg_no,#ishm_dlg_yes');
            this.get('#ishm_dlg div.tips_title').drag('#ishm_dlg');
            //胆拖拆分明细
            this.splitDlg =  this.lib.MaskLay('#split_dlg','#split_dlg_list');
            this.splitDlg.addClose('#split_dlg_close a','#split_dlg_ok');
            this.get('#split_dlg div.tips_title').drag('#split_dlg');
            //充值
            this.addMoneyDlg =  this.lib.MaskLay('#addMoneyLay');
            this.addMoneyDlg.addClose('#addMoneyClose a','#addMoneyNo','#addMoneyYes');
            this.get('#addMoneyLay div.tips_title').drag('#addMoneyLay');
            this.bindMsg()
        },
        bindMsg: function (){
            var hm = this.isBuy;
            this.extend('popIsWin', function (html, fn){
				var lot = this.getLotInfo();
				hm.title.html(lot.name + '第' + this.get('#expect').val() + '期方案' + (this.C('buy_type') == 0 ? '代购' : '合买'));
                hm.pop(html, function (e, btn){
                    if (btn.id == 'ishm_dlg_yes') {
                        fn.call(this)
                    }
                })
            });
            this.onMsg('msg_show_dlg', function (msg, fn){
                this.dlg.pop.apply(this.dlg, arguments)
            });
            this.onMsg('msg_isdg', function (msg, fn){
                this.confirm.pop.apply(this.confirm, arguments)
            });
            this.onMsg('msg_show_is', function (msg, fn, title, btn2){
                if (title) {
                    this.confirm2.title.html(title)
                }
                this.get('#confirm_dlg_yes').val(btn2||'确定');
                this.confirm2.pop(msg, fn)
            });
            //充值
            this.onMsg('msg_show_addmoney', function (fn, args){
                this.addMoneyDlg.pop(false, function (e, btn){
                    if (typeof fn === 'function' && btn.id == 'addMoneyYes') {
                        fn(args)
                    }
                })
            });
        }
    });
//合买表单类
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
                initVal: 0,
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
            this.fsInput.onchange();
            //认购
            this.rgInput = this.lib.DataInput({
                input:'#rgInput',
                initVal: 0,
                min:1
            });
            this.rgInput.onchange = function (){
                var d, fs, low, mf;
                yobj.rg = fs = this.getInt(this.val());
                mf = yobj.data.totalmoney / yobj.fs;
                this.need('#rgMoney').html((fs === 0 || yobj.fs === 0 ? 0 : mf* fs).rmb());
                this.need('#rgScale').html((yobj.fs ===0 ? 0 : (fs/yobj.fs*100).toFixed(2))+'%');
                if (fs < yobj.low) {
                    this.need('#rgErr').html('您至少需要认购'+yobj.low+'份，共计'+(yobj.low * mf).rmb()+'元！');
                }
                this.need('#rgErr').show(fs < yobj.low)
            };
            this.rgInput.onMsg('msg_fs_change',function (){
                this.val(yobj.low);
                this.onchange()
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
                sl = yobj.fs === 0 ? 0 : ((fs/yobj.fs*100).toFixed(2) + '%');
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
            this.onMsg('msg_get_hm_param', function (){
                return this.getParam()
            });
        },
        getfitFs: function (a, b){//计算适当份数
            while((a > b) && a/b - (a/b).toFixed(~~2) !== 0){b++};
            return Math.min(a, b)
        },
        getParam: function (){
              var yobj, isshow, param, tmp;
              yobj = this;
            if (!this.one('#agreement_hm').checked) {
                 this.postMsg('msg_show_is', '<p style="text-align:center;line-height:500%">您好，您需要阅读并且同意《用户合买代购协议》！</p>', function (e, btn){
                      if (btn.id === 'confirm_dlg_yes') {
                         yobj.one('#agreement_hm').checked = true                     
                      }
                  }, false, '同意')
            }else if (this.fs < 1) {
                 this.postMsg('msg_show_dlg', '每份金额必须大于等于1！', function (){
                     yobj.fsInput.input.doProp('select')
                 })
             }else if(this.fs > yobj.data.totalmoney){
                  this.postMsg('msg_show_dlg', '您好，您分成的每份金额不能小于1！', function (){
                     yobj.fsInput.input.doProp('select')
                 })            
             }else if (this.fs != this.fit) {
                  yobj.postMsg('msg_show_is', '<p style="padding:20px 0;font-size:14px;text-indent:2em">您好，每份金额不能除尽， 系统建议您分成<strong style="color:red"> '+this.fit
                      +' </strong>份，点击确定自动分成<strong style="color:red"> '+this.fit+' </strong>份！</p>', function (e, btn){
                      if (btn.id === 'confirm_dlg_yes') {
                         yobj.fsInput.val(yobj.fit);
                         yobj.fsInput.onchange();                      
                      }else{
                          yobj.fsInput.input.doProp('select')
                      }
                  }, '份数不能整除')
             }else if(this.rg < this.low){
                 this.postMsg('msg_show_dlg', '您好，您至少需要认购'+this.low+'份，共计'+(this.low*this.C('price')).rmb()+'元！', function (){
                     yobj.rgInput.input.doProp('select');
                     yobj.rgInput.val(yobj.low);
                 })
             }else if(this.rg > this.fs){
                 this.postMsg('msg_show_dlg', '您好，您要认购的份数不能大于所分的份数！', function (){
                     yobj.rgInput.input.doProp('select')
                 })         
             }else if(this.one('#isbaodi').checked && this.getInt(this.one('#bdScale').innerHTML)<20){
                 var minFs = Math.ceil(yobj.getInt(yobj.fsInput.val())*.2);
                 this.postMsg('msg_show_dlg', '您好，保底金额至少为总金额的20%，至少<span class="red">' + minFs + '</span>份！', function (){
                      yobj.bdInput.input.doProp('select');
                      yobj.bdInput.val(minFs)
                 })
            }else{
                isshow = this.one('#gk1').checked ? 0 : (this.one('#gk2').checked ? 1 : 2);
                tmp = this.need('#caseInfo').one();
                return {//合买参数
                    allnum: this.fs,
                    buynum: this.rg,
                    isbaodi: this.one('#isbaodi').checked ? 1 : 0,
                    baodinum: this.bd,
                    isshow: isshow,
                    totalmoney: this.data.totalmoney,
                    money: this.data.totalmoney/this.fs*this.rg,
                    title: this.need('#caseTitle').val(),
                    content: tmp.value == tmp.defaultValue ? '' : tmp.value,
                    buyuser: this.one('#dx2').checked ? this.need('#fixobj textarea').val() : 'all',
                    isset_buyuser: this.one('#dx2').checked ? 2 : 1
                }  
            }
         }
    });
//购买请求类
    Class('BuySender', {
        index:function (){
			
           Class.C('expect', this.get('#expect').val());//expect
           if (this.get('#case_ad textarea').size()) {// content
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
           if (this.get('#case_ad input').size()) {//title
               this.lib.DataInput({
                    input:'#case_ad input',
                    type: 'default',
                    len: 20,
                    change: function (val){
                        this.input.next('span').html('已输入'+val.length+'个字符，最多20个')
                    }
               })               
           };
            this.onMsg('msg_buy_dg', function (listParam){ 
				
                this.overflowMoney(listParam.totalmoney) && this.doDg(listParam)
            });   
            this.onMsg('msg_buy_hm', function (listParam){//号码列表参数
                var hm = this.postMsg('msg_get_hm_param');// 取得合买参数
                 if (hm.data) {
                      this.overflowMoney(listParam.totalmoney) && this.doHm(listParam, hm.data)                 
                 }else if(this.C('isbx')){//补选
                     this.doHm(listParam, {
                        pid: this.C('pid')
                     })
                 }
            });
        },
        overflowMoney: function (totalmoney){
            if (this.C('isEnd')) {
                this.alert('您好，'+this.C('lot-ch-name')+this.C('expect')+'期已截止！');
                return false
            }
            var limit = this.getLimit();
            var type = this.getPlayText();
            if (totalmoney < limit.min) {
                 this.alert('您好，'+type+'投注最小限制金额为'+Number(limit.min).rmb()+'元！');
                 return false
            }else if(totalmoney > limit.max){
                 this.alert('您好，'+type+'投注最大限制金额为'+Number(limit.max).rmb()+'元！');
                 return false                
            }else{
                return true
            }
        }, 
        doDg: function (list_param){
			
            if (!this.get('#agreement_dg').nodes[0].checked) {
                 this.postMsg('msg_show_is', '<p style="text-align:center; line-height:500%">您好，您需要阅读并且同意《用户合买代购协议》！</p>', function (e, btn){
                      if (btn.id === 'confirm_dlg_yes') {
                         this.one('#agreement_dg').checked = true                     
                      }
                  }, '温馨提示', '同意')
            }else{
                 this.getMoney(list_param, function (){
                      var param, Y, isupload;
                      Y = this;
                      isupload = list_param.isupload;
                      param = this.mix(list_param, this.getParam());// 由列表参数+基本参数
                      if (Class.C('play_name') == 'sc') {
                          param.isupload = isupload
                      }
                      var tplParam = this.mix(this.getVSHtml(param), {
                            play: this.getPlayText(),
                            beishu: list_param.beishu,
                            zhushu: list_param.zhushu,
                            buymoney: param.totalmoney.rmb(),
                            codesHidden: Class.C('isyt') || Class.C('isds') ? 'none' : '',
                            dthidden:  Class.C('isdt') ? '' : 'none'
                      });
                      if (Class.C('play_name') == 'sc' ) {
                          tplParam.ytcase = '<p style="text-align: left;padding: 20px 5px">'+param.codes + '<p>'
                      }
                      this.popIsWin(tpl_isdg.tpl(tplParam), function (){
                          if (Class.C('isdt')) {
                              param.codes = param.dtcodes;
                              delete param.dtcodes;
                          }
						 
                          Class.C('play_name') == 'sc' ? Y.doSc(param) : Y.doBuy(param)                                
                      })    
                 })
            }
        },
        getVSHtml: function ( param){
            var isyt = Class.C('isyt');
            var isbx = Class.C('isbx');
            var isdt = Class.C('isdt');
            var issc = Class.C('play_name') == 'sc';
            var isR9 = this.get('#ticket_type').val() == '10000';
            var vsLen =  isR9 ? 14 : this.getLotInfo().vsLen;
            var cs = '';
            if (vsLen == 12 || vsLen == 8) {
                vsLen = vsLen/2;
                cs='colspan="2"'
            }
            return {
                index: this.repeat(vsLen ,function (i){
                    return '<th '+cs+'>'+(i+1)+'</th>'
                }).join(''),
                vsName: (isyt || issc) && !isbx? '' : this.postMsg('msg_get_vslist').data.map(function (t){
                    return '<td><div class="texts">' + t.replace(',','<span class="gray">VS</span>').replace(/(半|全)/, '<span class="red">$1</span>') + '</div></td>'
                }).join(''),
                code: param.codes.split(',').map(function (c){
                    return '<td>'+c+'</td>'
                }).join(''),
                 dan: param.dtxx ? param.dtxx.map(function (x, i){
                     return '<td>'+(x == '&nbsp;' ? x : ('<span class="red">'+x+'</span>'))+'</td>'
                 }).join('') : '<td colspan="13">&nbsp;</td>'
              }            
        },
        doHm: function (list_data, hm_param){
			 this.mix(list_data, hm_param);
             this.getMoney(list_data, function (){
                  var y, param, codes, ext, isyt, isbx, isdt, issc, isupload, vsLen;
                  y = this;
                  isyt = Class.C('isyt');
                  isbx = Class.C('isbx');
                  isdt = Class.C('isdt');
                  isds = Class.C('isds');
                  issc = Class.C('play_name') == 'sc';
                  isupload = list_data.isupload;
				  param = this.mix(list_data, this.getParam());// 列表+合买+基本参数
				  if (Class.C('play_name') == 'sc') {
                      param.isupload = isupload
                  }
                  var tplData = this.getVSHtml(param);
				 
				  if(param.isshow==undefined){
					 param.isshow=this.get("#isshow").val();  
				  }
                  this.mix(tplData, {
                        hidetype: ['完全公开','截止后公开','仅对参与人公开'][param.isshow] || '',
                        codesHidden: (isyt || isds) && !isbx ? 'none' : '',
                        dthidden:  Class.C('isdt') ? '' : 'none',
                        ytcase: isyt ? this.postMsg('msg_get_ytcase').data : ''//预投方案                  
                  });
                  if (isbx){
                        this.mix(tplData, {
                            play: ('复式合买'),
                            allmoney: param.totalmoney.rmb(),
                            buymun: this.get('#anumber').val(),
                            beishu: this.get('#beishu').val(),
                            zhushu: this.get('#allmoney').val()/2,
                            buyscale: (param.buynum/param.allnum*100).toFixed(2),
                            bdscale: param.baodinum ? (param.baodinum/param.allnum*100).toFixed(2) + '%' : '未保底',
                            tc_bili: param.tc_bili+'%',
                            rghidden: 'none',
                            buymoney: this.get('#allmoney').val()
                      })                  
                  }else{                      
                        this.mix(tplData, {
                            expect: param.expect,
                            play: this.getPlayText(),
                            allmoney: param.totalmoney.rmb(),
                            unitmoney: (param.totalmoney/ param.allnum).rmb(),
                            buymun: param.buynum,
                            beishu: param.beishu,
                            zhushu: param.zhushu,
                            buyscale: (param.buynum/param.allnum*100).toFixed(2),
                            needmoney: (param.totalmoney/param.allnum*param.buynum).rmb(),
                            baodi: param.baodinum,
                            bdscale: param.baodinum ? (param.baodinum/param.allnum*100).toFixed(2) + '%' : '未保底',
                            tc_bili: param.tc_bili+'%',
                            buymoney: param.money.rmb()
                       })
                  }
                  if (issc) {
                      tplData.ytcase = '<p style="text-align: left;padding: 20px 5px">'+param.codes + '<p>'
                  }
				 
                  //确认合买
                  this.popIsWin(tpl_ishm.tpl(tplData),function (){
                      if (isdt) {
                          param.codes = param.dtcodes;
                          delete param.dtcodes;
                      }
                      Class.config('play_name') == 'sc' ? y.doSc(param) : y.doBuy(param)               
                  });                
             })
        },
        // 单式上传
        doSc: function (param){//合买分支
		    param.tc_bili = this.get('#tcSelect').val();
            param.play_method = this.get('#play_method').val();
			param.end_time = this.get('#end_time').val();
			 // this.mix(param, this.getParam());//添加基本参数
            this.postMsg('msg_show_dlg', '正在提交您的订单, 请稍后...', false, true);
            delete param.money;
			//log(param);//单式
            this.sendForm({
                form:'#suc_form',
                data: param,
                end: function (data){
                    var j;
                    if (j = this.dejson(data.text)) {
                        if (j.errcode == 0 && j.headerurl) {
                           window.location.href = '/'+j.headerurl.replace(/amp;/g,'')
                        }else{
                            this.postMsg('msg_show_dlg', j.msg);
                        }
                    }else{
						//log(data);
                      this.postMsg('msg_show_dlg', '网络故障, 请检查您的投注记录后重新提交!')
					  //跑到这一步一定是程序出错了
                   }
				   //log(data);//上传结果
                }
            })
        },
        getMoney: function (list_param, fn){//检查余额
		    var money = list_param.money || list_param.totalmoney;//有合买与代购之分
            if (this.C('isbx')) {
                fn.call(this)
            }else{
                this.ajax({
                    url:Class.config('root') + 'user/ajax_user_money',
                    end:function (data, i){
						var d;
                        if (d = this.dejson(data.text)) {
                            if (d.userMoney < money) {
                                //充值d.userMoney, o.money
                                this.postMsg('msg_show_addmoney',function (){
                                    window.open(Class.config('add-money-url'))     
                                })
                            }else{
                                fn.call(this)
                            }
                        }
                    }
                });                
            }
        },
        getParam: function (info){
			var base = {
                ticket_type: this.need('#ticket_type').val(),
                play_method: this.get('#play_method').val(),
                ishm: Class.config('buy_type') == 1 ? 1 : 0,
				tc_bili:this.get('#tcSelect').val(),
				end_time:this.get('#end_time').val(),
				buymun:this.get('#anumber').val()
				/*baodinum:this.get('#baodinum').val(),
				allnum:this.get('#anumber').val()		*/		
            }
            this.mix(base, this.C('isbx') ? {
                pid: this.get('#pid').val()
            } : {
                expect: this.need('#expect').val(),
                isupload: this.C('isyt') ? 0 : 1//1一般投注, 0 预投
            });
            if (Class.C('hasddsh')) {
                base.hasddsh = 1;
                base.ddsh = Class.config('last-ddsh');
            };
			if(this.get('#is_select_code').val()){
			    base.is_select_code = this.get('#is_select_code').val();
			}
            /*if (this.C('auto-ds-tc') !== false && (Class.config('play_name') == 'lr' || Class.config('play_name') == 'sc')) {
                base.tc_bili = 4//单式的提成自动为4%, 如未指定
            }*/
			
			return base
         },
         doBuy: function (param){
              this.chkLimitCode(param.codes, function (){
                  this.lastBuy(param)//限号检测
              }) 
         },
         lastBuy: function (param){
			 //log(param);
			 if(Class.C('has_submit')){
				  return false;	
			 }
			 Class.C('has_submit',true);
			 param.isupload=0;
			 var url, type;
			 this.postMsg('msg_show_dlg', '正在提交您的订单，请稍后...', null, true);
             type = Class.config('play_name');
             url = type == 'sc' ? Class.config('dsfq') : Class.config('fsfq');
             url = Class.C('isbx') ? Class.C('bxfq') : url; //补选的地址不同
			 delete param.money;//去掉money这个key
             delete param.msg;
			 //log(param);
			 //exit;
			 this.ajax({
                 url: url,
                 type: 'POST',
                 data: param,
                 end: function (data, i){
					//log(data);//查看结果数据，不能册除
                        var j;
                        if(j = this.dejson(data.text)){
                            if (j.errcode == 0) {//成功
                                this.postMsg('msg_buy_success');
                                if (j.headerurl) {
                                    location.href = '/'+j.headerurl//跳转
                                }else{
                                    this.postMsg('msg_show_dlg', j.msg);
                                    this.postMsg('msg_update_userMoney');//刷新余额，如果跳转，可能被浏览器取消                            
                                }
                            }else{//不成功
                                 this.postMsg('msg_show_dlg', j.msg);
                            }
                        }else{
							//log(data);
                            this.postMsg('msg_show_dlg', '网络故障, 请检查您的投注记录后重新提交!')
							//跑到这一步一定是程序出错了
                        }
                    }
             });             
         }
    });
//对阵根类
    Class('Choose', {   
        index:function (){
            //指数切换
			
            var tds = this.get('#vsTable td').filter(function (td){
                return td.id.indexOf('index_') > -1
            });
            this.get('#dataSwtch').change(function (e, Y){
                var id = 'index_'+this.value;
                tds.each(function (td){
                    Y.showNode(td, td.id.indexOf(id) > -1)
                });
                var title = this.value == 1 ? ['水位', '盘口', '水位'] : ['胜', '平', '负'];
                Y.get('#t_show td').each(function (td, i){
                    td.innerHTML = title[i]
                })
            });
            this.isdt = this.get('#play_method').val() == '123' // 任九胆拖
            var ticket_type = this.get('#ticket_type').val();
            if (ticket_type == '10000' || ticket_type == '1') {
                this.colorPercentage();
            }			
        },
        upMoney: function (need){
            this.get('#buyMoneySpan').html(need.rmb());
            this.get('#buySYSpan').html(Math.max(0, Class.config('userMoney') - need).rmb());     
        },
		//将前五的投注比例标红
		colorPercentage : function() {
			var spans = this.get('#vsTable td.last_td span');
			if (spans.nodes.length == 0) return;
			var percentages = spans.each( function(_span) {
				this.push( parseFloat(_span.innerHTML) );
			}, [] );
			percentages.sort( function(a, b) { return b - a } ); //降序
			if (!percentages[4]) return;
			spans.each( function(_span, i) {
				if (parseFloat(_span.innerHTML) >= percentages[4]) {
					this.get(_span).addClass('red');
				}
			}, this );
		}
    });
//选号器
    Class('Choose>SfcChoose',{
        focusCss: 'sp_xz',
        index:function (){
			this.base();
            this.init();
            this.bindMsg();
            this.fromCookie();
        },
        fromCookie: function (){
            var json,
                ticket_type = this.get('#ticket_type').val(),
                cookie = this.cookie(ticket_type+'_codes');
            this.cookie(ticket_type+'_codes', '0', {timeout: -1, path:'/'});
            if (cookie) {
                if (json = this.dejson(decodeURIComponent(cookie))) {
                    this.redraw((json.codes+'').split(','))
                }
            }
        }, 
        redraw: function (codes){
		  var ini = this.getLotInfo(),
                index=0, map= ini.vsLen == 8 ? [0, 1, 2, 3] : [2, 1, 0];  
             this.get('#vsTable tr').each(function (tr, i){
                if (tr.getAttribute('data-vs')) {
                    var code = (codes[index]+''),
                        btns = this.get('span.sp_nxz', tr);
                    code.split('').each(function (n, j){
                        if (!isNaN(n)) {
                            var el = btns.eq(map[n]).one();
                            if (el) {
                                this._select.call(el, {}, this)
                            }                            
                        }
                    }, this);
                    index++;
                }
            }, this)
        },
        _select: function (e, Y){
			
            var max, old, ini = Y.get(this).parent('tr').data('row_data');
            Y.toggleClass(this, Y.focusCss);
            old = ini.data;
            ini.data = ini.balls.nodes.map(function (b, i){
                return b.className.indexOf(Y.focusCss) > -1 ? Y.getInt(b.innerHTML) : ''
            }).join('');
            max = Y._doCount();
            if (!this.isyt && max) {
                Y.alert(Y.isR9 ? '您好，任选九场复式最多只能选择9场比赛！' : '您好，复式投注最大限制金额为'+max.rmb()+'元！');
                Y.toggleClass(this, Y.focusCss);//还原
                ini.data = old//还原
            }
            ini.chk.prop('checked', Y.get(this).parent('td').find('span.'+Y.focusCss).size() == ini.balls.size());
        },
        init: function (){
            var list = [], focusCss = this.focusCss, self = this;
            var vslist = [];
            var s160 = RegExp(String.fromCharCode(160),'g');//属性值对&nbsp;转为160
            var isyt = this.C('isyt');
            this.isyt = isyt;
            this.isR9 = this.get('#play_method').val() == '2';
            this.get('#vsTable tr').each(function (tr, i){
                if (tr.getAttribute('data-vs')) {
                    var data = {
                        index: self.getInt(tr.cells[0].innerHTML),
                        vs: tr.getAttribute('data-vs').replace(s160,'<br/>'),
                        balls: Yobj.get('span.sp_nxz', tr),
                        chk: Yobj.get(':checkbox', tr),
                        data:''
                    }
                    vslist[vslist.length] =data.vs;
                    Yobj.attr(tr, 'row_data', data);
                    data.chk.prop('checked', false);
                    list[list.length] = data
                }
            });
            this.vslist = this._vslist = vslist;
            this.onMsg('msg_get_vslist', function (){
                return this.vslist
            });
            this.get('#vsTable').live('span.sp_nxz', 'mousedown', function (e, Y){//单选
                var max, old, ini = Y.get(this).parent('tr').data('row_data');
                Y.toggleClass(this, focusCss);
                old = ini.data;
                ini.data = ini.balls.nodes.map(function (b, i){
                    return b.className.indexOf(focusCss) > -1 ? Y.getInt(b.innerHTML) : ''
                }).join('');
                max = self._doCount();
                if (!isyt && max) {
                     self.alert(self.isR9 ? '您好，任选九场复式最多只能选择9场比赛！' : '您好，复式投注最大限制金额为'+max.rmb()+'元！');
                    Y.toggleClass(this, focusCss);//还原
                    ini.data = old//还原
                }
                ini.chk.prop('checked', Y.get(this).parent('td').find('span.'+focusCss).size() == ini.balls.size());
            });
            this.get('#vsTable').live(':checkbox', 'click', function (e, Y){//全选
                var max, old, oldCss = [], ini = Y.get(this).parent('tr').data('row_data');
                ini.balls.each(function (ball, i){
                    oldCss[i] = ball.className
                })
                ini.balls[this.checked ? 'addClass' : 'removeClass'](focusCss);
                old = ini.data;
                ini.data = ini.balls.nodes.map(function (b, i){
                    return b.className.indexOf(focusCss) > -1 ? Y.getInt(b.innerHTML) : ''
                }).join('');
                max = self._doCount();
                if (!isyt && max) {
                    self.alert(self.isR9 ? '您好，您好，任选九场复式最多只能选择9场比赛！' : '您好，复式投注最大限制金额为'+max.rmb()+'元！');
                    this.checked = !this.checked;
                     ini.balls.each(function (ball, i){
                         ball.className = oldCss[i]
                    })//还原
                    ini.data = old//还原
                }
            });
            this.beishu = 1;
            this.zhushu = 0;
            this.totalmoney = 0;
            this.codes = '';
            this.vsData = list;
            this.nums = [0,0,0,0];
            this.moneySpan = this.need('#moneySpan');
            this.zsSpan = this.get('#zsSpan');
            if (!this.C('isyt') && !this.C('isbx')) {
                this.bsInput = this.lib.DataInput({
                    input:'#bsInput',
                    initVal: 1,
                    min:1,
                    overflowFix:true
                });
                this.bsInput.onchange = function (){
                    var max, old;
                    old = self.beishu;
                    self.beishu = this.getInt(this.input.val());
                    if (max = self._change()) {
                        self.alert('您好，复式投注最大限制金额为'+max.rmb()+'元！');
                        this.input.val(old)
                    }
                } 
                this.beishu = this.getInt(this.bsInput.input.val());                
            }else{
                this.buyNum = [
                    this.getInt(this.get('#one').html()),    
                    this.getInt(this.get('#two').html()),    
                    this.getInt(this.get('#three').html())
                ]
            }
        },
        bindMsg: function (){
            this.onMsg('msg_get_list_data', function (){
                var msg, m, cur, nn;
                nn = ['单', '双', '三', '四'];
                if (this.C('isbx')) {//补投的个数检查
                    m = [];
                    this.buyNum.each(function (n, i){
                        cur = this.nums[i];
                        if (n != cur) {
                            m.push(nn[i]+'选的个数(<span style="color:red">'+cur+'</span>)'+(n>cur?'小':'大')+'于预投的个数(<span style="color:#0080ff">'+n+'</span>)')
                        }
                    }, this);
                    if (m.length) {
                        msg = '您好，您选择的<br/>'+m.join('，<br/>')+'，<br/>请重新选择！'
						
                    }
                }
				//log(this.codes);
                return {
                    zhushu: this.zhushu,
                    beishu: this.beishu,
                    totalmoney: this.totalmoney,
                    codes: this.codes,
                    code: this.nums.join(','),
                    msg: msg
                }
            })         
        },
         _doCount: function (){//每次用vsData统计选号
             var zs, codes, nums;
             zs = 1;
             codes = [];
             nums = [];
             this.vsData.each(function (row,i){
                 if (row.data.length) {
                     codes[codes.length] = row.data ? row.data : '*';
                     nums[nums.length] = row.data.length;
                     zs*=row.data.length;
                 }else if(!this.isR9){
                     zs = 0;
                 }else{
                     codes[codes.length] = '*';//r9
                 }
             }, this);
             if (this.C('isbx')) {
                 this._getNum(nums)
             }
             if(this.isR9){
                 if (nums.length > 9) {
                     return 9
                 }else if(nums.length < 9){
                     zs = 0
                 }
             }
             this.zhushu = zs;
             this.codes = codes.join(',');
             return this._change()
         },
         _getNum: function (nums){//补投的个数
             nums = nums.sort(Array.up).join('');//11122333
             this.nums = [
                nums.replace(/[^1]/g,'').length,    
                nums.replace(/[^2]/g,'').length,    
                nums.replace(/[^3]/g,'').length
             ];
             this.get('#s1Span').html(this.nums[0]);
             this.get('#s2Span').html(this.nums[1]);
             this.get('#s3Span').html(this.nums[2]);
             if (this.get('#four')) {
                 this.nums.push(nums.replace(/[^4]/g,'').length);
                this.get('#s4Span').html(this.nums[3]);
             }
         },
         _change: function (){
             var zs, bs, pr, m, max;
             zs = this.zhushu;
             bs = this.beishu;
             pr = this.C('price');
             m = zs * bs * pr;
             max = this.getLimit().max;
             if (m > max) {
                 return max
             }
             this.zsSpan.html(zs);
             this.totalmoney = m;
             this.moneySpan.html(this.getInt(m).rmb());
             this.upMoney(m);
             this.postMsg('msg_list_change', {
                zhushu: zs,
                beishu: bs,
                totalmoney: m
             })             
         }
    });
//胆拖选号器
    Class('Choose>DtChoose',{
        focusCss: 'sp_xz',
        index:function (){
            this.base();
            this.init();
            this.bindMsg()
        },
        init: function (){
            var list = [], focusCss = this.focusCss, self = this;
            var vslist = [];
            var s160 = RegExp(String.fromCharCode(160),'g');//属性值对&nbsp;转为160
            var isyt = this.C('isyt');
            this.isR9 = this.get('#ticket_type').val() == '10000';
            this.get('#vsTable tr').each(function (tr, i){
                if (tr.getAttribute('data-vs')) {
                    var btns = Yobj.get('span.ba', tr);
                    var data = {
                        vs: tr.getAttribute('data-vs').replace(s160,'<br/>'),
                        balls: Yobj.get('span.sp_ball', tr),
                        chk: Yobj.get('span.sp_all', tr),
                        dan: Yobj.get(':checkbox', tr),
                        data:'',
                        isdan: false
                    }
                    vslist[vslist.length] =data.vs;
                    Yobj.attr(tr, 'row_data', data);
                    data.dan.prop('checked', false);
                    list[list.length] = data
                }
            });
            this.vslist = this._vslist = vslist;
            this.onMsg('msg_get_vslist', function (){
                return this.vslist
            });
            this.get('#vsTable').live('span.sp_ball', 'mousedown', function (e, Y){//单选
                var max, old, ini = Y.get(this).parent('tr').data('row_data');
                Y.toggleClass(this, focusCss);
                old = ini.data;
                ini.data = ini.balls.nodes.map(function (b, i){
                    return b.className.indexOf(focusCss) > -1 ? Y.getInt(b.innerHTML) : ''
                }).join('');
                max = self._doCount();
                if (max) {
                     self.alert('您好，复式投注最大限制金额为'+max.rmb()+'元！');
                    Y.toggleClass(this, focusCss);//还原
                    ini.data = old//还原
                }
                var isall = Y.get(this).parent('td').find('span.'+focusCss).size() == ini.balls.size();
                ini.chk[isall ? 'addClass' : 'removeClass'](focusCss);
                ini.chk.html(isall ? '清' : '全');
                if (ini.data.length == 0) {
                    ini.dan.prop('checked', false)
                }    
            });
            this.get('#vsTable').live('span.sp_all', 'mousedown', function (e, Y){//全选
                var max, old, oldCss = [], ini = Y.get(this).parent('tr').data('row_data'), ischecked;
                ini.balls.each(function (ball, i){
                    oldCss[i] = ball.className
                });
                Y.toggleClass(this, focusCss);
                ischecked = Y.hasClass(this, focusCss);
                Y.get(this).html(ischecked ? '清' : '全');
                ini.balls[ischecked ? 'addClass' : 'removeClass'](focusCss);
                old = ini.data;
                ini.data = ini.balls.nodes.map(function (b, i){
                    return b.className.indexOf(focusCss) > -1 ? Y.getInt(b.innerHTML) : ''
                }).join('');
                max = self._doCount();
                if (max) {
                    self.alert('您好，复式投注最大限制金额为'+max.rmb()+'元！');
                    this.checked = !this.checked;
                     ini.balls.each(function (ball, i){
                         ball.className = oldCss[i]
                    })//还原
                    ini.data = old//还原
                    Y.toggleClass(this, focusCss);
                    ischecked = Y.hasClass(this, focusCss);
                    Y.get(this).html(ischecked ? '清' : '全');
                };
                if (ini.data.length == 0) {
                    ini.dan.prop('checked', false)
                }                
            });
            this.get('#vsTable').live(':checkbox', 'click', function (e, Y){
                var ini = Y.get(this).parent('tr').data('row_data'), old;
                old = ini.data;
                if (ini.data.length == 0 && this.checked) {
                    self.alert('您好，请选择至少选择一个号码后再选胆！');
                    return this.checked = false
                }
               if (Y.dan > 7 && this.checked) {
                    self.alert('您好，最多只能选择8个胆！');
                    return this.checked = false                   
               }
                ini.isdan = this.checked;
                max = self._doCount();
                if (max) {
                    self.alert('您好，复式投注最大限制金额为'+max.rmb()+'元！');
                    this.checked = !this.checked;
                    ini.data = old//还原
                    ini.isdan =  this.checked
                }
            });
            this.beishu = 1;
            this.zhushu = 0;
            this.totalmoney = 0;
            this.dan = 0;
            this.codes = '';
            this.dtcodes = '';
            this.vsData = list;
            this.dtxx = [];
            this.moneySpan = this.need('#moneySpan');
            this.zsSpan = this.get('#zsSpan');
            this.bsInput = this.lib.DataInput({
                input:'#bsInput',
                initVal: 1,
                min:1,
                overflowFix:true
            });
            this.bsInput.onchange = function (){
                var max, old;
                old = self.beishu;
                self.beishu = this.getInt(this.input.val());
                if (max = self._change()) {
                    self.alert('您好，复式投注最大限制金额为'+max.rmb()+'元！');
                    this.input.val(old)
                }
            } 
            this.beishu = this.getInt(this.bsInput.input.val());
        },
        bindMsg: function (){
            this.onMsg('msg_get_list_data', function (){
                return {
                    zhushu: this.zhushu,
                    beishu: this.beishu,
                    totalmoney: this.totalmoney,
                    codes: this.codes,
                    dtcodes: this.dtcodes,
                    dtxx: this.dtxx
                }
            })         
        },
         _doCount: function (){//每次用vsData统计选号
             var zs, codes, vs, dan, tuo, maxHit, tcodes, dcodes,dtxx;
             zs = 0;
             codes = [];
             dan = [];
             dcodes = [];
             tuo = [];
             tcodes = [];
             vs=[];
             dtxx = [];
             this.vsData.each(function (row,i){
                 var data = row.data.length;
                 if (row.data.length) {
                     codes[codes.length] = row.data;
                     if (row.isdan) {
                         dan[dan.length] = data;
                         dcodes[dcodes.length] = row.data;
                         tcodes[tcodes.length] = '*';
                         dtxx.push('√');
                     }else{
                         tuo[tuo.length] = data;
                         tcodes[tcodes.length] = row.data;
                         dcodes[dcodes.length] = '*';
                         dtxx.push('&nbsp;')
                     }
                     vs.push(row.vs)
                 }else{
                     codes[codes.length] = '*';
                     dcodes[dcodes.length] = '*';
                     tcodes[tcodes.length] = '*';
                     dtxx.push('&nbsp;')
                 }
             }, this);
             zs = this._getDtCount(dan, tuo);
             this.maxHit = Math.c(tuo.length, 9 - dan.length);
             this.zhushu = zs;
             this.dtxx = dtxx;
             this.dan = dan.length;
             this.codes = codes.join(',');
             this.dtcodes = '[D:'+dcodes.join(',')+'][T:'+tcodes.join(',')+']';
             return this._change()
         },
         _getDtCount: function (d, t){//[1,1,2,3]
             var list, sum;
             sum = 0;
             list = d.length ? Math.dtl(d, t, 9) : Math.cl(t, 9);
             list.each(function (arr){
                 sum+=arr.reduce(function (p, n){
                     return p*=n
                 }, 1)
             });
             return sum             
         },
         _change: function (){
             var zs, bs, pr, m, max;
             zs = this.zhushu;
             bs = this.beishu;
             pr = this.C('price');
             m = zs * bs * pr;
             max = this.getLimit().max;
             if (m > max) {
                 return max
             }
             this.zsSpan.html(zs);
             this.totalmoney = m;
             this.get('#maxZs').html(this.maxHit);
             this.moneySpan.html(this.getInt(m).rmb());
             this.upMoney(m);
             this.postMsg('msg_list_change', {
                zhushu: zs,
                beishu: bs,
                totalmoney: m
             })             
         }
    });
//预投选号器
    Class('Choose>SfcYtChoose',{
        index: function (){
            this.base();
            this.vsLen = this.getLotInfo().vsLen;
            this._bindDom();
            this.bindMsg();
        },
        _bindDom: function (){
            var Y, all, end, vsLen, len, _code;
            Y = this;
            this.isR9 = this.get('#play_method').val() == '2';
    //bs
            this.bsInput = this.lib.DataInput({
                input: '#bsInput',
                len:7,
                initVal:1
            });
            this.bsInput.onchange= function (){
                Y.beishu = Y.getInt(this.input.val());
                Y._change()
            };
            this.zsSpan = this.need('#zsSpan');
            this.moneySpan = this.need('#moneySpan');
    // select
            this.zhushu = 1;
            this.beishu = 1;
            _code = [];
            all = this.get('#prevInput :text');
            end = all.eq(-1).one();
            vsLen = this.vsLen;
            len = all.size();
            all.each(function (el, i){
                var last = i == (len - 1);
                var ins = Y.lib.DataInput({
                    input: el,
                    initVal: last  ? vsLen : 0
                });
                ins.onchange = _change;
                _code[_code.length] = last ? vsLen : 0;
                if (last) {
                    _change.call(ins)//手工触发一次初始化
                }
            });
            this.code = _code;
    // num-change
            function _change(){
                var cur, c, v, zs, code, count;
                cur = this.input.one();
                c = all.nodes.slice(0,-1).reduce(function (a, el){
                  return a + (cur === el ? 0 : Y.getInt(el.value))  
                },0);
                v = this.getInt(cur.value);
                if (c + v > vsLen) {
                    cur.value = vsLen - c
                }
                if (cur !== end) {
                    end.value = Math.max(0, vsLen - (v + c))
                }
                zs = 1;
                count = 0;
                code = [];
                all.each(function (el, i){
                    var v = Y.getInt(el.value);
                    code[i] = v;
                    count += v;
                    if (v > 0) {
                        zs *= Math.pow(len - i, v)
                    }
                });
                Y.code = code;
                Y.zhushu = count < vsLen ? 0 : zs;
                Y._change()
            }
        },
        bindMsg: function (){
            this.onMsg('msg_get_list_data', function (){
                var msg, max;
                max = this.getLimit().max;
                if (this.codes.length < this.vsLen) {
                    msg = '您好，'+this.C('lot-ch-name')+'复式预投个数总和为'+this.vsLen+'个，请核对修改后再投注！'
                }else if(this.totalmoney > max){
                    msg = '您好，'+this.C('lot-ch-name')+'复式投注最大限制金额为'+max.rmb()+'元！'
                }
                return {
                    zhushu: this.zhushu,
                    beishu: this.beishu,
                    totalmoney: this.totalmoney,
                    codes: this.codes.join(','),
                    msg: msg
                }
            });
            this.onMsg('msg_get_ytcase', function (){
                var ch = ['四', '三', '双', '单'].slice(-this.code.length);
                var code_ch = this.code.map(function (el, i){
                    return el + '个' + ch[i] + '选'
                });
                return '<p style="text-align:left; padding: 20px 5px">您的预投选号方案为：'+ code_ch.join('、') + '，共<span class="red">'+this.zhushu+'</span>注</p>'
            })
        },
        _change: function (){
             var zs, bs, pr, m, max, len, count,_chr;
             zs = this.zhushu;
             bs = this.beishu;
             pr = this.C('price');
             m = zs * bs * pr;
             max = this.getLimit().max;
             if (m > max) {
                 var lot = this.getLotInfo();
                  this.alert('您好，'+lot.name+'复式投注最大限制金额为'+max.rmb()+'元！')
             }             
             this.codes = [];
             len = this.code.length;
             count = 0;
             _chr = this.isR9 ? '-----------' : '**********';
             this.code.each(function (n, i){//n is count, i is 321
                 count += n;
                 this.codes = this.codes.concat(this.repeat(n, function (){
                     return _chr.slice(0, len - i)
                 }))
             }, this);
             if (this.isR9) {
                 this.codes = this.codes.concat(['*','*','*','*','*'])
             }
             this.get('#sizeErr').show(count < this.vsLen);
             this.zsSpan.html(zs);
             this.totalmoney = m;
             this.moneySpan.html(this.getInt(m).rmb());
             this.upMoney(m);
             this.postMsg('msg_list_change', {
                zhushu: zs,
                beishu: bs,
                totalmoney: m
             })
        }
    });
    /*
单式上传类
    */
    Class('DsUpload', {
        index:function (config){
            this.addElements(config);
            this.defineMsg();
        },

        addElements: function (config){
            var Y = this, min;
            min = Class.config('price');
            this.dsInput = new this.lib.DataInput({
                input: '#dsInput',
                initVal: 5,
                len: 6,
                min:0
            });
            this.input = this.dsInput.input.one();
            this.zhushu = 0;
            this.beishu = 1;
            this.totalmoney = 0;
            this.dsInput.onchange = function (){
                var zs, dj;
                dj = Class.config('price');
                zs = Y.getInt(this.input.val());
                Y.zhushu = zs;
                Y.totalmoney = zs * dj;
                
                var limit, data = {
                    zhushu: Y.zhushu,
                    beishu: Y.beishu,
                    totalmoney: Y.totalmoney
                }
                this.get('#dsMoney').html(data.totalmoney);
                Y.postMsg('msg_list_change', data);
                limit = this.getLimit();
                this.updateBalance(Y.totalmoney);
                if (data.totalmoney < limit.min) {
                    Y.getTip().show(this.input,'<h5>投注金额限制</h5>您发起的方案金额不能少于'+limit.min.rmb()+'元, 请修改!').setIco(3);
                }else if(data.totalmoney > limit.max){
                    Y.getTip().show(this.input,'<h5>投注金额限制</h5>您发起的方案金额不能大于'+limit.max.rmb()+'元, 请修改!').setIco(3);
                }else{
                    Y.getTip().hide()
                }
            };
            this.dsInput.onchange();
        },
        
        defineMsg: function (){
            this.onMsg('msg_check_sc_err', function (){// 检查上传表单
                var err, file, input, zs, bs, money, min, max, pe;
                file = this.one('#upfile');
                zs = this.zhushu;
                bs = this.beishu;
                money = this.totalmoney;
                limit = this.getLimit();
                input = this.input;
                if (!zs) {
                    err = '您好，您发起方案的注数不能为0！';
                }else if (money % 2) {
                    err = '您好，选择单倍投注金额要整除2，才能发起投注。';
                }else if(money < limit.min){
                    err = '您好，您发起方案的金额不能小于'+limit.min.rmb()+'元！';          
                }else if(money > limit.max){
                    err = '您好，您发起方案的金额不能大于'+limit.max.rmb()+'元！';
                }else if (this.get('#sc1').one().checked) {
                    if (file.value == '') {
                         err = '您好，请选择要上传的方案文件！'
                    }else if(!file.value.match(/\.te?xt$/i)){
                         this.clearFileInput(file);
                         this.one('#upfile').focus();
                         err = '您好，上传文件只支持txt格式，请重新上传！'
                    }
                }
                if (err) {
                    this.alert(err, function (){
                        input && input.select()
                    });
                } 
                return !!err
            });
            this.onMsg('msg_get_list_data', function (){
                var nosc = this.get('#sc2').one().checked;
                return {
                    codes: nosc ? '稍后上传' : '文本文件上传',
                    isupload: nosc ? 0 : 1,
                    zhushu: this.zhushu,
                    beishu: this.beishu,
                    totalmoney:this.totalmoney
                }
            });
             this.onMsg('msg_clear_code', (function (){
                 this.clearCode();
             }).proxy(this))
        },
        clearCode: function (){
            this.dsInput.val(2);
            this.clearFileInput('#upfile');
            this.get('#dsMoney').html(1);
        },
        clearFileInput: function (f){
            if (this.ie) {
                f.outerHTML = f.outerHTML
            }else{
                f.value = ''    
            }
        }
    });
// end
})()
