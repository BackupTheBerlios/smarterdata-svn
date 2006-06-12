<?php

	include str_replace ( "\\", "/", dirname ( __FILE__ ) ) . "/config.examples.php";
	$smartertemplate	= new SmarterTemplate ( 'grundlagen.html' );
	$smartertemplate->assign (
	    'VARIABLER_TEXT',
	    'irgendwas'
	);
	echo $smartertemplate->result ();
?>