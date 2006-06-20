<?php
function GenerateMenu($Menu)
{
	global $UsedLanguages, $Languagetexts;
	foreach ($UsedLanguages as $Language)
	{
		$Tpl= new smartertemplate(dirname(__FILE__) . '/../Input/Templates/Menu.html');
		$Tpl->Assign('language', $Language);
		$Tpl->Assign('langtext', $Languagetexts[$Language]);
		$Tpl->Assign('menu', $Menu[$Language]);
		$Pageresult= $Tpl->Result();
		$Fh= fopen(dirname(__FILE__) . '/../Output/Menu/_menu_' . $Language . '.html', 'w');
		fputs($Fh, $Pageresult);
		fclose($Fh);
	}
}
?>