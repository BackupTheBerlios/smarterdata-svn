<?php
require_once "F:/Service/Workspace/x4user/include/SmarterTemplate/examples/../internal/extensions/displayFileInHTML.php";
require_once "F:/Service/Workspace/x4user/include/SmarterTemplate/examples/../internal/extensions/dateformat.php";

?><?php $TIME_GENERATED = round(microtime (), 4); ?><table style="background-color: rgb(204, 204, 204);" border="0" cellpadding="2" cellspacing="1" width="100%">
	<tr style="background-color: rgb(255, 255, 255);" valign="top">
		<td>
			<a href="erweiterung_argumente.php">zurueck</a> 
			| <a href="index.php">Uebersicht</a> 
			| <a href="anzeigekontrolle.php">weiter</a> 
			| <a href="<?php echo $loop[0]['value']['PHP_FILE']; ?>?doDebug">Debugversion</a>
		</td>
	</tr>
</table>
<table style="background-color: rgb(204, 204, 204);" border="0" cellpadding="2" cellspacing="1" width="100%">
	<tr style="background-color: rgb(255, 255, 255);" valign="top">
		<td colspan="3"><center><b>Kontrollstrukturen</b></center></td>
	</tr>
	<tr style="background-color: rgb(255, 255, 255);" valign="top">
		<td colspan="2"><b>Schleifen</b></td>
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
if ( is_array ( $loop[0]['value']['zeile'] ) )
{
$loop[1]['ROWCNT'] = -1;
$loop[1]['ROWCNTHUMAN'] = 0;
foreach ( $loop[0]['value']['zeile'] as $loop[1]['key'] => $loop[1]['value'] )
{
	$loop[1]['ROWCNT']++;
	$loop[1]['ROWCNTHUMAN']++;
	$loop[1]['value']['ROWCNT']       = $loop[1]['ROWCNT'];
	$loop[1]['value']['ROWCNTHUMAN']  = $loop[1]['ROWCNTHUMAN'];
	$loop[1]['value']['ROWBIT']       = $loop[1]['ROWCNT']%2;
	$loop[1]['value']['ALTROW']       = $loop[1]['ROWCNTHUMAN']%2;
	$loop[1]['value']['CURRENTKEY']   = $loop[1]['key'];
?>
				<?php echo $loop[1]['value']['CURRENTKEY']; ?>: <?php echo $loop[1]['value']['Spalte1']; ?>, <?php echo $loop[1]['value']['Spalte2']; ?>, <?php echo $loop[1]['value']['Spalte3']; ?><br>
			<?php } } ?>
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
