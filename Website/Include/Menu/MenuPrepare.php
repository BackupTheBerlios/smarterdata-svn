<?php
echo 'Preparing menu...<br>';
flush();
foreach ($UsedLanguages as $Language)
{
	$MenuPrepared[$Language]['categories']= implode('', file(dirname(__FILE__) . '/../../Output/Categories/_menu_categories_' . $Language . '.html'));
	$MenuPrepared[$Language]['newsmenu']= implode('', file(dirname(__FILE__) . '/../../Output/Newsmenu/_newsmenu_' . $Language . '.html'));
}
?>