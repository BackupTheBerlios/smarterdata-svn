<?php $TIME_GENERATED = round(microtime (), 4); ?><link href="Stylesheet/Menu.css" rel="stylesheet" type="text/css" media="screen, projection, print">
<div
	id="menu1"
	style="position:absolute; left:0px; top:110px; z-index:2">
<table style="width: 200px;">
	<tr class="menu">
		<td colspan="2"><img src="Images/Other/new_elbefant.png"></td>
	</tr>
	<!-- ABOUTUS -->
	<tr class="menu">
		<td style="width: 10px">&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr class="menu">
		<td
			class="menutop"
			colspan="2"><a href="_aboutus_<?php echo $loop[0]['value']['language']; ?>.html"><?php echo $loop[0]['value']['langtext']['aboutus']; ?></a></td>
	</tr>
	<!-- NEWS -->
	<tr class="menu">
		<td colspan="2"><a href="_news_<?php echo $loop[0]['value']['language']; ?>.html"><?php echo $loop[0]['value']['langtext']['news']; ?></a></td>
	</tr>
	<!-- NEWSMENU -->
	<tr class="menu">
		<td>&nbsp;</td>
		<td><?php echo $loop[0]['value']['menu']['newsmenu']; ?></td>
	</tr>
	<!-- PRODUCTS -->
	<tr class="menu">
		<td colspan="2"><?php echo $loop[0]['value']['langtext']['products']; ?></td>
	</tr>
	<tr class="menu">
		<td>&nbsp;</td>
		<td><?php echo $loop[0]['value']['menu']['categories']; ?></td>
	</tr>
	<!-- DOCUMENTS -->
	<tr class="menu">
		<td colspan="2"><a
			href="_products_documents_conformity_<?php echo $loop[0]['value']['language']; ?>.html"><?php echo $loop[0]['value']['langtext']['documents_conformity']; ?></td>
	</tr>
	<tr class="menu">
		<td colspan="2"><a href="_products_documents_manual_<?php echo $loop[0]['value']['language']; ?>.html"><?php echo $loop[0]['value']['langtext']['documents_manual']; ?></td>
	</tr>
	<tr class="menu">
		<td colspan="2"><a href="_products_documents_otherdoc_<?php echo $loop[0]['value']['language']; ?>.html"><?php echo $loop[0]['value']['langtext']['documents_other']; ?></td>
	</tr>
</table>
</div>
