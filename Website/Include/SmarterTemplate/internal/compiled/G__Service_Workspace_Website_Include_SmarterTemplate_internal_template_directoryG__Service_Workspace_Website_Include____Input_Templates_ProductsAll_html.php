<?php
require_once "G:/Service/Workspace/Website/Include/SmarterTemplate/internal/extensions/resetheader.php";

?><?php $TIME_GENERATED = round(microtime (), 4); ?><link
	href="Stylesheet/ProductsAll.css"
	rel="stylesheet"
	type="text/css"
	media="screen, projection, print">
<div
	class="index_content"
	id="index_content">
<table class="products_all">
	<tr class="products_all">
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
		<td class="products_all"><a href="<?php echo $loop[1]['value']['linkToProduct']; ?>"><?php echo $loop[1]['value']['name']; ?></a> - (<?php echo $loop[1]['value']['category']; ?>)</td>
		<?php echo steresetheader ( $loop[1]['value']['ROWCNT'],"3","</tr><tr class='products_all'>" ); ?>
		<?php } } ?>
	</tr>
</table>
</div>
