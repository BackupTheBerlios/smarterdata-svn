<?php
echo 'Prepare contacts...<br>';
flush();
ksort($AvailableContacts);
foreach($AvailableContacts as $Contact)
{
	if(!CheckContactTitle($Contact['title']))
	{
		die('E CheckContactTitle');
	}
	if(!CheckContactName($Contact['name']))
	{
		die('E CheckContactName');
	}
	if(!CheckContactStreet($Contact['street']))
	{
		die('E CheckContactStreet');
	}
	if(!CheckContactCountry($Contact['country']))
	{
		die('E CheckContactCountry');
	}
	if(!CheckContactCitycode($Contact['citycode']))
	{
		die('E CheckContactCitycode');
	}
	if(!CheckContactCity($Contact['city']))
	{
		die('E CheckContactCity');
	}
	if(!CheckContactPrenumber($Contact['prenumber']))
	{
		die('E CheckContactPrenumber');
	}
	if(!CheckContactNumber($Contact['number']))
	{
		die('E CheckContactNumber');
	}
	if(!CheckContactFax($Contact['fax']))
	{
		die('E CheckContactFax');
	}
	if(!CheckContactEmail($Contact['email']))
	{
		die('E CheckContactEmail');
	}
	$ContactsPrepared[] = $Contact;
}
echo '<pre>'.print_r($ContactsPrepared, 1).'</pre>';
?>