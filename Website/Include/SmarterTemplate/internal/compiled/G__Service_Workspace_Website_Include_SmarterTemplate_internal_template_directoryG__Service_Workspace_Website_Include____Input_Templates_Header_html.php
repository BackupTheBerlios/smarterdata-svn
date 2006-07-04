<?php $TIME_GENERATED = round(microtime (), 4); ?><div class="index_top"><?php
if ( is_array ( $loop[0]['value']['header'] ) )
{
$loop[1]['ROWCNT'] = -1;
$loop[1]['ROWCNTHUMAN'] = 0;
foreach ( $loop[0]['value']['header'] as $loop[1]['key'] => $loop[1]['value'] )
{
	$loop[1]['ROWCNT']++;
	$loop[1]['ROWCNTHUMAN']++;
	$loop[1]['value']['ROWCNT']       = $loop[1]['ROWCNT'];
	$loop[1]['value']['ROWCNTHUMAN']  = $loop[1]['ROWCNTHUMAN'];
	$loop[1]['value']['ROWBIT']       = $loop[1]['ROWCNT']%2;
	$loop[1]['value']['ALTROW']       = $loop[1]['ROWCNTHUMAN']%2;
	$loop[1]['value']['CURRENTKEY']   = $loop[1]['key'];
?> <?php if ( $loop[1]['value']['linkto'] > "" ) { ?><a
	href="<?php echo $loop[1]['value']['linkto']; ?>"
	style="border-width: 0px"><?php } ?> <img
	src="Images/<?php echo $loop[1]['value']['image']; ?>" alt="<?php echo $loop[1]['value']['image']; ?>"> <?php if ( $loop[1]['value']['linkto'] > "" ) { ?></a><?php } ?><?php } } ?>
</div>
