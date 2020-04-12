<?php

	//获取连接
	$con = @mysql_connect("127.0.0.1","tz_fjzhwd_top","snYLHmHasETMTyaF");
	if(!$con){
		die("没有找到连接".mysql_errno());
	}
	//设置字符集
	mysql_query("set names 'utf8'"); 
	// 选择数据库
	mysql_select_db("tz_fjzhwd_top",$con);

?>
