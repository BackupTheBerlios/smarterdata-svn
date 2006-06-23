<?php $TIME_GENERATED = round(microtime (), 4); ?><link
	href="Stylesheet/Menu.css"
	rel="stylesheet"
	type="text/css"
	media="screen, projection, print">
<table style="width: 200px;">
	<!-- ABOUTUS -->
	<tr class="aboutuslogo">
		<td
			class="aboutuslogo"
			colspan="2"
			align="center"><a href="_aboutus_<?php echo $loop[0]['value']['language']; ?>.html"><img
			src="Images/Other/elbefant.small.png"
			class="aboutuslogo"
			border="0"></a></td>
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
		<td colspan="2"><a href="_products_all_<?php echo $loop[0]['value']['language']; ?>.html"><?php echo $loop[0]['value']['langtext']['products_all']; ?></a></td>
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
