<?php
/**
 * Verwaltet die Datenbankverbindungen
 * 
 */
class DataConnect
{
	private static $DatabaseConnection;
	protected function __construct()
	{
	}
	protected function __destruct()
	{
	}
	/**
	 * Connect to a database using PHP-PDO
	 *
	 * @access public 
	 * @param string $DatabaseHost
	 * @param int $DatabasePort
	 * @param string $DatabaseName
	 * @param string $DatabaseUserName
	 * @param string $DatabaseUserPassword
	 */
	public static function & Connect($DatabaseHost, $DatabasePort, $DatabaseName, $DatabaseUserName, $DatabaseUserPassword)
	{
		$ConnectionString= self :: CreateConnectionstring($DatabaseHost, $DatabasePort, $DatabaseName, $DatabaseUserName, $DatabaseUserPassword);
		if (!isset (self :: $DatabaseConnection[$ConnectionString]))
		{
			try
			{
				self :: $DatabaseConnection[$ConnectionString]= new Pdo($ConnectionString, $DatabaseUserName, $DatabaseUserPassword);
			}
			catch (exception $Exception)
			{
				throw new exception('Error while connecting to database in DataCore. ' . $Exception->GetMessage());
			}
		}
		return self :: $DatabaseConnection[$ConnectionString];
	}
	public static function Disconnect($DatabaseHost, $DatabasePort, $DatabaseName, $DatabaseUserName, $DatabaseUserPassword)
	{
		$ConnectionString= self :: CreateConnectionstring($DatabaseHost, $DatabasePort, $DatabaseName, $DatabaseUserName, $DatabaseUserPassword);
		self :: $DatabaseConnection[$ConnectionString]= null;
	}
	private static function CreateConnectionstring($DatabaseHost, $DatabasePort, $DatabaseName, $DatabaseUserName, $DatabaseUserPassword)
	{
		$ConnectionString= 'mysql:';
		$ConnectionString .= 'host=' . $DatabaseHost;
		$ConnectionString .= ';port=' . $DatabasePort;
		$ConnectionString .= ';dbname=' . $DatabaseName;
		return $ConnectionString;
	}
}
?>