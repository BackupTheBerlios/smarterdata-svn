<?php
require_once 'Config.php';
require_once dirname(__FILE__) . '/Include/SmarterTemplate/class.smartertemplate.php';
/**
 * Sprachen laden
 */
require_once dirname(__FILE__) . '/Include/Languagetexts.php';
require_once dirname(__FILE__) . '/Include/PrepareLanguagetexts.php';
$FoundDocuments= array ();
require_once dirname(__FILE__) . '/Include/FunctionsMain.php';
/**
 * AboutUs erstellen
 */
require_once dirname(__FILE__) . '/Include/FunctionsAboutUs.php';
require_once dirname(__FILE__) . '/Include/AboutUs.php';
/**
 * Categories erstellen (Produktkategorieen)
 */
require_once dirname(__FILE__) . '/Include/FunctionsCategories.php';
require_once dirname(__FILE__) . '/Include/Categories.php';
/**
 * Contacts erstellen
 */
require_once dirname(__FILE__) . '/Include/FunctionsContacts.php';
require_once dirname(__FILE__) . '/Include/Contacts.php';
/**
 * Header erstellen
 */
require_once dirname(__FILE__) . '/Include/FunctionsHeader.php';
require_once dirname(__FILE__) . '/Include/Header.php';
/**
 * Impressum erstellen
 */
require_once dirname(__FILE__) . '/Include/FunctionsImpressum.php';
require_once dirname(__FILE__) . '/Include/Impressum.php';
/**
 * News erstellen
 */
require_once dirname(__FILE__) . '/Include/FunctionsNews.php';
require_once dirname(__FILE__) . '/Include/News.php';
/**
 * Products erstellen
 */
require_once dirname(__FILE__) . '/Include/FunctionsProducts.php';
require_once dirname(__FILE__) . '/Include/Products.php';
/**
 * Products Documents erstellen
 * abhaengig von Products
 */
require_once dirname(__FILE__) . '/Include/FunctionsProductsDocuments.php';
require_once dirname(__FILE__) . '/Include/ProductsDocuments.php';
/**
 * Menue erstellen
 */
require_once dirname(__FILE__) . '/Include/FunctionsMenu.php';
require_once dirname(__FILE__) . '/Include/Menu.php';
/**
 * Website bauen
 */
require_once dirname(__FILE__) . '/BuildSite.php';
echo "<hr>Fertig...";
?>