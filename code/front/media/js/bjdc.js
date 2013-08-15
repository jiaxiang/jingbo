/*----------------------------------------------------------------------------*
 * 足球单场复式选号页面                                                       *
 *----------------------------------------------------------------------------*/

/* LineSelector 北单行选择器
------------------------------------------------------------------------------*/
Class( 'LineSelector', {

	index : function(config) {
		
        this.vsLine       = config.tr;
		this.vsIndex      = config.vsIndex;
		this.vsOptions    = config.vsOptions;
		this.vsCheckAll   = config.vsCheckAll;
		this.spTag        = config.spTag;
		this.vsInfo       = config.vsInfo;

		this.disabled     = this.vsInfo.disabled === 'yes';
		this.index        = this.vsInfo.index;
		this.data         = [];  //本行的投注结果
		this.codeValIdx   = Class.config('codeValueIndex');

		this.bindEvent();
		if (this.disabled && !Class.config('stopSale')) {
			this.vsIndex.disabled = true;
		}
		this.vsIndex.checked = true;
		!this.disabled && this.initClearAll(); //初始时全不选中

		// 取消某一选项的选择
		this.onMsg('msg_touzhu_cancel', function(line_index, ck_value) {
			if (this.index == line_index) {
				var ck_index, ck;
				ck_index = this.getIndex(Class.config('codeValue'), ck_value);
				ck = this.vsOptions[ck_index].getElementsByTagName('input')[0];
				this.unCheck(ck);
				return false; //停止消息传递
			}
		});

	},

	// 绑定相关事件
	bindEvent : function() {
		var Y = this;

		// 鼠标经过每一行时改变样式
		this.get(this.vsLine).hover( function() {
			this.style.backgroundColor = '#FEFFD1';
		}, function() {
			this.style.backgroundColor = '';
		} );

		// 点击隐藏某场比赛
		this.vsIndex.onclick = function() {
			Y.hideLine();
		}

		if (this.disabled) return;

		// 点击选项进行投注
		for (var i = 0, l = this.vsOptions.length; i < l; i++) {
			this.vsOptions[i].parentNode.onmousedown = function() {
				var ck = this.getElementsByTagName('input')[0];
				ck.checked ? Y.unCheck(ck) : Y.check(ck);
			}
		}

		// 全选/全不选
		this.vsCheckAll.parentNode.onmousedown = function() {
			var ck = this.getElementsByTagName('input')[0];
			ck.checked = !ck.checked;
			ck.checked ? Y.checkAll() : Y.clearAll();
		}
	},

	check : function(ck) {
		this.data[this.codeValIdx[ck.value]] = ck.value;
		ck.checked = true;
		ck.parentNode.parentNode.style.backgroundColor = '#FFDAA4';
		this.vsCheckAll.checked = this.getData().length == this.vsOptions.length;
		this.changed();
	},

	unCheck : function(ck) {
		this.data[this.codeValIdx[ck.value]] = undefined;
		ck.checked = false;
		ck.parentNode.parentNode.style.backgroundColor = '';
		this.vsCheckAll.checked && (this.vsCheckAll.checked = false);
		this.changed();
	},

	checkAll : function() {
		this.data = Class.config('codeValue').slice();
		this.vsCheckAll.checked = true;
		for (var i = 0, l = this.vsOptions.length; i < l; i++) {
			this.vsOptions[i].getElementsByTagName('input')[0].checked = true;
			this.vsOptions[i].parentNode.style.backgroundColor = '#FFDAA4';
		}
		this.changed();
	},

	clearAll : function() {
		this.data = [];
		this.codes = [];
		this.vsCheckAll.checked = false;
		for (var i = 0, l = this.vsOptions.length; i < l; i++) {
			this.vsOptions[i].getElementsByTagName('input')[0].checked = false;
			this.vsOptions[i].parentNode.style.backgroundColor = '';
		}
		this.clearchanged();
   		//this.qclearAll();
	},
    qclearAll:function(){
	 
	  for (var i = 0, l = this.vsOptions.length; i < l; i++) {
			this.vsOptions[i].getElementsByTagName('input')[0].checked = false;
			this.vsOptions[i].parentNode.style.backgroundColor = '';
	  }
	},
	initClearAll : function() {
		var ck = this.vsLine.getElementsByTagName('input');
		for (var i = 1, l = ck.length; i < l; i++) {
			ck[i].checked = false;
		}
	},

	hideLine : function() {  //隐藏当前行
		if (this.vsLine.style.display != 'none') {
			this.vsLine.style.display = 'none';
			this.getData().length > 0 && this.clearAll();
			!this.vsIndex.disabled && this.postMsg('msg_one_match_hided');
			Y.C('autoHeight') && this.postMsg('msg_update_iframe_height');
		}
	},

	showLine : function() {  //显示当前行
		if (this.vsLine.style.display == 'none') {
			this.vsLine.style.display = '';
			this.vsIndex.checked = true;
			!this.vsIndex.disabled && this.postMsg('msg_one_match_showed');
			Y.C('autoHeight') && this.postMsg('msg_update_iframe_height');
		}
	},

	// 获取本行投注数据
	getData : function() {
		if (this.disabled) return [];
		return this.data.each( function(d) {
			d && this.push(d);
		}, [] );
	},

	// 选中某些特定的选项
	checkCertainVsOptions : function(ck_value) {
		var code_value = Class.config('codeValue').slice();
		ck_value.split(',').each( function(v) {
			var i = this.getIndex(code_value, v);
			this.check(this.vsOptions[i].getElementsByTagName('input')[0]);
		}, this );
	},

	// 更新SP值
	updateSP : function(sp_values) {
		
		if (this.spTag && !this.disabled) {
			this.spTag.each( function(item, index) {
				var sp_old, sp_new, arrow = '';
				sp_old = parseFloat(item.innerHTML);
				sp_new = parseFloat(sp_values[index]);
				this.get(item).removeClass('red').removeClass('green');
				if (sp_new > sp_old) {
					this.get(item).addClass('red');
					arrow = '↑';
				} else if (sp_new < sp_old) {
					this.get(item).addClass('green');
					arrow = '↓';
				}
				if (Class.config('playName') == 'jq' || Class.config('playName') == 'bq') {
					arrow = '';  //进球和半全不显示箭头
				}
				item.innerHTML = sp_new ? sp_new.toFixed(2) + arrow : '--';
			}, this );
		}
	},
    changed : function() {
		this.postMsg('msg_line_selector_changed');
	},
    clearchanged : function() {
		this.postMsg('msg_line_selector_changed_zz');
	}

} );


/* TableSelector 北单对阵列表选择器
------------------------------------------------------------------------------*/
Class( 'TableSelector', {

	vsInfo : [],
	hiddenMatchesNum : 0,
	codes  : [],

	index : function(config) {
		var Y = this;
        this.vsTable = this.need(config.vsTable);
		if (Class.config('playName') == 'rqspf') {
			this.ckRangqiu   = this.need(config.ckRangqiu);
			this.ckNoRangqiu = this.need(config.ckNoRangqiu);
		}
		this.ckOutOfDate = this.need(config.ckOutOfDate);
		this.hiddenMatchesNumTag = this.need(config.hiddenMatchesNumTag);
		this.matchShowTag = this.need(config.matchShowTag);
		this.matchFilter  = this.need(config.matchFilter);
		this.leagueShowTag  = this.need(config.leagueShowTag);
		this.leagueSelector = this.need(config.leagueSelector);
		this.selectAllLeague      = this.need(config.selectAllLeague);
		this.selectOppositeLeague = this.need(config.selectOppositeLeague);

		this.stopSale = Class.config('stopSale');
		this.allEnd = this.get('#out_of_date_matches').val() == this.get('#all_matches').val(); //全部截止

		this.initVsTrs(config.vsLines);  //建立好各个单行对象

		this.onMsg('msg_line_selector_changed', this.changed);
		
		this.onMsg('msg_line_selector_changed_zz', this.clearchanged);

		this.onMsg('msg_touzhu_line_cancel', function(index) {
			this.vsTrs[index - 1].clearAll();
		} );
        
		this.onMsg('msg_clear_all',function(){
			for(i=0;i<this.vsTrs.length;i++){
				this.vsTrs[i].clearAll();
			}
			
		});
		
		this.onMsg('msg_get_touzhu_codes', function() {
			return this.codes;
		});

		this.onMsg('msg_get_codes_4_submit', function() {
			return this.getCodes4Submit();
		} );
		
		// 为显示奖金预测提供相关数据
		this.onMsg('msg_get_data_4_prize_predict', function() {
			return this.getData4PrizePredict();
		} );

		// 返回修改时重现之前选择的比赛
		this.onMsg('msg_restore_codes', function(codes) {
			this.restoreCodes(codes);
		} );

		this.initMatchFilter();  //赛事过滤

		if (this.stopSale == false && !Y.C('autoHeight')) {
			//setTimeout( function() { Y.updateSP() }, 30000 );  //更新SP值(页面载入后30秒)
		}
	},

	initVsTrs : function(vs_lines) {
		var Y = this, input_length = 0;
		this.vsTrs = this.need(vs_lines).each( function(tr, i) {
			var vs_info = Y.dejson(tr.getAttribute('value'));
			input_length == 0 && (input_length = tr.getElementsByTagName('input').length);
			this[i] = Y.lib.LineSelector( {
				tr           : tr,
				vsIndex      : tr.getElementsByTagName('input')[0],
				vsOptions    : tr.getElementsByTagName('label'),
				vsCheckAll   : tr.getElementsByTagName('input')[input_length - 1],
				spTag        : Y.get('span.sp_value', tr),
				vsInfo       : vs_info
			} );
			Y.vsInfo[vs_info.index] = vs_info;  //存储所有比赛的相关数据
		}, [] );
		
	},

	// 获取所有行的投注数据
	getCodes : function() {
		this.codes = this.vsTrs.each( function (item) {
			if (item.disabled) return;
			var _data = item.getData();
			if (_data.length > 0) {
				this.push( {
					'index' : item.index,
					'arr'   : _data,
					'dan'   : false,
					'vsInfo': item.vsInfo
				} );
			}
		}, [] );
		return this.codes;
	},

	// 获取投注数据(用于提交时)
	// {'codes':'2:[胜]/5:[负]/6:[胜,平,负]', 'danma':'2:[胜]'}
	getCodes4Submit : function() {
		var codes, danma, arr_danma;
		codes = new Array();
		danma = new Array();
		arr_danma = this.postMsg('msg_get_danma').data;
		this.vsTrs.each( function(item) {
			var i, v;
			v = item.getData();
			i = item.index;
			if (v.length > 0) {
				var tmp_code = '';
				tmp_code = i + ':[';
				tmp_code += v.each( function(v2) {
					this.push( v2 );
				}, [] ).join(',');
				tmp_code += ']';
				codes.push(tmp_code);
				arr_danma[i] == true && danma.push(tmp_code);
			}
		} );
		return { 'codes':codes.join('/'), 'danma':danma.join('/') }; 
	},

	// 为显示奖金预测提供相关数据
	getData4PrizePredict : function() {
		var Y = this;
		return this.vsTrs.each( function(item, i) {
			var sp = [], vs_info;
			if (item.spTag) {
				sp = item.spTag.each( function(item2) {
					this.push( parseFloat(item2.innerHTML) || 0 );
				}, [] );
			}
			vs_info = Y.vsInfo[item.index];
			this.push( {
				'serialNumber' : item.index,
				'lg'    : vs_info.leagueName,
				'main'  : vs_info.homeTeam,
				'guest' : vs_info.guestTeam,
				'rq'    : vs_info.rangqiuNum,
				'sp'    : sp
			} );
		}, [] );
	},

	changed : function() {
		this.postMsg('msg_table_selector_changed', this.getCodes());
	},
	clearchanged : function() {
		this.postMsg('msg_table_selector_changed_zz', this.getCodes());
	},

	initMatchFilter : function() {
		var Y = this;

		// 几个复选框的初始状态
		if (Class.config('playName') == 'rqspf') {
			this.ckRangqiu.prop('checked', true);
			this.get('#rangqiu_tag').html(this.get('#rangqiu_matches').val());
			this.ckNoRangqiu.prop('checked', true);
			this.get('#no_rangqiu_tag').html(this.get('#no_rangqiu_matches').val());
		}
		this.ckOutOfDate.prop('checked', false);
		this.get('#out_of_date_tag').html(this.get('#out_of_date_matches').val() + '场');

		this.initVsDisplay(); //初始化对阵的显示情况

		this.onMsg('msg_update_hidden_matches_num', function() {
			Y.hiddenMatchesNumTag.html(Y.hiddenMatchesNum);
		} );

		// 设定消息，以改变隐藏比赛数量的显示
		this.onMsg('msg_one_match_showed', function() {
			Y.hiddenMatchesNum--;
			Y.postMsg('msg_update_hidden_matches_num');
		} );
		this.onMsg('msg_one_match_hided', function() {
			Y.hiddenMatchesNum++;
			Y.postMsg('msg_update_hidden_matches_num');
		} );

		this.onMsg('msg_show_certain_league', function(league_name) {
			Y.showCertainLeague(league_name);
		} );

		// 成块地显示或隐藏某归属日期下的所有赛事
		this.onMsg('msg_show_or_hide_matches', function(id, obj) {
			if (Y.get(obj).html().indexOf('隐藏') != -1) {
				Y.need('#'+id).hide();
				Y.get(obj).html('显示<s class="c_down"></s>');
			} else {
				Y.need('#'+id).show();
				Y.get(obj).html('隐藏<s class="c_up"></s>');
			}
			Y.C('autoHeight') && this.postMsg('msg_update_iframe_height');
		} );

		// 显示或隐藏有让球的场次
		if (Class.config('playName') == 'rqspf') {
			this.ckRangqiu.click( function() {
				var be_controlled = Y.stopSale || Y.ckOutOfDate.prop('checked');
				Y.vsTrs.each( function(item) {
					if (Y.vsInfo[item.index].rangqiuNum != 0 && (!item.disabled || be_controlled)) {
						this.checked ? item.showLine() : item.hideLine();
					}
				}, this );
			} );
			// 显示或隐藏非让球的场次
			this.ckNoRangqiu.click( function() {
				var be_controlled = Y.stopSale || Y.ckOutOfDate.prop('checked');
				Y.vsTrs.each( function(item) {
					if (Y.vsInfo[item.index].rangqiuNum == 0 && (!item.disabled || be_controlled)) {
						this.checked ? item.showLine() : item.hideLine();
					}
				}, this );
			} );
		}

		// 显示或隐藏已截止的场次
		this.ckOutOfDate.click( function() {
			var be_controlled = true;
			Y.vsTrs.each( function(item) {
				if (Class.config('playName') == 'rqspf') {
					be_controlled = (Y.vsInfo[item.index].rangqiuNum != 0 && Y.ckRangqiu.prop('checked')) || 
										(Y.vsInfo[item.index].rangqiuNum == 0 && Y.ckNoRangqiu.prop('checked'));
				}
				if (item.disabled && be_controlled) {
					this.checked ? item.showLine() : item.hideLine();
				}
			}, this );
			//this.checked ? Y.showAllTBody() : Y.hideSpareTBody();
			this.checked && Y.showAllTBody();
		} );

		// 点击已隐藏比赛的数量则显示所有的比赛
		this.hiddenMatchesNumTag.click( function() {
			if (this.innerHTML != '0') {
				Y.showAllMatches();
			}
		} );

		// 显示或隐藏联赛选择区域
		var timeout_id;
		this.leagueShowTag.mouseover( function() {
			if (Y.leagueSelector.one().getElementsByTagName('ul')[0].innerHTML == '') {
				Y.createLeagueList();  //生成联赛选择列表
			}
			clearTimeout(timeout_id);
			Y.leagueSelector.show();
			Y.leagueShowTag.addClass('ls_h_btn');
		} );
		this.leagueShowTag.mouseout( function() {
			timeout_id = setTimeout( function() {
				Y.leagueSelector.hide();
				Y.leagueShowTag.removeClass('ls_h_btn');
			}, 100);
		} );
		this.leagueSelector.mouseover( function() {
			clearTimeout(timeout_id);
			Y.leagueSelector.show();
		} );
		this.leagueSelector.mouseout( function() {
			timeout_id = setTimeout( function() {
				Y.leagueSelector.hide();
				Y.leagueShowTag.removeClass('ls_h_btn');
			}, 100);
		} );

		// 选择或隐藏某个指定的联赛
		this.leagueSelector.live('ul input', 'click', function(e, ns) {
			Y.vsTrs.each( function(item) {
				if (Y.vsInfo[item.index].leagueName == this.value && 
				        (!item.disabled || Y.stopSale || Y.ckOutOfDate.prop('checked'))) {
					this.checked ? item.showLine() : item.hideLine();
				}
			}, this );
		} );

		// 全选所有联赛
		this.selectAllLeague.click( function() {
			Y.showAllMatches();
		} );

		// 反选所有联赛
		this.selectOppositeLeague.click( function() {
			Y.leagueSelector.find('ul input').each( function(item) {
				item.click();
			} );
		} );

		// 显示或隐藏赛事筛选区域
		this.matchShowTag.drop( this.matchFilter, { 
			y : this.ie ? 7 : -1,
			x : this.ie ? 0 : -1,
			focusCss : 'dc_all_s dc_all_on',
			onshow : function() {
				this.matchShowTag.find('s').swapClass('c_down', 'c_up');
			},
			onhide : function() {
				this.matchShowTag.find('s').swapClass('c_up', 'c_down');
			}
		} );

		// 点击进行赛事筛选(全部比赛、热门投注、定胆最多...)
		this.matchFilter.find('a').click( function() {
			var _html, _value = Y.get(this).attr('value');
			if (_value == 'all') { //全部比赛
				Y.showAllMatches();
				_html = '全部比赛';
			} else if (_value == 'hot') { //热门投注
				if (typeof Y.hotMatches == 'undefined') {
					var arr_tzbl = [];
					var obj_tzbl = Y.vsTable.find('.tzbl');
					obj_tzbl.each( function(item) {
						var tmp_info = Y.dejson(item.parentNode.getAttribute('value'));
						if (tmp_info.disabled != 1 || Y.stopSale || Y.allEnd) {
							if (!parseFloat(item.innerHTML)) return;
							arr_tzbl.push( {'index':tmp_info.index, 'percentage':parseFloat(item.innerHTML)} );
						}
					} );
					Y.hotMatches = [];
					if (arr_tzbl.length != 0) {
						arr_tzbl.sort( function(a, b) { return b.percentage - a.percentage; } );
						arr_tzbl.length > 10 && (arr_tzbl = arr_tzbl.slice(0, 10));  //取前十
						arr_tzbl.each( function(item) {
							Y.hotMatches.push(item.index);
						} );
					}
				}
				Y.showCertainMatches(Y.hotMatches);
				_html = '热门投注';
			} else if (_value == 'dingdan') { //定胆最多
				if (typeof Y.dingdanMatches == 'undefined') {
					Y.ajax( {
						url : '/static/public/xml/long/ssfx/zqdc/tzddcs/' + Class.config('expect') + '.xml',
						end : function(data) {
							var dingdan_matches = [];
							if (data.xml) {
								Y.qXml('//row', data.xml, function(obj, i) {
									if (!Y.vsTrs[obj.items.ordernum - 1].disabled || Y.stopSale || Y.allEnd) {
										dingdan_matches.push( {'index':obj.items.ordernum, 'dingdanNum':obj.items['dingdan_' + obj.items.dingdan_max]} );
									}
								} );
							}
							dingdan_matches.sort( function(a, b) { return b.dingdanNum - a.dingdanNum; } );
							dingdan_matches.length > 10 && (dingdan_matches = dingdan_matches.slice(0, 10));  //取前十
							Y.dingdanMatches = [];
							dingdan_matches.each( function(item) {
								Y.dingdanMatches.push(item.index);
							} );
							Y.showCertainMatches(Y.dingdanMatches);
						}
					} );
				} else {
					Y.showCertainMatches(Y.dingdanMatches);
				}
				_html = '定胆最多';
			} else if (_value == 'rank') { //排名相差10以上
				if (typeof Y.rankMatches == 'undefined') {
					Y.rankMatches = [];
					Y.vsTrs.each( function(item) {
						if (Math.abs(item.vsInfo.homeTeamRank - item.vsInfo.guestTeamRank) >= 10 && 
						            (!item.disabled || Y.stopSale || Y.allEnd) ) {
							Y.rankMatches.push(item.index);
						}
					} );
				}
				Y.showCertainMatches(Y.rankMatches);
				_html = '排名相差';
			}
			Y.matchShowTag.html(_html + '<s class="c_up"></s>');
		} );

	},

	// 返回修改时重现之前选择的比赛
	restoreCodes : function(codes) {
		codes.each( function(obj) {
			this.vsTrs[obj.index - 1].checkCertainVsOptions(obj.arr);
		}, this );
	},

	// 更新SP值
	updateSP : function() {
		this.ajax( {
		url :	'' + Class.config('expect') + '_' + Class.config('playId') + '.xml',
		end :	function(data) {
					var Y = this;
					if (data.xml) {
						this.qXml('/w/*', data.xml, function(obj, i) {
							var sp_values = new Array();
							for (var j = 1, l = Class.config('codeValue').length * 2; j <= l; j += 2) {
								sp_values.push(obj.items['c' + j]);
							}
							this.vsTrs[i].updateSP(sp_values);
						} );
						//setTimeout( function() { Y.updateSP() }, 5*60*1000 );  //每隔一段时间再取一次
					} else {
						//setTimeout( function() { Y.updateSP() }, 5000 );  //失败后短时间内再次请求
					}
				}
		} );
	},

	// 显示所有赛事
	showAllMatches : function() {
		this.vsTrs.each( function(item) {
			if (!item.disabled || this.stopSale || this.ckOutOfDate.prop('checked')) {
				item.showLine();
			}
		}, this );
		this.leagueSelector.find('ul input').each( function(item) {
			!item.checked && (item.checked = true);
		},this );
		this.matchShowTag.html('全部比赛' + this.matchShowTag.html().substr(4));
		if (Class.config('playName') == 'rqspf') {
			this.ckRangqiu.prop('checked', true);
			this.ckNoRangqiu.prop('checked', true);
		}
	},

	// 只显示某个特定的联赛(用于资讯区的跳转)
	showCertainLeague : function(league_name) {
		this.vsTrs.each( function(item) {
			if (item.vsInfo.leagueName == league_name && (!item.disabled || this.stopSale || this.allEnd)) {
				item.showLine();
			} else {
				item.hideLine();
			}
		}, this );
		this.createLeagueList();
		this.leagueSelector.find('ul input').each( function(item) {
			item.checked = item.value == league_name;
		},this );
	},

	// 初始化对阵的显示情况
	initVsDisplay : function() {
		var Y = this;
		var arr_tbody = this.vsTable.find('tbody').filter( function(tBody) {
			return tBody.id && /^\d+-\d+-\d+$/.test(tBody.id)
		} );
		if (this.stopSale || this.allEnd) {
			Class.config('disableBtn', true); //此时禁用代购或合买按钮
		}
		if (this.stopSale == true) {
			this.ckOutOfDate.prop('checked', true);
			this.ckOutOfDate.prop('disabled', true);
		} else if (this.allEnd) {
			this.ckOutOfDate.prop('checked', true);
			this.ckOutOfDate.prop('disabled', true);
			this.showAllMatches();
		}else {
			arr_tbody.nodes.each( function(item, index) {
				if (this.get(item).getSize().offsetHeight == 0) {
					document.getElementById('switch_for_' + item.id).getElementsByTagName('a')[0].style.visibility = 'hidden';
				//	this.get('#switch_for_' + item.id).parent('tbody').hide(); //其他归属日期下所有的比赛均截止时，该tbody同样要隐藏
				}
			}, this );
		}
	},

	// 显示所有的tbody
	showAllTBody : function() {
		this.get('tbody', this.vsTable).show();
	},

	// 显示特定的一些比赛
	showCertainMatches : function(arr_matches) {
		this.vsTrs.each( function(item) {
			this.getIndex(arr_matches, item.index) !== -1 ? item.showLine() : item.hideLine();
		}, this );
	},

	// 生成联赛选择列表
	createLeagueList : function() {
		var Y = this;
		var arr_league = [];
		var league_list_html = '';
		var match_num_of_league = {};
		Y.vsTrs.each( function(item) {
			var league_name = Y.vsInfo[item.index].leagueName;
			if ( !item.disabled || Y.stopSale || Y.allEnd ) {
				if ( arr_league.join('|').indexOf(league_name) == -1 ) {
					arr_league.push(league_name);
					league_list_html += '<li><label><input type="checkbox" class="chbox" checked="checked" value="' + league_name + '" /><span style="padding:2px 4px;color:#FFF;background:' + Y.vsInfo[item.index].bgColor + '">' + league_name + '</span>[' + league_name + '_num]</label></li>';
				}
				if (typeof match_num_of_league[league_name] == 'undefined') {
					match_num_of_league[league_name] = 1;
				} else {
					match_num_of_league[league_name]++;
				}
			}
		} );
		for (var league_name in match_num_of_league) {
			league_list_html = league_list_html.replace(league_name + '_num', match_num_of_league[league_name]);
		}
		Y.get(league_list_html).insert(Y.leagueSelector.find('ul'));
	}

} );


/* TouzhuInfo 北单投注信息(一行)
------------------------------------------------------------------------------*/
Class( 'TouzhuInfoLine', {

	index : function(config) {
		this.index     = config.index;
		this.homeTeam  = config.homeTeam;
		this.guestTeam = config.guestTeam;
		this.endTime   = config.endTime;

		// 接收消息，生成某条特定的投注信息
		this.onMsg('msg_get_tr_html', function(oTr) {
			if (oTr.index == this.index) {
				return this.createTrHtml(oTr);
			}
		} );

		// 接收消息，返回单场比赛的截止时间
		this.onMsg('msg_get_endtime', function(line_index) {
			if (line_index == this.index) {
				return this.endTime;
			}
		} );
	},

	// 生成一行投注信息的html
	createTrHtml : function(oTr) {
		var tr_html, td_html, play_name, danma;
		td_html = '';
		play_name = Class.config('playName');
		oTr.arr.each( function(v) {
			td_html += '<span class="' + (play_name == 'jq' ? 'x_sz' : 'x_s') + '" value="' + this.index + '|' + v + '">' + v + '</span>';
		}, this );
		danma = this.postMsg('msg_get_danma').data;
		if (play_name == 'rqspf') {
			tr_html = '<tr>' + 
						  '<td>' + 
							  '<input type="checkbox" class="chbox" checked="checked" onclick="Yobj.postMsg(\'msg_touzhu_line_cancel\', ' + this.index + ')" />' + 
							  '<span class="chnum">' + this.index + '</span>' + 
						  '</td>' +
						  '<td class="t1" title="' + this.homeTeam + ' (' + oTr.vsInfo.rangqiuNum + ') ' + this.guestTeam + '">' + this.homeTeam + '</td>' +
						  '<td class="t1">' + td_html + '</td>' +
						  '<td><input type="checkbox" class="dan" value="' + this.index + '"' + (danma[this.index] ? ' checked="checked"' : '') + ' />' +
					  '</tr>';
		} else {
			tr_html = '<tr>' + 
						  '<td>' + 
							  '<input type="checkbox" class="chbox" checked="checked" onclick="Yobj.postMsg(\'msg_touzhu_line_cancel\', ' + this.index + ')" />' + 
							  '<span class="chnum">' + this.index + '</span>' + 
						  '</td>' +
						  '<td>' + this.homeTeam + '<span class="sp_vs">VS</span>' + this.guestTeam + '</td>' +
						  '<td><input type="checkbox" class="dan" value="' + this.index + '"' + (danma[this.index] ? ' checked="checked"' : '') + ' />' +
					  '</tr>' +
					  '<tr>' +
						  '<td colspan="3">' + td_html + '</td>' +
					  '</tr>';
		}
		return tr_html;
	}
	
} );


/* TouzhuInfo 北单投注信息
------------------------------------------------------------------------------*/
Class( 'TouzhuInfo', {

	matchNum : 0,
	danma : {},
	danmaNum : 0,

	index : function(config) {
		var Y = this;

		this.endtime = this.get(config.endtime);	
		this.touzhuTable = this.need(config.touzhuTable);
		this.touzhuTrs = this.need(config.vsLines).each( function(tr, i) {
			var vs_info = Y.dejson(tr.getAttribute('value'));
			this[i] = Y.lib.TouzhuInfoLine( vs_info );
		}, []);

		// 接收消息，更新投注信息
		this.onMsg('msg_table_selector_changed', function(data) {
			this.updateTouzhuInfoArea(data);
			//this.matchNum == this.danmaNum ? this.disableOrEnableDanma(-2) : this.storeDanma();
			this.storeDanma();
			//this.danmaNum == 0 && this.disableOrEnableDanma(-2);
			if (this.danmaNum == this.matchNum) { //更新后当胆码数与场次数相等时，清空胆码
				this.disableOrEnableDanma(-1);
				this.storeDanma();
			}
			this.changed();
		} );
		
		this.onMsg('msg_table_selector_changed_zz', function(data) {
			this.updateTouzhuInfoArea(data);
			//this.matchNum == this.danmaNum ? this.disableOrEnableDanma(-2) : this.storeDanma();
			this.storeDanma();
			//this.danmaNum == 0 && this.disableOrEnableDanma(-2);
			if (this.danmaNum == this.matchNum) { //更新后当胆码数与场次数相等时，清空胆码
				this.disableOrEnableDanma(-1);
				this.storeDanma();
			}
			this.clearchanged();
		} );

		this.onMsg('msg_get_danma', function() {
			return this.danma;
		} );

		// 禁用或恢复胆码复选框
		this.onMsg('msg_disable_or_enable_danma', function(gg_match_num) {
			this.disableOrEnableDanma(gg_match_num);
		} );

		this.spanCss = Class.config('playName') == 'jq' ? 'x_sz' : 'x_s';
		
		// 鼠标经过时显示一横线
		this.touzhuTable.live('span.' + Y.spanCss, 'mouseover', function(e, _y) {
			_y.get(this).addClass(config.mouseoverClass);
		} ).live('span.' + Y.spanCss, 'mouseout', function(e, _y) {
			_y.get(this).removeClass(config.mouseoverClass);
		} );

		// 点击取消选择
		this.touzhuTable.live('span.' + Y.spanCss, 'click', function(e, _y) {
			var a = _y.get(this).attr('value').split('|');
			_y.postMsg('msg_touzhu_cancel', a[0], a[1])
		} );

		// 点击胆码时
		this.touzhuTable.live('input.dan', 'click', function() {
			Y.storeDanma();
			Y.postMsg('msg_disable_or_enable_ggck', Y.danmaNum);
		} );

		// 返回修改时重现之前选择的胆码
		this.onMsg('msg_restore_danma', function(danma) {
			this.touzhuTable.find('input.dan').each( function(item) {
				if (this.getIndex(danma, item.value) !== -1) {
					this.get(item).prop('checked', true);
				}
			}, this );
			this.storeDanma();
			this.postMsg('msg_disable_or_enable_ggck', this.danmaNum);
		} );

	},

	// 更新投注信息区域, 返回所选比赛的数量
	updateTouzhuInfoArea : function(data) {
		var Y, earliest_endtime, match_num;
		Y = this;
		earliest_endtime = '2099-12-31 00:00';
		match_num = 0;
		this.endtime.html('');
		this.touzhuTable.empty();
		data.each( function(item) {
			var endtime = Y.postMsg('msg_get_endtime', item.index).data;
			endtime < earliest_endtime && (earliest_endtime = endtime); //取得最早截止时间

			var tr = Y.postMsg('msg_get_tr_html', item).data; // 发送消息，获取生成行的html
			Y.get(tr).insert(Y.touzhuTable);
			match_num++;
		} );
		earliest_endtime != '2099-12-31 00:00' && Y.endtime.html(earliest_endtime);
		this.matchNum = match_num;
	},

	// 获取胆码
	storeDanma : function() {
		this.danma = {};
		this.danmaNum = 0;
		this.touzhuTable.find('input.dan').each( function(item) {
			this.danma[item.value] = item.checked;
			this.danma[item.value] && this.danmaNum++;
		}, this );
	},

	disableOrEnableDanma : function(gg_match_num) {
		this.touzhuTable.find('input.dan').each( function(item) {
			if (gg_match_num == -1) { //清除胆码选择
				item.disabled = false;
				this.get(item).prop('checked', false);
			} else if (gg_match_num == -2) { //禁用所有胆码
				item.disabled = true;
				this.get(item).prop('checked', false);
			} else if (gg_match_num == 0 || this.danmaNum < gg_match_num - 1) { //恢复胆码
				if (!item.checked && !item.disabled) {
					return;
				}
				item.disabled = false;
			} else { //禁用未选中的胆码
				!item.checked && (item.disabled = true);
			}
			this.storeDanma();
		}, this );
	},

	changed : function() {
		this.postMsg('msg_touzhu_info_changed', this.matchNum, this.danmaNum);
	},

	clearchanged : function() {
		this.postMsg('msg_touzhu_info_changed_zz', this.matchNum, this.danmaNum);
	}

} );


/* GuoGuan 北单过关信息
------------------------------------------------------------------------------*/
Class( 'GuoGuan', {
	
	ggType : '自由过关',

	ggTypeMap  : { '自由过关' : 3, '多串过关' : 2 },
	ggTypeMap2 : { 3 : '自由过关', 2 : '多串过关' },

	ggGroup : [	[], ['单关'], ['2串1', '2串3'], ['3串1', '3串4', '3串7'], ['4串1', '4串5', '4串11', '4串15'], ['5串1', '5串6', '5串16', '5串26', '5串31'], ['6串1', '6串7', '6串22', '6串42', '6串57', '6串63'], ['7串1'], ['8串1'], ['9串1'], ['10串1'], ['11串1'], ['12串1'], ['13串1'], ['14串1'], ['15串1']	],
	ggGroupMap  : {'单关':27,'2串1':1,'2串3':2,'3串1':3,'3串4':5,'3串7':6,'4串1':7,'4串5':9,'4串11':12,'4串15':13,'5串1':14,'5串6':28,'5串16':29,'5串26':18,'5串31':19,'6串1':20,'6串7':30,'6串22':31,'6串42':32,'6串57':25,'6串63':26,'7串1':35,'8串1':36,'9串1':37,'10串1':38,'11串1':39,'12串1':40,'13串1':41,'14串1':42,'15串1':43},

	matchNum : 0,
	danmaNum : 0,
	
	index : function(config) {
		var Y = this;
		
		this.switchTag = this.need(config.switchTag);
		this.ggTable   = this.need(config.ggTable);

		// 切换过关类型
		this.switchTag.each( function(item) {
			Y.get(item).click( function() { 
				Y.ggTagSwitched(this);
			} )
		} ),

		// 当投注信息改变时
		this.onMsg('msg_touzhu_info_changed', function(match_num, danma_num) {
			this.matchNum = match_num;
			this.danmaNum = danma_num;
			this.updateGgInfo();
			this.matchNum == (parseInt(this.getGgInfo()[0]) || 1) && (this.danmaNum = 0);
			this.changed();
			this.disableOrEnableGgCk();
		} );
		
		this.onMsg('msg_touzhu_info_changed_zz', function(match_num, danma_num) {
			this.matchNum = match_num;
			this.danmaNum = danma_num;
			this.updateGgInfo();
			this.matchNum == (parseInt(this.getGgInfo()[0]) || 1) && (this.danmaNum = 0);
			this.clearchanged();
			this.disableOrEnableGgCk();
		} );

		// 返回过关方式
		this.onMsg('msg_get_guoguan_info', function() {
			return this.getGgInfo();
		} );

		// 选择过关方式时更新
		this.ggTable.live('input', 'click', function() {
			Y.changed();
		} );

		// 返回过关方式
		this.onMsg('msg_get_gg_info_more', function() {
			return this.getGgInfoMore();
		} );

		// 禁用或恢复过关方式选择框
		this.onMsg('msg_disable_or_enable_ggck', function(danma_num) {
			this.danmaNum = danma_num;
			this.disableOrEnableGgCk();
			this.changed();
		} );

		// 返回修改时重现之前选的过关类型
		this.onMsg('msg_restore_gggroup', function(gggroup) {
			this.switchTag.each( function(item) {
				if (this.get(item).attr('value') == this.ggTypeMap2[gggroup]) {
					this.ggTagSwitched(item);
				}
			}, this );
		} );

		// 返回修改时重现之前选的过关方式
		this.onMsg('msg_restore_sgtype', function(sgtype) {
			this.ggTable.find('input').each( function(item) {
				this.getIndex(sgtype, this.ggGroupMap[item.value]) !== -1 && this.get(item).prop('checked', true);
			}, this );
		} );
	},

	// 切换过关类型标签
	ggTagSwitched : function(obj) {
		this.switchTag.removeClass('an_cur');
		this.get(obj).addClass('an_cur');
		this.ggType = this.get(obj).attr('value');
		this.postMsg('msg_disable_or_enable_danma', -1); //清除胆码
		this.danmaNum = 0;
		this.updateGgInfo();
		this.changed();
	},

	// 更新过关信息
	updateGgInfo : function() {
		if (this.matchNum == 0) {
			this.ggTable.empty();
			return;
		}
		
		// 根据不同玩法对最大串数做限制
		var max_limit = this.matchNum;
		switch (Class.config('playName')) {
			case 'rqspf' :
				this.matchNum > 15 && (max_limit = 6);
				break;
			case 'bf' :
				this.matchNum > 3 && (max_limit = 3);
				break;
			case 'jq' :
			case 'ds' :
			case 'bq' :
				this.matchNum > 6 && (max_limit = 6);
		}

		var gg_html, checked_gg_type, checked_html;
		gg_html = checked_html = '';
		checked_gg_type = this.getGgInfo();
		
        if (this.ggType == '自由过关') {
			for (var i = 1, j = 1; i <= max_limit; i++) {
				if (j % 3 == 1) {
					if (parseInt(j / 3) % 2 == 1) {
						gg_html += '<tr class="even">';
					} else {
						gg_html += '<tr>';
					}
				}
				checked_gg_type.each( function(item) {
					item == this.ggGroup[i][0] && (checked_html = ' checked="checked" ');
				}, this );
				gg_html += '<td class="tl"><label class="mar_l10">' + 
							   '<input type="checkbox" class="chbox" name="gg_group"' + checked_html + ' value="' + this.ggGroup[i][0] + '" />' + this.ggGroup[i][0] +
						   '</label></td>';
				if (j++ % 3 == 0) {
					gg_html += '</tr>';
				}
				checked_html = '';
			}
		} else if (this.ggType == '多串过关') {
			if(max_limit>6){
			   max_limit=6;	
			}
			for (var i = max_limit, j = 1; i <= max_limit; i++) { //tr的输出有bug
				if (this.ggGroup[i].length < 2) {
					this.ggGroup[i]=this.ggGroup[8];
					//continue;
				}
				if (j % 3 == 1) {
					if (parseInt(j / 3) % 2 == 1) {
						gg_html += '<tr class="even">';
					} else {
						gg_html += '<tr>';
					}
				}
				for (var _i = 1, _l = this.ggGroup[i].length; _i < _l; _i++) {
					checked_gg_type.each( function(item) {
						item == this.ggGroup[i][_i] && (checked_html = ' checked="checked" ');
					}, this );
					gg_html += '<td class="tl"><label class="mar_l10">' + 
								   '<input type="radio" class="chbox" name="gg_group"' + checked_html + ' value="' + this.ggGroup[i][_i] + '" />' + this.ggGroup[i][_i] +
							   '</label></td>';
					if (j++ % 3 == 0) {
						gg_html += '</tr>';
					}
					if (j % 3 == 1) {
						if (parseInt(j / 3) % 2 == 1) {
							gg_html += '<tr class="even">';
						} else {
							gg_html += '<tr>';
						}
					}
					checked_html = '';
				}
			}
		}
		/* @todo 这里需要补齐缺少的单元格td */
		this.ggTable.empty();
		this.get(gg_html).insert(this.ggTable);
	},

	// 获取所选的过关方式
	getGgInfo : function() {
		var gg_info = new Array();
		this.ggTable.find('input').each( function(item) {
			item.checked && gg_info.push(item.value);
		}, this );
		return gg_info;
	},
	
	// 获取更为完整的过关信息
	getGgInfoMore : function() {
		var Y, gg_info;
		Y = this;
		gg_info = {};
		gg_info.gggroup = Y.ggTypeMap[Y.ggType];
		gg_info.sgtypename = Y.getGgInfo().join(',');
		gg_info.sgtype = Y.getGgInfo().each( function(item) {
			this.push(Y.ggGroupMap[item]);
		}, [] ).join(',');
		return gg_info;
	},

	disableOrEnableGgCk : function() {
		this.ggTable.find('input').each( function(item) {
			var gg_match_num = parseInt(item.value) || 1;
			if (gg_match_num <= this.danmaNum) {
				item.disabled = true;
			} else {
				if (!item.disabled) {
					return;
				}
				item.disabled = false;
			}
		}, this );
	},

	updateGgCk : function() {
		var gg_match_num_real, gg_match_num;
		if (this.danmaNum == this.matchNum - 1) {
			gg_match_num = 1;
		} else if (this.getGgInfo().length == 0) {
			gg_match_num = 0;
		} else {
			gg_match_num_real = parseInt(this.getGgInfo()[0]) || 1;
			if (this.ggType == '自由过关' && gg_match_num_real == this.matchNum) {
				gg_match_num  = -2;
				this.danmaNum = 0;
				this.disableOrEnableGgCk();
			} else {
				gg_match_num = gg_match_num_real;
			}
		}
		this.postMsg('msg_disable_or_enable_danma', gg_match_num);
	},

	changed : function() {
		this.updateGgCk();
		this.postMsg('msg_guoguan_info_changed');
	},
	clearchanged : function() {
		this.updateGgCk();
		this.postMsg('msg_guoguan_info_changed_zz');
	}

} );


/* TouzhuResult 北单投注结果
------------------------------------------------------------------------------*/
Class( 'TouzhuResult', {

	beishu   : 0,
	matchNum : 0,
	zhushu   : 0,
	totalSum : 0,
    splitMap:{
            '2串1':{'2串1':1},
			'2串3':{'2串1':1,'1单关':2},
            '3串1':{'3串1':1},
            '4串1':{'4串1':1},
            '5串1':{'5串1':1},
            '6串1':{'6串1':1},
			'7串1':{'7串1':1},
			'8串1':{'8串1':1}, 
            '3串3':{'2串1':3},
            '3串4':{'3串1':1,'2串1':3},
			'3串7':{'3串1':1,'2串1':3,'1单关':3},
            '4串6':{'2串1':6},
			'4串15':{'4串1':1,'3串1':4,'2串1':6,'1单关':4},
            '4串11':{'4串1':1,'3串1':4,'2串1':6},
            '5串10':{'2串1':10},
            '5串20':{'2串1':10,'3串1':10},
            '5串26':{'5串1':1,'4串1':5,'3串1':10,'2串1':10},
            '6串15':{'2串1':15},
            '6串35':{'2串1':15,'3串1':20},
            '6串50':{'2串1':15,'3串1':20,'4串1':15},
            '6串57':{'6串1':1,'5串1':6,'4串1':15,'3串1':20,'2串1':15},
			'6串63':{'6串1':1,'5串1':6,'4串1':15,'3串1':20,'2串1':15,'1单关':6},
            '4串4':{'3串1':4},
            '4串5':{'4串1':1,'3串1':4},
            '5串16':{'5串1':1,'4串1':5,'3串1':10},
            '6串20':{'3串1':20},
            '6串42':{'6串1':1,'5串1':6,'4串1':15,'3串1':20},
            '5串5':{'4串1':5},
            '5串6':{'5串1':1,'4串1':5},
            '6串22':{'6串1':1,'5串1':6,'4串1':15},
            '6串6':{'5串1':6},
            '6串7':{'6串1':1,'5串1':6},
			'7串7' : {'6串1':7},
			'7串8' : {'6串1':7, '7串1':1},
			'7串21' : {'5串1':21},
			'7串35' : {'4串1':35},
			'7串120': {'2串1':21, '3串1':35, '4串1':35, '5串1':21, '6串1':7, '7串1':1},
			'8串8' : {'7串1':8},
			'8串9' : {'7串1':8, '8串1':1},
			'8串28' : {'6串1':28},
			'8串56' : {'5串1':56},
			'8串70' : {'4串1':70},
			'8串247': {'2串1':28, '3串1':56, '4串1':70, '5串1':56, '6串1':28, '7串1':8, '8串1':1}
	},
	index : function(config) {
		var Y = this;
		this.beishuInput = this.need(config.beishuInput);
		this.matchNumTag = this.need(config.matchNum);
		this.zhushuTag   = this.need(config.zhushu);
		this.totalSumTag = this.need(config.totalSum);

		this.zhushuCalculator = this.lib.ZhushuCalculator();

		// 改变倍数时
		this.beishuInput.keyup( function() {
			Y.updateTouzhuResult();
		} ).blur( function() {
			if (this.value == '') {
				this.value = 1;
				Y.updateTouzhuResult();
			}
		} );
		
		this.onMsg('msg_guoguan_info_changed', function() {
			this.updateTouzhuResult();
		} );
		
		this.onMsg('msg_guoguan_info_changed_zz', function() {
			
			this.updateTouzhuResultzz();
		} );
        
        
		
		this.onMsg('msg_get_bottom_info',function(){
				var data = this.postMsg('msg_get_touzhu_codes').data;
				this.get_bottom_info(data);									  
		});
		
		// 返回投注结果，用于表单提交
		this.onMsg('msg_get_touzhu_result_4_submit', function() {
			return this.getTouzhuResult4Submit();
		} );

		// 返回修改时重现位数
		this.onMsg('msg_restore_beishu', function(beishu) {
			this.beishuInput.val(beishu);
			this.updateTouzhuResult();
		} );
		this.onMsg('msg_get_hunjiang',function(_pl){
		    return this._getHunJiang(_pl);
		});
	},
    get_bottom_info: function(data){
		ggtype = this.postMsg('msg_get_gg_info_more').data.gggroup;   //2多串 ,3 单关、自由
		if(ggtype==2){
			this._getDCHitSplitzz(data.length,true);
	    }
		else if(ggtype==3){
			this._getHitSplitzz(data.length,true);
	    }
        this.postMsg('msg_rowRender');
    },
	_getDCHitSplitzz: function (hitNum, isMax){//生成不同命中的(明细)`
        	var c1 = this._getHitType().n_1,//[3'c1',2'c1']
                data = this.postMsg('msg_get_touzhu_codes').data, spData;
				
        	var t = this.zz_tpl[0], 
			    f = this.zz_tpl[2], 
                bm = this.zz_tpl[1];
            var totalMoney = 0,
                totalZs = 0,
                b = [];
            var dan=[];
			ck_index = Class.config('codeValue');
			zmap={
				"胜":"0",
				"平":"1",
				"负":"2"
                };
            var midarr=[],zc1,del = /,/g,split_pl = [];
            Y.data = Y.postMsg('msg_get_data_4_prize_predict').data;
			
		    data.each(function (a){//每个对阵的最大SP值
			  var _name=[],_sp=[];
			  for (var n=0;n < a.arr.length; n++) { 
				zc1=zmap[a.arr[n]];
				var obj={};
				Y.data.each(function(b){
				    if(a.index==b.serialNumber)
				   {
					 obj=b;
				   }
				});
				_name.push(a.index.replace(del,'')+'('+a.arr[n]+')');
				_sp.push(obj.sp[n]);
			  }
			    var mid = _name.join('*')+'||'+_sp.join('*')+'||'+a.index;
				if(a.dan)
				{
					dan.push(mid);
				}
				else
				{
					midarr.push(mid);
				}
				
		    });
			
			var ggData =  curGg = this.postMsg('msg_get_guoguan_info').data,
                duoc = parseInt(ggData)?parseInt(ggData):false;   //3串4的3
		
			pl = Math.dtl(dan, midarr, duoc);//转成基本套票
		    var zzjpnum=0;
			
			pl.each(function(_pl) {
			    var znarr=[],zzpname=[],zzstr = [],regixtest=/\*/,split_plxp = [],zztype;
				//shai xuan
				_pl.map(function(zn){
					
					znarr=zn.split("||");
					if(!zzpname[znarr[2]]){
					   zzpname[znarr[2]]=true;
					}
					else{
					   zzstr['repeat']=true;
					}
					if(!zzstr['repeat']){
						  if(regixtest.test(zn)){
						     	  zztype='hh';
						  }
						 
					}
				},this);
				
				 if(zztype=='hh' && !zzstr['repeat']){  //混合型
						split_plhh = Y.postMsg('msg_get_hunjiang',_pl).data;
						split_pl = split_pl.concat(split_plhh);
				 }
				 else
			     {
							
						c1.each(function(n) {
							split_pl = split_pl.concat(Math.dtl(dan,_pl, n));//转成串一的小票
						})
				 }
			});
			
			//split_pl 所有完整组合
			var split_pl2={};
            split_pl.map(function(d){
            	var dlength = d.length;
            	if(split_pl2[dlength]==undefined){
            		split_pl2[dlength] = new Array();
            	}
            	split_pl2[dlength].push(d);
            	
            },this);
            var zznummoney;
            var zn=0;
            var rzzstr = '|||';
       
      for (var i = 0, j = c1.length; i < j; i++) { 
    	  var n = c1[i],money;
		  
    	  var expr = split_pl2[n].map(function (d){
            	var zzstr = [],zzmoney = [],zzpname = [],zzbmp;
				 d.map(function(zn){
					znarr=zn.split("||");
					if(!zzpname[znarr[2]]){
					   zzstr.push(znarr[0]);
					   zzpname[znarr[2]]=true;
					   zzmoney.push(znarr[1]);
					}
					else{
					  zzstr['repeat']=true;
					}
				},this);
				/*第二次筛选
			    if(zzstr['repeat']!=true){
					zzbmp = zzstr.join('');
					if(rzzstr.indexOf('|||'+zzbmp+'|||')<0){
						rzzstr+=zzbmp+"|||";
					}
					else{
						zzstr['repeat']=true;
					}
			    }
			    end*/
				zznummoney = zzmoney.reduce(function (s, o){
                             return s*o
                });
				
               money  =  zznummoney*2*this.beishu;
				//totalMoney += money;
              
               if(zzstr['repeat']!=true){
                  zn=zn+1;
                 return '<tr><td>'+zn+'</td><td>'+zzstr.length+'×1</td><td>'+zzstr.join('×')+'</td><td>'+money.toFixed(2)+'</td></tr>';
               }
          }, this).join(' ');
         
            b.push(bm.tpl({
                expr: expr
            }));
        } //end for
            this.get('#zzdetail').html(t + b.join('') + f);
			this.zhushu = zn;
			this.totalSum = this.zhushu * this.beishu * 2;
		
      },
	_getHunJiang: function(getpl){
		var midarr=[],hjtest=/\*/,hjax=[],hjaxa=[],hjstr,hjaxb=[],dan=[],split_pl=[],zzdata=[];
		var c1 = this._getHitType().n_1;
		getpl.map(function(n){    //拆解_pl
			if(hjtest.test(n)){
			   hjax	= n.split('||');
			   hjaxa = hjax[0].split('*');
			   hjaxb = hjax[1].split('*');
			   for(i=0;i<hjaxa.length;i++){
				    hjstr = hjaxa[i]+"||"+hjaxb[i]+"||"+hjax[2];
					midarr.push(hjstr);
			   }
			}
			else
			{
				midarr.push(n);
			}
		},this);
		
		var ggData =  curGg = this.postMsg('msg_get_guoguan_info').data,
        duoc = parseInt(ggData)?parseInt(ggData):false;   //3串4的3
		pl = Math.dtl(dan, midarr, duoc);//转成基本套票
		pl.each(function(_pl) {
				c1.each(function(n) {
						split_pl = split_pl.concat(Math.dtl(dan,_pl, n));//转成串一的小票
				})
				
		});
		var split_pl2={};
        split_pl.map(function(d){
            	var dlength = d.length;
            	if(split_pl2[dlength]==undefined){
            		split_pl2[dlength] = new Array();
            	}
            	split_pl2[dlength].push(d);
            	
        },this);
		var rzzstr = '|||';
        for (var i = 0, j = c1.length; i < j; i++) { 
    	  var n = c1[i];
		  var expr = split_pl2[n].map(function (d){
            	var zzstr = [],zzpname = [],zzbmp,znarr=[];
				d.map(function(zn){
					znarr=zn.split("||");
					if(!zzpname[znarr[2]]){
					   zzstr.push(znarr[0]);
					   zzpname[znarr[2]]=true;
					}
					else{
					  zzstr['repeat']=true;
					}
				},this);
				
			    if(zzstr['repeat']!=true){
					zzbmp = zzstr.join('');
					if(rzzstr.indexOf('|||'+zzbmp+'|||')<0){
						rzzstr+=zzbmp+"|||";
					}
					else{
						zzstr['repeat']=true;
					}
			    }
			 
				
				
              
				//totalMoney += money;
              
               if(zzstr['repeat']!=true){
                    zzdata.push(d);
               }
		  });
           
         } //end for
		 return zzdata;
		 
	},
	_getHitSplitzz: function (hitNum, isMax){//生成不同命中的(明细), 自由    hitNum:总场数,isMax:boolean 奖金大小
	      
		   var c1 = this._getHitType().n_1,//[3'c1',2'c1']    //6,5,4,3,2
		       data = this.postMsg('msg_get_touzhu_codes').data, spData,          //data 选中的场次对象集合以,号分割
               allData = this._getMinMaxListzz(data, c1);   //获得最小最大清单
		   var t = this.zz_tpl[0], 
			    f = this.zz_tpl[2], 
                bm = this.zz_tpl[1],
                totalMoney = 0,
                totalZs = 0, dan=0,
                b = [];
				
            data.each(function (o){
                dan+=o.dan?1:0
            });
			spData = allData[0];
			
            var zn=0;	
            for (var i = 0, j = c1.length; i < j; i++) {
                var n = c1[i], money = 0 ,zs = 0;
				if (n <= hitNum) {//应该以最大的n-1个为胆，进行组合,n为选中的n串1中的n
				    zs = Math.dt(dan, hitNum-dan, n);// zs注n串1
					var clip = isMax ? [-zs] : [0, zs];  //修剪
					var expr = spData[n].map(function (d){
						 var zzstr = [],zzmoney = [],zzpname = [];
						 d[0].map(function(zn){
							znarr=zn.split("||");
							if(!zzpname[znarr[2]]){
							   zzstr.push(znarr[0]);
							   zzpname[znarr[2]]=true;
							   zzmoney.push(znarr[1]);
							   
							}
							else{
							  zzstr['repeat']=true;
							}
						},this);
						
						zznummoney = zzmoney.reduce(function (s, o){
                                      return s*o
                                   });
					    
                        money  =  zznummoney*2*this.beishu;
					    //totalMoney += money;
                        if(!zzstr['repeat']){
                           zn=zn+1;
                          return '<tr><td>'+zn+'</td><td>'+n+'×1</td><td>'+zzstr.join('×')+'</td><td>'+money.toFixed(2)+'</td></tr>';
                        }
                    }, this).join(' ');
                  
				    b.push(bm.tpl({
                        expr: expr
                    }));
				    totalZs += zs
                }
            }
			/*
            b.push(bm.tpl({
                ggtype: '合  计',
                zs: totalZs + '注',
                expr: '&nbsp;',
                money: totalMoney.toFixed(2) + '元'
            }));
			*/
            this.get('#zzdetail').html(t + b.join('') + f);
			
        },
		zz_tpl:['<table width="100%" cellspacing="0" cellpadding="0" border="0" style="table-layout:fixed">'+
				'<tr><th width="100">注号</th><th width="120">过关方式</th><th>注项内容</th><th width="200" class="last_th">奖金</th></tr>',
				'{$expr}',
				'</table>',
				],
		_getHitType: function (){//生成过关方式表头和数据
            var ggTitle = [], tmp = [], ggtype, c1=[], curGg = this.postMsg('msg_get_guoguan_info').data;
			ggtype = this.postMsg('msg_get_gg_info_more').data.gggroup; 
			if(ggtype==2){
			 curGg=curGg[0];	
			}
			if (this.isString(curGg)) {//如果是多串(固定组合)过关,先进行转换
                ggtype = this.splitMap[curGg];
				for(var k in ggtype){//命中表头
                    tmp[tmp.length] = k;
                }
            }else{
                tmp = curGg
            }
            tmp.sort(function (a, b){
                return parseInt(a)> parseInt(b)? 1 : -1
            });
            for (var i =  tmp.length; i--;) {
                ggTitle.push('<td>'+tmp[i]+'</td>');
                c1.push(parseInt(tmp[i]))                
            }
			
            return {
                length: c1.length,
                n_1: c1,//[3,2,1]
                html:ggTitle.join('')//'<td>3串1</td>...'
            }
        },
	 _getMinMaxListzz: function (data, c1){//返回一个数组存放最大的日日期
	      
           var  prixsUp = {}, prixsDown = {}, del = /,/g, dan_sp_max=[], dan_sp_min=[], maxs = [], mins = [], midarr = [];
		   zmap={
				"胜":"0",
				"平":"1",
				"负":"2"
                };
		  Y.data = Y.postMsg('msg_get_data_4_prize_predict').data;
		  data.each(function (a){//每个对阵的最大SP值
			  for (var n=0;n < a.arr.length; n++) { 
				zc1=zmap[a.arr[n]];
				var obj={};
				Y.data.each(function(b){
					
	               if(a.index==b.serialNumber)
				   {
					 obj=b;
				    }
				   
				});
				
				var mid = a.index.replace(del,'')+'('+a.arr[n]+')'+'||'+obj.sp[n]+'||'+a.index;
				midarr.push(mid);
			  }
		   });
		  for (var n =  c1.length; n--;) {//c1 = [4, 5]分别代表几串1
		        var zh = Math.dtl(dan_sp_max, midarr, c1[n]);
				
                prixsUp[c1[n]] = zh.map(function (a){//所有单注最高奖金表
                    return [a, a.reduce(function (s, o){
                        return s*o
                    }, 1)]
                }).sort(function (a, b){
                    return parseFloat(a[1]) > parseFloat(b[1]) ? 1 : -1
                });
                
           };
		  
		   return [prixsUp,maxs,mins,dan_sp_max,dan_sp_min]//maxs和mins是不含胆的
        },
	// 更新投注结果
	updateTouzhuResult : function() {
		if (!parseInt(this.beishuInput.val())) {
			this.beishu = '';
		} else {
			this.beishu = parseInt(this.beishuInput.val());
		}
		this.zhushu = this.countZhushu();
		this.totalSum = this.zhushu * this.beishu * 2;
		this.updateHtml();
	},
	updateTouzhuResultzz : function() {
		
		if (!parseInt(this.beishuInput.val())) {
			this.beishu = '';
		} else {
			this.beishu = parseInt(this.beishuInput.val());
		}
		this.zhushu = this.countZhushu();
		this.totalSum = this.zhushu * this.beishu * 2;
		this.updateHtmlzz();
	},

	updateHtml : function() {
		this.postMsg('msg_get_bottom_info');
		this.beishuInput.val(this.beishu);  //更新倍数
		this.matchNumTag.html(this.matchNum);  //更新所选场次数
		this.zhushuTag.html(this.zhushu);  //更新注数
		this.totalSumTag.html(this.totalSum.rmb(true, 0)); //更新投注金额
		
	//	log('选号耗时：' + (new Date - Class.config('d')))
	},
	updateHtmlzz : function() {
		this.get('#zzdetail').html('<table width="100%" cellspacing="0" cellpadding="0" border="0" style="table-layout:fixed">'+
				'<tr><th width="100">注号</th><th width="120">过关方式</th><th>注项内容</th><th width="200" class="last_th">奖金</th></tr></table>');
		this.beishuInput.val(this.beishu);  //更新倍数
		this.matchNumTag.html(this.matchNum);  //更新所选场次数
		this.zhushuTag.html(this.zhushu);  //更新注数
		this.totalSumTag.html(this.totalSum.rmb(true, 0)); //更新投注金额
		
	//	log('选号耗时：' + (new Date - Class.config('d')))
	},

	getTouzhuResult4Submit : function() {
		return {
			zhushu : this.zhushu,
			beishu : this.beishu,
			totalmoney : this.totalSum
		}
	},

	countZhushu : function() {  //计算注数
		var codes, danma, ggtype, ggmlist;
		//codes 选场对象数组
		codes = this.postMsg('msg_get_touzhu_codes').data;
		this.matchNum = codes.length;  //保存场次数
		ggmlist = this.postMsg('msg_get_guoguan_info').data;    //所选过关类型
		if (this.matchNum == 0 || ggmlist.length == 0) {
			return 0;
		}
		ggtype = this.postMsg('msg_get_gg_info_more').data.gggroup;   //2多串 ,3 单关、自由
		danma = this.postMsg('msg_get_danma').data;
	    codes.each( function(item) {
			item.dan = danma[item.index];
		} );
		
		return this.postMsg('msg_get_zhushu', codes, ggtype, ggmlist).data;
	}

} );


/* Restore 重现填写的数据
------------------------------------------------------------------------------*/
Class( 'Restore', {

	index : function() {
		this.cookie('restore_data') && this.restoreData();   //返回修改
		this.cookie('bjdc_league') && this.restoreLeague(); //资讯跳转(显示某一联赛)
		this.cookie('bjdc_codes') && this.restoreCodes();  //资讯跳转(重现之前的选择)
	},

	restoreData : function() {
		var restore_data = this.dejson(this.cookie('restore_data'));
		this.cookie('restore_data', '', {timeout:-1});
		this.postMsg('msg_restore_codes', this.processCodes(restore_data.codes));
		this.postMsg('msg_restore_gggroup', restore_data.gggroup);
		this.postMsg('msg_restore_sgtype', restore_data.sgtype.split(','));
		this.postMsg('msg_restore_danma', this.processDanma(restore_data.danma));
		this.postMsg('msg_restore_beishu', restore_data.beishu);
	},

	restoreLeague : function() {
		var league_name = decodeURIComponent(this.cookie('bjdc_league'));
		this.cookie('bjdc_league', '', {timeout:-1,path:'/'});
		this.postMsg('msg_show_certain_league', league_name);
	},

	restoreCodes : function() {
		var codes = decodeURIComponent(this.cookie('bjdc_codes'));
		this.cookie('bjdc_codes', '', {timeout:-1,path:'/'});
		this.postMsg('msg_restore_codes', this.processCodes(codes));
	},

	//2:[平,负]/3:[负] 变成 [ {index:2, arr:[平,负]}, ... ]
	processCodes : function(codes) {
		codes = codes.split('/');
		return codes.each( function(item) {
			var info = item.match(/^(\d+):\[(.+)\]$/);
			this.push( { 'index':info[1], 'arr':info[2] } );
		}, [] );
	},

	//2:[平,负]/3:[负] 变成 [2,3]
	processDanma : function(danma) {
		if (danma.length == 0) return '';
		danma = danma.split('/');
		return danma.each( function(item) {
			var info = item.match(/^(\d+):\[(.+)\]$/);
			this.push( info[1] );
		}, [] );
	}

} );


/* Clock 当前时间
------------------------------------------------------------------------------*/
Class( 'Clock', {
	index : function(clock_id) {
		this.clockTag = this.get(clock_id);
		this.runClock();
	},
	runClock : function() {
		var Y = this;
		setInterval( function() {
			var d = new Date();
			var d_str = Y.addZero((d.getMonth() + 1)) + '月' + Y.addZero(d.getDate()) + '日 ' + Y.addZero(d.getHours()) + ':' + Y.addZero(d.getMinutes()) + ':' + Y.addZero(d.getSeconds());
			Y.clockTag.html(d_str);
		}, 1000 );
	},
	addZero : function(n) {
		return parseInt(n) < 10 ? '0' + n : n;
	}
} );


/* 主程序 ~!@#$%^&*()_+-={}|:"<>?,./;'[]\!!!!!!!!
------------------------------------------------------------------------------*/
Class( {
	
	use   : 'mask',
	ready : true,

	index : function () {
		var Y = this, d = new Date();

		// 切换期号
		this.get('#expect_select').change( function() {
			var url = location.href.replace(/#.*/, '');
			if (url.indexOf('expect') != -1) {
				url = url.replace(/expect=.+?(?=&|$)/ig, 'expect=' + this.value.split('|')[0]);
			} else if (url.indexOf('?') != -1 && url.indexOf('=') != -1) {
				url += '&expect=' + this.value.split('|')[0];
			} else {
				url += '?expect=' + this.value.split('|')[0];
			}
			location.replace(url);
		} );

		if (this.get('tr.vs_lines').nodes.length == 0) {
			return;  //没取到对阵的话则以下js代码不执行
		}

		Class.extend( 'getIndex', function(arr, v) {
			for (var i = 0, l = arr.length; i < l; i++) {
				if (arr[i] == v) return i;	
			}
			return -1;
		} );

		Class.config('playId', parseInt(this.need('#playid').val()) );  //玩法id
		Class.config('expect', this.need('#expect').val() );  //期号
		switch (Class.config('playId')) {
			case 34 :    //让球胜平负
				Class.config('playName', 'rqspf');
				Class.config('codeValue', ['胜', '平', '负']);
				break;
			case 40 :    //总进球数
				Class.config('playName', 'jq');
				Class.config('codeValue', ['0', '1', '2', '3', '4', '5', '6', '7+']);
				break;
			case 41 :    //上下单双
				Class.config('playName', 'ds');
				Class.config('codeValue', ['上+单', '上+双', '下+单', '下+双']);
				break;
			case 42 :    //比分
				Class.config('playName', 'bf');
				Class.config('codeValue', [ '胜其他', '1:0', '2:0', '2:1', '3:0', '3:1', '3:2', '4:0', '4:1', '4:2', 
				                            '平其他', '0:0', '1:1', '2:2', '3:3', 
				                            '负其他', '0:1', '0:2', '1:2', '0:3', '1:3', '2:3', '0:4', '1:4', '2:4' ]);
				break;
			case 51 :    //半全场
				Class.config('playName', 'bq');
				Class.config('codeValue', ['胜-胜', '胜-平', '胜-负', '平-胜', '平-平', '平-负', '负-胜', '负-平', '负-负']);
				break;
			default :
		}
		var code_value_index = {};
		Class.config('codeValue').each( function(v, i) {
			code_value_index[v] = i;
		} )
		Class.config('codeValueIndex', code_value_index);
		Class.config('stopSale', this.need('#stop_sale').val() == 'yes');

		var tableSelectorClass = this.lib.TableSelector_BF || this.lib.TableSelector;
		tableSelectorClass( {
			vsTable : '#vs_table',
			vsLines : 'tr.vs_lines',
			spLines : 'tr.sp_lines',

			ckRangqiu   : '#ck_rangqiu',
			ckNoRangqiu : '#ck_no_rangqiu',
			ckOutOfDate : '#ck_out_of_date',
			hiddenMatchesNumTag : '#hidden_matches_num',
			matchShowTag : '#match_show',
			matchFilter  : '#match_filter',
			leagueShowTag  : '#league_show',
			leagueSelector : '#league_selector',
			selectAllLeague      : '#select_all_league',
			selectOppositeLeague : '#select_opposite_league'
		} );

		this.lib.TouzhuInfo( {
			endtime : '#endtime',
			vsLines : 'tr.vs_lines',
			touzhuTable : '#touzhu_table',
			mouseoverClass : 'nx_s'
		} );

		this.lib.GuoGuan( {
			switchTag : '#gg_type li',
			ggTable   : '#gg_table tbody'
		} );

		this.lib.TouzhuResult( {
			beishuInput : '#beishu_input',
			matchNum    : '#match_num',
			zhushu      : '#zhushu',
			totalSum    : '#total_sum'
		} );
		
		this.lib.ConfirmForm();
		this.lib.Restore();
		this.lib.Clock('#running_clock');
		this.lib.PrizePredict();
        this.lib.rowRender();
	/*	// 切换平均赔率与投注比例
		if (Class.config('playName') == 'rqspf') {
			Y.need('#vs_table_header select').change( function() {
				Y.need('#vs_table .pjoz, #vs_table .tzbl, #vs_table .asianhand').hide();
				switch (this.value) {
					case '0' : Y.need('#vs_table .pjoz').show(true, 'inline-block'); break;
					case '1' : Y.need('#vs_table .tzbl').show(true, 'inline-block'); break;
					case '2' : Y.need('#vs_table .asianhand').show(true, 'inline-block');
				}
			} );
		}*/

		if (Class.config('disableBtn')) { //禁用代购和合买按钮
			Y.get('#dg_btn').swapClass('btn_Dora_bs', 'btn_Dora_bstop').html('<b>确认代购</b>').attr('id', '');
			Y.get('#hm_btn').swapClass('btn_Dora_bs', 'btn_Dora_bstop').html('<b>发起合买</b>').attr('id', '');
		}

		// 发起代购
		Y.get('#dg_btn').click( function() {
			Y.postMsg('msg_do_dg');
		} );

		// 发起合买
		Y.get('#hm_btn').click( function() {
			Y.postMsg('msg_do_hm');
		} );

		Y.get('#clear_all').click( function() {
					Y.postMsg('msg_clear_all');	
		});

        //创建一个公共弹窗, 使用msg_show_dlg进行调用
		this.infoLay = this.lib.MaskLay('#defLay', '#defConent');
		this.infoLay.addClose('#defCloseBtn', '#defTopClose a');
		this.get('#defLay div.tips_title').drag(this.get('#defLay'));
		this.infoLay.noMask = self != top;

		// 提供弹窗服务
		this.onMsg('msg_show_dlg', function (msg, fn, forbid_close) {
			this.infoLay.pop(msg, fn, forbid_close);
			if (Y.C('autoHeight')) {
				this.infoLay.panel.nodes[0].style.top = Y.C('clientY') - 80 + 'px';
			}
		} );

		this.goTop = this.one('a.back_top');
		this.rightArea = this.get('#right_area');
		this.mainArea = this.get('#main');
		if (this.ie && this.ie == 6) {
			this.goTop.style.position = 'absolute';
			this.goTop.style.left = '750px';
		} else {
			setTimeout( function() {
				Y.goTop.style.left = Y.rightArea.getXY().x + 'px';
			}, 500 );
		}
		this.get(window).scroll( function () {
			clearTimeout(Class.C('scrollTimer'));
			if (Y.ie && Y.ie == 6) {
				Class.C('scrollTimer', setTimeout(Y.scrollStillIE6.proxy(Y), 100));
			} else {
				Class.C('scrollTimer', setTimeout(Y.scrollStill.proxy(Y), 100));
			}
		} );

	//	log('页面载入耗时：' + (new Date() - d))

	},

	scrollStill : function() {
		var window_size = Y.getSize();
		Y.goTop = Y.get('a.back_top');
		Y.mainArea = Y.get('#main');
		Y.leftArea = Y.get('#main div.dc_l');
		Y.rightArea = Y.get('#main div.dc_r');
		var right_xy = Y.rightArea.getXY();
		var right_size = Y.rightArea.getSize();
		if (window_size.scrollTop + window_size.offsetHeight > Y.mainArea.getXY().y + Y.mainArea.getSize().offsetHeight + 10) {
			Y.goTop.setStyle('position', 'absolute').setStyle('bottom', 0).setStyle('left', '750px');
		} else {
			Y.goTop.setStyle('position', 'fixed').setStyle('bottom', '10px').setStyle('left', right_xy.x + 'px');
		}
		if (window_size.scrollTop <= right_xy.y || 
				right_xy.y + right_size.offsetHeight + 90 > window_size.scrollTop + window_size.offsetHeight ||
				Y.leftArea.getSize().offsetHeight - 90 < right_size.offsetHeight) {
			Y.goTop.hide();
		} else {
			Y.goTop.show();
		}
	},

	scrollStillIE6 : function() {
		var window_size = Y.getSize();
		Y.goTop = Y.get('a.back_top');
		Y.mainArea = Y.get('#main');
		Y.leftArea = Y.get('#main div.dc_l');
		Y.rightArea = Y.get('#main div.dc_r');
		var right_xy = Y.rightArea.getXY();
		var right_size = Y.rightArea.getSize();
		if (window_size.scrollTop + window_size.offsetHeight > Y.mainArea.getXY().y + Y.mainArea.getSize().offsetHeight + 10) {
			Y.goTop.setStyle('top', '').setStyle('bottom', 0);
		} else {
			Y.goTop.setStyle('top', window_size.scrollTop + window_size.offsetHeight - 310 + 'px');
		}
		if (window_size.scrollTop <= right_xy.y || 
				right_xy.y + right_size.offsetHeight + 90 > window_size.scrollTop + window_size.offsetHeight || 
				Y.leftArea.getSize().offsetHeight - 90 < right_size.offsetHeight) {
			Y.goTop.hide();
		} else {
			Y.goTop.show();
		}
	}

});
Class( 'rowRender', {
    ready: true,
    index : function() {
	  
	   this.onMsg('msg_rowRender',function(){
		this.rowRender('zzdetail','tr');								   
	   });
	},
	rowRender: function(id, item, odd, even, start, end) {    
	  
       var list = document.getElementById(id);    
       var items = list.getElementsByTagName(item); 
	   if (isNaN(start) || (start < 0 || start >= items.length)) {       
	     start = 0;   
	   }    
	   if (isNaN(end) || (end < start || end >= items.length)) { 
	    end = items.length;  
	    }  
	     odd  = odd  || 'odd';  
	     even = even || 'even';     
      for (var i = start; i < end; i++) {     
	    var className = ' ' + ((i % 2 == 0) ? odd : even);     
        items[i].className += className;   
      }
   }
});