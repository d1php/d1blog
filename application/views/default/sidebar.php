      <div class="sidebar">
       <?php if($categorylist):?>
        <div class="gadget">
          <h2 class="star">文章分类</h2>
          <ul class="sb_menu">
          <?php foreach ($categorylist as $value):?>
            <li><a href="<?php echo site_url('article/listbycategory/'.$value->id);?>" title="该分类下有<?php echo $value->article_num;?>篇文章"><?php echo $value->blog_category_name;?></a></li>
          <?php endforeach;?>  
          </ul>
        </div>
       <?php endif;?> 
        <?php if($newposts):?>
        <div class="gadget">
          <h2 class="star">最新文章</h2>
          <ul class="ex_menu">
            <?php foreach ($newposts as $value):?>
            <li><a href="<?php echo site_url('article/view/'.$value->id);?>" title="<?php echo $value->post_title;?>"><?php echo mb_substr($value->post_title,0,18,'utf-8');?></a></li>
            <?php endforeach;?>
          </ul>
        </div>
        <?php endif;?>
        <?php if($newcomments):?>
        <div class="gadget">
          <h2 class="star">最新评论</h2>
          <ul class="ex_menu">
            <?php foreach ($newcomments as $value):?>
            <li><a href="<?php echo site_url('article/view/'.$value->post_id.'#comment');?>" title="<?php echo $value->comment_content;?>"><?php echo mb_substr($value->comment_content,0,18,'utf-8');?></a></li>
            <?php endforeach;?>
          </ul>
        </div>
          <?php else:?>
          <?php endif;?>
          <?php if($tagcloud):?>
          <div class="gadget" id="tags">
          <h2 class="star">标签云</h2>
          <ul>
            <?php foreach ($tagcloud as $value):?>
            <li><a href="<?php echo site_url('article/listbytag/'.$value->id);?>" title="该标签下有‘<?php echo $value->tag_post_num;?>’篇文章"><?php echo mb_substr($value->blog_tag_name,0,18,'utf-8');?></a></li>
            <?php endforeach;?>
          </ul>  
        </div>
          <?php endif;?>
          <?php if($linklist):?>
          <div class="gadget">
          <h2 class="star">友情链接</h2>
          <ul class="ex_menu">
            <?php foreach ($linklist as $value):?>
            <li><a href="<?php echo $value->link_url;?>" title="访问该链接"><?php echo $value->link_name;?></a></li>
            <?php endforeach;?>
          </ul>  
         </div>
          <?php endif;?>
          <div class="gadget">
          <h2 class="star">网站管理</h2>
          <ul class="ex_menu">
          <?php if($this->session->userdata('adminid')):?>
          <li><a href="<?php echo site_url('admin/cpanel');?>">管理面板</a></li>
          <li><a href="<?php echo site_url('admin/cpanel/loginout');?>">退出</a></li>
          <?php else:?>
          <li><a href="<?php echo site_url('admin/login');?>">登录</a></li>
          <?php endif;?>
          </ul>  
        </div>
      </div>
      <div class="clr"></div>
    </div>
  </div>