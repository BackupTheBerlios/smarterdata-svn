<?php $TIME_GENERATED = round(microtime (), 4); ?><?php
if ( is_array ( $loop[0]['value']['aboutus'] ) )
{
$loop[1]['ROWCNT'] = -1;
$loop[1]['ROWCNTHUMAN'] = 0;
foreach ( $loop[0]['value']['aboutus'] as $loop[1]['key'] => $loop[1]['value'] )
{
	$loop[1]['ROWCNT']++;
	$loop[1]['ROWCNTHUMAN']++;
	$loop[1]['value']['ROWCNT']       = $loop[1]['ROWCNT'];
	$loop[1]['value']['ROWCNTHUMAN']  = $loop[1]['ROWCNTHUMAN'];
	$loop[1]['value']['ROWBIT']       = $loop[1]['ROWCNT']%2;
	$loop[1]['value']['ALTROW']       = $loop[1]['ROWCNTHUMAN']%2;
	$loop[1]['value']['CURRENTKEY']   = $loop[1]['key'];
?>
<p><img
	src="./images/<?php echo $loop[1]['value']['imagepath']; ?>"
	align="<?php echo $loop[1]['value']['imageposition']; ?>"
	border="0"> <?php echo $loop[1]['value']['content']; ?> <br />
</p>
<?php } } ?>
