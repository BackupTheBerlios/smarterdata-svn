<?php
function CheckMultiple($Check)
{
	if (!is_array($Check))
	{
		return false;
	}
	foreach ($Check as $ShouldBeANumber => $Values)
	{
		if (!is_numeric($ShouldBeANumber))
		{
			return false;
		}
	}
	return true;
}
function CheckDocument($Check, $Path)
{
	if (!isset ($Check['name']))
	{
		return false;
	}
	if (!isset ($Check['path']))
	{
		return false;
	}
	if (!file_exists(dirname(__FILE__) . '/../site_html/Documents/' . $Path . '/' . $Check['path']))
	{
		return false;
	}
	return true;
}
?>