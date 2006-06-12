<?php
function CheckHeaderImage(& $Check)
{
	global $DefaultLanguage, $UsedLanguages;
	$Imagepath= dirname(__FILE__) . '/../site_html/images/';
	if (!is_array($Check))
	{
		echo 'header image is not an array';
		return false;
	}
	if (!isset ($Check[$DefaultLanguage]))
	{
		echo 'default language for header image not set';
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
			echo 'header image unset for ' . $Language;
			return false;
		}
		if (!is_file($Imagepath . $Check[$Language]))
		{
			echo $Imagepath . $Check[$Language];
			echo 'header image not found for ' . $Language;
			return false;
		}
	}
	return true;
}
function CheckHeaderLinkto(& $Check)
{
	global $DefaultLanguage, $UsedLanguages;
	$Mainpath= dirname(__FILE__) . '/../site_html/';
	if (!is_array($Check))
	{
		echo 'header image is not an array';
		return false;
	}
	if (!isset ($Check[$DefaultLanguage]))
	{
		echo 'default language for header linkto not set';
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
			echo 'header linkto unset for ' . $Language;
			return false;
		}
		echo $Mainpath . $Check[$Language] . '<br>';
		if (!file_exists($Mainpath . $Check[$Language]))
		{
			echo 'header linkto not found.';
			return false;
		}
	}
	return true;
}
function GenerateHeader($Headers)
{
	global $UsedLanguages;
	foreach ($UsedLanguages as $Language)
	{
		$NewItems= array ();
		foreach ($Headers as $Header)
		{
			$NewItems[]= PrepareHeaderArray($Header, $Language);
		}
		$Tpl= new smartertemplate(dirname(__FILE__) . '/../Input/Templates/Header.html');
		$Tpl->Assign('language', $Language);
		$Tpl->Assign('header', $NewItems);
		$Pageresult= $Tpl->Result();
		$Fh= fopen(dirname(__FILE__) . '/../Output/Header/_header_' . $Language . '.html', 'w');
		fputs($Fh, $Pageresult);
		fclose($Fh);
	}
}
function PrepareHeaderArray($Header, $Language)
{
	global $Languagetexts;
	$Tplvar['language']= $Language;
	$Tplvar['image']= $Header['image'][$Language];
	if (isset ($Header['linkto']))
	{
		$Tplvar['linkto']= $Header['linkto'][$Language];
	}
	else
	{
		$Tplvar['linkto']= '';
	}
	$Tplvar['langtext']= $Languagetexts[$Language];
	return $Tplvar;
}
?>