Class.extend('getSubDomain', function (sub, n){
    return location.protocol + '//' + sub + '.' + location.hostname.split('.').slice(-(n || 2)).join('.')
});

Class.C('url-passport', location.protocol + '//' + location.hostname);
Class.C('url-login-check', '/user/ajax_check_login');
Class.C('url-login-user', '/user/ajax_user_money');

Class.C('url-login-yzm', '/site/secoder?id=login_secoder');
Class.C('url-login-op', Class.C('url-passport')+'/user/login');
//第三方登陆
Class.extend('thirdLogin', function (type){
    var callback, url, popw, Y, lister, root, _name;
    root = this.getSubDomain('passport');
    switch(type){
        case 'tenpay':
            callback = root +'/login/CFLoginSet.php';
            url = root + '/login/CFUserLogin.php?timeSpan=' + ( +new Date ) + '&tourl=' + encodeURIComponent(callback);
            _name = '财付通'
            break;
        case 'zfb':
            callback =  root +'/login/zfb/loginsuccess.php';
            url = root +'/login/zfb/login.php?timeSpan=' + (+new Date) + '&tourl=' + encodeURIComponent(callback);
            _name ='支付宝'
            break;
    }
    Y = this;
    popw = window.open(url);
    lister = setInterval(function (){
        try{
            if (Y.ie > 6 && (!popw || popw.closed)) {// ie6 bug
                update();
                Y.alert.close()
            }  
        }catch(e){}
    }, 1000);         
    this.alert('您好，如果您已使用' + _name + '登陆，请关闭对话框！', update);
    return false;
    function update(){
        clearInterval(lister);
        Y.postMsg('msg_login', function (){
            Y.postMsg('msg_update_userMoney');
        });
    }
});
Class('Loginer', {//登陆器
    single: true,//单例
     index:function (config){
        var Y = this;
        this.loginDlg = this.lib.MaskLay('#loginLay');//登陆框
        this.loginDlg.addClose('#flclose a','#fclosebtn');//关闭元素
        this.get('#loginLay div.tips_title').drag('#loginLay');
        this.loginDlg.esc = true;
        this.userMoneys = '#userMoneyInfo,#userMoneyInfo2,#userMoneyInfo3';//用户信息显示面板
        //url

        this.addNoop('onlogin,onlogout');

        this.bindEvent(config);

        this.onMsg('msg_login', function (fn){//回应登陆检查
		  
		    return this.login(fn)
        });
        this.onMsg('msg_update_userMoney', function (fn){//刷新用户信息
            this.showUserInfo()
        });
        this.onMsg('msg_logout', function (fn){//回应登陆检查
            return this.logout(fn)
        });
    },

    bindEvent: function (config){
        var Y = this;
         // 表单ui
        this.user = this.need('#lu');
        this.pwd = this.need('#lp');
        this.yzm = this.need('#yzmtext');
        this.img = this.need('#login_secoder');
		this.yzm_time = this.need('#yzm_time');
        this.errorTip = this.get('#error_tips');
        var tpl = '<b class="dl_err"></b>{1}';
        //passport callback
        window.acceptLoginMsg = function (err){
			if (err) {
                Y.errorTip.html(tpl.format(err)).show();
                if (err.indexOf('验证码')>-1) {
                    Y.yzm.one().select()
                }else{
                    Y.user.one().select()
                }  
            }else{
                Y.showUserInfo();
                if (Y.isFunction(fn)) {
                    fn();
                    Y.C('loginCallback', false)
                }
                if (Y.get('#reload').val() == 1) {
                    location.href = Y.param({rnd:+new Date}, location.href)
                }
                Y.onlogin();
            }
            window.passportloginmsg = false;
            Y.one('#floginbtn').disabled = false 
        };

        this.get('#yzmup').click(function (){
            Y.img.attr('src', Y.getYzm());
            return false
        });
        this.need('#floginbtn').click(function (e, Y){
            this.disabled = true;
            Y.doLogin()
        });

 		this.user.keydown(enter);
 		this.pwd.keydown(enter);
 		this.yzm.keydown(enter);

        function enter(e, Y){
            if (e.keyCode == 13) {
                if (Y.user.val() && Y.pwd.val() && Y.yzm.val()) {
                    Y.need('#floginbtn').attr('disabled', true);
                    Y.doLogin()                    
                }
            }     
        }

        this.img.click(function (e, Y){
            this.src = Y.getYzm()
        });
        
        //登入
        this.need(config.loginBtns).click(function (e, Y){
            Y.login();
            e.end();
            return false
        });
        
        //登出
        this.need(config.logoutBtns).click(function (e, Y){
            Y.logout()
            e.end();
            return false
        });

        this.loginDlg.onpop = function (){
           Y.user.one().select();
           Y.img.show().attr('src', Y.getYzm())
        };

        this.loginDlg.onclose = function (){
            Y.user.val('');
            Y.pwd.val('');
            Y.yzm.val('');
            Y.errorTip.hide();
        }
    },
    
    login: function (fn){// 登陆
	  //  this.loginDlg.pop()//弹出登陆框
       
	   this.getLogStart(function (isLogin){
		   if (isLogin) {
                this.onlogin();
                fn && fn.call(this)
            }else{
				
                Y.C('loginCallback', fn);
                this.loginDlg.pop()//弹出登陆框
            }
        })
	 
    },

    getLogStart: function (fn){// 检查是否登陆
	    this.ajax(Class.C('url-login-check'), function (data){
		   var islogin;
            if (!data.error){
                islogin = this.dejson(data.text);
            }
		    fn.call(this, !!islogin)
        })
	   
    },
    doLogin: function (){//提交表单
	  
       var Y = this;
       var tpl = '<b class="dl_err"></b>{1}';//您输入的账户名和密码不匹配，请重新输入
       this.errorTip.show();
        if(this.user.val() == ""){
            this.errorTip.html(tpl.format("请输入合法的用户名!"));
            this.user.one().focus();
        } else if(this.pwd.val() == ""){
            this.errorTip.html(tpl.format("请输入合法的密码!"));
            this.pwd.one().focus();
        } else if(this.yzm.val() == ""){
            this.errorTip.html(tpl.format("请输入正确的验证码!"));
            this.yzm.one().focus();
        } else {
            this.errorTip.hide();
            var data = this.mix(this.qForm('#loginForm'), {
                rw: '/inc/login/loginback.php?callback=top.acceptLoginMsg',
                r: 1,
                t: 4//, pwdlevel: ''
            });
            return this.sendForm({
                data: data,
                url: this.C('url-passport')+'/user/login?ajax=1'
            })
        }
        this.one('#floginbtn').disabled = false        
    },

    getYzm: function (){
    	var nowtime = new Date
		this.yzm_time.val(+nowtime);
        return Class.C('url-login-yzm')+'?_='+(+nowtime)
    },

    showUserInfo: function (){
        this.loginDlg.close();
        this.get('#nologin_info').hide().get('#top_user_info').show();
		
		this.ajax({
          url:Class.C('url-login-user'),
          end:function (data, i){
			  var info, showText, Y;
              Y = this;
              if (data.error) {
                  this.setUserInfo('拉取用户信息失败, 请刷新重试!')
              }else{
                 if (info = this.dejson(data.text)) {
					 
                     Class.C('userMoney', parseFloat(info.userMoney)||0);
                     Class.C('userName', info.userName||'');
					 this.get('#top_username').html('您好 '+info.userName+'</a>，欢迎您！ ');//用户名
                     //this.get('#top_username').html('您好,<a href="" target="_blank">'+info.userName+'</a>&nbsp;');//用户名
                     this.get('#money').html(parseFloat(info.userMoney).rmb());//下拉菜单中
					 this.get('#fa_lanse').html(info.outstanding_plan);//下拉菜单中
					 showText = '<span><a target="_blank" href="/user" hidefocus="true">“'+info.userName+//购买表单中
                         '”</a></span>，您的账户余额为<strong class="red eng">'+(parseFloat(info.userMoney)||0).rmb()+'</strong>元【<b class="i-jb"></b><a href="/user/recharge/" target="_blank">账户充值</a>】'
                     this.setUserInfo(showText);
					
                     this.get('#buySYSpan,#buySYSpan2').html((parseFloat(info.userMoney)||0).rmb());                 
                 }
                 Y.user.val('');
                 Y.pwd.val('');
                 Y.yzm.val(''); 
                /* this.getSpaceInfo();//空间信息
                 this.getXmsInfo(info.userName);
                 this.loadMsg();
                 this.upRecorder();*/
              }
          }
        })
		try{
			if(typeof(eval("autoLoad_list"))=="function"){
				autoLoad_list();
			}
		}catch(e){
		    //alert("not function"); 	
		}
		
		
		
    },

    setUserInfo: function (x){
        this.get(this.userMoneys).html(x);
        this.get('span.if_buy_yue').show()
    },

    clearUserInfo: function (){
        this.setUserInfo('您尚未登录，请先<a href="javascript:void 0" onclick="Yobj.postMsg(\'msg_login\')">登录</a>!')
        this.get('#buySYSpan,#buySYSpan2').html((0).rmb());
        this.get('span.if_buy_yue').hide()
    },

    logout: function (fn){//退出
        var Y = this;
        this.ajax({
            url:'/user/logout',
            end: function (){
                Y.getLogStart(function (isLogin){//检查是否退出
                    if (!isLogin) {
                        this.onlogout();
                        this.get('#nologin_info').show().get('#top_user_info').hide();
                        Class.config('userMoney', 0);
                        this.clearUserInfo();
                        if (Y.isFunction(fn)) {
                            fn()
                        }
                        if (this.onlogout() === false && this.get('#reload').val() == 1) {
                            location.href = Y.param({rnd:+new Date}, location.href)
                        }
                        this.upRecorder()
                    }else{
                        alert('退出失败, 请重试!')
                    }                     
                })
            }
        })        
    },
    
    getSpaceInfo: function (username){//空间信息拉取
        var url = Class.C('url-space')+'/port/request.php?c_limit=1&c_id=0001';
        window['echo_json_0001']  = function (msg){
             var vals;//{"msg":"190,0,0,4","code":100}
             if (msg.code == 100) {
                 vals = msg.msg.split(',');
                 Y.get('#account_inner a').each(function (a, i){
                     if(i<3){
                        a.innerHTML = '<strong class="eng red">' + vals[i]+ '</strong>'
                     }
                 })
             }else{
                
             }
        };
        this.use(url)
    },
    
    getXmsInfo: function (userName){//小秘书
        var url = Class.C('url-space')+'/port/request.php?c_limit=1&c_id=0012&usernames='+encodeURIComponent(userName), Y = this,
                xmshtml = '',
                xmsopen = '';
        window['echo_json_0012']  = function (data){
             if (Y.C('showxmsed')) {
                 return
             }
             Y.C('showxmsed', true);
             var vals, timer, ico;//{"msg":[{"username":"links025","openservice":"1"}]}
             if (data && data.msg && data.msg instanceof Array) {
                 vals = data.msg[0];
                 if (vals && vals.openservice == 1) {
                    xmshtml = xmsopen
                 }
             }
             ico = Y.get(xmshtml).insert('#top_username', 'next');
             ico.hover(function (){
                 clearTimeout(timer);
                 ico.child('div').show();             
             }, function (){
                 timer = setTimeout(function() {
                     ico.child('div').hide();
                 },1000);  
             }).click(function (){
                 window.open('');
                 ico.child('div').hide();
             })
        };
        this.use(url)
    },    

    loadMsg: function (){//拉取短信
        this.ajax({
            url:'/main/ajax/usermsgset.php',
            end:function (data, i){
                if (!data.error) {
                    if (data.text) {
                        this.get('#webmsg').html(data.text)
                    }
                }
            }
        });

    },
    
    upRecorder: function (){
        if (this.get('#buyrecorder').size()) {
            this.ajax({
                url:'/main/ajax/buyrecoder.php',
                end:function (data, i){
                    if (!data.error) {
                        this.get('#buyrecorder').html(data.text)
                    }
                }
            });
        }        
    }
});

/*
 自动启动
*/
Class({
    use: 'mask, countDown',
    ready: true,

    index:function (){
        if (this.get('#loginLay').size() == 0) {
            return
        }
        this.loginer = this.lib.Loginer({
            loginBtns: '#top_login_btn',//顶部登陆
            logoutBtns: '#logoutLink'
        }); 

        this.get('#tenpaylogin').click(function (e, Y){
            Y.thirdLogin('tenpay')
        });

        this.get('#zfblogin').click(function (e, Y){
            Y.thirdLogin('zfb')
        });

        this.use('/media/js/add.js', false, {
            charset: 'utf-8'
        });

        this.cookie('buymode', 48);

        //左菜单
        this.get('li.my_account').hover(function (e, Y){
            Y.get('#account_inner').show()
            Y.get(this).addClass('c_btn')
        },function (e, Y){
            Y.get('#account_inner').hide()
            Y.get(this).removeClass('c_btn') 
        });

		//右菜单
        this.get('li.site_nav').hover(function (){
            Y.get('#quicklink').show();
            Y.get('li.site_nav a.site_nav_h').addClass('hover');
            Y.get('li.site_nav b').swapClass('c_down', 'c_up');
        }, function (){
            Y.get('#quicklink').hide();
            Y.get('li.site_nav a.site_nav_h').removeClass('hover');
            Y.get('li.site_nav b').swapClass('c_up', 'c_down');
        });

		//右菜单
        this.get('em.sub-nav-odd').hover(function (){
            Y.get('#zcdata').show();
            Y.get('em.sub-nav-odd').addClass('on');
            Y.get('em.sub-nav-odd b').addClass('c_up');
        }, function (){
            Y.get('#zcdata').hide();
            Y.get('em.sub-nav-odd').removeClass('on');
            Y.get('em.sub-nav-odd b').removeClass('c_up');
        });

        if (this.get('#countDownSpan,#responseJson,#countDownData').size() > 1) {
            this.setCountDown()//如果有时间数据和显示标签则运行倒计时
        }

        this.loginer.getLogStart(function (isLogin){
            if (isLogin) {
                this.showUserInfo()//如果已登陆,拉取空间数据.
                this.get('span.if_buy_yue').show()
            }
        });
		
        this.get('b.i-hp,s.i-qw,#xianhao1,#xianhao2,#xianhao3').tip('data-help', 1, false, 360);// 帮助说明
        this.get('ul.main-menu-container').setStyle('z-index:9999');
        this.get('div.main-menu').slideDrop('ul.main-menu-container',{
            onshow: function (m, b, mk){
                this.get('span.main-menu-up',b).removeClass('drop-hide')
            },
            onhide: function (m, b, mk){
                this.get('span.main-menu-up',b).addClass('drop-hide')
            }
        })
    },
           
    setCountDown: function (){// 倒计时
        var info, data, clock, ctpl, ctpl2,  timebar, Y, gp;
        Y = this;
        info = this.get('#responseJson');
       // ctpl = '还剩<b>{1}</b>天<b>{2}</b>时<b>{3}</b>分<b>{4}</b>秒';
        ctpl = '还剩 <span class="last_time"> {1}天{2}小时</span>';
        ctpl2 = '还剩 <span class="last_time">{2}小时{3}分钟{4}秒</span>';
        timebar = this.get('#countDownSpan');//显示板 
        if (info) {
            this.config = data = this.dejson(info.val());
            Class.config('page-config', data);
            if (data) {
                clock = new this.lib.CountDown();
                gp = this.get('#countDownData').val().trim();//格式为 value="时间#id,时间#id"
                if (gp!='') {// 高频倒计时
                    gp.split(',').each(function (d){
                        var s = d.split('#'),
                            o = this.get('#'+s[1]);
                        if (o.size()) {
                            clock.add({
                                endTime: s[0],
                                change:function (times, isEnd, msg, now){
                                    if (isEnd) {
                                        o.html('<span class="red">已截止</span>');
                                    }else{
                                        o.html(times.slice(-4, -1).join(':').replace(/\b\d\b/g,'0$&'))
                                    }  
                                }
                            })
                        }
                    }, this)
                }
                var __oncd = {
                    endTime: data.endTime,
                    change:function (times, isEnd, msg, now){
                        var tpl = times[0] > 0 ? ctpl : ctpl2;
                        if (isEnd) {
                            timebar.html('<span class="red">'+(msg || '已截止')+'</span>');
                            Class.config('isEnd', true);
                            Y.get('#all_form').next('div').addClass('b-end');
                        }else if(this.C('shownowtime')){
                            timebar.html(this.getDate(now).format('MM月DD日 hh:mm:ss'))
                        }else{
                            timebar.html( ctpl.format.apply(tpl, times).replace(/\b\d\b/g,'0$&'))
                        }                                
                    }                
                };
                if (this.C('shownowtime')) {
                    timebar.setStyle('background:#000;color:#00FF00;padding:1px');
                }
                if (timebar.size()) {//常规倒计时
                    if (this.getDate(data.endTime)) {
                        clock.add(__oncd);                            
                    }else{
                        timebar.html('<span class="red">该彩种尚未开售</span>')
                    }                
                }
                this.onMsg('msg_endtime_change', function (endtime, now){
                    clock.end('loading...');//不同玩法，时间的切换
                    __oncd.endTime = endtime;
                    this.get('#endtimeSpan').html(endtime);
                    clock.add(__oncd);
                    Class.config('isEnd', false);
                    Y.get('#all_form').next('div.con').removeClass('b-end')
                    clock.play(now)
                });
                clock.play(data.serverTime)
            }
        }
    }        
});
//公共弹出层
Class({
    Type: 'System_dlg',
    use: 'mask',
    ready: true,

    index:function (){
        var _alert, _confirm, _open;
        if (this.get('#yclass_alert').size() == 0) {
            this.createHtml()
        }
        _alert = this.lib.MaskLay('#yclass_alert', '#yclass_alert_content', '#yclass_alert_title');
        _alert.addClose('#yclass_alert_close', '#yclass_alert_ok');
        this.get('#yclass_alert  div.tips_title').drag('#yclass_alert');
        _confirm = this.lib.MaskLay('#yclass_confirm', '#yclass_confirm_content', '#yclass_confirm_title');
        _confirm.addClose('#yclass_confirm_close', '#yclass_confirm_no', '#yclass_confirm_ok');
        this.get('#yclass_confirm div.tips_title').drag('#yclass_confirm');
        _open = this.lib.MaskLay();
        this.extend('alert', function (a, b, c, noMask){// txt, callback, nobtn, nomask
            _alert.noMask = noMask;
            _alert.pop(a, b, c);
            return _alert;
        });
        this.alert.close = function (){
            _alert.close() 
        };
        this.extend('confirm', function (html, fn, title, noMask){
            var callback;
            if (title) {
                _confirm.title.html(title)
            }
            if (noMask) {
                _confirm.noMask = true
            }
            if (this.isFunction(fn)) {
                callback = function (e, btn){
                    if (btn.id == 'yclass_confirm_ok') {
                        fn.call(this)
                    }
                }
            }
            _confirm.pop.call(_confirm, html, callback);
            return _confirm
        });
        this.confirm.close = function (){
            _confirm.close()
        };
        this.extend('openUrl', function (url, w, h, noMask, scroll, showMove){
            if (noMask) {
                _open.noMask = true
            }
			
            _open.open(url,{
                width: w,
                height: h,
                scroll: scroll,
                showMove: showMove !== false
            });
			
            _open.proxyTitle.drag(_open.panel);
            return _open;
        });
        this.extend('closeUrl', function (){
            _open.close()
        });
    },
    createHtml: function (){
        var dlgHTML = '<div class="tips_m" style="top:700px;display:none" id="yclass_alert">'+
        '	<div class="tips_b">'+
        '        <div class="tips_box">'+
        '            <div class="tips_title">'+
        '                <h2 id="yclass_alert_title">温馨提示</h2>'+
        '                <span class="close" id="yclass_alert_close"><a href="#">关闭</a></span>'+
        '            </div>'+
        '            <div class="tips_text">'+
        '               <div class="tips_ts" id="yclass_alert_content" style="zoom:1"></div>'+
        '            </div>'+
        '            <div class="tips_sbt">'+
        '                <input type="button" value="确 定"  class="btn_Dora_b" id="yclass_alert_ok" />'+
        '            </div>'+
        '        </div>'+
        '    </div>'+
        '</div>'+
        '<div class="tips_m" style="display:none" id="yclass_confirm">'+
        '	<div class="tips_b">'+
        '        <div class="tips_box">'+
        '            <div class="tips_title">'+
        '                <h2 id="yclass_confirm_title">温馨提示</h2>'+
        '                <span class="close" id="yclass_confirm_close"><a href="#">关闭</a></span>'+
        '            </div>'+
        '            <div class="tips_info"  id="yclass_confirm_content" style="zoom:1"></div>'+
        '            <div class="tips_sbt">'+
        '                <input type="button" value="取 消" class="btn_Lora_b"  id="yclass_confirm_no" /><input type="button" value="确 定" class="btn_Dora_b"  id="yclass_confirm_ok" />'+
        '            </div>'+
        '        </div>'+
        '    </div>'+ 
        '</div>'+
        '<div style="display:none;" id="open_iframe">'+
        '  <div id="open_iframe_content"></div>'+
        '</div>';
        this.get(dlgHTML).insert()
    }
});

Yobj.extend('setHome', function (obj){
	var url = window.location.href;
	try {
		obj.style.behavior = 'url(#default#homepage)';
		obj.setHomePage(url);
	} catch(e) {
		if (window.netscape) {
			try {
				netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
			} catch(e) {
				alert("此操作被浏览器拒绝！\n请在浏览器地址栏输入“about:config”并回车\n然后将 [signed.applets.codebase_principal_support]的值设置为'true',双击即可。");
			}
			var prefs = Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch);
			prefs.setCharPref('browser.startup.homepage', url);
		}
	};
    return false
});

Yobj.extend('addFavorite', function (){
	var url = window.location.href;
	try {
		window.external.addFavorite(url, "");
	} catch(e) {
		try {
			window.sidebar.addPanel("", url, "");
		} catch(e) {
			alert("加入收藏失败，请使用Ctrl+D进行添加");
		}
	};
    return false
})