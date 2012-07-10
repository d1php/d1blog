
			<div class="clear"></div> <!-- End .clear -->
			
			<div class="content-box"><!-- Start Content Box -->
				
				<div class="content-box-header">
					
					<h3>添加链接</h3>
					
					<div class="clear"></div>
					
				</div> <!-- End .content-box-header -->
				
				<div class="content-box-content">
					
					<div>
						<form action="<?php echo site_url('admin/flink/doadd');?>" method="post" onsubmit="return check_linkform();" id="link_form">
							
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
								
								<p>
									<label>链接名称</label>
										<input class="text-input small-input" type="text" id="link_name" name="link_name" /> <span id="linknameremind"></span> <!-- Classes for input-notification: success, error, information, attention -->
										<br /><small>在此填写链接名称</small>
								</p>								
								<p>
									<label>链接地址</label>
										<input class="text-input small-input" type="text" id="link_url" name="link_url" /> <span id="linkurlremind"></span> <!-- Classes for input-notification: success, error, information, attention -->
										<br /><small>在此填写链接地址</small>
								</p>
																<p>
									<label>链接描述</label>
										<input class="text-input small-input" type="text" id="link_description" name="link_description" />
										<br /><small>在此填写链接地址</small>
								</p>
								<p>
									<label>链接email</label>
										<input class="text-input small-input" type="text" id="link_email" name="link_email" /><span id="linkemailremind"></span>
										<br /><small>在此填写链接email</small>
								</p>
																
								<p>
									<input type="checkbox" name="link_status" value="1" checked/>默认显示
								</p>
								<p>
									<input class="button" type="submit" value="发布" />
								</p>
								
							</fieldset>
							
							<div class="clear"></div><!-- End .clear -->
							
						</form>
					</div> <!-- End #tab2 -->        
					
				</div> <!-- End .content-box-content -->
				
			</div> <!-- End .content-box -->

			<div class="clear"></div>