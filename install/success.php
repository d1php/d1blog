<html>
<head><title>安装成功</title>
<meta charset='utf-8'>
<script>
var i=4;
setTimeout('show_time()',1000);
function show_time(){	
	if(i==0){
		location.href='<?php echo '../admin/login';?>';
      
	}
	document.getElementById('timeup').innerHTML=i;
	i--
	setTimeout('show_time()',1000);
}
</script>
</head>
<body>
<p style="color:red">安装成功！请删除install文件夹！</p>
<p><span id="timeup">5</span>秒后跳转到<a href="<?php echo '../admin/login';?>">登录页</a></p>
<p>如果浏览器没有自动跳转，请<a href="<?php echo '../admin/login';?>">点击跳转</a>！</p>
</body>
</html>