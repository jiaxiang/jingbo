/**
 * 预测奖金生成器
 */
Class( 'prizePrediction', {
	ready : true,
	typeMap : {
		'3串3' :['2串1'],
		'3串4' :['2串1','3串1'],
		'4串6' :['2串1'],
		'4串11':['2串1','3串1','4串1'],
		'5串10':['2串1'],
		'5串20':['2串1','3串1'],
		'5串26':['2串1','3串1','4串1','5串1'],
		'6串15':['2串1'],
		'6串35':['2串1','3串1'],
		'6串50':['2串1','3串1','4串1'],
		'6串57':['2串1','3串1','4串1','4串1','5串1','6串1'],
		'4串4' :['3串1'],
		'4串5' :['3串1','4串1'],
		'5串16':['3串1','4串1','5串1'],
		'6串20':['3串1'],
		'6串42':['3串1','4串1','5串1','6串1'],
		'5串5' :['4串1'],
		'5串6' :['4串1','5串1'],
		'6串22':['4串1','5串1','6串1'],
		'6串6' :['5串1'],
		'6串7' :['5串1','6串1'],

		'7串7'  :['6串1'],
		'7串8'  :['6串1','7串1'],
		'7串21' :['5串1'],
		'7串35' :['4串1'],
		'7串120':['2串1','3串1','4串1','4串1','5串1','6串1','7串1'],
		'8串8'  :['7串1'],
		'8串9'  :['7串1','8串1'],
		'8串28' :['6串1'],
		'8串56' :['5串1'],
		'8串70' :['4串1'],
		'8串247':['2串1','3串1','4串1','4串1','5串1','6串1','7串1','8串1']
	},
	index : function() {
		this.onMsg('msg_predict_max_prize', function(max_sp, gg_name, dan_sp, new_round) {
           
			return this.predictMaxPrize(max_sp, gg_name, dan_sp, new_round);
		});
		this.onMsg('msg_predict_min_prize', function(min_sp, gg_name, dan_sp, new_round) {
			return this.predictMinPrize(min_sp, gg_name, dan_sp, new_round);
		});
	},
	/**
	 * 预测最大奖金
	 *
	 * @param Array  max_sp  最大赔率构成的数组
	 * @param Stirng gg_name 过关方式(单关或m串n)
	 * @param String new_round 是否采用4舍6入5进双规则
	 * @return Number 最大奖金
	 * 4.1,1.6    2串1   ""(object)   underfined
	 */
	predictMaxPrize : function(max_sp, gg_name, dan_sp, new_round) {
//		alert(max_sp +','+ gg_name +','+ dan_sp +','+ new_round);
		var max_prize = 0, hasDan = dan_sp && dan_sp.length > 0;
		if (gg_name == '单关') {
			max_prize = max_sp.reduce( function(a,b){return a+b} );
			
		} else if (/串1$/.test(gg_name)) {  //自由
			gg_name = gg_name.split(',');
			gg_name.each( function(_gg_name) {
				var _n = parseInt(_gg_name);
				
				if (hasDan) {
                    Math.dtl(dan_sp, max_sp, _n).each( function(sp) {
                        max_prize += sp.reduce( function(a,b){return (a*10000)*(b*10000)/100000000} );
                    }, this );                        
                }else{
                    Math.cl(max_sp, _n).each( function(sp) {
                        max_prize += sp.reduce( function(a,b){return (a*10000)*(b*10000)/100000000} );
                    }, this );                    
                }
			}, this );
		} else {  //多串(不去重)
			var _n = parseInt(gg_name),
				gg_split = this.typeMap[gg_name];
            var cl = hasDan ? Math.dtl(dan_sp, max_sp, _n) : Math.cl(max_sp, _n);//判断是否胆
			cl.each( function(sp) {
				gg_split.each( function(_gg_name) {
					var __n = parseInt(_gg_name);
					Math.cl(sp, __n).each( function(_sp) {
						max_prize += _sp.reduce( function(a,b){return (a*10000)*(b*10000)/100000000} );
					}, this );
				}, this );
			}, this );
		}
//		if (gg_name != '单关') {
//			max_prize *= 2;
//		}
		max_prize *= 2;
		
		return max_prize = new_round ? this.newRound(max_prize) : (+max_prize).toFixed(2);

	},
	/**
	 * 预测最小奖金
	 *
	 * @param Array  min_sp  最小赔率构成的数组
	 * @param Stirng gg_name 过关方式(单关或m串n)
	 * @param String new_round 是否采用4舍6入5进双规则
	 * @return Number 最小奖金
	 */
	predictMinPrize : function(min_sp, gg_name, dan_sp, new_round) {
		var min_prize = 0;
		if (gg_name == '单关') {
			min_prize = min_sp.sort(Array.up)[0];
		} else if (/串1$/.test(gg_name)) {  //自由
			var min_n = parseInt(gg_name);
			min_prize = min_sp.sort(Array.up).slice(0, min_n).reduce( function(a,b){return (a*10000)*(b*10000)/100000000} );
		} else {  //多串(不去重)
			var _n = parseInt(gg_name),
				min_n = parseInt(this.typeMap[gg_name][0]);
			min_prize = min_sp.sort(Array.up).slice(0, min_n).reduce( function(a,b){return (a*10000)*(b*10000)/100000000} );
			min_prize *= Math.c(min_sp.length - min_n, _n - min_n);
		}
		if (gg_name != '单关') {
			min_prize *= 2;
		}
		return min_prize = new_round ? this.newRound(min_prize) : (+min_prize).toFixed(2);
	},
	/**
	 * 4舍6入5进双
	 */
	newRound : function(n) {
		if (/\d+\.\d\d5/.test(n.toString())) {
			var match_ret = n.toString().match(/\d+\.\d(\d)/);
			if (match_ret[1] % 2 == 1) {
				return parseFloat(n).toFixed(2);
			} else {
				return match_ret[0];
			}
		} else {
			return parseFloat(n).toFixed(2);
		}
	}

} );
