<?php
echo 'Loading headers...<br>';
flush();
$Directory= dirname(__FILE__) . '/../../Input/Header';
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
	$AvailableHeader[$Filename]= $Temp['root']['item'];
}
echo '<pre>'.print_r($AvailableHeader, 1).'</pre>';
?>