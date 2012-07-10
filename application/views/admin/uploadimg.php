
			<div class="clear"></div> <!-- End .clear -->
			
			<div class="content-box"><!-- Start Content Box -->
				
				<div class="content-box-header">
					
					<h3>图片上传</h3>
					
					<div class="clear"></div>
					
				</div> <!-- End .content-box-header -->
<script type="text/javascript">
var img_id_upload=new Array();
var i=0;
$(function() {
    $('#file_upload').uploadify({
    	'auto'     : false,
    	'removeTimeout' : 1,
        'swf'      : '<?php echo site_url('css/uploadify/uploadify.swf');?>',
        'uploader' : '<?php echo site_url('admin/image/doupload');?>',
        'method'   : 'post',
        'buttonText' : '选择图片',
        'multi'    : true,
        'uploadLimit' : 10,
        'fileTypeDesc' : 'Image Files',
        'fileTypeExts' : '*.gif; *.jpg; *.png',
        'fileSizeLimit' : '200KB', 
        'onUploadSuccess' : function(file, data, response) {
            if(isNaN(data)){
               alert(data);
            }else{
               img_id_upload[i]=data;
               i++;
            }
        },
        'onQueueComplete' : function(queueData) {
            if(img_id_upload.length>0)
            location.href="<?php echo site_url('admin/image/addimginfo/');?>"+"/"+encodeURIComponent(img_id_upload);
        }
        // Put your options here
    });
});
</script>
				<div class="content-box-content">
					
					<div>
					
						<form action="<?php echo site_url('admin/image/doupload');?>" method="post">
							
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
								<p>
								<input type="file" name="file_upload" id="file_upload" /><small>同名文件将被覆盖</small>
								</p>								
								<p>
									<label>选择图片分类</label>              
									<select id="img_category" name="img_category" class="small-input"> 
									<?php if($category):?>
									    <option value="0">请选择图片分类</option>    
									<?php foreach ($category as $value):?>
										<option value="<?php echo $value->id;?>"><?php echo html_escape($value->image_category_name);?></option>
									<?php endforeach;?>
									<?php else:?>
									    <option value="0">当前没有分类</option>   
									<?php endif;?>
									</select> 
								</p>															
								<p><a href="javascript:check_imgcategory();">上传</a>
								<a href="javascript:$('#file_upload').uploadify('cancel','*')">重置上传队列</a> 
								</p>
								
							</fieldset>
							
							<div class="clear"></div><!-- End .clear -->
						</form>
					</div> <!-- End #tab2 -->        
					
				</div> <!-- End .content-box-content -->
				
			</div> <!-- End .content-box -->
	
			<div class="clear"></div>