<?php
require_once "G:/Service/Workspace/Website/Include/SmarterTemplate/internal/extensions/htmlentities.php";

?><?php $TIME_GENERATED = round(microtime (), 4); ?><body bgcolor="#6375bd">
<div
	valign="middle"
	align="center"
	style="width: 100%; height: 100%"><br>
<br>
<img
	src="Images/Other/new_elbefant.png"
	BORDER="0"
	width="200"
	height="198"> <br>
<br>
<br>
<table class="entrance">
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
?>
	<tr class="entrance">
		<td class="entrance"><a href="<?php echo $loop[1]['value']['filename']; ?>"><img
			src="<?php echo $loop[1]['value']['flag']; ?>"
			border="0"> <?php echo stehtmlentities ( $loop[1]['value']['langtext']['safety_and_environmental_technology'] ); ?></a></td>
	</tr>
	<?php } } ?>
</table>
</div>
</body>
