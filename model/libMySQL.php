<?php

class SQL {

	var $hostname,
			$username,
			$password,
			$database,
			$datatype,
			$persconn,
			$logging,
			$id;

	function SQL($database = '', $datatype = 0, $persconn = true, $hostname = '', $username = '', $password = '', $logging = false) {
		
		$this->hostname	= $hostname ? $hostname : '';
		$this->username	= $username ? $username : '';
		$this->password	= $password ? $password : '';
		$this->persconn = $persconn;

		$this->logging	= $logging;

		$this->database	= $database;
		$this->datatype	= $datatype;
		$this->id		= false;
	}
	
	function Connect() {
		$connectf = $this->persconn ? 'mysql_connect' : 'mysql_connect';
		if (!$this->id)
			$this->id = @$connectf($this->hostname, $this->username, $this->password) or $this->LogError('Connect()');
			
    if (!defined('PMA_MYSQL_INT_VERSION')) {
        $result = @mysql_query('SELECT VERSION() AS version', $this->id);
        if ($result != FALSE && @mysql_num_rows($result) > 0) {
            $row   = mysql_fetch_row($result);
            $match = explode('.', $row[0]);
            mysql_free_result($result);
        }
        if (!isset($row)) {
            define('PMA_MYSQL_INT_VERSION', 32332);
            define('PMA_MYSQL_STR_VERSION', '3.23.32');
        } else{
            define('PMA_MYSQL_INT_VERSION', (int)sprintf('%d%02d%02d', $match[0], $match[1], intval($match[2])));
            define('PMA_MYSQL_STR_VERSION', $row[0]);
            unset($result, $row, $match);
        }
    }
    if (PMA_MYSQL_INT_VERSION >= 40100) {
        $mysql_charset = 'utf8';
        mysql_query('SET CHARACTER SET ' . $mysql_charset . ';', $this->id);
    }
    
		if ($this->id)
			return @mysql_select_db($this->database, $this->id) or $this->LogError('Connect()');
		return false;
	}
	
	function Close() {
		if ($this->id)
			return mysql_close($this->id);
		return false;
	}
	
	function Query($query = 'SELECT 1', $datatype = false) {
		$this->LogSql($query);
		$datatype = !is_bool($datatype) ? $datatype : $this->datatype;

		$this->Connect();
		if ($this->id) {
	
			$result =  @mysql_query($query, $this->id) or $this->LogError('Query('.$query.')');
			
					
		} else {
			$result = false;
		}
		switch ($datatype) {
			case 0:	return $result;
			case 1: if ($result) {
						$i = 0;
						$arr = array();
						while ($row = mysql_fetch_assoc($result))
							$arr[$i++] = $row;
						mysql_free_result($result);
						return $arr;
					} else {
						return false;
					}
		}
		return false;
	}
	
	
	function Row($query = 'SELECT 1', $datatype = false) {
		$this->LogSql($query);
		$datatype = !is_bool($datatype) ? $datatype : $this->datatype;

		$this->Connect();
		if ($this->id) {
	
			$result =  @mysql_query($query, $this->id) or $this->LogError('Query('.$query.')');
			
					
		} else {
			$result = false;
		}
		switch ($datatype) {
			case 0:	return $result;
			case 1: if ($result) {
						
						$row = mysql_fetch_row($result);
							
						return $row;
					} else {
						return false;
					}
		}
		return false;
	}
	
	function mysql_evaluate_array($query) {
		$result = mysql_query($query);
		$values = array();
		for ($i=0; $i<mysql_num_rows($result); ++$i)
			array_push($values, mysql_result($result,$i));
		return $values;
	
	}
	
	function mysql_evaluate($query, $default_value="undefined") { //zwraca wartoœæ bez tablicy
		$result = mysql_query($query);
		if (mysql_num_rows($result)==0)
			return $default_value;
		else
			return mysql_result($result,0);
	}
	
	function GetInsertID() {
		return ($this->id) ? @mysql_insert_id($this->id) : false;
	}
	
	function NumRows() {
		if ($this->id)
			return @mysql_num_rows($this->id) or $this->LogError('NumRows()');
		return false;
	}
	
	function Error() {
		if ($this->id) {
			return mysql_errno($this->id).": ".mysql_error($this->id);
		} else {
			return mysql_errno().": ".mysql_error();
		}
		return false;
	}
	
	function LogSql($sql) {
		if ($this->logging) {
			echo '<div>' . date("d-m-Y H:i:s").' - ['.$sql . ']</div>';
		}
		return false;
	}
	
	function LogError($function = '') {
		if ($this->logging) {
			echo date("d-m-Y H:i:s").' - '.$function.': '.($this->Error() ? $this->Error() : 'There is not a valid MySQL-Link resource');
		}
		return false;
	}

}
?>