<?php
require dirname(__FILE__) . '/../Include.php';
require dirname(__FILE__) . '/Config.php';
$databaseHost= 'localhost';
$databasePort= 3306;
$databaseName= 'test';
$databaseUserName= 'test';
$databaseUserPassword= 'test';
$pdo= LhPdo :: connect($databaseHost, $databasePort, $databaseName, $databaseUserName, $databaseUserPassword);
$translation['tableName']= 'test';
$translation['cellNameUniqueId']= 'id';
$translation['cellNameParentId']= 'pid';
$translation['cellNameDateCreated']= 'date_created';
$translation['cellNameDateChanged']= 'date_changed';
$translation['keyForChildren']= '//CHILDREN//';
#$translation['order']= 'ORDER BY id DESC';
$translation['order']= array (
	array (
		'cell_name' => 'id',
		'direction' => 'ASC'
	)
);
#$translation['where']= 'WHERE id>2';
$translation['where']= array (
	array (
		'cell_name' => 'id',
		'cell_op' => '<',
		'cell_value' => 4
	)
);
$table= new LhCoreTest(& $pdo, $translation);
die();
$result= $table->getRow(1);
echo '<pre>' . print_r($result, 1) . '</pre>';
$result= $table->getRowsRecursiveDown(1);
echo '<pre>' . print_r($result, 1) . '</pre>';
$result= $table->getRowsRecursiveUp(5);
echo '<pre>' . print_r($result, 1) . '</pre>';
$result= $table->getPage(0, 10);
echo '<pre>' . print_r($result, 1) . '</pre>';
$result= $table->getTotal();
echo '<pre>' . print_r($result, 1) . '</pre>';
$result= $table->setRow(7, array (
	'name' => '7th-',
	'date_changed' => '07-07-2007-'
));
echo '<pre>' . print_r($result, 1) . '</pre>';
$result= $table->setRow(7, array (
	'name' => '7th',
	'date_changed' => '07-07-2007'
));
echo '<pre>' . print_r($result, 1) . '</pre>';
$uniqueId= $table->newRow(array (
	'name' => '8th'
));
echo '<pre>' . print_r($uniqueId, 1) . '</pre>';
$result= $table->updateRow($uniqueId, array ());
$result= $table->getLastUniqueId();
echo '<pre>' . print_r($result, 1) . '</pre>';
?>