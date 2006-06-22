<?php
function steresetheader($currentRow, $maxRows, $newheader)
{
	$currentRow++;
	if ($currentRow > 0)
	{
		if ($currentRow % $maxRows != 0)
			return '';
		else
			return $newheader;
	}
}
?>