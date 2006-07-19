<?php
require_once dirname(__FILE__) . '/Config.php';
// Verzeichnis oeffnen
$dh= dir($dirMyPrograms);
if (!$dh)
{
	echo 'Can not read directory: ' . $dirMyPrograms;
	exit (1);
}
while ($file= $dh->read())
{
	if ($file == '.' || $file == '..' || !is_dir($dirMyPrograms . '/' . $file))
	{
		continue;
	}
	if (($nameOfProgram= getProgramName($file)) == false)
	{
		continue;
	}
	echo 'Try setup : '.$nameOfProgram.$nl;
	SetupUnpacked($file);
	echo 'Setup succesful: '.$nameOfProgram.$nl;}
$dh->close();
?>