<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
		
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
		<title>d1blog--管理面板</title>
		
		<!--                       CSS                       -->
	  		<?php 
		$link1 = array(
          'href' => 'css/admin/css/reset.css',
          'rel' => 'stylesheet',
          'type' => 'text/css',
          'media' => 'screen');
		$link2 = array(
          'href' => 'css/admin/css/style.css',
          'rel' => 'stylesheet',
          'type' => 'text/css',
          'media' => 'screen');
		$link3 = array(
          'href' => 'css/admin/css/invalid.css',
          'rel' => 'stylesheet',
          'type' => 'text/css',
          'media' => 'screen');
		$link4 = array(
          'href' => 'css/admin/css/blue.css',
          'rel' => 'stylesheet',
          'type' => 'text/css',
          'media' => 'screen');
        $link5 = array(
          'href' => 'css/admin/css/red.css',
          'rel' => 'stylesheet',
          'type' => 'text/css',
          'media' => 'screen');?>
		<!-- Reset Stylesheet -->
		<?php echo link_tag($link1);?>
		<!-- Main Stylesheet -->
	    <?php echo link_tag($link2);?>
		
		<!-- Invalid Stylesheet. This makes stuff look pretty. Remove it if you want the CSS completely valid -->
		<?php echo link_tag($link3);?>	
		
		<!-- Colour Schemes
	  
		Default colour scheme is green. Uncomment prefered stylesheet to use it.
		<?php echo link_tag($link4);?>	
		
		<?php echo link_tag($link5);?>   
	 
		-->
		
		<!-- Internet Explorer Fixes Stylesheet -->
		
		<!--[if lte IE 7]>
		<?php         
		$link6 = array(
          'href' => 'css/admin/css/ie.css',
          'rel' => 'stylesheet',
          'type' => 'text/css',
          'media' => 'screen');?>
        <?php echo link_tag($link6);?> 
		<![endif]-->
		
		<!--                       Javascripts                       -->
  
		<!-- jQuery -->
		<script type="text/javascript" src="<?php echo site_url('css/common/jquery-1.7.2.min.js');?>"></script>
		
		<!-- jQuery Configuration -->
		<script type="text/javascript" src="<?php echo site_url('css/admin/scripts/simpla.jquery.configuration.js');?>"></script>
		
		<!-- Facebox jQuery Plugin -->
		<script type="text/javascript" src="<?php echo site_url('css/admin/scripts/facebox.js');?>"></script>
		<!-- jQuery WYSIWYG Plugin -->
		<script type="text/javascript" src="<?php echo site_url('css/admin/scripts/jquery.wysiwyg.js');?>"></script>
		
		<!-- jQuery Datepicker Plugin -->
		<script type="text/javascript" src="<?php echo site_url('css/admin/scripts/jquery.datePicker.js');?>"></script>
		<script type="text/javascript" src="<?php echo site_url('css/admin/scripts/jquery.date.js');?>"></script>
		<!--[if IE]><script type="text/javascript" src="<?php echo site_url('css/admin/scripts/jquery.bgiframe.js');?>"></script><![endif]-->

		
		<!-- Internet Explorer .png-fix -->
		
		<!--[if IE 6]>
			<script type="text/javascript" src="<?php echo site_url('css/admin/scripts/DD_belatedPNG_0.0.7a.js');?>"></script>
			<script type="text/javascript">
				DD_belatedPNG.fix('.png_bg, img, li');
			</script>
		<![endif]-->
		<script type="text/javascript" src="<?php echo site_url('ueditor/editor_config.js');?>"></script>
        <script type="text/javascript" src="<?php echo site_url('ueditor/editor_all.js');?>"></script>
        <link rel="stylesheet" href="<?php echo site_url('ueditor/themes/default/ueditor.css');?>"/>
		<script type="text/javascript" src="<?php echo site_url('css/common/ajax.js');?>"></script>
		<script type="text/javascript" src="<?php echo site_url('css/uploadify/jquery.uploadify-3.1.min.js');?>"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo site_url('css/uploadify/uploadify.css');?>" />
	</head>