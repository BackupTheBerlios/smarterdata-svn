<?php
function smarttemplate_extension_htmlentities($Text, $NoNewline= false)
{
	$Text= str_replace("[br]", "\n", $Text);
	$Text= htmlentities($Text);
	if ($NoNewline === false)
	{
		$Text= nl2br($Text);
	}
	return trim($Text);
}
?>