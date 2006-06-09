<?php

	include str_replace ( "\\", "/", dirname ( __FILE__ ) ) . "/config.examples.php";
	$GLOBALS['_CONFIG']['sqlDSN']
		= 'mysql:dbname=test;host=127.0.0.1';
	$GLOBALS['_CONFIG']['sqlUsername']
		= 'test';
	$GLOBALS['_CONFIG']['sqlPassword']
		= 'test';
	$smartertemplate	= new SmarterTemplate ( 'sql.html' );
	echo $smartertemplate->result ();

?>