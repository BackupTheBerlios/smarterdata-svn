<?php $TIME_GENERATED = round(microtime (), 4); ?><table width="100%">
	<!-- ABOUTUS -->
	<tr>
		<td><a href="_aboutus_<?php echo $loop[0]['value']['language']; ?>.html"><?php echo $loop[0]['value']['langtext']['aboutus']; ?></a></td>
	</tr>
	<!-- NEWS -->
	<tr>
		<td><a href="_news_<?php echo $loop[0]['value']['language']; ?>.html"><?php echo $loop[0]['value']['langtext']['news']; ?></a></td>
	</tr>
	<!-- NEWSMENU -->
	<tr>
		<td><?php echo $loop[0]['value']['menu']['newsmenu']; ?></td>
	</tr>
	<!-- PRODUCTS -->
	<tr>
		<td><?php echo $loop[0]['value']['langtext']['products']; ?></td>
	</tr>
	<tr>
		<td><?php echo $loop[0]['value']['menu']['categories']; ?></td>
	</tr>
</table>
