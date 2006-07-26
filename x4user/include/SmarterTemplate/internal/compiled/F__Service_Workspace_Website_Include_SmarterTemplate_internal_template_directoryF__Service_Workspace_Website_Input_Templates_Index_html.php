<?php $TIME_GENERATED = round(microtime (), 4); ?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta
	http-equiv="content-type"
	content="text/html; charset=iso-8859-1">
<link
	href="Stylesheet/ProductsAll.css"
	rel="stylesheet"
	type="text/css"
	media="screen, projection, print">
<link
	href="Stylesheet/ProductOverview.css"
	rel="stylesheet"
	type="text/css"
	media="screen, projection, print">
<link
	href="Stylesheet/Newsmenu.css"
	rel="stylesheet"
	type="text/css"
	media="screen, projection, print">
<link
	href="Stylesheet/News.css"
	rel="stylesheet"
	type="text/css"
	media="screen, projection, print">
<link
	href="Stylesheet/Menu.css"
	rel="stylesheet"
	type="text/css"
	media="screen, projection, print">
<link
	href="Stylesheet/ProductsDocuments.css"
	rel="stylesheet"
	type="text/css"
	media="screen, projection, print">
<link
	href="Stylesheet/AboutUs.css"
	rel="stylesheet"
	type="text/css"
	media="screen, projection, print">
<link
	href="Stylesheet/Categories.css"
	rel="stylesheet"
	type="text/css"
	media="screen, projection, print">
<link
	href="Stylesheet/Contacts.css"
	rel="stylesheet"
	type="text/css"
	media="screen, projection, print">
<link
	href="Stylesheet/Header.css"
	rel="stylesheet"
	type="text/css"
	media="screen, projection, print">
<link
	href="Stylesheet/Impressum.css"
	rel="stylesheet"
	type="text/css"
	media="screen, projection, print">
<link
	href="Stylesheet/Index.css"
	rel="stylesheet"
	type="text/css"
	media="screen, projection, print">
<title>E.L.B. F&uuml;llstandsger&auml;te Bundschuh GmbH+Co.</title>
</head>
<body>
<script
	type="text/javascript"
	src="Javascript/Menu.js"></script>
<?php echo $loop[0]['value']['index']['header']; ?>
<script
	type="text/javascript"
	src="Javascript/Hide.js"></script>
<div
	class="index_left"
	id="index_left"><?php echo $loop[0]['value']['index']['menu']; ?> <?php
if ( is_array ( $loop[0]['value']['languages'] ) )
{
$loop[1]['ROWCNT'] = -1;
$loop[1]['ROWCNTHUMAN'] = 0;
foreach ( $loop[0]['value']['languages'] as $loop[1]['key'] => $loop[1]['value'] )
{
	$loop[1]['ROWCNT']++;
	$loop[1]['ROWCNTHUMAN']++;
	$loop[1]['value']['ROWCNT']       = $loop[1]['ROWCNT'];
	$loop[1]['value']['ROWCNTHUMAN']  = $loop[1]['ROWCNTHUMAN'];
	$loop[1]['value']['ROWBIT']       = $loop[1]['ROWCNT']%2;
	$loop[1]['value']['ALTROW']       = $loop[1]['ROWCNTHUMAN']%2;
	$loop[1]['value']['CURRENTKEY']   = $loop[1]['key'];
?> <a
	href="<?php echo $loop[1]['value']['filename']; ?>"><img
	src="<?php echo $loop[1]['value']['flag']; ?>"
	alt="FLAG"
	style="border-width: 0px"></a> &nbsp;&nbsp; <?php } } ?></div>
<script type="text/javascript">
initMenu('index_left', 0);
</script>
<?php echo $loop[0]['value']['index']['content']; ?>
<script
	type="text/javascript"
	src="Javascript/wz_tooltip/wz_tooltip.js"></script>
</body>
</html>
