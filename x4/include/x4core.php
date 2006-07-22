<?php
class x4core
{
	private static $db;
	private static $dbType;
	private static $dbHost;
	private static $dbUser;
	private static $dbPass;
	private static $dbDatabase;
	private static $isInitialized= false;
	private static $isConnected= false;
	private static $allowChangeInit= true;
	protected function __construct()
	{
	}
	protected function __destruct()
	{
	}
	public static function init()
	{
		if (self :: $allowChangeInit === true)
		{
			session_start();
			self :: $isInitialized= true;
		}
	}
	protected static function isInitialized()
	{
		return self :: $isInitialized;
	}
	public static function connect($dbType, $dbHost, $dbUser, $dbPass, $dbDatabase)
	{
		if (self :: $allowChangeInit === true)
		{
			switch ($dbType)
			{
				case 'mysql' :
					{
						self :: $db= mysql_connect($dbHost, $dbUser, $dbPass);
						if (!mysql_select_db($dbDatabase, self :: $db))
						{
							self :: $isConnected= false;
							throw new exception('Can not use database: ' . $dbDatabase);
						}
						break;
					}
				default :
					{
						self :: $isConnected= false;
						throw new exception('Db not supported: ' . $dbType);
					}
			}
			self :: $isConnected= true;
		}
	}
	protected static function isConnected()
	{
		return self :: $isConnected;
	}
	protected static function setAllowChangeInit($allow= false)
	{
		self :: $allowChangeInit= $allow;
	}
	protected static function & db()
	{
		return self :: $db;
	}
}
?>