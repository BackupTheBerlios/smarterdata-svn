<?php
function CheckAboutUsId(& $Check)
{
	if (is_array($Check))
	{
		echo 'Id is an array';
		return false;
	}
	return true;
}
function CheckAboutUsImage(& $Check)
{
	global $DefaultLanguage, $UsedLanguages;
	if (!is_array($Check))
	{
		echo 'AboutUsImage is not an array';
		return false;
	}
	if (!isset ($Check['position']))
	{
		echo 'AboutUsImage position not set';
		return false;
	}
	if (!isset ($Check['path']))
	{
		echo 'AboutUsImage path not set';
		return false;
	}
	if (!file_exists(dirname(__FILE__) . '/../site_html/Images/Other/' . $Check['path']))
	{
		echo 'IMAGE does not exist. ' . $Check['path'];
		return false;
	}
	return true;
}
function CheckAboutUsContent(& $Check)
{
	global $DefaultLanguage, $UsedLanguages;
	if (!is_array($Check))
	{
		echo 'AboutUsContent is not an array';
		return false;
	}
	if (!isset ($Check[$DefaultLanguage]))
	{
		echo 'default language for AboutUsContent not set';
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
			echo 'AboutUsContent unset for ' . $Language;
			return false;
		}
	}
	return true;
}
function GenerateAboutUs($Abouts)
{
	global $UsedLanguages;
	foreach ($UsedLanguages as $Language)
	{
		$NewItems= array ();
		foreach ($Abouts as $AboutUs)
		{
			$NewItems[]= PrepareAboutUsArray($AboutUs, $Language);
		}
		$Tpl= new smartertemplate(dirname(__FILE__) . '/../Input/Templates/AboutUs.html');
		$Tpl->Assign('aboutus', $NewItems);
		$Pageresult= $Tpl->Result();
		$Fh= fopen(dirname(__FILE__) . '/../Output/AboutUs/_aboutus_' . $Language . '.html', 'w');
		fputs($Fh, $Pageresult);
		fclose($Fh);
	}
}
function PrepareAboutUsArray($AboutUs, $Language)
{
	global $Languagetexts;
	$Tplvar['language']= $Language;
	$Tplvar['imagepath']= $AboutUs['image']['path'];
	$Tplvar['imageposition']= $AboutUs['image']['position'];
	$Tplvar['content']= $AboutUs['content'][$Language];
	return $Tplvar;
}
?>