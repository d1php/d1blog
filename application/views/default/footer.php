  <div class="fbg">
    <div class="fbg_resize">
      <div class="col c1">
        <h2>关于我们</h2>
        <img src="<?php echo site_url('css/view/default/images/white.jpg');?>" width="66" height="66" alt="pix" />
        <p>大家好:-)，欢迎使用由第一php网站长开发的博客系统d1blog。默认主题和后台模板来自网络免费资源，网站功能由站长自主开发，感谢模板原作者的无私奉献！</p>
        <p>该博客系统开源发布，供所有人免费使用，可任意修改再发布！站长希望使用d1blog系统的朋友，本着开源精神，无私奉献，热心帮助他人！</p>
        <p>如果在使用过程中发现了任何bug或者有好的建议，请联系站长。站长主页：<a href="http://www.phptogether.com/aboutme/" target="_blank">http://www.phptogether.com/aboutme/</a>，联系邮箱：phptogether@hotmail.com</p>
      </div>
      <div class="col c2">
        <h2>捐赠第一php网</h2>
        <p>第一php网的建立并不是纯粹以盈利为目地的，一方面站长需要把自己日常工作、学习积累的资料保存下来供以后使用，主要是为了查找方便；另一方面也希望站长积累的资料可以方便互联网上的其他人，任何在学习工作中遇到困难的人。本站以积极分享知识、耐心帮助他人为口号，希望更多的技术人员，尤其是PHP方面的技术人员加入进来，共同建设、维护。如果觉得本站的内容对您有帮助，烦请帮助宣传、推广或者<a href="http://list.qq.com/cgi-bin/qf_invite?id=e8be7fcfe97d4d4117dadd8145e53d352e77d986e4fc62d6" target="_blank">
<img border="0" src="http://rescdn.list.qq.com/zh_CN/htmledition/images/qunfa/manage/picMode_light_s.png" alt="填写您的邮件地址，订阅我们的精彩内容：">
</a>，站长将不胜感激，您的支持是小站前进的动力！<br />捐赠入口：<a href="http://www.phptogether.com/donate">http://www.phptogether.com/donate</a></p>
      </div>
      <div class="col c3">
        <h2>图片欣赏</h2>
        <a href="#"><img src="<?php echo site_url('css/view/default/images/pix1.jpg')?>" width="66" height="66" alt="ad" class="ad" /></a>
        <a href="#"><img src="<?php echo site_url('css/view/default/images/pix2.jpg')?>" width="66" height="66" alt="ad" class="ad" /></a>
        <a href="#"><img src="<?php echo site_url('css/view/default/images/pix3.jpg')?>" width="66" height="66" alt="ad" class="ad" /></a>
        <a href="#"><img src="<?php echo site_url('css/view/default/images/pix4.jpg')?>" width="66" height="66" alt="ad" class="ad" /></a>
        <a href="#"><img src="<?php echo site_url('css/view/default/images/pix5.jpg')?>" width="66" height="66" alt="ad" class="ad" /></a>
        <a href="#"><img src="<?php echo site_url('css/view/default/images/pix6.jpg')?>" width="66" height="66" alt="ad" class="ad" /></a>
        <h2>联系方式</h2>
        <p><strong>作者QQ:</strong> 15624575<br /><strong>官方网站:</strong><a href="http://www.phptogether.com" title="访问官网" target="_blank">www.phptogether.com</a><br /><strong>E-mail:</strong> <a href="mailto:phptogether@hotmai.com">phptogether@hotmai.com</a></p>
      </div>
      <div class="clr"></div>
    </div>
  </div>
  <div class="footer">
    <div class="footer_resize">
      <p class="lf">&copy; Copyright 2012-2012 <a href="<?php echo site_url();?>"><?php echo $siteconfig->site_title;?></a></p>
      <ul class="fmenu">
          <li <?php if(isset($m)&&$m=='index'):?>class="active"<?php endif;?>><a href="<?php echo site_url();?>"><span>首页</span></a></li>
          <?php if($categorylist):?>
          <?php foreach ($categorylist as $value):?>
          <li <?php if(isset($current_id)&&$value->id==$current_id):?>class="active"<?php endif;?>><a href="<?php echo site_url('article/listbycategory/'.$value->id);?>" title="<?php echo $value->blog_category_name;?>"><span><?php echo $value->blog_category_name;?></span></a></li>
          <?php endforeach;?>
          <?php endif;?> 
      </ul>
    </div>
    <div class="clr"></div>
  </div>
</div>
</body>
</html>
