			
			<!-- Page Head -->
			<h2>欢迎你， <?php echo $this->session->userdata['adminnickname'];?></h2>
			<p id="page-intro">想做点什么吗？</p>
			
			<ul class="shortcut-buttons-set">
				
				<li><a class="shortcut-button" href="<?php echo site_url('admin/article/write');?>"><span>
				<?php echo img(array('src' => 'css/admin/images/icons/pencil_48.png','alt' => 'icon'));?><br />
					写文章
				</span></a></li>
				
				<li><a class="shortcut-button" href="<?php echo site_url('admin/article/articlelist');?>"><span>
                <?php echo img(array('src' => 'css/admin/images/icons/paper_content_pencil_48.png','alt' => 'icon'));?><br />
					查看所有文章
				</span></a></li>
				
				<li><a class="shortcut-button" href="<?php echo site_url('admin/image/upload');?>"><span>
				<?php echo img(array('src' => 'css/admin/images/icons/image_add_48.png','alt' => 'icon'));?><br />
					上传图片
				</span></a></li>
				
			</ul><!-- End .shortcut-buttons-set -->