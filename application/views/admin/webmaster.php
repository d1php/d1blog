
			<div class="clear"></div> <!-- End .clear -->
			
			<div class="content-box"><!-- Start Content Box -->
				
				<div class="content-box-header">
					
					<h3>管理员信息</h3>
					
					<div class="clear"></div>
					
				</div> <!-- End .content-box-header -->
				
				<div class="content-box-content">
					
					<div>
					
						<form action="<?php echo site_url('admin/webmaster/doadd');?>" method="post" onsubmit="return check_webmasterform();">
							
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
								
								<p>
									<label>管理员帐号</label>
									<input class="text-input small-input" type="text" id="usr_account" name="usr_account" value="<?php echo $webmaster->usr_account;?>"/> <!-- Classes for input-notification: success, error, information, attention -->
								</p>
																
								<p>
									<label>管理员昵称</label>
									<input class="text-input medium-input datepicker" type="text" id="usr_nickname" name="usr_nickname" value="<?php echo $webmaster->usr_nickname;?>"/>
								</p>
								
								<p>
									<label>管理员密码</label>
									<input class="text-input medium-input datepicker" type="type" id="usr_pwd" name="" value="<?php echo $webmaster->usr_pwd;?>" readonly/><a href="javascript:change_pwd()">修改</a>
									</br>如要修改密码，请直接在此填写新密码
								</p>
								<p>
									<label>管理员邮箱</label>
									<input class="text-input medium-input datepicker" type="text" id="usr_email" name="usr_email" value="<?php echo $webmaster->usr_email;?>"/> <span id="articletagremind"></span>
									</br>当有人评论文章时，将收到邮件通知
								</p>
								<p>
									<label>smtp邮箱帐号</label>
									<input class="text-input medium-input datepicker" type="text" id="usr_email_account" name="usr_email_account" value="<?php echo $webmaster->usr_email_account;?>"/> <span id="articletagremind"></span>
									</br>如果开启了smtp，必须填写,用于发邮件
								</p>
								<p>
									<label>smtp邮箱密码</label>
									<input class="text-input medium-input datepicker" type="password" id="usr_email_pwd" name="usr_email_pwd" value="<?php echo $webmaster->usr_email_pwd;?>"/> <span id="articletagremind"></span>
									</br>如果本地架设有邮件服务器可以不填，否则将调用对应的smtp发邮件，需要密码
								</p>
								<p>
									<label>smtp地址</label>
									<input class="text-input medium-input datepicker" type="text" id="usr_email_smtp" name="usr_email_smtp" value="<?php echo $webmaster->usr_email_smtp;?>"/> <span id="articletagremind"></span>
									</br>填写与邮箱帐号对应的smtp服务器地址
								</p>
								<p>
									<label>smtp端口</label>
									<input class="text-input medium-input datepicker" type="text" id="usr_email_port" name="usr_email_port" value="<?php echo $webmaster->usr_email_port;?>"/> <span id="articletagremind"></span>
									</br>如果未检测到有效值，默认启用25端口
								</p>
								<p><input type="checkbox" id="is_smtp" name="is_smtp" <?php if($webmaster->is_smtp)echo 'checked';?> value="1"/>开启smtp</p>
								<p>
									<input class="button" type="submit" value="更新" />
								</p>
								
							</fieldset>
							
							<div class="clear"></div><!-- End .clear -->
							
						</form>
					</div> <!-- End #tab2 -->        
					
				</div> <!-- End .content-box-content -->
				
			</div> <!-- End .content-box -->
			<div class="clear"></div>