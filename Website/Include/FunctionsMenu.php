<?php
function CheckMenuname(& $Check)
{
	global $DefaultLanguage, $UsedLanguages;
	if (!is_array($Check))
	{
		echo 'MENUNAME is not an array';
		return false;
	}
	if (!isset ($Check[$DefaultLanguage]))
	{
		echo 'default language for MENUNAME not set';
		return false;
	}
	foreach ($UsedLanguages as $Language)
	{
		if (!isset ($Check[$Language]))
		{
			$Check[$Language]= $Check[$DefaultLanguage];
		}
		if (strlen($Check[$Language]) == 0)
		{
			echo 'MENUNAME unset for ' . $Language;
			return false;
		}
	}
	return true;
}
?>