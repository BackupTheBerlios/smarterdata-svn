<?php
require_once "F:/Service/Workspace/x4user/include/SmarterTemplate/examples/../internal/extensions/displayFileInHTML.php";
require_once "F:/Service/Workspace/x4user/include/SmarterTemplate/examples/../internal/extensions/dateformat.php";

?><?php $TIME_GENERATED = round(microtime (), 4); ?><table style="background-color: rgb(204, 204, 204);" border="0" cellpadding="2" cellspacing="1" width="100%">
	<tr style="background-color: rgb(255, 255, 255);" valign="top">
		<td> <a href="phpcode.php">back</a> | <a href="index.php">Overview</a> | <!-- <a href="anzeigekontrolle.php">next</a> -->| <a href="sprachsupport.php?doDebug">Debugversion</a></td>
	</tr>
</table>
<table style="background-color: rgb(204, 204, 204);" border="0" cellpadding="2" cellspacing="1" width="100%">
	<tr style="background-color: rgb(255, 255, 255);" valign="top">
		<td colspan="3"><center><b>Language support</b></center></td>
	</tr>
	<tr style="background-color: rgb(255, 255, 255);" valign="top">
		<td colspan="2"><b>English</b></td>
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
		<td><b>Output</b></td>
		<td>Current language: <?php echo $loop[0]['value']['LANG']; ?>
			<br>Switch to: <a href="<?php echo $loop[0]['value']['PHP_FILE']; ?>?lang=<?php if ( $loop[0]['value']['LANG'] == "de" ) { ?>en">en<?php } else { ?>de">de<?php } ?></a>
		</td>
	</tr>
</table>
<table width="100%" cellspacing="1" cellpadding="2" border="0">
	<tr>
		<td> <a href="phpcode.php">back</a> | <a href="index.php">Overview</a> | next </td>
		<td>
			<div align="right">
				<b>Refreshed <?php echo stedateformat ( $loop[0]['value']['TIME_REFRESHED'] ); ?></b>
				<br><b>Page compiled in <?php echo $loop[0]['value']['TIME_COMPILED']; ?> seconds</b>
				<br><b>Page generated in <?php echo ( round(microtime (), 4) - $TIME_GENERATED); ?> seconds</b>
			</div>
		</td>
	</tr>
</table>
