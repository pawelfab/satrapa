<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


function smarty_function_array_size($params, &$smarty)
{
		$item = $params['arr'];

    return count($item);
} 
?>
