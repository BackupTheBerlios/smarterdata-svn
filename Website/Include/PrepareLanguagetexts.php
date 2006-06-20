<?php
foreach ($Languagetexts[$DefaultLanguage] as $Key => $Value)
{
	foreach ($UsedLanguages as $Language)
	{
		if ($Language == $DefaultLanguage)
		{
			continue;
		}
		if (!isset ($Languagetexts[$Language][$Key]))
		{
			die('Sprachtext fuer ' . $Key . ' fehlt fuer ' . $Language);
		}
	}
}
?>