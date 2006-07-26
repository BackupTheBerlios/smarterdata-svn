<?php
/**
* SmartTemplate Extension dateformat
* Converts a Timestamp according to a specific dateformat
*
* Usage Example:
* Content:  $template->assign('TIMESTAMP', time());
* Template: Today: {dateformat:TIMESTAMP,'d.m.Y H:i:s'}
* Result:   Today: 16.10.2002 14:49:05
*
* @author Philipp v. Criegern philipp@criegern.com
*/
function stedateformat($param, $format= '')
{
	global $_CONFIG;
	if ($format == '')
	{
		if (!isset ($_CONFIG['date_format']))
		{
			$format= 'd.m.Y, H:i.s';
		}
		else
		{
			$format= $_CONFIG['date_format'];
		}
	}
	return date($format, $param);
}
?>