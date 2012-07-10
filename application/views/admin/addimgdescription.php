
			<div class="clear"></div> <!-- End .clear -->
			
			<div class="content-box"><!-- Start Content Box -->
				
				<div class="content-box-header">
					
					<h3>添加图片描述</h3>
					
					<div class="clear"></div>
					
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
					
					<div>
					
						<form action="<?php echo site_url('admin/image/save/'.$img_id);?>" method="post" onsubmit="return check_imginfoform('<?php echo $img_id;?>');">
							
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->							
							<?php if($img_detail):?>
							<?php foreach ($img_detail as $value):?>
							<p><img src="<?php echo site_url($value->img_url);?>" width="80" height="80"/>             </p>
							<p>
							<label>添加图片描述</label>
							<textarea id="img_description_<?php echo $value->id;?>" name="img_description_<?php echo $value->id;?>" style="width:25px;height:50px"rows="5" cols="79"></textarea>
							</p>																
							<?php endforeach;?>
							<?php endif;?>
							<input type="submit" value="保存并返回图片列表" class="button"/>	<input type="button" value="继续上传" class="button" id="go_on_upload"/>
							</fieldset>
							
							<div class="clear"></div><!-- End .clear -->
						</form>
					</div> <!-- End #tab2 -->        
					
				</div> <!-- End .content-box-content -->
				
			</div> <!-- End .content-box -->

			<div class="clear"></div>