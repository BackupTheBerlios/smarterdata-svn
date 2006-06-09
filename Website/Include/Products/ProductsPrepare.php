<?php
echo 'Preparing products...<br>';
flush();
foreach ($AvailableProducts as $ProductKey => $Product)
{
	if (!CheckProductId($Product['id']))
	{
		die('E id');
	}
	if (!CheckProductDate($Product['date']))
	{
		die('E date');
	}
	if (!CheckProductCategory($Product['category']))
	{
		die('E category');
	}
	if (!CheckProductPosition($Product['position']))
	{
		die('E position');
	}
	if (!CheckProductIcon($Product['icon']))
	{
		die('E icon');
	}
	if (!CheckProductImage($Product['image']))
	{
		die('E image');
	}
	if (!CheckProductName($Product['name']))
	{
		die('E name');
	}
	if (!CheckProductHeadline($Product['headline']))
	{
		die('E headline');
	}
	if (!CheckProductDescription($Product['description']))
	{
		die('E description');
	}
	if (isset ($Product['linkto']))
	{
		if (!CheckProductLinktoProduct($Product['linkto']))
		{
			die('E linkto');
		}
	}
	if (isset ($Product['datasheet']))
	{
		if (!CheckProductDatasheet($Product['datasheet']))
		{
			die('E datasheet');
		}
	}
	if (isset ($Product['manual']))
	{
		if (!CheckProductManual($Product['manual']))
		{
			die('E Otherdoc');
		}
	}
	if (isset ($Product['conformity']))
	{
		if (!CheckProductConformity($Product['conformity']))
		{
			die('E Otherdoc');
		}
	}
	if (isset ($Product['otherdoc']))
	{
		if (!CheckProductOtherdoc($Product['otherdoc']))
		{
			die('E Otherdoc');
		}
	}
	$Category1= substr($Product['category'], 0, 2);
	$Category2= substr($Product['category'], 3, 2);
	$Category3= substr($Product['category'], 6, 2);
	$ProductsPrepared[$Category1][$Category2][$Category3][$Product['position']][$Product['id']][]= $Product;
	ksort($ProductsPrepared);
	ksort($ProductsPrepared[$Category1]);
	ksort($ProductsPrepared[$Category1][$Category2]);
	ksort($ProductsPrepared[$Category1][$Category2][$Category3]);
	ksort($ProductsPrepared[$Category1][$Category2][$Category3][$Product['position']]);
	ksort($ProductsPrepared[$Category1][$Category2][$Category3][$Product['position']][$Product['id']]);
	$AvailableProducts[$ProductKey] = $Product;
}
?>