<?php
include 'begin.php';
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );


class Repair {
    
	var $system;
	var $sourceIdent = 'REPAIR';

	function Repair($system, $conf) {
		$this->system = &$system;
	}

	function UserIdent($login, $password){

		$sql = "select * from users where login like '".$login."' and haslo like '".$password."'";
		$res = $this->system->Query($sql);
		return $res;
	}
	
	function GetRepair($id_repair){

		$sql = "SELECT *
					FROM repairs
					INNER JOIN customers USING (id_customer)
					INNER JOIN devices USING (id_dev)
					INNER JOIN model USING (id_model)
					INNER JOIN status_serw USING (id_stat_serw)
					LEFT JOIN serwisy USING (id_serwis)
					LEFT JOIN rodz_napr USING (id_rodz_napr)
					LEFT JOIN typ_napr USING (id_typ_napr)
					INNER JOIN manufactur USING (id_man)
					LEFT JOIN serwisant USING (id_serwisant)
					LEFT JOIN status_kosztorys USING (id_stat_koszt)
					WHERE id_repair='".$id_repair."'";
		$res = $this->system->Query($sql);
		return $res;
	}
	
	function GetRepairParts($id_repair){

		$sql = "SELECT *
					FROM part_conn
					LEFT JOIN part USING (id_part)
					WHERE id_repair='".$id_repair."'";
		$res = $this->system->Query($sql);
		return $res;
	}

	function GetRepairs($sort='id_repair', $desc = 'asc', $closed=''){
		
		$sort = $sort ? ' order by ' . $sort . ' ' . $desc : '';
		$closed = $closed ? ' AND Compl_D IS NOT NULL ' : ' AND Compl_D IS NULL';

		$sql = "SELECT *
					FROM repairs
					INNER JOIN customers USING (id_customer)
					INNER JOIN devices USING (id_dev)
					INNER JOIN model USING (id_model)
					INNER JOIN status_serw USING (id_stat_serw)
					LEFT JOIN serwisy USING (id_serwis)
					LEFT JOIN rodz_napr USING (id_rodz_napr)
					LEFT JOIN typ_napr USING (id_typ_napr)
					LEFT JOIN serwisant USING (id_serwisant)
					INNER JOIN manufactur USING (id_man)
					LEFT JOIN status_kosztorys USING (id_stat_koszt)
					WHERE 1=1 $closed $sort";
		$res = $this->system->Query($sql);
		//T::dumpa($sql);
		return $res;
	}

	function AddDevice($inp){

		$sql = "INSERT INTO devices (id_model,nr_ser) VALUES ('".$inp['model_id']."', '".$inp['nr_ser']."')";
		$res = $this->system->Query($sql,0);
		return $res;

	}
	
		
	function EditRepair($inp){
		if (empty($inp['gwar'])) { $gwar=0;} else {$gwar=$inp['gwar'];};
		if (empty($inp['id_Transp'])) { $id_Transp=0;} else {$id_Transp=$inp['id_Transp'];};
		if (empty($inp['do_raportu'])) { $do_raportu=0;} else {$do_raportu=$inp['do_raportu'];};
		if (empty($inp['zaraportowane'])) { $zaraportowane=0;} else {$zaraportowane=$inp['zaraportowane'];};
		if (empty($inp['status_koszt'])) { $id_stat_koszt="''";} else {$id_stat_koszt=$inp['status_koszt'];};
		if (empty($inp['Compl_D'])) { $Compl_D='null';} else {$Compl_D="'".$inp['Compl_D']."'";};
		

		$sql = "UPDATE customers SET nazwa = '".$inp['klient']."', nazwa2 = '".$inp['klient2']."', adrr = '".$inp['miasto']."', adrr2 = '".$inp['ulica']."', adrr3 = '".$inp['nrdomu']."', kod_poczt = '".$inp['kod_poczt']."', Cons_Tel1 = '".$inp['nr_tel']."' WHERE id_customer = '".$inp['KlientId']."'";
		$res = $this->system->Query($sql,0);
		$sql = "UPDATE devices SET id_model = (SELECT id_model FROM model WHERE model LIKE '".$inp['chosenm']."' LIMIT 1), nr_ser = '".$inp['numer_seryjny']."', Purch_D = '".$inp['Purch_D']."', CRT_Ser = '".$inp['CRT_Ser']."' WHERE id_dev = '".$inp['DeviceId']."'";
		//T::dumpa($sql);
		$res = $this->system->Query($sql,0);
		$sql = "UPDATE repairs SET Compl_D = $Compl_D, id_stat_serw = '".$inp['ServStatus']."', id_rodz_napr = '".$inp['RodzNapr']."', id_typ_napr = '".$inp['TypNapr']."', Start_D = '".$inp['Start_D']."', Reqes_D = '".$inp['Reqes_D']."', id_serwisant = '".$inp['Serwisant']."', Par_Cost = '".$inp['Par_Cost']."', Lab_Cost = '".$inp['Lab_Cost']."', Tra_Cost = '".$inp['Tra_Cost']."', Oth_Cost = '".$inp['Oth_Cost']."', Def_Desc = '".$inp['Def_Desc']."', Rep_Desc = '".$inp['Rep_Desc']."',zaraportowane = $zaraportowane, do_raportu = $do_raportu, gwar = $gwar, id_Transp = $id_Transp, id_stat_koszt = $id_stat_koszt, id_serwis = '".$inp['serwisy']."' WHERE id_repair = '".$inp['id_naprawy']."'";
		//T::dumpa($sql);
		$res = $this->system->Query($sql,0);
		$sql = "DELETE FROM part_conn WHERE id_repair = '".$inp['id_naprawy']."'";
		$res = $this->system->Query($sql,0);
		return $res;

	}
	
	
	function AddPartToRepair($inp,$part,$lokal,$napr,$faktura){
		//T::dumpa($inp);
		//T::dumpa($part);
		$sql = "INSERT INTO part_conn (id_part,id_repair, lokalizacja, part_conn_napr, part_conn_fv) VALUES ($part, ".$inp['id_naprawy'].", '$lokal', '$napr', '$faktura')";
		//T::dumpa($sql);
		$res = $this->system->Query($sql,0);
		//(id_part,id_repair,lokalizacja,part_conn_napr,part_conn_fv)
		return $res;
	}
	
	
	function Reports($doraportu = '0'){
		
		$sql = "SELECT *
					FROM repairs
					INNER JOIN customers USING (id_customer)
					INNER JOIN devices USING (id_dev)
					INNER JOIN model USING (id_model)
					INNER JOIN status_serw USING (id_stat_serw)
					LEFT JOIN rodz_napr USING (id_rodz_napr)
					LEFT JOIN typ_napr USING (id_typ_napr)
					LEFT JOIN serwisant USING (id_serwisant)
					INNER JOIN manufactur USING (id_man)
					WHERE zaraportowane=0 AND gwar=1 AND do_raportu = $doraportu";
					
		$res = $this->system->Query($sql);
		return $res;
	}
	
	function ToReport($id,$record){
	
		$sql = "UPDATE repairs SET $record = 1 WHERE id_repair = $id";
		$res = $this->system->Query($sql,0);
		return $res;
	}
	
	function GetChosenModel($id_repair){
		$sql = "SELECT model FROM repairs INNER JOIN devices USING (id_dev)
											INNER JOIN model USING (id_model)
											WHERE id_repair='".$id_repair."'";
		$res = $this->system->mysql_evaluate($sql);
		return $res;
	
	}
	
	
	function GetModel(){
		
		$sql = "select model,manuf,id_model from model,manufactur where model.id_man=manufactur.id_man";
		$res = $this->system->Query($sql);
		return $res;
	}
	
	function GetServStatus(){
		
		$sql = "select * from status_serw";
		$res = $this->system->Query($sql);
		return $res;
	}
	
	function GetTypNapr(){
		
		$sql = "select * from typ_napr";
		$res = $this->system->Query($sql);
		return $res;
	}
	
	function GetRodzNapr(){
		
		$sql = "select * from rodz_napr";
		$res = $this->system->Query($sql);
		return $res;
	}
	
	function GetManufactur(){
		
		$sql = "select * from manufactur";
		$res = $this->system->Query($sql);
		return $res;
	}
	
	function GetTable($table){
		
		$sql = "select * from $table";
		$res = $this->system->Query($sql);
		return $res;
	}
	
	function SearchRepairs($search){
		
		$sql = "SELECT *
					FROM repairs
					INNER JOIN customers USING (id_customer)
					INNER JOIN devices USING (id_dev)
					INNER JOIN model USING (id_model)
					INNER JOIN manufactur USING (id_man) where 1=1 $search";
		$res = $this->system->Query($sql);
		//T::dumpa($sql);
		return $res;
	}
	
	
	function AddRepair($inp){
		$verify = $this->CheckSerialNr($inp['nr_ser']);
			if($verify == false){
			
						//wprowadzenie nowego urzadzenia jeœli nie by³o go wczeœniej w bazie
						$addDevice = $this->AddDevice($inp);
						//odczyt id ostatniego wprowadzonego urzadzenia
						$idDev = $this->LastId('devices','id_dev');
					
					}
					
			else if ($verify == true) {
				//urz¹dzenie jest w bazie i pobieram jego dane
				$device = $this->GetDevice($inp['nr_ser']);			
				$idDev = $device[0]['id_dev'];
				//T::dumpa($device);
			
			}
						
			if (!empty($inp['customer_id'])){
						$user = $_SESSION['user']['0']['ID_U'];
						//wprowadzenie nowej napawy gdy klient ju¿ by³ w bazie
						$sql = "INSERT INTO repairs (id_repair,id_customer,id_dev,id_user,Reqes_D,Start_D) VALUES ('".$inp['id_naprawy']."','".$inp['customer_id']."',$idDev,$user,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
						$res = $this->system->Query($sql,0);
						//T::dumpa($sql);
						return $res;
			}
			
			else if(!empty($inp['nazwa'])){
				$user = $_SESSION['user']['0']['ID_U'];
				//dodanie nowego klienta
				$addKlient = $this->AddKlient($inp);
				//odczyt id ostatniego wprowadzonego klienta
				$idCustomer = $this->LastId('customers','id_customer');
				//T::dumpa($idCustomer);
				//wprowadzenie nowej napawy 
				$sql = "INSERT INTO repairs (id_repair,id_customer,id_dev,id_user,Reqes_D,Start_D) VALUES ('".$inp['id_naprawy']."',$idCustomer,$idDev,$user,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
				$res = $this->system->Query($sql,0);
				//T::dumpa($sql);
				return $res;
				
			}
			
			
			
					
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
	
	
	function AddKlient($inp){
			$sql = "INSERT INTO customers (nazwa,nazwa2,adrr,adrr2,adrr3,kod_poczt,Cons_Tel1) VALUES ('".$inp['nazwa']."','".$inp['nazwa2']."','".$inp['adres']."','".$inp['adrr2']."','".$inp['adrr3']."','".$inp['kod_poczt']."','".$inp['Cons_Tel1']."')";
			$res = $this->system->Query($sql,0);
			return $res;
	
	}
	
	function LastId($table,$id){
			$sql = "SELECT $id FROM $table ORDER BY $id DESC LIMIT 1";
			$resId = $this->system->mysql_evaluate($sql,0);
			return $resId;
			
	}
	
	function GetDevice($deviceSerial){

		
		$sql = "select * from devices where nr_ser='$deviceSerial'";
		$res = $this->system->Query($sql);
		return $res;
	}
	
	///////////////////////////////////
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
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