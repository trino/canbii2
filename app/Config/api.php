<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	$isSecure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443;
	$protocol = "http://";
	if($isSecure){
		$protocol = "https://";
	}
	define("protocol", $protocol);

	function errorlog($text){
		$file = APP . "/tmp/logs/debug.log";
		file_put_contents($file, "\n" . $text, FILE_APPEND);
	}
	function get($key, $default = ""){
		if(isset($_GET[$key])){return $_GET[$key];}
		if(isset($_POST[$key])){return $_POST[$key];}
		return $default;
	}
?>