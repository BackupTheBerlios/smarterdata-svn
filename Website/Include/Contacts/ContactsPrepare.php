<?php
echo 'Prepare contacts...<br>';
flush();
ksort($AvailableContacts);
foreach($AvailableContacts as $Contact)
{
	if(!CheckContactTitle($Contact['title']))
	{
		die(
	}
	if(!CheckContactName($Contact['name']))
	{
	}
	if(!CheckContactStreet($Contact['street']))
	{
	}
	if(!CheckContactCountry($Contact['country']))
	{
	}
	if(!CheckContactCitycode($Contact['citycode']))
	{
	}
	if(!CheckContactCity($Contact['city']))
	{
	}
	if(!CheckContactPrenumber($Contact['prenumber']))
	{
	}
	if(!CheckContactNumber($Contact['number']))
	{
	}
	if(!CheckContactFax($Contact['fax']))
	{
	}
	if(!CheckContactEmail($Contact['email']))
	{
	}
	$ContactsPrepared[] = $Contact;
}
echo '<pre>'.print_r($ContactsPrepared, 1).'</pre>';
?>