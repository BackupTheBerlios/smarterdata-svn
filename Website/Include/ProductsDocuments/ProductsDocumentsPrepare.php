<?php
echo 'Preparing productsdocuments...<br>';
flush();
$ProductsDocumentsPrepared= array ();
foreach ($UsedLanguages as $Language)
{
	ksort($AvailableProductsDocuments['manuals'][$Language]);
	foreach ($AvailableProductsDocuments['manuals'][$Language] as $Name => $Documents)
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
					'path' => 'Documents/Manual/'.$Document['path']
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
					'path' => 'Documents/Conformity/'.$Document['path']
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
					'path' => 'Documents/Otherdoc/'.$Document['path']
				);
			}
		}
	}
}
?>