<?php
include 'begin.php';

if(!empty($_POST['login']) && !empty($_POST['password'])){
	$pass = md5($_POST['password']);
	$log = $webcare->user->UserIdent($_POST['login'],$pass);

	if(!empty($log)){
			$_SESSION['user']=$log;
			//T::Dumpa($_SESSION['user'][0]['AUTH']);
			$smarty->display("index_us.tpl");
	}
	else{
			$smarty->assign('error', '1');
			$smarty->display("index.tpl");
	}

}
else{
			$smarty->display("index.tpl");
}



?>
