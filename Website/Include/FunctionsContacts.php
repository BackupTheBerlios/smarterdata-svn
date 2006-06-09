<?php
function CheckContactTitle(& $Check)
{
	global $DefaultLanguage, $UsedLanguages;
	if (!is_array($Check))
	{
		echo 'contact title is not an array';
		return false;
	}
	if (!isset ($Check[$DefaultLanguage]))
	{
		echo 'default language for contact title not set';
		return false;
	}
	foreach ($UsedLanguages as $Language)
	{
		if (!isset ($Check[$Language]))
		{
			$Check[$Language]= $Check[$DefaultLanguage];
		}
		if (strlen($Check[$Language]) == 0)
		{
			echo 'contact title unset for ' . $Language;
			return false;
		}
	}
	return true;
}
function CheckContactName(& $Check)
{
	if (is_array($Check))
	{
		echo 'Array in contact name';
		return false;
	}
	if (strlen($Check) < 10)
	{
		echo 'contact name too short';
		return false;
	}
	return true;
}
function CheckContactStreet(& $Check)
{
	if (is_array($Check))
	{
		echo 'Array in contact street';
		return false;
	}
	if (strlen($Check) < 10)
	{
		echo 'contact street too short';
		return false;
	}
	return true;
}
function CheckContactCountry(& $Check)
{
	if (is_array($Check))
	{
		echo 'Array in contact Country';
		return false;
	}
	if (strlen($Check) < 1)
	{
		echo 'contact Country too short';
		return false;
	}
	if (strlen($Check) > 3)
	{
		echo 'contact Country too long';
		return false;
	}
	return true;
}
function CheckContactCitycode(& $Check)
{
	if (is_array($Check))
	{
		echo 'Array in contact Citycode';
		return false;
	}
	if (strlen($Check) < 4)
	{
		echo 'contact Citycode too short';
		return false;
	}
	if (strlen($Check) < 7)
	{
		echo 'contact Citycode too long';
		return false;
	}
	if (!is_numeric($Check))
	{
		echo 'contact Citycode not numeric';
		return false;
	}
	return true;
}
function CheckContactCity(& $Check)
{
	if (is_array($Check))
	{
		echo 'Array in contact City';
		return false;
	}
	if (strlen($Check) < 4)
	{
		echo 'contact City too short';
		return false;
	}
	return true;
}
function CheckContactPrenumber(& $Check)
{
	if (is_array($Check))
	{
		echo 'Array in contact Prenumber';
		return false;
	}
	if (strlen($Check) < 4)
	{
		echo 'contact Prenumber too short';
		return false;
	}
	if (strlen($Check) > 6)
	{
		echo 'contact Prenumber too long';
		return false;
	}
	return true;
}
function CheckContactNumber(& $Check)
{
	if (is_array($Check))
	{
		echo 'Array in contact Number';
		return false;
	}
	if (strlen($Check) < 3)
	{
		echo 'contact Number too short';
		return false;
	}
	return true;
}
function CheckContactFax(& $Check)
{
	if (is_array($Check))
	{
		echo 'Array in contact Fax';
		return false;
	}
	if (strlen($Check) < 3)
	{
		echo 'contact Fax too short';
		return false;
	}
	return true;
}
function CheckContactEmail(& $Check)
{
	if (is_array($Check))
	{
		echo 'Array in contact Email';
		return false;
	}
	if (strlen($Check) < 10)
	{
		echo 'contact Email too short';
		return false;
	}
	if (!preg_match('/^([a-zA-Z0-9._-]{1,})@([a-zA-Z0-9._-]{1,})$/', $Check))
	{
		echo 'contact Email bad format: ' . $Check;
		return false;
	}
	return true;
}
?>