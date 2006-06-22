<?php
require_once "G:/Service/Workspace/Website/Include/SmarterTemplate/internal/extensions/htmlentities.php";

?><?php $TIME_GENERATED = round(microtime (), 4); ?><link
	href="Stylesheet/Impressum.css"
	rel="stylesheet"
	type="text/css"
	media="screen, projection, print">
<div class="index_content">
<table
	cellspacing="0"
	cellpadding="0"
	border="0">
	<tr class="impressum">
		<?php
if ( is_array ( $loop[0]['value']['impressum'] ) )
{
$loop[1]['ROWCNT'] = -1;
$loop[1]['ROWCNTHUMAN'] = 0;
foreach ( $loop[0]['value']['impressum'] as $loop[1]['key'] => $loop[1]['value'] )
{
	$loop[1]['ROWCNT']++;
	$loop[1]['ROWCNTHUMAN']++;
	$loop[1]['value']['ROWCNT']       = $loop[1]['ROWCNT'];
	$loop[1]['value']['ROWCNTHUMAN']  = $loop[1]['ROWCNTHUMAN'];
	$loop[1]['value']['ROWBIT']       = $loop[1]['ROWCNT']%2;
	$loop[1]['value']['ALTROW']       = $loop[1]['ROWCNTHUMAN']%2;
	$loop[1]['value']['CURRENTKEY']   = $loop[1]['key'];
?>
		<td><?php echo stehtmlentities ( $loop[1]['value']['text'] ); ?></td>
		<?php } } ?>
	</tr>
</table>
</div>
