<?php
require_once "G:/Service/Workspace/Website/Include/SmarterTemplate/internal/extensions/htmlentities.php";

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
		<td colspan="2"><a href="_news_<?php echo $loop[0]['value']['language']; ?>.html"><?php echo stehtmlentities ( $loop[0]['value']['langtext']['news'] ); ?></a></td>
	</tr>
	<!-- NEWSMENU -->
	<tr class="menu">
		<td>&nbsp;</td>
		<td><?php echo $loop[0]['value']['menu']['newsmenu']; ?></td>
	</tr>
	<!-- PRODUCTS -->
	<tr class="menu">
		<td colspan="2"><a href="_products_all_<?php echo $loop[0]['value']['language']; ?>.html"><?php echo stehtmlentities ( $loop[0]['value']['langtext']['products_all'] ); ?></a></td>
	</tr>
	<tr class="menu">
		<td>&nbsp;</td>
		<td><?php echo $loop[0]['value']['menu']['categories']; ?></td>
	</tr>
	<!-- DOCUMENTS -->
	<tr class="menu">
		<td colspan="2"><a
			href="_products_documents_conformity_<?php echo $loop[0]['value']['language']; ?>.html"><?php echo stehtmlentities ( $loop[0]['value']['langtext']['documents_conformity'] ); ?></a></td>
	</tr>
	<tr class="menu">
		<td colspan="2"><a href="_products_documents_manual_<?php echo $loop[0]['value']['language']; ?>.html"><?php echo stehtmlentities ( $loop[0]['value']['langtext']['documents_manual'] ); ?></a></td>
	</tr>
	<tr class="menu">
		<td colspan="2"><a href="_products_documents_otherdoc_<?php echo $loop[0]['value']['language']; ?>.html"><?php echo stehtmlentities ( $loop[0]['value']['langtext']['documents_other'] ); ?></a></td>
	</tr>
	<tr class="menu">
		<td colspan="2"><a href="_contacts_<?php echo $loop[0]['value']['language']; ?>.html"><?php echo stehtmlentities ( $loop[0]['value']['langtext']['contact'] ); ?></a></td>
	</tr>
	<tr class="menu">
		<td colspan="2"><a href="_impressum_<?php echo $loop[0]['value']['language']; ?>.html"><?php echo stehtmlentities ( $loop[0]['value']['langtext']['imprint'] ); ?></a></td>
	</tr>
</table>
