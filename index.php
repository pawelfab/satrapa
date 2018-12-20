<?php
include 'begin.php';

if (!empty($_SESSION['user']))
	$smarty->display("index_us.tpl");
else
	$smarty->display("index.tpl");

?>
<html>test</html>
