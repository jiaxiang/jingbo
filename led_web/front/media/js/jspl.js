/**
 * 
 */
function showOdds() {
	$.ajax({url: '/jspl/showByAjax', type:'POST', data:{  }, dataType:'json', success:function(j) {
		jl = j.length;
		if (jl > 0) {
			for(i = 0; i < jl; i++) {
				var last_home_score = $('#home_score_'+j[i].id).html();
				var last_away_score = $('#away_score_'+j[i].id).html();
				var now_home_score = j[i].home_score;
				var now_away_score = j[i].away_score;
				var rand_num = j[i].rand_num;
				var match_status = j[i].match_status;
				if (j[i].match_ing_gif != '') {
					var match_status = j[i].match_status + j[i].match_ing_gif;
					$('#home_score_'+j[i].id).css('color','#FF0000');
					$('#home_score_'+j[i].id).css('font-size','14px');
					$('#home_score_'+j[i].id).css('font-weight','bold');
					
					$('#away_score_'+j[i].id).css('color','#FF0000');
					$('#away_score_'+j[i].id).css('font-size','14px');
					$('#away_score_'+j[i].id).css('font-weight','bold');
				}
				$('#match_status_'+j[i].id).html(match_status);
				$('#match_status_'+j[i].id).css('color',j[i].match_status_color);
				$('#match_open_time_'+j[i].id).html(j[i].match_open_time);
				$('#sp_h_'+j[i].id).html(j[i].sp_h);
				$('#sp_d_'+j[i].id).html(j[i].sp_d);
				$('#sp_a_'+j[i].id).html(j[i].sp_a);
				
				if (last_home_score != null && now_home_score > last_home_score) {
					if (is_sound() == true) {
						goal_sound();
					}
					if (is_open() == true) {
						var title = j[i].home_name_chs+' 进球啦！！！';
						var content = j[i].home_name_chs+' <font color="red">'+now_home_score+'</font>：'+now_away_score+' '+j[i].away_name_chs;
						creat_dialog(title, content, rand_num, 'top', 1);
					}
				}
				$('#home_score_'+j[i].id).html(now_home_score);
				
				if (last_away_score != null && now_away_score > last_away_score) {
					if (is_sound() == true) {
						goal_sound();
					}
					if (is_open() == true) {
						var title = j[i].away_name_chs+' 进球啦！！！';
						var content = j[i].home_name_chs+' '+now_home_score+'：<font color="red">'+now_away_score+'</font> '+j[i].away_name_chs;
						creat_dialog(title, content, rand_num, 'top', 1);
					}
				}
				$('#away_score_'+j[i].id).html(now_away_score);
				$('#home_first_half_score_'+j[i].id).html(j[i].home_first_half_score);
				$('#away_first_half_score_'+j[i].id).html(j[i].away_first_half_score);
				if (j[i].home_yellow_card > 0) {
					$('#home_yellow_card_'+j[i].id).html('<span class="yellowcard">'+j[i].home_yellow_card+'</span>');
				}
				if (j[i].away_yellow_card > 0) {
					$('#away_yellow_card_'+j[i].id).html('<span class="yellowcard">'+j[i].away_yellow_card+'</span>');
				}
				if (j[i].home_red_card > 0) {
					$('#home_red_card_'+j[i].id).html('<span class="redcard">'+j[i].home_red_card+'</span>');
				}
				if (j[i].away_red_card > 0) {
					$('#away_red_card_'+j[i].id).html('<span class="redcard">'+j[i].away_red_card+'</span>');
				}
			}
		}
	}});
}
function auto_run() {
	t = 30*1000;
	setInterval(function(){showOdds();}, t);
}