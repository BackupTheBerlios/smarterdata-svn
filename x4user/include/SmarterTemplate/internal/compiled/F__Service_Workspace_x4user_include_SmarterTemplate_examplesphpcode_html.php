<?php
require_once "F:/Service/Workspace/x4user/include/SmarterTemplate/examples/../internal/extensions/displayFileInHTML.php";
require_once "F:/Service/Workspace/x4user/include/SmarterTemplate/examples/../internal/extensions/dateformat.php";

?><?php $TIME_GENERATED = round(microtime (), 4); ?><table style="background-color: rgb(204, 204, 204);" border="0" cellpadding="2" cellspacing="1" width="100%">
	<tr style="background-color: rgb(255, 255, 255);" valign="top">
		<td>
			<a href="anzeigekontrolle.php">zurueck</a> 
			| <a href="index.php">Uebersicht</a> 
			| <a href="sprachsupport.php">weiter</a> 
			| <a href="<?php echo $loop[0]['value']['PHP_FILE']; ?>?doDebug">Debugversion</a>
		</td>
	</tr>
</table>
<table style="background-color: rgb(204, 204, 204);" border="0" cellpadding="2" cellspacing="1" width="100%">
	<tr style="background-color: rgb(255, 255, 255);" valign="top">
		<td colspan="3"><center><b>PHP Ausfuehrung</b></center></td>
	</tr>
	<tr style="background-color: rgb(255, 255, 255);" valign="top">
		<td colspan="2"><b>Normale Ausfuehrung unterbinden</b></td>
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
		<td><?php highlight_string ( '<?php  echo "PHP-Code";  ?>' ); ?>
			<?php echo "<br>PHP-Code2"; ?>
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
