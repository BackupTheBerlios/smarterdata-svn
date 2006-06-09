<?php
echo 'Loading contacts...<br>';
flush();
$Directory= dirname(__FILE__) . '/../../Input/Contacts';
$Dir= dir($Directory);
$Items= array ();
while ($File= $Dir->Read())
{
	if ($File == '..' || $File == '.' || !is_file($Directory . '/' . $File))
	{
		continue;
	}
	$AboutUs= new Config;
	$Temp= & $AboutUs->ParseConfig($Directory . '/' . $File, 'XML');
	$Temp= $Temp->toArray();
	$Filename= substr($File, 0, strlen($File) - 4);
	$AvailableContacts[$Filename]= $Temp['root']['item'];
}
?>