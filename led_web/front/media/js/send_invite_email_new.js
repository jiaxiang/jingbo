var n=6000/100;
var timeId=null;
//控制发送email按钮的时间段，防止用户恶意提交
function enableSendEmail(emailButton)
{
	var obj=Y.one('#'+emailButton);
	if (n>0)
	{		
		obj.value='发送邀请 ('+n+')';
		obj.disabled=true;
	}else{
		obj.value='发送邀请';
		obj.disabled=false;
		clearInterval(timeId);
		obj.disabled=false;
		obj.className="btn_Dblue_b";
	}
	n = n-1;
}


//全选email
function selallemail(v_check, oName)
{
	//选择另外一个全选按钮
	var oNameObj = fw.dom.getId(oName);
	if(oNameObj.checked)
	{
		oNameObj.checked = 0;
	}else{
		oNameObj.checked = 1;
	}
	if ("undefined" != typeof(document.listform.email))
	{
		if ("undefined" != typeof(document.listform.email.length))
		{
			for (i=0; i<document.listform.email.length; i++)
			{
				document.listform.email[i].checked = v_check.checked;
			}
		}else
		{
			document.listform.email.checked = v_check.checked;
		}
	}
	//fw.dom.getId('fansel_1').checked = 0;
	//fw.dom.getId('fansel_2').checked = 0;
}

//反选email
function fanselemial(v_check, oName)
{
	//选择另外一个反选按钮
	var oNameObj = fw.dom.getId(oName);
	if(oNameObj.checked)
	{
		oNameObj.checked = 0;
	}else{
		oNameObj.checked = 1;
	}
	if ("undefined" != typeof(document.listform.email))
	{
		if ("undefined" != typeof(document.listform.email.length))
		{
			for (i=0; i<document.listform.email.length; i++)
			{
				if(document.listform.email[i].checked)
				{
					document.listform.email[i].checked = 0;
				}else{
					document.listform.email[i].checked = 1;
				}
			}
		}else
		{
			document.listform.email.checked = v_check.checked;
		}
	}
	//判断是否全选中了
	checkAllBox ('email');
}

//判断当前checkbox是否全部选中
//如果返回是true，就是全部选中
function isCheckAll (oName)
{
	var oNameObj = fw.dom.getName(oName);
	for(var i = 0;i<oNameObj.length;i++)
	{
		if(!oNameObj[i].checked)
		{
			return false;
		}
	}
	return true;
}

//单个checkbox，选择事件
function checkAllBox (oName)
{
	if(isCheckAll (oName))
	{
		fw.dom.getId('allsel_1').checked = 1;
		fw.dom.getId('allsel_2').checked = 1;
	}else{
		fw.dom.getId('allsel_1').checked = 0;
		fw.dom.getId('allsel_2').checked = 0;
	}
}

//选中textarea框中的一部分文字
/*
@textareaid textarea框的id
@string 需要选中的一段文字
*/
function selectTextareaString(textareaid,string){ 
	if (!string) return false;
	var rng = textareaid.createTextRange(); 
	rng.findText(string);
	rng.select();
}

//复制方案地址
function copyIt(id) {
	var o = fw.getId(id);
	if (document.all) {
		o.select();
		window.clipboardData.clearData();
		window.clipboardData.setData("text",o.value);
		alert('网址复制成功！你可以利用Ctrl+V直接粘贴。');
	} else {
		alert('您的浏览器不支持脚本复制,请尝试手动复制');
		o.select();
	}
}

//检查email格式是否正确
function isEmail(_str)
{
   return /^[-a-zA-Z0-9_\.]+@([0-9A-Za-z][0-9A-Za-z-]+\.)+[A-Za-z]{2,5}$/.test(_str); 
}
//检查是否是中文
function isChn(str){
      var reg = /^[\u4E00-\u9FA5]+$/;
      if(!reg.test(str)){
       return true;
      }
      return false;
}

//ajax发送email,直接填写email地址
function sendAjaxEmail (emailList)
{
	//发送email类型
	var emailCate = getEmailType ();
	Y.one("#sendEmail").disabled = true;
	var inverUrlArr = Y.one("#inverUrl").value.split('?');
	Y.one("#writeHiddenUrl").value = inverUrlArr[0] + '?'+ encodeURIComponent(inverUrlArr[1]);
	/*var dlg = new Y.lib.MaskLay();
	dlg.addClose();
	dlg.pop()*/	
	//TIP.alert({type:'loading', info:'正在发送邮件'});
	Y.postMsg('msg_pop', '正在发送邮件', false, true);
	//Y.postMsg('msg_pop', 'xxxxx', function(){
	//	alert(123456)
	//})
	var json = {
		type: 'post',
		url : "/pages/trade/main/send_invite_email.php?emailCate="+emailCate+"&action=sendEmail&"+Math.random(),
        data: Y.qForm(document.daoru),
		end: function(data){//成功
            if (data.error) {
                alert("操作失败！");
            }else{
                sendEmailAlert (data);
            }
		 }
	};
	Y.ajax(json);	
	/*
	var xmlhttp = new fw.ajax.request(document.daoru);
	xmlhttp.url = "/pages/trade/main/send_invite_email.php?emailCate="+emailCate+"&action=sendEmail&"+Math.random();
	xmlhttp.callBack = function(s){
		//绑定email联系人列表到页面
		//alert(s)
		sendEmailAlert (s)
			}
	xmlhttp.run();*/
}
//发送email提示
function sendEmailAlert (result)
{
	Y.one("#sendEmail").disabled = true;
	if(result=="1")
	{
		Y.postMsg('msg_pop', '发送邀请邮件成功！祝您好运！', false, true);
		//TIP.alert({type:'emailok', info:'发送邀请邮件成功！祝您好运！'});
	}else{
		Y.postMsg('msg_pop', '服务器正忙，请稍后再试', false);
		//TIP.alert({type:'alert', info:'服务器正忙，请稍后再试'});
	}
	timeId=setInterval("enableSendEmail('sendEmail');",1000);
}

//转换中文的；号为英文状态
function ReplaceAll(str, sptr, sptr1)
{
	while (str.indexOf(sptr) >= 0)
	{
	   str = str.replace(sptr, sptr1);
	}
	return str;
}

//获取发送email类型（发起2、认购1）
function getEmailType ()
{
	var emailCate = Y.one("#emailCate").value;
	return emailCate;
}

function showPageOne ()
{
	return;
	TIP.alert({type:'email_1'});
}

function showPageTwo ()
{
	var emailType = fw.dom.getName('emailType');
	var emailTypeNum = emailType.length;
	for(var i=0; i<emailTypeNum; i++)
	{
		if(emailType[i].checked)
		{
			var newImgSrc = emailType[i].value;
			fw.getId('emailTypeIcon').value = newImgSrc;
			if(changeEmailByType (newImgSrc))
			{
				fw.getId('account').className="ipt1";
				fw.getId('emailFont').innerHTML = '&nbsp;@' + changeEmailByType (newImgSrc);
			}else{
				fw.getId('account').className="ipt";
				fw.getId('emailFont').innerHTML = changeEmailByType (newImgSrc);
			}
			
		}
	}
	//第2个div换logo图片
	var imgSrc = fw.getId('emailLogo').src;
	var imgSrcArr = imgSrc.split('logo_');
	newImg = imgSrcArr[0] + 'logo_' + newImgSrc + '.gif';
	fw.getId('emailLogo').src = newImg;
	//把输入框清空
	fw.getId('account').value = '';
	fw.getId('passwd').value = '';
	fw.getId('email1').style.display = 'none';
	fw.getId('email2').style.display = '';
	fw.getId('email3').style.display = 'none';
	
	
}

function BackOne ()
{
	fw.getId('email1').style.display = '';
	fw.getId('email2').style.display = 'none';
	fw.getId('email3').style.display = 'none';
}

function BackTwo ()
{
	fw.getId('email1').style.display = 'none';
	fw.getId('email2').style.display = '';
	fw.getId('email3').style.display = 'none';
}

function loginEmail ()
{
	var account = fw.getId('account').value;
	var passwd = fw.getId('passwd').value;
	//判断是否是msn
	var emailType = fw.dom.getName('emailType');
	var emailTypeNum = emailType.length;
	if(account=='')
	{
		alert('请输入您的邮箱地址!');
		fw.getId('account').focus();
		return false;
	}else{
		for(var i=0; i<emailTypeNum; i++)
		{
			if(emailType[i].checked)
			{
				var type = emailType[i].value;
				if(emailType[i].value=='immsn')
				{
					if(!isEmail(account))
					{
						alert('您所输入的email地址不正确!');
						fw.getId('account').focus();
						return false;
					}
				}else{
					//给最终的邮箱付值
					var postoffice = changeEmailByType (type);
				}
			}
		}
	}
	if(passwd=='')
	{
		alert('请输入您的邮箱密码!');
		fw.getId('passwd').focus();
		return false;
	}
	fw.getId('email1').style.display = 'none';
	fw.getId('email2').style.display = 'none';
	fw.getId('email3').style.display = '';
	fw.getId("loadFriend").disabled = true;
	fw.getId('passwd2').value = passwd;
	fw.getId('emailList').innerHTML = '&nbsp;正在导入邮箱联系人列表，请稍后....';
	//ajax获取邮箱列表
	//var xmlhttp = new fw.ajax.request(document.daoru);
	if(type!='immsn')  //除msn外的email
	{
		/*xmlhttp.url = "/pages/trade/main/get_email_contect.php?account="+account+"&passwd="+passwd+"&postoffice="+postoffice+"&"+Math.random();
		xmlhttp.callBack = function(s){
			//绑定email联系人列表到页面
			//alert(s)
			bangEmailHtml (s)
		}
		xmlhttp.run();*/
		
		var json = {
			method: 'post',
			url : "/pages/trade/main/get_email_contect.php?account="+account+"&postoffice="+postoffice+"&"+Math.random(),
			form : document.daoru,
			onsuccess: function(vale){//成功
			  bangEmailHtml (vale);
			 },
			onfail : function (){
				alert("操作失败！");
			}	
		};
		fw.ajax.request(json);
		fw.getId('passwd2').value = '';
	}else{   //msn的导入列表
		/*
		xmlhttp.url = "/pages/trade/main/get_email_msn.php?account="+account+"&passwd="+passwd+"&"+Math.random();
		xmlhttp.callBack = function(s){
			//绑定email联系人列表到页面
			bangEmailHtmlMsn (s)
		}
		xmlhttp.run();*/
		var json = {
			method: 'post',
			url : "/pages/trade/main/get_email_msn.php?account="+account+"&"+Math.random(),
			form : document.daoru,
			onsuccess: function(vale){//成功
			  bangEmailHtmlMsn (vale);
			 },
			onfail : function (){
				alert("操作失败！");
			}	
		};
		fw.ajax.request(json);
		fw.getId('passwd2').value = '';
	}
	
}

function viewEmailContent (type)
{
	var invertUrl = Y.one('#inverUrl').value;
	var emailContent = (Y.one('#emailContent').value).trim();
	var username = (Y.one('#username').value).trim();
	if(type==1)
	{
		var emailTitle = '请点击以下链接支持我的方案';
	}else{
		var emailTitle = '请点击以下链接浏览我认购的方案';
	}
	if(username == '')
	{
		alert('请输入您的名字!');
		Y.one('#username').focus();
		return false;
	}
	if(emailContent == '')
	{
		alert('email的内容不能为空！');
		Y.one('#emailContent').focus();
		return false;
	}
	Y.postMsg('msg_pop', username+'：<br/>'+emailTitle+'：<br/>'+emailContent, false);
	//TIP.alert({type:'emailContent',invertUrl:invertUrl,emailContent:emailContent,username:username,emailTitle:emailTitle});
}

function sendEmailSuc ()
{
	var allEmail = Y.one('#writeEmail').value; 
	//处理用户输入的email
	allEmail = allEmail.trim();
	allEmail = ReplaceAll(allEmail,"\n",";");
	allEmail = ReplaceAll(allEmail,"；",";");
	
	//alert(allEmail);
	//fw.getId('lastWriteEmail').value = allEmail;
	var emailContent = (Y.one('#emailContent').value).trim();
	var username = (Y.one('#username').value).trim();
	if(allEmail=='')
	{
		alert('请输入您要发送好友的email地址');
		Y.one('#writeEmail').focus();
		return false;
	}else{
		if(!isChn(allEmail))
		{
			alert('您所输入的email地址中包含非法字符');
			return false;
		}
	}
	if(emailContent == '')
	{
		alert('email的内容不能为空！');
		Y.one('#emailContent').focus();
		return false;
	}
	if(username == '')
	{
		alert('请输入您的名字!');
		Y.one('#username').focus();
		return false;
	}
	
	var allEmailArr = allEmail.split(';');
	var emailNum = allEmailArr.length;
	if(emailNum>50)
	{
		alert('发送email不可以超过50封');
		return false;
	}
	var writeEmail = Y.one('#writeEmail');
	for(var i =0 ;i<emailNum; i++)
	{
		if(allEmailArr[i]!='')
		{
			if(!isEmail(allEmailArr[i]))
			{
				alert('您所输入的email地址:\"'+allEmailArr[i]+'\"不正确');
				selectTextareaString(writeEmail,allEmailArr[i]);
				return false;
			}
		}
	}
	//发送email
	//所有非法判断都通过，发送email
	sendAjaxEmail (allEmail);
}

//转换email函数
function changeEmailByType (type)
{
	var emailCom;
	switch(type)
    {
		case '126':
          emailCom  = '126.com';
        break;
		
		case '163':
          emailCom  = '163.com';
        break;
        
        case 'sina':
          emailCom  = 'sina.com';
        break;
        
        case 'sohu':
          emailCom  = 'sohu.com';
        break;
        
        case 'tom':
          emailCom  = 'tom.com';
        break;
        
        case 'gmail':
          emailCom  = 'gmail.com';
        break;
        
        case 'yahoo':
          emailCom  = 'yahoo.cn';
        break;
        
        case 'immsn':
          emailCom  = '';
        break;
        
        default:
           emailCom = '126.com';
       break;      
     }
     fw.getId('postoffice').value = emailCom;
	 return emailCom;
}

//绑定返回的THML代码
function bangEmailHtml (s)
{
	var element=fw.getId("emailList");
	//alert(s)
	if(s==0 && s!='error')
	{
		element.innerHTML = '系统繁忙，请稍后再试';
	}else if(s=='error3'){
		element.innerHTML = '您的邮箱名称或者密码错误';
	}else if(s=='empty'){
		element.innerHTML = '您的邮箱联系人列表为空';
	}else{
		element.innerHTML = s;
		fw.getId("totalEmailNum").innerHTML = fw.dom.getName('email').length;
		fw.getId("loadFriend").disabled = false;
	}
}

//绑定返回MSN的THML代码
function bangEmailHtmlMsn (s)
{
	var element=fw.getId("emailList");
	if(!s)
	{
		element.innerHTML = '您的邮箱名称或者密码错误 或者您的联系人列表为空';
	}else if(s=='empty'){
		element.innerHTML = '您的邮箱联系人列表为空';
	}else{
		element.innerHTML = s;
		fw.getId("totalEmailNum").innerHTML = fw.dom.getName('email').length;
		fw.getId("loadFriend").disabled = false;
	}
}

//导入好友操作
function loadEmailList ()
{
	//统计用户选择的email个数是否超过50
	var checkEmail = fw.dom.getName('email');
	var checkEmailNum = checkEmail.length;
	if(fw.getId('writeEmail').value!='')
	{
		fw.getId('writeEmail').value += ';'; 
	}
	var j=0;
	for(var i=0;i<checkEmailNum;i++)
	{
		if(checkEmail[i].checked)
		{
			j++;
			fw.getId('writeEmail').value += checkEmail[i].value+';';
		}
	}
	if(j==0)
	{
		alert('您至少选择一个好友邮箱！');
		return false;
	}
	fw.getId('writeEmail').value = fw.getId('writeEmail').value.substring(0,fw.getId('writeEmail').value.length-1);
	TIP.close();
	var newImgSrc = fw.getId('emailTypeIcon').value;
	fw.getId('tips_msg').style.display = '';
	showEmailIcon (newImgSrc);
}

//转图标
function showEmailIcon (email)
{
	var imgIconObj = fw.dom.getName('imgIcon');
	for(var i =0;i<imgIconObj.length;i++)
	{
		if(imgIconObj[i].id == email)
		{
			fw.getId(imgIconObj[i].id).style.display = '';
		}else{
			fw.getId(imgIconObj[i].id).style.display = 'none';
		}
	}
}

//点击图标选中单选框
function chanceRadioIcon (emailValue)
{
	var emailType = fw.dom.getName('emailType');
	var emailTypeNum = emailType.length;
	for(var i=0; i<emailTypeNum; i++)
	{
		if(emailType[i].value == emailValue)
		{
			emailType[i].checked = 1;
		}else{
			emailType[i].checked = 0;
		}
	}
}

//跳转页面
function jumpPage ()
{
	var page = fw.getId('inverUrl').value;
	location.href = page;
}