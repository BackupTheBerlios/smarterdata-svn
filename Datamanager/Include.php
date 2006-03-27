<?php
require_once dirname(__FILE__) . '/Include/Datamanager.php';
$DatabaseHost= 'localhost';
$DatabasePort= 3306;
$DatabaseName= 'test';
$DatabaseUserName= 'test';
$DatabaseUserPassword= 'test';
$Fields= array ();
$Fields[]= array (
	'Name' => 'Field 1',
	'Description' => 'Description for field 1',
	'Type' => 'bool',
	'UsePredefined' => true,
	'Predefined' => array (
		array (
			'Yes' => '1'
		),
		array (
			'No' => '0'
		)
	),
	'PredefinedDefault' => 1
);
$TableName= 'Testtable';
$TableDescription= 'BlahBlah';
try
{
	Datamanager :: Initialize();
	Datamanager :: Connect($DatabaseHost, $DatabasePort, $DatabaseName, $DatabaseUserName, $DatabaseUserPassword);
	$Table= Datamanager :: NewTable($TableName, $TableDescription, $Fields);
}
catch (exception $Exception)
{
	echo "<pre>Error:\n" . print_r($Exception->GetMessage(), 1) . "</pre>";
}
?>