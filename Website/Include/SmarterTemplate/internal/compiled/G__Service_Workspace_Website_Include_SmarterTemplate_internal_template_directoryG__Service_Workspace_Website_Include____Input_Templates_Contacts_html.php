<?php
require_once "G:/Service/Workspace/Website/Include/SmarterTemplate/internal/extensions/htmlentities.php";

?><?php $TIME_GENERATED = round(microtime (), 4); ?><link
	href="Stylesheet/Contacts.css"
	rel="stylesheet"
	type="text/css"
	media="screen, projection, print">
<div class="index_content">
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
		<td colspan="2"><?php echo $loop[1]['value']['title']; ?></td>
	</tr>
	<tr
		class="contacts"
		valign="top">
		<td><?php echo stehtmlentities ( $loop[1]['value']['name'] ); ?> <br>
		<?php echo stehtmlentities ( $loop[1]['value']['street'] ); ?> <br>
		<?php echo stehtmlentities ( $loop[1]['value']['country'] ); ?> - <?php echo stehtmlentities ( $loop[1]['value']['citycode'] ); ?> <?php echo stehtmlentities ( $loop[1]['value']['city'] ); ?></td>
		<td NOWRAP><?php echo stehtmlentities ( $loop[1]['value']['langtext']['fon'] ); ?>: <?php echo stehtmlentities ( $loop[1]['value']['prenumber'] ); ?> <?php echo stehtmlentities ( $loop[1]['value']['number'] ); ?> <br>
		<?php echo stehtmlentities ( $loop[1]['value']['langtext']['fax'] ); ?>: <?php echo stehtmlentities ( $loop[1]['value']['prenumber'] ); ?> <?php echo stehtmlentities ( $loop[1]['value']['fax'] ); ?> <br>
		<?php echo stehtmlentities ( $loop[1]['value']['langtext']['email'] ); ?>: <a href="MAILTO:<?php echo $loop[1]['value']['email']; ?>"><?php echo stehtmlentities ( $loop[1]['value']['email'] ); ?></a></td>
	</tr>
	<?php } } ?>
</table>
</div>
