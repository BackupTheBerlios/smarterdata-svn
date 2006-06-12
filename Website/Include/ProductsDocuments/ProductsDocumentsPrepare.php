<?php
echo 'Preparing productsdocuments...<br>';
flush();
$ProductsDocumentsPrepared= array ();
foreach ($UsedLanguages as $Language)
{
	ksort($AvailableProductsDocuments['manual'][$Language]);
	foreach ($AvailableProductsDocuments['manual'][$Language] as $Name => $Documents)
	{
		foreach ($Documents as $Document)
		{
			$Found= false;
			foreach ($ProductsDocumentsPrepared[$Language]['manual'] as $DocumentOld)
			{
				if ($DocumentOld['path'] == $Document['path'] && $Name == $DocumentOld['name'])
				{
					$Found= true;
				}
			}
			if ($Found === false)
			{
				$ProductsDocumentsPrepared[$Language]['manual'][]= array (
					'name' => $Name,
					'description' => $Document['name'],
					'path' => $Document['path']
				);
			}
		}
	}
	foreach ($AvailableProductsDocuments['conformity'][$Language] as $Name => $Documents)
	{
		foreach ($Documents as $Document)
		{
			$Found= false;
			foreach ($ProductsDocumentsPrepared[$Language]['conformity'] as $DocumentOld)
			{
				if ($DocumentOld['path'] == $Document['path'] && $Name == $DocumentOld['name'])
				{
					$Found= true;
				}
			}
			if ($Found === false)
			{
				$ProductsDocumentsPrepared[$Language]['conformity'][]= array (
					'name' => $Name,
					'description' => $Document['name'],
					'path' => $Document['path']
				);
			}
		}
	}
	foreach ($AvailableProductsDocuments['otherdoc'][$Language] as $Name => $Documents)
	{
		foreach ($Documents as $Document)
		{
			$Found= false;
			foreach ($ProductsDocumentsPrepared[$Language]['otherdoc'] as $DocumentOld)
			{
				if ($DocumentOld['path'] == $Document['path'] && $Name == $DocumentOld['name'])
				{
					$Found= true;
				}
			}
			if ($Found === false)
			{
				$ProductsDocumentsPrepared[$Language]['otherdoc'][]= array (
					'name' => $Name,
					'description' => $Document['name'],
					'path' => $Document['path']
				);
			}
		}
	}
}
?>