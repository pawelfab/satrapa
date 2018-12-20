<?php
$start = new DateTime('2010-06-06'); 
$end   = new DateTime('2011-02-04'); 
echo $start->diff($end)->days.'<br>';

$start = new DateTime('2005-01-01'); 
echo $start->diff($end)->days;
phpinfo();
?>