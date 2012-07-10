<div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2 id="apply">申请友情链接</h2>
          <?php if(isset($apply)) echo '<p style="color:red">申请提交成功，请耐心等待审核！</p>';?>
          <form action="<?php echo site_url('flink/doadd/');?>" method="post" id="leavereply" onsubmit="return check_flinkform();">
          <ol>
          <li>
            <label for="usrname">链接名称 </label>
            <input name="link_name" id="link_name" class="text" /><span id="linknameremind"></span>
          </li>
          <li><label for="usrname">链接地址 </label>
            <input name="link_url" id="link_url" class="text" value="http://"/><br/>请输入完整url地址，如：http://www.d1php.info
          </li>
          <li>
            <label for="email">链接描述</label>
            <input name="link_description" id="link_description" class="text" />
          </li>
          <li>
            <label for="email">电子邮件</label>
            <input name="link_email" id="link_email" class="text" /><span id="linkemailremind"></span>
          </li>
          <li>
            <input type="image" name="imageField" id="imageField" src="<?php echo site_url('css/view/default/images/submit.gif');?>" class="send" />
            <div class="clr"></div>
          </li></ol>
          </form>
        </div>
      </div>