var Wi = [ 7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2, 1 ];// 加权因子  
var ValideCode = [ 1, 0, 10, 9, 8, 7, 6, 5, 4, 3, 2 ];// 身份证验证位值.10代表X  

function IdCardValidate(idCard) {  
    
    //idCard = trim(idCard.replace(/ /g, ""));  
   
   if (idCard.length == 15) {  
        return isValidityBrithBy15IdCard(idCard);  
    } else if (idCard.length == 18) { 

        var a_idCard = idCard.split("");// 得到身份证数组 
        if(isValidityBrithBy18IdCard(idCard)&&isTruidateCodeBy18IdCard(a_idCard)){  
            return true;  
        }else {  
            return false;  
        }  
    } else {  
        return false;  
    }  
}  
 
function isTruidateCodeBy18IdCard(a_idCard) {  
    var sum = 0; // 声明加权求和变量  
    
    if (a_idCard[17].toLowerCase() == 'x') {  
        a_idCard[17] = 10;// 将最后位为x的验证码替换为10方便后续操作  
    }  

    for ( var i = 0; i < 17; i++) {  
        sum += Wi[i] * a_idCard[i];// 加权求和  
    }  
 
    valCodePosition = sum % 11;// 得到验证码所位置  
    if (a_idCard[17] == ValideCode[valCodePosition]) {  

        return true;  
    } else {  
    
        return false;  
    }  
}  
 
function maleOrFemalByIdCard(idCard){  
    idCard = trim(idCard.replace(/ /g, ""));// 对身份证号码做处理。包括字符间有空格。  
    if(idCard.length==15){  
        if(idCard.substring(14,15)%2==0){  
            return 'female';  
        }else{  
            return 'male';  
        }  
    }else if(idCard.length ==18){  
        if(idCard.substring(14,17)%2==0){  
            return 'female';  
        }else{  
            return 'male';  
        }  
    }else{  
        return null;  
    }  
//  可对传入字符直接当作数组来处理  
// if(idCard.length==15){  
// alert(idCard[13]);  
// if(idCard[13]%2==0){  
// return 'female';  
// }else{  
// return 'male';  
// }  
// }else if(idCard.length==18){  
// alert(idCard[16]);  
// if(idCard[16]%2==0){  
// return 'female';  
// }else{  
// return 'male';  
// }  
// }else{  
// return null;  
// }  
}  
  
function isValidityBrithBy18IdCard(idCard18){  
    var year =  idCard18.substring(6,10);  
    var month = idCard18.substring(10,12);  
    var day = idCard18.substring(12,14);  
   
    var temp_date = new Date(year,parseFloat(month)-1,parseFloat(day));  
    
    // 这里用getFullYear()获取年份，避免千年虫问题  
    if(temp_date.getFullYear()!=parseFloat(year)  
          ||temp_date.getMonth()!=parseFloat(month)-1  
          ||temp_date.getDate()!=parseFloat(day)){  

            return false;  
    }else{  

        return true;  
    }  
}  
   
  function isValidityBrithBy15IdCard(idCard15){  
      var year =  idCard15.substring(6,8);  
      var month = idCard15.substring(8,10);  
      var day = idCard15.substring(10,12);  
      var temp_date = new Date(year,parseFloat(month)-1,parseFloat(day));  
      // 对于老身份证中的你年龄则不需考虑千年虫问题而使用getYear()方法  
      if(temp_date.getYear()!=parseFloat(year)  
              ||temp_date.getMonth()!=parseFloat(month)-1  
              ||temp_date.getDate()!=parseFloat(day)){  
                return false;  
        }else{  
            return true;  
        }  
  }  
 
  function getAttByIdCard(val,att)
  {
    var birthdayValue;
    var sexId;
    var sexText;
    var age;

    if (15 == val.length){ //15位身份证号码
        birthdayValue = val.charAt(6) + val.charAt(7);
        if (parseInt(birthdayValue) < 10) {
            birthdayValue = '20' + birthdayValue;
        }
        else {
            birthdayValue = '19' + birthdayValue;
        }
        birthdayValue = birthdayValue + '-' + val.charAt(8) + val.charAt(9) + '-' + val.charAt(10) + val.charAt(11);
        if (parseInt(val.charAt(14) / 2) * 2 != val.charAt(14)) {
            sexId = "1";
            sexText = "男";
        }
        else {
            sexId = "2";
            sexText = "女";
        }
    }
    if (18 == val.length) { //18位身份证号码
        birthdayValue = val.charAt(6) + val.charAt(7) + val.charAt(8) + val.charAt(9) + '-' + val.charAt(10) + val.charAt(11) + '-' + val.charAt(12) + val.charAt(13);
        if (parseInt(val.charAt(16) / 2) * 2 != val.charAt(16)) {
            sexId = "1";
            sexText = "男";
        }
        else {
            sexId = "2";
            sexText = "女";
        }
    }
     //年龄
    var dt1 = new Date(birthdayValue.replace("-", "/"));
    var dt2 = new Date();
    var age = dt2.getFullYear() - dt1.getFullYear();
    var m = dt2.getMonth() - dt1.getMonth();
    if (m < 0)
        age--;
    //alert(birthdayValue+sexId+sexText+age);
    if (att=="SEX") return sexText;
    if (att=="DATE") return birthdayValue;
    if (att=="AGE") return age;
   

  }
