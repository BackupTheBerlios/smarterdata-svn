<?php
require_once "F:/Service/Workspace/Website/Include/SmarterTemplate/internal/extensions/htmlentities.php";
require_once "F:/Service/Workspace/Website/Include/SmarterTemplate/internal/extensions/resetheader.php";

?><?php $TIME_GENERATED = round(microtime (), 4); ?><div class="index_content">
<table
	cellspacing="0"
	cellpadding="0"
	style="border-width: 0px">
	<tr class="productsdocuments">
		<?php
if ( is_array ( $loop[0]['value']['documents'] ) )
{
$loop[1]['ROWCNT'] = -1;
$loop[1]['ROWCNTHUMAN'] = 0;
foreach ( $loop[0]['value']['documents'] as $loop[1]['key'] => $loop[1]['value'] )
{
	$loop[1]['ROWCNT']++;
	$loop[1]['ROWCNTHUMAN']++;
	$loop[1]['value']['ROWCNT']       = $loop[1]['ROWCNT'];
	$loop[1]['value']['ROWCNTHUMAN']  = $loop[1]['ROWCNTHUMAN'];
	$loop[1]['value']['ROWBIT']       = $loop[1]['ROWCNT']%2;
	$loop[1]['value']['ALTROW']       = $loop[1]['ROWCNTHUMAN']%2;
	$loop[1]['value']['CURRENTKEY']   = $loop[1]['key'];
?>
		<td><a href="<?php echo $loop[1]['value']['path']; ?>"><img
			src="Images/Other/pdf.png"
			alt="PDFICON"
			style="width: 19px; height: 18px; border-width: 0px;"
			style="vertical-align:middle"></a>
		</td>
		<td><a href="<?php echo $loop[1]['value']['path']; ?>"><?php echo stehtmlentities ( $loop[1]['value']['name'] ); ?>, <?php echo stehtmlentities ( $loop[1]['value']['description'] ); ?></a></td>
		<?php echo steresetheader ( $loop[1]['value']['ROWCNT'],"2","</tr><tr class='productsdocuments'>" ); ?>
		<?php } } ?>
	</tr>
</table>
</div>
