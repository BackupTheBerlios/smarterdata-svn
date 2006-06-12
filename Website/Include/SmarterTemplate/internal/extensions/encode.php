<?php

	function steEncode ( $encodeType, $decodedString )
	{
		switch ( strtolower ( $encodeType ) )
		{
			case 'base64' :
			{
				return base64_encode ( $decodedString );
			}
			case 'gz' :
			{
				return gzencode ( $decodedString );
			}
			case 'rawurl' :
			{
				return rawurlencode ( $decodedString );
			}
			case 'url' :
			{
				return urlencode ( $decodedString );
			}
			case 'utf8' :
			{
				return utf8_encode ( $decodedString );
			}
			case 'html' :
			{
				return htmlentities ( $decodedString );
			}
			case 'htmlnl' :
			{
				return nl2br ( htmlentities ( $decodedString ) );
			}
			case 'nl' :
			{
				return nl2br ( $decodedString );
			}
			case 'email' :
			{
				return 
					str_replace ( "@", " AT ",
					str_replace ( ".", " DOT ",
					str_replace ( "_", " UNDERLINE ",
					str_replace ( "-", " MINUS ",
						$decodedString
					) ) ) 
				);
			}
			default :
			{
				return "Encoding does not support type $encodeType<br>";
			}
		} 
	}

?>