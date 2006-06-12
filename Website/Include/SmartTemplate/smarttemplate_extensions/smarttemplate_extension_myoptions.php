<?php

	function smarttemplate_extension_myoptions ( $param,  $default = '_DEFAULT_' )
	{
		$output  =  "";
		foreach ($param as $value)
		{
			$output .= "<option value=\"" . $param['id'] . "\" ";
			if ( $value['id'] == $default )
			{
				$output .= " SELECTED ";
			}
			$output .= " >" . $param['value'] . "</option>";
		}
		return $output;
	}

?>