<?php $TIME_GENERATED = round(microtime (), 4); ?><style>
tr.header
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
<table cellspacing="0" cellpadding="0" border="0">
	<tr class="header">
		<?php
if ( is_array ( $loop[0]['value']['header'] ) )
{
$loop[1]['ROWCNT'] = -1;
$loop[1]['ROWCNTHUMAN'] = 0;
foreach ( $loop[0]['value']['header'] as $loop[1]['key'] => $loop[1]['value'] )
{
	$loop[1]['ROWCNT']++;
	$loop[1]['ROWCNTHUMAN']++;
	$loop[1]['value']['ROWCNT']       = $loop[1]['ROWCNT'];
	$loop[1]['value']['ROWCNTHUMAN']  = $loop[1]['ROWCNTHUMAN'];
	$loop[1]['value']['ROWBIT']       = $loop[1]['ROWCNT']%2;
	$loop[1]['value']['ALTROW']       = $loop[1]['ROWCNTHUMAN']%2;
	$loop[1]['value']['CURRENTKEY']   = $loop[1]['key'];
?>
			<td>
				<?php if ( $loop[1]['value']['linkto'] > "" ) { ?><a href="<?php echo $loop[1]['value']['linkto']; ?>" border="0"><?php } ?>
				<img src="<?php echo $loop[1]['value']['image']; ?>">
				<?php if ( $loop[1]['value']['linkto'] > "" ) { ?></a><?php } ?>
			</td>
		<?php } } ?>
	</tr>
	
</table>