<?php
define('OK', true);
$nl= "\n";
$directoryRoot= str_replace('\\', '/', dirname(__FILE__));
$fileClassUserExceptions= $directoryRoot . '/include/UserExceptions.php';
$fileClassUserManager= $directoryRoot . '/include/UserManager.php';
$fileClassUser= $directoryRoot . '/include/User.php';
$fileConfig= $directoryRoot . '/include/Configuration/Config.php';
$currentRequest= parse_url($_SERVER['REQUEST_URI']);
$currentRequestFile= basename($currentRequest['path']);
$userManager= null;
$databaseHost= null;
$databaseUsername= null;
$databaseUserpass= null;
$databaseName= null;
$databaseTableprefix= null;
/*
 * Begin code
 */
require_once $fileClassUserExceptions;
require_once $fileClassUserManager;
require_once $fileClassUser;
if (file_exists($fileConfig))
{
	require_once $fileConfig;
	$databaseHandler= mysql_connect($databaseHost, $databaseUsername, $databaseUserpass);
	if (!mysql_select_db($databaseName, $databaseHandler))
	{
		die('Can not use database: ' . $databaseName);
	}
	else
	{
		try
		{
			$userManager= new UserManager(& $databaseHandler, $databaseTableprefix);
		}
		catch (exceptionUserLogin $error)
		{
			echo '<pre>' . print_r($error->getMessage(), 1) . '</pre>';
		}
		catch (exceptionUserProblem $error)
		{
			echo '<pre>' . print_r($error->getMessage(), 1) . '</pre>';
		}
		catch (exceptionUserSql $error)
		{
			echo '<pre>' . print_r($error->getMessage(), 1) . '</pre>';
		}
		catch (exceptionUserSet $error)
		{
			echo '<pre>' . print_r($error->getMessage(), 1) . '</pre>';
		}
	}
}
else
{
	if (strtolower($currentRequestFile) != 'setup.php')
	{
		require_once $directoryRoot . '/Admin/Setup.php';
		die();
	}
}
?>