<?php
require_once str_replace('\\', '/', dirname(__FILE__)) . '/Include/VisitorCounter.php';
$clientCounter = new VisitorCounter();
$testArray = array (
	'VisitorCounter' => 10,
	'WriteComment' => 30,
	'CheckBox' => 100
);
foreach ($testArray as $functionName => $functionTime)
{
	echo 'Function : ' . $functionName . ': ';
	if ($clientCounter->functionOk($functionName, $functionTime))
	{
		echo 'Ok<br>';
	}
	else
	{
		echo 'not Ok<br>';
	}
}
?>