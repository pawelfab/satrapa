<?php

//$variables['showWarnigs'] = false;


// DEFAULT META
$variables['default_meta_title'] = 'SATRAPA';
$variables['default_meta_desc'] = '...';
$variables['default_meta_key'] = '...';

// email & subscription  ADMIN   ADMIN   ADMIN   ADMIN
$variables['emailContact'] = '*';
$variables['emailContactName'] = '*';
$variables['emailCC'] = array();
$variables['smtpServer'] =  '';
$variables['smtpUser'] =  '';
$variables['smtpPass'] =  '';

$variables['confirmUrl'] =  "http://".$_SERVER["HTTP_HOST"]."/";

// SMARTY
define ("SMARTY_DIR", $_SERVER['DOCUMENT_ROOT'] . '/view/smarty/libs/');
$variables['smarty_template_dir'] 	= WB_ROOT . '/view';
$variables['smarty_config_dir']			= WB_ROOT . '/view/configs';
$variables['smarty_compile_dir']		= WB_ROOT . '/view/view_c';
$variables['smarty_use_sub_dirs']		= false;
$variables['smarty_compile_check']	= true;
$variables['smarty_debugging']			= false;
$variables['smarty_user_plugins']		= '/plugins';
$variables['smarty_cache_dir']		= '';

// DB
$variables['database'] = '***';
$variables['dbhost'] = '***';
$variables['dbuser'] = '***';
$variables['dbpass'] = '***';
$variables['dblogging'] = false;


?>