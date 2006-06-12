<?php

	/**
	* SmartTemplate Extension config
	* Print Content of Configuration Parameters
	*
	* Usage Example:
	* Content:  $_CONFIG['webmaster']  =  'philipp@criegern.com';
	* Template: Please Contact Webmaster: {config:"webmaster"}
	* Result:   Please Contact Webmaster: philipp@criegern.com
	*
	* @author Philipp v. Criegern philipp@criegern.com
	*/
	function stedisplayFileInHTML ( $directory, $file )
	{
		if ( file_exists ( $directory . "/" . $file ) )
		{
			return highlight_file ( $directory . "/" . $file, 1 ); 
		} else {
			return "File does not exist $directory, $file";
		}
	}

?>