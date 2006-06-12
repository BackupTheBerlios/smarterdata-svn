<?php
echo 'Preparing aboutus...<br>';
flush();
foreach ($AvailableAboutUs as $AboutUs)
{
	if (!CheckAboutUsId($AboutUs['id']))
	{
		die('E id');
	}
	if (!CheckAboutUsImage($AboutUs['image']))
	{
		die('E image');
	}
	if (!CheckAboutUsContent($AboutUs['content']))
	{
		die('E content');
	}
	$AboutUsPrepared[$AboutUs['id']]= $AboutUs;
}
?>