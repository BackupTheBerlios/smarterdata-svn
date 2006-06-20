<?php $TIME_GENERATED = round(microtime (), 4); ?><style>
tr.menu
{
	background-color: #FFFFFF;
	border-bottom: 1px solid #000000;
	font-family: verdana;
	font-size: 11px;
	border-collapse: collapse;
	margin: 0px;
	padding: 0px;
}
</style>
<table width="100%">
	<!-- ABOUTUS -->
	<tr class="menu">
		<td><a href="_aboutus_<?php echo $loop[0]['value']['language']; ?>.html"><?php echo $loop[0]['value']['langtext']['aboutus']; ?></a></td>
	</tr>
	<!-- NEWS -->
	<tr class="menu">
		<td><a href="_news_<?php echo $loop[0]['value']['language']; ?>.html"><?php echo $loop[0]['value']['langtext']['news']; ?></a></td>
	</tr>
	<!-- NEWSMENU -->
	<tr class="menu">
		<td><?php echo $loop[0]['value']['menu']['newsmenu']; ?></td>
	</tr>
	<!-- PRODUCTS -->
	<tr class="menu">
		<td><?php echo $loop[0]['value']['langtext']['products']; ?></td>
	</tr>
	<tr class="menu">
		<td><?php echo $loop[0]['value']['menu']['categories']; ?></td>
	</tr>
	<!-- DOCUMENTS -->
	<tr class="menu">
		<td><a href="_products_documents_conformity_<?php echo $loop[0]['value']['language']; ?>.html"><?php echo $loop[0]['value']['langtext']['documents_conformity']; ?></td>
	</tr>
	<tr class="menu">
		<td><a href="_products_documents_manual_<?php echo $loop[0]['value']['language']; ?>.html"><?php echo $loop[0]['value']['langtext']['documents_manual']; ?></td>
	</tr>
	<tr class="menu">
		<td><a href="_products_documents_otherdoc_<?php echo $loop[0]['value']['language']; ?>.html"><?php echo $loop[0]['value']['langtext']['documents_other']; ?></td>
	</tr>
</table>
