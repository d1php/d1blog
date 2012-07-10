<div class="content">
    <div class="content_resize">
      <div class="mainbar">
      <?php if($article_detail):?>
        <div class="article">
          <h2><?php echo html_escape($article_detail->post_title);?></h2>
          <p>作者：<a href="#"><?php echo html_escape($article_detail->usr_nickname);?></a> &nbsp;&nbsp;|&nbsp;&nbsp; 分类：<?php if($article_detail->blog_category_name):?><a href="<?php echo site_url('article/listbycategory/'.$article_detail->post_category_id);?>"><?php echo html_escape($article_detail->blog_category_name);?></a>&nbsp;&nbsp;<?php else:?>暂无分类<?php endif;?>|&nbsp;&nbsp; 浏览量：<?php echo $article_detail->post_views;?></p>
          <?php 
          $article_detail->post_content=str_replace('_baidu_page_break_tag_','',$article_detail->post_content);
          echo $article_detail->post_content;?>
          <p>标签：<?php echo $tagstr?$tagstr:"暂无标签";?></p>
          <p><a href="#commont"><strong>评论 (<?php echo $comment?count($comment):0;?>)</strong></a> &nbsp;&nbsp;|&nbsp;&nbsp; <?php echo $article_detail->post_time;?> <?php if($this->session->userdata('adminid')):?>&nbsp;&nbsp;|&nbsp;&nbsp; <a href="<?php echo site_url('admin/article/edit/'.$article_detail->id);?>"><strong>编辑</strong></a><?php endif;?></p>
        </div>
        <div class="article">
          <h2 id="comment"><?php echo $comment?count($comment):0;?> 回复</h2>
          <?php if($comment):?>
          <?php foreach($comment as $value):?>
          <div class="comment">
          <a href="#">
                  <?php
		   $image_properties = array(
		  'width' => '40',
		  'height'=> '40',
          'src' => 'css/view/images/userpic.gif',
		  'alt' => 'user',
		  'class' => 'userpic');
	  ?>
	  <?php echo img($image_properties);?></a>
            <p><a href="<?php echo $value->comment_url;?>"><?php echo $value->post_author;?></a> 说:<span style="float:right"><?php echo $value->comment_floor;?>楼</span><br /><?php echo $value->comment_time;?></p>
            <p><?php echo html_escape($value->comment_content);?></p>
          </div>
           <?php endforeach;?>
           <?php else:?>
                           <p id="nonecomment">暂无评论</p>
           <?php endif;?>
           <p class="pagination"><?php echo $pagination;?></p>
        </div>
        <div class="article">
          <h2>发布评论</h2>
          <form action="<?php echo site_url('comment/doadd/'.$article_detail->id);?>" method="post" id="leavereply" onsubmit="return check_commentform();">
          <ol><li>
            <label for="usrname">姓名 </label>
            <input id="usrname" name="usrname" class="text" />
          </li><li>
            <label for="email">电子邮件</label>
            <input id="email" name="email" class="text" />
          </li><li>
            <label for="website">个人主页</label>
            <input id="website" name="website" class="text" value=""/>
          </li><li>
            <label for="message">留言内容（必填）</label>
            <textarea id="message" name="message" rows="8" cols="50"></textarea>
          </li><li>
            <input type="image" name="imageField" id="imageField" src="<?php echo site_url('css/view/default/images/submit.gif');?>" class="send" />
            <div class="clr"></div>
          </li></ol>
          </form>
        </div>
       <?php else:?>
                   该页面不存在
        <?php endif;?>
      </div>
  