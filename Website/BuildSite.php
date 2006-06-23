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
$UnlinkFiles= array ();
foreach ($UsedLanguages as $Language)
{
	$Index['header']= implode('', file(dirname(__FILE__) . '/Output/Header/_header_' . $Language . '.html'));
	$UnlinkFiles[]= dirname(__FILE__) . '/Output/Header/_header_' . $Language . '.html';
	$Index['menu']= implode('', file(dirname(__FILE__) . '/Output/Menu/_menu_' . $Language . '.html'));
	$UnlinkFiles[]= dirname(__FILE__) . '/Output/Menu/_menu_' . $Language . '.html';
	foreach ($Contentsites as $Section)
	{
		$Directory= dirname(__FILE__) . '/Output/' . $Section;
		$Dir= dir($Directory);
		while ($Value= $Dir->Read())
		{
			$Languagearray= array ();
			if ($Value == '.' || $Value == '..' || !is_file($Directory . '/' . $Value))
			{
				continue;
			}
			if (!preg_match('/^(.*)_' . $Language . '\.html$/', $Value, $Result))
			{
				continue;
			}
			foreach ($UsedLanguages as $CurrentLanguage)
			{
				$Languagearray[]= array (
					'name' => $CurrentLanguage,
					'filename' => urlencode($Result[1] . '_' . $CurrentLanguage . '.html'
				), 'flag' => 'Images/Other/' . $CurrentLanguage . '.png');
			}
			$Index['content']= implode('', file($Directory . '/' . $Value));
			$UnlinkFiles[]= $Directory . '/' . $Value;
			$Tpl= new smartertemplate(dirname(__FILE__) . '/Input/Templates/Index.html');
			$Tpl->Assign('language', $Language);
			$Tpl->Assign('langtext', $Languagetexts[$Language]);
			$Tpl->Assign('index', $Index);
			$Tpl->Assign('languages', $Languagearray);
			$Pageresult= $Tpl->Result();
			$Fh= fopen(dirname(__FILE__) . '/site_html/' . $Value, 'w');
			fputs($Fh, $Pageresult);
			fclose($Fh);
		}
	}
}
$Languagearray= array ();
foreach ($UsedLanguages as $CurrentLanguage)
{
	$Languagearray[]= array (
		'name' => $CurrentLanguage,
		'filename' => urlencode('_aboutus_' . $CurrentLanguage . '.html'
	), 'flag' => 'Images/Other/' . $CurrentLanguage . '.png', 'langtext' => $Languagetexts[$CurrentLanguage]);
}
$Tpl= new smartertemplate(dirname(__FILE__) . '/Input/Templates/Entrance.html');
$Tpl->Assign('language', $Language);
$Tpl->Assign('langtext', $Languagetexts[$Language]);
$Tpl->Assign('languages', $Languagearray);
$Pageresult= $Tpl->Result();
$Fh= fopen(dirname(__FILE__) . '/site_html/index.html', 'w');
fputs($Fh, $Pageresult);
fclose($Fh);
/**
 * Unlink
 */
foreach ($UnlinkFiles as $File)
{
	@ unlink($File);
}
?>