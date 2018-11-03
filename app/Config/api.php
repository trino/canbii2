<?php
	$isSecure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443;
	$protocol = "http://";
	if($isSecure){
		$protocol = "https://";
	}
	define(protocol, $protocol);
?>