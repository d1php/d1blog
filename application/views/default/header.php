<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo isset($page_title)?$page_title.'—':'';?><?php echo $siteconfig->site_title;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="generator" content="<?php echo $this->config->item('blog_name');?>" />
<meta name="description" content="<?php echo $siteconfig->site_description;?>" />
<meta name="keywords" content="<?php echo $siteconfig->site_keyword;?>" />
<?php echo link_tag(site_url('css/view/default/style.css'));?>
<!-- CuFon: Enables smooth pretty custom font rendering. 100% SEO friendly. To disable, remove this section -->
<script type="text/javascript" src="<?php echo site_url('css/view/default/js/cufon-yui.js')?>"></script>
<script type="text/javascript" src="<?php echo site_url('css/view/default/js/arial.js');?>"></script>
<script type="text/javascript" src="<?php echo site_url('css/view/default/js/cuf_run.js');?>"></script>
<script type="text/javascript" src="<?php echo site_url('css/common/jquery-1.7.2.min.js');?>"></script>
<script type="text/javascript" src="<?php echo site_url('css/view/default/js/view.js');?>"></script>
<!-- CuFon ends -->
</head>
<body>
<div class="main">
  <div class="header">
    <div class="header_resize">
      <div class="logo"><h1><a href="<?php echo site_url();?>"><span><?php echo $siteconfig->site_title;?><br /><small><?php echo $siteconfig->site_description;?></small></a></h1></div>
      <div class="searchform">
        <form id="formsearch" name="formsearch" method="get" action="<?php echo site_url('article/find');?>">
          <input name="button_search" src="<?php echo site_url('css/view/default/images/search_btn.gif');?>" class="button_search" type="image" />
          <span><input name="w" class="editbox_search" id="w" maxlength="80" value="" type="text" /></span>
        </form>
      </div>
      <div class="clr"></div>
      <div class="menu">
        <ul>
          <li <?php if(isset($m)&&$m=='index'):?>class="active"<?php endif;?>><a href="<?php echo site_url();?>"><span>首页</span></a></li>
          <?php if($categorylist):?>
          <?php foreach ($categorylist as $value):?>
          <li <?php if(isset($current_id)&&$value->id==$current_id):?>class="active"<?php endif;?>><a href="<?php echo site_url('article/listbycategory/'.$value->id);?>" title="<?php echo $value->blog_category_name;?>"><span><?php echo $value->blog_category_name;?></span></a></li>
          <?php endforeach;?>
          <?php endif;?>
          <li><a href="<?php echo site_url('contact');?>"><span>联系我们</span></a></li>
          <li><a href="<?php echo site_url('flink');?>"><span>友情链接申请</span></a></li> 
        </ul>
      </div>
      <div class="clr"></div>
    </div>
  </div>
  <div class="clr"></div>


  <div class="hbg">
    <div class="hbg_resize">
    <?php if($article_head):?>
      <h2><a href="<?php echo site_url('article/view/'.$article_head->id)?>"><?php echo $article_head->post_title;?></a></h2>
      <?php
      	$article_head->post_content=preg_replace('/<img([\d\D]*?)\/>/','',$article_head->post_content);
      	echo mb_strlen($article_head->post_content,'utf-8')>200?mb_substr($article_head->post_content,0,200,'utf-8').'......':$article_head->post_content;	
      ?>
      <p><a href="<?php echo site_url('article/view/'.$article_head->id);?>">      
      <?php
		   $image_properties = array(
		  'width' => '112',
		  'height'=> '33',
          'src' => 'css/view/default/images/readmore.gif',
		  'border' => '0',
          'alt' => '更多');
	  ?>
<?php echo img($image_properties);?></a></p>
<?php else:?>
<?php echo $article_head;?>
    <?php endif;?> 
    </div>
  </div>