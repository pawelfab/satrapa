<?php
require_once $smarty->_get_plugin_filepath('shared','make_timestamp');

function smarty_modifier_pl_date_format($string, $withWeekDay)
{
		$timestamp = smarty_make_timestamp($string);
    $day = date("w",$timestamp);
		$mounthDay = date("j",$timestamp);
		$mounth = date("n",$timestamp);
		$year = date("Y",$timestamp);
		
		$days = array('niedziela','poniedzia&#322;ek','wtorek','&#347;roda','czwartek','pi&#261;tek','sobota');
		$mounths = array('stycze&#324;','luty','marzec','kwiece&#324;','maj','czerwiec','lipiec','sierpie&#324;','wrzesie&#324;','pa&#378;dziernik','listopad','grudzie&#324;');
		
		
		return ($withWeekDay ? $days[$day] . ', ' : '') . $mounthDay . ' ' . $mounths[$mounth] . ' ' . $year . ' r.';
}

?>
