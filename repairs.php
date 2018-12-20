<?php
include 'begin.php';
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );



empty($_SESSION['repair_sort_desc']) ? $_SESSION['repair_sort_desc']='' : '';
empty($_SESSION['repair_sort']) ? $_SESSION['repair_sort']='' : '';
empty($_SESSION['repair_closed']) ? $_SESSION['repair_closed']='' : '';

if(!empty($_GET['sort'])){
	$_SESSION['repair_sort'] = $_GET['sort'];
	$_SESSION['repair_sort_desc'] == 'desc' ? $_SESSION['repair_sort_desc'] = 'asc' : $_SESSION['repair_sort_desc'] = 'desc';
	}
if(!empty($_GET['closed'])){
	$_SESSION['repair_closed'] = $_GET['closed'];
	}
	else {$_SESSION['repair_closed']=0;}
	

$repairs = $webcare->repair->GetRepairs($_SESSION['repair_sort'], $_SESSION['repair_sort_desc'],$_SESSION['repair_closed']);
$smarty->assign('repairs', $repairs);

function Strony($repairs,$countPage){
	global $smarty;
	$pagerOptions = array(
		    'mode'     => 'Sliding',
		    'delta'    => 1,
		    'perPage'  => $countPage,
		    'itemData' => $repairs,
			'altPage' => 'strona'
		);
		$pager =& Pager::factory($pagerOptions);
		
		$data = $pager->getPageData();
		if (!is_array($data)) {
		$data = array();
		}
		$smarty->assign('repairs', $data);
		$smarty->assign('pager_links', $pager->links);
		$smarty->assign(
		'page_numbers', array(
        'current' => $pager->getCurrentPageID(),
        'total'   => $pager->numPages()
						)
		);
		}

if(!empty($_GET['repair'])){

	if($_GET['repair']=='list'){
	
		////sprawdzanie różnicy dat
		$N = count($repairs);
		$czasTeraz = new DateTime;
		
		for($i=0; $i < $N; $i++){
			$r=$repairs[$i]['Reqes_D'];
			$czasRozp = new DateTime($r);
			$roznica = date_diff($czasTeraz, $czasRozp);
			//echo $czasRozp->diff($czasTeraz)->days.'<br>';
			$czas = $czasRozp->diff($czasTeraz)->days;
			$repairs[$i]['repairdays'] = $czas;
			
		}
		////end sprawdzanie różnicy dat
		$smarty->assign('repairs', $repairs);
		Strony($repairs,15);
		//T::dumpa($_SESSION);
		$smarty->display("list_repairs.tpl");
		}
	
	elseif($_GET['repair']=='search'){
		
		if(!empty($_POST)){
		$_SESSION['addWhere'] = '';
		$addWhere = '';
		!empty($_POST['id_repair']) ? $addWhere.=" and id_repair =  ".$_POST['id_repair']."":'';
		!empty($_POST['nr_ser']) ? $addWhere.=" and nr_ser like '%".$_POST['nr_ser']."%'" : '';
		!empty($_POST['klient']) ? $addWhere.=" and (nazwa like '%".$_POST['klient']."%' or nazwa2 like '%".$_POST['klient']."%')" : '';
		!empty($_POST['nazwa']) ? $addWhere.=" and nazwa like '%".$_POST['nazwa']."%'" : '';
		!empty($_POST['manuf']) ? $addWhere.=" and manuf like '%".$_POST['manuf']."%'" : '';
		!empty($_POST['model']) ? $addWhere.=" and model like '%".$_POST['model']."%'" : '';
		$_SESSION['addWhere'] = $addWhere;
		}
		
		$repairs = $webcare->repair->SearchRepairs($_SESSION['addWhere']);
		$smarty->assign('repairs', $repairs);
		Strony($repairs,15);
		$smarty->display("list_repairs.tpl");
		
		}
		
		

// dodawanie nowegej naprawy
////////////////////////////////
	elseif($_GET['repair']=='new'){
		if(!empty($_POST['new'])){
			T::dumpa($_POST);
			
			$newRepair = $webcare->repair->AddRepair($_POST);
			$repairs = $webcare->repair->SearchRepairs($_POST);
			$smarty->assign('repairs', $repairs);
			Strony($repairs,15);
			$smarty->display("list_repairs.tpl");
			
		}
		else{
			$lastId = null;
			$lastId = $webcare->repair->LastId('repairs','id_repair');
			$lastId = $lastId + 1;
			$smarty->assign('lastId', $lastId);
			$model = $webcare->repair->GetModel();
			$smarty->assign('model', $model);
			$customers = $webcare->user->GetCustomers();
			$smarty->assign('customers', $customers);
			//T::dumpa($customers);
			$smarty->display("add_repair.tpl");
			}
	}
// wylogowanie
////////////////
	elseif($_GET['repair']=='logout'){
	      $_SESSION['repair']='';
			$smarty->display("index.tpl");
			exit();
	}


// EDYCJA repair
////////////////////////////////
	elseif($_GET['repair']=='edit'){
				if(!empty($_GET['repairId'])){
						
						//pobranie danych dotyczÄ…cych naprawy
						$repair = $webcare->repair->GetRepair($_GET['repairId']);
						$smarty->assign('repair', $repair);
						$model = $webcare->repair->GetModel();
						$smarty->assign('model', $model);
						$servStatus = $webcare->repair->GetServStatus();
						$smarty->assign('servStatus', $servStatus);
						$TypNapr = $webcare->repair->GetTypNapr();
						$smarty->assign('TypNapr', $TypNapr);
						$RodzNapr = $webcare->repair->GetRodzNapr();
						$smarty->assign('RodzNapr', $RodzNapr);
						$serwisanci = $webcare->repair->GetTable('serwisant');
						$smarty->assign('serwisanci', $serwisanci);
						$status_koszt = $webcare->repair->GetTable('status_kosztorys');
						$smarty->assign('status_koszt', $status_koszt);
						$RepairParts = $webcare->repair->GetRepairParts($_GET['repairId']);
						$smarty->assign('RepairParts', $RepairParts);
						$parts = $webcare->repair->GetTable('part');
						$smarty->assign('parts', $parts);
						$serwisy = $webcare->repair->GetTable('serwisy');
						$smarty->assign('serwisy',$serwisy);
						//T::dumpa($RepairParts);
						
						
																	
				}
				
					if(!empty($_POST['edit'])){
						//T::dumpa($_POST);
						// validate after a POST
						SmartyValidate::connect($smarty);
						if(SmartyValidate::is_valid($_POST)) {
							// no errors, done with SmartyValidate
							$add = $webcare->repair->EditRepair($_POST);
							//dodanie czesci do naprawy
							if(isset($_POST['part'])) {	$part = $_POST['part'];} else {$part = null;}
							if(isset($_POST['lokal'])) { $lokal = $_POST['lokal'];} else {$lokal = null;}
							if(isset($_POST['napr'])) { $napr = $_POST['napr'];} else {$napr = null;}
							if(isset($_POST['faktura'])) { $faktura = $_POST['faktura'];} else {$faktura = null;}
							
							if(!empty($part)){
								$N = count($part);
								for($i=0; $i < $N; $i++){
									//echo $part[$i];
									if(!empty($part[$i])){
									$add = $webcare->repair->AddPartToRepair($_POST,$part[$i],$lokal[$i],$napr[$i],$faktura[$i]);
									}
								}
							}
							///////
							$_POST = '';
							SmartyValidate::disconnect();
							//Strony($repairs,15);
							//$smarty->display("list_repairs.tpl");
							header("Location: repairs.php?repair=list");
						}
						else {
							   // bĹ‚Ä…d walidacji,ponowne wczytanie danych formularza
							   $smarty->assign($_POST);
							   //T::dumpa($_POST);
								$repair = $webcare->repair->GetRepair($_POST['id_naprawy']);
								$smarty->assign('repair', $repair);
								$model = $webcare->repair->GetModel();
								$smarty->assign('model', $model);
								$servStatus = $webcare->repair->GetServStatus();
								$smarty->assign('servStatus', $servStatus);
								$TypNapr = $webcare->repair->GetTypNapr();
								$smarty->assign('TypNapr', $TypNapr);
								$RodzNapr = $webcare->repair->GetRodzNapr();
								$smarty->assign('RodzNapr', $RodzNapr);
								$serwisanci = $webcare->repair->GetTable('serwisant');
								$smarty->assign('serwisanci', $serwisanci);
								$status_koszt = $webcare->repair->GetTable('status_kosztorys');
								$smarty->assign('status_koszt', $status_koszt);
								$RepairParts = $webcare->repair->GetRepairParts($_GET['repairId']);
								$smarty->assign('RepairParts', $RepairParts);
								$parts = $webcare->repair->GetTable('part');
								$smarty->assign('parts', $parts);
								$serwisy = $webcare->repair->GetTable('serwisy');
								$smarty->assign('serwisy',$serwisy);
							   $smarty->display("edit_repair.tpl");
						 }
					}
					else{
						SmartyValidate::connect($smarty, true);
						SmartyValidate::register_validator('fullname', 'klient', 'notEmpty');
						SmartyValidate::register_validator('numer_seryjny', 'numer_seryjny', 'notEmpty');
						$smarty->display("edit_repair.tpl");
						}
				
			}
			
			
			
			
	////////////////generowanie raportu//////////		
	elseif($_GET['repair']=='rep_generate'){
			$doRaportu = $webcare->repair->Reports('1');
			$smarty->assign('doRaportu',$doRaportu);
			
			if(!empty($_GET['to_report'])){
			$doRaportu = $webcare->repair->Reports('0');
			$smarty->assign('doRaportu',$doRaportu);
			$smarty->display("list_reports.tpl");
			}
			
			//T::dumpa($doRaportu);
			elseif(!empty($_POST['generate'])){
				$rap = $_POST['raport'];
				$N = count($rap);
				$zlec = "Claim_No;ServStatusID;ServStatus;ServStatus_D;Reason;CompCode;ServCod;SabCod;Local_Point;RepFromAsc;RepOutAsc;Id_Rep1;Id_Rep2;Id_Rep3;Cons_Data;Cons_Name;Cons_Name2;Country;Cons_Addr1;Cons_Addr2;Cons_Addr3;Post_code;Cons_Tel1;Cons_Tel2;Model_ID;Model_Name;Model_Cod;Model_Mark;Serial_No;Gwaran_No;Purch_D;ReqZleDealer;Reqes_D;Start_D;Compl_D;ETD_D;GiveOut_D;AuthorNo;RepairNo;Dealer_ID;Dealer;InvoceNo;InvoceDate;Technic;Remarks;Id_Transp;Out_D;Out_Doc;In_D;In_Doc;Distance;Par_Cost;Lab_Cost;Tra_Cost;Oth_Cost;Tot_Cost;Def_Desc;Rep_Desc;Nsc_Desc;Oth_Desc;Condit_C;Symptom_C;CRT_Ser;CRT_Man;Old_Firmware;New_Firmware;Old_Mb_Serial_No;New_Mb_Serial_No;Old_IMEI;New_IMEI;RFB_Parts;ReplGiveout_D;ReplRet_D;ReplModel;ReplSerialNo;ReplSpecialCode;wniosek_no;utworzono_d;rodzaj_varchar;akceptowano_d;customer_type;customer_markt1;customer_markt2;Part_Num1;Part_Nam1;Location1;Used_Qty1;Part_Aam1;InvDocNo1;Flag_C1;Sect_C1;Defect_C1;Repair_C1;OrderNo1;OrderDate1;PartsDeliveryDate1;SnNew1;SnOld1;Lab_Cod1;Lab_Nam1;Lab_Aam1;Part_Num2;Part_Nam2;Location2;Used_Qty2;Part_Aam2;InvDocNo2;Flag_C2;Sect_C2;Defect_C2;Repair_C2;OrderNo2;OrderDate2;PartsDeliveryDate2;SnNew2;SnOld2;Lab_Cod2;Lab_Nam2;Lab_Aam2;Part_Num3;Part_Nam3;Location3;Used_Qty3;Part_Aam3;InvDocNo3;Flag_C3;Sect_C3;Defect_C3;Repair_C3;OrderNo3;OrderDate3;PartsDeliveryDate3;SnNew3;SnOld3;Lab_Cod3;Lab_Nam3;Lab_Aam3;Part_Num4;Part_Nam4;Location4;Used_Qty4;Part_Aam4;InvDocNo4;Flag_C4;Sect_C4;Defect_C4;Repair_C4;OrderNo4;OrderDate4;PartsDeliveryDate4;SnNew4;SnOld4;Lab_Cod4;Lab_Nam4;Lab_Aam4;Part_Num5;Part_Nam5;Location5;Used_Qty5;Part_Aam5;InvDocNo5;Flag_C5;Sect_C5;Defect_C5;Repair_C5;OrderNo5;OrderDate5;PartsDeliveryDate5;SnNew5;SnOld5;Lab_Cod5;Lab_Nam5;Lab_Aam5;Part_Num6;Part_Nam6;Location6;Used_Qty6;Part_Aam6;InvDocNo6;Flag_C6;Sect_C6;Defect_C6;Repair_C6;OrderNo6;OrderDate6;PartsDeliveryDate6;SnNew6;SnOld6;Lab_Cod6;Lab_Nam6;Lab_Aam6;Part_Num7;Part_Nam7;Location7;Used_Qty7;Part_Aam7;InvDocNo7;Flag_C7;Sect_C7;Defect_C7;Repair_C7;OrderNo7;OrderDate7;PartsDeliveryDate7;SnNew7;SnOld7;Lab_Cod7;Lab_Nam7;Lab_Aam7;Part_Num8;Part_Nam8;Location8;Used_Qty8;Part_Aam8;InvDocNo8;Flag_C8;Sect_C8;Defect_C8;Repair_C8;OrderNo8;OrderDate8;PartsDeliveryDate8;SnNew8;SnOld8;Lab_Cod8;Lab_Nam8;Lab_Aam8;Part_Num9;Part_Nam9;Location9;Used_Qty9;Part_Aam9;InvDocNo9;Flag_C9;Sect_C9;Defect_C9;Repair_C9;OrderNo9;OrderDate9;PartsDeliveryDate9;SnNew9;SnOld9;Lab_Cod9;Lab_Nam9;Lab_Aam9;Part_Num10;Part_Nam10;Location10;Used_Qty10;Part_Aam10;InvDocNo10;Flag_C10;Sect_C10;Defect_C10;Repair_C10;OrderNo10;OrderDate10;PartsDeliveryDate10;SnNew10;SnOld10;Lab_Cod10;Lab_Nam10;Lab_Aam10;Zlec_ID;XML_TR_NO;Status_D;Status;Status_ID"."\r\n";
				$ServStatus_D = date('Y-m-d H:i:s');
				for($i=0; $i < $N; $i++)
					{
					  $r = $webcare->repair->GetRepair($rap[$i]);
					  
					  
					  /////wycięcie znaków ; i enter
					  $znaki = array(';', "\r", "\n");
					$zamien_na   = array('', '', '');
					  $klucze = array_keys($r['0']);
					  $ilosc_elementow = count($klucze);
					  for($x = 0; $x < $ilosc_elementow; $x++) {

							//echo $klucze[$x] . ': ' . $r['0'][$klucze[$x]] . '<br>';
							//$text = $r['0'][$klucze[$x]];
							$r['0'][$klucze[$x]] = str_replace($znaki, $zamien_na, $r['0'][$klucze[$x]]);
							//echo '<br>po usunieciu:  ';
							//echo $klucze[$x] . ': ' . $r['0'][$klucze[$x]] . ' koniec<br>';
						}
						////end wycięcie
					  
					  if ($r['0']['id_Transp']==1) {$transp = 'Y';} else {$transp = 'N';}
					  $zlec.= "".$r['0']['id_repair'].";13;".$r['0']['ServStatus'].";$ServStatus_D; ;;331;;;0;0;".$r['0']['kod_typ_napr'].";".$r['0']['kod_rodzNaprawy'].";;1;".$r['0']['nazwa'].";".$r['0']['nazwa2'].";PL;".$r['0']['adrr'].";".$r['0']['adrr2'].";".$r['0']['adrr3'].";".$r['0']['kod_poczt'].";".$r['0']['Cons_Tel1'].";;;".$r['0']['model'].";".$r['0']['model'].";;".$r['0']['nr_ser'].";;".$r['0']['Purch_D'].";;".$r['0']['Reqes_D'].";".$r['0']['Start_D'].";;".$r['0']['Reqes_D'].";;;".$r['0']['id_repair'].";;;;;".$r['0']['serwisant_name'].";;$transp;;;;;;;;;;;".$r['0']['Def_Desc'].";".$r['0']['Rep_Desc'].";;;1;810;".$r['0']['CRT_Ser'].",".$r['0']['CRT_Man'].";;;;;;;; ; ; ; ; ; ; ; ; ; ; ; ;;;;;;;;;;;;;; ; ;;;;;;;;;;;;;;;;; ; ;;;;;;;;;;;;;;;;; ; ;;;;;;;;;;;;;;;;; ; ;;;;;;;;;;;;;;;;; ; ;;;;;;;;;;;;;;;;; ; ;;;;;;;;;;;;;;;;; ; ;;;;;;;;;;;;;;;;; ; ;;;;;;;;;;;;;;;;; ; ;;;;;;;;;;;;;;;;; ; ;;;;;331".$r['0']['id_repair'].";;$ServStatus_D;".$r['0']['ServStatus'].";1"."\r\n";
					$zaraportowane = $webcare->repair->ToReport($r['0']['id_repair'],'zaraportowane');
					}	
				$plik = fopen("raport.csv", "w");
				/*$zawartosc = "Claim_No;ServStatusID;ServStatus;ServStatus_D;Reason;CompCode;ServCod;SabCod;Local_Point;RepFromAsc;RepOutAsc;Id_Rep1;Id_Rep2;Id_Rep3;Cons_Data;Cons_Name;Cons_Name2;Country;Cons_Addr1;Cons_Addr2;Cons_Addr3;Post_code;Cons_Tel1;Cons_Tel2;Model_ID;Model_Name;Model_Cod;Model_Mark;Serial_No;Gwaran_No;Purch_D;ReqZleDealer;Reqes_D;Start_D;Compl_D;ETD_D;GiveOut_D;AuthorNo;RepairNo;Dealer_ID;Dealer;InvoceNo;InvoceDate;Technic;Remarks;Id_Transp;Out_D;Out_Doc;In_D;In_Doc;Distance;Par_Cost;Lab_Cost;Tra_Cost;Oth_Cost;Tot_Cost;Def_Desc;Rep_Desc;Nsc_Desc;Oth_Desc;Condit_C;Symptom_C;CRT_Ser;CRT_Man;Old_Firmware;New_Firmware;Old_Mb_Serial_No;New_Mb_Serial_No;Old_IMEI;New_IMEI;RFB_Parts;ReplGiveout_D;ReplRet_D;ReplModel;ReplSerialNo;ReplSpecialCode;wniosek_no;utworzono_d;rodzaj_varchar;akceptowano_d;customer_type;customer_markt1;customer_markt2;Part_Num1;Part_Nam1;Location1;Used_Qty1;Part_Aam1;InvDocNo1;Flag_C1;Sect_C1;Defect_C1;Repair_C1;OrderNo1;OrderDate1;PartsDeliveryDate1;SnNew1;SnOld1;Lab_Cod1;Lab_Nam1;Lab_Aam1;Part_Num2;Part_Nam2;Location2;Used_Qty2;Part_Aam2;InvDocNo2;Flag_C2;Sect_C2;Defect_C2;Repair_C2;OrderNo2;OrderDate2;PartsDeliveryDate2;SnNew2;SnOld2;Lab_Cod2;Lab_Nam2;Lab_Aam2;Part_Num3;Part_Nam3;Location3;Used_Qty3;Part_Aam3;InvDocNo3;Flag_C3;Sect_C3;Defect_C3;Repair_C3;OrderNo3;OrderDate3;PartsDeliveryDate3;SnNew3;SnOld3;Lab_Cod3;Lab_Nam3;Lab_Aam3;Part_Num4;Part_Nam4;Location4;Used_Qty4;Part_Aam4;InvDocNo4;Flag_C4;Sect_C4;Defect_C4;Repair_C4;OrderNo4;OrderDate4;PartsDeliveryDate4;SnNew4;SnOld4;Lab_Cod4;Lab_Nam4;Lab_Aam4;Part_Num5;Part_Nam5;Location5;Used_Qty5;Part_Aam5;InvDocNo5;Flag_C5;Sect_C5;Defect_C5;Repair_C5;OrderNo5;OrderDate5;PartsDeliveryDate5;SnNew5;SnOld5;Lab_Cod5;Lab_Nam5;Lab_Aam5;Part_Num6;Part_Nam6;Location6;Used_Qty6;Part_Aam6;InvDocNo6;Flag_C6;Sect_C6;Defect_C6;Repair_C6;OrderNo6;OrderDate6;PartsDeliveryDate6;SnNew6;SnOld6;Lab_Cod6;Lab_Nam6;Lab_Aam6;Part_Num7;Part_Nam7;Location7;Used_Qty7;Part_Aam7;InvDocNo7;Flag_C7;Sect_C7;Defect_C7;Repair_C7;OrderNo7;OrderDate7;PartsDeliveryDate7;SnNew7;SnOld7;Lab_Cod7;Lab_Nam7;Lab_Aam7;Part_Num8;Part_Nam8;Location8;Used_Qty8;Part_Aam8;InvDocNo8;Flag_C8;Sect_C8;Defect_C8;Repair_C8;OrderNo8;OrderDate8;PartsDeliveryDate8;SnNew8;SnOld8;Lab_Cod8;Lab_Nam8;Lab_Aam8;Part_Num9;Part_Nam9;Location9;Used_Qty9;Part_Aam9;InvDocNo9;Flag_C9;Sect_C9;Defect_C9;Repair_C9;OrderNo9;OrderDate9;PartsDeliveryDate9;SnNew9;SnOld9;Lab_Cod9;Lab_Nam9;Lab_Aam9;Part_Num10;Part_Nam10;Location10;Used_Qty10;Part_Aam10;InvDocNo10;Flag_C10;Sect_C10;Defect_C10;Repair_C10;OrderNo10;OrderDate10;PartsDeliveryDate10;SnNew10;SnOld10;Lab_Cod10;Lab_Nam10;Lab_Aam10;Zlec_ID;XML_TR_NO;Status_D;Status;Status_ID
					801211;13;W NAPRAWIE;2012-11-13 15:56:50; ;;331;;;0;0;IH;FL;;1;Tajkun;Warszawa;;Warszawa;Staniewicka;18;03310;99;;;CLX-8385NX/SEE;CLX-8385NX/SEE;;Z534B1CB600056K;;2012-04-30;;2012-11-13 15:34:00;2012-11-13 15:35:00;;2012-11-15 15:34:00;;;0;;;;;w.kubatin;;N;;;;;;;;;;;Błąd sekcji grzewczej. ;Wymiana sekcji grzewczej. ;;;1;810;44487;V2.00.03.01;;;;;;;; ; ; ; ; ; ; ; ; ; ; ; ;JC96-04868A;FUSER;CLX;1;0;;;;N;Z;;;; ; ;;;;;;;;0;;;;;;;;; ; ;;;;;;;;0;;;;;;;;; ; ;;;;;;;;0;;;;;;;;; ; ;;;;;;;;0;;;;;;;;; ; ;;;;;;;;0;;;;;;;;; ; ;;;;;;;;0;;;;;;;;; ; ;;;;;;;;0;;;;;;;;; ; ;;;;;;;;0;;;;;;;;; ; ;;;;;;;;0;;;;;;;;; ; ;;;;331801211;;2012-11-13 15:56:50;UZUPELNIONE;2
					";
				*/
				$fwrite = fwrite($plik, $zlec);
				if ($fwrite==false or $plik==false){return $raport = "err";}
				else{
				$raport = 'ok';
				}
				$plik='raport.csv';
				$smarty->assign('plik',$plik);
				$smarty->assign('raport',$raport);
				$smarty->display("reports.tpl");
				$_POST = '';
			}
			elseif(!empty($_POST['update'])){
				//T::dumpa($_POST);
				
				if(empty($_POST['do_raportu']))
				  {
					$brak_wyboru = 1;
					$smarty->assign('brak_wyboru',$brak_wyboru);
					$doRaportu = $webcare->repair->Reports('0');
					$smarty->assign('doRaportu',$doRaportu);
					$smarty->display("list_reports.tpl");
				  }
				  else
				  {
					//ok, wybrane zlecenia do raportu,zapisuje w bazie ktore sa do raportowania
					$checkbox = $_POST['do_raportu'];
					$N = count($checkbox);
					for($i=0; $i < $N; $i++)
					{
					  $ToReport = $webcare->repair->ToReport($checkbox[$i],'do_raportu');
					}
					
					$raport = 'ok';
					$smarty->assign('raport',$raport);
					$doRaportu = $webcare->repair->Reports('0');
					$smarty->assign('doRaportu',$doRaportu);
					$smarty->display("list_reports.tpl");
				}
			}
			
			else
			$smarty->display("reports.tpl");
			
	}
	
	elseif($_GET['repair']=='printa'){
			if(!empty($_GET['repairId'])){
				$repair = $webcare->repair->GetRepair($_GET['repairId']);
				
				
				
				/////wycięcie znaków ; i enter
					  $znaki = array("\r", "\n");
					$zamien_na   = array('', '', '');
					  $klucze = array_keys($repair['0']);
					  $ilosc_elementow = count($klucze);
					  for($x = 0; $x < $ilosc_elementow; $x++) {

							//echo $klucze[$x] . ': ' . $r['0'][$klucze[$x]] . '<br>';
							//$text = $r['0'][$klucze[$x]];
							$repair['0'][$klucze[$x]] = str_replace($znaki, $zamien_na, $repair['0'][$klucze[$x]]);
							//echo '<br>po usunieciu:  ';
							//echo $klucze[$x] . ': ' . $r['0'][$klucze[$x]] . ' koniec<br>';
						}
						////end wycięcie
						
						
				$smarty->assign('repair', $repair);
				$url = "raportgwar.php?nazwa=".$repair['0']['nazwa']."&Reqes_D=".$repair['0']['Reqes_D']."&adrr2=".$repair['0']['adrr2']."&adrr=".$repair['0']['adrr']."&kod_poczt=".$repair['0']['kod_poczt']."&Cons_Tel1=".$repair['0']['Cons_Tel1']."&model=".$repair['0']['model']."&nr_ser=".$repair['0']['nr_ser']."&CRT_Ser=".$repair['0']['CRT_Ser']."&Def_Desc=".$repair['0']['Def_Desc']."&serwisant_name=".$repair['0']['serwisant_name']."&nazwa2=".$repair['0']['nazwa2']."&adrr3=".$repair['0']['adrr3']."";
				//T::dumpa($repair);
				header("Location: ".$url);
			}
			
	}
	
	elseif($_GET['repair']=='print'){
			if(!empty($_GET['repairId'])){
				$repair = $webcare->repair->GetRepair($_GET['repairId']);
				
				
				
				/////wycięcie znaków ; i enter
					  $znaki = array("\r", "\n");
					$zamien_na   = array('', '', '');
					  $klucze = array_keys($repair['0']);
					  $ilosc_elementow = count($klucze);
					  for($x = 0; $x < $ilosc_elementow; $x++) {

							//echo $klucze[$x] . ': ' . $r['0'][$klucze[$x]] . '<br>';
							//$text = $r['0'][$klucze[$x]];
							$repair['0'][$klucze[$x]] = str_replace($znaki, $zamien_na, $repair['0'][$klucze[$x]]);
							//echo '<br>po usunieciu:  ';
							//echo $klucze[$x] . ': ' . $r['0'][$klucze[$x]] . ' koniec<br>';
						}
						////end wycięcie
						
						
				$smarty->assign('repair', $repair);
				$url = "raportgwar.php?podkladka=".$_GET['image']."&nazwa=".$repair['0']['nazwa']."&Reqes_D=".$repair['0']['Reqes_D']."&adrr2=".$repair['0']['adrr2']."&adrr=".$repair['0']['adrr']."&kod_poczt=".$repair['0']['kod_poczt']."&Cons_Tel1=".$repair['0']['Cons_Tel1']."&model=".$repair['0']['model']."&nr_ser=".$repair['0']['nr_ser']."&CRT_Ser=".$repair['0']['CRT_Ser']."&Def_Desc=".$repair['0']['Def_Desc']."&serwisant_name=".$repair['0']['serwisant_name']."&nazwa2=".$repair['0']['nazwa2']."&adrr3=".$repair['0']['adrr3']."&id_repair=".$repair['0']['id_repair']."";
				//T::dumpa($repair);
				header("Location: ".$url);
				//$smarty->display("print_repair_gwar.tpl");
			}
			
	}
	
	
	

}
			
		
			
	
?>
