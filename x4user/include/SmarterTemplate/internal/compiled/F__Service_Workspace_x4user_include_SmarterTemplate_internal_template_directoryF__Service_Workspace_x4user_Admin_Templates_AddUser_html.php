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
<form action="<?php echo $loop[0]['value']['currentRequestFile']; ?>" method="POST">
<input type="hidden" name="action" value="addUser">
<table>
	<tr>
		<td>Username</td>
		<td><input 
			type="text" 
			name="userName" 
			value="<?php echo $loop[0]['value']['userName']; ?>"></td>
	</tr>
	<tr>
		<td>Password</td>
		<td><input 
			type="password" 
			name="userPassword" 
			value="<?php echo $loop[0]['value']['userPassword']; ?>"></td>
	</tr>
	<tr>
		<td>eMail</td>
		<td><input 
			type="text" 
			name="userEmail" 
			value="<?php echo $loop[0]['value']['userEmail']; ?>"></td>
	</tr>
	<tr>
		<td colspan="3"><input type="submit" value="Update"></td>
	</tr>
</table>
</form>