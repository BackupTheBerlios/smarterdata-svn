<?php
$rootDir= str_replace('\\', '/', dirname(__FILE__));
if (!preg_match("|^(.*)/([^/]{1,})$|", $rootDir, $result))
{
	echo 'Can not create root directory: ' . $rootDir;
	exit (1);
}
$rootDir= $result[1];
$dirMyPrograms= $rootDir . '/MyPrograms';
$dirMyProgramsWindows= str_replace('/', '\\', $dirMyPrograms);
$dirMyDownloads= $rootDir . '/MyDownloads';
$dirMyDownloadsWindows= str_replace('/', '\\', $dirMyDownloads);
$nameFileConfig= 'setup.conf';
$nl= "\n";
if (OS_WINDOWS)
{
	$nl= "\n\r";
}
else
{
	$nl= "\n\r";
}
function getProgramName($filename)
{
	if (!preg_match('/^(.*), ([^,]{1,})$/', $filename, $result))
	{
		echo 'Can not create program name: ' . $filename;
		return false;
	}
	return $result[1];
}
function parseConfig($curDir)
{
	global $nl;
	if (!file_exists($curDir . '/setup.conf'))
	{
		$fh= fopen($curDir . '/setup.conf', 'w');
		if ($fh)
		{
			fputs($fh, "filename=\nconfname=\n");
			fclose($fh);
		}
		echo 'Setup does not exist for ' . $curDir . $nl;
		return false;
	}
	$programConfig= array ();
	$fileContent= file($curDir . '/setup.conf');
	foreach ($fileContent as $line)
	{
		$type= strtolower(substr($line, 0, 8));
		$name= trim(substr($line, 9));
		if ($name == '')
		{
			echo 'No data for entry: ' . $line;
			return false;
		}
		if (!preg_match('/^([^;]{1,});(.*)$/', $name, $result2))
		{
			echo 'Can not find name in entry: ' . $name;
			return false;
		}
		$programConfig[$type][]= array (
			'file' => $result2[1],
			'entry' => $result2[2]
		);
	}
	if (sizeof($programConfig['confname']) > 25)
	{
		echo 'Max. 25 confname entries';
		return false;
	}
	if (sizeof($programConfig['filename']) > 10)
	{
		echo 'Max. 10 filename entries';
		return false;
	}
	if (sizeof($programConfig['filename']) == 0)
	{
		echo 'No filename set';
		return false;
	}
	return $programConfig;
}
function generateDosBoxConf($curDir)
{
	global $rootDir, $nl;
	$fh= fopen($curDir . '/dosbox.conf', 'w');
	if (!$fh)
	{
		echo 'Can not create dosbox.conf' . $nl;
		return false;
	}
	$dosboxConf=<<<BLIP
[sdl]
fullscreen=false
fulldouble=false
fullresolution=original
windowresolution=original
output=surface
autolock=true
sensitivity=100
waitonerror=true
priority=higher,normal
mapperfile=mapper.txt
usescancodes=true

[dosbox]
language=
machine=vga
captures=capture
memsize=32

[render]
frameskip=0
aspect=false
scaler=normal2x

[cpu]
core=normal
cycles=3500
cycleup=500
cycledown=20

[mixer]
nosound=false
rate=22050
blocksize=2048
prebuffer=10

[midi]
mpu401=intelligent
device=default
config=

[sblaster]
sbtype=sb16
sbbase=220
irq=7
dma=1
hdma=5
mixer=true
oplmode=auto
oplrate=22050

[gus]
gus=true
gusrate=22050
gusbase=240
irq1=5
irq2=5
dma1=3
dma2=3
ultradir=C:\ULTRASND

[speaker]
pcspeaker=true
pcrate=22050
tandy=auto
tandyrate=22050
disney=true

[bios]
joysticktype=2axis

[serial]
serial1=dummy
serial2=dummy
serial3=disabled
serial4=disabled

[dos]
xms=true
ems=true
umb=true

[ipx]
ipx=false

BLIP;
	$dosboxConf .= '[autoexec]
';
	$dosboxConf .= 'mount C "' . str_replace('/', '\\', $curDir) . '"
';
	$dosboxConf .= 'mount D "' . str_replace('/', '\\', $rootDir . '\program\KEYB') . '"
';
	$dosboxConf .= 'D:
cd \ 
keyb gr 
C:
cd \
zzz.bat
';
	fputs($fh, $dosboxConf);
	fclose($fh);
	return true;
}
function generateStartGameBat($curDir)
{
	global $rootDir, $nl;
	$fh= fopen($curDir . '/__START_GAME.bat', 'w');
	if (!$fh)
	{
		echo 'Can not create __START_GAME.bat' . $nl;
		return false;
	}
	fputs($fh, str_replace('/', '\\', '"' . $rootDir . '/program/dosbox.exe" -conf' . ' "' . $curDir . '/dosbox.conf"'));
	fclose($fh);
	return true;
}
function generateZzzBat($curDir, $programName, $programConfig)
{
	global $nl;
	$startbatch= '@echo off
:start
cls
echo   ' . $programName . '
echo ===================================
';
	$middlebatch= '';
	$endbatch= '';
	$choicebatch= 'D:\choice.com -c:';
	$currentChar= ord('A');
	$i= 1;
	if (is_array($programConfig['confname']))
	{
		foreach ($programConfig['confname'] as $entry)
		{
			$startbatch .= 'echo ' . chr($currentChar) . '= ' . $entry['entry'] . '
																												';
			$middlebatch= 'IF ERRORLEVEL ' . (int) $i . ' GOTO SETUP_' . chr($currentChar) . '
																												' . $middlebatch;
			$choicebatch .= chr($currentChar);
			$endbatch .= ':SETUP_' . chr($currentChar) . '
														cd game
																												call ' . $entry['file'] . '
																												goto start
																												';
			$i++;
			$currentChar++;
		}
	}
	$currentChar= ord('0');
	if (is_array($programConfig['filename']))
	{
		foreach ($programConfig['filename'] as $entry)
		{
			$startbatch .= 'echo ' . chr($currentChar) . '= ' . $entry['entry'] . '
																												';
			$middlebatch= 'IF ERRORLEVEL ' . $i . ' GOTO GAME_' . chr($currentChar) . '
																												' . $middlebatch;
			$choicebatch .= chr($currentChar);
			$endbatch .= ':GAME_' . chr($currentChar) . '
																												cd game
																												call ' . $entry['file'] . '
																												goto start
																												';
			$i++;
			$currentChar++;
		}
	}
	$startbatch .= 'echo Z= EXIT
';
	$middlebatch= 'IF ERRORLEVEL ' . $i . ' GOTO EXIT
' . $middlebatch . '
goto start
';
	$choicebatch .= 'Z
';
	$endbatch .= ':EXIT
exit
';
	$fileContent= $startbatch . $choicebatch . $middlebatch . $endbatch;
	$fh= fopen($curDir . '/zzz.bat', 'w');
	if (!$fh)
	{
		echo 'Can not create zzz.bat' . $nl;
		return false;
	}
	fputs($fh, $fileContent);
	fclose($fh);
	return true;
}
function SetupUnpacked($nameOfProgram)
{
	global $dirMyPrograms, $nl;
	$curDir= $dirMyPrograms.'/'.$nameOfProgram;
	if (($programConfig= ParseConfig($curDir)) == false)
	{
		return false;
	}
	if (($programName= getProgramName($nameOfProgram)) == false)
	{
		return false;
	}
	if (generateZzzBat($curDir, $programName, $programConfig) == false)
	{
		return false;
	}
	if (generateDosBoxConf($curDir) == false)
	{
		return false;
	}
	if (generateStartGameBat($curDir) == false)
	{
		return false;
	}
}
?>