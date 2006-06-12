<?php

	/**
	* SmartTemplate Extension htmlentities
	* Converts Special Characters to HTML Entities
	*
	* Usage Example:
	* Content:  $template->assign('NEXT', 'Next Page >>');
	* Template: <a href="next.php">{htmlentities:NEXT}</a>
	* Result:   <a href="next.php">Next Page &gt;&gt;</a>
	*
	* @author Philipp v. Criegern philipp@criegern.com
	*/
	function stehtmlentities ( $param, $noNl = false )
	{
		$return		= str_replace ( "[br]", "\n", $param );
		$return		= htmlentities ( $return );
		if ( $noNl === false )
		{
			$return	= nl2br ( $return );
		}
		return trim ( $return );
	}

?>