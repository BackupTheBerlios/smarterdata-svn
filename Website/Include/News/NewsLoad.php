<?php
echo 'Loading news...<br>';
flush();
$Directory= dirname(__FILE__) . '/../../Input/News';
$Dir= dir($Directory);
$Items= array ();
while ($File= $Dir->Read())
{
	if ($File == '..' || $File == '.' || !is_file($Directory . '/' . $File))
	{
		continue;
	}
	$Product= new Config;
	$Temp= & $Product->ParseConfig($Directory . '/' . $File, 'XML');
	$Temp= $Temp->toArray();
	$Filename= substr($File, 0, strlen($File) - 4);
	$AvailableNews[$Filename]= $Temp['root']['item'];
}
?>