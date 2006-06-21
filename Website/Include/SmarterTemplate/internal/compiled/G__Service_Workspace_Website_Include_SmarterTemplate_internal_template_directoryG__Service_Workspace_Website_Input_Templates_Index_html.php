<?php $TIME_GENERATED = round(microtime (), 4); ?><script
	type="text/javascript"
	language="javascript"
	src="Javascript/Menu.js"></script>
<link href="Stylesheet/Index.css" rel="stylesheet" type="text/css" media="screen, projection, print">
<body OnLoad="setVariables();checkLocationMenu1();checkLocationMenu2()">
<table
	cellspacing="0"
	cellpadding="0"
	border="0">
	<tr valign="top">
		<td style="width: 200px">&nbsp;</td>
		<td><?php echo $loop[0]['value']['index']['header']; ?></td>
	</tr>
	<tr valign="top">
		<td style="width: 200px"><?php echo $loop[0]['value']['index']['menu']; ?></td>
		<td><?php echo $loop[0]['value']['index']['content']; ?></td>
	</tr>
</table>