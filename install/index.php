<html>
<head>
<meta charset='utf-8'>
<title>欢迎使用d1blog</title>
<style>
input{width:250px}
</style>
</head>
<body>
<?php 
if($_REQUEST['action']=='install')
{
    extract($_POST);
    if(trim($dbport)&&$dbport!='3306')
	$host=$dbaddr.':'.$dbport;//主机名
    else
    $host=$dbaddr;
	$user=$dbusr;//用户名
	$pwd=$dbpwd;//密码
	$cstr='<?php 
	$host="'.$host.'";
	$user="'.$dbusr.'";//用户名
	$pwd="'.$dbpwd.'";//密码
	$dbname="'.$dbname.'";//密码
	?>';
	file_put_contents('conn.php', $cstr);
	//如果连接失败，显示错误
	$link = mysql_connect($host, $user, $pwd)or die("Could not connect: " . mysql_error());
	//如果选择数据库失败，显示错误
	mysql_query("CREATE database IF NOT EXISTS `".$dbname."` CHARACTER SET utf8 COLLATE utf8_general_ci");
	mysql_select_db($dbname, $link) or die ('无法链接'.$dbname.' : 请尝试手动创建' );
	//设置编码
	mysql_query("SET NAMES 'utf8'");
	mysql_query("SET CHARACTER_SET_CLIENT=utf8");
	mysql_query("SET CHARACTER_SET_RESULTS=utf8");
	
	$sql=file_get_contents('ci_blog.sql');
	preg_match_all('/CREATE TABLE([\d\D]*?);/', $sql, $matches);
	foreach ($matches[0] as $key=>$value)
	mysql_query($value) or die(mysql_error());
	mysql_query("SET SQL_MODE='NO_AUTO_VALUE_ON_ZERO';SET time_zone = '+00:00';");
	$result=mysql_list_tables($dbname);
	$tablearray=array('blog_category','blog_comment','blog_image','blog_image_category','blog_link',
			'blog_options','blog_posts','blog_tag','blog_tag_relationship','blog_usr');
	while ($row = mysql_fetch_row($result)) {
		if(in_array($row[0],$tablearray))
		{
			echo '表-'.$row[0].'安装成功<br>';
			$i++;
		}
		else
		{
			echo '表-'.$row[0].'<font color="red">安装失败</font><br>';
		}			    
	}
	if($i==count($tablearray))
	{
		$str=file_get_contents('database.php');
		$str.="\r\n\r\n".
'$db'."['default']['hostname'] = '$dbaddr';\r\n".
'$db'."['default']['username'] = '$dbusr';\r\n".
'$db'."['default']['password'] = '$dbpwd';\r\n".
'$db'."['default']['database'] = '$dbname';\r\n".
'$db'."['default']['dbdriver'] = 'mysql';\r\n".
'$db'."['default']['dbprefix'] = '';\r\n".
'$db'."['default']['pconnect'] = TRUE;\r\n".
'$db'."['default']['db_debug'] = TRUE;\r\n".
'$db'."['default']['cache_on'] = FALSE;\r\n".
'$db'."['default']['cachedir'] = '';\r\n".
'$db'."['default']['char_set'] = 'utf8';\r\n".
'$db'."['default']['dbcollat'] = 'utf8_general_ci';\r\n".
'$db'."['default']['swap_pre'] = '';\r\n".
'$db'."['default']['autoinit'] = TRUE;\r\n".
'$db'."['default']['stricton'] = FALSE;\r\n
/* End of file database.php */
/* Location: ./application/config/database.php */";
		file_put_contents('../application/config/database.php', $str);
		echo '<a href="?action=setusr">下一步</a>';
	}
	else
	{
		echo '<a href="index.php">上一步</a>';
	}
}
else if($_REQUEST['action']=='setusr')
{?>
<div style="text-align:center;">
<p style="color:red">设置网站信息</p>
<form action="?action=siteconfig" method="post">
<p>管理员帐号：<input type="text" name="usr_account"></p>
<p>管理员密码：<input type="password" name="usr_pwd"><span style="position:absolute">密码最低必须6位，不要使用全空格作为密码</span></p>
<p>管理员昵称：<input type="text" name="usr_nickname"><span style="position:absolute">昵称不要超过30个字符</span></p>
<p>网站的标题：<input type="text" name="site_title"></p>
<p><input type="submit" name="submit" value="下一步" style="width:auto"></p>
</form>
</div>	
<?php 
}
else if($_REQUEST['action']=='siteconfig')
{
extract($_POST);
require 'conn.php';
//如果连接失败，显示错误
$link = mysql_connect($host, $user, $pwd)or die("Could not connect: " . mysql_error());
//如果选择数据库失败，显示错误
mysql_select_db($dbname, $link) or die ('无法链接'.$dbname.' : 请尝试手动创建' );
//设置编码
mysql_query("SET NAMES 'utf8'");
mysql_query("SET CHARACTER_SET_CLIENT=utf8");
mysql_query("SET CHARACTER_SET_RESULTS=utf8");

if(!trim($usr_account))
{
	echo '<script>alert("请填写管理员帐号");history.back();</script>';
}
else if(!trim($usr_pwd))
{
	echo '<script>alert("请填写密码");history.back();</script>';
}
else if(mb_strlen(trim($usr_pwd),'utf-8')<6)
{
	echo '<script>alert("密码不得低于6位");history.back();</script>';
}
else if(!trim($usr_nickname))
{
	echo '<script>alert("请填写昵称");history.back();</script>';
}
else if(!trim($site_title))
{
	echo '<script>alert("请填写网站标题");history.back();</script>';
}
else if(mb_strlen(trim($usr_nickname),'utf-8')>30)
{
	echo '<script>alert("昵称不要超过30个字符");history.back();</script>';
}
else 
{
	mysql_query("TRUNCATE TABLE `blog_usr` ");
	mysql_query("TRUNCATE TABLE `blog_posts` ");
	mysql_query("TRUNCATE TABLE `blog_options` ");
	mysql_query("INSERT INTO `$dbname`.`blog_usr` (`id`, `usr_account`, `usr_email`, `usr_email_pwd`, `usr_email_account`, `usr_email_smtp`, `usr_email_port`, `is_smtp`, `usr_nickname`, `usr_pwd`, `usr_reg_time`) VALUES (NULL, '$usr_account', NULL, NULL, NULL, '', '25', '0', '$usr_nickname', MD5('$usr_pwd'), CURRENT_TIMESTAMP);");
	$adminid=mysql_insert_id();
	mysql_query("INSERT INTO `d1blog`.`blog_posts` (
`id` ,
`author_id` ,
`post_title` ,
`post_content` ,
`post_category_id` ,
`post_time` ,
`post_editime` ,
`post_views` ,
`set_head`
)
VALUES (
NULL , '$adminid', '欢迎使用d1blog', '传承华夏文明 弘扬民族气节', '0', now(),
CURRENT_TIMESTAMP , '0', '0'
)");
	mysql_query("INSERT INTO `$dbname`.`blog_options` (`id`, `meta`, `value`) 
VALUES 
(NULL, 'site_title', '$site_title'), 
(NULL, 'site_keyword', ''),
(NULL, 'site_description', ''), 
(NULL, 'site_theme', 'default/'), 
(NULL, 'site_statistics', '');");
	if(mysql_insert_id())
	echo '<script>location.href="success.php";</script>';
}
	
?>
	
<?php
}
else 
{
?>
<div style="text-align:center;">
<p style="color:red">请认真填写数据库连接信息</p>
<form action="?action=install" method="post">
<p>数据库地址&nbsp;&nbsp;：<input type="text" name="dbaddr"><span style="position:absolute">本地安装填写：127.0.0.1或localhost</span></p>
<p>数据库端口&nbsp;&nbsp;：<input type="text" name="dbport"><span style="position:absolute">默认为3306</span></p>
<p>数据库用户名：<input type="text" name="dbusr"></p>
<p>数据库密码&nbsp;&nbsp;：<input type="password" name="dbpwd"></p>
<p>数据库名称&nbsp;&nbsp;：<input type="text" name="dbname"><span style="position:absolute">不存在将自动创建</span></p>
<p><input type="submit" name="submit" value="安装" style="width:auto"></p>
</form>
</div>
<?php }?>
</body>
</html>
