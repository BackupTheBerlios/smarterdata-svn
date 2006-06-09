<?php

	/**
	* SmartTemplate Extension load_file
	* Print out file content
	*
	* Usage Example:
	* External Content Source (counter.txt):
	*
	*     1234
	*
	* Template:
	*
	*     You are visitor No: {load_file:"counter.txt"}
	*
	* Result:
	*
	*     You are visitor No: 1234
	*
	* @author Philipp v. Criegern philipp@criegern.com
	*/
	function steload_file ( $filename )
	{
		if (is_file($filename))
		{
			if($hd = @fopen($filename, "r")) 
			{
				$content  =  fread($hd, filesize($filename));
				fclose($hd);
				return $content;
			}
		}
	}

?>