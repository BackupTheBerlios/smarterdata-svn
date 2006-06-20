<?php $TIME_GENERATED = round(microtime (), 4); ?><style>
tr.contactheader
{
	background-color: #BBBBBB;
	border-bottom: 1px solid #000000;
	font-family: verdana;
	font-size: 10px;
	border-collapse: collapse;
	margin: 0px;
	padding: 0px;
}
tr.contacts
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
if ( is_array ( $loop[0]['value']['contacts'] ) )
{
$loop[1]['ROWCNT'] = -1;
$loop[1]['ROWCNTHUMAN'] = 0;
foreach ( $loop[0]['value']['contacts'] as $loop[1]['key'] => $loop[1]['value'] )
{
	$loop[1]['ROWCNT']++;
	$loop[1]['ROWCNTHUMAN']++;
	$loop[1]['value']['ROWCNT']       = $loop[1]['ROWCNT'];
	$loop[1]['value']['ROWCNTHUMAN']  = $loop[1]['ROWCNTHUMAN'];
	$loop[1]['value']['ROWBIT']       = $loop[1]['ROWCNT']%2;
	$loop[1]['value']['ALTROW']       = $loop[1]['ROWCNTHUMAN']%2;
	$loop[1]['value']['CURRENTKEY']   = $loop[1]['key'];
?>
	<tr class="contactheader">
		<td
			colspan="2"
			align="center"><?php echo $loop[1]['value']['title']; ?></td>
	</tr>
	<tr
		class="contacts"
		valign="top">
		<td><?php echo $loop[1]['value']['name']; ?> <br>
		<?php echo $loop[1]['value']['street']; ?> <br>
		<?php echo $loop[1]['value']['country']; ?> - <?php echo $loop[1]['value']['citycode']; ?> <?php echo $loop[1]['value']['city']; ?></td>
		<td NOWRAP><?php echo $loop[1]['value']['langtext']['fon']; ?>: <?php echo $loop[1]['value']['prenumber']; ?> <?php echo $loop[1]['value']['number']; ?> <br>
		<?php echo $loop[1]['value']['langtext']['fax']; ?>: <?php echo $loop[1]['value']['prenumber']; ?> <?php echo $loop[1]['value']['fax']; ?> <br>
		<?php echo $loop[1]['value']['langtext']['email']; ?>: <?php echo $loop[1]['value']['email']; ?></td>
	</tr>
	<?php } } ?>
</table>
