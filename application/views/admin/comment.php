
			<div class="clear"></div> <!-- End .clear -->
			
			<div class="content-box"><!-- Start Content Box -->
				
				<div class="content-box-header">
					
					<h3>查看评论</h3>
					
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
你可以在这里管理文章的分类，点击右上角的图标可以关闭该提示。								
							</div>
						</div>
						
						<table>
							
							<thead>
								<tr>
								   <th><input class="check-all" type="checkbox" id="check-all"/></th>
								   <th>评论id</th>
								   <th>评论者</th>
								   <th>评论内容</th>
								   <th>评论时间</th>
								   <th>来自文章</th>
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
											<input type="button" class="button" value="应用" id="comment_apply_button">
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
							if($comment):
							foreach ($comment as $key=>$value):?>
								<tr id="r<?php echo $value->id;?>">
									<td><input type="checkbox" name="commentbox" value="<?php echo $value->id;?>" id="commentbox<?php echo $value->id;?>"/></td>
									<td id="c<?php echo $value->id;?>"><?php echo $value->id;?></td>
									<td><?php echo $value->post_author;?></td>
									<td id="tn<?php echo $value->id;?>"><a href="<?php echo site_url('admin/article/editcomment/'.$value->id);?>" title="编辑'<?php echo $value->comment_content;?>'" id="n<?php echo $value->id;?>"><?php echo mb_strlen($value->comment_content,'utf-8')>20?mb_substr(nl2br($value->comment_content),0,20,'utf-8').'...':nl2br($value->comment_content);?></a></td>
									<td id="d<?php echo $value->id;?>"><?php echo $value->comment_time;?></td>
									<td><?php if($value->post_id):?><a href="<?php echo site_url('article/view/'.$value->post_id);?>" title="查看'<?php echo $value->post_title;?>'" id="a<?php echo $value->id;?>" target="_blank"><?php echo mb_strlen($value->post_title,'utf-8')>20?mb_substr($value->post_title,0,20,'utf-8').'...':$value->post_title;?></a><?php else:?><a href="<?php echo site_url('contact');?>">联系我们</a><?php endif;?></td>
									<td>
										<!-- Icons -->
										 <a href="<?php echo site_url('admin/article/editcomment/'.$value->id);?>" title="编辑"><?php echo img(array("css/admin/images/icons/pencil.png",'alt'=>"编辑"));?></a>
										 <a href="javascript:delete_comment('<?php echo $value->id;?>','<?php echo site_url().'admin/article/deletecomment';?>')" title="删除" id="del<?php echo $value->id;?>"><?php echo img(array("css/admin/images/icons/cross.png",'alt'=>"删除"));?></a> 
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