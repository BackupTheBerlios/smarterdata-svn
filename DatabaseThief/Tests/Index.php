<?php
require_once str_replace('\\', '/', dirname(__FILE__)) . '/../Include.php';
require_once str_replace('\\', '/', dirname(__FILE__)) . '/Config.php';
$Data= new DatabaseThief('mysql');
$Data->Connect($DatabaseHost, $DatabasePort, $DatabaseName, 'root', 'samtron');
$Databases= $Data->ListDatabases();
if ($Databases === null)
{
	echo 'No databases<br>';
}
else
{
	foreach ($Databases as $Database)
	{
		echo '<hr align="left" style="width: 50px">';
		echo 'DB: ' . $Database[0] . '<br>';
		#continue;
		$Tables= $Data->ListTables($Database[0]);
		if ($Tables === null)
		{
			echo 'no tables<br>';
		}
		else
		{
			foreach ($Tables as $Table)
			{
				echo '<hr align="left" style="width: 60px">';
				echo 'Table: ' . $Table[0] . '<br>';
				$Fields= $Data->ListFields($Database[0], $Table[0]);
				if ($Fields === null)
				{
					echo 'No Fields<br>';
				}
				else
				{
					foreach ($Fields as $Field)
					{
						echo '<hr align="left" style="width: 70px">';
						echo 'Field name: '.$Field['Field'].'<br>';
						echo 'Field type: '.$Field['Type'].'<br>';
						echo 'Field NULL: '.$Field['Null'].'<br>';
						echo 'Field KEY: '.$Field['Key'].'<br>';
						echo 'Field Default: '.$Field['Default'].'<br>';
						echo 'Field Extra: '.$Field['Extra'].'<br>';
					}
				}
			}
		}
	}
}
?>