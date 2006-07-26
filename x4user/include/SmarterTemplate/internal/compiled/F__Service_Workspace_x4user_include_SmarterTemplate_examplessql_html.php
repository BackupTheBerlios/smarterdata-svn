<?php
require_once "F:/Service/Workspace/x4user/include/SmarterTemplate/examples/../internal/extensions/displayFileInHTML.php";
require_once "F:/Service/Workspace/x4user/include/SmarterTemplate/examples/../internal/extensions/dateformat.php";

?><?php $TIME_GENERATED = round(microtime (), 4); ?><table style="background-color: rgb(204, 204, 204);" border="0" cellpadding="2" cellspacing="1" width="100%">
	<tr style="background-color: rgb(255, 255, 255);" valign="top">
		<td>
			<a href="erweiterung_argumente.php">zurueck</a> 
			| <a href="index.php">Uebersicht</a> 
			| <a href="index.php">weiter</a> 
			| <a href="<?php echo $loop[0]['value']['PHP_FILE']; ?>?doDebug">Debugversion</a>
		</td>
	</tr>
</table>
<table style="background-color: rgb(204, 204, 204);" border="0" cellpadding="2" cellspacing="1" width="100%">
	<tr style="background-color: rgb(255, 255, 255);" valign="top">
		<td colspan="3"><center><b>SQL</b></center></td>
	</tr>
	<tr style="background-color: rgb(255, 255, 255);" valign="top">
		<td colspan="2"><b>SQL</b></td>
	</tr>
	<tr style="background-color: rgb(255, 255, 255);" valign="top">
		<td NOWRAP><b>Template</b></td>
		<td><pre><?php echo stedisplayFileInHTML ( $loop[0]['value']['TEMPLATE_DIRECTORY'],$loop[0]['value']['TEMPLATE_FILE'] ); ?></pre></td>
	</tr>
	<tr style="background-color: rgb(255, 255, 255);" valign="top">
		<td NOWRAP><b>PHP-Code</b></td>
		<td><pre><?php echo stedisplayFileInHTML ( $loop[0]['value']['PHP_DIRECTORY'],$loop[0]['value']['PHP_FILE'] ); ?></pre></td>
	</tr>
	<tr style="background-color: rgb(255, 255, 255);" valign="top">
		<td><b>Ausgabe</b></td>
		<td>
				<?php
try {
 $loop[0]['NOEXEC'] = false;
	$loop[0]['DB'] = new PDO ( $this->sql['dsn'], $this->sql['username'], $this->sql['password'] );
} catch ( PDOException $loop_0_error ) {
	echo 'Connection failed: ' . $loop_0_error->getMessage();
 $loop[0]['NOEXEC'] = true;
}
if ( $loop[0]['NOEXEC'] === false )
{
$loop[0]['DBRES'] = $loop[0]['DB']->prepare ( "SELECT * FROM usergroups ORDER BY user_group_name" );
$loop[0]['DBRES']->execute();
$loop[0]['value']['usergroups'] = $loop[0]['DBRES']->fetchAll();
if ( sizeof ( $loop[0]['value']['usergroups'] ) == 0 ) unset ( $loop[0]['value']['usergroups'] );
}
?>

				<?php if ( isset ( $loop[0]['value']['usergroups'] ) ) { ?>
					<?php
if ( is_array ( $loop[0]['value']['usergroups'] ) )
{
$loop[1]['ROWCNT'] = -1;
$loop[1]['ROWCNTHUMAN'] = 0;
foreach ( $loop[0]['value']['usergroups'] as $loop[1]['key'] => $loop[1]['value'] )
{
	$loop[1]['ROWCNT']++;
	$loop[1]['ROWCNTHUMAN']++;
	$loop[1]['value']['ROWCNT']       = $loop[1]['ROWCNT'];
	$loop[1]['value']['ROWCNTHUMAN']  = $loop[1]['ROWCNTHUMAN'];
	$loop[1]['value']['ROWBIT']       = $loop[1]['ROWCNT']%2;
	$loop[1]['value']['ALTROW']       = $loop[1]['ROWCNTHUMAN']%2;
	$loop[1]['value']['CURRENTKEY']   = $loop[1]['key'];
?>
						<?php echo $loop[1]['value']['user_group_name']; ?> : <?php echo $loop[1]['value']['user_group_id']; ?>
						<?php
try {
 $loop[1]['NOEXEC'] = false;
	$loop[1]['DB'] = new PDO ( $this->sql['dsn'], $this->sql['username'], $this->sql['password'] );
} catch ( PDOException $loop_1_error ) {
	echo 'Connection failed: ' . $loop_1_error->getMessage();
 $loop[1]['NOEXEC'] = true;
}
if ( $loop[1]['NOEXEC'] === false )
{
$loop[1]['DBRES'] = $loop[1]['DB']->prepare ( "SELECT * FROM users WHERE user_group_id = '".$loop[1]['value']['user_group_id']."' ORDER BY user_name" );
$loop[1]['DBRES']->execute();
$loop[1]['value']['users'] = $loop[1]['DBRES']->fetchAll();
if ( sizeof ( $loop[1]['value']['users'] ) == 0 ) unset ( $loop[1]['value']['users'] );
}
?>

						<?php if ( isset ( $loop[1]['value']['users'] ) ) { ?>
							<?php
if ( is_array ( $loop[1]['value']['users'] ) )
{
$loop[2]['ROWCNT'] = -1;
$loop[2]['ROWCNTHUMAN'] = 0;
foreach ( $loop[1]['value']['users'] as $loop[2]['key'] => $loop[2]['value'] )
{
	$loop[2]['ROWCNT']++;
	$loop[2]['ROWCNTHUMAN']++;
	$loop[2]['value']['ROWCNT']       = $loop[2]['ROWCNT'];
	$loop[2]['value']['ROWCNTHUMAN']  = $loop[2]['ROWCNTHUMAN'];
	$loop[2]['value']['ROWBIT']       = $loop[2]['ROWCNT']%2;
	$loop[2]['value']['ALTROW']       = $loop[2]['ROWCNTHUMAN']%2;
	$loop[2]['value']['CURRENTKEY']   = $loop[2]['key'];
?>
								<?php echo $loop[2]['value']['user_name']; ?>
							<?php } } ?>
						<?php } else { ?>
							No users
						<?php } ?>
					<?php } } ?>
				<?php } ?>
		</td>
	</tr>
</table>
<table width="100%" cellspacing="1" cellpadding="2" border="0">
	<tr>
		<td>
			<div align="right">
				<b>Letzte Aenderung am <?php echo stedateformat ( $loop[0]['value']['TIME_REFRESHED'] ); ?></b>
				<br><b>Seite kompiliert in <?php echo $loop[0]['value']['TIME_COMPILED']; ?> Sekunden</b>
				<br><b>Seite generiert in <?php echo ( round(microtime (), 4) - $TIME_GENERATED); ?> Sekunden</b>
			</div>
		</td>
	</tr>
</table>
