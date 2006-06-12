<?php

	include str_replace ( "\\", "/", dirname ( __FILE__ ) ) . "/config.examples.php";
	$GLOBALS['_CONFIG']['autoLink']		= true;
	if ( !isset ( $GLOBALS['_CONFIG']['lang'] ) )
	{
		$GLOBALS['_CONFIG']['lang']		= 'de';
	}
	$smartertemplate	= new SmarterTemplate ( 'sprachsupport.html' );
	echo $smartertemplate->result ();
?>