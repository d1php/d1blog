
	<body id="login">
		
		<div id="login-wrapper" class="png_bg">
			<div id="login-top">
			
				<h1>Simpla Admin</h1>
				<!-- Logo (221px width) -->
				<?php 
				$image_properties = array(
		  'id' => 'logo',
          'src' => 'css/admin/images/logo.png',
          'alt' => 'Admin logo'
				);?>
				<?php echo img($image_properties);?>
			</div> <!-- End #logn-top -->
			
			<div id="login-content">
				<?php $attributes = array('onsubmit' => 'return check_adminform(\''.site_url().'admin/cpanel\',\''.site_url().'admin/login/dologin\')', 'id' => 'adminform');?>
				<?php echo form_open('admin/login/dologin',$attributes);?>
				
					<div class="notification information png_bg">
						<div id="adminremind">
							<?php if($error=validation_errors())echo $error;else echo '欢迎使用第一博客系统，请牢记您的密码。'; ?>
						</div>
					</div>
					
					<p>
						<label>用户名</label>
						<input class="text-input" type="text" name="usrname"/>
					</p>
					<div class="clear"></div>
					<p>
						<label>密&nbsp;&nbsp;&nbsp;&nbsp;码</label>
						<input class="text-input" type="password" name="usrpwd"/>
					</p>
					<div class="clear"></div>
					<p id="remember-password">
						<input type="checkbox" name="rememberme" value="1"/>一周免登录
					</p>
					<div class="clear"></div>
					<p>
						<input class="button" type="submit" value="登录" id="adminlogin"/>
					</p>
					
				</form>
			</div> <!-- End #login-content -->
			
		</div> <!-- End #login-wrapper -->
		
  </body>
  </html>
