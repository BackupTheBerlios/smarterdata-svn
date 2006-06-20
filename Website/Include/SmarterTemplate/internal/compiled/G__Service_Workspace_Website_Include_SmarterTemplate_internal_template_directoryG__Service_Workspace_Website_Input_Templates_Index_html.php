<?php $TIME_GENERATED = round(microtime (), 4); ?><style>
a:link {
font-weight:normal;
color:#000000;
text-decoration:none;
}
a:visited {
font-weight:normal;
color:#CCCCCC;
text-decoration:none;
}
a:focus {
font-weight:normal;
color:#FFFFFF;
text-decoration:underline;
}
a:hover {
font-weight:normal;
color:#FFFFFF;
text-decoration:none;
}
a:active {
font-weight:bold;
color:#FFFFFF;
text-decoration:underline;
}
body, table, td, img
{
	background-color: #6375bd;
	font-family: verdana;
	border-collapse: collapse;
	border: 0px;
	margin: 0px;
	padding: 0px;
	color: rgb( 0, 0, 0 );
}
</style>
<table cellspacing="0" cellpadding="0" border="0">
	<tr valign="top">
		<td style="width: 200px"></td>
		<td><?php echo $loop[0]['value']['index']['header']; ?></td>
	</tr>
	<tr valign="top">
		<td><?php echo $loop[0]['value']['index']['menu']; ?></td>
		<td><?php echo $loop[0]['value']['index']['content']; ?></td>
	</tr>
</table>