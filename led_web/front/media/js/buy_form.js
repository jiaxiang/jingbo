Class.C('has_submit', false);
/* ConfirmForm 北单复式第2步、发起方案
------------------------------------------------------------------------------*/
Class( 'BuyForm', {

	use   : 'mask',
	ready : true,
	_param : {},

	index : function() {
		var Y = this;

		Class.config('playId', parseInt(this.need('#playid').val()) );  //玩法id
		Class.config('submitting', false);  //是否正在提交中

		this.expander    = this.get('#expander');
		this.dgBtn       = this.get('#dg_btn');
		this.hmBtn       = this.get('#hm_btn');
		this.backBtn     = this.need('#back_btn');
		this.agreement   = this.need('#agreement');
		this.fanganTable = this.need('#fangan_table');

		this.get('.i-hp,.i-qw').tip('data-help', 1); //提示窗口
		
		if (this.need('#ishm').val() == 1) {
			this.getHmHtmlElement();
			this.hmInit();
			this.doHmThings();
			this.title_word_count.html(this.title.val().length);
			this.content_word_count.html(this.content.val().length);
		}
		
		this.expander.click( function() {
			Y.expand();
		} );

		this.dgBtn.click( function() {
			Y.postMsg('msg_login', function() { //是否登入
				if (!Class.config('submitting')) {
					Class.config('submitting', true);
					Y.doDg();
				}
			} );
		} );

		this.hmBtn.click( function() {
			Y.postMsg('msg_login', function() { //是否登入
				if (!Class.config('submitting')) {
					Class.config('submitting', true);
					Y.doHm();
				}
			} );
		} );

		// 返回修改
		this.backBtn.click( function() {
			Y.goBack();
		} );

		//创建一个公共弹窗, 使用msg_show_dlg进行调用
		this.infoLay = this.lib.MaskLay('#defLay', '#defConent');
		this.infoLay.addClose('#defCloseBtn', '#defTopClose a');
		this.get('#defLay div.tips_title').drag(this.get('#defLay'));

		// 提供弹窗服务
		this.onMsg('msg_show_dlg', function (msg, fn, forbid_close) {
			this.infoLay.pop(msg, fn, forbid_close);
		} );

		// 余额不足请充值的弹窗
		this.addMoneyDlg = this.lib.MaskLay('#addMoneyLay');
		this.addMoneyDlg.addClose('#addMoneyClose a', '#addMoneyNo', '#addMoneyYes');
		this.get('#addMoneyLay div.tips_title').drag('#addMoneyLay');
		this.onMsg('msg_show_addmoney', function (fn, args) {
			this.addMoneyDlg.pop(false, function (e, btn) {
				if (typeof fn === 'function' && btn.id == 'addMoneyYes') {
					fn(args);
				}
			})
		});

	},

	// 点击查看全部 或隐藏
	expand : function() {
		this.fanganTable.find('tr').each( function(tr, i) {
			if (i > 10) {
				if (this.get(tr).getStyle('display') == 'none') {
					this.get(tr).show();
					this.expander.html('隐藏部分场次<b class="a_up"></b>');
				} else {
					this.get(tr).hide();
					this.expander.html('查看全部场次<b class="a_down"></b>');
				}
			}
		}, this );
	},

	// 发起代购
	doDg : function() {
		this.getParam();
		if (this.check() == true) {
			this.getMoney( function() {
				this.postMsg('msg_show_dlg', '正在提交您的请求, 请稍候...', null, true);
				this.submit();
			} );
		} else {
			Class.config('submitting', false);
		}
	},

	// 发起合买
	doHm : function() {
		this.getParam();
		this.getHmParam();
		if (this.check() == true && this.hmCheck() == true) {
			this.getMoney( function() {
				this.postMsg('msg_show_dlg', '正在提交您的请求, 请稍候...', null, true);
				this.submit();
			} );
		} else {
			Class.config('submitting', false);
		}
	},

	// 检测余额，不足的话提示充值
	getMoney : function(fn) {
		var cost_money = this._param.ishm == 0 ? this._param.totalmoney : 
		                 this._param.totalmoney / this._param.allnum * this._param.buynum;
		this.ajax( {
			url : '/user/ajax_user_money',
			end : function (data) {
				var d;
				if (d = this.dejson(data.text)) {
					if (d.userMoney < cost_money) {
						//var charge_url = '/useraccount/default.php?url=' + this.get('#passport_url').val() + '/useraccount/addmoney/add.php';
						var charge_url = '/user/recharge';
						this.postMsg('msg_show_addmoney', function () {
							window.open(charge_url);
						} );
						Class.config('submitting', false);
					} else {
						fn.call(this);
					}
				} else {
					Class.config('submitting', false);
				}
			}
		} );
	},

	// 获取发起时必须的参数
	getParam : function() {
		this._param.lotid  = this.need('#lotid').val();
		this._param.playid = this.need('#playid').val();
		this._param.playtype = this.need('#playtype').val();
		this._param.expect = this.need('#expect').val();

		this._param.endtime = this.need('#endtime').val();
		this._param.zhushu = this.need('#zhushu').val();
		this._param.beishu = this.need('#beishu').val();
		this._param.codes = this.need('#codes').val();
		this._param.danma = this.need('#danma').val();
		this._param.totalmoney = this.need('#totalmoney').val();
		this._param.ratelist = this.need('#ratelist').val();
		this._param.IsCutMulit = this.need('#IsCutMulit').val(); //注数去重
		
		this._param.gggroup = this.need('#gggroup').val();
		this._param.sgtype = this.need('#sgtype').val();
		this._param.sgtypename = this.need('#sgtypename').val();

		this._param.ishm = this.need('#ishm').val();
	},

	// 获取合买发起时必须的参数
	getHmParam : function() {
		this._param.allnum = parseInt(this.allnum.val()) || 0;
		this._param.buynum = parseInt(this.buynum.val()) || 0;
		this._param.isbaodi = this.isbaodi.prop('checked') ? 1 : 0;
		this._param.baodinum = this._param.isbaodi == 1 ? (parseInt(this.baodinum.val()) || 0) : 0;
		this._param.tcbili = this.tcbili.val(); //提成比例

		if (this.optional_info.prop('checked') == true) {
			this._param.title = this.title.val().trim();
			if (this._param.title == '') {
				this._param.title = this.title.attr('default');
				this.title.val(this._param.title);
			}
			this._param.content = this.content.val().trim();
			if (this._param.content == '') {
				this._param.content = this.content.attr('default');
				this.content.val(this._param.content);
			}
			if (this.buyuser.getStyle('display') == 'none') {
				this._param.zgdx = 1;
				this._param.setbuyuser = 'all';
			} else {
				this._param.zgdx = 2;
				this._param.setbuyuser = this.setbuyuser.val().trim();
				if (this._param.setbuyuser == '') {
					this.setbuyuser.val('all');
					this._param.zgdx = 1;
					this._param.setbuyuser = 'all';
				}
			}
		} else {
			this._param.title = this.title.attr('default');
			this._param.content = this.content.attr('default');
			this._param.zgdx = 1;
			this._param.setbuyuser = 'all';
		}
	},

	// 基本的检测
	check : function() {
		if (!this.agreement.prop('checked')) {
			this.postMsg('msg_show_dlg', '您需要阅读并且同意《用户合买代购协议》，才能够使用我们的服务。');
		} else {
			return true;
		}
		return false;
	},

	// 合买的发起检测
	hmCheck : function() {
		if (this._param.totalmoney * 100 % this._param.allnum != 0) {
			this.postMsg('msg_show_dlg', '！每份金额不能除尽，建议分成'+this.divideAdvice(this._param.allnum)+'份，请重新填写份数。');
		} else if (this._param.totalmoney / this._param.allnum < 1) {
			this.postMsg('msg_show_dlg', '每份金额至少要为1元，请重新填写份数。');
		} else if (this._param.buynum / this._param.allnum < 0.05) {
			this.postMsg('msg_show_dlg', '至少需要认购5%，请重新填写认购份数。');
		} else if (this._param.buynum > this._param.allnum) {
			this.postMsg('msg_show_dlg', '购买份数大于所分的份数，请重新填写。');
		} else if (this.isbaodi.prop('checked') && (this._param.baodinum / this._param.allnum < 0.2)) {
			this.postMsg('msg_show_dlg', '至少需要保底20%，请重新填写保底份数。');
		} else if (this.isbaodi.prop('checked') && (this._param.baodinum + this._param.buynum > this._param.allnum)) {
			this.postMsg('msg_show_dlg', '购买份数加保底份数不能大于总份数。');
		} else {
			return true;
		}
		return false;
	},

	submit : function() {
		if(Class.C('has_submit')){
		  return false;	
		}
        Class.C('has_submit',true);
		for ( var _i in this._param) {
			this._param[_i] = encodeURIComponent(this._param[_i]);
		}
		
	//	log(this._param);
		this.ajax( {
			url  : '/bjdc/pute',
			type : 'post',
			data : this._param,
			end  : function(data) {
				if (data.error) {
					this.postMsg('msg_show_dlg', '网络故障, 请检查您的投注记录后重新提交!');
					Class.config('submitting', false);
				} else {
					var info = this.dejson(data.text);
					if (info.success) {
						//this.postMsg('msg_show_dlg', info.msg);
						location.href = info.url;
					} else {
						this.postMsg('msg_show_dlg', info.msg);
						Class.config('submitting', false);
					}
				}
			}
		} );
	},

	// 获取合买页面中必需的一些元素
	getHmHtmlElement : function() {
		this.allnum = this.need('#allnum');
		this.allnum_piece = this.need('#allnum_piece');
		this.allnum_tip = this.need('#allnum_tip');
		this.buynum = this.need('#buynum');
		this.buynum_money = this.need('#buynum_money');
		this.buynum_scale = this.need('#buynum_scale');
		this.buynum_tip = this.need('#buynum_tip');
		this.isbaodi = this.need('#isbaodi');
		this.baodinum = this.need('#baodinum');
		this.baodi_money = this.need('#baodi_money');
		this.baodi_scale = this.need('#baodi_scale');
		this.baodi_tip = this.need('#baodi_tip');
		this.tcbili = this.need('#tcbili'); //提成比例
		
		this.optional_info = this.need('#optional_info');
		this.optional_info_1 = this.need('#optional_info_1');
		this.title = this.need('#title');
		this.title_word_count = this.need('#title_word_count');
		this.content = this.need('#content');
		this.content_word_count = this.need('#content_word_count');
		this.optional_info_2 = this.need('#optional_info_2');
		this.zgdx = this.get(document.getElementsByName('zgdx'));
		this.buyuser = this.need('#buyuser');
		this.setbuyuser = this.need('#setbuyuser');
	},

	hmInit : function() {
		this.totalMoney = parseInt(this.need('#totalmoney').val());  //方案总金额
		this.allnum.val(this.totalMoney);
		this.isbaodi.prop('checked', false);
		this.baodinum.val('').prop('disabled', true);
		this.optional_info.prop('checked', false);
		this.optional_info_1.hide();
		this.optional_info_2.hide();
		this.zgdx.nodes[0].checked = true;
		this.buyuser.hide();
		this.title.val(this.title.attr('default'));
		this.content.val(this.content.attr('default'));
		this.setbuyuser.val('all');
		this.processSplitNum();
	},

	// 合买页面的一些处理
	doHmThings : function() {
		var Y = this;

		this.allnum.keyup( function() {  //我要分成多少份的处理
			Y.processSplitNum();
		} ).blur( function() {
			Y.processSplitNum();
		} );

		this.buynum.keyup( function() {  //我要认购多少份的处理
			Y.processBuyNum();
		} ).blur( function() {
			Y.processBuyNum();
		} );

		this.isbaodi.click( function() {  //是否保底的选择
			if (Y.isbaodi.prop('checked')) {
				var all_num = parseInt(Y.allnum.val());
				Y.baodinum.prop('disabled', false).val( Y.allnum.val() ? Math.ceil(all_num * 0.2) : '' );
				Y.baodinum.one().focus();
				Y.processBaodiNum();
			} else {
				Y.baodi_tip.hide();
				Y.baodinum.prop('disabled', true).val('');
				Y.baodi_money.html('￥0.00');
				Y.baodi_scale.html('0%');
			}
		} );

		this.baodinum.keyup( function() {  //我要保底多少份的处理
			Y.processBaodiNum();
		} ).blur( function() {
			Y.processBaodiNum();
		} );

		this.optional_info.click( function() {  //显示或隐藏可选信息
			Y.optional_info_1.show(Y.optional_info.prop('checked'));
			Y.optional_info_2.show(Y.optional_info.prop('checked'));
		} );

		this.optional_info_2.live(':radio', 'click', function() {  //显示或隐藏合买对象
			Y.buyuser.show(this.value == 2);
		} );

		Y.defaultTitleCleared = false;
		this.title.keyup( function() {  //限制方案标题的长度
			if (Y.title.val().length > 20) {
				Y.title.val(Y.title.val().substr(0, 20));
			}
			Y.title_word_count.html(Y.title.val().length);
		} ).focus( function() {
			if (!Y.defaultTitleCleared) {
				Y.title.val('');
				Y.title_word_count.html(0);
				Y.defaultTitleCleared = true;
			}
		} );

		Y.defaultContentCleared = false;
		this.content.keyup( function() {  //限制方案描述的长度
			if (Y.content.val().length > 200) {
				Y.content.val(Y.content.val().substr(0, 200));
			}
			Y.content_word_count.html(Y.content.val().length);
		} ).focus( function() {
			if (!Y.defaultContentCleared) {
				Y.content.val('');
				Y.content_word_count.html(0);
				Y.defaultContentCleared = true;
			}
		} );

	},
	
	processSplitNum : function() {
		var all_num, per_money, Y = this;
		all_num = parseInt(Y.allnum.val());
		if (!all_num) {
			Y.allnum.val('');
			Y.allnum_tip.html('！每份至少1元，请重新填写').show();
			Y.allnum_piece.html('￥0.00');
		} else {
			Y.allnum.val(all_num);
			per_money = Y.totalMoney / all_num;
			if (per_money < 1) {
				Y.allnum_tip.html('！每份至少1元，请重新填写').show();
			} else if (Y.totalMoney * 100 % all_num != 0) {
				Y.allnum_tip.html('！每份金额不能除尽，建议分成'+Y.divideAdvice(all_num)+'份，请重新填写').show();
			} else {
				Y.allnum_tip.hide();
			}
			Y.allnum_piece.html(per_money.rmb());
			Y.buynum.val(Math.ceil(all_num * 0.05));
			if (Y.isbaodi.prop('checked')) {
				Y.baodinum.val(Math.ceil(all_num * 0.2));
			}
		}
		Y.processBuyNum();
		Y.isbaodi.prop('checked') && Y.processBaodiNum();
	},

	processBuyNum : function() {
		var buy_num, all_num, min_num, Y = this;
		all_num = parseInt(Y.allnum.val());
		buy_num = parseInt(Y.buynum.val());
		if (!all_num || !buy_num) {
			Y.buynum.val('');
			Y.buynum_money.html('￥0.00');
			Y.buynum_scale.html('0.00%');
			Y.buynum_tip.hide(!all_num);
		} else {
			Y.buynum.val(buy_num);
			Y.buynum_money.html( (Y.totalMoney / all_num * buy_num).rmb() );
			Y.buynum_scale.html( (Y.fixNum(buy_num * 100 / all_num)).toFixed(2) + '%' );
			min_num = Math.ceil(all_num * 0.05);  //最少需认购5%
			if (buy_num < min_num || buy_num > all_num) {
				var _span = Y.buynum_tip.one().getElementsByTagName('span');
				_span[0].innerHTML = min_num;
				_span[1].innerHTML = all_num;
				Y.buynum_tip.show();
			} else {
				Y.buynum_tip.hide();
			}
		}
	},

	processBaodiNum : function() {
		var baodi_num, all_num, min_num, Y = this;
		all_num   = parseInt(Y.allnum.val());
		baodi_num = parseInt(Y.baodinum.val());
		if (!all_num || !baodi_num) {
			Y.baodinum.val('');
			Y.baodi_money.html('￥0.00');
			Y.baodi_scale.html('0.00%');
			Y.baodi_tip.hide(!all_num);
			return;
		}
		Y.baodinum.val(baodi_num);
		Y.baodi_money.html( (Y.totalMoney / all_num * baodi_num).rmb() );
		Y.baodi_scale.html( (Y.fixNum(baodi_num * 100 / all_num)).toFixed(2) + '%' );
		min_num = Math.ceil(all_num * 0.2);  //最少需保底20%
		Y.baodi_tip.show(baodi_num < min_num);
	},

	// 除不尽时建议分成多少份
	divideAdvice : function(num) {
		var total_money = this.totalMoney;
		for (var i = num; i <= total_money; i++) {
			if (total_money * 100 % i == 0) {
				return i;
			}
		}
	},

	// 返回修改
	goBack : function() {
		var restore_data = '';
		restore_data += '{ "codes":"' + this.need('#codes').val() + '",';
		restore_data += '  "danma":"' + this.need('#danma').val() + '",';
		restore_data += '  "gggroup":"' + this.need('#gggroup').val() + '",';
		restore_data += '  "sgtype":"' + this.need('#sgtype').val() + '",';
		restore_data += '  "beishu":"' + this.need('#beishu').val() + '"  }';
		this.cookie('restore_data', restore_data);
	},

	fixNum : function(n) {
		return parseFloat((parseInt(n * 100) / 100).toFixed(2));
	}

} );