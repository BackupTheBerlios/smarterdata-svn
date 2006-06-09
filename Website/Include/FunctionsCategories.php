<?php
function CheckCategoryId(& $Check)
{
	if (strlen($Check) !== 2)
	{
		echo 'Category id wrong';
		return false;
	}
	return true;
}
function CheckCategoryPosition(& $Check)
{
	if (!is_numeric($Check))
	{
		echo 'Category position wrong';
		return false;
	}
	return true;
}
function CheckCategoryHtmldataName(& $Check)
{
	global $DefaultLanguage, $UsedLanguages;
	if (!is_array($Check))
	{
		echo 'category htmldata name is not an array';
		return false;
	}
	if (!isset ($Check[$DefaultLanguage]))
	{
		echo 'default language for category htmldata name not set';
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
			echo 'category htmldata name unset for ' . $Language;
			return false;
		}
	}
	return true;
}
function GenerateCategories($Categories)
{
	global $UsedLanguages;
	foreach ($UsedLanguages as $Language)
	{
		$NewItems= array ();
		foreach ($Categories as $Category)
		{
			$NewItems[]= PrepareCategoryArray($Category, $Language);
		}
		
		$Tpl= new smartertemplate(dirname(__FILE__) . '/../Input/Templates/Categories.html');
		$Tpl->Assign('language', $Language);
		$Tpl->Assign('categories', $NewItems);
		$Pageresult= $Tpl->Result();
		$Fh= fopen(dirname(__FILE__) . '/../Output/Categories/_menu_categories_' . $Language . '.html', 'w');
		fputs($Fh, $Pageresult);
		fclose($Fh);
	}
}
function PrepareCategoryArray($Category, $Language)
{
	global $Languagetexts;
	$Tplvar['language']= $Language;
	$Tplvar['id']= $Category['id'];
	$Tplvar['position']= $Category['position'];
	$Tplvar['name']= $Category['htmldata']['name'][$Language];
	return $Tplvar;
}
?>