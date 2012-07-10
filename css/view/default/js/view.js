/*@d1blog 2012-2012
 *@作者：陈先觉
 *@主页：www.phptogether.com 
 */

function check_commentform(dourl){
   var usrname=$("#usrname").val();
   var email=$("input[name='email']").val();
   var url=$("input[name='website']").val();
   var message=$("textarea[name='message']").val();
   if(!$.trim(message)){
     alert('留言不能为空！');
     $('#message').focus();
     return false;
   }else if($.trim(usrname).length>15){
	 alert('姓名不能超过15个字符！');
	 $('#name').focus();
	 return false;   
   }else{
     return true;
   }
}

function check_flinkform()
{
	   var link_email=$("input[name='link_email']").val();
	   var link_name=$("input[name='link_name']").val();
	   var link_url=$("input[name='link_url']").val();
	   if(link_email.search(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/) == -1){
            alert('email格式不合法'); 
	 	    $("#link_email").focus();
	 	    return false;
	  }else if(!$.trim(link_name)){
           alert('请填写链接名称'); 
	 	   $("#link_name").focus();
	 	   return false;
	   }else if(!$.trim(link_name).length>30){
           alert('链接名称不得超过30'); 
	 	   $("#link_name").focus();
	 	   return false;
	   }else if(!$.trim(link_url)){
           alert('请填写链接地址'); 
	 	   $("#link_url").focus();
	 	   return false;
	   }
}