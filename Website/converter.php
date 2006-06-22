<?php
require_once 'Config.php';
$Directory= dirname(__FILE__) . '/Input/ProductsOld';
$Dir= dir($Directory);
while ($Value= $Dir->Read())
{
	if (preg_match('/\.new\.xml$/', $Value))
	{
		continue;
	}
	if (preg_match('/\.xml$/', $Value))
	{
		$Product= array ();
		$ProductXml= new Config;
		$Temp= & $ProductXml->ParseConfig($Directory . '/' . $Value, 'XML');
		$Temp= $Temp->toArray();
		$Temp= $Temp['root']['products']['product'];
		$Product['item']['id']= $Temp['id'];
		$Product['item']['date']= '2006-01-01';
		$Product['item']['category']= substr($Temp['category']['de'], 0, 8);
		$Product['item']['position']= 1;
		$Product['item']['icon']['deutsch']= $Temp['imagesmall'];
		$Product['item']['icon']['english']= $Temp['imagesmall'];
		$Product['item']['icon']['french']= $Temp['imagesmall'];
		$Product['item']['image']['deutsch']= $Temp['imagebig'];
		$Product['item']['image']['english']= $Temp['imagebig'];
		$Product['item']['image']['french']= $Temp['imagebig'];
		$Product['item']['name']['deutsch']= $Temp['product'];
		$Product['item']['name']['english']= $Temp['product'];
		$Product['item']['name']['french']= $Temp['product'];
		$Product['item']['headline']['deutsch']= $Temp['headline']['de'];
		$Product['item']['headline']['english']= $Temp['headline']['en'];
		$Product['item']['headline']['french']= $Temp['headline']['fr'];
		$Product['item']['description']['deutsch']= $Temp['text']['de'];
		$Product['item']['description']['english']= $Temp['text']['en'];
		$Product['item']['description']['french']= $Temp['text']['fr'];
		if(isset($Temp['document']['de']))
		{
			$Temp['document'] = array($Temp['document']);
		}
		if (isset ($Temp['document']) && is_array($Temp['document']))
		{
			foreach ($Temp['document'] as $Document)
			{
				$Doc['deutsch']['name']= $Document['de']['name'];
				$Doc['deutsch']['path']= $Document['de']['link'];
				$Doc['english']['name']= $Document['en']['name'];
				$Doc['english']['path']= $Document['en']['link'];
				$Doc['french']['name']= $Document['fr']['name'];
				$Doc['french']['path']= $Document['fr']['link'];
				if(preg_match('/^TestReport/', $Doc['deutsch']['path']))
				{
					$Doc['deutsch']['path'] = 'TestReport/'.substr($Doc['deutsch']['path'], 11);
					$Doc['english']['path'] = 'TestReport/'.substr($Doc['english']['path'], 11);
					$Doc['french']['path'] = 'TestReport/'.substr($Doc['french']['path'], 11);
					$Product['item']['otherdoc'][] = $Doc;
				}
				elseif(preg_match('/^test_report/', $Doc['deutsch']['path']))
				{
					$Doc['deutsch']['path'] = 'TestReport/'.substr($Doc['deutsch']['path'], 12);
					$Doc['english']['path'] = 'TestReport/'.substr($Doc['english']['path'], 12);
					$Doc['french']['path'] = 'TestReport/'.substr($Doc['french']['path'], 12);
					$Product['item']['otherdoc'][] = $Doc;
				}
				elseif(preg_match('/^manuals/', $Doc['deutsch']['path']))
				{
					$Doc['deutsch']['path'] = substr($Doc['deutsch']['path'], 8);
					$Doc['english']['path'] = substr($Doc['english']['path'], 8);
					$Doc['french']['path'] = substr($Doc['french']['path'], 8);
					$Product['item']['manual'][] = $Doc;
				}
				elseif(preg_match('/^products/', $Doc['deutsch']['path']))
				{
					$Doc['deutsch']['path'] = substr($Doc['deutsch']['path'], 9);
					$Doc['english']['path'] = substr($Doc['english']['path'], 9);
					$Doc['french']['path'] = substr($Doc['french']['path'], 9);
					$Product['item']['datasheet'][] = $Doc;
				}
				else
				{
					$Product['item']['otherdoc'][] = $Doc;
				}
			}
		}
		unset($ProductXml);
		$ProductXml= new Config;
		$Root= & $ProductXml->ParseConfig($Product, 'PHPArray');
		if(preg_match('/-([0-9]{2})-([0-9]{2})-([0-9]{2})$/', $Product['item']['id']))
		{
			$Filename = $Product['item']['id'].'.xml';
		}
		else
		{
			$Filename = $Product['item']['id'].'-'.$Product['item']['category'].'.xml';
		}
#		if(file_exists(dirname(__FILE__) . '/Input/Products/' . $Filename))
#		{
#			echo 'File exist: '.$Filename.'<br>';
#		}
#		else
#		{
			$Root->writeDatasrc(dirname(__FILE__) . '/Input/Products/' . $Filename, 'XML');
#		}
		unset($Product, $ProductXml, $Temp);
		#echo '<pre>' . print_r($Product, 1) . '</pre>';
	}
}
?>