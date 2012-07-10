<div class="content">
    <div class="content_resize">
      <div class="mainbar">
              <div class="article">
          <h2 id="comment"><?php echo $comment?count($comment):0;?> 留言</h2>
          <?php if($comment):?>
          <?php foreach($comment as $value):?>
          <div class="comment">
          <a href="<?php echo $value->comment_url;?>">
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
                           <p id="nonecomment">暂无留言</p>
           <?php endif;?>
           <p class="pagination"><?php echo $pagination;?></p>
        </div>
        <div class="article">
          <h2>发表留言</h2>
          <form action="<?php echo site_url('comment/addcontact/');?>" method="post" id="leavereply" onsubmit="return check_commentform();">
          <ol><li>
            <label for="usrname">姓名 </label>
            <input id="usrname" name="usrname" class="text" />
          </li><li>
            <label for="email">电子邮件</label>
            <input id="email" name="email" class="text" />
          </li><li>
            <label for="website">个人主页（需填写完整url地址，如http://www.d1php.info）</label>
            <input id="website" name="website" class="text" value="http://"/>
          </li><li>
            <label for="message">留言内容（必填）</label>
            <textarea id="message" name="message" rows="8" cols="50"></textarea>
          </li><li>
            <input type="image" name="imageField" id="imageField" src="<?php echo site_url('css/view/images/submit.gif');?>" class="send" />
            <div class="clr"></div>
          </li></ol>
          </form>
        </div>
      </div>