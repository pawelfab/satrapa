<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty upper modifier plugin
 *
 * Type:     modifier<br>
 * Name:     upper<br>
 * Purpose:  convert string to uppercase
 * @link http://smarty.php.net/manual/en/language.modifier.upper.php
 *          upper (Smarty online manual)
 * @param string
 * @return string
 */
function smarty_modifier_icon($string)
{
		$mime_types = array( 
			'gif' => 'image/gif', 
			'jpg' => 'image/jpeg', 
			'jpeg' => 'image/jpeg', 
			'jpe' => 'image/jpeg', 
			'bmp' => 'image/bmp', 
			'png' => 'image/png', 
			'tif' => 'image/tiff', 
			'tiff' => 'image/tiff', 
			'pict' => 'image/x-pict', 
			'pic' => 'image/x-pict', 
			'pct' => 'image/x-pict', 
			'tif' => 'image/tiff', 
			'tiff' => 'image/tiff', 
			'psd' => 'image/x-photoshop', 
			
			'swf' => 'application/x-shockwave-flash', 
			'js' => 'application/x-javascript', 
			'pdf' => 'application/pdf', 
			'ps' => 'application/postscript', 
			'eps' => 'application/postscript', 
			'ai' => 'application/postscript', 
			'wmf' => 'application/x-msmetafile', 
			
			'css' => 'text/css', 
			'htm' => 'text/html', 
			'html' => 'text/html', 
			'txt' => 'text/plain', 
			'xml' => 'text/xml', 
			'wml' => 'text/wml', 
			'wbmp' => 'image/vnd.wap.wbmp', 
			
			'mid' => 'audio/midi', 
			'wav' => 'audio/wav', 
			'mp3' => 'audio/mpeg', 
			'mp2' => 'audio/mpeg', 
			
			'avi' => 'video/x-msvideo', 
			'mpeg' => 'video/mpeg', 
			'mpg' => 'video/mpeg', 
			'qt' => 'video/quicktime', 
			'mov' => 'video/quicktime', 
			
			'lha' => 'application/x-lha', 
			'lzh' => 'application/x-lha', 
			'z' => 'application/x-compress', 
			'gtar' => 'application/x-gtar', 
			'gz' => 'application/x-gzip', 
			'gzip' => 'application/x-gzip', 
			'tgz' => 'application/x-gzip', 
			'tar' => 'application/x-tar', 
			'bz2' => 'application/bzip2', 
			'zip' => 'application/zip', 
			'arj' => 'application/x-arj', 
			'rar' => 'application/x-rar-compressed', 
			
			'hqx' => 'application/mac-binhex40', 
			'sit' => 'application/x-stuffit', 
			'bin' => 'application/x-macbinary', 
			
			'uu' => 'text/x-uuencode', 
			'uue' => 'text/x-uuencode', 
			
			'latex'=> 'application/x-latex', 
			'ltx' => 'application/x-latex', 
			'tcl' => 'application/x-tcl', 
			
			'pgp' => 'application/pgp', 
			'asc' => 'application/pgp', 
			'exe' => 'application/x-msdownload', 
			'doc' => 'application/msword', 
			'rtf' => 'application/rtf', 
			'xls' => 'application/vnd.ms-excel', 
			'ppt' => 'application/vnd.ms-powerpoint', 
			'mdb' => 'application/x-msaccess', 
			'wri' => 'application/x-mswrite', 
			);
		
		$iconType = array (
			'image/gif' => 'gif', 
			'image/jpeg' => 'jpg', 
			'image/tiff' => 'tif', 
			'application/pdf' => 'pdf', 
			'application/msword' => 'doc', 
			'application/rtf' => 'doc', 
			'application/vnd.ms-excel' => 'xls', 
			'application/vnd.ms-powerpoint' => 'ppt',
			
			'application/x-lha' => 'arc', 
			'application/x-lha' => 'arc', 
			'application/x-compress' => 'arc', 
			'application/x-gtar' => 'arc', 
			'application/x-gzip' => 'arc', 
			'application/x-gzip' => 'arc', 
			'application/x-gzip' => 'arc', 
			'application/x-tar' => 'arc', 
			'application/bzip2' => 'arc', 
			'application/zip' => 'arc', 
			'application/x-arj' => 'arc', 
			'application/x-rar-compressed' => 'arc'
		);
		
		foreach($mime_types as $key => $value)
			if(empty($iconType[$value]))
				$iconType[$value] = $key;
    
		return (!empty($iconType[$string]) ? $iconType[$string] : 'unk') . ".gif";
}

?>
