<?php
echo 'Prepare impressum...<br>';
flush();
ksort($AvailableImpressum);
foreach ($AvailableImpressum as $Impressum)
{
	if (!CheckImpressumText($Impressum['text']))
	{
		die('E CheckImpressumText');
	}
	$ImpressumPrepared[]= $Impressum;
}
?>