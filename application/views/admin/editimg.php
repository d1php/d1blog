
			<div class="clear"></div> <!-- End .clear -->
			
			<div class="content-box"><!-- Start Content Box -->
				
				<div class="content-box-header">
					
					<h3>编辑图片</h3>
					
					<div class="clear"></div>
					
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
					
					<div>
					
						<form action="<?php echo site_url('admin/image/doedit/'.$img_id);?>" method="post" onsubmit="return check_editimgform('<?php echo $img_id;?>');">
							
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->							
							<?php if($img_detail):?>
							<?php foreach ($img_detail as $value):?>
							<p><img src="<?php echo site_url($value->img_url);?>" width="80" height="80"/>             </p>
							<p>
									<label>选择图片分类</label>              
									<select id="img_category" name="img_category" class="small-input"> 
									<?php if($category):?>
									    <option value="0">请选择图片分类</option>    
									<?php foreach ($category as $cat_value):?>
										<option value="<?php echo $cat_value->id;?>" <?php if($value->img_category_id==$cat_value->id):?>selected='selected'<?php endif;?>><?php echo html_escape($cat_value->image_category_name);?></option>
									<?php endforeach;?>
									<?php else:?>
									    <option value="0">当前没有分类</option>   
									<?php endif;?>
									</select> 
							</p>
							<p>
							<label>图片描述</label>
							<textarea id="img_description_<?php echo $value->id;?>" name="img_description_<?php echo $value->id;?>" style="width:25px;height:50px"rows="5" cols="79"><?php echo html_escape($value->img_description);?></textarea>
							</p>																
							<?php endforeach;?>
							<?php endif;?>
							<input type="submit" value="编辑" class="button"/>	
							</fieldset>
							
							<div class="clear"></div><!-- End .clear -->
						</form>
					</div> <!-- End #tab2 -->        
					
				</div> <!-- End .content-box-content -->
				
			</div> <!-- End .content-box -->

			<div class="clear"></div>