<?php
/*
 本软件版权归作者所有,在投入使用之前注意获取许可
 作者：北京市普艾斯科技有限公司
 项目：simcms_锐游1.0
 电话：010-58480317
 网址：http://www.simcms.net
 simcms.net保留全部权力，受相关法律和国际		  		
 公约保护，请勿非法修改、转载、散播，或用于其他赢利行为，并请勿删除版权声明。
*/
$db_config['DB_HOST'] = 'localhost';
$db_config['DB_USER'] = 'haoid';
$db_config['DB_PASS'] = '52haoid';
$db_config['DB_NAME'] = 'sqlhaoid';
$db_config['DB_CHARSET'] = 'utf8';
$db_config['DB_ERROR'] = true;
$db_config['TB_PREFIX'] = 'travel_';

define('CHARSET', 'utf-8'); //文件编码
define('TIMEZONE', '-8'); //时区设置
define('INC_DIR', 'include/'); //包含目录
define('TPL_DIR', 'templates/'); //模板目录
define('CACHE_DIR', 'cache/'); //缓存目录
define('ADMIN_PAGE', 'adm.php'); //后台入口文件
define('HTML_DIR', ''); //静态文件目录
define('CACHETIME',0);       //缓存时间
define('COOKIETIME','3600');  //COOKIE生存时间
?>