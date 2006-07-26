<?php
require_once "F:/Service/Workspace/Website/Include/SmarterTemplate/internal/extensions/htmlentities.php";

?><?php $TIME_GENERATED = round(microtime (), 4); ?><div
	class="menu2"
	id="menu2"><b><?php echo stehtmlentities ( $loop[0]['value']['products']['0']['langtext']['products'] ); ?></b><br>
<?php
if ( is_array ( $loop[0]['value']['products'] ) )
{
$loop[1]['ROWCNT'] = -1;
$loop[1]['ROWCNTHUMAN'] = 0;
foreach ( $loop[0]['value']['products'] as $loop[1]['key'] => $loop[1]['value'] )
{
	$loop[1]['ROWCNT']++;
	$loop[1]['ROWCNTHUMAN']++;
	$loop[1]['value']['ROWCNT']       = $loop[1]['ROWCNT'];
	$loop[1]['value']['ROWCNTHUMAN']  = $loop[1]['ROWCNTHUMAN'];
	$loop[1]['value']['ROWBIT']       = $loop[1]['ROWCNT']%2;
	$loop[1]['value']['ALTROW']       = $loop[1]['ROWCNTHUMAN']%2;
	$loop[1]['value']['CURRENTKEY']   = $loop[1]['key'];
?> <a href="#<?php echo $loop[1]['value']['hash']; ?>"><?php echo stehtmlentities ( $loop[1]['value']['name'] ); ?></a>
(<?php echo stehtmlentities ( $loop[1]['value']['category'] ); ?>)<br>
<?php } } ?></div>
<div class="index_content"><script type="text/javascript">initMenu('menu2', 121);</script>
<table
	class="product"
	cellspacing="1"
	style="border-width: 0px; width: 600px;">
	<?php
if ( is_array ( $loop[0]['value']['products'] ) )
{
$loop[1]['ROWCNT'] = -1;
$loop[1]['ROWCNTHUMAN'] = 0;
foreach ( $loop[0]['value']['products'] as $loop[1]['key'] => $loop[1]['value'] )
{
	$loop[1]['ROWCNT']++;
	$loop[1]['ROWCNTHUMAN']++;
	$loop[1]['value']['ROWCNT']       = $loop[1]['ROWCNT'];
	$loop[1]['value']['ROWCNTHUMAN']  = $loop[1]['ROWCNTHUMAN'];
	$loop[1]['value']['ROWBIT']       = $loop[1]['ROWCNT']%2;
	$loop[1]['value']['ALTROW']       = $loop[1]['ROWCNTHUMAN']%2;
	$loop[1]['value']['CURRENTKEY']   = $loop[1]['key'];
?>
	<tr class="product_tr">
		<td
			colspan="2"
			class="product_headline_name"><a name="<?php echo $loop[1]['value']['hash']; ?>" />&nbsp;</a><?php echo stehtmlentities ( $loop[1]['value']['category'] ); ?>
		&nbsp;&nbsp;&nbsp;&nbsp; <?php echo stehtmlentities ( $loop[1]['value']['name'] ); ?></td>
	</tr>
	<tr class="product_tr" valign="top">
		<td class="product_icon">
		<div onmouseover="returnescape('<img
			src=\'Images/<?php echo $loop[1]['value']['image']; ?>\'>');"><img
			src="images/<?php echo $loop[1]['value']['icon']; ?>"
			alt="<?php echo $loop[1]['value']['icon']; ?>"
			align="left"></div>
		</td>
		<!-- DESCRIPTION -->
		<td class="product_description">
		<div class="seealsosideinside"><b><?php echo stehtmlentities ( $loop[1]['value']['headline'] ); ?>:</b>
		<ul>
			<?php
if ( is_array ( $loop[1]['value']['description'] ) )
{
$loop[2]['ROWCNT'] = -1;
$loop[2]['ROWCNTHUMAN'] = 0;
foreach ( $loop[1]['value']['description'] as $loop[2]['key'] => $loop[2]['value'] )
{
	$loop[2]['ROWCNT']++;
	$loop[2]['ROWCNTHUMAN']++;
	$loop[2]['value']['ROWCNT']       = $loop[2]['ROWCNT'];
	$loop[2]['value']['ROWCNTHUMAN']  = $loop[2]['ROWCNTHUMAN'];
	$loop[2]['value']['ROWBIT']       = $loop[2]['ROWCNT']%2;
	$loop[2]['value']['ALTROW']       = $loop[2]['ROWCNTHUMAN']%2;
	$loop[2]['value']['CURRENTKEY']   = $loop[2]['key'];
?>
			<li><?php echo stehtmlentities ( $loop[2]['value']['value'] ); ?></li>
			<?php } } ?>
		</ul>
		</div>
		</td>
	</tr>
	<tr class="product_tr" valign="top">
		<td colspan="2"><!-- DOCS -->
		<table
			cellspacing="0"
			cellpadding="0"
			style="width: 600px; border-width: 0px">
			<tr valign="top">
				<td style="width: 300px;"><?php if ( $loop[1]['value']['conformity'] > "" ) { ?>
				<div
					class="seealsosideinside"
					style="width: 300px"><i><b><?php echo stehtmlentities ( $loop[1]['value']['langtext']['conformity'] ); ?>:</b></i>
				<ul>
					<?php
if ( is_array ( $loop[1]['value']['conformity'] ) )
{
$loop[2]['ROWCNT'] = -1;
$loop[2]['ROWCNTHUMAN'] = 0;
foreach ( $loop[1]['value']['conformity'] as $loop[2]['key'] => $loop[2]['value'] )
{
	$loop[2]['ROWCNT']++;
	$loop[2]['ROWCNTHUMAN']++;
	$loop[2]['value']['ROWCNT']       = $loop[2]['ROWCNT'];
	$loop[2]['value']['ROWCNTHUMAN']  = $loop[2]['ROWCNTHUMAN'];
	$loop[2]['value']['ROWBIT']       = $loop[2]['ROWCNT']%2;
	$loop[2]['value']['ALTROW']       = $loop[2]['ROWCNTHUMAN']%2;
	$loop[2]['value']['CURRENTKEY']   = $loop[2]['key'];
?>
					<li><img
						src="Images/Other/pdf2.png"
						alt="PDFICON"
						style="width: 19px; height: 18px; vertical-align:middle"><a
						href="Documents/Conformity/<?php echo $loop[2]['value']['path']; ?>"><?php echo stehtmlentities ( $loop[2]['value']['name'] ); ?></a></li>
					<?php } } ?>
				</ul>
				</div>
				<?php } ?> <?php if ( $loop[1]['value']['datasheet'] > "" ) { ?>
				<div
					class="seealsosideinside"
					style="width: 300px;"><i><b><?php echo stehtmlentities ( $loop[1]['value']['langtext']['datasheet'] ); ?>:</b></i>
				<ul>
					<?php
if ( is_array ( $loop[1]['value']['datasheet'] ) )
{
$loop[2]['ROWCNT'] = -1;
$loop[2]['ROWCNTHUMAN'] = 0;
foreach ( $loop[1]['value']['datasheet'] as $loop[2]['key'] => $loop[2]['value'] )
{
	$loop[2]['ROWCNT']++;
	$loop[2]['ROWCNTHUMAN']++;
	$loop[2]['value']['ROWCNT']       = $loop[2]['ROWCNT'];
	$loop[2]['value']['ROWCNTHUMAN']  = $loop[2]['ROWCNTHUMAN'];
	$loop[2]['value']['ROWBIT']       = $loop[2]['ROWCNT']%2;
	$loop[2]['value']['ALTROW']       = $loop[2]['ROWCNTHUMAN']%2;
	$loop[2]['value']['CURRENTKEY']   = $loop[2]['key'];
?>
					<li><img
						src="Images/Other/pdf2.png"
						alt="PDFICON"
						style="width: 19px; height: 18px; vertical-align: middle;"><a
						href="Documents/Datasheet/<?php echo $loop[2]['value']['path']; ?>"><?php echo stehtmlentities ( $loop[2]['value']['name'] ); ?></a></li>
					<?php } } ?>
				</ul>
				</div>
				<?php } ?> <?php if ( $loop[1]['value']['manual'] > "" ) { ?>
				<div
					class="seealsosideinside"
					style="width: 300px;"><i><b><?php echo stehtmlentities ( $loop[1]['value']['langtext']['handbuch'] ); ?>:</b></i>
				<ul>
					<?php
if ( is_array ( $loop[1]['value']['manual'] ) )
{
$loop[2]['ROWCNT'] = -1;
$loop[2]['ROWCNTHUMAN'] = 0;
foreach ( $loop[1]['value']['manual'] as $loop[2]['key'] => $loop[2]['value'] )
{
	$loop[2]['ROWCNT']++;
	$loop[2]['ROWCNTHUMAN']++;
	$loop[2]['value']['ROWCNT']       = $loop[2]['ROWCNT'];
	$loop[2]['value']['ROWCNTHUMAN']  = $loop[2]['ROWCNTHUMAN'];
	$loop[2]['value']['ROWBIT']       = $loop[2]['ROWCNT']%2;
	$loop[2]['value']['ALTROW']       = $loop[2]['ROWCNTHUMAN']%2;
	$loop[2]['value']['CURRENTKEY']   = $loop[2]['key'];
?>
					<li><img
						src="Images/Other/pdf2.png"
						alt="PDFICON"
						style="width: 19px; heigth: 18px; vertical-align:middle;"><a
						href="Documents/Manual/<?php echo $loop[2]['value']['path']; ?>"><?php echo stehtmlentities ( $loop[2]['value']['name'] ); ?></a></li>
					<?php } } ?>
				</ul>
				</div>
				<?php } ?></td>
				<td style="width: 300px; border-left: 1px solid #000000;"><?php if ( $loop[1]['value']['otherdoc'] > "" ) { ?>
				<div
					class="seealsosideinside"
					style="width: 300px;"><i><b><?php echo stehtmlentities ( $loop[1]['value']['langtext']['otherdoc'] ); ?>:</b></i>
				<ul>
					<?php
if ( is_array ( $loop[1]['value']['otherdoc'] ) )
{
$loop[2]['ROWCNT'] = -1;
$loop[2]['ROWCNTHUMAN'] = 0;
foreach ( $loop[1]['value']['otherdoc'] as $loop[2]['key'] => $loop[2]['value'] )
{
	$loop[2]['ROWCNT']++;
	$loop[2]['ROWCNTHUMAN']++;
	$loop[2]['value']['ROWCNT']       = $loop[2]['ROWCNT'];
	$loop[2]['value']['ROWCNTHUMAN']  = $loop[2]['ROWCNTHUMAN'];
	$loop[2]['value']['ROWBIT']       = $loop[2]['ROWCNT']%2;
	$loop[2]['value']['ALTROW']       = $loop[2]['ROWCNTHUMAN']%2;
	$loop[2]['value']['CURRENTKEY']   = $loop[2]['key'];
?>
					<li><img
						src="Images/Other/pdf2.png"
						alt="PDFICON"
						style="width: 19px; height: 18px;
						vertical-align:middle"><a
						href="Documents/Otherdoc/<?php echo $loop[2]['value']['path']; ?>"><?php echo stehtmlentities ( $loop[2]['value']['name'] ); ?></a></li>
					<?php } } ?>
				</ul>
				</div>
				<?php } ?> <?php if ( $loop[1]['value']['linkto'] > "" ) { ?>
				<div
					class="seealsosideinside"
					style="width: 300px;"><i><b><?php echo stehtmlentities ( $loop[1]['value']['langtext']['siehe_auch'] ); ?>:</b></i>
				<ul>
					<?php
if ( is_array ( $loop[1]['value']['linkto'] ) )
{
$loop[2]['ROWCNT'] = -1;
$loop[2]['ROWCNTHUMAN'] = 0;
foreach ( $loop[1]['value']['linkto'] as $loop[2]['key'] => $loop[2]['value'] )
{
	$loop[2]['ROWCNT']++;
	$loop[2]['ROWCNTHUMAN']++;
	$loop[2]['value']['ROWCNT']       = $loop[2]['ROWCNT'];
	$loop[2]['value']['ROWCNTHUMAN']  = $loop[2]['ROWCNTHUMAN'];
	$loop[2]['value']['ROWBIT']       = $loop[2]['ROWCNT']%2;
	$loop[2]['value']['ALTROW']       = $loop[2]['ROWCNTHUMAN']%2;
	$loop[2]['value']['CURRENTKEY']   = $loop[2]['key'];
?>
					<li><a href="<?php echo $loop[2]['value']['link']; ?>"><?php echo stehtmlentities ( $loop[2]['value']['name'] ); ?></a></li>
					<?php } } ?>
				</ul>
				</div>
				<?php } ?></td>
			</tr>
		</table>
		</td>
	</tr>
	<?php } } ?>
	<tr>
		<td colspan="2" style="height: 400px">&nbsp;</td>
	</tr>
</table>
</div>
