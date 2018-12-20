<?php
include 'begin.php';


   $users = $webcare->user->GetUsers();
	//T::dumpa($users);
   $smarty->assign('users', $users);


	$smarty->display("list_users.tpl");

?>