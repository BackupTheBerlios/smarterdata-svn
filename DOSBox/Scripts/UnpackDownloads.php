<?php
$rootDir= str_replace('\\', '/', dirname(__FILE__));
if (!preg_match("|^(.*)/([^/]{1,})$|", $rootDir, $result))
{
	echo 'Can not create root directory: ' . $rootDir;
	exit (1);
}
$rootDir= $result[1];
$unzipExe = $rootDir.'/tools/unzip.exe';
$options = '-o -qq';
$dirDownloads= $rootDir . '/MyGames';
$dh= dir($dirDownloads);
if (!$dh)
{
	echo 'Can not read directory: ' . $dirDownloads;
	exit (1);
}

set curdir=%CD%
cd "%curdir%\MyGames"
FOR /F "eol=; tokens=1* delims=." %%a IN ('dir /b "%curdir%\Downloads\*.zip"') DO (
	echo Unpack %%a
	"%curdir%\tools\unzip.exe" -o -qq "%curdir%\Downloads\%%a.zip"
)
cd..
call ResetGamesPath.bat