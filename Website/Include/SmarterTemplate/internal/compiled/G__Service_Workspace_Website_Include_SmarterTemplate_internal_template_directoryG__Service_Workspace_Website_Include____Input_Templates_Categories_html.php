<?php
require_once "G:/Service/Workspace/Website/Include/SmarterTemplate/internal/extensions/urlencode.php";
require_once "G:/Service/Workspace/Website/Include/SmarterTemplate/internal/extensions/htmlentities.php";

?><?php $TIME_GENERATED = round(microtime (), 4); ?><table
	cellspacing="0"
	cellpadding="0"
	style="border-width: 0px">
	<?php
if ( is_array ( $loop[0]['value']['categories'] ) )
{
$loop[1]['ROWCNT'] = -1;
$loop[1]['ROWCNTHUMAN'] = 0;
foreach ( $loop[0]['value']['categories'] as $loop[1]['key'] => $loop[1]['value'] )
{
	$loop[1]['ROWCNT']++;
	$loop[1]['ROWCNTHUMAN']++;
	$loop[1]['value']['ROWCNT']       = $loop[1]['ROWCNT'];
	$loop[1]['value']['ROWCNTHUMAN']  = $loop[1]['ROWCNTHUMAN'];
	$loop[1]['value']['ROWBIT']       = $loop[1]['ROWCNT']%2;
	$loop[1]['value']['ALTROW']       = $loop[1]['ROWCNTHUMAN']%2;
	$loop[1]['value']['CURRENTKEY']   = $loop[1]['key'];
?>
	<tr class="categories">
		<td><a href="_category_<?php echo $loop[1]['value']['id']; ?>_<?php echo steurlencode ( $loop[0]['value']['language'] ); ?>.html"><?php echo stehtmlentities ( $loop[1]['value']['name'] ); ?></a></td>
	</tr>
	<?php } } ?>
</table>
