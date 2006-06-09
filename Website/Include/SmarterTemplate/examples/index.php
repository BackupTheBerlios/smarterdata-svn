<?php
	include str_replace ( "\\", "/", dirname ( __FILE__ ) ) . "/config.examples.php";
	$smartertemplate	= new SmarterTemplate ( 'index.html' );
	echo $smartertemplate->result ();
?>