<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 * @author Piotr Szczerbowski
 */

function smarty_function_pokaz_lata($params, &$smarty) {
	$dzien = $params['atualna_data'];
	$contents = "";
	for($i=1;$i<32;$i++) {
		$contents =. "<option ".( ( $i == $dzien ) ? "selected" : NULL )." value=\"".$i."\">".$i."</option>";
	}
	return $contents;
} 
?>
