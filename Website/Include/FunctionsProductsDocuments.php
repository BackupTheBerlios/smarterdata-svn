<?php
function GenerateProductsDocuments($Documents)
{
	global $UsedLanguages;
	foreach ($UsedLanguages as $Language)
	{
		$NewItems= array ();
		$Tpl= new smartertemplate(dirname(__FILE__) . '/../Input/Templates/ProductsDocuments.html');
		$Tpl->Assign('documents', $Documents[$Language]['manual']);
		$Pageresult= $Tpl->Result();
		$Fh= fopen(dirname(__FILE__) . '/../Output/ProductsDocuments/_products_documents_manual_' . $Language . '.html', 'w');
		fputs($Fh, $Pageresult);
		fclose($Fh);
		$Tpl->Assign('documents', $Documents[$Language]['conformity']);
		$Pageresult= $Tpl->Result();
		$Fh= fopen(dirname(__FILE__) . '/../Output/ProductsDocuments/_products_documents_conformity_' . $Language . '.html', 'w');
		fputs($Fh, $Pageresult);
		fclose($Fh);

		$Tpl->Assign('documents', $Documents[$Language]['otherdoc']);
		$Pageresult= $Tpl->Result();
		$Fh= fopen(dirname(__FILE__) . '/../Output/ProductsDocuments/_products_documents_otherdoc_' . $Language . '.html', 'w');
		fputs($Fh, $Pageresult);
		fclose($Fh);
	}
}
?>