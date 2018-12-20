<?php
include 'begin.php';
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );
//T::dumpa($_POST);
$devices = $webcare->device->GetDevices();
$smarty->assign('devices', $devices);

function Strony($devices,$countPage){
	global $smarty;
	$pagerOptions = array(
		    'mode'     => 'Sliding',
		    'delta'    => 1,
		    'perPage'  => $countPage,
		    'itemData' => $devices,
		);
		$pager =& Pager::factory($pagerOptions);
		
		$data = $pager->getPageData();
		if (!is_array($data)) {
		$data = array();
		}
		$smarty->assign('devices', $data);
		$smarty->assign('pager_links', $pager->links);
		$smarty->assign(
		'page_numbers', array(
        'current' => $pager->getCurrentPageID(),
        'total'   => $pager->numPages()
						)
		);
		}

if(!empty($_GET['device'])){

	if($_GET['device']=='list'){
		Strony($devices,20);
		//T::dumpa($devices);
		$smarty->display("list_devices.tpl");
		}
		

// dodawanie nowego modelu
////////////////////////////////
	elseif($_GET['device']=='new'){
		if(!empty($_POST['new'])){
			
			if(!empty($_POST['manuf'])&&!empty($_POST['model'])){
			$add = $webcare->device->AddModel($_POST);
			$_POST = '';
			$smarty->assign('addOK','Dodano nowe urządzenie');
			$smarty->display("add_device.tpl");
			}
			else {
					$smarty->assign('addNO','puste pole lub nieprawidłowe dane');
					$smarty->display("add_device.tpl");
					}
		}
		else{$smarty->display("add_device.tpl");}
	}
// wylogowanie
////////////////
	elseif($_GET['device']=='logout'){
	      $_SESSION['device']='';
			$smarty->display("index.tpl");
			exit();
	}
// usuwanie deviceu
/////////////////////////
	elseif($_GET['device']=='delete' && !empty($_GET['deviceId'])){
			$delete = $webcare->device->Deletedevice($_GET['deviceId']);
			header("Location: device.php?device=list");

	}

// EDYCJA deviceu
////////////////////////////////
	elseif($_GET['device']=='edit'){
			$device = $webcare->device->Getdevice($_GET['deviceId']);
			//T::dumpa($device);
			$smarty->assign('device', $device);
				if(!empty($_POST['edit'])){
					//T::dumpa($_POST);
					$add = $webcare->device->Editdevice($_POST);
					$_POST = '';
					header("Location: device.php?device=list");
				}
				else{$smarty->display("edit_device.tpl");}
			}	
	
}	

if(!empty($_GET['part'])){
	
	$parts = $webcare->device->GetTable('part');
	$smarty->assign('parts', $parts);
	
	if($_GET['part']=='list'){
		Strony($parts,20);
		//T::dumpa($parts);
		$smarty->display("list_parts.tpl");
		}
		
	elseif($_GET['part']=='new'){
	
		if(!empty($_POST['new'])){
			//T::dumpa($_POST);
			$add = $webcare->device->AddPart($_POST);
			$_POST = '';
			$smarty->assign('AddOk',true);
			$smarty->display("add_part.tpl");
		}
		else{$smarty->display("add_part.tpl");}
	}
	
	
	}
?>
