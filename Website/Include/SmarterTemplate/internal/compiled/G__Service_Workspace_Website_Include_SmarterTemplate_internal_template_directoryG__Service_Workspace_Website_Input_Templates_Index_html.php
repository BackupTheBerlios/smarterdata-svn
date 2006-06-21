<?php $TIME_GENERATED = round(microtime (), 4); ?><script
	type="text/javascript"
	language="javascript"
	src="Javascript/Menu.js"></script>
<link
	href="Stylesheet/Index.css"
	rel="stylesheet"
	type="text/css"
	media="screen, projection, print">
<table
	cellspacing="0"
	cellpadding="0"
	border="0">
	<tr valign="top">
		<td style="width: 200px">&nbsp;</td>
		<td><?php echo $loop[0]['value']['index']['header']; ?></td>
	</tr>
	<tr valign="top">
		<td style="width: 200px">
		<div
			id="menu1"
			style="position:absolute; left:0px; top:1px; z-index:2"><?php echo $loop[0]['value']['index']['menu']; ?>
		<?php
if ( is_array ( $loop[0]['value']['languages'] ) )
{
$loop[1]['ROWCNT'] = -1;
$loop[1]['ROWCNTHUMAN'] = 0;
foreach ( $loop[0]['value']['languages'] as $loop[1]['key'] => $loop[1]['value'] )
{
	$loop[1]['ROWCNT']++;
	$loop[1]['ROWCNTHUMAN']++;
	$loop[1]['value']['ROWCNT']       = $loop[1]['ROWCNT'];
	$loop[1]['value']['ROWCNTHUMAN']  = $loop[1]['ROWCNTHUMAN'];
	$loop[1]['value']['ROWBIT']       = $loop[1]['ROWCNT']%2;
	$loop[1]['value']['ALTROW']       = $loop[1]['ROWCNTHUMAN']%2;
	$loop[1]['value']['CURRENTKEY']   = $loop[1]['key'];
?> <a href="<?php echo $loop[1]['value']['filename']; ?>"><img
			src="<?php echo $loop[1]['value']['flag']; ?>"
			border="0"></a>&nbsp;&nbsp; <?php } } ?></div>
		</td>
		<td><?php echo $loop[0]['value']['index']['content']; ?></td>
	</tr>
</table>
