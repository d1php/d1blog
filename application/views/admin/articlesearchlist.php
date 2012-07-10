
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
你可以在这里管理文章，点击右上角的图标可以关闭该提示。								
							</div>
						</div>
						      <div style="text-align:right">
        <form id="formsearch" name="formsearch" method="get" action="<?php echo site_url('admin/article/find');?>">
        <span><input name="w" class="editbox_search" id="w" maxlength="80" type="text" value="<?php if(isset($w))echo urldecode($w);?>"/></span><input name="button_search" type="submit" value="搜索文章" />
        </form>
      </div>
						<table>
							
							<thead>
								<tr>
								   <th><input class="check-all" type="checkbox" id="check-all"/></th>
								   <th>文章id</th>
								   <th>文章标题</th>
								   <th>文章分类</th>
								   <th>发布时间</th>
								   <th>编辑时间</th>
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
											<input type="button" class="button" value="应用" id="articlesearch_apply_button">
										</div>
										
										<div class="pagination">
										<?php echo $pagination;?>
										</div> <!-- End .pagination -->
										<div class="clear"></div>
									</td>
								</tr>
							</tfoot>
						 
							<tbody>
							<?php 
							if($articlelist):
							foreach ($articlelist as $key=>$value):?>
								<tr id="r<?php echo $value->id;?>">
									<td><input type="checkbox" name="articlebox" value="<?php echo $value->id;?>" id="articlebox<?php echo $value->id;?>"/></td>
									<td id="c<?php echo $value->id;?>"><?php echo $value->id;?></td>
									<td id="tn<?php echo $value->id;?>"><a href="<?php echo site_url('admin/article/edit/'.$value->id);?>" title="编辑'<?php echo $value->post_title;?>'" id="n<?php echo $value->id;?>"><?php echo $value->post_title;?></a></td>
									<td id="d<?php echo $value->id;?>"><?php echo $value->blog_category_name?'<a href="'.site_url('admin/artilce/listbycategory/'.$value->post_category_id).'" title="查看\''.$value->blog_category_name.'\'下的文章">'.$value->blog_category_name.'</a>':'暂无分类';?></td>
									<td><?php echo $value->post_time;?></td>
									<td><?php echo $value->post_editime;?></td>
									<td>
										<!-- Icons -->
										 <a href="<?php echo site_url('admin/article/edit/'.$value->id);?>" title="编辑"><?php echo img(array("css/admin/images/icons/pencil.png",'alt'=>"编辑"));?></a>
										 <a href="javascript:delete_articlesearch('<?php echo $value->id;?>','<?php echo $w;?>','<?php echo site_url().'admin/article/deletearticlesearch';?>')" title="删除" id="del<?php echo $value->id;?>"><?php echo img(array("css/admin/images/icons/cross.png",'alt'=>"删除"));?></a> 
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