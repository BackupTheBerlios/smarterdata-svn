<?php
	include str_replace ( "\\", "/", dirname ( __FILE__ ) ) . "/config.examples.php";
	$GLOBALS['_CONFIG']['enablePHPExecution']		= false;
	$smartertemplate	= new SmarterTemplate ( 'phpcode.html' );
	echo $smartertemplate->result ();
?>