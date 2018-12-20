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
		$sql = "SELECT id_man FROM manufactur WHERE manuf like '".$inp['manuf']."'";
		$id_man = $this->system->Query($sql);
		$id = $id_man[0]['id_man'];
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

	function DeleteDevice($filmId){

		$sql = "delete from devices where ID_F = '".$filmId."' ";
		$res = $this->system->Query($sql,0);
		$sql = "delete from kasety where ID_F = '".$filmId."' ";
		$res = $this->system->Query($sql,0);
		return $res;

	}
	
	function GetDevice($deviceId){

		
		$sql = "select * from devices where id_dev=$deviceId";
		$res = $this->system->Query($sql);
		return $res;
	}
	
	function WypFilm($inp){

		$sql = "INSERT INTO WYDARZENIA(ID_U,ID_KASETY,DATA_WYP,ID_F) VALUES ('".$_SESSION['klient']['0']['ID_U']."' , '".$inp['kasetaId']."' , CURRENT_TIMESTAMP , (SELECT ID_F FROM KASETY WHERE ID_KASETY LIKE '".$inp['kasetaId']."'))";
		$res = $this->system->Query($sql,0);
		return $res;
	}
	
	function GetKaseta($filmId){//pokazuje kasety niewypozyczone w danym momencie

		$sql = "select ID_KASETY from kasety where ID_F like '".$filmId."' and ID_KASETY not in (select ID_KASETY from wydarzenia where DATA_WYP is not null and DATA_ZWROTU is null or DATA_REZERW is not null and DATA_WYP is null)";
		$res = $this->system->Query($sql);
		return $res;
	}
	
	function ZwrotFilm($kasetaId){ //zapisuje do bazy zwrot kasety

		$sql = "UPDATE WYDARZENIA SET DATA_ZWROTU=CURRENT_TIMESTAMP WHERE ID_KASETY LIKE '".$kasetaId."' AND DATA_ZWROTU IS NULL";
		$res = $this->system->Query($sql,0);
		return $res;
	} 

	function HistoriaKaseta($kasetaId){ //sprawdza komu by³a wypozyczana zwracana kaseta

		$sql = "select IMIE,NAZWISKO,TYTUL,DATA_WYP,ID_KASETY from wydarzenia w join users u join devices f on w.id_u=u.id_u and w.id_f=f.id_f where id_kasety like '".$kasetaId."' and DATA_WYP is not null order by data_wyp desc limit 1";
		$res = $this->system->Query($sql);
		return $res;
	}
	
	function WolnaKaseta($filmId){ //sprawdza wolne kasety wypozyczanego filmu

		$sql = "select id_kasety from kasety where id_f like '".$filmId."' and id_kasety not in (select id_kasety from wydarzenia where data_wyp is not null and data_zwrotu is null or data_rezerw is not null) limit 1";
		$res = $this->system->Query($sql);
		return $res;
	}
	
	function Rezerwuj($kasetaId){ //rezerwuje pierwsza wolna kasete wybranego filmu dla klienta

		$sql = "INSERT INTO WYDARZENIA(ID_U,ID_KASETY,DATA_REZERW,ID_F) VALUES ('".$_SESSION['klient']['0']['ID_U']."' , '".$kasetaId."' , CURRENT_TIMESTAMP , (SELECT ID_F FROM KASETY WHERE ID_KASETY LIKE '".$kasetaId."') ) ";
		$res = $this->system->Query($sql,0);
		return $res;
	}
	
	function WykRezerw($kasetaId){ //zapisuje do bazy wypo¿yczenie zarezerwowanego wczesniej filmu

		$sql = "UPDATE WYDARZENIA SET DATA_WYP=CURRENT_TIMESTAMP WHERE ID_KASETY LIKE '".$kasetaId."' and id_u like '".$_SESSION['klient']['0']['ID_U']."' and (DATA_WYP IS NULL AND DATA_ZWROTU IS NULL)";
		$res = $this->system->Query($sql,0);
		return $res;
	}
	
	function SprRezerw($userId){ //sprawdza rezerwacje klienta

		$sql = "SELECT ID_KASETY,TYTUL,REZYSER,KATEGORIA,CZAS,ROK,DATA_REZERW FROM WYDARZENIA W JOIN devices F ON W.ID_F=F.ID_F WHERE ID_U LIKE '".$userId."' AND ID_KASETY IN (SELECT ID_KASETY FROM WYDARZENIA WHERE data_wyp is null and data_zwrotu is null)";
		$res = $this->system->Query($sql);
		return $res;
	}
	
	function DelRezerw($kasetaId){ //zapisuje do bazy zwrot kasety

		$sql = "DELETE FROM WYDARZENIA WHERE ID_KASETY LIKE '".$kasetaId."' AND (DATA_WYP IS NULL AND DATA_ZWROTU IS NULL)";
		$res = $this->system->Query($sql,0);
		return $res;
	} 
}
?>