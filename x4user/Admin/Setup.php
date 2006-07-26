<?php
if (!defined('OK'))
{
	require str_replace('\\', '/', dirname(__FILE__)) . '/../Include.php';
}
if (file_exists($fileConfig))
{
	die('Configuration exists');
}
$currentErrors= array ();
$currentOk= false;
if (isset ($_POST['databaseHost']) && isset ($_POST['databaseUsername']) && isset ($_POST['databaseUserpass']) && isset ($_POST['databaseName']) && isset ($_POST['databaseTableprefix']))
{
	$databaseHandler= @ mysql_connect($_POST['databaseHost'], $_POST['databaseUsername'], $_POST['databaseUserpass']);
	if (!$databaseHandler)
	{
		$currentErrors[]= 'Can not connect to database';
	}
	else
	{
		if (!mysql_select_db($_POST['databaseName'], $databaseHandler))
		{
			$currentErrors[]= 'Can not use database';
		}
		else
		{
			$currentOk= true;
		}
	}
}
if ($currentOk === true)
{
	$fileHandler= fopen($directoryRoot . '/Include/Configuration/Config.php', 'w');
	if (!$fileHandler)
	{
		$currentOk= false;
	}
	else
	{
		fputs($fileHandler, '<?php' . $nl);
		fputs($fileHandler, '$databaseHost=\'' . addslashes($_POST['databaseHost']) . '\';' . $nl);
		fputs($fileHandler, '$databaseUsername=\'' . addslashes($_POST['databaseUsername']) . '\';' . $nl);
		fputs($fileHandler, '$databaseUserpass=\'' . addslashes($_POST['databaseUserpass']) . '\';' . $nl);
		fputs($fileHandler, '$databaseName=\'' . addslashes($_POST['databaseName']) . '\';' . $nl);
		fputs($fileHandler, '$databaseTableprefix=\'' . addslashes($_POST['databaseTableprefix']) . '\';' . $nl);
		fputs($fileHandler, '?>');
		fclose($fileHandler);
	}
}
if ($currentOk === false)
{
	require $directoryRoot . '/Admin/Templates/Setup.01.php';
}
die();
?>