<?php

	include str_replace ( "\\", "/", dirname ( __FILE__ ) ) . "/config.examples.php";
	$smartertemplate	= new SmarterTemplate ( 'schleife.html' );
	$smartertemplate->assign (
		'zeile', 
		array (
			'Zeile1'		=> array (
				'Spalte1' => 'Spalte 1.1',
				'Spalte2' => 'Spalte 2.1', 
				'Spalte3' => 'Spalte 3.1'
			),
			'Zeile2'		=> array ( 
				'Spalte1' => 'Spalte 1.2',
				'Spalte2' => 'Spalte 2.2',
				'Spalte3' => 'Spalte 3.2'
			),
			'Zeile3'		=> array (
				'Spalte1' => 'Spalte 1.3', 
				'Spalte2' => 'Spalte 2.3', 
				'Spalte3' => 'Spalte 3.3'
			),
			'Zeile4'		=> array (
				'Spalte1' => 'Spalte 1.4', 
				'Spalte2' => 'Spalte 2.4', 
				'Spalte3' => 'Spalte 3.4'
			),
		)
	);
	echo $smartertemplate->result ();
?>