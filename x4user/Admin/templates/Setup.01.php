<?php
foreach ($currentErrors as $error)
{
	echo htmlentities($error) . '<br>';
}
?>
<form action="<?php echo $currentRequestFile; ?>" method="post">
<table>
	<tr>
		<td 
			colspan="2">Database</td>
	</tr>
	<tr>
		<td>Host/IP</td>
		<td><input 
			type="text" 
			name="databaseHost" 
			value="<?php if (isset($_POST['databaseHost'])) echo $_POST['databaseHost']; ?>"></td>
	</tr>
	<tr>
		<td>Username</td>
		<td><input
			type="text"
			name="databaseUsername"
			value="<?php if (isset($_POST['databaseUsername'])) echo $_POST['databaseUsername']; ?>"></td>
	</tr>
	<tr>
		<td>Password</td>
		<td><input
			type="text"
			name="databaseUserpass"
			value="<?php if (isset($_POST['databaseUserpass'])) echo $_POST['databaseUserpass']; ?>"></td>
	</tr>
	<tr>
		<td>Database</td>
		<td><input
			type="text"
			name="databaseName"
			value="<?php if (isset($_POST['databaseName'])) echo $_POST['databaseName']; ?>"></td>
	</tr>
	<tr>
		<td>Prefix</td>
		<td><input
			type="text"
			name="databaseTableprefix"
			value="<?php if (isset($_POST['databaseTableprefix'])) echo $_POST['databaseTableprefix']; ?>"></td>
	</tr>
	<tr>
		<td 
			colspan="2"><input
				type="submit"
				value="Create"></td>
	</tr>
</table>
</form>