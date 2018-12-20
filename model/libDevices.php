<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

class Device {
    
	var $system;
	var $sourceIdent = 'DEVICE';

	function Device($system, $conf) {
		$this->system = &$system;
	}

	function UserIdent($login, $password){

		$sql = "select * from users where login like '".$login."' and haslo like '".$password."'";
		$res = $this->system->Query($sql);
		return $res;
	}
	
	

	function GetDevices(){

		$sql = "SELECT * FROM devices,model,manufactur where devices.id_model=model.id_model and model.id_man=manufactur.id_man";
		$res = $this->system->Query($sql);
		return $res;
	}

	function AddDevice($inp){

		$sql = "INSERT INTO devices (id_model,nr_ser) VALUES ('".$inp['model_id']."', '".$inp['nr_seryjny']."')";
		$res = $this->system->Query($sql,0);
		return $res;

	}
	
	function AddModel($inp){
		//dodanie manufactur jeœli nie istnieje
		$sql = "INSERT IGNORE INTO manufactur SET manuf = '".$inp['manuf']."' ";
		$res = $this->system->Query($sql,0);
		//pobranie id wpisanego manufactur
		$sql = "SELECT id_man FROM manufactur WHERE manuf like '%".$inp['manuf']."%'";
		$id_man = $this->system->Query($sql);
		//echo isset($id_man[0]['id_man'])?$id_man[0]['id_man']:'operacja nieudana';
		$id = $id_man[0]['id_man'];
		//isset($post[0]['price'])?$post[0]['price']:'';
		//zapisanie modelu
		$sql = "INSERT INTO model (id_man,model) VALUES ($id,'".$inp['model']."')";
		$id_man = $this->system->Query($sql,0);
		return $id_man;
	}
	
	function CheckSerialNr($inp){
			//sprawdzenie czy numer seryjny urz¹dzenia jest juz w bazie.
			$sql = "SELECT * FROM devices WHERE nr_ser LIKE '".$inp."'";
			$query = $this->system->Query($sql);
			//T::dumpa($query[0]['nr_ser']);
			if(!empty($query[0]['nr_ser'])){
				$res = true;
			} else {$res = false;}
			return $res;
	}
	
	
	function EditDevice($inp){

		$sql = "update devices set tytul='".$inp['tytul']."', rezyser='".$inp['rezyser']."', kategoria='".$inp['kategoria']."', rok='".$inp['rok']."', czas='".$inp['czas']."' where ID_F='".$inp['filmId']."'";
		$res = $this->system->Query($sql,0);
		return $res;

	}

	
	function GetDevice($deviceId){

		
		$sql = "select * from devices where id_dev=$deviceId";
		$res = $this->system->Query($sql);
		return $res;
	}
	
	function GetTable($table){
		
		$sql = "select * from $table";
		$res = $this->system->Query($sql);
		return $res;
	}
	
	function AddPart($part){
		//dodanie manufactur jeœli nie istnieje
		$sql = "INSERT IGNORE INTO part SET part_name = '".$part['part_name']."', indeks_kat = '".$part['indeks_kat']."', cena_sprzed = '".$part['cena_sprzed']."', indeks_handl = '".$part['indeks_handl']."' ";
		$res = $this->system->Query($sql,0);
		return $res;
	}
	
	
}
?>