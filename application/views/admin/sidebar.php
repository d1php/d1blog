<body>
<div id="body-wrapper"> <!-- Wrapper for the radial gradient background -->
		
		<div id="sidebar"><div id="sidebar-wrapper"> <!-- Sidebar with logo and menu -->
			
			<h1 id="sidebar-title"><a href="#">d1blog控制面板</a></h1>
		  
			<!-- Logo (221px wide) -->
			<a href="#">			
		   <?php
		   $image_properties = array(
		  'id' => 'logo',
          'src' => 'css/admin/images/logo.png',
          'alt' => 'Admin logo');
		   ?>
				<?php echo img($image_properties);?></a>
<!-- Sidebar Profile links -->
			<div id="profile-links">
				欢迎你，<a href="#" title="Edit your profile"><?php echo $this->session->userdata('adminnickname');?></a><br />
				<br />
				<a href="<?php echo site_url();?>" title="查看首页">查看首页</a> | <a href="<?php echo site_url('admin/cpanel/logout')?>" title="登出">登出</a>
			</div>

			<ul id="main-nav">  <!-- Accordion Menu -->
				
				<li>
					<a href="<?php echo site_url().'admin/cpanel';?>" class="nav-top-item <?php if($c=='cpanel'):?>current<?php else:?>no-submenu<?php endif;?>"> <!-- Add the class "no-submenu" to menu items with no sub menu -->
						控制面板
					</a>       
				</li>
				<li> 
					<a href="#" class="nav-top-item <?php if($c=='article'):?>current<?php endif;?>"> <!-- Add the class "current" to current menu item -->
					文章管理
					</a>
					<ul>
						<li><a <?php if($m=='write'):?>class="current"<?php endif;?> href="<?php echo site_url().'admin/article/write';?>">写文章</a></li>
						<li><a <?php if($m=='articlelist'):?>class="current"<?php endif;?> href="<?php echo site_url().'admin/article/articlelist';?>">所有文章</a></li> <!-- Add class "current" to sub menu items also -->
						<li><a <?php if($m=='comment'):?>class="current"<?php endif;?> href="<?php echo site_url().'admin/article/comment';?>">查看评论</a></li>
						<li><a <?php if($m=='category'):?>class="current"<?php endif;?> href="<?php echo site_url().'admin/article/category';?>">文章分类</a></li>
					    <li><a <?php if($m=='tag'):?>class="current"<?php endif;?> href="<?php echo site_url().'admin/article/tag';?>">文章标签</a></li>
					</ul>
				</li>
				<li> 
					<a href="#" class="nav-top-item <?php if($c=='image'):?>current<?php endif;?>"> <!-- Add the class "current" to current menu item -->
					图片管理
					</a>
					<ul>
						<li><a <?php if($m=='upload'):?>class="current"<?php endif;?> href="<?php echo site_url().'admin/image/upload';?>">上传图片</a></li>
						<li><a <?php if($m=='imgcategory'):?>class="current"<?php endif;?> href="<?php echo site_url().'admin/image/imgcategory';?>">图片分类</a></li>
						<li><a <?php if($m=='imglist'):?>class="current"<?php endif;?> href="<?php echo site_url().'admin/image/imglist';?>">所有图片</a></li> <!-- Add class "current" to sub menu items also -->
					</ul>
				</li>
				<li>
					<a href="#" class="nav-top-item <?php if($c=='flink'):?>current<?php endif;?>">
						友情链接
					</a>
					<ul>
						<li><a href="<?php echo site_url().'admin/flink/addlink';?>" <?php if($m=='addlink'):?>class="current"<?php endif;?>>添加链接</a></li>
						<li><a href="<?php echo site_url().'admin/flink/requestlink';?>" <?php if($m=='requestlink'):?>class="current"<?php endif;?>>待审核链接</a></li>
						<li><a href="<?php echo site_url().'admin/flink/linklist';?>" <?php if($m=='linklist'):?>class="current"<?php endif;?>>友情链接</a></li>
					</ul>
				</li>

				<li>
					<a href="<?php echo site_url('admin/siteconfig');?>" class="nav-top-item <?php if($c=='siteconfig'):?>current<?php else:?>no-submenu<?php endif;?>">
						网站设置
					</a>
				</li>
				
				<li>
					<a href="<?php echo site_url('admin/webmaster');?>" class="nav-top-item <?php if($c=='webmaster'):?>current<?php else:?>no-submenu<?php endif;?>">
						管理员信息
					</a>
				</li>     
				
			</ul> <!-- End #main-nav -->
			
		</div></div> <!-- End #sidebar -->
		
		<div id="main-content"> <!-- Main Content Section with everything -->
			
			<noscript> <!-- Show a notification if the user has disabled javascript -->
				<div class="notification error png_bg">
					<div>
						您的浏览器不支持javascript，请检查使用开启javascript！</div>
				</div>
			</noscript>