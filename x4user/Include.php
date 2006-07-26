<?php
$directoryRoot= str_replace('\\', '/', dirname(__FILE__));
$fileClassUserExceptions= $directoryRoot . '/include/UserExceptions.php';
$fileClassUserManager= $directoryRoot . '/include/UserManager.php';
$fileClassUser= $directoryRoot . '/include/User.php';
$fileConfig= $directoryRoot . '/include/Configuration/Config.php';
/*
 * Begin code
 */
require_once $fileClassUserExceptions;
require_once $fileClassUserManager;
require_once $fileClassUser;
if (!file_exists($fileConfig))
{
	require_once $directoryRoot . '/Admin/Setup.php';
	die();
}
require_once $fileConfig;
$databaseHandler= mysql_connect($databaseHost, $databaseUsername, $databaseUserpass);
if (!mysql_select_db($databaseName, $databaseHandler))
{
	die('Can not use database: ' . $databaseName);
}
?>