<?php
require_once "F:/Service/Workspace/x4user/include/SmarterTemplate/internal/extensions/htmlentities.php";

?><?php $TIME_GENERATED = round(microtime (), 4); ?><table>
	<?php
if ( is_array ( $loop[0]['value']['userList'] ) )
{
$loop[1]['ROWCNT'] = -1;
$loop[1]['ROWCNTHUMAN'] = 0;
foreach ( $loop[0]['value']['userList'] as $loop[1]['key'] => $loop[1]['value'] )
{
	$loop[1]['ROWCNT']++;
	$loop[1]['ROWCNTHUMAN']++;
	$loop[1]['value']['ROWCNT']       = $loop[1]['ROWCNT'];
	$loop[1]['value']['ROWCNTHUMAN']  = $loop[1]['ROWCNTHUMAN'];
	$loop[1]['value']['ROWBIT']       = $loop[1]['ROWCNT']%2;
	$loop[1]['value']['ALTROW']       = $loop[1]['ROWCNTHUMAN']%2;
	$loop[1]['value']['CURRENTKEY']   = $loop[1]['key'];
?>
		<tr>
			<td>
				<a href="EditUser.php?userId=<?php echo $loop[1]['value']['userId']; ?>">
					<?php echo stehtmlentities ( $loop[1]['value']['userName'] ); ?>
				</a>
			</td>
		</tr>
	<?php } } ?>
</table>