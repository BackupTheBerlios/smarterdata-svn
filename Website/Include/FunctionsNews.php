<?php
function CheckNewsDate(&$Check)
{
	if (is_array($Check))
	{
		echo 'DATE is an array';
		return false;
	}
	if (!preg_match('/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/', $Check))
	{
		echo 'wrong DATE format (yyyy-mm-dd)';
		return false;
	}
	return true;
}
function CheckNewsIcon(& $Check)
{
	global $DefaultLanguage, $UsedLanguages;
	if (!is_array($Check))
	{
		echo 'ICON is not an array';
		return false;
	}
	if (!isset ($Check[$DefaultLanguage]))
	{
		echo 'default language for ICON not set';
		return false;
	}
	foreach ($UsedLanguages as $Language)
	{
		if (!isset ($Check[$Language]))
		{
			$Check[$Language]= $Check[$DefaultLanguage];
		}
		if (!file_exists(dirname(__FILE__) . '/../site_html/Images/' . $Check[$Language]))
		{
			echo 'ICON does not exist. ' . $Check[$Language];
			return false;
		}
	}
	return true;
}
function CheckNewsHeadline(& $Check)
{
	global $DefaultLanguage, $UsedLanguages;
	if (!is_array($Check))
	{
		echo 'HEADLINE is not an array';
		return false;
	}
	if (!isset ($Check[$DefaultLanguage]))
	{
		echo 'default language for HEADLINE not set';
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
			echo 'HEADLINE unset for ' . $Language;
			return false;
		}
	}
	return true;
}
function CheckNewsDescription(& $Check)
{
	global $DefaultLanguage, $UsedLanguages;
	if (!is_array($Check))
	{
		echo 'DESCRIPTION is not an array';
		return false;
	}
	if (!isset ($Check[$DefaultLanguage]))
	{
		echo 'default language for DESCRIPTION not set';
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
			echo 'DESCRIPTION unset for ' . $Language;
			return false;
		}
		$Description= explode("\n", $Check[$Language]);
		$Check[$Language]= array ();
		foreach ($Description as $Line)
		{
			$Check[$Language][]['value']= trim($Line) . "\n";
		}
	}
	return true;
}
function CheckNewsDoc(& $Check)
{
	global $DefaultLanguage, $UsedLanguages;
	if (!CheckMultiple($Check))
	{
		$Check= array (
			$Check
		);
	}
	foreach ($Check as $DocumentKey => $Document)
	{
		if (!isset ($Document[$DefaultLanguage]))
		{
			echo 'default language for NEWS not set';
			return false;
		}
		foreach ($UsedLanguages as $Language)
		{
			if (!isset ($Document[$Language]))
			{
				$Document[$Language]= $Document[$DefaultLanguage];
			}
			if (!CheckDocument($Document[$Language], 'News'))
			{
				echo 'NEWS does not exist. ' . $Document[$Language]['path'];
				return false;
			}
		}
		$Check[$DocumentKey]= $Document;
	}
	return true;
}
function CheckNewsInmenu(&$Check, &$Headline)
{
	if($Check === 'yes')
	{
		$Check = $Headline;
	}
	return true;
}
function GenerateNewssite($News)
{
	echo '<pre>' . print_r($News, 1) . '</pre>';
}
?>