<?php
/**
 * Erstellt die Website
 * aus den Einzelteilen
 */
/**
 * Grundgeruest bauen mit
 *  index, menu, header
 * Seiten bauen
 *  aboutus
 *  news
 *  products
 *  documents
 *  contact
 *  imprint
 */
$Contentsites= array (
	'AboutUs',
	'Contacts',
	'Impressum',
	'News',
	'Products',
	'ProductsDocuments'
);
foreach ($UsedLanguages as $Language)
{
	$Index['header']= implode('', file(dirname(__FILE__) . '/Output/Header/_header_' . $Language . '.html'));
	$Index['menu']= implode('', file(dirname(__FILE__) . '/Output/Menu/_menu_' . $Language . '.html'));
	foreach ($Contentsites as $Section)
	{
		$Directory= dirname(__FILE__) . '/Output/' . $Section;
		$Dir= dir($Directory);
		while ($Value= $Dir->Read())
		{
			if ($Value == '.' || $Value == '..' || !is_file($Directory . '/' . $Value))
			{
				continue;
			}
			if (!preg_match('/_' . $Language . '\.html$/', $Value))
			{
				continue;
			}
			$Index['content']= implode('', file($Directory . '/' . $Value));
			$Tpl= new smartertemplate(dirname(__FILE__) . '/Input/Templates/Index.html');
			$Tpl->Assign('language', $Language);
			$Tpl->Assign('langtext', $Languagetexts[$Language]);
			$Tpl->Assign('index', $Index);
			$Pageresult= $Tpl->Result();
			$Fh= fopen(dirname(__FILE__) . '/Output/BuildSite/' . $Value, 'w');
			fputs($Fh, $Pageresult);
			fclose($Fh);
		}
	}
}
?>