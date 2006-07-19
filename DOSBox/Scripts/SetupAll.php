<?php
$rootDir= str_replace('\\', '/', dirname(__FILE__)) . '/..';
$dirDownloads= $rootDir . '/MyGames';
$dh= dir($dirDownloads);
if (!$dh)
{
	echo 'Can not read directory: ' . $dirDownloads;
	exit (1);
}
while ($file= $dh->read())
{
	if ($file == '.' || $file == '..' || !is_dir($dirDownloads . '/' . $file))
	{
		continue;
	}
	$curDir= $dirDownloads . '/' . $file;
	if (!file_exists($curDir . '/setup.conf'))
	{
		echo 'Setup does not exist for ' . $file . "\n";
		continue;
	}
	if (!preg_match('/^(.*), ([^,]{1,})$/', $file, $result))
	{
		echo 'Can not create program name: ' . $file;
		exit (1);
	}
	$programName= $result[1];
	$programConfig= array ();
	echo 'Check program: ' . $programName . "\n";
	$fileContent= file($curDir . '/setup.conf');
	foreach ($fileContent as $line)
	{
		$type= strtolower(substr($line, 0, 8));
		$name= trim(substr($line, 9));
		if ($name == '')
		{
			echo 'No data for entry: ' . $line;
			continue;
		}
		if (!preg_match('/^([^;]{1,});(.*)$/', $name, $result2))
		{
			echo 'Can not find name in entry: ' . $name;
			continue;
		}
		echo $type;
		$programConfig[$type][]= array (
			'file' => $result2[1],
			'entry' => $result2[2]
		);
	}
	if (sizeof($programConfig['confname']) > 25)
	{
		echo 'Max. 25 confname entries';
	}
	if (sizeof($programConfig['filename']) > 10)
	{
		echo 'Max. 10 filename entries';
	}
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
	$usedChars= array ();
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
		echo 'Can not create zzz.bat';
	}
	fputs($fh, $fileContent);
	fclose($fh);
	$fh= fopen($curDir . '/__START_GAME.bat', 'w');
	if (!$fh)
	{
		echo 'Can not create __START_GAME.bat';
	}
	fputs($fh, str_replace('/', '\\', '"' . $rootDir . '/program/dosbox.exe" -conf' . ' "' . $rootDir . '/MyGames/' . $file . '/dosbox.conf"'));
	fclose($fh);
	
/*
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
\n
[ipx]\n
ipx=false\n
\n[autoexec]";
mount D "G:\_Workspace\DOSBox\program\keyb" 
D: 
keyb gr 
mount C "G:\_Workspace\DOSBox\MyGames\1000 Miglia, Racing" 
C: 
zzz.bat
*/ 
}
?>