<?php

	function steDecode ( $decodeType, $encodedString )
	{
		switch ( strtolower ( $decodeType ) )
		{
			case 'base64' :
			{
				return base64_decode ( $encodedString );
			}
			case 'rawurl' :
			{
				return rawurldecode ( $encodedString );
			}
			case 'url' :
			{
				return urldecode ( $encodedString );
			}
			case 'utf8' :
			{
				return utf8_decode ( $encodedString );
			}
			case 'html' :
			{
				return html_entity_decode ( $encodedString );
			}
			case 'htmlnl' :
			{
				return html_entity_decode ( preg_replace ( '/(<[\/]{,1}br[\/]{,1}>)/', "\n" , $encodedString ) );
			}
			case 'nl' :
			{
				return preg_replace ( '/(<[\/]{0,1}br[\/]{0,1}>)/', "\n" , $encodedString );
			}
			case 'email' :
			{
				return 
					str_replace ( " AT ", "@", 
					str_replace ( " DOT ", ".",
					str_replace ( " UNDERLINE ", "_",
					str_replace (  " MINUS ", "-",
						$encodedString
					) ) ) 
				);
			}
			default :
			{
				return "Encoding does not support type $decodeType<br>";
			}
		} 
	}

?>