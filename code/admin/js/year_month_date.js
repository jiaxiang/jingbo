var months=new Array("一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月");var daysInMonth=new Array(31,28,31,30,31,30,31,31,30,31,30,31);var days=new Array("日","一","二","三","四","五","六");var today;document.writeln("<div id='Calendar' style='position:absolute; z-index:1; visibility: hidden; filter:\"progid:DXImageTransform.Microsoft.Shadow(direction=135,color=#999999,strength=3)\"'></div>");function getDays(b,a){if(1==b){return((0==a%4)&&(0!=(a%100)))||(0==a%400)?29:28}else{return daysInMonth[b]}}function getToday(){this.now=new Date();this.year=this.now.getFullYear();this.month=this.now.getMonth();this.day=this.now.getDate()}function getStringDay(a){var a=a.split("-");this.now=new Date(parseFloat(a[0]),parseFloat(a[1])-1,parseFloat(a[2]));this.year=this.now.getFullYear();this.month=this.now.getMonth();this.day=this.now.getDate()}function newCalendar(){var a=parseInt(document.getElementById("Year").value);var f=new Date(a,document.getElementById("Month").selectedIndex,1);var g=-1;var e=f.getDay();var j=0;if((today.year==f.getFullYear())&&(today.month==f.getMonth())){g=today.day}var b=document.getElementById("calendar2");var d=getDays(f.getMonth(),f.getFullYear());for(var i=1;i<b.rows.length;i++){for(var c=0;c<b.rows[i].cells.length;c++){var h=b.rows[i].cells[c];if((c==e)&&(0==j)){j=1}if(g==j){h.style.background="#6699CC";h.style.color="#FFFFFF"}else{if(c==6){h.style.color="green"}else{if(c==0){h.style.color="red"}}}if((j>0)&&(j<=d)){h.innerHTML=j;j++}else{h.innerHTML=""}}}}function GetDate(event,InputBox,flag){var sDate;var isIE=document.all&&window.external;if(isIE){if(event.srcElement.tagName=="TD"){if(event.srcElement.innerHTML!=""){var month=document.getElementById("Month").value;if(month.length==1){month="0"+month}var day=event.srcElement.innerText;if(day.length==1){day="0"+day}sDate=document.getElementById("Year").value+"-"+month+"-"+day;eval("document.getElementById('"+InputBox+"')").value=sDate}}}else{if(event.target.tagName=="TD"){if(event.target.innerHTML!=""){var month=document.getElementById("Month").value;if(month.length==1){month="0"+month}var day=event.target.innerHTML;if(day.length==1){day="0"+day}sDate=document.getElementById("Year").value+"-"+month+"-"+day;eval("document.getElementById('"+InputBox+"')").value=sDate}}}if(flag==1){HiddenCalendar()}}function HiddenCalendar(){document.getElementById("Calendar").style.visibility="hidden"}function ShowCalendar(InputBox,xoff,yoff,flag){if(document.getElementById("Calendar").style.visibility=="visible"){HiddenCalendar()}else{var x,y,intLoop,intWeeks,intDays;var DivContent;var year,month,day;var o=eval("document.getElementById('"+InputBox+"')");var thisyear;thisyear=new getToday();thisyear=thisyear.year;today=o.value;if(isDate(today)){today=new getStringDay(today)}else{today=new getToday()}x=o.offsetLeft;y=o.offsetTop;while(o=o.offsetParent){x+=o.offsetLeft;y+=o.offsetTop}document.getElementById("Calendar").style.left=x+xoff+"px";document.getElementById("Calendar").style.top=y+yoff+"px";document.getElementById("Calendar").style.visibility="visible";DivContent="<table border='0' cellspacing='0' style='border:1px solid #0066FF; background-color:#EDF2FC'>";DivContent+="<tr>";DivContent+="<td style='border-bottom:1px solid #0066FF; background-color:#C7D8FA'>";DivContent+="<select name='Year' id='Year' onChange='newCalendar()' style='font-family:Verdana; font-size:12px'>";for(intLoop=(thisyear-1);intLoop<(thisyear+2);intLoop++){DivContent+="<option value= "+intLoop+" "+(today.year==intLoop?"Selected":"")+">"+intLoop+"</option>"}DivContent+="</select>";DivContent+="<select name='Month' id='Month' onChange='newCalendar()' style='font-family:Verdana; font-size:12px'>";for(intLoop=0;intLoop<months.length;intLoop++){DivContent+="<option value= "+(intLoop+1)+" "+(today.month==intLoop?"Selected":"")+">"+months[intLoop]+"</option>"}DivContent+="</select>";DivContent+="</td>";DivContent+="<td style='border-bottom:1px solid #0066FF; background-color:#C7D8FA;  font-weight:bold; font-family:Wingdings 2,Wingdings,Webdings; font-size: 16px; padding-top:2px; color:#4477FF; cursor:hand' align='center' title=' 关闭' onClick='javascript:HiddenCalendar()'>S</td>";DivContent+="</tr>";DivContent+="<tr><td align='center' colspan='2'>";DivContent+="<table id='calendar2' border='0' width='100%'>";DivContent+="<tr>";for(intLoop=0;intLoop<days.length;intLoop++){DivContent+="<td align='center' style='font-size:12px'>"+days[intLoop]+"</td>"}DivContent+="</tr>";for(intWeeks=0;intWeeks<6;intWeeks++){DivContent+="<tr>";for(intDays=0;intDays<days.length;intDays++){DivContent+="<td onClick='GetDate(event,\""+InputBox+'",'+flag+")' style='cursor:hand; border-right:1px solid #BBBBBB; border-bottom:1px solid #BBBBBB; color:#215DC6; font-family:Verdana; font-size:12px' align='center'></td>"}DivContent+="</tr>"}DivContent+="</table></td></tr></table>";document.getElementById("Calendar").innerHTML=DivContent;newCalendar()}}function isDate(c){var f=/^(\d{4})(\-)(\d{1,2})(\-)(\d{1,2})$/;var e=c.match(f);if(e==null){return false}var g=e[3];var b=e[5];var d=e[1];if(g<1||g>12){return false}if(b<1||b>31){return false}if((g==4||g==6||g==9||g==11)&&b==31){return false}if(g==2){var a=(d%4==0&&(d%100!=0||d%400==0));if(b>29||(b==29&&!a)){return false}}return true};