<?php
require_once "F:/Service/Workspace/x4user/include/SmarterTemplate/internal/extensions/htmlentities.php";

?><?php $TIME_GENERATED = round(microtime (), 4); ?><?php if ( $loop[0]['value']['error'] > "" ) { ?>
	<?php
if ( is_array ( $loop[0]['value']['error'] ) )
{
$loop[1]['ROWCNT'] = -1;
$loop[1]['ROWCNTHUMAN'] = 0;
foreach ( $loop[0]['value']['error'] as $loop[1]['key'] => $loop[1]['value'] )
{
	$loop[1]['ROWCNT']++;
	$loop[1]['ROWCNTHUMAN']++;
	$loop[1]['value']['ROWCNT']       = $loop[1]['ROWCNT'];
	$loop[1]['value']['ROWCNTHUMAN']  = $loop[1]['ROWCNTHUMAN'];
	$loop[1]['value']['ROWBIT']       = $loop[1]['ROWCNT']%2;
	$loop[1]['value']['ALTROW']       = $loop[1]['ROWCNTHUMAN']%2;
	$loop[1]['value']['CURRENTKEY']   = $loop[1]['key'];
?><?php echo stehtmlentities ( $loop[1]['value']['value'] ); ?><?php } } ?>
<?php } ?>
<form action="<?php echo $loop[0]['value']['currentRequestFile']; ?>" method="post">
<table>
	<tr>
		<td 
			colspan="2">Database</td>
	</tr>
	<tr>
		<td>Host/IP</td>
		<td><input 
			type="text" 
			name="databaseHost" 
			value="<?php echo stehtmlentities ( $loop[0]['value']['_POST']['databaseHost'] ); ?>"></td>
	</tr>
	<tr>
		<td>Username</td>
		<td><input
			type="text"
			name="databaseUsername"
			value="<?php echo stehtmlentities ( $loop[0]['value']['_POST']['databaseUsername'] ); ?>"></td>
	</tr>
	<tr>
		<td>Password</td>
		<td><input
			type="text"
			name="databaseUserpass"
			value="<?php echo stehtmlentities ( $loop[0]['value']['_POST']['databaseUserpass'] ); ?>"></td>
	</tr>
	<tr>
		<td>Database</td>
		<td><input
			type="text"
			name="databaseName"
			value="<?php echo stehtmlentities ( $loop[0]['value']['_POST']['databaseName'] ); ?>"></td>
	</tr>
	<tr>
		<td>Prefix</td>
		<td><input
			type="text"
			name="databaseTableprefix"
			value="<?php echo stehtmlentities ( $loop[0]['value']['_POST']['databaseTableprefix'] ); ?>"></td>
	</tr>
	<tr>
		<td 
			colspan="2"><input
				type="submit"
				value="Create"></td>
	</tr>
</table>
</form>