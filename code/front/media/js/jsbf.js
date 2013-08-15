/**
 * 
 */
$(document).ready(function () {
	init_sound();
	init_open();
	auto_run();
});
function runEffect() {
	var selectedEffect = 'bounce';
	var options = {};
	if ( selectedEffect === "scale" ) {
		options = { percent: 100 };
	} else if ( selectedEffect === "size" ) {
		options = { to: { width: 280, height: 185 } };
	}
	$( "#effect" ).removeAttr( "style" ).show( selectedEffect, options, 500, callback() );
};
function callback() {
	setTimeout(function() {
		$( "#effect:visible" ).removeAttr( "style" ).fadeOut();
	}, 1000 );
};
$( "#button" ).click(function() {
	runEffect();
	return false;
});
$( "#effect" ).hide();
function showEvent(match_id) {
	$.ajax({url: '/jsbf/showEventByAjax', type:'POST', data:{ match_id:match_id }, dataType:'json', success:function(j) {
		var title = '比赛事件';
		var content = '';
		var rand_num = Math.round(Math.random()*10000);
		//alert(rand_num);
		jl = j.length;
		if (jl > 0) {
			for(i = 0; i < jl; i++) {
				var home_or_away = j[i].home_or_away;
				var player_name = j[i].player_name;
				var action = j[i].match_event_type;
				var time = j[i].match_event_time;
				content += home_or_away+'的'+player_name+'在'+time+'分钟'+action+'<br />';
			}
			if (content == '') {
				content = '暂无数据';
			}
		}
		else {
			content = '暂无数据';
		}
		//creat_window(title, content);
		creat_dialog(title, content, rand_num, 'center', 0);
	}});
}
function showJSBF() {
	$.ajax({url: '/jsbf/showByAjax', type:'POST', data:{  }, dataType:'json', success:function(j) {
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
	t = 1*60*1000;
	//t = 30*1000;
	setInterval(function(){showJSBF();}, t);
}
function goal_sound() {
	soundNotice=document.createElement('embed');
	soundNotice.setAttribute('src','../media/images/goal1.swf');
	soundNotice.setAttribute('hidden','true');
	soundNotice.setAttribute('loop','false');
	document.getElementById('main').appendChild(soundNotice);
}
function init_sound() {
	r = $.cookie('sound');
	if (r == 'Off') {
		$('#sound_op').prop('checked', false);
	}
	else {
		$('#sound_op').prop('checked', true);
	}
}
function set_sound() {
	r = $('#sound_op').prop('checked');
	if (r == true) {
		$.cookie('sound', 'On');
	}
	else {
		$.cookie('sound', 'Off');
	}
}
function is_sound() {
	r = $.cookie('sound');
	if (r == 'Off') {
		return false;
	}
	else {
		return true;
	}
}
function init_open() {
	r = $.cookie('open');
	if (r == 'Off') {
		$('#open_op').prop('checked', false);
	}
	else {
		$('#open_op').prop('checked', true);
	}
}
function set_open() {
	r = $('#open_op').prop('checked');
	if (r == true) {
		$.cookie('open', 'On');
	}
	else {
		$.cookie('open', 'Off');
	}
}
function is_open() {
	r = $.cookie('open');
	if (r == 'Off') {
		return false;
	}
	else {
		return true;
	}
}
function creat_window(title, content) {
	var s = '<div id="effect" class="ui-widget-content ui-corner-all" style="display: none"><h3 class="ui-widget-header ui-corner-all">'+title+'</h3><p>'+content+'</p></div>';
	$('#toggler1').html(s);
	runEffect();
	return false;
}
function creat_dialog(title, content, rand_num, pos, autoclose) {
	var s = '<div id="dialog'+rand_num+'" title="'+title+'"><p align="center" font-size="14pt">'+content+'</p></div>';
	$('#toggler').html(s);
	$( "#dialog"+rand_num ).dialog({
		autoOpen: false,
		show: "slide",
		hide: "fade",
		resizable : "false",
		position : pos,
		title : title
	});
	$( "#dialog"+rand_num ).dialog( "open" );
	if (autoclose == 1) {
		setTimeout(function() {
			$( "#dialog"+rand_num ).dialog( "close" );
		}, 3000 );
	}
	//return false;
}