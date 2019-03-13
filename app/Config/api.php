<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	$GLOBALS["settings"] = [
		"limit" 		=> 200,
		"reviewlimit" 	=> 20,
		"usetable" 		=> "symptoms",//"symptoms" or "activities"
		"multiple" 		=> true,//disable for single queries only
		"allowreviews" 	=> true,//disable to prevent reviews from being placed
		"islocal"		=> $_SERVER['HTTP_HOST'] == "localhost",
		"imagepanel" 	=> false,//allow use of the image renaming/deleting panel
	];

	$currentURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	if(textcontains($currentURL, "?")){
		$currentURL = left($currentURL, strpos($currentURL, "?"));
	}
	define("currentURL", $currentURL);

	$isSecure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443;
	$protocol = "http://";
	if($isSecure){
		$protocol = "https://";
	}
	define("protocol", $protocol);

	function getdirectory($path){
		return pathinfo(str_replace("\\", "/", $path), PATHINFO_DIRNAME);
	}

	function getfilename($path, $WithExtension = false){
		if ($WithExtension) {
			$path = pathinfo($path, PATHINFO_BASENAME); //filename only, with extension
		} else {
			$path = pathinfo($path, PATHINFO_FILENAME); //filename only, no extension
		}
		return trimend($path, "?");
	}

	function trim2($text, $text2trim){
		if(startswith($text, $text2trim)){
			$text = right($text, strlen($text) - strlen($text2trim));
		}
		if(endswith($text, $text2trim)){
			$text = left($text, strlen($text) - strlen($text2trim));
		}
		return $text;
	}

	function isJSON($Text){
		json_decode($Text);
		return (json_last_error() == JSON_ERROR_NONE);
	}

	function trimend($text, $endtext){
		$start = strpos($text, $endtext);
		if($start !== false){
			$text = left($text, $start);
		}
		return $text;
	}
	//get the lower-cased extension of a file path
	//HOME/WINDOWS/TEST.JPG returns jpg
	function getextension2($path){
		return trimend(strtolower(pathinfo($path, PATHINFO_EXTENSION)), "?"); // extension only, no period
	}

	if(!function_exists("array_key_last")){
		function array_key_last($array) {
			$keys = array_keys($array);
			return end($keys);
		}
		function array_value_last($array) {
			$keys = array_values($array);
			return end($keys);
		}
	}

	function file_size($path){
		if (file_exists($path)) {
			return filesize($path);
		}
		return 0;
	}

	function errorlog($text){
		$file = APP . "/tmp/logs/debug.log";
		file_put_contents($file, "\n" . $text, FILE_APPEND);
	}

	function get($key, $default = ""){
		if(isset($_GET[$key])){return $_GET[$key];}
		if(isset($_POST[$key])){return $_POST[$key];}
		return $default;
	}

	function textcontains($text, $searchfor){
		return stripos($text, $searchfor) !== false;
	}

	function left($text, $length){
		return substr($text, 0, $length);
	}

	function right($text, $length){
		return substr($text, -$length);
	}

	function mid($text, $start, $length){
		return substr($text, $start, $length);
	}

	App::uses('ConnectionManager', 'Model');
	$dataSource = ConnectionManager::getDataSource('default');
	$username = $dataSource->config['login'];
	$password = $dataSource->config['password'];
	$database = $dataSource->config['database'];

	$con = connectdb($database, $username, $password);
	function connectdb($database = false, $username = false, $password = false){
		global $con;
		$localhost = "localhost";
		if ($_SERVER["SERVER_NAME"] == "localhost") {
			$localhost .= ":3306";
		}
		$GLOBALS["database"] = $database;
		$con = mysqli_connect($localhost, $username, $password, $database) or die("Error " . mysqli_connect_error($con));
		return $con;
	}

	function startswith($text, $test){
		return left($text, strlen($test)) == $test;
	}

	function endswith($text, $test){
		return right($text, strlen($test)) == $test;
	}

	function escapeSQL($text){
		global $con;
		return mysqli_real_escape_string($con, $text);
	}

	function getarrayasstring($DataArray, $Keys = True){
		if ($Keys) {
			$DataArray = array_keys($DataArray);
			return implode(", ", $DataArray);
		} else {
			$DataArray = array_values($DataArray);
			$DataArray = implode("', '", $DataArray);
			return "'" . $DataArray . "'";
		}
	}

	function filtersubarrays(&$array){
		foreach ($array as $key => $row) {
			if (is_array($row))
				unset($array[$key]);
		}
	}

	function insertdb($Table, $DataArray, $PrimaryKey = "id", $Execute = True){
		global $con;
		if(!is_array($DataArray) || !$DataArray){return false;}
		$controlledtables = ["colour_ratings", "effects", "effect_ratings", "flavors", "flavorstrains", "flavor_ratings", "overall_colour_ratings", "overall_effect_ratings", "overall_flavor_ratings", "overall_symptom_ratings", "reviews", "strains", "symptoms", "symptom_ratings", "symptom_votes", "user_effect_ratings", "user_symptom_ratings"];
		if (is_object($con)) {
			if(in_array($Table, $controlledtables)){
				$DataArray["imported"] = 1;
			}
			$DataArray = escapearray($DataArray, $con);
		}
		filtersubarrays($DataArray);
		$query = "INSERT INTO " . $Table . " (" . getarrayasstring($DataArray, True) . ") VALUES (" . getarrayasstring($DataArray, False) . ")";
		if ($PrimaryKey && isset($DataArray[$PrimaryKey])) {
			$query .= " ON DUPLICATE KEY UPDATE";
			$delimeter = " ";
			foreach ($DataArray as $Key => $Value) {
				if(!startswith($Key, "omit_")) {
					if ($Key != $PrimaryKey) {
						$query .= $delimeter . $Key . "='" . $Value . "'";
						$delimeter = ", ";
					}
				}
			}
		}
		$query .= ";";
		if ($Execute && is_object($con)) {
			mysqli_query($con, $query) or die ('Unable to execute query. ' . mysqli_error($con) . "<P>Query: " . $query);
			return $con->insert_id;
		}
		$GLOBALS["lastsql"] = $query;
		return $query;
	}

	function escapearray($DataArray, $con){
		foreach ($DataArray as $Key => $Value) {
			if (!is_array($Value)) {
				$DataArray[$Key] = mysqli_real_escape_string($con, $Value);
			}
		}
		return $DataArray;
	}

	function describe($table = false){
		if(!$table){return enum_tables();}
		return Query("DESCRIBE " . $table, true);
	}

	function deleterow($Table, $Where = false){
		if ($Where) {$Where = " WHERE " . $Where;}
		$SQL = "DELETE FROM " . $Table . $Where;
		Query($SQL, false);
		if(!$Where){
			Query("ALTER TABLE " . $Table . " AUTO_INCREMENT = 1", false);
		}
		return $SQL;
	}

	function first($query){
		global $con;
		if (!is_object($query)) {$query = Query($query, false);}
		if ($query) {
			$ret = array();
			while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
				unescape($row);
				return $row;
			}
		}
		return false;
	}

	function primarykey($table){
		$data = first("SHOW KEYS FROM " . $table . " WHERE Key_name = 'PRIMARY'");
		if($data){
			return $data["Column_name"];
		}
		return false;
	}

	function unescape(&$data){
		if(is_array($data)){
			foreach($data as $key => $index){
				$data[$key] = unescape($index);
			}
		} else if (is_string($data)){
			$data = stripslashes($data);
		}
		return $data;
	}

	function collapsearray($Arr, $ValueKey = false, $KeyKey = false, $Delimiter = false){
		foreach ($Arr as $index => $value) {
			if (!$ValueKey) {
				foreach ($value as $key2 => $value2) {
					$ValueKey = $key2;
					break;
				}
			}
			if ($Delimiter) {
				$Arr[$index] = explode($Delimiter, $value[$ValueKey]);
			} else {
				if ($KeyKey) {
					$Arr[$value[$KeyKey]] = $value[$ValueKey];
					unset($Arr[$index]);
				} else {
					$Arr[$index] = $value[$ValueKey];
				}
			}
		}
		return $Arr;
	}

	function flattenarray($arr, $key){
		foreach ($arr as $index => $value) {
			$arr[$index] = $value[$key];
		}
		return $arr;
	}

	function enum_tables($table = "", $Why = "UNKNOWN"){
		return flattenarray(Query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='" . $GLOBALS["database"] . "'" . iif($table, " AND TABLE_NAME='" . $table . "'"), true, "API.enum_tables: " . $Why), "TABLE_NAME");
	}

	if (!function_exists("mysqli_fetch_all")) {
		function mysqli_fetch_all($result) {
			$data = [];
			if (is_object($result)) {
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
			}
			return $data;
		}
	}

	function fixtext($text) {
		$text = html_entity_decode(html_entity_decode(htmlspecialchars_decode($text)));
		$text = mb_convert_encoding($text, "HTML-ENTITIES", 'UTF-8');
		$text = str_replace(['&nbsp;<a data-target=".product__description" class="js-scroll-to text-cta">Learn More</a>', 'ain’', 'Â', 'â€™', '&acirc;&euro;&trade;'], ["", "'", '', "'", "'"], $text);
		return trim($text);
	}

	function slugtotext($key) {
		if (textcontains($key, "-")) {
			$key = explode("-", $key);
			foreach ($key as $INDEX => $VALUE) {
				$key[$INDEX] = ucfirst($VALUE);
			}
			return implode(" ", $key);
		}
		return $key;
	}

	function Query($query, $all = false){
		global $con;
		$ret = false;
		$GLOBALS["lastsql"] = $query;
		if ($all) {
			$result = $con->query($query);
			if (is_object($result)) {
				$ret = true;
				$data = mysqli_fetch_all($result, MYSQLI_ASSOC);// or die ('Unable to execute query. '. mysqli_error($con) . "<P>Query: " . $query);
				unescape($data);
				if(is_string($all)){
					foreach($data as $KEY => $VALUE){
						$data[$KEY] = [$all => $VALUE];//for backwards compatibility with Cake's SQL
					}
				}
			} else {
				return [];
			}
		}
		if(!$ret) {$data = $con->query($query);}
		return $data;
	}

	function iif($value, $istrue, $isfalse = ""){
		if ($value) {
			return $istrue;
		}
		return $isfalse;
	}

	if(!function_exists("is_iterable")) {
		function is_iterable($var) {
			return (is_array($var) || $var instanceof Traversable);
		}
	}

	function vardump($JSON, $isHTML = false){
		if($isHTML){
			$HTML = htmlspecialchars($JSON);
		} else {
			$HTML = json_encode($JSON, JSON_PRETTY_PRINT);
		}
		$HTML = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),"<br/>",$HTML);
		echo '<PRE STYLE="background-color: white; border: 1px solid red; white-space: pre-wrap; white-space: -moz-pre-wrap; white-space: -pre-wrap; white-space: -o-pre-wrap; word-wrap: break-word; color: black !important;">' . $HTML . '</PRE>';
	}

	function getbetween($text, $start, $end = false){
		$startpos = stripos($text, $start);
		if($startpos === false){return false;}
		$text = right($text, strlen($text) - ($startpos + strlen($start)));
		if($end === false){return $text;}
		$startpos = stripos($text, $end);
		if($startpos === false){return false;}
		$text = left($text, $startpos);
		return $text;
	}

	//$src = source array, $keys = the keys to remove
	function removekeys($src, $keys){
		return array_diff_key($src, array_flip($keys));
	}

	//removes numbers
	function filternumeric($text, $withwhat = ''){
		return preg_replace('/[0-9]/', $withwhat, $text);
	}

	//removes non-numbers
	function filternonnumeric($text, $withwhat = ''){
		return preg_replace('/[^0-9]/', $withwhat, $text);
	}

	function filternonalphanumeric($text, $withwhat = '', $anythingelse = ''){
		return preg_replace("/[^A-Za-z0-9 " . $anythingelse . "]/", $withwhat, $text);
	}

	function getiterator($arr, $key, $value, $retValue = true){
		foreach ($arr as $index => $item) {
			if (is_array($item)) {
				if (isset($item[$key]) && $item[$key] == $value) {
					if ($retValue) {
						return $item;
					}
					return $index;
				}
			} else if (is_object($item)) {
				if (isset($item->$key) && $item->$key == $value) {
					if ($retValue) {
						return $item;
					}
					return $index;
				}
			}
		}
		return false;
	}

	function debugprint($text){
		vardump($text);
		die();
	}

	//gets the protected value of an object ("_properties" is one used by most objects)
	function getProtectedValue($obj, $name = "_properties"){
		$array = (array)$obj;
		$prefix = chr(0) . '*' . chr(0);
		if (isset($array[$prefix . $name])) {
			return $array[$prefix . $name];
		}
		return false;
	}

	function like_match($pattern, $subject){
		$pattern = str_replace('%', '.*', preg_quote($pattern, '/'));
		return (bool)preg_match("/^{$pattern}$/i", $subject);
	}

	function countSQL($table, $SQL = "*"){
		return first("SELECT COUNT(" . $SQL . ") as count FROM " . $table)["count"];
	}

	function money_format2($ignored, $value) {
		return '$' . number_format($value, 2);
	}

	function array_sort($array, $on, $order=SORT_ASC){

		$new_array = array();
		$sortable_array = array();

		if (count($array) > 0) {
			foreach ($array as $k => $v) {
				if (is_array($v)) {
					foreach ($v as $k2 => $v2) {
						if ($k2 == $on) {
							$sortable_array[$k] = $v2;
						}
					}
				} else {
					$sortable_array[$k] = $v;
				}
			}

			switch ($order) {
				case SORT_ASC:
					asort($sortable_array);
					break;
				case SORT_DESC:
					arsort($sortable_array);
					break;
			}

			foreach ($sortable_array as $k => $v) {
				$new_array[$k] = $array[$k];
			}
		}

		return $new_array;
	}
?>