<?php
echo 'Prepare headers...<br>';
flush();
ksort($AvailableHeader);
foreach($AvailableHeader as $Header)
{
	if(!CheckHeaderImage($Header['image']))
	{
		die('E CheckHeaderImage');
	}
	if(isset($Header['linkto']))
	{
		if(!CheckHeaderLinkto($Header['linkto']))
		{
			die('E CheckHeaderLinkto');
		}
	}
	$HeaderPrepared[] = $Header;
}
?>