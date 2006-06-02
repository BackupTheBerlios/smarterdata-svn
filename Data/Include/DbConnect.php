<?php
class DbConnect
{
	private static $DatabaseConnection;
	/**
	 * Constructor
	 * 
	 * @access protected
	 */
	protected function __construct()
	{
	}
	/**
	 * Destructor
	 * 
	 * @access protected
	 */
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
			catch (Exception $Error)
			{
				self :: SendError(__FUNCTION__, 'While connecting to database', $Error->GetMessage());
			}
		}
		return self :: $DatabaseConnection[$ConnectionString];
	}
	/**
	 * Disconnect
	 * 
	 * @access public
	 * @param string $DatabaseHost
	 * @param int $DatabasePort
	 * @param string $DatabaseName
	 * @param string $DatabaseUserName
	 * @param string $DatabaseUserPassword
	 */
	public static function Disconnect($DatabaseHost, $DatabasePort, $DatabaseName, $DatabaseUserName, $DatabaseUserPassword)
	{
		$ConnectionString= self :: CreateConnectionstring($DatabaseHost, $DatabasePort, $DatabaseName, $DatabaseUserName, $DatabaseUserPassword);
		self :: $DatabaseConnection[$ConnectionString]= null;
	}
	/**
	 * Create a connectionstring
	 * 
	 * @access private
	 * @param string $DatabaseHost
	 * @param int $DatabasePort
	 * @param string $DatabaseName
	 * @param string $DatabaseUserName
	 * @param string $DatabaseUserPassword
	 */
	private static function CreateConnectionstring($DatabaseHost, $DatabasePort, $DatabaseName, $DatabaseUserName, $DatabaseUserPassword)
	{
		$ConnectionString= 'mysql:';
		$ConnectionString .= 'host=' . $DatabaseHost;
		$ConnectionString .= ';port=' . $DatabasePort;
		$ConnectionString .= ';dbname=' . $DatabaseName;
		return $ConnectionString;
	}
	/**
	 * Throw a new exception
	 * 
	 * @access protected
	 * @param string $Method
	 * @param string $Action
	 * @param mixed $Error
	 */
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