<?php

	/**
	* SmartTemplate Extension config
	* Print Content of Configuration Parameters
	*
	* Usage Example:
	* Content:  $_CONFIG['webmaster']  =  'philipp@criegern.de';
	* Template: Please Contact Webmaster: {config:"webmaster"}
	* Result:   Please Contact Webmaster: philipp@criegern.de
	*
	* @author Philipp v. Criegern philipp@criegern.de
	*/
	function smarttemplate_extension_genlist ( $param )
	{
		$listitems	= explode ( "\n", $param );
		foreach ( $listitems as $listitem )
		{
			if ( trim ( $listitem ) > "" )
			{
				$return		.= '<li>' . nl2br ( htmlentities ( trim ( $listitem ) ) ) . '</li>';
			}
		}
		if ( $return > "" )
		{
			$return		= "<ul>$return</ul>";
		} else {
			$return		= "";
		}
		return $return;
	}

?>