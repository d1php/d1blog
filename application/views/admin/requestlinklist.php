
			<div class="clear"></div> <!-- End .clear -->
			
			<div class="content-box"><!-- Start Content Box -->
				
				<div class="content-box-header">
					
					<h3>审核链接</h3>
					
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
你可以在这里管理友情链接，点击右上角的图标可以关闭该提示。								
							</div>
						</div>
						
						<table>
							
							<thead>
								<tr>
								   <th><input class="check-all" type="checkbox" id="check-all"/></th>
								   <th>链接id</th>
								   <th>链接名称</th>
								   <th>链接地址</th>
								   <th>链接描述</th>
								   <th>链接email</th>
								   <th>链接状态</th>
								   <th>操作</th>
								</tr>
								
							</thead>
						 
							<tfoot>
								<tr>
									<td colspan="6">
										<div class="bulk-actions align-left">
											<select name="applyname" id="applyname">
												<option value="none">选择操作...</option>
												<option value="edit">通过审核</option>
												<option value="delete">删除</option>
											</select>
											<input type="button" class="button" value="应用" id="requestlink_apply_button">
										</div>
										
										<div class="pagination">
										</div> <!-- End .pagination -->
										<div class="clear"></div>
									</td>
								</tr>
							</tfoot>
						 
							<tbody>
							<?php 
							if($linklist):
							foreach ($linklist as $key=>$value):?>
								<tr id="r<?php echo $value->id;?>">
									<td><input type="checkbox" name="requestlinkbox" value="<?php echo $value->id;?>" id="linkbox<?php echo $value->id;?>"/></td>
									<td id="c<?php echo $value->id;?>"><?php echo $value->id;?></td>
									<td id="tn<?php echo $value->id;?>"><a href="<?php echo $value->link_url;?>" title="访问该链接" id="n<?php echo $value->id;?>" target="_blank"><?php echo $value->link_name;?></a></td>
									<td id="u<?php echo $value->id;?>"><?php echo $value->link_url;?></td>
									<td id="d<?php echo $value->id;?>"><?php echo $value->link_description?$value->link_description:'暂无描述';?></td>
									<td id="re<?php echo $value->id;?>"><?php echo $value->link_email?'<a href="mailto:'.$value->link_email.'" title="邮件通知对方" id="e'.$value->id.'">'.$value->link_email.'</a>':'无';?></td>
									<td id="s<?php echo $value->id;?>"><?php if($value->link_status)echo '可见';else echo '不可见';?></td>
									<td>
										<!-- Icons -->
										 <a href="javascript:show_requestlink('<?php echo $value->id;?>','<?php echo $value->link_email;?>','<?php echo site_url('admin/flink/showlink');?>')" title="通过"><?php echo img(array("css/admin/images/icons/pencil.png",'alt'=>"通过"));?></a>
										 <a href="javascript:delete_requestlink('<?php echo $value->id;?>','<?php echo site_url().'admin/flink/deleterequestlink';?>')" title="删除" id="del<?php echo $value->id;?>"><?php echo img(array("css/admin/images/icons/cross.png",'alt'=>"删除"));?></a>  
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