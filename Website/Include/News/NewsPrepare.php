<?php
echo 'Preparing news...<br>';
flush();
foreach ($AvailableNews as $News)
{
	if (!CheckNewsDate($News['date']))
	{
		die($File . ' date error');
	}
	if (!CheckNewsIcon($News['icon']))
	{
		die($File . ' icon error');
	}
	if (!CheckNewsHeadline($News['headline']))
	{
		die($File . ' headline error');
	}
	if (!CheckNewsDescription($News['description']))
	{
		die($File . ' icon error');
	}
	if (!CheckNewsInMenu($News['inmenu'], $News['headline']))
	{
		die($File . ' inmenu error');
	}
	if (!CheckNewsDoc($News['newsdoc']))
	{
		die($File . ' image error');
	}
	$NewsPrepared[$News['date']][]= $News;
}
?>