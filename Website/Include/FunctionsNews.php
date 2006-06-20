<?php
function CheckNewsDate(& $Check)
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
			$Check[$Language][]['value']= trim($Line);
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
function CheckNewsInmenu(& $Check, & $Headline)
{
	if ($Check === 'yes')
	{
		$Check= $Headline;
	}
	return true;
}
function GenerateNews($News)
{
	global $UsedLanguages;
	foreach ($UsedLanguages as $Language)
	{
		$NewItems= array ();
		foreach ($News as $Newsbit)
		{
			foreach ($Newsbit as $New)
			{
				$NewItems[]= PrepareNewsArray($New, $Language);
			}
		}
		$Tpl= new smartertemplate(dirname(__FILE__) . '/../Input/Templates/News.html');
		$Tpl->Assign('language', $Language);
		$Tpl->Assign('news', $NewItems);
		$Pageresult= $Tpl->Result();
		$Fh= fopen(dirname(__FILE__) . '/../Output/News/_news_' . $Language . '.html', 'w');
		fputs($Fh, $Pageresult);
		fclose($Fh);
		$Tpl->SetTemplatefilename(dirname(__FILE__) . '/../Input/Templates/Newsmenu.html');
		$Pageresult= $Tpl->Result();
		$Fh= fopen(dirname(__FILE__) . '/../Output/News/_newsmenu_' . $Language . '.html', 'w');
		fputs($Fh, $Pageresult);
		fclose($Fh);
	}
}
function PrepareNewsArray($News, $Language)
{
	global $Languagetexts;
	$Tplvar['language']= $Language;
	$Tplvar['langtext']= $Languagetexts[$Language];
	$Tplvar['date']= $News['date'];
	$Tplvar['icon']= $News['icon'][$Language];
	$Tplvar['inmenu']= $News['inmenu'][$Language];
	$Tplvar['menuname']= $News['menuname'][$Language];
	$Tplvar['headline']= $News['headline'][$Language];
	$Tplvar['description']= $News['description'][$Language];
	if (!isset ($News['newsdoc']))
	{
		$Tplvar['newsdoc']= '';
	}
	else
	{
		foreach ($News['newsdoc'] as $Newsdoc)
		{
			$Tplvar['newsdoc'][]= $Newsdoc[$Language];
		}
	}
	return $Tplvar;
}
?>