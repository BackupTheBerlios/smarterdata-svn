<?php
function CheckImpressumText(& $Check)
{
	global $DefaultLanguage, $UsedLanguages;
	if (!is_array($Check))
	{
		echo 'impressum text is not an array';
		return false;
	}
	if (!isset ($Check[$DefaultLanguage]))
	{
		echo 'default language for impressum text not set';
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
			echo 'impressum text unset for ' . $Language;
			return false;
		}
	}
	return true;
}
function GenerateImpressum($Impressums)
{
	global $UsedLanguages;
	foreach ($UsedLanguages as $Language)
	{
		$NewItems= array ();
		foreach ($Impressums as $Impressum)
		{
			$NewItems[]= PrepareImpressumArray($Impressum, $Language);
		}
		$Tpl= new smartertemplate(dirname(__FILE__) . '/../Input/Templates/Impressum.html');
		$Tpl->Assign('language', $Language);
		$Tpl->Assign('impressum', $NewItems);
		$Pageresult= $Tpl->Result();
		$Fh= fopen(dirname(__FILE__) . '/../Output/Impressum/_impressum_' . $Language . '.html', 'w');
		fputs($Fh, $Pageresult);
		fclose($Fh);
	}
}
function PrepareImpressumArray($Impressum, $Language)
{
	global $Languagetexts;
	$Tplvar['language']= $Language;
	$Text = explode("\n", $Impressum['text'][$Language]);
	foreach($Text as $Line)
	{
		$Tplvar['text'].= trim($Line)."\n";
	}
	$Tplvar['langtext']= $Languagetexts[$Language];
	return $Tplvar;
}
?>