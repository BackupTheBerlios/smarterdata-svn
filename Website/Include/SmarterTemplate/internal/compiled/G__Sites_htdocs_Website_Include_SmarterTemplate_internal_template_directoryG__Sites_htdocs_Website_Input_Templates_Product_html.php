<?php $TIME_GENERATED = round(microtime (), 4); ?><style>
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
table.product
{
	width: 600px;
	border: 1px solid #000000;
}
table.headline
{
	border: 0px solid #000000;
}
td.product_headline
{
	border: 0px solid #000000;
	padding: 2px;
	background-color: #6c83b0;
	font-size: 1px;
	font-weight: normal;
	color: #000000;
	text-align: left;
	vertical-align: top;
}
td.product_headline_category
{
	padding: 2px;
	background-color: #6c83b0;
	width: 100px;
	font-size: 14px;
	font-weight: bold;
	color: #000000;
	text-align: center;
}
td.product_headline_name
{
	padding: 2px;
	background-color: #6c83b0;
	font-size: 15px;
	font-weight: bold;
	color: #000000;
	text-align: left;
}
td.product_content_description
{
	border: 0px solid #000000;
	padding: 2px;
	background-color: #FFFFFF;
	font-size: 12px;
	font-weight: bold;
	color: #000000;
}
td.product_icon
{
	width: 170px;
	border: 0px solid #000000;
	padding: 0px;
	font-size: 1px;
	font-weight: normal;
	color: #000000;
	text-align: center;
	vertical-align: center;
}
td.product_description
{
	border: 0px solid #000000;
	padding: 0px;
	font-size: 1px;
	font-weight: normal;
	color: #000000;
	text-align: center;
	vertical-align: center;
}
td.product_content_empty
{
	text-align: left;
	background-color: #6c83b0;
	font-size: 14px;
	font-weight: bold;
	color: #000000;
}
td.product_content_headline
{
	text-align: left;
	padding-left: 100px;
	background-color: #6c83b0;
	font-size: 14px;
	font-weight: bold;
	color: #000000;
}
td.contentside
{
	vertical-align: top;
	text-align: left;
	padding: 2px;
	font-size: 12px;
	font-weight: normal;
	color: #000000;
}
div.seealsosideinside
{
	border: 0px solid #000000;
	border-top: 1px dotted #333333;
	border-bottom: 1px dotted #333333;
	text-align: left;
	background-color: #6c83b0;
	padding: 5px;
	margin-top: 10px;
	margin-bottom: 10px;
	font-size: 12px;
	font-weight: normal;
	color: #000000;
}
div.description
{
	border: 0px solid #000000;
	border-top: 1px dotted #333333;
	border-bottom: 1px dotted #333333;
	border-left: 1px solid #333333;
	text-align: left;
	background-color: #6c83b0;
	padding: 5px;
	margin-top: 10px;
	margin-bottom: 10px;
	font-size: 12px;
	font-weight: normal;
	color: #000000;
}
</style>
<table
	class="product"
	width="100%"
	cellspacing="1"
	colspan="1"
	border="0">
	<tr>
		<td
			colspan="2"
			class="product_headline_name"><?php echo $loop[0]['value']['product']['category']; ?>
		&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $loop[0]['value']['product']['name']; ?></td>
	</tr>
	<tr valign="top">
		<td class="product_icon"><img
			src="images/<?php echo $loop[0]['value']['product']['icon']; ?>"
			align="left"></td>
		<!-- DESCRIPTION -->
		<td class="product_description">
		<div
			class="seealsosideinside"
			width="100%"><b><?php echo $loop[0]['value']['product']['headline']; ?>:</b>
		<ul>
			<?php
if ( is_array ( $loop[0]['value']['product']['description'] ) )
{
$loop[1]['ROWCNT'] = -1;
$loop[1]['ROWCNTHUMAN'] = 0;
foreach ( $loop[0]['value']['product']['description'] as $loop[1]['key'] => $loop[1]['value'] )
{
	$loop[1]['ROWCNT']++;
	$loop[1]['ROWCNTHUMAN']++;
	$loop[1]['value']['ROWCNT']       = $loop[1]['ROWCNT'];
	$loop[1]['value']['ROWCNTHUMAN']  = $loop[1]['ROWCNTHUMAN'];
	$loop[1]['value']['ROWBIT']       = $loop[1]['ROWCNT']%2;
	$loop[1]['value']['ALTROW']       = $loop[1]['ROWCNTHUMAN']%2;
	$loop[1]['value']['CURRENTKEY']   = $loop[1]['key'];
?>
			<li><?php echo $loop[1]['value']['value']; ?></li>
			<?php } } ?>
		</ul>
		</div>
		</td>
	</tr>
	<tr valign="top">
		<td colspan="2"><!-- DOCS -->
		<table
			width="100%"
			cellspacing="0"
			cellpadding="0"
			border="0">
			<tr valign="top">
				<td width="50%" ><?php if ( $loop[0]['value']['product']['datasheet'] > "" ) { ?>
				<div
					class="seealsosideinside"
					width="100%"><i><b><?php echo $loop[0]['value']['product']['langtext']['datasheet']; ?>:</b></i>
				<ul>
					<?php
if ( is_array ( $loop[0]['value']['product']['datasheet'] ) )
{
$loop[1]['ROWCNT'] = -1;
$loop[1]['ROWCNTHUMAN'] = 0;
foreach ( $loop[0]['value']['product']['datasheet'] as $loop[1]['key'] => $loop[1]['value'] )
{
	$loop[1]['ROWCNT']++;
	$loop[1]['ROWCNTHUMAN']++;
	$loop[1]['value']['ROWCNT']       = $loop[1]['ROWCNT'];
	$loop[1]['value']['ROWCNTHUMAN']  = $loop[1]['ROWCNTHUMAN'];
	$loop[1]['value']['ROWBIT']       = $loop[1]['ROWCNT']%2;
	$loop[1]['value']['ALTROW']       = $loop[1]['ROWCNTHUMAN']%2;
	$loop[1]['value']['CURRENTKEY']   = $loop[1]['key'];
?>
					<li><a href="Documents/Datasheet/<?php echo $loop[1]['value']['path']; ?>"><?php echo $loop[1]['value']['name']; ?></a></li>
					<?php } } ?>
				</ul>
				</div>
				<?php } else { ?>&nbsp;<?php } ?> <?php if ( $loop[0]['value']['product']['manual'] > "" ) { ?>
				<div
					class="seealsosideinside"
					width="100%"><i><b><?php echo $loop[0]['value']['product']['langtext']['handbuch']; ?>:</b></i>
				<ul>
					<?php
if ( is_array ( $loop[0]['value']['product']['manual'] ) )
{
$loop[1]['ROWCNT'] = -1;
$loop[1]['ROWCNTHUMAN'] = 0;
foreach ( $loop[0]['value']['product']['manual'] as $loop[1]['key'] => $loop[1]['value'] )
{
	$loop[1]['ROWCNT']++;
	$loop[1]['ROWCNTHUMAN']++;
	$loop[1]['value']['ROWCNT']       = $loop[1]['ROWCNT'];
	$loop[1]['value']['ROWCNTHUMAN']  = $loop[1]['ROWCNTHUMAN'];
	$loop[1]['value']['ROWBIT']       = $loop[1]['ROWCNT']%2;
	$loop[1]['value']['ALTROW']       = $loop[1]['ROWCNTHUMAN']%2;
	$loop[1]['value']['CURRENTKEY']   = $loop[1]['key'];
?>
					<li><a href="Documents/Manual/<?php echo $loop[1]['value']['path']; ?>"><?php echo $loop[1]['value']['name']; ?></a></li>
					<?php } } ?>
				</ul>
				</div>
				<?php } else { ?> &nbsp; <?php } ?></td>
				<td width="50%" style="border-left: 1px solid #000000;"><?php if ( $loop[0]['value']['product']['otherdoc'] > "" ) { ?>
				<div
					class="seealsosideinside"
					width="100%"><i><b><?php echo $loop[0]['value']['product']['langtext']['otherdoc']; ?>:</b></i>
				<ul>
					<?php
if ( is_array ( $loop[0]['value']['product']['otherdoc'] ) )
{
$loop[1]['ROWCNT'] = -1;
$loop[1]['ROWCNTHUMAN'] = 0;
foreach ( $loop[0]['value']['product']['otherdoc'] as $loop[1]['key'] => $loop[1]['value'] )
{
	$loop[1]['ROWCNT']++;
	$loop[1]['ROWCNTHUMAN']++;
	$loop[1]['value']['ROWCNT']       = $loop[1]['ROWCNT'];
	$loop[1]['value']['ROWCNTHUMAN']  = $loop[1]['ROWCNTHUMAN'];
	$loop[1]['value']['ROWBIT']       = $loop[1]['ROWCNT']%2;
	$loop[1]['value']['ALTROW']       = $loop[1]['ROWCNTHUMAN']%2;
	$loop[1]['value']['CURRENTKEY']   = $loop[1]['key'];
?>
					<li><a href="Documents/Otherdoc/<?php echo $loop[1]['value']['path']; ?>"><?php echo $loop[1]['value']['name']; ?></a></li>
					<?php } } ?>
				</ul>
				</div>
				<?php } else { ?> &nbsp; <?php } ?> <?php if ( $loop[0]['value']['product']['linkto'] > "" ) { ?>
				<div
					class="seealsosideinside"
					width="100%"><i><b><?php echo $loop[0]['value']['product']['langtext']['siehe_auch']; ?>:</b></i>
				<ul>
					<?php
if ( is_array ( $loop[0]['value']['product']['linkto'] ) )
{
$loop[1]['ROWCNT'] = -1;
$loop[1]['ROWCNTHUMAN'] = 0;
foreach ( $loop[0]['value']['product']['linkto'] as $loop[1]['key'] => $loop[1]['value'] )
{
	$loop[1]['ROWCNT']++;
	$loop[1]['ROWCNTHUMAN']++;
	$loop[1]['value']['ROWCNT']       = $loop[1]['ROWCNT'];
	$loop[1]['value']['ROWCNTHUMAN']  = $loop[1]['ROWCNTHUMAN'];
	$loop[1]['value']['ROWBIT']       = $loop[1]['ROWCNT']%2;
	$loop[1]['value']['ALTROW']       = $loop[1]['ROWCNTHUMAN']%2;
	$loop[1]['value']['CURRENTKEY']   = $loop[1]['key'];
?>
					<li><a href="<?php echo $loop[1]['value']['value']; ?>_details_<?php echo $loop[0]['value']['product']['language']; ?>.html"><?php echo $loop[1]['value']['value']; ?></a></li>
					<?php } } ?>
				</ul>
				</div>
				<?php } else { ?> &nbsp; <?php } ?></td>
			</tr>
		</table>
		</td>
	</tr>
</table>
