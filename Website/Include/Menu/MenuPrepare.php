<?php
echo 'Preparing menu...<br>';
flush();
/** Benoetigt die Available-Variablen **/
#$AvailableNews
#$AvailableProducts
krsort($NewsPrepared);
foreach ($NewsPrepared as $News)
{
	if (is_array($News['inmenu']))
	{
		$MenuPrepared['news']['visible'][]= $News;
	}
	$MenuPrepared['news']['invisible'][]= $News;
}
$Menu
?>