<?php $TIME_GENERATED = round(microtime (), 4); ?><link
	href="Stylesheet/ProductsDocuments.css"
	rel="stylesheet"
	type="text/css"
	media="screen, projection, print">
<div class="index_content">
<table
	cellspacing="0"
	cellpadding="0"
	border="0">
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
	<tr class="productsdocuments_<?php echo $loop[1]['value']['ROWBIT']; ?>">
		<td><img
			src="Images/Other/pdf.png"
			width="19"
			height="18"
			style="vertical-align:middle"><a href="<?php echo $loop[1]['value']['path']; ?>"><?php echo $loop[1]['value']['name']; ?></a></td>
		<td><?php echo $loop[1]['value']['description']; ?></td>
	</tr>
	<?php } } ?>
</table>
</div>
