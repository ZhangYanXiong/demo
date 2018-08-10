<?php
	//连接服务器名称
	define('DB_HOST', 'localhost');
	//连接数据库的账号
	define('DB_USER','root');
	//连接数据库的密码
	define('DB_PASSWORD','');
	//数据库名
	define('DB_NAME','trip');
	define('DB_PRE','dees');
	define('DB_PCONNECT',0);
	//数据库编码格式
	define('DB_CHARSET', 'utf-8');
	function fl_value($data) {
		  $data = trim($data);
		  $data = stripslashes($data);
		  $data = htmlspecialchars($data);
		  return $data;
	}
	


