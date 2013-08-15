$(function(){
	//判断姓名是中文
	$('input[name=real_name]').blur(function(){
		values=$(this).val()										 
		var repost= /^[\u4e00-\u9fa5]{2,4}$/;
		ok=repost.test(values);
		if(ok){
			$('#real_name_txt').html('');	
		}else{
			$('#real_name_txt').html('请输入正确的姓名');
			return false;
			}
	})
	
	$('input[name=identity_card]').blur(function(){
		values=$(this).val()										 
		var repost= /^[A-Za-z0-9]{15}$|^[0-9]{18}$/;
		ok=repost.test(values);
		if(ok){
			$('#identity_card_txt').html('');	
		}else{
			$('#identity_card_txt').html('请输入正确的省份证号码');	
			return false;
			}
	})
	
	$('.yz_sfz').click(function(){
		values=$('input[name=real_name]').val()								
		var repost= /^[\u4e00-\u9fa5]{2,4}$/;
		ok=repost.test(values);
		if(ok){
			$('#real_name_txt').html('');	
		}else{
			$('#real_name_txt').html('请输入正确的姓名');
			return false;
		}
		
		
		hm=$('input[name=identity_card]').val()										 
		var lh= /^[A-Za-z0-9]{15}$|^[0-9]{18}$/;
		oks=lh.test(hm);
		if(oks){
			$('#identity_card_txt').html('');	
		}else{
			$('#identity_card_txt').html('请输入正确的省份证号码');	
			return false;
		}
		
		//确认资料
		$('.paly_pop_ok').show();
		$('.tips_text span').eq(0).html(values);
		$('.tips_text span').eq(1).html(hm);
		return false;
 	})
	//返回修改  与关闭 对话框
	$('.fhxgai,.close').click(function(){
		$('.paly_pop_ok').hide();							   
    })
	//确认修改
	$('.qrxgai').click(function(){
		document.myname.submit(); 							   
    })
	
	
	$('input[name=money]').blur(function(){
		money=parseInt($(this).val());
		order=parseInt($('input[name=qian]').val());
		free_money=parseInt($('input[name=free_money]').val());
		
		var repost= /^[0-9]{1,10}$/;
		ok=repost.test(money);
		if(ok){
			$('#identity_card_txt').html('');	
		}else{
			$('#identity_card_txt').html('提取金额只能点写数字');	
			return false;
		}
		if(money>order){
			$('#identity_card_txt').html('提取金额不能大于当前可提现金额');
			return false;
		}
		if(money+free_money>order){
			if(order-free_money>0){
				numa=order-free_money;
				}else{
				numa=0;
				}
			$('#identity_card_txt').html('您最多可以提取'+numa+'元');
			return false;
		}
		
		
	})
	
	
	
	
	
	
	
		   
})