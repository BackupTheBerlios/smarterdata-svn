<?php
require_once 'Config.php';
require_once dirname(__FILE__) . '/Include/SmarterTemplate/class.smartertemplate.php';
$UsedLanguages= array (
	'deutsch',
	'english',
	'fran�ais'
);
$Languagetexts= array (
	'deutsch' => array (
		'siehe_auch' => 'siehe auch',
		'datasheet' => 'Datenblaetter',
		'handbuch' => 'Betriebsanleitungen',
		'otherdoc' => 'Andere Dokumente'
	),
	'english' => array (
		'siehe_auch' => 'see also',
		'datasheet' => 'Datasheets',
		'handbuch' => 'Manuals',
		'otherdoc' => 'Other documents'
	),
	'fran�ais' => array (
		'siehe_auch' => 'voir aussi',
		'datasheet' => 'Datasheets',
		'handbuch' => 'Manuals',
		'otherdoc' => 'Other documents'
	)
);
$DefaultLanguage= 'deutsch';
$FoundDocuments= array();
require_once dirname(__FILE__) . '/Include/FunctionsMain.php';
/** **/
require_once dirname(__FILE__) . '/Include/FunctionsAboutUs.php';
require_once dirname(__FILE__) . '/Include/AboutUs.php';
require_once dirname(__FILE__) . '/Include/FunctionsCategories.php';
require_once dirname(__FILE__) . '/Include/Categories.php';
require_once dirname(__FILE__) . '/Include/FunctionsContacts.php';
require_once dirname(__FILE__) . '/Include/Contacts.php';
require_once dirname(__FILE__) . '/Include/FunctionsNews.php';
require_once dirname(__FILE__) . '/Include/News.php';
require_once dirname(__FILE__) . '/Include/FunctionsMenu.php';
require_once dirname(__FILE__) . '/Include/Menu.php';
require_once dirname(__FILE__) . '/Include/FunctionsProducts.php';
require_once dirname(__FILE__) . '/Include/Products.php';
require_once dirname(__FILE__) . '/Include/FunctionsProductsDocuments.php';
require_once dirname(__FILE__) . '/Include/ProductsDocuments.php';
echo "The end";
?>