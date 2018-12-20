<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


function smarty_function_dictionary_view($params, &$smarty)
{
		$dictionary = $smarty->get_template_vars($params['dic']);
		$values = $params['inp'];
		
		$content = '';
		foreach($dictionary as $key => $value) {
			if(!empty($values[$key])) {
				if($content) $content .= ', '; 
				$content .= $value;
			}
		}
    return !empty($content) ? $content : 'N/A';
} 
?>
