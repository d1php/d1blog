
			<div class="clear"></div> <!-- End .clear -->
			
			<div class="content-box"><!-- Start Content Box -->
				
				<div class="content-box-header">
					
					<h3>文章管理</h3>
					
					<ul class="content-box-tabs">
						<li><a href="#tab1" class="default-tab">文章列表</a></li> <!-- href must be unique and match the id of target div -->
					</ul>
					
					<div class="clear"></div>
					
				</div> <!-- End .content-box-header -->
				
				<div class="content-box-content">
					
					<div class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->
						
						<div class="notification attention png_bg">
							<a href="#" class="close"><?php echo img(array('css/admin/images/icons/cross_grey_small.png','title'=>'关闭提示','alt'=>'关闭'))?></a>
							<div id="note">
你可以在这里管理图片，点击右上角的图标可以关闭该提示。								
							</div>
						</div>
						
						<table>
							
							<thead>
								<tr>
								   <th><input class="check-all" type="checkbox" id="check-all"/></th>
								   <th>图片id</th>
								   <th>查看原图</th>
								   <th>图片描述</th>
								   <th>图片分类</th>
								   <th>上传时间</th>
								   <th>操作</th>
								</tr>
								
							</thead>
						 
							<tfoot>
								<tr>
									<td colspan="6">
										<div class="bulk-actions align-left">
											<select name="applyname" id="applyname">
												<option value="none">选择操作...</option>
												<option value="delete">删除</option>
											</select>
											<input type="button" class="button" value="应用" id="image_category_apply_button">
										</div>
				
										<div class="pagination" id="pagination">
										<?php echo $pagination;?>
										</div> <!-- End .pagination -->
										<div class="clear"></div>
									</td>
								</tr>
							</tfoot>
							<tbody id="liststr">
							<?php 
							if($imagelist):
							foreach ($imagelist as $key=>$value):?>
								<tr id="r<?php echo $value->id;?>">
									<td><input type="checkbox" name="imagebox" value="<?php echo $value->id;?>" id="imagebox<?php echo $value->id;?>"/></td>
									<td id="c<?php echo $value->id;?>"><?php echo $value->id;?></td>
									<td><a href="#img_<?php echo $value->id?>" rel="modal">查看原图</a></td>
                                    <td id="tn<?php echo $value->id;?>"><?php echo $value->img_description?nl2br(html_escape($value->img_description)):'暂无描述';?></td>
									<td id="d<?php echo $value->id;?>"><a href="<?php echo site_url('admin/image/listbycategory/'.$value->img_category_id);?>"><?php echo $value->image_category_name;?></a></td>
									<td><?php echo $value->img_upload_time;?></td>
									<td>
										<!-- Icons -->
										 <a href="<?php echo site_url('admin/image/edit/'.$value->id);?>" title="编辑"><?php echo img(array("css/admin/images/icons/pencil.png",'alt'=>"编辑"));?></a>
										 <a href="javascript:delete_image_bycategory('<?php echo $value->id;?>','<?php echo site_url().'admin/image/delete_img_bycategory';?>','<?php echo $value->img_url;?>')" title="删除" id="del<?php echo $value->id;?>"><?php echo img(array("css/admin/images/icons/cross.png",'alt'=>"删除"));?></a> 
									</td>
									<td id="img_<?php echo $value->id;?>" style="display:none"><img src="<?php echo site_url($value->img_url);?>" id="img_src_<?php echo $value->id;?>"/></td>
								</tr>
							<?php endforeach;?>
							<?php endif;?>	
							</tbody>
							
						</table>
						
					</div> <!-- End #tab1 -->
					
				</div> <!-- End .content-box-content -->
				
			</div> <!-- End .content-box -->

			<div class="clear"></div>