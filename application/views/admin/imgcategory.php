
			<div class="clear"></div> <!-- End .clear -->
			
			<div class="content-box"><!-- Start Content Box -->
				
				<div class="content-box-header">
					
					<h3>图片分类管理</h3>
					
					<ul class="content-box-tabs">
						<li><a href="#tab1" class="default-tab">分类列表</a></li> <!-- href must be unique and match the id of target div -->
						<li><a href="#tab2">添加分类</a></li>
					</ul>
					
					<div class="clear"></div>
					
				</div> <!-- End .content-box-header -->
				
				<div class="content-box-content">
					
					<div class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->
						
						<div class="notification attention png_bg">
							<a href="#" class="close"><?php echo img(array('css/admin/images/icons/cross_grey_small.png','title'=>'关闭提示','alt'=>'关闭'))?></a>
							<div id="note">
你可以在这里管理文章的分类，点击右上角的图标可以关闭该提示。								
							</div>
						</div>
						
						<table>
							
							<thead>
								<tr>
								   <th><input class="check-all" type="checkbox" id="check-all"/></th>
								   <th>分类id</th>
								   <th>分类名称</th>
								   <th>分类图片数量</th>
								   <th>操作</th>
								</tr>
								
							</thead>
						 
							<tfoot>
								<tr>
									<td colspan="6">
										<div class="bulk-actions align-left">
											<select name="applyname" id="applyname">
												<option value="none">选择操作...</option>
												<option value="edit">编辑</option>
												<option value="delete">删除</option>
											</select>
											<input type="button" class="button" value="应用" id="imgcategory_apply_button"><input type="button" class="button" style="visibility:hidden" value="提交修改" id="imgcategory_edit_button" onclick="edit_all_imgcategory('<?php echo site_url().'admin/image/editallcategory';?>')">
										</div>
										
										<div class="pagination" id="pagination">
										<?php echo $pagination;?>
										</div> <!-- End .pagination -->
										<div class="clear"></div>
									</td>
								</tr>
							</tfoot>
						 
							<tbody>
							<?php 
							if($category):
							foreach ($category as $key=>$value):?>
								<tr id="r<?php echo $value->id;?>">
									<td><input type="checkbox" name="imgcategorybox" value="<?php echo $value->id;?>" id="imgcategorybox<?php echo $value->id;?>"/></td>
									<td id="c<?php echo $value->id;?>"><?php echo $value->id;?></td>
									<td id="tn<?php echo $value->id;?>"><a href="<?php echo site_url('admin/image/listbycategory/'.$value->id);?>" title="查看'<?php echo $value->image_category_name;?>'分类下的文章" id="n<?php echo $value->id;?>"><?php echo $value->image_category_name;?></a></td>
									<td><?php echo $value->img_num;?></td>
									<td>
										<!-- Icons -->
										 <a href="javascript:show_imgcategory_edit('<?php echo $value->id;?>')" title="编辑"><?php echo img(array("css/admin/images/icons/pencil.png",'alt'=>"编辑"));?></a>
										 <a href="javascript:delete_imgcategory('<?php echo $value->id;?>','<?php echo site_url().'admin/image/deletecategory';?>')" title="删除" id="del<?php echo $value->id;?>"><?php echo img(array("css/admin/images/icons/cross.png",'alt'=>"删除"));?></a>
										 <a href="javascript:apply_imgcategory_edit('<?php echo $value->id;?>','<?php echo site_url().'admin/image/editcategory'?>')" title="应用修改" id="apply_edit_row<?php echo $value->id;?>"><?php echo img(array("css/admin/images/icons/hammer_screwdriver.png",'alt'=>"应用修改"));?></a> 
									</td>
								</tr>
							<?php endforeach;?>
							<?php endif;?>	
							</tbody>
							
						</table>
						
					</div> <!-- End #tab1 -->
					
					<div class="tab-content" id="tab2">
					
						<form action="#" method="post" onsubmit="return add_imgcategory('<?php echo site_url().'admin/image/addcategory';?>');">
							
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
								
								<p>
									<label>分类名称</label>
										<input class="text-input small-input" type="text" id="newimgcategory" name="newimgcategory" /><span id="imgcategoryremind"></span><!-- Classes for input-notification: success, error, information, attention -->
										<br /><small>在此填写文章分类</small>
								</p>
								<p>
									<input class="button" type="submit" value="新增分类" />
								</p>
								
							</fieldset>
							
							<div class="clear"></div><!-- End .clear -->
							
						</form>
						
					</div> <!-- End #tab2 -->        
					
				</div> <!-- End .content-box-content -->
				
			</div> <!-- End .content-box -->
			
			<div class="clear"></div>