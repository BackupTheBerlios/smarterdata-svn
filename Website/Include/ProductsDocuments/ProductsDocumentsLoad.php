<?php
echo 'Loading productsdocuments...<br>';
flush();
$AvailableProductsDocuments = array();
foreach ($AvailableProducts as $Product)
{
	if (isset ($Product['manual']))
	{
		foreach($Product['manual'] as $Manual)
		{
			foreach($UsedLanguages as $Language)
			{
				$AvailableProductsDocuments['manuals'][$Language][$Product['name'][$Language]][$Manual[$Language]['path']] = $Manual[$Language];
			}
		}
	}
	if (isset ($Product['conformity']))
	{
		foreach($Product['conformity'] as $Conformity)
		{
			foreach($UsedLanguages as $Language)
			{
				$AvailableProductsDocuments['conformity'][$Language][$Product['name'][$Language]][$Conformity[$Language]['path']] = $Conformity[$Language];
			}
		}
	}
	if (isset ($Product['otherdoc']))
	{
		foreach($Product['otherdoc'] as $Otherdoc)
		{
			foreach($UsedLanguages as $Language)
			{
				$AvailableProductsDocuments['otherdoc'][$Language][$Product['name'][$Language]][$Otherdoc[$Language]['path']] = $Otherdoc[$Language];
			}
		}
	}
}
?>