<html>
<head><title>您的登录状态有误，请重新登录</title>
<meta charset='utf-8'>
<script>
var i=2;
setTimeout('show_time()',1000);
function show_time(){	
	if(i==0){
		location.href='<?php echo site_url('admin/cpanel/logout');?>';
      
	}
	document.getElementById('timeup').innerHTML=i;
	i--
	setTimeout('show_time()',1000);
}
</script>
</head>
<body>
<p style="color:red">对不起，您的登录状态有误！</p>
<p><span id="timeup">3</span>秒后跳转到<a href="<?php echo site_url('admin/cpanel/logout');?>">登录页</a></p>
<p>如果浏览器没有自动跳转，请<a href="<?php echo site_url('admin/cpanel/logout');?>">点击跳转</a>！</p>
</body>
</html>