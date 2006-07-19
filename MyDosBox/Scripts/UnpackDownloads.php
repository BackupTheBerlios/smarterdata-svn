<?php
require_once dirname(__FILE__) . '/Config.php';
$dh= dir($dirMyDownloads);
if (!$dh)
{
	echo 'Can not read directory: ' . $dirMyDownloads;
	exit (1);
}
$unzipExe= $rootDir . '/tools/unzip.exe';
$unzipOptions= '-o -qq';
while ($file= $dh->read())
{
	if ($file == '.' || $file == '..' || is_dir($dirMyDownloads . '/' . $file))
	{
		continue;
	}
	if (($nameOfProgram= getProgramName($file)) == false)
	{
		continue;
	}
	if (!preg_match('/^(.*)\.zip$/', $file, $result))
	{
		continue;
	}
	$nameOfDirectory= $result[1];
	if (is_dir($dirMyPrograms . '/' . $nameOfDirectory))
	{
		echo 'Program exist: ' . $nameOfProgram . "\n";
		continue;
	}
	echo 'Try installing: '.$nameOfProgram.$nl;
	$commandline= $unzipExe . ' ' . $unzipOptions . ' "' . str_replace('/', '\\', $dirMyDownloads . '/' . $file . '"');
	$commandlineReturn= '';
	system($commandline, & $commandlineReturn);
	if ($commandlineReturn !== 0 || !is_dir($rootDir . '/Scripts/' . $nameOfDirectory))
	{
		echo 'Error while unpack: ' . $nameOfProgram . "\n";
		continue;
	}
	if (!@ rename($rootDir . '/Scripts/' . $nameOfDirectory, $dirMyPrograms . '/' . $nameOfDirectory))
	{
		echo 'Installation failed. Please delete : ' . $rootDir . '/Scripts/' . $nameOfDirectory . $nl;
		continue;
	}
	SetupUnpacked($nameOfDirectory);
	echo 'Installed succesful: '.$nameOfProgram.$nl;
}
$dh->close();
?>