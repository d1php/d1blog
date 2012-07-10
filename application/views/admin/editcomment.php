
			<div class="clear"></div> <!-- End .clear -->
			
			<div class="content-box"><!-- Start Content Box -->
				
				<div class="content-box-header">
					
					<h3>修改留言</h3>
					
					<div class="clear"></div>
					
				</div> <!-- End .content-box-header -->
				
				<div class="content-box-content">
					
					<div>
					
						<form action="<?php echo site_url('admin/article/doeditcomment/'.$comment->id);?>" method="post" onsubmit="return check_commentform();">
							
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
								
								<p>
									<label>姓名</label>
										<input class="text-input small-input" type="text" id="usrname" name="usrname" value="<?php echo $comment->post_author;?>"/>
										<br />
								</p>
								
								<p>
									<label>电子邮件</label>              
                                        <input class="text-input small-input" type="text" id="email" name="email" value="<?php echo $comment->comment_email;?>"/>
										<br />
								</p>								
								<p>
									<label>个人主页</label>
									<input class="text-input medium-input datepicker" type="text" id="website" name="website" value="<?php echo $comment->comment_url;?>"/>
								</p>
								
								<p>
								    <label>留言内容</label>
									<textarea id="message" name="message" rows="8" cols="50"><?php echo $comment->comment_content;?></textarea>
								</p>
								<p>
									<input class="button" type="submit" value="修改" />
								</p>
								
							</fieldset>
							
							<div class="clear"></div><!-- End .clear -->
							
						</form>
					</div> <!-- End #tab2 -->        
					
				</div> <!-- End .content-box-content -->
				
			</div> <!-- End .content-box -->

			<div class="clear"></div>