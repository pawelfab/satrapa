<?php
include 'begin.php';
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );
$auth= $webcare->user->Auth();
//T::dumpa($_POST);
$serwis = $webcare->serwis->GetSerwisy();
$smarty->assign('serwis', $serwis);

function StronyS($serwis,$countPage){
	global $smarty;
	$pagerOptions = array(
		    'mode'     => 'Sliding',
		    'delta'    => 1,
		    'perPage'  => $countPage,
		    'itemData' => $serwis,
		);
		$pager =& Pager::factory($pagerOptions);
		
		$data = $pager->getPageData();
		if (!is_array($data)) {
		$data = array();
		}
		$smarty->assign('serwis', $data);
		$smarty->assign('pager_links', $pager->links);
		$smarty->assign(
		'page_numbers', array(
        'current' => $pager->getCurrentPageID(),
        'total'   => $pager->numPages()
						)
		);
		}

if(!empty($_GET['serwis'])){
	if($_GET['serwis']=='list'){
		//T::dumpa($_SESSION);
		
		StronyS($serwis,15);
		$smarty->display("list_serwis.tpl");
	}

// dodawanie nowego serwisu
////////////////////////////////
	elseif($_GET['serwis']=='new'){
		if(!empty($_POST['new'])){
			if(!empty($_POST['nazwa'])&&!empty($_POST['miasto'])){
			//T::dumpa($_POST);
			$add = $webcare->serwis->AddSerwis($_POST);
			$_POST = '';
			$smarty->assign('addOK','Dodano pozycję');
			$smarty->display("add_serwis.tpl");
			}
			else {
					$smarty->assign('addNO','puste pole lub nieprawidłowe dane');
					$smarty->display("add_serwis.tpl");
				}
		}
		else{$smarty->display("add_serwis.tpl");}
	}

// usuwanie serwisu
/////////////////////////
	elseif($_GET['serwis']=='delete' && !empty($_GET['id'])){
		$delete = $webcare->serwis->DeleteSerwis($_GET['id']);
		header("Location: serwis.php?serwis=list");

	}

// EDYCJA
////////////////////////////////
	elseif($_GET['serwis']=='edit'){
	$serwis = $webcare->serwis->GetSerwis($_GET['id']);
	$smarty->assign('serwis', $serwis);
	//T::dumpa($serwis);
		if(!empty($_POST['edit'])){
			
			if(!empty($_POST['nazwa'])&&!empty($_POST['miasto'])){
				$add = $webcare->serwis->EditSerwis($_POST);
				$serwis = $webcare->serwis->GetSerwis($_GET['id']);
				$smarty->assign('serwis', $serwis);
				$_POST = '';
				$smarty->assign('addOK','Dane zostały zmienione');
				$smarty->display("edit_serwis.tpl");
					
			}
			else {
					$smarty->assign('addNO','puste pole lub nieprawidłowe dane');
					$smarty->display("edit_serwis.tpl");
					}
		}
		else{$smarty->display("edit_serwis.tpl");}
	}



	//$smarty->display("list_users.tpl");
			

}
?>