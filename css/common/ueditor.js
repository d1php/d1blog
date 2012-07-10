    var editor = new baidu.editor.ui.Editor({
        textarea:'article_content',
        minFrameHeight:200,
        autoFloatEnabled: false,
        relativePath:true
        });

    editor.render("EditorBody");
    function check_postform(){
    	   var article_title=$("input[name='article_title']").val();
    	   var article_tag=$("input[name='article_tag']").val();
    	   if($.trim(article_tag)){
    	  	     var tagarr=article_tag.split(' ');
               for(var i in tagarr){
                   if($.trim(tagarr[i]).length>10){
            		   $("#articletagremind").addClass('input-notification error png_bg');
            		   $("#articletagremind").html('单个标签不能超过10个字符');
            		   $("#article_tag").focus();
                	   return false;
                       }
               }
    	   }
    	   if(!$.trim(article_title)){
    		   $("#articletitleremind").removeClass('input-notification success png_bg');
    		   $("#articletitleremind").addClass('input-notification error png_bg');
    		   $("#articletitleremind").html('标题不能为空');
    		   $("#article_title").focus();
    	       return false;
    	   }else if(article_title.length>30){
    		   $("#articletitleremind").addClass('input-notification error png_bg');
    		   $("#articletitleremind").html('标题不能超过30个字符');
    		   $("#article_title").focus();
      	   return false;
    	  	   }else if(!editor.hasContents()){
               editor.setContent('写点什么吧~');
               editor.focus();
    	       return false;
    	   }
   }


    jQuery(function(){
    	$("#article_title").keyup(function(){
    	  var article_title=$.trim($("input[name='article_title']").val());
    	  if(article_title&&article_title.length<=30){
    		  $("#articletitleremind").removeClass('input-notification error png_bg');
    		  $("#articletitleremind").addClass('input-notification success png_bg');
    		  $("#articletitleremind").html('&nbsp;');
    	  }else if(article_title.length>30){
    		  $("#articletitleremind").removeClass('input-notification success png_bg');
    		  $("#articletitleremind").addClass('input-notification error png_bg');
    		  $("#articletitleremind").html('标题不能超过30个字符');
    	  }
    	});})
    	
    jQuery(function(){
    	$("#article_tag").keyup(function(){
    	  var article_tag=$.trim($("input[name='article_tag']").val());
     	  if(article_tag){
        	   var tagarr=article_tag.split(' ');
               for(var i in tagarr){
                   if($.trim(tagarr[i]).length>10){
             		   $("#articletagremind").removeClass('input-notification success png_bg');
            		   $("#articletagremind").addClass('input-notification error png_bg');
            		   $("#articletagremind").html('单个标签不能超过10个字符');
            		   return false;
                       }else{
                 	   $("#articletagremind").removeClass('input-notification error png_bg');
                	   $("#articletagremind").addClass('input-notification success png_bg');
                	   $("#articletagremind").html('&nbsp;');   
                       }
               }
    	   }else{
         	   $("#articletagremind").removeClass('input-notification error png_bg');
         	   $("#articletagremind").removeClass('input-notification success png_bg');
        	   $("#articletagremind").html('&nbsp;');     
    	   }
    	});})