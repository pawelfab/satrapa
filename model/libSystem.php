<?php    

include_once dirname(__FILE__) . '/libMySQL.php';
include_once dirname(__FILE__) . '/libUser.php';
include_once dirname(__FILE__) . '/libDevices.php';
include_once dirname(__FILE__) . '/libRepairs.php';
include_once dirname(__FILE__) . '/libSerwis.php';

class WebCareSystem extends SQL {

	
	// SUB LIBRARY
	var $sql;
	var $user;
	var $device;
	var $repair;
	var $serwis;
	
	var $logDir;
	var $conf;
	
	function WebCareSystem($conf) {
		$this->SQL($conf['database'], 1, false, $conf['dbhost'], $conf['dbuser'], $conf['dbpass'], $conf['dblogging']);

		
		$this->user = new User(&$this, &$conf);
		$this->device = new Device(&$this, &$conf);
		$this->repair = new Repair(&$this, &$conf);
		$this->serwis = new Serwis(&$this, &$conf);
		$this->conf = $conf;
		
	}
	
}
?>