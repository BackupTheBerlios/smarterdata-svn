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
	* @author Philipp v. Criegern philipp@criegern.de
	*/
	function smarttemplate_extension_htmlnewline ( $param )
	{
		return str_replace ( "\n", "<br>", $param );
	}

?>