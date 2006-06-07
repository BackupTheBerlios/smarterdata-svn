<?php
require_once str_replace('\\', '/', dirname(__FILE__)) . '/../Include.php';
require_once str_replace('\\', '/', dirname(__FILE__)) . '/Config.php';
Datamanager :: Connect($DatabaseHost, $DatabasePort, $DatabaseName, $DatabaseUsername, $DatabasePassword);
#Datamanager :: ResetTableId();
#Datamanager :: ResetTableData();
#Datamanager :: ResetTableAttribute();
Datamanager::ResetTableValues();
#$Data = Datamanager :: NewData('default');
$Data = Datamanager :: GetData(1);
$Data->SetParentId(1);
$Data->SetAttribute('First entry', 'First text');
$Data->SetAttribute('Second entry', 'Second text');
$Data->SetAttribute('First entry', 'Third text');
$Data->Store();
echo '<pre>' . print_r ($Data, 1) . '</pre>';
?>