<?php

	include str_replace ( "\\", "/", dirname ( __FILE__ ) ) . "/config.examples.php";
	$smartertemplate	= new SmarterTemplate ( 'erweiterung_argumente.html' );
	echo $smartertemplate->result ();
?>