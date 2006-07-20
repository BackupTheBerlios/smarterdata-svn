<?php
require_once dirname(__FILE__) . '/Config.php';
$dh= dir($dirMyPrograms);
if (!$dh)
{
	echo 'Can not read directory: ' . $dirMyPrograms;
	exit (1);
}
$zipExe=$rootDir . '/tools/zip.exe';
$zipOptions='-r -9 -qq';
while ($file= $dh->read())
{
	if ($file == '.' || $file == '..' || !is_dir($dirMyPrograms . '/' . $file))
	{
		continue;
	}
	if(!file_exists($dirMyPrograms.'/'.$file.'/setup.conf'))
	{
		echo 'setup.conf does not exist: '.$file.$nl;
		continue;
	}
	if(!file_exists($dirMyPrograms.'/'.$file.'/zzz.bat'))
	{
		echo 'zzz.bat does not exist: '.$file.$nl;
		continue;
	}
	if(!file_exists($dirMyPrograms.'/'.$file.'/__START_GAME.bat'))
	{
		echo '__START_GAME.bat does not exist: '.$file.$nl;
		continue;
	}
	if(!file_exists($dirMyPrograms.'/'.$file.'/dosbox.conf'))
	{
		echo 'dosbox.conf does not exist: '.$file.$nl;
		continue;
	}
	@unlink($dirMyPrograms.'/'.$file.'/zzz.bat');
	@unlink($dirMyPrograms.'/'.$file.'/__START_GAME.bat');
	@unlink($dirMyPrograms.'/'.$file.'/dosbox.conf');
	if(file_exists($dirMyDownloads.'/'.$file.'.zip'))
	{
		for($i = 0; $i < 1000; $i++)
		{
			if(!file_exists($dirMyDownloads.'/'.$file.'.'.$i.'.zip'))
			{
				rename ($dirMyDownloads.'/'.$file.'.zip',$dirMyDownloads.'/'.$file.'.'.$i.'.zip');
				break;
			}
		}
	}
	$returnCode=0;
	$currentDir = getcwd();
	chdir($dirMyProgramsWindows);
	system('"'.$zipExe.' '.$zipOptions.' "'.$dirMyDownloadsWindows.'\\'.$file.'.zip" "'.$file.'"', $returnCode);
	chdir($currentDir);
	if($returnCode !== 0 )
	{
		echo 'Error while packing: '.$file.$nl;
		continue;
	}
}
?>