<?php

	/**
	* SmartTemplate Extension gettext
	* Translates Text Calls 
	*
	* Usage Example:
	* Template: {gettext:Welcome}
	* Calls:    gettext('Welcome')
	* Result:   Willkommen
	*
	* @author Philipp v. Criegern philipp@criegern.com
	*/
	function stegettext ( $param )
	{
		return gettext( $param );
	}

?>