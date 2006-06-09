<?php
echo 'Preparing categories...<br>';
flush();
foreach ($AvailableCategories as $Category)
{
	if (!CheckCategoryId($Category['id']))
	{
		die('E id');
	}
	if (!CheckCategoryPosition($Category['position']))
	{
		die('E position');
	}
	if (!CheckCategoryHtmldataName($Category['htmldata']['name']))
	{
		die('E htmldata name');
	}
	$CategoriesPrepared[$Category['position']]= $Category;
}
ksort($CategoriesPrepared);
?>