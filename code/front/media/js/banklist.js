function show_bank(){
	$.ajax({type: 'post',url: "/user/showByAjax",cache: false,data: {},dataType: 'json',   
        success: function(j){
		jl=j.length;
		for(i = 0; i < jl; i++) {
			$('<option value='+j[i]+'>'+j[i]+'</option>').appendTo("#province")//添加下拉框的option
//			alert(j[i]);
		}
		}
	    }); 
}
function getCity(province){
	if(province!=""){
		$.ajax({type: 'post',url: "/user/showByAjax",cache: false,data: {pro:province},dataType: 'json',   
        success: function(j){
				$("#city").empty();//清空下拉框//$("#select").html('');
				$("#bank_name").empty();
				$("#bank_found").empty();
				$('<option value="">请选择城市</option>').appendTo("#city");//添加下拉框的option
				$('<option value="">-----</option>').appendTo("#bank_name");
				$('<option value="">-----</option>').appendTo("#bank_found");
				jl=j.length;
				for(i = 0; i < jl; i++) {
					$('<option value='+j[i]+'>'+j[i]+'</option>').appendTo("#city")//添加下拉框的option
				}
		}
	    }); 
}
	if(province==""){
		$("#city").empty();//清空下拉框//$("#select").html('');
		$("#bank_name").empty();
		$("#bank_found").empty();
		$('<option value="">-----</option>').appendTo("#city");//添加下拉框的option
		$('<option value="">-----</option>').appendTo("#bank_name");
		$('<option value="">-----</option>').appendTo("#bank_found");
	}
}
function getBank(bank){
	if(bank!=""){
		$.ajax({type: 'post',url: "/user/showByAjax",cache: false,data: {bank:bank},dataType: 'json',   
	        success: function(j){
				$("#bank_name").empty();//清空下拉框//$("#select").html('');
				$("#bank_found").empty();
				$('<option value="">请选择银行</option>').appendTo("#bank_name")//添加下拉框的option
				$('<option value="">-----</option>').appendTo("#bank_found")
				jl=j.length;
				for(i = 0; i < jl; i++) {
					$('<option value='+j[i]['id']+'>'+j[i]['name']+'</option>').appendTo("#bank_name")//添加下拉框的option
				}
		}
	    }); 
	}
	if(bank==""){
		$("#bank_name").empty();
		$("#bank_found").empty();
		$('<option value="">-----</option>').appendTo("#bank_name");
		$('<option value="">-----</option>').appendTo("#bank_found");
	}
}
function getBranch(Branch,city){
	if(Branch!=""&&city!=""){
		$.ajax({type: 'post',url: "/user/showByAjax",cache: false,data: {Branch:Branch,city:city},dataType: 'json',   
	        success: function(j){
				$("#bank_found").empty();//清空下拉框//$("#select").html(''); 
				$('<option value="">请选择支行</option>').appendTo("#bank_found")//添加下拉框的option
				jl=j.length;
				for(i = 0; i < jl; i++) {
					$('<option value='+j[i]+'>'+j[i]+'</option>').appendTo("#bank_found")//添加下拉框的option
				}
			}
	    }); 
	}
	if(Branch!=""||city!=""){
		$("#bank_found").empty();
		$('<option value="">-----</option>').appendTo("#bank_found");
	}
}
$(document).ready(function(){
	show_bank();
});

