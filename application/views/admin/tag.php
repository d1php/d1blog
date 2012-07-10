
			<div class="clear"></div> <!-- End .clear -->
			
			<div class="content-box"><!-- Start Content Box -->
				
				<div class="content-box-header">
					
					<h3>标签管理</h3>
					
					<ul class="content-box-tabs">
						<li><a href="#tab1" class="default-tab">标签列表</a></li> <!-- href must be unique and match the id of target div -->
					</ul>
					
					<div class="clear"></div>
					
				</div> <!-- End .content-box-header -->
				
				<div class="content-box-content">
					
					<div class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->
						
						<div class="notification attention png_bg">
							<a href="#" class="close"><?php echo img(array('css/admin/images/icons/cross_grey_small.png','title'=>'关闭提示','alt'=>'关闭'))?></a>
							<div id="note">
你可以在这里管理文章的标签，点击右上角的图标可以关闭该提示。								
							</div>
						</div>
						
						<table>
							
							<thead>
								<tr>
								   <th><input class="check-all" type="checkbox" id="check-all"/></th>
								   <th>标签id</th>
								   <th>标签名称</th>
								   <th>标签文章数量</th>
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
											<input type="button" class="button" value="应用" id="tag_apply_button"><input type="button" class="button" style="visibility:hidden" value="提交修改" id="tag_edit_button" onclick="edit_all_tag('<?php echo site_url().'admin/article/editalltag';?>')">
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
							if($tag):
							foreach ($tag as $key=>$value):?>
								<tr id="r<?php echo $value->id;?>">
									<td><input type="checkbox" name="tagbox" value="<?php echo $value->id;?>" id="tagbox<?php echo $value->id;?>"/></td>
									<td id="c<?php echo $value->id;?>"><?php echo $value->id;?></td>
									<td id="tn<?php echo $value->id;?>"><a href="<?php echo site_url('admin/article/listbytag/'.$value->id);?>" title="查看'<?php echo $value->blog_tag_name;?>'标签下的文章" id="n<?php echo $value->id;?>"><?php echo $value->blog_tag_name;?></a></td>
									<td id="d<?php echo $value->id;?>"><?php echo $value->article_num;?></td>
									<td>
										<!-- Icons -->
										 <a href="javascript:show_tag_edit('<?php echo $value->id;?>')" title="编辑"><?php echo img(array("css/admin/images/icons/pencil.png",'alt'=>"编辑"));?></a>
										 <a href="javascript:delete_tag('<?php echo $value->id;?>','<?php echo site_url().'admin/article/deletetag';?>')" title="删除" id="del<?php echo $value->id;?>"><?php echo img(array("css/admin/images/icons/cross.png",'alt'=>"删除"));?></a>
										 <a href="javascript:apply_tag_edit('<?php echo $value->id;?>','<?php echo site_url().'admin/article/edittag'?>')" title="应用修改" id="apply_edit_row<?php echo $value->id;?>"><?php echo img(array("css/admin/images/icons/hammer_screwdriver.png",'alt'=>"应用修改"));?></a> 
									</td>
								</tr>
							<?php endforeach;?>
							<?php endif;?>	
							</tbody>
							
						</table>
						
					</div> <!-- End #tab1 -->
					
				</div> <!-- End .content-box-content -->
				
			</div> <!-- End .content-box -->
	
			<div class="clear"></div>