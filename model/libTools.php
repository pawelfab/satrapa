<?php
class T {
	
	function conv_encoding ($string, $enc_input, $enc_output) {
		
		if($enc_input == $enc_output) 
			return $string;
			
		if(function_exists('iconv'))
			return iconv($enc_input,$enc_output,$string);

		if(strtolower($enc_input) == 'windows-1250' && strtolower($enc_output) == 'utf-8')
			return T::WIN1250_2_UTF8($string);
		if(strtolower($enc_input) == 'windows-1250' && strtolower($enc_output) == 'iso-8859-2')
			return T::WIN1250_2_ISO88592($string);
		if(strtolower($enc_input) == 'utf-8' && strtolower($enc_output) == 'windows-1250')
			return T::UTF8_2_WIN1250($string);
		if(strtolower($enc_input) == 'iso-8859-2' && strtolower($enc_output) == 'windows-1250')
			return T::ISO88592_2_WIN1250($string);

		if(function_exists('mb_convert_encoding'))
			return mb_convert_encoding($string, $enc_output, $enc_input);
		
		if(strtolower($enc_input) == 'utf-8' && strtolower($enc_output) == 'iso-8859-2')
			return T::UTF8_2_ISO88592($string);
		if(strtolower($enc_input) == 'iso-8859-2' && strtolower($enc_output) == 'utf-8')
			return T::ISO88592_2_UTF8($string);
		
		return $string;	
	}



	function parseRequest () {
		//T::dumpa($_REQUEST);
		foreach ($_REQUEST as $key => $value) {
			$_REQUEST[$key] = T::parseDate ($value); 
		}
		foreach ($_POST as $key => $value) {
			$_POST[$key] = T::parseDate ($value); 
		}
		foreach ($_GET as $key => $value) {
			$_GET[$key] = T::parseDate ($value); 
		}
		//T::dumpa($_REQUEST);
	}
	
	function parseDate ($value) {
		if (preg_match ("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $value, $regs)) {
    	return "$regs[3]-$regs[2]-$regs[1]";
		} else {
    	//echo "Tekst daty jest niepoprawny";
    	return $value;
		}
	}
	
	function utf2html ($str) { 
		$ret = ""; 
		$max = strlen($str); 
		$last = 0;  // keeps the index of the last regular character 
		for ($i=0; $i<$max; $i++) { 
		 $c = $str{$i}; 
		 $c1 = ord($c); 
		 if ($c1>>5 == 6) {  // 110x xxxx, 110 prefix for 2 bytes unicode 
		   $ret .= substr($str, $last, $i-$last); // append all the regular characters we've passed 
		   $c1 &= 31; // remove the 3 bit two bytes prefix 
		   $c2 = ord($str{++$i}); // the next byte 
		   $c2 &= 63;  // remove the 2 bit trailing byte prefix 
		   $c2 |= (($c1 & 3) << 6); // last 2 bits of c1 become first 2 of c2 
		   $c1 >>= 2; // c1 shifts 2 to the right 
		   $ret .= "&#" . ($c1 * 100 + $c2) . ";"; // this is the fastest string concatenation 
		   $last = $i+1;        
		 } 
		}
		return $ret . substr($str, $last, $i); // append the last batch of regular characters 
	}
	
	function dumpa ($arr) {
		echo '<div style="border:1px solid black;margin:2px;"><pre>';
		print_r($arr);
		echo '</pre></div>';
	}
	
	function htmlCharSet ($string) {
		$newString = "";
		for($i=0;$i<strlen($string);$i++) {
			if(ord($string[$i]) >= 192 && ord($string[$i]) < 253) {
				$string .= '&#'.$i.';';
			} else {
				$newString .= $string[$i]; 
			}
		}
		return $newString;
	}

function win2utf(){
 $tabela = Array(
  "\xb9" => "\xc4\x85", "\xa5" => "\xc4\x84", "\xe6" => "\xc4\x87", "\xc6" => "\xc4\x86",
  "\xea" => "\xc4\x99", "\xca" => "\xc4\x98", "\xb3" => "\xc5\x82", "\xa3" => "\xc5\x81",
  "\xf3" => "\xc3\xb3", "\xd3" => "\xc3\x93", "\x9c" => "\xc5\x9b", "\x8c" => "\xc5\x9a",
  "\x9f" => "\xc5\xbc", "\xaf" => "\xc5\xbb", "\xbf" => "\xc5\xba", "\xac" => "\xc5\xb9",
  "\xf1" => "\xc5\x84", "\xd1" => "\xc5\x83");
 return $tabela;
}

function iso2utf(){
 $tabela = Array(
  "\xb1" => "\xc4\x85", "\xa1" => "\xc4\x84", "\xe6" => "\xc4\x87", "\xc6" => "\xc4\x86",
  "\xea" => "\xc4\x99", "\xca" => "\xc4\x98", "\xb3" => "\xc5\x82", "\xa3" => "\xc5\x81",
  "\xf3" => "\xc3\xb3", "\xd3" => "\xc3\x93", "\xb6" => "\xc5\x9b", "\xa6" => "\xc5\x9a",
  "\xbc" => "\xc5\xba", "\xac" => "\xc5\xb9", "\xbf" => "\xc5\xbc", "\xaf" => "\xc5\xbb",
  "\xf1" => "\xc5\x84", "\xd1" => "\xc5\x83");
 return $tabela;
}

function ISO88592_2_UTF8($tekst){
 return strtr($tekst, T::iso2utf());
}

function UTF8_2_ISO88592($tekst){
 return strtr($tekst, array_flip(T::iso2utf()));
}

function WIN1250_2_UTF8($tekst){
 return strtr($tekst, T::win2utf());
}

function UTF8_2_WIN1250($tekst){
 return strtr($tekst, array_flip(T::win2utf()));
}

function ISO88592_2_WIN1250($tekst){
 return strtr($tekst, "\xa1\xa6\xac\xb1\xb6\xbc", "\xa5\x8c\x8f\xb9\x9c\x9f");
}

function WIN1250_2_ISO88592($tekst){
 return strtr($tekst, "\xa5\x8c\x8f\xb9\x9c\x9f", "\xa1\xa6\xac\xb1\xb6\xbc");

}

	function iso885922utf8($str_iso8859_1) {
		$str_utf8 = preg_replace("/([\x80-\xFF])/e",
	           "chr(0xC0|ord('\\1')>>6).chr(0x80|ord('\\1')&0x3F)",
	             $str_iso8859_1);
		return $str_utf8;
	}
	
	function utf82iso88592($str_utf8) {
		$str_iso8859_1 = preg_replace("/([\xC2\xC3])([\x80-\xBF])/e",
	               "chr(ord('\\1')<<6&0xC0|ord('\\2')&0x3F)",
	                 $str_utf8);
		return $str_iso8859_1;
	}
	
	function parse_alert($alert, $replace) {
		$healthy = array("{0}", "{1}", "{2}", "{3}", "{4}", "{5}", "{6}");
		return str_replace($healthy, $replace, $alert);
	}
	
	function isSession() {
		return !empty($_SESSION['session_id']) && $_SESSION['session_id'] > 0;
	}
	
	function set_lenguage($variables, $request) {
		if(!empty($request['lg_change']) && !empty($variables['lg_map'][$request['lg_change']])) {
			$_SESSION['lg_session'] = $request['lg_change'];
		} elseif(empty($_SESSION['lg_session'])) {
			$_SESSION['lg_session'] = $variables['lg_act'];
		}
		return $_SESSION['lg_session'];
	}
	
	function set_app_lenguage($variables, $request) {
		if(!empty($request['app_lg_change']) && !empty($variables['app_lg_map'][$request['app_lg_change']])) {
			$_SESSION['app_lg_session'] = $variables['app_lg_default'] == $request['app_lg_change'] ? '' : $request['app_lg_change'];
		} elseif(!T::isSession() || empty($_SESSION['app_lg_session'])) {
			$_SESSION['app_lg_session'] = $variables['app_lg_default'] == $variables['app_lg_act'] ? '' : $variables['app_lg_act'];
		}
		return $_SESSION['app_lg_session'];
	}
	
	function GetVariables ($file) {
		$val = file($file);
		$tab = array ();
		for( $i=0; $i<count($val); $i++ ) {
			if( !empty($val[$i]) && !eregi("^\/\/",$val[$i]) ) {
				@list($key,$value) = explode("=",$val[$i]);
				$tab[trim($key)] = trim($value);
			}
		}
		return $tab;
	}
	
	function zwrocSciezke($id,&$tab,&$tabID) {
		if(!$tabID[$id]['SCT_SCT_ID']) 
			return '';
		else
			$ret = zwrocSciezke($tabID[$id]['SCT_SCT_ID'],$tab,$tabID).'/'.$tabID[$tabID[$id]['SCT_SCT_ID']]['SCT_NAME'];
		return $ret;
	}
	
	function parseFormAddToGal ($post) {
		$idPicT = array();
		foreach($post as $key => $value) {
			if( eregi("^z([0-9]+)add$",$key) ) {
				$idPicT[] = $value;
			}
		}
		return $idPicT;
	}
	
	function parseFormPhotoDesc ($post) {
		$zPicD = array();
		foreach($post as $key => $value) {
			if( eregi("^z([0-9]+)desc$",$key,$ret) ) {
				if(!empty($value))
					$zPicD[$ret[1]] = $value;
			}
		}
		return $zPicD;
	}
	
	function getJSTabFromPhotosID($images) {
		if(count($images) < 1) return '';
		$tablicaIDZdj = "var t = new Array(";
		for($i=0;$i<count($images);$i++) {
			$tablicaIDZdj .= $images[$i]['gpc_id'].',';
		}
		$tablicaIDZdj = substr($tablicaIDZdj,0,-1);
		$tablicaIDZdj .= ");\n";
		return $tablicaIDZdj;
	}
	
	function parseAllGaleries ($CatGal) {
		$ktid = 0;
		$j = 0;
		$addToGal = array();
		for($i=0;$i<count($CatGal);$i++) {
			if($ktid != $CatGal[$i]['ggc_cat_id']) {
				$ktid = $CatGal[$i]['ggc_cat_id'];
			} else {
				$CatGal[$i]['gct_id'] = 0;
			}
			$addToGal[$j] = $CatGal[$i];
			$j++;
		}
		return $addToGal;
	}
	
	function zwrocSciezkeID($id,&$tab,&$tabID) {
		if(!$tabID[$id]['SCT_SCT_ID']) 
			return '';
		else
			$ret .= zwrocSciezkeID($tabID[$id]['SCT_SCT_ID'],$tab,$tabID).'#'.$tabID[$id]['SCT_SCT_ID'].'#';
		return $ret;
	}
	
	function dodajWage ($nr) {
		$ret = '';
		for($i=strlen($nr);$i<4;$i++) {
			$ret .= "#";
		}
		return '/'.$ret.$nr;
	}
	function zwrocSciezkeSort($id,&$tab,&$tabID) {
		if(!$tabID[$id]['SCT_SCT_ID']) 
			return '';
		else
			$ret = zwrocSciezkeSort($tabID[$id]['SCT_SCT_ID'],$tab,$tabID).dodajWage ($tabID[$tabID[$id]['SCT_SCT_ID']]['SCT_WEIGHT']).$tabID[$tabID[$id]['SCT_SCT_ID']]['SCT_NAME'];
		return $ret;
	}
	
	function zwrocListePKategorii(&$tab,&$tabID) {
		$ntab=array();
		for($i=0;$i<count($tab);$i++) {
			$ntab[$tab[$i]['SCT_ID']] = zwrocSciezkeSort($tab[$i]['SCT_ID'],$tab,$tabID) . dodajWage($tab[$i]['SCT_WEIGHT']) . $tab[$i]['SCT_NAME'];
		}
		asort ($ntab);
		reset ($ntab);
		return $ntab;
	}
	
	function dodajOdstep($value) {
		$t = explode ('/',$value);
		$s='';
		for($i=0;$i<count($t)-2;$i++) $s.='&nbsp;&nbsp;';
		return $s;
	}
	
	
	function recursive_ls($listing, $directory, $count) {
		$dummy = $count; 
		if ($handle = opendir($directory)) { 
			while ($file = readdir($handle)) { 
				if ($file=='.' || $file=='..') continue; 
				else if (($h = @opendir($directory.$file."/")) && $file != 'wfbtrash') { 
					closedir($h); 
					$count = -1; 
					$listing["$file"] = array(); 
					recursive_ls(&$listing["$file"], $directory.$file."/", $count + 1); 
				} elseif (eregi("\.gif|\.jpg|\.jpeg|\.png",$file)) { 
					$listing[$dummy] = $file;
	        $dummy = $dummy + 1;
				}
			}
		}
		closedir($handle); 
		return ($listing); 
	}
	
	function recursive_dir($listing, $directory, $count) {
		$dummy = $count; 
		if ($handle = opendir($directory)) { 
			while ($file = readdir($handle)) { 
				if ($file=='.' || $file=='..') continue; 
				elseif (($h = @opendir($directory.$file."/")) && $file != 'wfbtrash') { 
					closedir($h); 
					$count = -1; 
					$listing["$file"] = array(); 
					recursive_dir(&$listing["$file"], $directory.$file."/", $count + 1); 
				} elseif (eregi("\.gif|\.jpg|\.jpeg|\.png",$file)) { 
					$dummy += 1;
					$listing = $dummy;
				}
			}
		}
		closedir($handle); 
		return ($listing); 
	}
	
	 /*
		Funkcja robiaca cos takiego:
		$arr			arraySplit($arr,2)
		+---+---+      	+---+---+---+ 
		| 0 | A |      	| 0 | A | B | 
		| 1 | B |  ==> 	| 1 | C | D | 
		| 2 | C | 	 	| 2 | E | F | 
		| 3 | D |      	+---+---+---+ 
		| 4 | E |      				  
		+---+---+      				
	*/
	function ArraySplit($arr, $ileKolumn = 2) {
		if (isset($arr) && is_array($arr) && sizeof($arr)) {
			for($i = 0; $i < sizeof($arr); $i += $ileKolumn) {
				for($j = 0; $j < $ileKolumn; $j++) {
					if (isset($arr[$i+$j])) $arrNew[$i/$ileKolumn][$j] = $arr[$i+$j];
					else $arrNew[$i/$ileKolumn][$j] = '';
					$arrNew[$i/$ileKolumn][$j]["inxI"] = $i/$ileKolumn;
					$arrNew[$i/$ileKolumn][$j]["inxJ"] = $j;
				}
			}
		} else {
			$arrNew = false;
		}
		return $arrNew;
	}
	
	/*
		Funkcja robiaca cos takiego:
		$arr			arraySplit($arr,2)
		+---+---+      	+---+---+---+ 
		| 0 | A |      	| 0 | A | D | 
		| 1 | B |  ==> 	| 1 | B | E | 
		| 2 | C | 	 	  | 2 | C | F | 
		| 3 | D |      	+---+---+---+ 
		| 4 | E |      				  
		+---+---+      				
	*/
	function ArraySplitLine($arr,$ileKolumn = 2) {
		if (isset($arr) && is_array($arr)) {
			$hl = sizeof($arr)/$ileKolumn;
			for($i = 0; $i < $hl; $i++) {
				for($j = 0; $j < $ileKolumn; $j++) {
					if (isset($arr[$i+$hl*$j])) $arrNew[$i][$j] = $arr[$i+$hl*$j];
					else $arrNew[$i][$j] = '';
					$arrNew[$i][$j]["inxI"] = $i;
					$arrNew[$i][$j]["inxJ"] = $j;
				}
			}
		} else {
			$arrNew = false;
		}
		return $arrNew;
	}
	
		function getRemoteIP() {
		$proxy = "";
		$IP = "";
		if (isSet ($_SERVER)) {
			if (isSet ($_SERVER["HTTP_X_FORWARDED_FOR"])) {
				$IP = $_SERVER["HTTP_X_FORWARDED_FOR"];
				$proxy = $_SERVER["REMOTE_ADDR"];
			}
			elseif (isSet ($_SERVER["HTTP_CLIENT_IP"])) {
				$IP = $_SERVER["HTTP_CLIENT_IP"];
			} else {
				$IP = $_SERVER["REMOTE_ADDR"];
			}
		} else {
			if (getenv('HTTP_X_FORWARDED_FOR')) {
				$IP = getenv('HTTP_X_FORWARDED_FOR');
				$proxy = getenv('REMOTE_ADDR');
			}
			elseif (getenv('HTTP_CLIENT_IP')) {
				$IP = getenv('HTTP_CLIENT_IP');
			} else {
				$IP = getenv('REMOTE_ADDR');
			}
		}
		if (strstr($IP, ',')) {
			$ips = explode(',', $IP);
			$IP = $ips[0];
		}

		$RemoteInfo[0] = $IP;
		$RemoteInfo[1] = @ GetHostByAddr($IP);
		$RemoteInfo[2] = $proxy;

		return $IP;
	}

	function getMimeType($ext) {
		$mime_types = array ('gif' => 'image/gif', 'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'jpe' => 'image/jpeg', 'bmp' => 'image/bmp', 'png' => 'image/png', 'tif' => 'image/tiff', 'tiff' => 'image/tiff', 'pict' => 'image/x-pict', 'pic' => 'image/x-pict', 'pct' => 'image/x-pict', 'tif' => 'image/tiff', 'tiff' => 'image/tiff', 'psd' => 'image/x-photoshop', 'swf' => 'application/x-shockwave-flash', 'js' => 'application/x-javascript', 'pdf' => 'application/pdf', 'ps' => 'application/postscript', 'eps' => 'application/postscript', 'ai' => 'application/postscript', 'wmf' => 'application/x-msmetafile', 'css' => 'text/css', 'htm' => 'text/html', 'html' => 'text/html', 'txt' => 'text/plain', 'xml' => 'text/xml', 'wml' => 'text/wml', 'wbmp' => 'image/vnd.wap.wbmp', 'mid' => 'audio/midi', 'wav' => 'audio/wav', 'mp3' => 'audio/mpeg', 'mp2' => 'audio/mpeg', 'avi' => 'video/x-msvideo', 'mpeg' => 'video/mpeg', 'mpg' => 'video/mpeg', 'qt' => 'video/quicktime', 'mov' => 'video/quicktime', 'lha' => 'application/x-lha', 'lzh' => 'application/x-lha', 'z' => 'application/x-compress', 'gtar' => 'application/x-gtar', 'gz' => 'application/x-gzip', 'gzip' => 'application/x-gzip', 'tgz' => 'application/x-gzip', 'tar' => 'application/x-tar', 'bz2' => 'application/bzip2', 'zip' => 'application/zip', 'arj' => 'application/x-arj', 'rar' => 'application/x-rar-compressed', 'hqx' => 'application/mac-binhex40', 'sit' => 'application/x-stuffit', 'bin' => 'application/x-macbinary', 'uu' => 'text/x-uuencode', 'uue' => 'text/x-uuencode', 'latex' => 'application/x-latex', 'ltx' => 'application/x-latex', 'tcl' => 'application/x-tcl', 'pgp' => 'application/pgp', 'asc' => 'application/pgp', 'exe' => 'application/x-msdownload', 'doc' => 'application/msword', 'rtf' => 'application/rtf', 'xls' => 'application/vnd.ms-excel', 'ppt' => 'application/vnd.ms-powerpoint', 'mdb' => 'application/x-msaccess', 'wri' => 'application/x-mswrite',);
		return !empty ($mime_types[$ext]) ? $mime_types[$ext] : '';
	}

	function ZamienNaUPL($str) {
		$trans = array ('&#261;' => 'a', '&#347;' => 's', '&#380;' => 'z', '&#378;' => 'z', '&#263;' => 'c', '&#324;' => 'n', '&#322;' => 'l', '&#243;' => 'o', '&#281;' => 'e', '&#260;' => 'A', '&#346;' => 'S', '&#379;' => 'Z', '&#377;' => 'Z', '&#262;' => 'C', '&#323;' => 'N', '&#321;' => 'L', '&#211;' => 'O', '&#280;' => 'E', '&#261;' => 'a', '&#347;' => 's', '&#378;' => 'z', '&#260;' => 'A', '&#346;' => 'S', '&#377;' => 'Z');
		return strtr($str, $trans);
	}

	//SPECIAL
	function ParseText($text) {
		$posStartTab = strpos($text, "<table");
		$newText = '';
		if ($posStartTab === false) {
    	return $text;
		} else {
			$posEndTab = strpos($text, "</table>");
			if ($posEndTab === false) {
	    	return $text;
			} else {
				if($posStartTab > $posEndTab) {
					return $text;
				} else {
					$newText = substr($text,0,$posStartTab);
					$isadded = eregi("tbcolor", substr($newText,-19)); 
					$newText .= !$isadded ? '<div class=tbcolor>' : '';
					$newText .= $this->ParseTable(substr($text,$posStartTab, $posEndTab-$posStartTab + 8));
					$newText .= !$isadded ? '</div>' : '';
					$newText .= $this->ParseText(substr($text,$posEndTab+8 + ($isadded ? 6 : 0))); 
				}
			}
		}
		return $newText;
	}
	
	function ParseTable ($table) {
		
		$table = ereg_replace ("<table([^>])*>", '<table width="100%" border="0" cellspacing="2" cellpadding="2">', $table);
		$table = ereg_replace ("<td([^>])*>", '<td>', $table);
		$table = ereg_replace ("<tr([^>])*>", '<tr>', $table);
		$table = ereg_replace ("<tr([^>])*>", '<tr>', $table);
		
		$listRows = explode ("</tr>", $table);
		$newTable="";
		for($i=0;$i<count($listRows);$i++) {
			if($i)
				$newTable .= "</tr>";
			$newTable .= $this->ParseRow ($listRows[$i],0);
		}

		return $newTable;
	}
	function ParseRow ($row,$inx) {
		$posTd = strpos($row, "<td");
		$newTd = '';
		if ($posTd === false) {
			return $row;
		} else {
			$newTd = substr($row,0,$posTd + 3);
			if($inx % 2)
				$newTd .= ' class=tdcolor';
			$newTd .= ' valign=top';
			$newTd .= $this->ParseRow(substr($row,$posTd + 3), $inx + 1); 
		}
		return $newTd;
	}
	
	function TransSpecialChars($text) {
		if(@is_array($text))
			return $text;
		
		$trans = array(
		"Ã?"=>"&Oslash;",
		"Â°"=>"&deg;",
		"â€?"=>"&lsquo;", 
		"â€™"=>"&rsquo;",
		"â€œ"=>"&ldquo;",
		"â€"=>"&rdquo;",
		"â€ž" => "&ldquo;",
		"â€“"=>"&ndash;",
		"â€”"=>"&mdash;",
		"Â©"=>"&copy;",
		"Â«"=>"&laquo;",
		"Â®"=>"&reg;",
		"Â»"=>"&raquo;"
		);
		return strtr($text, $trans);
	}


	function Utf2NonUml($text) {
			$trans = array ("\xC4\x81" => "a", // Á 
		"\xC4\x82" => "a", // Á 
		"\xC4\x83" => "a", // Â 
		"\xC4\x84" => "a", // ¹ 
		"\xC4\x85" => "a", // ¹ 
		"\xC4\x86" => "c", //  Æ 
		"\xC4\x87" => "c", //  æ 
		"\xC4\x8c" => "c", //  È 
		"\xC4\x8d" => "c", //  è 
		"\xC4\x8e" => "d", //  Ï 
		"\xC4\x8f" => "d", //  ï 
		"\xC4\x90" => "d", //  Ð 
		"\xC4\x91" => "d", //  ð 
		"\xC4\x98" => "e", //  Ê 
		"\xC4\x99" => "e", //  ê 
		"\xC4\x9a" => "e", //  Ì 
		"\xC4\x9b" => "e", //  ì 
		"\xC4\xb9" => "l", //  Å 
		"\xC4\xba" => "l", //  å 
		"\xC4\xbd" => "l", //  ¼ 
		"\xC4\xbe" => "l", //  ¾ 

		"\xC3\x81" => "a", //Á 
		"\xC3\x82" => "a", //Â 
		"\xC3\x84" => "a", //Ä 
		"\xC3\x87" => "c", //Ç 
		"\xC3\x89" => "e", //É 
		"\xC3\x8b" => "e", //Ë 
		"\xC3\x8d" => "i", // Í 
		"\xC3\x8e" => "i", // Î 
		"\xC3\x93" => "o", // Ó 
		"\xC3\x94" => "o", // Ô 
		"\xC3\x96" => "o", // Ö 
		"\xC3\x9a" => "u", // Ú 
		"\xC3\x9c" => "u", // Ü 
		"\xC3\x9d" => "y", // Ý 
		"\xC3\x9f" => "b", // ß 
		"\xC3\xa0" => "a", // a 
		"\xC3\xa1" => "a", // á 
		"\xC3\xa2" => "a", // â 
		"\xC3\xa4" => "c", // ä 
		"\xC3\xa7" => "c", // ç 
		"\xC3\xa8" => "e", // e 
		"\xC3\xa9" => "e", // é 
		"\xC3\xaa" => "e", // e 
		"\xC3\xab" => "e", // ë 
		"\xC3\xac" => "i", // i 
		"\xC3\xad" => "i", // í 
		"\xC3\xae" => "i", // î 
		"\xC3\xb3" => "o", // ó 
		"\xC3\xb4" => "o", // ô 
		"\xC3\xb6" => "o", // ö 
		"\xC3\xba" => "u", // ú 
		"\xC3\xbc" => "u", // ü 
		"\xC3\xbd" => "y", // ý 

		"\xC5\x81" => "l", //  £ 
		"\xC5\x82" => "l", //  ³ 
		"\xC5\x83" => "n", //  Ñ 
		"\xC5\x84" => "n", //  ñ 
		"\xC5\x87" => "n", //  Ò 
		"\xC5\x88" => "n", //  ò 
		"\xC5\x90" => "o", //  Õ 
		"\xC5\x91" => "o", //  õ 
		"\xC5\x94" => "r", //  À 
		"\xC5\x95" => "r", //  à 
		"\xC5\x98" => "r", //  Ø 
		"\xC5\x99" => "r", //  ø 
		"\xC5\x9a" => "s", //  Œ 
		"\xC5\x9b" => "s", //  œ 
		"\xC5\x9e" => "s", //  ª 
		"\xC5\x9f" => "s", //  º 
		"\xC5\xa0" => "s", //  Š 
		"\xC5\xa1" => "s", //  š 
		"\xC5\xa2" => "t", //  Þ 
		"\xC5\xa3" => "t", //  þ 
		"\xC5\xa4" => "t", //   
		"\xC5\xa5" => "t", //   
		"\xC5\xae" => "u", //  Ù 
		"\xC5\xaf" => "u", //  ù 
		"\xC5\xb0" => "u", //  Û 
		"\xC5\xb1" => "u", //  û 
		"\xC5\xb9" => "z", //   
		"\xC5\xba" => "z", //  Ÿ 
		"\xC5\xbb" => "z", //  ¯ 
		"\xC5\xbc" => "z", //  ¿ 
		"\xC5\xbd" => "z", //  Ž 
		"\xC5\xbe" => "z" //  ž
	);
		return strtr($text, $trans);
	}
}
?>