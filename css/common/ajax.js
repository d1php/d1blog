/*@d1blog 2012-2012
 *@作者：陈先觉
 *@主页：www.phptogether.com 
 */

jQuery(function(){
$("#category_description").keyup(function(){
  var category_description=$.trim($("input[name='category_description']").val());
  if(category_description&&category_description.length<=30){
	  $("#category_description_remind").removeClass('input-notification error png_bg');
	  $("#category_description_remind").addClass('input-notification success png_bg');
	  $("#category_description_remind").html(' ');
  }else if(category_description.length>30){
	  $("#category_description_remind").removeClass('input-notification success png_bg');
	  $("#category_description_remind").addClass('input-notification error png_bg');
	  $("#category_description_remind").html('分类描述不能超过30个字符');
  }
});})

jQuery(function(){
$("#category_description").blur(function(){
  var category_description=$.trim($("input[name='category_description']").val());
  if(category_description&&category_description.length<=30){
	  $("#category_description_remind").removeClass('input-notification error png_bg');
	  $("#category_description_remind").addClass('input-notification success png_bg');
	  $("#category_description_remind").html(' ');
  }else if(category_description.length>30){
	  $("#category_description_remind").removeClass('input-notification success png_bg');
	  $("#category_description_remind").addClass('input-notification error png_bg');
	  $("#category_description_remind").html('分类描述不能超过30个字符');
  }
});})

jQuery(function(){
$("#newcategory").keyup(function(){
	categoryname=$.trim($("input[name='newcategory']").val());
  if(categoryname&&categoryname.length<=20){
	  $("#categoryremind").removeClass('input-notification error png_bg');
	  $("#categoryremind").addClass('input-notification success png_bg');
	  $("#categoryremind").html(' ');
  }else if(categoryname.length>20){
	  $("#categoryremind").removeClass('input-notification success png_bg');
	  $("#categoryremind").addClass('input-notification error png_bg');
	  $("#categoryremind").html('分类名称不能超过20个字符');
  }
});})

jQuery(function(){
$("#newcategory").blur(function(){
	categoryname=$.trim($("input[name='newcategory']").val());
  if(categoryname&&categoryname.length<=20){
	  $("#categoryremind").removeClass('input-notification error png_bg');
	  $("#categoryremind").addClass('input-notification success png_bg');
	  $("#categoryremind").html(' ');
  }else if(categoryname.length>20){
	  $("#categoryremind").removeClass('input-notification success png_bg');
	  $("#categoryremind").addClass('input-notification error png_bg');
	  $("#categoryremind").html('分类名称不能超过20个字符');
  }
});})

function check_adminform(tourl,dourl){
   var usrname=$("input[name='usrname']").val();
   var usrpwd=$("input[name='usrpwd']").val();
   var rememberme=$("input[name='rememberme']").val();
   if(!$.trim(usrname)){
     $("#adminremind").html("<font color='red'>用户名不能为空</font>");
     return false;
   }else if(!$.trim(usrpwd)){
	 $("#adminremind").html("<font color='red'>密码不能为空</font>");
	 return false;   
   }else{
	   $.post(dourl, {usrname:usrname,usrpwd:usrpwd,rememberme:rememberme},function(data){
		  if(data){
			  $("#adminremind").html("<font color='red'>"+data+"</font>");
		  }else{
			  location.href=tourl;
		  }
			  
	   });
	   return false;
   }
}

function add_category(url){
	   var categoryname=$.trim($("input[name='newcategory']").val());
	   var category_description=$.trim($("input[name='category_description']").val());
	   $("#categoryremind").fadeIn("slow");
	   $("#category_description_remind").fadeIn("slow"); 
	   if(!$.trim(categoryname)){
		   $("#categoryremind").addClass('input-notification error png_bg');
		   $("#categoryremind").html('分类名称不能为空');
		   $("#newcategory").focus();
	       return false;
	   }else if(categoryname.length>20){
		   $("#categoryremind").addClass('input-notification error png_bg');
		   $("#categoryremind").html('分类名称不能超过20个字符');
		   $("#newcategory").focus();
		   return false;
	   }else if(category_description.length>30){
		   $("#category_description_remind").addClass('input-notification error png_bg');
		   $("#category_description_remind").html('分类描述不能超过30个字符');
		   $("#category_description").focus();
		   return false;
	   }else{
		 $.post(url, {categoryname:categoryname,category_description:category_description},function(data){
			  if(data=='success'){
				  $("#categoryremind").removeClass('input-notification error png_bg');
				  $("#categoryremind").addClass('input-notification success png_bg');
				  $("#categoryremind").html('分类添加成功');
				  $("#categoryremind").fadeOut("slow"); 
				  $("#category_description_remind").fadeOut("slow"); 
			  }else if(data=='repeat'){
				  $("#categoryremind").removeClass('input-notification success png_bg');
				  $("#categoryremind").addClass('input-notification error png_bg');
				  $("#categoryremind").html('请不要重复添加');
			  }else{
				  $("#categoryremind").removeClass('input-notification success png_bg');
				  $("#categoryremind").addClass('input-notification error png_bg');
				  $("#categoryremind").html(data);
			  }
	   });
		   return false;
	  }
}

function show_category_edit(id){
	var name=$("#n"+id).html();
	var description=$("#d"+id).html();
	$('#tn'+id).html('<input type="text" value="'+name+'" name="categoryname'+id+'" id="categoryname'+id+'">');
	$('#d'+id).html('<input type="text" value="'+description+'" name="categorydescription'+id+'" id="categorydescription'+id+'">');
}

function apply_category_edit(id,dourl){
	var newcategoryname=$("#categoryname"+id).val();
	var newcategorydescription=$("#categorydescription"+id).val();
    if(!$("#categoryname"+id).is("input")){
		alert('分类名称未修改');
		return false;
	}	if(!$.trim(newcategoryname)){
		alert('分类名称不能为空');
		$("#categoryname"+id).focus();
		return false;
	}
	var checkedlength=$("input[name='categorybox']:checked").length;
	$.ajax({
		type: "POST",
		url: dourl,
		dataType:'json',
		data: "id="+id+"&newcategoryname="+newcategoryname+"&newcategorydescription="+newcategorydescription,
		success: function(data){
		if(data){
		$('#tn'+id).html('<a href="#" id="n'+id+'">'+data.name+'</a>');
		$('#d'+id).html(data.description);	
		}else{
		return false;	
		}	
		}
		});
	$("#categorybox"+id).attr('checked',false);
	if(!checkedlength)$("#category_edit_button").css('visibility','hidden');
	$("#category_apply_button").attr('disabled',false);
}

function delete_category(id,dourl){
	if(confirm('你确定要删除吗，被删除分类下的文章将不再被分类')){
		 var mpos=location.href.indexOf('category');
		 var page=location.href.substr(mpos+9);
	     if(!$.trim(page))page=1;
			$.ajax({
				type: "POST",
				url: dourl,
				dataType:'json',
				data:"id="+id+'&page='+page,
				success: function(data){
				  if(data){
					  $("#r"+id).remove();
					  var boxlength2=$("input[name='categorybox']").length;
					  if(boxlength2==0&&data.page==page){
						  location=location;
					  }else if(boxlength2==0&&data.page!=page&&data.page){
						  location.href=location.href.substr(0,mpos)+'category/'+data.page+'#note';
					  }else if(boxlength2==0&&!data.page){
						  location.href=location.href.substr(0,mpos)+'category/#note';
					  }
					  $("#pagination").html(data.newpagination);
				  }else{
				  return false;	
				  }	
			   }
			});	
	}
}

jQuery(function(){
	$("#category_apply_button").click(function(){
	 var actionname=$("#applyname").val();
	 if(actionname=='none'){
		 $("#note").html('<span style="color:red">请选择一项操作！</span>');
		 return false;
	 }
	 var boxlength=$("input[name='categorybox']").length;
	 var checkedlength=$("input[name='categorybox']:checked").length;
	 if(!checkedlength){
		 $("#note").html('<span style="color:red">请勾选至少一个项目！</span>');
		 return false;
	 }
	 $("#note").html('<span style="color:red">睁大眼睛看仔细咯~！</span>');
	 if(actionname=='edit'){
		 for(var i=0;i<boxlength;i++){
			 if($("input[name='categorybox']").eq(i).attr("checked")=='checked'){
				 var category_id=$("input[name='categorybox']").eq(i).val();
				 show_category_edit(category_id); 
			 }	 
		 }
		 $("#category_apply_button").attr('disabled',true);
		 $("#category_edit_button").css('visibility','visible');
	 }else if(actionname=='delete'){
		 if(confirm('你确定要删除吗，被删除分类下的文章将不再被分类')){
		 var mpos=location.href.indexOf('category');
		 var dourl=location.href.substr(0,mpos)+'deleteallcategory';
		 var boxlength=$("input[name='categorybox']").length;
		 var page=location.href.substr(mpos+9);
		 if(!page)page=1;
		 var deletedata='';
			for(var i=0;i<boxlength;i++){
			  if($("input[name='categorybox']").eq(i).attr("checked")=='checked'){
				category_id=$("input[name='categorybox']").eq(i).val();
				deletedata +='{"id": "'+$("input[name='categorybox']").eq(i).val()+'"},';
		      }
		    }
			var lpos=deletedata.lastIndexOf(',');
			deletedata='['+deletedata.substr(0,lpos)+']';
			$.ajax({
				type: "POST",
				url: dourl,
				dataType:'json',
				data: "deletedata="+deletedata+'&page='+page,
				success: function(data){
				  if(data){
					  for(i=0;i<data.len;i++){
						  $("#r"+data[i].id).remove();
					  }	
					  var boxlength2=$("input[name='categorybox']").length;
					  if(boxlength2==0&&data.page==page){
						  location=location;
					  }else if(boxlength2==0&&data.page!=page){
						  location.href=location.href.substr(0,mpos)+'category/'+data.page+'#note';
					  }else if(boxlength2==0&&!data.page){
						  location.href=location.href.substr(0,mpos)+'category/#note';
					  }
					  $("#pagination").html(data.newpagination);
				  }else{
				  return false;	
				  }	
			   }
			});
			$("#category_apply_button").attr('disabled',false);
		 }else{
			 return false;
		 }
	 }
	});})

function edit_all_category(dourl){
    var boxlength=$("input[name='categorybox']").length;
    var editdata='';
	for(var i=0;i<boxlength;i++){
	  if($("input[name='categorybox']").eq(i).attr("checked")=='checked'){
		category_id=$("input[name='categorybox']").eq(i).val();
		editdata +='{"id": "'+$("input[name='categorybox']").eq(i).val()+'","name": "'+$("#categoryname"+category_id).val()+'", "description": "'+$("#categorydescription"+category_id).val()+'"},';
      }
    }
	var lpos=editdata.lastIndexOf(',');
	editdata='['+editdata.substr(0,lpos)+']';
	$.ajax({
		type: "POST",
		url: dourl,
		dataType:'json',
		data: "editdata="+editdata,
		success: function(data){
		  if(data){
		  for(i=0;i<data.len;i++){
			  $('#tn'+data[i].id).html('<a href="#" id="n'+data[i].id+'">'+data[i].name+'</a>');
			  $('#d'+data[i].id).html(data[i].description);  
		  }	  
		  }else{
		  return false;	
		  }	
	   }
	});
	$("#category_edit_button").css('visibility','hidden');
	$("#category_apply_button").attr('disabled',false);
}

jQuery(function(){
	$("#article_apply_button").click(function(){
	 var actionname=$("#applyname").val();
	 if(actionname=='none'){
		 $("#note").html('<span style="color:red">请选择一项操作！</span>');
		 return false;
	 }
	 var boxlength=$("input[name='articlebox']").length;
	 var checkedlength=$("input[name='articlebox']:checked").length;
	 if(!checkedlength){
		 $("#note").html('<span style="color:red">请勾选至少一个项目！</span>');
		 return false;
	 }
	 $("#note").html('<span style="color:red">睁大眼睛看仔细咯~！</span>');
     if(actionname=='delete'){
		 if(confirm('你确定要删除吗，该分类下的文章将不再有文类')){
		 var mpos=location.href.indexOf('articlelist');
		 var dourl=location.href.substr(0,mpos)+'deleteallarticle';
		 var boxlength=$("input[name='articlebox']").length;
		 var page=location.href.substr(mpos+12);
		 if(!page)page=1;
		 var deletedata='';
			for(var i=0;i<boxlength;i++){
			  if($("input[name='articlebox']").eq(i).attr("checked")=='checked'){
				article_id=$("input[name='articlebox']").eq(i).val();
				deletedata +='{"id":"'+article_id+'"},';
		      }
		    }
			var lpos=deletedata.lastIndexOf(',');
			deletedata='['+deletedata.substr(0,lpos)+']';
			$.ajax({
				type: "POST",
				url: dourl,
				dataType:'json',
				data: "deletedata="+deletedata+'&page='+page,
				success: function(data){
				  if(data){
					  for(i=0;i<data.len;i++){
						  $("#r"+data[i].id).remove();
					  }
					  var boxlength2=$("input[name='articlebox']").length;
					  if(boxlength2==0&&data.page==page){
						  location=location;
					  }else if(boxlength2==0&&data.page!=page){
						  location.href=location.href.substr(0,mpos)+'articlelist/'+data.page+'#note';
					  }else if(boxlength2==0&&!data.page){
						  location.href=location.href.substr(0,mpos)+'articlelist/#note';
					  }
					  $("#pagination").html(data.newpagination);
				  }else{
				  return false;	
				  }	
			   }
			});
			$("#article_apply_button").attr('disabled',false);
		 }else{
			 return false;
		 }
	 }
	});})

jQuery(function(){
	$("#article_category_apply_button").click(function(){
	 var actionname=$("#applyname").val();
	 if(actionname=='none'){
		 $("#note").html('<span style="color:red">请选择一项操作！</span>');
		 return false;
	 }
	 var boxlength=$("input[name='articlebox']").length;
	 var checkedlength=$("input[name='articlebox']:checked").length;
	 if(!checkedlength){
		 $("#note").html('<span style="color:red">请勾选至少一个项目！</span>');
		 return false;
	 }
	 $("#note").html('<span style="color:red">睁大眼睛看仔细咯~！</span>');
     if(actionname=='delete'){
		 if(confirm('你确定要删除吗，该分类下的文章将不再有文类')){
		 var mpos=location.href.indexOf('listbycategory');
		 var dourl=location.href.substr(0,mpos)+'deleteallarticle_bycategory';
		 var boxlength=$("input[name='articlebox']").length;
		 var page=$("#cpn").html();
	     if(!$.trim(page))page=1;
		 var deletedata='';
			for(var i=0;i<boxlength;i++){
			  if($("input[name='articlebox']").eq(i).attr("checked")=='checked'){
				article_id=$("input[name='articlebox']").eq(i).val();
				deletedata +='{"id":"'+article_id+'"},';
		      }
		    }
			var lpos=deletedata.lastIndexOf(',');
			deletedata='['+deletedata.substr(0,lpos)+']';
			$.ajax({
				type: "POST",
				url: dourl,
				dataType:'json',
				data: "deletedata="+deletedata+'&page='+page,
				success: function(data){
				  if(data){
					  for(i=0;i<data.len;i++){
						  $("#r"+data[i].id).remove();
					  }
					  var boxlength2=$("input[name='articlebox']").length;
					  if(boxlength2==0&&data.page==page){
						  location=location;
					  }else if(boxlength2==0&&data.page!=page&&data.page){
						  location.href=location.href.substr(0,mpos)+'listbycategory/'+data.category_id+'/'+data.page+'#note';
					  }else if(boxlength2==0&&!data.page){
						  location.href=location.href.substr(0,mpos)+'listbycategory/'+data.category_id+'#note';
					  }
					  $("#pagination").html(data.newpagination);
				  }else{
				  return false;	
				  }	
			   }
			});
			$("#article_category_apply_button").attr('disabled',false);
		 }else{
			 return false;
		 }
	 }
	});})


jQuery(function(){
	$("#articlesearch_apply_button").click(function(){
	 var actionname=$("#applyname").val();
	 if(actionname=='none'){
		 $("#note").html('<span style="color:red">请选择一项操作！</span>');
		 return false;
	 }
	 var boxlength=$("input[name='articlebox']").length;
	 var checkedlength=$("input[name='articlebox']:checked").length;
	 if(!checkedlength){
		 $("#note").html('<span style="color:red">请勾选至少一个项目！</span>');
		 return false;
	 }
	 $("#note").html('<span style="color:red">睁大眼睛看仔细咯~！</span>');
     if(actionname=='delete'){
		 if(confirm('你确定要删除吗，该分类下的文章将不再有文类')){
		 var mpos=location.href.indexOf('search');
		 var dourl=location.href.substr(0,mpos)+'deleteallarticlesearch';
		 var boxlength=$("input[name='articlebox']").length;
		 var page=$("#cpn").html();
		 var w=encodeURIComponent($("#w").val());
	     if(!$.trim(page))page=1;
		 var deletedata='';
			for(var i=0;i<boxlength;i++){
			  if($("input[name='articlebox']").eq(i).attr("checked")=='checked'){
				article_id=$("input[name='articlebox']").eq(i).val();
				deletedata +='{"id":"'+article_id+'"},';
		      }
		    }
			var lpos=deletedata.lastIndexOf(',');
			deletedata='['+deletedata.substr(0,lpos)+']';
			$.ajax({
				type: "POST",
				url: dourl,
				dataType:'json',
				data: "deletedata="+deletedata+'&page='+page+'&w='+w,
				success: function(data){
				  if(data){
					  for(i=0;i<data.len;i++){
						  $("#r"+data[i].id).remove();
					  }
					  var boxlength2=$("input[name='articlebox']").length;
					  if(boxlength2==0&&data.page==page){
						  location=location;
					  }else if(boxlength2==0&&data.page!=page&&data.page){
						  location.href=location.href.substr(0,mpos)+'search/'+data.w+'/'+data.page+'#note';
					  }else if(boxlength2==0&&!data.page){
						  location.href=location.href.substr(0,mpos)+'search/'+data.w+'#note';
					  }
					  $("#pagination").html(data.newpagination);
				  }else{
				  return false;	
				  }	
			   }
			});
			$("#articlesearch_apply_button").attr('disabled',false);
		 }else{
			 return false;
		 }
	 }
	});})

function delete_article(id,dourl){
	if(confirm('你确定要删除吗，该操作不可恢复')){
		 var mpos=location.href.indexOf('articlelist');
		 var page=location.href.substr(mpos+12);
	     if(!$.trim(page))page=1;
			$.ajax({
				type: "POST",
				url: dourl,
				dataType:'json',
				data:"id="+id+'&page='+page,
				success: function(data){
				  if(data){
					  $("#r"+id).remove();
					  var boxlength2=$("input[name='articlebox']").length;
					  if(boxlength2==0&&data.page==page){
						  location=location;
					  }else if(boxlength2==0&&data.page!=page&&data.page){
						  location.href=location.href.substr(0,mpos)+'articlelist/'+data.page+'#note';
					  }else if(boxlength2==0&&!data.page){
						  location.href=location.href.substr(0,mpos)+'articlelist/#note';
					  }
					  $("#pagination").html(data.newpagination);
					  $("#articlebox"+id).attr('checked',false);
				  }else{
				  return false;	
				  }	
			   }
			});		
	}
}

function delete_articlesearch(id,w,dourl){
	if(confirm('你确定要删除吗，该操作不可恢复')){
		 var mpos=location.href.indexOf('search');
		 var page=$("#cpn").html();
		 var w=encodeURIComponent(w);
	     if(!$.trim(page))page=1;
			$.ajax({
				type: "POST",
				url: dourl,
				dataType:'json',
				data:"id="+id+'&page='+page+'&w='+w,
				success: function(data){
				  if(data){
					  $("#r"+id).remove();
					  var boxlength2=$("input[name='articlebox']").length;
					  if(boxlength2==0&&data.page==page){
						  location=location;
					  }else if(boxlength2==0&&data.page!=page&&data.page){
						  location.href=location.href.substr(0,mpos)+'search/'+data.w+'/'+data.page+'#note';
					  }else if(boxlength2==0&&!data.page){
						  location.href=location.href.substr(0,mpos)+'search/'+data.w+'#note';
					  }
					  $("#pagination").html(data.newpagination);
					  $("#articlebox"+id).attr('checked',false);
				  }else{
				  return false;	
				  }	
			   }
			});		
	}
}

function delete_article_bytag(id,dourl,tag_id){
	if(confirm('你确定要删除吗，该操作不可恢复')){
		 var mpos=location.href.indexOf('listbytag');
		 var page=$("#cpn").html();
	     if(!$.trim(page))page=1;
			$.ajax({
				type: "POST",
				url: dourl,
				dataType:'json',
				data:"id="+id+'&page='+page+'&tag_id='+tag_id,
				success: function(data){
				  if(data){
					  $("#r"+id).remove();
					  var boxlength2=$("input[name='articlebox']").length;
					  if(boxlength2==0&&data.page==page){
						  location=location;
					  }else if(boxlength2==0&&data.page!=page&&data.page){
						  location.href=location.href.substr(0,mpos)+'listbytag/'+tag_id+'/'+data.page+'#note';
					  }else if(boxlength2==0&&!data.page){
						  location.href=location.href.substr(0,mpos)+'listbytag/'+tag_id+'#note';
					  }
					  $("#pagination").html(data.newpagination);
					  $("#articlebox"+id).attr('checked',false);
				  }else{
				  return false;	
				  }	
			   }
			});		
	}
}

jQuery(function(){
	$("#article_tag_apply_button").click(function(){
	 var actionname=$("#applyname").val();
	 if(actionname=='none'){
		 $("#note").html('<span style="color:red">请选择一项操作！</span>');
		 return false;
	 }
	 var boxlength=$("input[name='articlebox']").length;
	 var checkedlength=$("input[name='articlebox']:checked").length;
	 if(!checkedlength){
		 $("#note").html('<span style="color:red">请勾选至少一个项目！</span>');
		 return false;
	 }
	 $("#note").html('<span style="color:red">睁大眼睛看仔细咯~！</span>');
     if(actionname=='delete'){
		 if(confirm('你确定要删除吗，该分类下的文章将不再有文类')){
		 var mpos=location.href.indexOf('listbytag');
		 var dourl=location.href.substr(0,mpos)+'deleteallarticle_bytag';
		 var boxlength=$("input[name='articlebox']").length;
		 var tagstr=location.href.substr(mpos+10);
		 var urlarr=tagstr.split('/');
		 var tag_id=urlarr[0];
		 var page=$("#cpn").html();
	     if(!$.trim(page))page=1;
		 var deletedata='';
			for(var i=0;i<boxlength;i++){
			  if($("input[name='articlebox']").eq(i).attr("checked")=='checked'){
				article_id=$("input[name='articlebox']").eq(i).val();
				deletedata +='{"id":"'+article_id+'"},';
		      }
		    }
			var lpos=deletedata.lastIndexOf(',');
			deletedata='['+deletedata.substr(0,lpos)+']';
			$.ajax({
				type: "POST",
				url: dourl,
				dataType:'json',
				data: "deletedata="+deletedata+'&page='+page+'&tag_id='+tag_id,
				success: function(data){
				  if(data){
					  for(i=0;i<data.len;i++){
						  $("#r"+data[i].id).remove();
					  }
					  var boxlength2=$("input[name='articlebox']").length;
					  if(boxlength2==0&&data.page==page){
						  location=location;
					  }else if(boxlength2==0&&data.page!=page&&data.page){
						  location.href=location.href.substr(0,mpos)+'listbytag/'+tag_id+'/'+data.page+'#note';
					  }else if(boxlength2==0&&!data.page){
						  location.href=location.href.substr(0,mpos)+'listbytag/'+tag_id+'#note';
					  }
					  $("#pagination").html(data.newpagination);
				  }else{
				  return false;	
				  }	
			   }
			});
			$("#article_tag_apply_button").attr('disabled',false);
		 }else{
			 return false;
		 }
	 }
	});})
	
function delete_article_bycategory(id,dourl){
	if(confirm('你确定要删除吗，该操作不可恢复')){
		 var mpos=location.href.indexOf('listbycategory');
		 var page=$("#cpn").html();
	     if(!$.trim(page))page=1;
			$.ajax({
				type: "POST",
				url: dourl,
				dataType:'json',
				data:"id="+id+'&page='+page,
				success: function(data){
				  if(data){
					  $("#r"+id).remove();
					  var boxlength2=$("input[name='articlebox']").length;
					  if(boxlength2==0&&data.page==page){
						  location=location;
					  }else if(boxlength2==0&&data.page!=page&&data.page){
						  location.href=location.href.substr(0,mpos)+'listbycategory/'+data.category_id+'/'+data.page+'#note';
					  }else if(boxlength2==0&&!data.page){
						  location.href=location.href.substr(0,mpos)+'listbycategory/'+data.category_id+'#note';
					  }
					  $("#pagination").html(data.newpagination);
					  $("#articlebox"+id).attr('checked',false);
				  }else{
				  return false;	
				  }	
			   }
			});		
	}
}

function check_linkform(){
	   var link_name=$("input[name='link_name']").val();
	   var link_url=$("input[name='link_url']").val();
       if(!$.trim(link_name)){
	     $("#linknameremind").removeClass('input-notification success png_bg');
	     $("#linknameremind").addClass('input-notification error png_bg');  
	     $("#linknameremind").html("请填写链接名称");
	     $("#link_name").focus();
	     return false;
	   }
	   else if($.trim(link_name).length>30){
		$("#linknameremind").removeClass('input-notification success png_bg');
		$("#linknameremind").addClass('input-notification error png_bg'); 
		$("#linknameremind").html("链接名称不能超过30个字符");
		$("#link_name").focus();
		 return false;   
	   }else if(!$.trim(link_url)){
		 $("#linkurlremind").removeClass('input-notification success png_bg');
		 $("#linkurlremind").addClass('input-notification error png_bg'); 
		 $("#linkurlremind").html("请填写链接地址");
		 $("#link_url").focus();
		 return false;   
	   }else{
         $('#link_form').submit();
	   }
	}

jQuery(function(){
	$("#link_name").keyup(function(){
	  var link_name=$.trim($("input[name='link_name']").val());
	  if(link_name&&link_name.length<=30){
		  $("#linknameremind").removeClass('input-notification error png_bg');
		  $("#linknameremind").addClass('input-notification success png_bg');
		  $("#linknameremind").html('&nbsp;');
	  }else if(link_name.length>30){
		  $("#linknameremind").removeClass('input-notification success png_bg');
		  $("#linknameremind").addClass('input-notification error png_bg');
		  $("#linknameremind").html('链接名称不能超过30个字符');
	  }
	});})

jQuery(function(){
	$("#link_url").keyup(function(){
	  var link_url=$.trim($("input[name='link_url']").val());
	  if(link_url){
		  $("#linkurlremind").removeClass('input-notification error png_bg');
		  $("#linkurlremind").addClass('input-notification success png_bg');
		  $("#linkurlremind").html('&nbsp;');
	  }else{
		  $("#linkurlremind").removeClass('input-notification success png_bg');
		  $("#linkurlremind").addClass('input-notification error png_bg');
		  $("#linkurlremind").html('链接地址不能为空');
	  }
	});})
	
function show_link_edit(id){
	var name=$("#n"+id).html();
	var description=$("#d"+id).html();
	var url=$("#u"+id).html();
	var email=$("#e"+id).html();
	if(!email)email='无';
	var link_status=$("#s"+id).html();
	if(link_status=='可见')
	    var statuschecked='checked=checked';
	else
	    var statuschecked=false;
	$('#tn'+id).html('<input type="text" value="'+name+'" name="linkname'+id+'" id="linkname'+id+'">');
	$('#u'+id).html('<input type="text" value="'+url+'" name="linkurl'+id+'" id="linkurl'+id+'">');
	$('#d'+id).html('<input type="text" value="'+description+'" name="linkdescription'+id+'" id="linkdescription'+id+'">');
	$('#re'+id).html('<input type="text" value="'+email+'" name="linkemail'+id+'" id="linkemail'+id+'">');
	$('#s'+id).html('<input type="checkbox" value="1" name="linkstatus'+id+'" id="linkstatus'+id+'" '+statuschecked+'>可见');
	$("#note").html('<span style="color:red">睁大眼睛看仔细咯~！</span>');
}

function apply_link_edit(id,dourl){
	var newlinkname=$("#linkname"+id).val();
	var newlinkdescription=$("#linkdescription"+id).val();
	var newlinkurl=$("#linkurl"+id).val();
	var newlinkemail=$("#linkemail"+id).val();
	if($('#linkstatus'+id).attr('checked')=='checked')
		var newlinkstatus=1;
	else
		var newlinkstatus=0;
    if(!$("#linkname"+id).is("input")){
		alert('未获得任何修改项目');
		return;
	}else if(!$.trim(newlinkname)){
		alert('链接名称不能为空');
		$("#linkname"+id).focus();
		return;
	}else if(!$.trim(newlinkurl)){
		alert('链接地址不能为空');
		$("#linkname"+id).focus();
		return;
	}
	var checkedlength=$("input[name='linkbox']:checked").length;
	$.ajax({
		type: "POST",
		url: dourl,
		dataType:'json',
		data: "id="+id+"&newlinkname="+newlinkname+"&newlinkdescription="+newlinkdescription+"&newlinkurl="+newlinkurl+"&newlinkemail="+newlinkemail+"&newlinkstatus="+newlinkstatus,
		success: function(data){
		if(data){
		$('#tn'+id).html('<a href="'+data.link_url+'" id="n'+id+'">'+data.link_name+'</a>');
		$('#d'+id).html(data.link_description);	
		$('#u'+id).html(data.link_url);
		$('#re'+id).html('<a href="mailto:'+data.link_email+'" id="e'+id+'">'+data.link_email+'</a>');
		if(parseInt(data.link_status))
			$('#s'+id).html('可见');
		else
			$('#s'+id).html('不可见');
		}else{
		return false;	
		}
		}
		});
	$("#linkbox"+id).attr('checked',false);
	if(!checkedlength)$("#link_edit_button").css('visibility','hidden');
	$("#link_apply_button").attr('disabled',false);
}

function delete_link(id,dourl){
	if(confirm('你确定要删除吗，该操作不可恢复')){
		 var mpos=location.href.indexOf('linklist');
		 var page=location.href.substr(mpos+9);
	     if(!$.trim(page))page=1;
			$.ajax({
				type: "POST",
				url: dourl,
				dataType:'json',
				data:"id="+id+'&page='+page,
				success: function(data){
				  if(data){
					  $("#r"+id).remove();
					  var boxlength2=$("input[name='linkbox']").length;
					  if(boxlength2==0&&data.page==page){
						  location=location;
					  }else if(boxlength2==0&&data.page!=page&&data.page){
						  location.href=location.href.substr(0,mpos)+'linklist/'+data.page+'#note';
					  }else if(boxlength2==0&&!data.page){
						  location.href=location.href.substr(0,mpos)+'linklist/#note';
					  }
					  $("#pagination").html(data.newpagination);
				  }else{
				  return false;	
				  }	
			   }
			});		
	}else{
		return false;
	}
}

jQuery(function(){
	$("#link_apply_button").click(function(){
	 var actionname=$("#applyname").val();
	 if(actionname=='none'){
		 $("#note").html('<span style="color:red">请选择一项操作！</span>');
		 return false;
	 }
	 var boxlength=$("input[name='linkbox']").length;
	 var checkedlength=$("input[name='linkbox']:checked").length;
	 if(!checkedlength){
		 $("#note").html('<span style="color:red">请勾选至少一个项目！</span>');
		 return false;
	 }
	 $("#note").html('<span style="color:red">睁大眼睛看仔细咯~！</span>');
	 if(actionname=='edit'){
		 for(var i=0;i<boxlength;i++){
			 if($("input[name='linkbox']").eq(i).attr("checked")=='checked'){
				 var link_id=$("input[name='linkbox']").eq(i).val();
				 show_link_edit(link_id); 
			 }	 
		 }
		 $("#link_apply_button").attr('disabled',true);
		 $("#link_edit_button").css('visibility','visible');
	 }else if(actionname=='delete'){
		 if(confirm('你确定要删除吗，被删除分类下的文章将不再被分类')){
		 var mpos=location.href.indexOf('linklist');
		 var dourl=location.href.substr(0,mpos)+'deletealllink';
		 var boxlength=$("input[name='linkbox']").length;
		 var page=location.href.substr(mpos+9);
	     if(!$.trim(page))page=1;
		 var deletedata='';
			for(var i=0;i<boxlength;i++){
			  if($("input[name='linkbox']").eq(i).attr("checked")=='checked'){
				link_id=$("input[name='linkbox']").eq(i).val();
				deletedata +='{"id": "'+$("input[name='linkbox']").eq(i).val()+'"},';
		      }
		    }
			var lpos=deletedata.lastIndexOf(',');
			deletedata='['+deletedata.substr(0,lpos)+']';
			$.ajax({
				type: "POST",
				url: dourl,
				dataType:'json',
				data: "deletedata="+deletedata+"&page="+page,
				success: function(data){
				  if(data){
					  for(i=0;i<data.len;i++){
						  $("#r"+data[i].id).remove();
					  }
					  var boxlength2=$("input[name='linkbox']").length;
					  if(boxlength2==0&&data.page==page){
						  location=location;
					  }else if(boxlength2==0&&data.page&&data.page!=page){
						  location.href=location.href.substr(0,mpos)+'linklist/'+data.page+'#note';
					  }else if(boxlength2==0&&!data.page){
						  location.href=location.href.substr(0,mpos)+'linklist/#note';
					  }
					  $("#pagination").html(data.newpagination);	  
				  }else{
				  return false;	
				  }	
			   }
			});
			$("#link_apply_button").attr('disabled',false);
		 }else{
			 return false;
		 }
	 }
	});})

function edit_all_link(dourl){
    var boxlength=$("input[name='linkbox']").length;
    var editdata='';

	for(var i=0;i<boxlength;i++){
	  if($("input[name='linkbox']").eq(i).attr("checked")=='checked'){
		link_id=$("input[name='linkbox']").eq(i).val();
	    if(!$.trim($("#linkname"+link_id).val())){
			alert('链接名称不能为空');
			$("#linkname"+link_id).focus();
			return false;
		}else if(!$.trim($("#linkurl"+link_id).val())){
			alert('链接地址不能为空');
			$("#linkurl"+link_id).focus();
			return false;
		}
		if($('#linkstatus'+link_id).attr('checked')=='checked')
			var newlinkstatus=1;
		else
			var newlinkstatus=0;
		editdata +='{"id": "'+link_id+'","newlinkname": "'+$("#linkname"+link_id).val()+'", "newlinkdescription": "'+$("#linkdescription"+link_id).val()+'", "newlinkurl": "'+$("#linkurl"+link_id).val()+'","newlinkemail": "'+$("#linkemail"+link_id).val()+'","newlinkstatus": "'+newlinkstatus+'"},';
      }
    }
	var lpos=editdata.lastIndexOf(',');
	editdata='['+editdata.substr(0,lpos)+']';
	$.ajax({
		type: "POST",
		url: dourl,
		dataType:'json',
		data: "editdata="+editdata,
		success: function(data){
		  if(data){
		  for(i=0;i<data.len;i++){
				$('#tn'+data[i].id).html('<a href="'+data[i].link_url+'" id="n'+data[i].id+'" target="_blank">'+data[i].link_name+'</a>');
				$('#d'+data[i].id).html(data[i].link_description);	
				$('#u'+data[i].id).html(data[i].link_url);
				if(data[i].link_email)
				$('#re'+data[i].id).html('<a href="mailto:'+data[i].link_email+'" titile="邮件通知对方" id="e'+id+'">'+data[i].link_email+'</a>');
				else
				$('#re'+data[i].id).html('无');	
				if(parseInt(data[i].link_status))
					$('#s'+data[i].id).html('可见');
				else
					$('#s'+data[i].id).html('不可见');
		  }	  
		  }else{
		  return false;	
		  }	
	   }
	});
	$("#link_edit_button").css('visibility','hidden');
	$("#link_apply_button").attr('disabled',false);
}

jQuery(function(){
	$("#requestlink_apply_button").click(function(){
	 var actionname=$("#applyname").val();
	 if(actionname=='none'){
		 $("#note").html('<span style="color:red">请选择一项操作！</span>');
		 return false;
	 }
	 var boxlength=$("input[name='requestlinkbox']").length;
	 var checkedlength=$("input[name='requestlinkbox']:checked").length;
	 if(!checkedlength){
		 $("#note").html('<span style="color:red">请勾选至少一个项目！</span>');
		 return false;
	 }
	 $("#note").html('<span style="color:red">睁大眼睛看仔细咯~！</span>');
	 if(actionname=='edit'){
		var mpos=location.href.indexOf('requestlink');
		var dourl=location.href.substr(0,mpos)+'showlink';
		 for(var i=0;i<boxlength;i++){
			 if($("input[name='requestlinkbox']").eq(i).attr("checked")=='checked'){
				 var link_id=$("input[name='requestlinkbox']").eq(i).val();
				 var link_email=$("#e"+link_id).html();
				 show_requestlink(link_id,link_email,dourl)
			 }	 
		 }
		 $("#requestlink_apply_button").attr('disabled',true);
	 }else if(actionname=='delete'){
		 if(confirm('你确定要删除吗，该操作不可恢复')){
		 var mpos=location.href.indexOf('requestlink');
		 var dourl=location.href.substr(0,mpos)+'deleterequestalllink';
		 var boxlength=$("input[name='requestlinkbox']").length;
		 var deletedata='';
			for(var i=0;i<boxlength;i++){
			  if($("input[name='requestlinkbox']").eq(i).attr("checked")=='checked'){
				link_id=$("input[name='requestlinkbox']").eq(i).val();
				deletedata +='{"id": "'+$("input[name='requestlinkbox']").eq(i).val()+'"},';
		      }
		    }
			var lpos=deletedata.lastIndexOf(',');
			deletedata='['+deletedata.substr(0,lpos)+']';
			$.ajax({
				type: "POST",
				url: dourl,
				dataType:'json',
				data: "deletedata="+deletedata,
				success: function(data){
				  if(data){
					  for(i=0;i<data.len;i++){
						  var link_email=$("#e"+data[i].id).html();
						  $("#r"+data[i].id).remove();
						  var message="fail";
						  send_nofity_email(link_email,message);
					  }	  
				  }else{
				  return false;	
				  }	
			   }
			});
			$("#link_apply_button").attr('disabled',false);
		 }else{
			 return false;
		 }
	 }
	});})
	
function show_requestlink(id,email,dourl){
			$.ajax({
				type: "POST",
				url: dourl,
				dataType:'json',
				data:"id="+id+'&email='+email,
				success: function(data){
				  if(data.success){
					  $("#r"+id).remove();
					  send_nofity_email(email,'none');
				  }else{
				  return false;	
				  }	
			   }
			});		
}

function delete_requestlink(id,dourl){
	if(confirm('你确定要删除吗，该操作不可恢复')){
		 var mpos=location.href.indexOf('requestlink');
			$.ajax({
				type: "POST",
				url: dourl,
				dataType:'json',
				data:"id="+id,
				success: function(data){
				  if(data){
					  var link_email=$("#e"+data.id).html();
					  $("#r"+data.id).remove();
					  send_nofity_email(link_email,'fail');
				  }else{
				  return false;	
				  }	
			   }
			});		
	}else{
		return;
	}
}

function send_nofity_email(email,message)
{
	var mpos=location.href.indexOf('requestlink');
	var dourl=location.href.substr(0,mpos)+'send_notify_email';
	$.ajax({
		type: "POST",
		url: dourl,
		dataType:'json',
		data:'email='+email+'&message='+message,
		success: function(data){
		  if(data.success){
          return true;
		  }else{
		  return false;	
		  }	
	   }
	});	
}

jQuery(function(){
	$("#comment_apply_button").click(function(){
	 var actionname=$("#applyname").val();
	 if(actionname=='none'){
		 $("#note").html('<span style="color:red">请选择一项操作！</span>');
		 return false;
	 }
	 var boxlength=$("input[name='commentbox']").length;
	 var checkedlength=$("input[name='commentbox']:checked").length;
	 if(!checkedlength){
		 $("#note").html('<span style="color:red">请勾选至少一个项目！</span>');
		 return false;
	 }
	 $("#note").html('<span style="color:red">睁大眼睛看仔细咯~！</span>');
     if(actionname=='delete'){
		 if(confirm('你确定要删除吗，该操作不可恢复')){
		 var mpos=location.href.indexOf('comment');
		 var dourl=location.href.substr(0,mpos)+'deleteallcomment';
		 var boxlength=$("input[name='commentbox']").length;
		 var page=location.href.substr(mpos+8);
	     if(!$.trim(page))page=1;
		 var deletedata='';
			for(var i=0;i<boxlength;i++){
			  if($("input[name='commentbox']").eq(i).attr("checked")=='checked'){
				comment_id=$("input[name='commentbox']").eq(i).val();
				deletedata +='{"id":"'+comment_id+'"},';
		      }
		    }
			var lpos=deletedata.lastIndexOf(',');
			deletedata='['+deletedata.substr(0,lpos)+']';
			$.ajax({
				type: "POST",
				url: dourl,
				dataType:'json',
				data: "deletedata="+deletedata+'&page='+page,
				success: function(data){
				  if(data){
					  for(i=0;i<data.len;i++){
						  $("#r"+data[i].id).remove();
					  }
					  $("#pagination").html(data.newpagination);
					  var boxlength2=$("input[name='commentbox']").length;
					  if(boxlength2==0&&data.page==page){
						  location=location;
					  }else if(boxlength2==0&&data.page!=page){
						  location.href=location.href.substr(0,mpos)+'comment/'+data.page+'#note';
					  }else if(boxlength2==0&&!data.page){
						  location.href=location.href.substr(0,mpos)+'comment/#note';
					  }
					  $("#pagination").html(data.newpagination);	  
				  }else{
				  return false;	
				  }	
			   }
			});
			$("#comment_apply_button").attr('disabled',false);
		 }else{
			 return false;
		 }
	 }
	});})
	
function delete_comment(id,dourl){
	if(confirm('你确定要删除吗，该操作不可恢复')){
		 var mpos=location.href.indexOf('comment');
		 var page=location.href.substr(mpos+8);
	     if(!$.trim(page))page=1;
			$.ajax({
				type: "POST",
				url: dourl,
				dataType:'json',
				data:"id="+id+'&page='+page,
				success: function(data){
				  if(data){
					  $("#r"+id).remove();
					  var boxlength2=$("input[name='commentbox']").length;
					  if(boxlength2==0&&data.page==page){
						  location=location;
					  }else if(boxlength2==0&&data.page!=page){
						  location.href=location.href.substr(0,mpos)+'comment/'+data.page+'#note';
					  }else if(boxlength2==0&&!data.page){
						  location.href=location.href.substr(0,mpos)+'comment/#note';
					  }
					  $("#pagination").html(data.newpagination);
				  }else{
				  return false;	
				  }	
			   }
			});			
	}
}

function check_commentform(){
	   var message=$("#message").val();
	   if(!$.trim(message)){
	     alert('留言内容不能为空！');
	     return false;
	   }else{
		 return true;
	   }
}

function show_tag_edit(id){
	var name=$("#n"+id).html();
	$('#tn'+id).html('<input type="text" value="'+name+'" name="tagname'+id+'" id="tagname'+id+'">');
}

function apply_tag_edit(id,dourl){
	var newcategoryname=$("#tagname"+id).val();
    if(!$("#tagname"+id).is("input")){
		alert('标签名称未修改');
		return false;
	}	if(!$.trim(newcategoryname)){
		alert('标签名称不能为空');
		$("#tagname"+id).focus();
		return false;
	}
	var checkedlength=$("input[name='tagbox']:checked").length;
	$.ajax({
		type: "POST",
		url: dourl,
		dataType:'json',
		data: "id="+id+"&newtagname="+newcategoryname,
		success: function(data){
		if(data){
		$('#tn'+id).html('<a href="'+data.url+'" id="n'+id+'">'+data.name+'</a>');
		}else{
		return false;	
		}	
		}
		});
	$("#tagbox"+id).attr('checked',false);
	if(!checkedlength)$("#tag_edit_button").css('visibility','hidden');
	$("#tag_apply_button").attr('disabled',false);
}

function delete_tag(id,dourl){
	if(confirm('你确定要删除吗，该操作不可恢复')){
		 var mpos=location.href.indexOf('tag');
		 var page=location.href.substr(mpos+4);
	     if(!$.trim(page))page=1;
			$.ajax({
				type: "POST",
				url: dourl,
				dataType:'json',
				data:"id="+id+'&page='+page,
				success: function(data){
				  if(data){
					  $("#r"+id).remove();
					  $("#pagination").html(data.newpagination);
					  var boxlength2=$("input[name='tagbox']").length;
					  if(boxlength2==0&&data.page){
						  location.href=location.href.substr(0,mpos)+'tag/'+data.page+'#note';
					  }else if(boxlength2==0&&!data.page){
						  location.href=location.href.substr(0,mpos)+'tag/#note';
					  }
					  $("#imagebox"+id).attr('checked',false);
				  }else{
				  return false;	
				  }	
			   }
			});	
	}
}

jQuery(function(){
	$("#tag_apply_button").click(function(){
	 var actionname=$("#applyname").val();
	 if(actionname=='none'){
		 $("#note").html('<span style="color:red">请选择一项操作！</span>');
		 return false;
	 }
	 var boxlength=$("input[name='tagbox']").length;
	 var checkedlength=$("input[name='tagbox']:checked").length;
	 if(!checkedlength){
		 $("#note").html('<span style="color:red">请勾选至少一个项目！</span>');
		 return false;
	 }
	 $("#note").html('<span style="color:red">睁大眼睛看仔细咯~！</span>');
	 if(actionname=='edit'){
		 for(var i=0;i<boxlength;i++){
			 if($("input[name='tagbox']").eq(i).attr("checked")=='checked'){
				 var tag_id=$("input[name='tagbox']").eq(i).val();
				 show_tag_edit(tag_id); 
			 }	 
		 }
		 $("#tag_apply_button").attr('disabled',true);
		 $("#tag_edit_button").css('visibility','visible');
	 }else if(actionname=='delete'){
		 if(confirm('你确定要删除吗，该标签将不再显示')){
		 var mpos=location.href.indexOf('tag');
		 var dourl=location.href.substr(0,mpos)+'deletealltag';
		 var boxlength=$("input[name='tagbox']").length;
		 var page=location.href.substr(mpos+4);
	     if(!$.trim(page))page=1;
		 var deletedata='';
			for(var i=0;i<boxlength;i++){
			  if($("input[name='tagbox']").eq(i).attr("checked")=='checked'){
				tag_id=$("input[name='tagbox']").eq(i).val();
				deletedata +='{"id": "'+tag_id+'"},';
		      }
		    }
			var lpos=deletedata.lastIndexOf(',');
			deletedata='['+deletedata.substr(0,lpos)+']';
			$.ajax({
				type: "POST",
				url: dourl,
				dataType:'json',
				data: "deletedata="+deletedata+'&page='+page,
				success: function(data){
				  if(data){
					  for(i=0;i<data.len;i++){
						  $("#r"+data[i].id).remove();
					  }
					  $("#pagination").html(data.newpagination);
					  var boxlength2=$("input[name='tagbox']").length;
					  if(boxlength2==0&&data.page==page){
						  location=location;
					  }else if(boxlength2==0&&data.page!=page){
						  location.href=location.href.substr(0,mpos)+'tag/'+data.page+'#note';
					  }else if(boxlength2==0&&!data.page){
						  location.href=location.href.substr(0,mpos)+'tag/#note';
					  }
					  $("#pagination").html(data.newpagination);	  
				  }else{
				  return false;	
				  }	
			   }
			});
			$("#tag_apply_button").attr('disabled',false);
		 }else{
			 return false;
		 }
	 }
	});})

function edit_all_tag(dourl){
    var boxlength=$("input[name='tagbox']").length;
    var editdata='';
	for(var i=0;i<boxlength;i++){
	  if($("input[name='tagbox']").eq(i).attr("checked")=='checked'){
		category_id=$("input[name='tagbox']").eq(i).val();
		editdata +='{"id": "'+$("input[name='tagbox']").eq(i).val()+'","name": "'+$("#tagname"+category_id).val()+'"},';
      }
    }
	var lpos=editdata.lastIndexOf(',');
	editdata='['+editdata.substr(0,lpos)+']';
	$.ajax({
		type: "POST",
		url: dourl,
		dataType:'json',
		data: "editdata="+editdata,
		success: function(data){
		  if(data){
		  for(i=0;i<data.len;i++){
			  $('#tn'+data[i].id).html('<a href="'+data[i].url+'" id="n'+data[i].id+'">'+data[i].name+'</a>');
		  }	  
		  }else{
		  return false;	
		  }	
	   }
	});
	$("#tag_edit_button").css('visibility','hidden');
	$("#tag_apply_button").attr('disabled',false);
}

function check_webmasterform(){
	   var usraccount=$("#usr_account").val();
	   var usrname=$("#usr_nickname").val();
	   var usremail=$("input[name='usr_email']").val();
	   var usrpwd=$("#usr_pwd").val();
	   var usremailpwd=$("#usr_email_pwd").val();
	   if(!$.trim(usraccount)){
		 alert('管理员帐号不能为空');
		 $('#usr_account').focus();
		 return false;
	   }else if(!$.trim(usrname)){
	     alert('昵称不能为空');
	     $('#usr_nickname').focus();
	     return false;
	   }else if(!$.trim(usrpwd)){
		 alert('管理员密码不能为空');
		 $('#usr_pwd').focus();
		 return false;   
	   }else{
		 return true;
	   }
}

function change_pwd(){
	$('#usr_pwd').val('');
	$('#usr_pwd').attr('name','usr_pwd');
	$('#usr_pwd').removeAttr('readonly');
	$('#usr_pwd').focus();
}

function check_imginfoform(img_id_arr){
	var arr=eval('['+decodeURIComponent(img_id_arr)+']');
	var len=arr.length;
	for(var i=0;i<len;i++){
		if($.trim($("#img_description_"+arr[i]).val()).length>255){
			alert('图片描述不能超过255个字符！');
			$("#img_description_"+arr[i]).focus();
			return false;
		}
	}
	return true;
}

function check_imgcategory(){
	var img_category=$("#img_category").val();
	if(img_category=='0'){
		alert('请选择图片分类');
		return;
	}else{
		$('#file_upload').uploadify('settings','formData',{'img_category_id':$("#img_category").val() });
		$('#file_upload').uploadify('upload','*');
	}
}

function check_editimgform(img_id_arr){
	var img_category=$("#img_category").val();
	if(img_category=='0'){
		alert('请选择图片分类');
		return false;
	}
	return check_imginfoform(img_id_arr);
}

function delete_image(id,dourl,imgpath){
	if(confirm('你确定要删除吗，该操作不可恢复')){
		 var mpos=location.href.indexOf('imglist');
		 var page=location.href.substr(mpos+8);
	     if(!$.trim(page))page=1;
			$.ajax({
				type: "POST",
				url: dourl,
				dataType:'json',
				data:"id="+id+'&page='+page+'&imgpath='+imgpath,
				success: function(data){
				  if(data){
					  $("#r"+id).remove();
					  var boxlength2=$("input[name='imagebox']").length;
					  if(boxlength2==0&&data.page==page){
						  location=location;
					  }else if(boxlength2==0&&data.page!=page&&data.page){
						  location.href=location.href.substr(0,mpos)+'imglist/'+data.page+'#note';
					  }else if(boxlength2==0&&!data.page){
						  location.href=location.href.substr(0,mpos)+'imglist/#note';
					  }
					  $("#pagination").html(data.newpagination);
				  }else{
				  return false;	
				  }	
			   }
			});	
	}
}

function delete_image_bycategory(id,dourl,imgpath){
	if(confirm('你确定要删除吗，该操作不可恢复')){
		 var mpos=location.href.indexOf('listbycategory');
		 var page=location.href.substr(mpos+15);
	     if(!$.trim(page))page=1;
			$.ajax({
				type: "POST",
				url: dourl,
				dataType:'json',
				data:"id="+id+'&page='+page+'&imgpath='+imgpath,
				success: function(data){
				  if(data){
					  $("#r"+id).remove();
					  var boxlength2=$("input[name='imagebox']").length;
					  if(boxlength2==0&&data.page==page){
						  location=location;
					  }else if(boxlength2==0&&data.page!=page&&data.page){
						  location.href=location.href.substr(0,mpos)+'listbycategory/'+data.category_id+'/'+data.page+'#note';
					  }else if(boxlength2==0&&!data.page){
						  location.href=location.href.substr(0,mpos)+'listbycategory/'+data.category_id+'#note';
					  }
					  $("#pagination").html(data.newpagination);
				  }else{
				  return false;	
				  }	
			   }
			});	
	}
}

jQuery(function(){
	$("#image_apply_button").click(function(){
	 var actionname=$("#applyname").val();
	 if(actionname=='none'){
		 $("#note").html('<span style="color:red">请选择一项操作！</span>');
		 return false;
	 }
	 var boxlength=$("input[name='imagebox']").length;
	 var checkedlength=$("input[name='imagebox']:checked").length;
	 if(!checkedlength){
		 $("#note").html('<span style="color:red">请勾选至少一个项目！</span>');
		 return false;
	 }
	 $("#note").html('<span style="color:red">睁大眼睛看仔细咯~！</span>');
     if(actionname=='delete'){
		 if(confirm('你确定要删除吗，该操作不可恢复')){
		 var mpos=location.href.indexOf('imglist');
		 var page=location.href.substr(mpos+8);
	     if(!$.trim(page))page=1;
		 var dourl=location.href.substr(0,mpos)+'deleteallimage';
		 var deletedata='';
			for(var i=0;i<boxlength;i++){
			  if($("input[name='imagebox']").eq(i).attr("checked")=='checked'){
				image_id=$("input[name='imagebox']").eq(i).val();
				deletedata +='{"id":"'+image_id+'","imgpath":"'+$("#img_src_"+image_id).attr('src')+'"},';
		      }
		    }
			var lpos=deletedata.lastIndexOf(',');
			deletedata='['+deletedata.substr(0,lpos)+']';
			$.ajax({
				type: "POST",
				url: dourl,
				dataType:'json',
				data: "deletedata="+deletedata+'&page='+page,
				success: function(data){
				  if(data){
					  for(i=0;i<data.len;i++){
						  $("#r"+data[i].id).remove();
					  }
					  var boxlength2=$("input[name='imagebox']").length;
					  if(boxlength2==0&&data.page==page){
						  location=location;
					  }else if(boxlength2==0&&data.page!=page&&data.page){
						  location.href=location.href.substr(0,mpos)+'imglist/'+data.page+'#note';
					  }else if(boxlength2==0&&!data.page){
						  location.href=location.href.substr(0,mpos)+'imglist/#note';
					  }
					  $("#pagination").html(data.newpagination);
				  }else{
				  return false;	
				  }	
			   }
			});
			$("#image_apply_button").attr('disabled',false);
		 }else{
			 return false;
		 }
	 }
	});})

jQuery(function(){
	$("#image_category_apply_button").click(function(){
	 var actionname=$("#applyname").val();
	 if(actionname=='none'){
		 $("#note").html('<span style="color:red">请选择一项操作！</span>');
		 return false;
	 }
	 var boxlength=$("input[name='imagebox']").length;
	 var checkedlength=$("input[name='imagebox']:checked").length;
	 if(!checkedlength){
		 $("#note").html('<span style="color:red">请勾选至少一个项目！</span>');
		 return false;
	 }
	 $("#note").html('<span style="color:red">睁大眼睛看仔细咯~！</span>');
     if(actionname=='delete'){
		 if(confirm('你确定要删除吗，该操作不可恢复')){
		 var mpos=location.href.indexOf('listbycategory');
		 var page=$("#cpn").html();
	     if(!$.trim(page))page=1;
		 var dourl=location.href.substr(0,mpos)+'deleteallimage_bycategory';
		 var deletedata='';
			for(var i=0;i<boxlength;i++){
			  if($("input[name='imagebox']").eq(i).attr("checked")=='checked'){
				image_id=$("input[name='imagebox']").eq(i).val();
				deletedata +='{"id":"'+image_id+'","imgpath":"'+$("#img_src_"+image_id).attr('src')+'"},';
		      }
		    }
			var lpos=deletedata.lastIndexOf(',');
			deletedata='['+deletedata.substr(0,lpos)+']';
			$.ajax({
				type: "POST",
				url: dourl,
				dataType:'json',
				data: "deletedata="+deletedata+'&page='+page,
				success: function(data){
				  if(data){
					  for(i=0;i<data.len;i++){
						  $("#r"+data[i].id).remove();
					  }
					  var boxlength2=$("input[name='imagebox']").length;
					  if(boxlength2==0&&data.page==page){
						  location=location;
					  }else if(boxlength2==0&&data.page!=page&&data.page){
						  location.href=location.href.substr(0,mpos)+'listbycategory/'+data.category_id+'/'+data.page+'#note';
					  }else if(boxlength2==0&&!data.page){
						  location.href=location.href.substr(0,mpos)+'listbycategory/'+data.category_id+'#note';
					  }
					  $("#pagination").html(data.newpagination);
				  }else{
				  return false;	
				  }	
			   }
			});
			$("#image_apply_button").attr('disabled',false);
		 }else{
			 return false;
		 }
	 }
	});})
	
jQuery(function(){
	$("#go_on_upload").click(function(){
		 var mpos=location.href.indexOf('addimginfo');
		 var dourl=location.href.substr(0,mpos)+'upload';
	     location.href=dourl;
	})
})

function add_imgcategory(url){
	   var categoryname=$.trim($("input[name='newimgcategory']").val());
	   $("#imgcategoryremind").fadeIn("slow");
	   if(!$.trim(categoryname)){
		   $("#imgcategoryremind").addClass('input-notification error png_bg');
		   $("#imgcategoryremind").html('分类名称不能为空');
		   $("#newcategory").focus();
	       return false;
	   }else if(categoryname.length>20){
		   $("#imgcategoryremind").addClass('input-notification error png_bg');
		   $("#imgcategoryremind").html('分类名称不能超过20个字符');
		   $("#newimgcategory").focus();
		   return false;
	   }else{
		 $.post(url, {categoryname:categoryname},function(data){
			  if(data=='success'){
				  $("#imgcategoryremind").removeClass('input-notification error png_bg');
				  $("#imgcategoryremind").addClass('input-notification success png_bg');
				  $("#imgcategoryremind").html('分类添加成功');
				  $("#imgcategoryremind").fadeOut("slow"); 
			  }else if(data=='repeat'){
				  $("#imgcategoryremind").removeClass('input-notification success png_bg');
				  $("#imgcategoryremind").addClass('input-notification error png_bg');
				  $("#imgcategoryremind").html('请不要重复添加');
			  }else{
				  $("#imgcategoryremind").removeClass('input-notification success png_bg');
				  $("#imgcategoryremind").addClass('input-notification error png_bg');
				  $("#imgcategoryremind").html(data);
			  }
	   });
		   return false;
	  }
}

jQuery(function(){
	$("#newimgcategory").keyup(function(){
		categoryname=$.trim($("input[name='newimgcategory']").val());
	  if(categoryname&&categoryname.length<=20){
		  $("#imgcategoryremind").removeClass('input-notification error png_bg');
		  $("#imgcategoryremind").addClass('input-notification success png_bg');
		  $("#imgcategoryremind").html(' ');
	  }else if(categoryname.length>20){
		  $("#imgcategoryremind").removeClass('input-notification success png_bg');
		  $("#imgcategoryremind").addClass('input-notification error png_bg');
		  $("#imgcategoryremind").html('分类名称不能超过20个字符');
	  }
	});})

	jQuery(function(){
	$("#newimgcategory").blur(function(){
		categoryname=$.trim($("input[name='newimgcategory']").val());
	  if(categoryname&&categoryname.length<=20){
		  $("#imgcategoryremind").removeClass('input-notification error png_bg');
		  $("#imgcategoryremind").addClass('input-notification success png_bg');
		  $("#imgcategoryremind").html(' ');
	  }else if(categoryname.length>20){
		  $("#imgcategoryremind").removeClass('input-notification success png_bg');
		  $("#imgcategoryremind").addClass('input-notification error png_bg');
		  $("#imgcategoryremind").html('分类名称不能超过20个字符');
	  }
	});})

function show_imgcategory_edit(id){
	var name=$("#n"+id).html();
	$('#tn'+id).html('<input type="text" value="'+name+'" name="imgcategoryname'+id+'" id="imgcategoryname'+id+'">');
}

function apply_imgcategory_edit(id,dourl){
	var newcategoryname=$("#imgcategoryname"+id).val();
    if(!$("#imgcategoryname"+id).is("input")){
		alert('分类名称未修改');
        return;
	}else if(!$.trim(newcategoryname)){
		alert('分类名称不能为空');
		$("#imgcategoryname"+id).focus();
		return;
	}else if($.trim(newcategoryname).length>20){
		alert('分类名称不能超过20个字符');
		$("#imgcategoryname"+id).focus();
		return;
	   }
	var checkedlength=$("input[name='imgcategorybox']:checked").length;
	$.ajax({
		type: "POST",
		url: dourl,
		dataType:'json',
		data: "id="+id+"&newcategoryname="+newcategoryname,
		success: function(data){
		if(data){
		$('#tn'+id).html(data.name);	
		}else{
			return;
		}
		}
		});
	$("#imgcategorybox"+id).attr('checked',false);
	if(!checkedlength)$("#imgcategory_edit_button").css('visibility','hidden');
	$("#imgcategory_apply_button").attr('disabled',false);
}

function delete_imgcategory(id,dourl){
	if(confirm('你确定要删除吗，该操作不恢复')){
		 var mpos=location.href.indexOf('imgcategory');
		 var page=location.href.substr(mpos+12);
	     if(!$.trim(page))page=1;
			$.ajax({
				type: "POST",
				url: dourl,
				dataType:'json',
				data:"id="+id+'&page='+page,
				success: function(data){
				  if(data){
					  if(data.error){
						  alert('该分类下存在图片，请先删除图片');
						  return false;
					  }
					  $("#r"+id).remove();
					  var boxlength2=$("input[name='imgcategorybox']").length;
					  if(boxlength2==0&&data.page==page){
						  location=location;
					  }else if(boxlength2==0&&data.page!=page&&data.page){
						  location.href=location.href.substr(0,mpos)+'imgcategory/'+data.page+'#note';
					  }else if(boxlength2==0&&!data.page){
						  location.href=location.href.substr(0,mpos)+'imgcategory/#note';
					  }
					  $("#pagination").html(data.newpagination);
				  }else{
				  return false;	
				  }	
			   }
			});	
	}
}

jQuery(function(){
	$("#imgcategory_apply_button").click(function(){
	 var actionname=$("#applyname").val();
	 if(actionname=='none'){
		 $("#note").html('<span style="color:red">请选择一项操作！</span>');
		 return false;
	 }
	 var boxlength=$("input[name='imgcategorybox']").length;
	 var checkedlength=$("input[name='imgcategorybox']:checked").length;
	 if(!checkedlength){
		 $("#note").html('<span style="color:red">请勾选至少一个项目！</span>');
		 return false;
	 }
	 $("#note").html('<span style="color:red">睁大眼睛看仔细咯~！</span>');
	 if(actionname=='edit'){
		 for(var i=0;i<boxlength;i++){
			 if($("input[name='imgcategorybox']").eq(i).attr("checked")=='checked'){
				 var category_id=$("input[name='imgcategorybox']").eq(i).val();
				 show_category_edit(category_id); 
			 }	 
		 }
		 $("#imgcategory_apply_button").attr('disabled',true);
		 $("#imgcategory_edit_button").css('visibility','visible');
	 }else if(actionname=='delete'){
		 if(confirm('你确定要删除吗，该操作不可恢复')){
		 var mpos=location.href.indexOf('imgcategory');
		 var dourl=location.href.substr(0,mpos)+'deleteallcategory';
		 var boxlength=$("input[name='imgcategorybox']").length;
		 var page=location.href.substr(mpos+12);
		 if(!page)page=1;
		 var deletedata='';
			for(var i=0;i<boxlength;i++){
			  if($("input[name='imgcategorybox']").eq(i).attr("checked")=='checked'){
				category_id=$("input[name='imgcategorybox']").eq(i).val();
				deletedata +='{"id": "'+$("input[name='imgcategorybox']").eq(i).val()+'"},';
		      }
		    }
			var lpos=deletedata.lastIndexOf(',');
			deletedata='['+deletedata.substr(0,lpos)+']';
			$.ajax({
				type: "POST",
				url: dourl,
				dataType:'json',
				data: "deletedata="+deletedata+'&page='+page,
				success: function(data){
				  if(data){
					  for(i=0;i<data.len;i++){
						  if(data[i])
						  $("#r"+data[i].id).remove();
					  }
					  if(data.error){
						  alert('有个'+data.error+'分类未删除，该分类存在图片，请先删除图片');
					  }
					  var boxlength2=$("input[name='imgcategorybox']").length;
					  if(boxlength2==0&&data.page==page){
						  location=location;
					  }else if(boxlength2==0&&data.page!=page){
						  location.href=location.href.substr(0,mpos)+'imgcategory/'+data.page+'#note';
					  }else if(boxlength2==0&&!data.page){
						  location.href=location.href.substr(0,mpos)+'imgcategory/#note';
					  }
					  $("#pagination").html(data.newpagination);
				  }else{
				  return false;	
				  }	
			   }
			});
			$("#imgcategory_apply_button").attr('disabled',false);
		 }else{
			 return false;
		 }
	 }
	});})

function edit_all_imgcategory(dourl){
    var boxlength=$("input[name='imgcategorybox']").length;
    var editdata='';
	for(var i=0;i<boxlength;i++){
	  if($("input[name='imgcategorybox']").eq(i).attr("checked")=='checked'){
		category_id=$("input[name='imgcategorybox']").eq(i).val();
		editdata +='{"id": "'+$("input[name='imgcategorybox']").eq(i).val()+'","name": "'+$("#categoryname"+category_id).val()+'"},';
      }
    }
	var lpos=editdata.lastIndexOf(',');
	editdata='['+editdata.substr(0,lpos)+']';
	$.ajax({
		type: "POST",
		url: dourl,
		dataType:'json',
		data: "editdata="+editdata,
		success: function(data){
		  if(data){
		  for(i=0;i<data.len;i++){
			  $('#tn'+data[i].id).html(data[i].name); 
		  }	  
		  }else{
		  return false;	
		  }	
	   }
	});
	$("#imgcategory_edit_button").css('visibility','hidden');
	$("#imgcategory_apply_button").attr('disabled',false);
}

jQuery(function(){
	$("#autotag").change(function(){
	  var tagname=$.trim($("#autotag").val());
	  var article_tag=$.trim($("#article_tag").val());
	  if(tagname&&article_tag.indexOf(tagname)=='-1')
		  {
		  if(article_tag)
		  $("#article_tag").val(article_tag+' '+tagname);
		  else
		  $("#article_tag").val(tagname);  
		  $("#articletagremind").removeClass('input-notification error png_bg');
		  $("#articletagremind").addClass('input-notification success png_bg');
		  $("#articletagremind").html(' ');
		  }
	  else
		  {
		  $("#article_tag").focus();
		  }
	});
})