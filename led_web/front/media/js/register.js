 jQuery.validator.addMethod("passCheck", function(value, element) {      
     return this.optional(element) || /^[\x20-\x7f]+$/.test(value);      
  }, "密码请勿包含中文");  

 jQuery.validator.addMethod("stringMinLength", function(value, element, param) {
	   var length = value.length;
	   for ( var i = 0; i < value.length; i++) {
	    if (value.charCodeAt(i) > 127) {
	     length++;
	    }
	   }
	   return this.optional(element) || (length >= param);
	  }, $.validator.format("用户名长度至少应该为{0}个字符!"));
 jQuery.validator.addMethod("stringMaxLength", function(value, element, param) {
	   var length = value.length;
	   for ( var i = 0; i < value.length; i++) {
	    if (value.charCodeAt(i) > 127) {
	     length++;
	    }
	   }
	   return this.optional(element) || (length <= param);
	  }, $.validator.format("用户名长度请不要超过{0}个字符!"));
 jQuery.validator.addMethod("string", function(value, element) {
	   return this.optional(element) || /^[\u0391-\uFFE5\w]+$/.test(value);
	  }, "用户名不允许包含特殊符号!");
 
$(document).ready(function(){
    $("#register_form").validate({
        errorClass: 'register_error',
		success: function(label) { 
			label.html("").removeClass("register_error").addClass("register_ok"); 
		},
        errorElement: "div",
        rules: {
		   focusCleanup: true,
           lastname:{
			  required: true,
			  //maxlength:16,
			  //minlength:4,
			  string:true,
			  stringMinLength:4,
			  stringMaxLength:16,
			  remote:'/user/ajax_checkname/'+$('#lastname').val()
		   },
		   email:{
			  required: true, 
			  email:true
		   },
		   password:{
			  required: true,   
			  maxlength:15,
			  minlength:6,
			  passCheck:true
		   },
		   password_confirm:{
			  required: true, 
			  equalTo:"#password"
		   },
		   secode:{
			   required: true,
			   remote:'/user/ajax_checkrancode/'+$('#secode').val()  
		   }
		   
		  
        },
        messages: {
			lastname:{
			  required:"请输入用户名！",
			  maxlength:'对不起，用户名长度请不要超过16个字符！',
			  minlength:'对不起，用户名长度至少应该为4个字符！',
			  remote:'用户名已存在，请重新输入！'
			},
			email:{
			  required:"请添写邮箱！",
			  email:"对不起，请输入正确邮箱地址！"
			},
			password:{
			  required:'请输入密码！',   
			  maxlength:'您输入的密码超过15位，请换个密码',
			  minlength:'您输入的密码不足6位，请重新输入'
		   },
		   password_confirm:{
			  required:"请输入确认密码！", 
			  equalTo:"您两次输入的密码不一致，请重新输入！"
		   },
		   secode:{
			   required:"请输入验证码！",
			   remote:"验证码不正确，请重新输入"  
		   }    
        },
        errorPlacement: function(error, element){
            msg = element.parent().next();msg.html('');error.appendTo(msg);
        }
    });
});