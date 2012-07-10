
			<div class="clear"></div> <!-- End .clear -->
			
			<div class="content-box"><!-- Start Content Box -->
				
				<div class="content-box-header">
					
					<h3>网站设置</h3>
					
					<div class="clear"></div>
					
				</div> <!-- End .content-box-header -->
				
				<div class="content-box-content">
					
					<div>
					
						<form action="<?php echo site_url('admin/siteconfig/doadd');?>" method="post">
							
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
								
								<p>
									<label>网站标题</label>
										<input class="text-input small-input" type="text" id="site_title" name="site_title" value="<?php echo isset($siteconfig->site_title)?$siteconfig->site_title:'';?>"/> <span id="articletitleremind"></span> <!-- Classes for input-notification: success, error, information, attention -->
								</p>
																
								<p>
									<label>网站关键字</label>
									<input class="text-input medium-input datepicker" type="text" id="site_keyword" name="site_keyword" value="<?php echo isset($siteconfig->site_keyword)?$siteconfig->site_keyword:'';?>"/> <span id="articletagremind"></span>
								</p>
								
								<p>
									<label>网站描述</label>
									<input class="text-input medium-input datepicker" type="text" id="site_description" name="site_description" value="<?php echo isset($siteconfig->site_description)?$siteconfig->site_description:'';?>"/> <span id="articletagremind"></span>
								</p>
								
								<p>
									<label>网站主题</label>
									<select name="site_theme" id="site_theme">
									<?php foreach ($theme as $value):?>
									<option value="<?php echo $value;?>/" <?php if($value=='default')echo 'selected';?>><?php echo $value;?></option>
									<?php endforeach;?>
									</select>
								</p>
								<p>
									<label>统计代码</label>
									<textarea class="text-input medium-input datepicker" id="site_statistics" name="site_statistics" rows="8px"/><?php echo isset($siteconfig->site_statistics)?$siteconfig->site_statistics:'';?></textarea>
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