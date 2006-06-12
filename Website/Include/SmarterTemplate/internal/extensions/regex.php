<?php

	/**
	* SmartTemplate Extension regex
	* Regular Expression String Replace
	*
	* Usage Example:
	* Content:  $template->assign('NAME', '*My Document*');
	* Template: Document Name: {regex:NAME,'/[^a-z0-9]/i','_'}
	* Result:   Document Name: _My_Document_
	*
	* @author Philipp v. Criegern philipp@criegern.com
	*/
	function steregex ( $param, $pattern, $replace )
	{
		return preg_replace( $pattern, $replace, $param );
	}

?>