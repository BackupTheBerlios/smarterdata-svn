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
	* @author Philipp v. Criegern philipp@criegern.de
	*/
	function smarttemplate_extension_htmlentities ( $param, $doHtml = true, $doBr = true )
	{
		$return		= $param;
		$found		= false;
		while ( preg_match ( '|\[html\](.*?)\[\/html\]|ims', $return, $result ) )
		{
			$found		= true;
			$return		= str_replace (
				'[html]' . $result[1] . '[/html]', htmlentities ( $result[1] ), $return );
		}
		if ( $found === false )
		{
			if ( $doHtml === true )
			{
				$return		= htmlentities( $return );
			}
			if ( $doBr === true )
			{
				$return = nl2br ( $return );
			}
		}
		$return		= str_replace ( '[img]', '<img src="', $return );
		$return		= str_replace ( '[/img]', '" border="0">', $return );
		$return		= str_replace ( '[p]', '<p>', $return );
		$return		= str_replace ( '[/p]', '</p>', $return );
		$return		= str_replace ( '[br]', '<br/>', $return );
		return $return;
	}

?>