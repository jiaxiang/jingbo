var n=6000/100;
var timeId=null;
//���Ʒ���email��ť��ʱ��Σ���ֹ�û������ύ
function enableSendEmail(emailButton)
{
	var obj=Y.one('#'+emailButton);
	if (n>0)
	{		
		obj.value='�������� ('+n+')';
		obj.disabled=true;
	}else{
		obj.value='��������';
		obj.disabled=false;
		clearInterval(timeId);
		obj.disabled=false;
		obj.className="btn_Dblue_b";
	}
	n = n-1;
}


//ȫѡemail
function selallemail(v_check, oName)
{
	//ѡ������һ��ȫѡ��ť
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

//��ѡemail
function fanselemial(v_check, oName)
{
	//ѡ������һ����ѡ��ť
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
	//�ж��Ƿ�ȫѡ����
	checkAllBox ('email');
}

//�жϵ�ǰcheckbox�Ƿ�ȫ��ѡ��
//���������true������ȫ��ѡ��
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

//����checkbox��ѡ���¼�
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

//ѡ��textarea���е�һ��������
/*
@textareaid textarea���id
@string ��Ҫѡ�е�һ������
*/
function selectTextareaString(textareaid,string){ 
	if (!string) return false;
	var rng = textareaid.createTextRange(); 
	rng.findText(string);
	rng.select();
}

//���Ʒ�����ַ
function copyIt(id) {
	var o = fw.getId(id);
	if (document.all) {
		o.select();
		window.clipboardData.clearData();
		window.clipboardData.setData("text",o.value);
		alert('��ַ���Ƴɹ������������Ctrl+Vֱ��ճ����');
	} else {
		alert('�����������֧�ֽű�����,�볢���ֶ�����');
		o.select();
	}
}

//���email��ʽ�Ƿ���ȷ
function isEmail(_str)
{
   return /^[-a-zA-Z0-9_\.]+@([0-9A-Za-z][0-9A-Za-z-]+\.)+[A-Za-z]{2,5}$/.test(_str); 
}
//����Ƿ�������
function isChn(str){
      var reg = /^[\u4E00-\u9FA5]+$/;
      if(!reg.test(str)){
       return true;
      }
      return false;
}

//ajax����email,ֱ����дemail��ַ
function sendAjaxEmail (emailList)
{
	//����email����
	var emailCate = getEmailType ();
	Y.one("#sendEmail").disabled = true;
	var inverUrlArr = Y.one("#inverUrl").value.split('?');
	Y.one("#writeHiddenUrl").value = inverUrlArr[0] + '?'+ encodeURIComponent(inverUrlArr[1]);
	/*var dlg = new Y.lib.MaskLay();
	dlg.addClose();
	dlg.pop()*/	
	//TIP.alert({type:'loading', info:'���ڷ����ʼ�'});
	Y.postMsg('msg_pop', '���ڷ����ʼ�', false, true);
	//Y.postMsg('msg_pop', 'xxxxx', function(){
	//	alert(123456)
	//})
	var json = {
		type: 'post',
		url : "/pages/trade/main/send_invite_email.php?emailCate="+emailCate+"&action=sendEmail&"+Math.random(),
        data: Y.qForm(document.daoru),
		end: function(data){//�ɹ�
            if (data.error) {
                alert("����ʧ�ܣ�");
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
		//��email��ϵ���б�ҳ��
		//alert(s)
		sendEmailAlert (s)
			}
	xmlhttp.run();*/
}
//����email��ʾ
function sendEmailAlert (result)
{
	Y.one("#sendEmail").disabled = true;
	if(result=="1")
	{
		Y.postMsg('msg_pop', '���������ʼ��ɹ���ף�����ˣ�', false, true);
		//TIP.alert({type:'emailok', info:'���������ʼ��ɹ���ף�����ˣ�'});
	}else{
		Y.postMsg('msg_pop', '��������æ�����Ժ�����', false);
		//TIP.alert({type:'alert', info:'��������æ�����Ժ�����'});
	}
	timeId=setInterval("enableSendEmail('sendEmail');",1000);
}

//ת�����ĵģ���ΪӢ��״̬
function ReplaceAll(str, sptr, sptr1)
{
	while (str.indexOf(sptr) >= 0)
	{
	   str = str.replace(sptr, sptr1);
	}
	return str;
}

//��ȡ����email���ͣ�����2���Ϲ�1��
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
	//��2��div��logoͼƬ
	var imgSrc = fw.getId('emailLogo').src;
	var imgSrcArr = imgSrc.split('logo_');
	newImg = imgSrcArr[0] + 'logo_' + newImgSrc + '.gif';
	fw.getId('emailLogo').src = newImg;
	//����������
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
	//�ж��Ƿ���msn
	var emailType = fw.dom.getName('emailType');
	var emailTypeNum = emailType.length;
	if(account=='')
	{
		alert('���������������ַ!');
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
						alert('���������email��ַ����ȷ!');
						fw.getId('account').focus();
						return false;
					}
				}else{
					//�����յ����丶ֵ
					var postoffice = changeEmailByType (type);
				}
			}
		}
	}
	if(passwd=='')
	{
		alert('������������������!');
		fw.getId('passwd').focus();
		return false;
	}
	fw.getId('email1').style.display = 'none';
	fw.getId('email2').style.display = 'none';
	fw.getId('email3').style.display = '';
	fw.getId("loadFriend").disabled = true;
	fw.getId('passwd2').value = passwd;
	fw.getId('emailList').innerHTML = '&nbsp;���ڵ���������ϵ���б����Ժ�....';
	//ajax��ȡ�����б�
	//var xmlhttp = new fw.ajax.request(document.daoru);
	if(type!='immsn')  //��msn���email
	{
		/*xmlhttp.url = "/pages/trade/main/get_email_contect.php?account="+account+"&passwd="+passwd+"&postoffice="+postoffice+"&"+Math.random();
		xmlhttp.callBack = function(s){
			//��email��ϵ���б�ҳ��
			//alert(s)
			bangEmailHtml (s)
		}
		xmlhttp.run();*/
		
		var json = {
			method: 'post',
			url : "/pages/trade/main/get_email_contect.php?account="+account+"&postoffice="+postoffice+"&"+Math.random(),
			form : document.daoru,
			onsuccess: function(vale){//�ɹ�
			  bangEmailHtml (vale);
			 },
			onfail : function (){
				alert("����ʧ�ܣ�");
			}	
		};
		fw.ajax.request(json);
		fw.getId('passwd2').value = '';
	}else{   //msn�ĵ����б�
		/*
		xmlhttp.url = "/pages/trade/main/get_email_msn.php?account="+account+"&passwd="+passwd+"&"+Math.random();
		xmlhttp.callBack = function(s){
			//��email��ϵ���б�ҳ��
			bangEmailHtmlMsn (s)
		}
		xmlhttp.run();*/
		var json = {
			method: 'post',
			url : "/pages/trade/main/get_email_msn.php?account="+account+"&"+Math.random(),
			form : document.daoru,
			onsuccess: function(vale){//�ɹ�
			  bangEmailHtmlMsn (vale);
			 },
			onfail : function (){
				alert("����ʧ�ܣ�");
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
		var emailTitle = '������������֧���ҵķ���';
	}else{
		var emailTitle = '������������������Ϲ��ķ���';
	}
	if(username == '')
	{
		alert('��������������!');
		Y.one('#username').focus();
		return false;
	}
	if(emailContent == '')
	{
		alert('email�����ݲ���Ϊ�գ�');
		Y.one('#emailContent').focus();
		return false;
	}
	Y.postMsg('msg_pop', username+'��<br/>'+emailTitle+'��<br/>'+emailContent, false);
	//TIP.alert({type:'emailContent',invertUrl:invertUrl,emailContent:emailContent,username:username,emailTitle:emailTitle});
}

function sendEmailSuc ()
{
	var allEmail = Y.one('#writeEmail').value; 
	//�����û������email
	allEmail = allEmail.trim();
	allEmail = ReplaceAll(allEmail,"\n",";");
	allEmail = ReplaceAll(allEmail,"��",";");
	
	//alert(allEmail);
	//fw.getId('lastWriteEmail').value = allEmail;
	var emailContent = (Y.one('#emailContent').value).trim();
	var username = (Y.one('#username').value).trim();
	if(allEmail=='')
	{
		alert('��������Ҫ���ͺ��ѵ�email��ַ');
		Y.one('#writeEmail').focus();
		return false;
	}else{
		if(!isChn(allEmail))
		{
			alert('���������email��ַ�а����Ƿ��ַ�');
			return false;
		}
	}
	if(emailContent == '')
	{
		alert('email�����ݲ���Ϊ�գ�');
		Y.one('#emailContent').focus();
		return false;
	}
	if(username == '')
	{
		alert('��������������!');
		Y.one('#username').focus();
		return false;
	}
	
	var allEmailArr = allEmail.split(';');
	var emailNum = allEmailArr.length;
	if(emailNum>50)
	{
		alert('����email�����Գ���50��');
		return false;
	}
	var writeEmail = Y.one('#writeEmail');
	for(var i =0 ;i<emailNum; i++)
	{
		if(allEmailArr[i]!='')
		{
			if(!isEmail(allEmailArr[i]))
			{
				alert('���������email��ַ:\"'+allEmailArr[i]+'\"����ȷ');
				selectTextareaString(writeEmail,allEmailArr[i]);
				return false;
			}
		}
	}
	//����email
	//���зǷ��ж϶�ͨ��������email
	sendAjaxEmail (allEmail);
}

//ת��email����
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

//�󶨷��ص�THML����
function bangEmailHtml (s)
{
	var element=fw.getId("emailList");
	//alert(s)
	if(s==0 && s!='error')
	{
		element.innerHTML = 'ϵͳ��æ�����Ժ�����';
	}else if(s=='error3'){
		element.innerHTML = '�����������ƻ����������';
	}else if(s=='empty'){
		element.innerHTML = '����������ϵ���б�Ϊ��';
	}else{
		element.innerHTML = s;
		fw.getId("totalEmailNum").innerHTML = fw.dom.getName('email').length;
		fw.getId("loadFriend").disabled = false;
	}
}

//�󶨷���MSN��THML����
function bangEmailHtmlMsn (s)
{
	var element=fw.getId("emailList");
	if(!s)
	{
		element.innerHTML = '�����������ƻ���������� ����������ϵ���б�Ϊ��';
	}else if(s=='empty'){
		element.innerHTML = '����������ϵ���б�Ϊ��';
	}else{
		element.innerHTML = s;
		fw.getId("totalEmailNum").innerHTML = fw.dom.getName('email').length;
		fw.getId("loadFriend").disabled = false;
	}
}

//������Ѳ���
function loadEmailList ()
{
	//ͳ���û�ѡ���email�����Ƿ񳬹�50
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
		alert('������ѡ��һ���������䣡');
		return false;
	}
	fw.getId('writeEmail').value = fw.getId('writeEmail').value.substring(0,fw.getId('writeEmail').value.length-1);
	TIP.close();
	var newImgSrc = fw.getId('emailTypeIcon').value;
	fw.getId('tips_msg').style.display = '';
	showEmailIcon (newImgSrc);
}

//תͼ��
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

//���ͼ��ѡ�е�ѡ��
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

//��תҳ��
function jumpPage ()
{
	var page = fw.getId('inverUrl').value;
	location.href = page;
}