<?php

	/**
	* SmartTemplate Extension lowercase
	* Converts String to lowercase
	*
	* Usage Example:
	* Content:  $template->assign('NAME', 'John Doe');
	* Template: Username: {lowercase:NAME}
	* Result:   Username: john doe
	*
	* @author Philipp v. Criegern philipp@criegern.com
	*/
	function stelowercase ( $param )
	{
		return strtolower( $param );
	}

?>