<?php
require_once "F:/Service/Workspace/Website/Include/SmarterTemplate/internal/extensions/htmlentities.php";
require_once "F:/Service/Workspace/Website/Include/SmarterTemplate/internal/extensions/current_date.php";
require_once "F:/Service/Workspace/Website/Include/SmarterTemplate/internal/extensions/current_time.php";

?><?php $TIME_GENERATED = round(microtime (), 4); ?><table style="width: 200px;">
	<!-- ABOUTUS -->
	<tr class="aboutuslogo">
		<td
			class="aboutuslogo"
			colspan="2"
			align="center"><a href="_aboutus_<?php echo $loop[0]['value']['language']; ?>.html"><img
			src="Images/Other/elbefant.small.png"
			alt="LOGO"
			class="aboutuslogo"
			style="border-width: 0px"></a></td>
	</tr>
	<!-- NEWS -->
	<tr class="menu">
		<td colspan="2"><a href="_news_<?php echo $loop[0]['value']['language']; ?>.html" style="font-weight: bold"><?php echo stehtmlentities ( $loop[0]['value']['langtext']['news'] ); ?></a></td>
	</tr>
	<!-- NEWSMENU -->
	<tr class="menu">
		<td style="width: 10px">&nbsp;</td>
		<td style="width: 190px"><?php echo $loop[0]['value']['menu']['newsmenu']; ?></td>
	</tr>
	<!-- PRODUCTS -->
	<tr class="menu">
		<td colspan="2"><a href="_products_all_<?php echo $loop[0]['value']['language']; ?>.html" style="font-weight: bold"><?php echo stehtmlentities ( $loop[0]['value']['langtext']['products_all'] ); ?></a></td>
	</tr>
	<tr class="menu">
		<td>&nbsp;</td>
		<td><div 
				class="div_product_show" 
				name="product_show"
				id="product_show"><i>
				<a href="#" onclick="
					hide('product_show');
					show('product_hide','inline');
					show('product_menu', 'block');"><?php echo stehtmlentities ( $loop[0]['value']['langtext']['show_productcategories'] ); ?></a>
			</i></div>
			<div 
				class="div_product_hide" 
				name="product_hide" 
				id="product_hide"><i>
				<a href="#" onclick="
					show('product_show', 'inline');
					hide('product_hide');
					hide('product_menu');"><?php echo stehtmlentities ( $loop[0]['value']['langtext']['hide_productcategories'] ); ?></a>
			</i></div>
			<div 
				class="div_product_menu" 
				name="product_menu" 
				id="product_menu"><?php echo $loop[0]['value']['menu']['categories']; ?></div>
		</td>
	</tr>
	<!-- DOCUMENTS -->
	<tr class="menu">
		<td colspan="2"><a
			href="_products_documents_conformity_<?php echo $loop[0]['value']['language']; ?>.html" style="font-weight: bold"><?php echo stehtmlentities ( $loop[0]['value']['langtext']['documents_conformity'] ); ?></a></td>
	</tr>
	<tr class="menu">
		<td colspan="2"><a href="_products_documents_manual_<?php echo $loop[0]['value']['language']; ?>.html" style="font-weight: bold"><?php echo stehtmlentities ( $loop[0]['value']['langtext']['documents_manual'] ); ?></a></td>
	</tr>
	<tr class="menu">
		<td colspan="2"><a href="_products_documents_otherdoc_<?php echo $loop[0]['value']['language']; ?>.html" style="font-weight: bold"><?php echo stehtmlentities ( $loop[0]['value']['langtext']['documents_other'] ); ?></a></td>
	</tr>
	<tr class="menu">
		<td colspan="2"><a href="_contacts_<?php echo $loop[0]['value']['language']; ?>.html" style="font-weight: bold"><?php echo stehtmlentities ( $loop[0]['value']['langtext']['contact'] ); ?></a></td>
	</tr>
	<tr class="menu">
		<td colspan="2"><a href="_impressum_<?php echo $loop[0]['value']['language']; ?>.html" style="font-weight: bold"><?php echo stehtmlentities ( $loop[0]['value']['langtext']['imprint'] ); ?></a></td>
	</tr>
	<tr class="menu_last_changes">
		<td colspan="2"><?php echo stehtmlentities ( $loop[0]['value']['langtext']['last_changes'] ); ?> <?php echo stecurrent_date (  ); ?>, <?php echo stecurrent_time (  ); ?></td>
	</tr>
</table>