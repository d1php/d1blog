  <div class="content">
    <div class="content_resize">
      <div class="mainbar">
      <?php if($articlelist):?>
      <?php foreach ($articlelist as $value):?>
        <div class="article">
          <a href="<?php echo site_url('article/view/'.$value->id)?>"><h2><?php echo html_escape($value->post_title);?></h2></a>
          <p>作者：<a href="#"><?php echo html_escape($value->usr_nickname);?></a> | 分类：<?php if($value->blog_category_name):?><a href="<?php echo site_url('article/listbycategory/'.$value->post_category_id);?>"><?php echo html_escape($value->blog_category_name);?></a><?php else:?>暂无分类<?php endif;?> | 标签：<?php echo $value->tagstr?$value->tagstr:'暂无标签';?></p>
          <?php 
          $contentarr=explode('_baidu_page_break_tag_',$value->post_content);
          if(count($contentarr)>1)
          	   echo $contentarr[0];
          else
               echo $value->post_content;
          ?>
          <p><a href="<?php echo site_url('article/view/'.$value->id)?>">查看全文</a> | <a href="<?php echo site_url('article/view/'.$value->id).'#comment'?>">回复 (<?php echo $value->comment_num;?>)</a>  | 浏览量(<?php echo $value->post_views;?>) | 发表于：<?php echo $value->post_time;?></p>
        </div>
      <?php endforeach;?>
      <?php else:?>
      暂无文章
      <?php endif;?>
      <p class="pagination"><?php echo $pagination;?></p>
      </div>
