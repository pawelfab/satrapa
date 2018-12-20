<?php
include 'begin.php';


   $devices = $webcare->devices->GetDevices();
	//T::dumpa($devices);
   $smarty->assign('devices', $devices);


	$smarty->display("list_devices.tpl");

?>