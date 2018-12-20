<?php


class User {

	var $system;
	var $sourceIdent = 'USER';

	function User($system, $conf) {
		$this->system = &$system;
	}
	
	function Auth(){
	if(!isset($_SESSION["user"]) || $_SESSION["user"]=='u') {include('login.php'); return;}
	}

	function UserIdent($login, $password){

		$sql = "select * from users where login like '".$login."' and haslo like '".$password."'";
		$res = $this->system->Query($sql);
		return $res;
	}

	function GetUsers(){

		$sql = "select * from users where AUTH like 'u'";
		$res = $this->system->Query($sql);
		return $res;
	}
	
	function GetCustomers(){

		$sql = "select * from customers";
		$res = $this->system->Query($sql);
		return $res;
	}

	function AddUser($inp){

		$sql = "insert into users (login, haslo, imie, nazwisko, adres, pesel, telefon) VALUES
		('".$inp['login']."','".$inp['password']."','".$inp['name']."','".$inp['surname']."','".$inp['adres']."','".$inp['pesel']."','".$inp['telefon']."')";
		$res = $this->system->Query($sql,0);
		return $res;

	}
	
	function EditUser($inp){

		$sql = "update users set login='".$inp['login']."', haslo='".$inp['password']."', imie='".$inp['name']."', nazwisko='".$inp['surname']."', adres='".$inp['adres']."', pesel='".$inp['pesel']."', telefon='".$inp['telefon']."' where ID_U='".$inp['userId']."'";
		$res = $this->system->Query($sql,0);
		return $res;

	}

	function DeleteUser($userId){

		$sql = "delete from users where ID_U = ".$userId."";
		$res = $this->system->Query($sql,0);
		return $res;

	}
	
	function GetUser($userId){

		$sql = "select * from users where ID_U='".$userId."'";
		$res = $this->system->Query($sql);
		return $res;
	}
	
	function GetRezerw($userId){ //sprawdza wszystkie wypozyczenia i rezerwacje klienta dla historii wypozyczeñ
		$sql = "SELECT ID_KASETY,TYTUL,DATA_WYP,DATA_ZWROTU,DATA_REZERW FROM WYDARZENIA W JOIN FILMY F ON W.ID_F=F.ID_F WHERE ID_U LIKE '".$userId."'";
		$res = $this->system->Query($sql);
		return $res;
	}
}
?>