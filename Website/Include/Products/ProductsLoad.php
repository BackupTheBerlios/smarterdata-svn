<?php
echo 'Loading products...<br>';
flush();
$Directory= dirname(__FILE__) . '/../../Input/Products';
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
	$AvailableProducts[$Filename]= $Temp['root']['item'];
}
?>