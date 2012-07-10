
			<div class="clear"></div> <!-- End .clear -->
			
			<div class="content-box"><!-- Start Content Box -->
				
				<div class="content-box-header">
					
					<h3>Content box</h3>
					
					<div class="clear"></div>
					
				</div> <!-- End .content-box-header -->
				
				<div class="content-box-content">
					
					<div>
						<form action="<?php echo site_url('admin/article/doedit/'.$post_detail->id);?>" method="post" onsubmit="return check_postform();">
							
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
								
								<p>
									<label>文章标题</label>
										<input class="text-input small-input" type="text" id="article_title" name="article_title" value="<?php echo html_escape($post_detail->post_title);?>"/> <span id="articletitleremind"></span> <!-- Classes for input-notification: success, error, information, attention -->
										<br /><small>在此填写文章标题</small>
								</p>
								
								<p>
									<label>选择文章分类</label>              
									<select name="category_dropdown" class="small-input">
									    
									<?php if($category):?>
									    <option value="0">请选择文章分类</option>    
									<?php foreach ($category as $value):?>
										<option value="<?php echo $value->id;?>" <?php if($post_detail->post_category_id==$value->id)echo 'selected';?>><?php echo html_escape($value->blog_category_name);?></option>
									<?php endforeach;?>
									<?php else:?>
									    <option value="0">当前没有分类</option>   
									<?php endif;?>
									</select> 
								</p>								
								<p>
									<label>填写文章标签，多个标签之间用空格隔开</label>
									<input class="text-input medium-input datepicker" type="text" id="article_tag" name="article_tag" value="<?php echo $post_tag;?>"/>
									<?php if($tag):?>
									<select id="autotag">
									<option value=''>选择标签</option>
									<?php foreach ($tag as $value):?>
									<option value="<?php echo $value->blog_tag_name;?>"><?php echo $value->blog_tag_name;?></option>
									<?php endforeach;?>
									</select>
									<?php endif;?>
									<span id="articletagremind"></span>
								</p>
								
								<p>
									<input type="checkbox" name="sethead" <?php if($post_detail->set_head)echo 'checked=checked';?>/>置顶
								</p>
								<p>
									<label>文章内容</label>
									 <div id="EditorBody" type="text/plain"></div><span id="articlecontentremind"></span>
								</p>
								
								<p>
									<input class="button" type="submit" value="更新" />
								</p>
								
							</fieldset>
							
							<div class="clear"></div><!-- End .clear -->
							
						</form>
<script type="text/javascript" src="<?php echo site_url('css/common/ueditor.js?random='.rand(0,999));?>"></script>
<script>
editor.setContent('<?php echo $post_detail->post_content;?>');
</script>
					</div> <!-- End #tab2 -->        
					
				</div> <!-- End .content-box-content -->
				
			</div> <!-- End .content-box -->

			<div class="clear"></div>