<?php $TIME_GENERATED = round(microtime (), 4); ?><link
	href="Stylesheet/News.css"
	rel="stylesheet"
	type="text/css"
	media="screen, projection, print">
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
	<tr class="news">
		<td><?php echo $loop[1]['value']['date']; ?></td>
		<td><?php echo $loop[1]['value']['headline']; ?></td>
	</tr>
	<tr class="news">
		<td colspan="2">
		<ul>
			<?php
if ( is_array ( $loop[1]['value']['description'] ) )
{
$loop[2]['ROWCNT'] = -1;
$loop[2]['ROWCNTHUMAN'] = 0;
foreach ( $loop[1]['value']['description'] as $loop[2]['key'] => $loop[2]['value'] )
{
	$loop[2]['ROWCNT']++;
	$loop[2]['ROWCNTHUMAN']++;
	$loop[2]['value']['ROWCNT']       = $loop[2]['ROWCNT'];
	$loop[2]['value']['ROWCNTHUMAN']  = $loop[2]['ROWCNTHUMAN'];
	$loop[2]['value']['ROWBIT']       = $loop[2]['ROWCNT']%2;
	$loop[2]['value']['ALTROW']       = $loop[2]['ROWCNTHUMAN']%2;
	$loop[2]['value']['CURRENTKEY']   = $loop[2]['key'];
?>
			<li><?php echo $loop[2]['value']['value']; ?></li>
			<?php } } ?>
		</ul>
		<?php if ( $loop[1]['value']['newsdoc'] > "" ) { ?>
		<div align="right">
		<ul>
			<?php
if ( is_array ( $loop[1]['value']['newsdoc'] ) )
{
$loop[2]['ROWCNT'] = -1;
$loop[2]['ROWCNTHUMAN'] = 0;
foreach ( $loop[1]['value']['newsdoc'] as $loop[2]['key'] => $loop[2]['value'] )
{
	$loop[2]['ROWCNT']++;
	$loop[2]['ROWCNTHUMAN']++;
	$loop[2]['value']['ROWCNT']       = $loop[2]['ROWCNT'];
	$loop[2]['value']['ROWCNTHUMAN']  = $loop[2]['ROWCNTHUMAN'];
	$loop[2]['value']['ROWBIT']       = $loop[2]['ROWCNT']%2;
	$loop[2]['value']['ALTROW']       = $loop[2]['ROWCNTHUMAN']%2;
	$loop[2]['value']['CURRENTKEY']   = $loop[2]['key'];
?>
			<li><img
				src="Images/Other/pdf.png"
				width="19"
				height="18"
				style="vertical-align:middle"><a href="Documents/News/<?php echo $loop[2]['value']['path']; ?>"><?php echo $loop[2]['value']['name']; ?></a></li>
			<?php } } ?>
		</ul>
		</div>
		<?php } ?></td>
	</tr>
	<?php } } ?>
</table>
