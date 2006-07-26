<?php

	/**
	* SmartTemplate Extension uppercase
	* Converts String to uppercase
	*
	* Usage Example:
	* Content:  $template->assign('NAME', 'John Doe');
	* Template: Username: {uppercase:NAME}
	* Result:   Username: JOHN DOE
	*
	* @author Philipp v. Criegern philipp@criegern.com
	*/
	function steuppercase ( $param )
	{
		return strtoupper( $param );
	}

?>