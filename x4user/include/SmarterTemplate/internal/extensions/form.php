<?php

	function steForm ( $formType, $formname, $defaultValue, $currentValue = "", $options = false, $useOptionkeyAsValue = false )
	{
		$currentValue	= ( $currentValue == "" ) ? $defaultValue : $currentValue;
		switch ( strtolower ( $formType ) )
		{
			case 'text' :
			{
				return "<input type=\"text\" name=\"$formname\" value=\"$currentValue\">";
			}
			case 'password' :
			{
				return "<input type=\"password\" name=\"$formname\" value=\"$currentValue\">";
			}
			case 'checkbox' :
			{
				return "<input type=\"checkbox\" name=\"$formname\" value=\"$currentValue\">";
			}
			case 'radio' :
			{
				return "<input type=\"radio\" name=\"$formname\" value=\"$currentValue\">";
			}
			case 'submit' :
			{
				return "<input type=\"submit\" name=\"$formname\" value=\"$currentValue\">";
			}
			case 'reset' :
			{
				return "<input type=\"reset\" name=\"$formname\" value=\"$currentValue\">";
			}
			case 'file' :
			{
				return "<input type=\"file\" name=\"$formname\">";
			}
			case 'hidden' :
			{
				return "<input type=\"hidden\" name=\"$formname\" value=\"$currentValue\">";
			}
			case 'image' :
			{
				return "<input type=\"image\" name=\"$formname\" src=\"$currentValue\">";
			}
			case 'button' :
			{
				return "<input type=\"button\" name=\"$formname\" value=\"$currentValue\">";
			}
			case 'select' :
			{
				$return		= "<select name\"$formname\">";
				if ( $useOptionkeyAsValue === true )
				{
					foreach ( $options as $optionkey => $optionvalue )
					{
						$return .= "<option value=\"$optionkey\">$optionvalue</option>";
					}
				} else {
					foreach ( $options as $optionkey => $optionvalue )
					{
						$return .= "<option value=\"$optionkey\">$optionvalue</option>";
					}
				}
				$return .= "</select>";
				return $return;
			}
			case 'form' :
			{
				if ( $defaultValue === 'upload' )
				{
					$defaultValue	= "enctype=\"multipart/form-data\"";
				} else {
					$defaultValue	= "";
				}
				return "<form name=\"$formname\" $defaultValue action=\"$currentValue\" >";
			}
			case default :
			{
				return "";
			}
		}
	}
	
?>