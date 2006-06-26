<?php
class LhPdo
{
	private static $DatabaseConnection;
	protected function __construct()
	{
	}
	protected function __destruct()
	{
	}
	public static function & Connect($DatabaseHost, $DatabasePort, $DatabaseName, $DatabaseUserName, $DatabaseUserPassword)
	{
		$ConnectionString= self :: CreateConnectionstring($DatabaseHost, $DatabasePort, $DatabaseName, $DatabaseUserName, $DatabaseUserPassword);
		if (!isset (self :: $DatabaseConnection[$ConnectionString]))
		{
			try
			{
				self :: $DatabaseConnection[$ConnectionString]= new Pdo($ConnectionString, $DatabaseUserName, $DatabaseUserPassword);
			}
			catch (Exception $Error)
			{
				self :: SendError(__FUNCTION__, 'While connecting to database', $Error->GetMessage());
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
	private static function SendError($Method, $Action, $Error)
	{
		$Message= 'Class: DbConnect';
		$Message .= "\n";
		$Message .= 'Method: ' . $Method;
		$Message .= "\n";
		$Message .= 'Action: ' . $Action;
		$Message .= "\n";
		$Message .= 'Error: <pre>' . print_r($Error, 1) . '</pre>';
		$Message .= "\n";
		throw new exception($Message);
	}
}
?>