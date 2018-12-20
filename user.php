<?php
include 'begin.php';
include 'devices.php';
$auth= $webcare->user->Auth();
//T::dumpa($_POST);
$users = $webcare->user->GetUsers();
$smarty->assign('users', $users);


if(!empty($_GET['user'])){
	if($_GET['user']=='list'){
		//T::dumpa($_SESSION);
		
		Strony($users,9);
		$smarty->display("list_users.tpl");
	}

// dodawanie nowego użytkownika
////////////////////////////////
	elseif($_GET['user']=='new'){
		if(!empty($_POST['new'])){
			$_POST['password']=md5($_POST['password']);
			//T::dumpa($_POST);
			$add = $webcare->user->AddUser($_POST);
			$_POST = '';
			header("Location: user.php?user=list");
		}
		else{$smarty->display("add_user.tpl");}
	}
// wylogowanie
////////////////
	elseif($_GET['user']=='logout'){
	      $_SESSION['user']='';
			$smarty->display("index.tpl");
			exit();
	}
// usuwanie użytkownika
/////////////////////////
	elseif($_GET['user']=='delete' && !empty($_GET['userId'])){
		$delete = $webcare->user->DeleteUser($_GET['userId']);
		header("Location: user.php?user=list");

	}

// EDYCJA użytkownika
////////////////////////////////
	elseif($_GET['user']=='edit'){
	$user = $webcare->user->GetUser($_GET['userId']);
	//T::dumpa($user);
	
	$smarty->assign('user', $user);
		if(!empty($_POST['edit'])){
			$_POST['password']=md5($_POST['password']);
			//T::dumpa($_POST);
			$add = $webcare->user->EditUser($_POST);
			$_POST = '';
			if (!empty($_SESSION['klient'])){ //gdy operujemy na konkretnym kliencie po edycji wraca do menu klienta
				$id=$_SESSION['klient']['0']['ID_U'];
				header("Location: user.php?user=dane&userId=$id");
				
				}
				else
			header("Location: user.php?user=list");
		}
		else{$smarty->display("edit_user.tpl");}
	}



	//$smarty->display("list_users.tpl");
			

}
?>