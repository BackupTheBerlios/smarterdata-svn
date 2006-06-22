<?php
function CheckProductId(& $Check)
{
	if (is_array($Check))
	{
		echo 'Id is an array';
		return false;
	}
	return true;
}
function CheckProductDate(& $Check)
{
	if (is_array($Check))
	{
		echo 'DATE is an array';
		return false;
	}
	if (!preg_match('/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/', $Check))
	{
		echo 'wrong DATE format (yyyy-mm-dd)';
		return false;
	}
	return true;
}
function CheckProductCategory(& $Check)
{
	if (is_array($Check))
	{
		echo 'CATEGORY is an array';
		return false;
	}
	if (!preg_match('/^([0-9]{2})-([0-9]{2})-([0-9]{2})$/', $Check))
	{
		echo 'wrong CATEGORY format (nn-nn-nn)';
		return false;
	}
	return true;
}
function CheckProductPosition(& $Check)
{
	if (is_array($Check))
	{
		echo 'POSITION is an array';
		return false;
	}
	if (!is_numeric($Check))
	{
		echo 'POSITION is not a number';
		return false;
	}
	return true;
}
function CheckProductName(& $Check)
{
	global $DefaultLanguage, $UsedLanguages;
	if (!is_array($Check))
	{
		echo 'NAME is not an array';
		return false;
	}
	if (!isset ($Check[$DefaultLanguage]))
	{
		echo 'default language for NAME not set';
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
			echo 'NAME unset for ' . $Language;
			return false;
		}
	}
	return true;
}
function CheckProductHeadline(& $Check)
{
	global $DefaultLanguage, $UsedLanguages;
	if (!is_array($Check))
	{
		echo 'HEADLINE is not an array';
		return false;
	}
	if (!isset ($Check[$DefaultLanguage]))
	{
		echo 'default language for HEADLINE not set';
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
			echo 'HEADLINE unset for ' . $Language;
			return false;
		}
	}
	return true;
}
function CheckProductDescription(& $Check)
{
	global $DefaultLanguage, $UsedLanguages;
	if (!is_array($Check))
	{
		echo 'DESCRIPTION is not an array';
		return false;
	}
	if (!isset ($Check[$DefaultLanguage]))
	{
		echo 'default language for DESCRIPTION not set';
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
			echo 'DESCRIPTION unset for ' . $Language;
			return false;
		}
		$Description= explode("\n", $Check[$Language]);
		$Check[$Language]= array ();
		foreach ($Description as $Line)
		{
			$Check[$Language][]['value']= trim($Line) . "\n";
		}
	}
	return true;
}
function CheckProductLinktoProduct(& $Check)
{
	global $AvailableProducts;
	if (!CheckMultiple($Check))
	{
		$Check= array (
			$Check
		);
	}
	foreach ($Check as $Key => $Linkto)
	{
		if (!isset ($AvailableProducts[$Linkto]))
		{
			echo 'LINKTO product does not exist. ' . $Linkto . '.xml';
			return false;
		}
		$Check[$Key]= array (
			'file' => $Linkto,
			'category' => GetProductsCategory($Linkto
		));
	}
	return true;
}
function CheckProductIcon(& $Check)
{
	global $DefaultLanguage, $UsedLanguages;
	if (!is_array($Check))
	{
		echo 'ICON is not an array';
		return false;
	}
	if (!isset ($Check[$DefaultLanguage]))
	{
		echo 'default language for ICON not set';
		return false;
	}
	foreach ($UsedLanguages as $Language)
	{
		if (!isset ($Check[$Language]))
		{
			$Check[$Language]= $Check[$DefaultLanguage];
		}
		if (!file_exists(dirname(__FILE__) . '/../site_html/Images/' . $Check[$Language]))
		{
			echo 'ICON does not exist. ' . $Check[$Language];
			return false;
		}
	}
	return true;
}
function CheckProductImage(& $Check)
{
	global $DefaultLanguage, $UsedLanguages;
	if (!is_array($Check))
	{
		echo 'IMAGE is not an array';
		return false;
	}
	if (!isset ($Check[$DefaultLanguage]))
	{
		echo 'Default language for IMAGE not set';
		return false;
	}
	foreach ($UsedLanguages as $Language)
	{
		if (!isset ($Check[$Language]))
		{
			$Check[$Language]= $Check[$DefaultLanguage];
		}
		if (!file_exists(dirname(__FILE__) . '/../site_html/Images/' . $Check[$Language]))
		{
			echo 'IMAGE does not exist. ' . $Check[$Language];
			return false;
		}
	}
	return true;
}
function CheckProductDatasheet(& $Check)
{
	global $DefaultLanguage, $UsedLanguages;
	if (!CheckMultiple($Check))
	{
		$Check= array (
			$Check
		);
	}
	foreach ($Check as $DocumentKey => $Document)
	{
		if (!isset ($Document[$DefaultLanguage]))
		{
			echo 'default language for DATASHEET not set';
			return false;
		}
		foreach ($UsedLanguages as $Language)
		{
			if (!isset ($Document[$Language]))
			{
				$Document[$Language]= $Document[$DefaultLanguage];
			}
			if (!CheckDocument($Document[$Language], 'Datasheet'))
			{
				echo 'DATASHEET does not exist. ' . $Document[$Language]['path'];
				return false;
			}
		}
		$Check[$DocumentKey]= $Document;
	}
	return true;
}
function CheckProductManual(& $Check)
{
	global $DefaultLanguage, $UsedLanguages;
	if (!CheckMultiple($Check))
	{
		$Check= array (
			$Check
		);
	}
	foreach ($Check as $DocumentKey => $Document)
	{
		if (!isset ($Document[$DefaultLanguage]))
		{
			echo 'default language for MANUAL not set';
			return false;
		}
		foreach ($UsedLanguages as $Language)
		{
			if (!isset ($Document[$Language]))
			{
				$Document[$Language]= $Document[$DefaultLanguage];
			}
			if (!CheckDocument($Document[$Language], 'Manual'))
			{
				echo 'MANUAL does not exist. ' . $Document[$Language]['path'];
				return false;
			}
		}
		$Check[$DocumentKey]= $Document;
	}
	return true;
}
function CheckProductConformity(& $Check)
{
	global $DefaultLanguage, $UsedLanguages;
	if (!CheckMultiple($Check))
	{
		$Check= array (
			$Check
		);
	}
	foreach ($Check as $DocumentKey => $Document)
	{
		if (!isset ($Document[$DefaultLanguage]))
		{
			echo 'default language for CONFORMITY not set';
			return false;
		}
		foreach ($UsedLanguages as $Language)
		{
			if (!isset ($Document[$Language]))
			{
				$Document[$Language]= $Document[$DefaultLanguage];
			}
			if (!CheckDocument($Document[$Language], 'Conformity'))
			{
				echo 'CONFORMITY does not exist. ' . $Document[$Language]['path'];
				return false;
			}
		}
		$Check[$DocumentKey]= $Document;
	}
	return true;
}
function CheckProductOtherdoc(& $Check)
{
	global $DefaultLanguage, $UsedLanguages;
	if (!CheckMultiple($Check))
	{
		$Check= array (
			$Check
		);
	}
	foreach ($Check as $DocumentKey => $Document)
	{
		if (!isset ($Document[$DefaultLanguage]))
		{
			echo 'default language for OTHERDOC not set';
			return false;
		}
		foreach ($UsedLanguages as $Language)
		{
			if (!isset ($Document[$Language]))
			{
				$Document[$Language]= $Document[$DefaultLanguage];
			}
			if (!CheckDocument($Document[$Language], 'Otherdoc'))
			{
				echo 'OTHERDOC does not exist. ' . $Document[$Language]['path'];
				return false;
			}
		}
		$Check[$DocumentKey]= $Document;
	}
	return true;
}
function GetProductsCategory($LinkTo)
{
	global $AvailableProducts;
	$Category= substr($AvailableProducts[$LinkTo]['category'], 0, 2);
	return $Category;
}
function GetProductsName($LinkTo, $Language)
{
	global $AvailableProducts;
	return $AvailableProducts[$LinkTo]['name'][$Language];
}
function GetProductsHash($LinkTo, $Language)
{
	global $AvailableProducts;
	$Hash= $AvailableProducts[$LinkTo]['id'] . $AvailableProducts[$LinkTo]['category'] . $AvailableProducts[$LinkTo]['name'][$Language];
	$Hash= sha1($Hash);
	return $Hash;
}
function GenerateProductsites($Products)
{
	$AllItems= array ();
	foreach ($Products as $Category => $CategoriesProducts)
	{
		$CatchedItems= array ();
		foreach ($CategoriesProducts as $Category2 => $CategoriesProducts2)
		{
			foreach ($CategoriesProducts2 as $Category3 => $CategoriesProducts3)
			{
				foreach ($CategoriesProducts3 as $Position => $Items)
				{
					foreach ($Items as $ProductKey => $ProductValues)
					{
						foreach ($ProductValues as $Item)
						{
							$CatchedItems[]= $Item;
							$AllItems[]= $Item;
						}
					}
				}
			}
		}
		GenerateProductOverview($CatchedItems, $Category);
	}
	GenerateProductAll($AllItems);
}
function GenerateProductOverview($Items, $Category)
{
	global $UsedLanguages;
	foreach ($UsedLanguages as $Language)
	{
		$NewItems= array ();
		foreach ($Items as $Product)
		{
			$NewItems[]= PrepareProductArray($Product, $Language);
		}
		$Tpl= new smartertemplate(dirname(__FILE__) . '/../Input/Templates/ProductOverview.html');
		$Tpl->Assign('products', $NewItems);
		$Pageresult= $Tpl->Result();
		$Fh= fopen(dirname(__FILE__) . '/../Output/Products/_category_' . $Category . '_' . $Language . '.html', 'w');
		fputs($Fh, $Pageresult);
		fclose($Fh);
	}
}
function GenerateProductAll($AllItems)
{
	global $UsedLanguages;
	foreach ($UsedLanguages as $Language)
	{
		$NewItems= array ();
		foreach ($AllItems as $Product)
		{
			$TempItem= PrepareProductAllArray($Product, $Language);
			$NewItems[$TempItem['name']]= $TempItem;
		}
		ksort($NewItems);
		$Tpl= new smartertemplate(dirname(__FILE__) . '/../Input/Templates/ProductsAll.html');
		$Tpl->Assign('products', $NewItems);
		$Pageresult= $Tpl->Result();
		$Fh= fopen(dirname(__FILE__) . '/../Output/Products/_products_all_' . $Language . '.html', 'w');
		fputs($Fh, $Pageresult);
		fclose($Fh);
	}
}
function PrepareProductAllArray($Product, $Language)
{
	global $Languagetexts;
	$Tplvar= $Product;
	$Tplvar['language']= $Language;
	$Hash= $Product['id'];
	$Hash .= $Product['category'];
	$Hash .= $Product['name'][$Language];
	$Tplvar['hash']= sha1($Hash);
	$Tplvar['icon']= $Product['icon'][$Language];
	$Tplvar['image']= $Product['image'][$Language];
	$Tplvar['name']= $Product['name'][$Language];
	$Tplvar['headline']= $Product['headline'][$Language];
	$Tplvar['description']= $Product['description'][$Language];
	$Tplvar['langtext']= $Languagetexts[$Language];
	$Tplvar['linkToProduct']= '_category_' . substr($Tplvar['category'], 0, 2) . '_' . $Language . '.html#' . $Tplvar['hash'];
	return $Tplvar;
}
function PrepareProductArray($Product, $Language)
{
	global $Languagetexts;
	$Tplvar= $Product;
	$Tplvar['language']= $Language;
	if (isset ($Product['linkto']))
	{
		$Tplvar['linkto']= array ();
		foreach ($Product['linkto'] as $Linkto)
		{
			$Tplvar['linkto'][]= array (
				'name' => GetProductsName($Linkto['file'],
				$Language
			), 'category' => $Linkto['category'], 'link' => '_category_' . $Linkto['category'] . '_' . $Language . '.html#' . GetProductsHash($Linkto['file'], $Language));
		}
	}
	else
	{
		$Tplvar['linkto']= '';
	}
	$Hash= $Product['id'];
	$Hash .= $Product['category'];
	$Hash .= $Product['name'][$Language];
	$Tplvar['hash']= sha1($Hash);
	$Tplvar['icon']= $Product['icon'][$Language];
	$Tplvar['image']= $Product['image'][$Language];
	$Tplvar['name']= $Product['name'][$Language];
	$Tplvar['headline']= $Product['headline'][$Language];
	$Tplvar['description']= $Product['description'][$Language];
	unset ($Tplvar['datasheet']);
	if (isset ($Product['datasheet']))
	{
		foreach ($Product['datasheet'] as $Document)
		{
			$Tplvar['datasheet'][]= $Document[$Language];
		}
	}
	unset ($Tplvar['manual']);
	if (isset ($Product['manual']))
	{
		foreach ($Product['manual'] as $Document)
		{
			$Tplvar['manual'][]= $Document[$Language];
		}
	}
	unset ($Tplvar['otherdoc']);
	if (isset ($Product['otherdoc']))
	{
		foreach ($Product['otherdoc'] as $Document)
		{
			$Tplvar['otherdoc'][]= $Document[$Language];
		}
	}
	unset ($Tplvar['conformity']);
	if (isset ($Product['conformity']))
	{
		foreach ($Product['conformity'] as $Document)
		{
			$Tplvar['conformity'][]= $Document[$Language];
		}
	}
	unset ($Tplvar['news']);
	if (isset ($Product['news']))
	{
		foreach ($Product['news'] as $Document)
		{
			$Tplvar['news'][]= $Document[$Language];
		}
	}
	$Tplvar['langtext']= $Languagetexts[$Language];
	return $Tplvar;
}
?>