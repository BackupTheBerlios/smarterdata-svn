<?php
require dirname(__FILE__) . '/../Include.php';
require dirname(__FILE__) . '/Config.php';
$databaseHost= 'localhost';
$databasePort= 3306;
$databaseName= 'test';
$databaseUserName= 'test';
$databaseUserPassword= 'test';
$translation['tableName']= 'test';
$translation['cellNameUniqueId']= 'id';
$translation['cellNameParentId']= 'pid';
$translation['cellNameDateCreated']= 'date_created';
$translation['cellNameDateChanged']= 'date_changed';
$translation['keyForChildren']= '//CHILDREN//';
$translation['order']= array (
	array (
		'cell_name' => 'id',
		'direction' => 'ASC'
	)
);
$translation['where']= array (
	array (
		'cell_name' => 'id',
		'cell_op' => '<',
		'cell_value' => 4
	)
);
$pdo= LhPdo :: connect($databaseHost, $databasePort, $databaseName, $databaseUserName, $databaseUserPassword);
$coreTest= new LhCoreTest(& $pdo, $translation);
?>