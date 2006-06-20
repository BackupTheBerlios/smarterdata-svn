<?php $TIME_GENERATED = round(microtime (), 4); ?><style>
tr.newsmenu
{
	background-color: #CCCCCC;
	border-bottom: 1px solid #000000;
	font-family: verdana;
	font-size: 10px;
	border-collapse: collapse;
	margin: 0px;
	padding: 0px;
}
</style>
<table
	cellspacing="0"
	cellpadding="0"
	border="0">
	<?php
if ( is_array ( $loop[0]['value']['news'] ) )
{
$loop[1]['ROWCNT'] = -1;
$loop[1]['ROWCNTHUMAN'] = 0;
foreach ( $loop[0]['value']['news'] as $loop[1]['key'] => $loop[1]['value'] )
{
	$loop[1]['ROWCNT']++;
	$loop[1]['ROWCNTHUMAN']++;
	$loop[1]['value']['ROWCNT']       = $loop[1]['ROWCNT'];
	$loop[1]['value']['ROWCNTHUMAN']  = $loop[1]['ROWCNTHUMAN'];
	$loop[1]['value']['ROWBIT']       = $loop[1]['ROWCNT']%2;
	$loop[1]['value']['ALTROW']       = $loop[1]['ROWCNTHUMAN']%2;
	$loop[1]['value']['CURRENTKEY']   = $loop[1]['key'];
?>
	<?php if ( $loop[1]['value']['inmenu'] > "" ) { ?>
	<tr class="newsmenu">
		<td><a href="_news_<?php echo $loop[0]['value']['language']; ?>.html"><?php echo $loop[1]['value']['menuname']; ?></a></td>
	</tr>
	<?php } ?>
	<?php } } ?>
</table>
