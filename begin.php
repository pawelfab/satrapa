<?php
if(empty($variables)) {
	
	if(empty($NO_HEADERS)) {
		session_start();
		@ini_set('session.cache_limiter', 'nocache'); 
		
		// Date in the past
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		
		// always modified
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		 
		// HTTP/1.1
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		
		// HTTP/1.0
		header("Pragma: no-cache");
			
		session_name('ServiceSes');
		
	}
	
	define('WB_ROOT', dirname(__FILE__));
	define('WB_ADMIN_ROOT', dirname(__FILE__));
	
	include WB_ROOT.'/config.inc.php';
	
	if(!empty($variables['showWarnigs'])) {
		error_reporting(63);
		ini_set('display_errors',"1");
	} else {
		error_reporting(0);
		ini_set('display_errors',"1");
	}


	
	// smarty
	$SUB_DIR = !empty($SUB_DIR) ? '/' . $SUB_DIR : '';
	require(SMARTY_DIR.'Smarty.class.php');
	require(SMARTY_DIR.'SmartyValidate.class.php');

	require_once (SMARTY_DIR.'Pager.php');

	$smarty = new Smarty;
	$smarty->template_dir 	= $variables['smarty_template_dir'] . $SUB_DIR;
	$smarty->compile_dir 		= $variables['smarty_compile_dir'] . $SUB_DIR;
	
	$smarty->config_dir 		= $variables['smarty_config_dir']. (!empty ($LG_DIR) ? '/'.$LG_DIR : '');
	if(!is_dir($smarty->config_dir)) {
		$smarty->config_dir = $variables['smarty_config_dir'];
	}
	
	$smarty->cache_dir 			= $variables['smarty_cache_dir'];
	$smarty->use_sub_dirs 	= $variables['smarty_use_sub_dirs'];
	
	$smarty->plugins_dir[] = $variables['smarty_user_plugins'];
	
	$smarty->compile_check 	= $variables['smarty_compile_check'];
	$smarty->debugging 			= $variables['smarty_debugging'];
	
	
	//libraries
	include WB_ROOT.'/model/libTools.php';
	include WB_ROOT.'/model/libSystem.php';
	
	
	 // START MAIN CLASS
	$CMS = new WebCareSystem($variables);
	$webcare = &$CMS;
	//T::dumpa($webcare);
	foreach ($variables as $key => $value) {
		$smarty->assign($key, $value);
	}
	
	
	$smarty->assign("iconPath", '/icon/');
	
	//PARSE REQUEST
	//T::parseRequest ();

	if(empty($_SESSION['user']) && empty($_POST['login'])){
			$smarty->display("index.tpl");
			exit();

	}


}
?>
<html>sss</html>