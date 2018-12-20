<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

class Serwis {
    
	var $system;
	var $sourceIdent = 'SERWIS';

	function Serwis($system, $conf) {
		$this->system = &$system;
	}

	function UserIdent($login, $password){

		$sql = "select * from users where login like '".$login."' and haslo like '".$password."'";
		$res = $this->system->Query($sql);
		return $res;
	}
	
	

	function GetSerwisy(){

		$sql = "SELECT * FROM serwisy WHERE del = 0";
		$res = $this->system->Query($sql);
		return $res;
	}
	
	function GetSerwis($inp){

		$sql = "SELECT * FROM serwisy WHERE del = 0 and id_serwis = '".$inp."'";
		$res = $this->system->Query($sql);
		return $res;
	}

	function AddSerwis($inp){

		$sql = "INSERT INTO serwisy (nazwa_serwis,miasto_serwis) VALUES ('".$inp['nazwa']."', '".$inp['miasto']."')";
		$res = $this->system->Query($sql,0);
		return $res;

	}
	
	
	function EditSerwis($inp){

		$sql = "update serwisy set nazwa_serwis='".$inp['nazwa']."', miasto_serwis='".$inp['miasto']."' where id_serwis = '".$inp['id']."'";
		$res = $this->system->Query($sql,0);
		return $res;

	}

	
	function DeleteSerwis($inp){

		$sql = "UPDATE serwisy set del = 1 where id_serwis = ".$inp."";
		$res = $this->system->Query($sql,0);
		return $res;

	}
	
	
}
?>