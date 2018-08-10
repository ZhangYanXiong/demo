<?php  

include("smarty/libs/Smarty.class.php");
	$smarty=new Smarty;
	$smarty->template_dir='templates';
	$smarty->config_dir='config';
	$smarty->cache_dir='smarty_chache';
	$smarty->compile_dir='smarty_templates_c';
	//参数配置
	$smarty->caching=false;//关闭缓存
	$smarty->left_delimiter="{";//左边界
	$smarty->right_delimiter="}";//右边界