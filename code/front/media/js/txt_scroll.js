/**
	参数：
		_wra：元素Class(格式：$('ul.ad_txt1')，其中ad_txt1就是class名)
		_int：滚动周期(单位毫秒[ms])
		_spe：滚动速度(单位毫秒[ms])
	调用：
		(例:<script type="text/javascript">var _wra = $('ul.ad_txt2');txt_sroll(_wra,2000,800);</script>)
*/
function txt_sroll(_wra,_int,_spe){
	var _wrap = _wra, _moving;
	var _int = (_int == null) ? 3000 : _int;
	var _spe = (_spe == null) ? 800 : _spe;
	_wrap.hover(function(){clearInterval(_moving);},
		function(){
			_moving = setInterval(function(){
				var _field = _wrap.find('li:first'),_h = _field.height();
				_field.animate({marginTop:-_h+'px'},_spe,function(){_field.css('marginTop',0).appendTo(_wrap);});
			},_int);
		}
	).trigger('mouseleave');
}