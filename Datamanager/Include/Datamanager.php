<?php
class Datamanager
{
	private static $Initialized= false;
	/**
	 * @var string Scripts directory
	 * 
	 * @access protected
	 */
	protected static $Directory= '';
	/**
	 * @var string Database host
	 * 
	 * @access private
	 */
	private static $DatabaseHost= '';
	/**
	 * @var string Database port
	 * 
	 * @access private
	 */
	private static $DatabasePort= '';
	/**
	 * @var string Database name
	 * 
	 * @access private
	 */
	private static $DatabaseName= '';
	/**
	 * @var string Database username
	 * 
	 * @access private
	 */
	private static $DatabaseUserName= '';
	/**
	 * @var string Database userpassword
	 * 
	 * @access private
	 */
	private static $DatabaseUserPassword= '';
	/**
	 * @var int table counter
	 * 
	 * @access private
	 */
	private static $Tablecounter;
	/**
	 * Constructor
	 * 
	 * @access public 
	 */
	public function __construct()
	{
		self :: Initialize();
	}
	/**
	 * Destructor
	 * 
	 * @access public 
	 */
	public function __destruct()
	{
	}
	/**
	 * Initialize all variables
	 * @access public
	 */
	public static function Initialize()
	{
		if (self :: $Initialized === false)
		{
			self :: $Directory= str_replace('\\', '/', dirname(__FILE__));
			self :: InitInternalDirectory();
			self :: InitInternalCounter();
			self :: $Initialized= true;
		}
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
	public static function Connect($DatabaseHost, $DatabasePort, $DatabaseName, $DatabaseUserName, $DatabaseUserPassword)
	{
		self :: CheckInit();
		self :: $DatabaseHost= $DatabaseHost;
		self :: $DatabasePort= $DatabasePort;
		self :: $DatabaseName= $DatabaseName;
		self :: $DatabaseUserName= $DatabaseUserName;
		self :: $DatabaseUserPassword= $DatabaseUserPassword;
	}
	/**
	 * Create new table
	 *  
	 * $Fields = array (
	 *   array (
	 *     'Name' => 'field name',
	 *     'Description' => 'field description',
	 *     'Type' => 'field type (bool,num,line,multiline,file)',
	 *     'UsePredefined' => true|false,
	 *     'Predefined' => array (
	 *       array ( 'Predefined display 1' => 'Predefined send'),
	 *       array ( 'Predefined display 2' => 'Predefined send'),
	 *       ...
	 *     ),
	 *     'PredefinedDefault' => 0..n
	 *   ),
	 *   ...
	 * );
	 * Ist UsePredefined true dann muss der Wert eines Feldes irgendeinem Predefined send entsprechen.
	 * Alles andere ist ungueltig.
	 * @param string $TableName
	 * @param string $TableDescription
	 * @param array $Fields
	 */
	public static function NewTable($TableName, $TableDescription, $Fields)
	{
		self :: CheckInit();
		self :: CheckTableName($TableName);
		self :: CheckFields($Fields);
		self :: CreateQueryNewTable($TableName, $TableDescription, $Fields);
	}
	/**
	 * Initialize internal directory
	 * 
	 * @access private
	 */
	private static function InitInternalDirectory()
	{
		if (!is_dir(self :: $Directory . '/DatamanagerInternal'))
		{
			if (!@ mkdir(self :: $Directory . '/DatamanagerInternal', 0777))
			{
				throw new exception('Can not create directory : ' . self :: $Directory . '/DatamanagerInternal');
			}
		}
	}
	/**
	 * Initialize internal counter
	 * 
	 * @access private
	 */
	private static function InitInternalCounter()
	{
		if (is_file(self :: $Directory . '/DatamanagerInternal/Tablecounter'))
		{
			self :: $Tablecounter= (int) trim(implode('', file(self :: $Directory . '/DatamanagerInternal/Tablecounter')));
		}
		else
		{
			$Tablecounter= @ fopen(self :: $Directory . '/DatamanagerInternal/Tablecounter', 'w');
			if (!$Tablecounter)
			{
				throw new exception('Can not create file : ' . self :: $Directory . '/DatamanagerInternal/Tablecounter');
			}
			fputs($Tablecounter, 0);
			fclose($Tablecounter);
			self :: $Tablecounter= 0;
		}
	}
	/**
	 * Check the table name
	 * 
	 * @access private
	 * @param string $TableName
	 */
	private static function CheckTableName($TableName)
	{
		if (!preg_match('/^([a-zA-Z _-]{1,})$/', $TableName))
		{
			throw new exception('Bad tablename : ' . $TableName);
		}
	}
	/**
	 * Check all fields
	 * 
	 * @access private
	 * @param array $Fields
	 */
	private static function CheckFields($Fields)
	{
		foreach ($Fields as $FieldKey => $Field)
		{
			self :: CheckFieldName($FieldKey, $Field);
			self :: CheckFieldType($FieldKey, $Field);
			self :: CheckFieldPredefined($FieldKey, $Field);
		}
	}
	/**
	 * Check the field name
	 * 
	 * @access private
	 * @param int $FieldKey
	 * @param array $Field
	 */
	private static function CheckFieldName($FieldKey, $Field)
	{
		if (!preg_match('/^([0-9a-zA-Z _-]{1,})$/', $Field['Name']))
		{
			throw new exception('Field ' . $FieldKey . ', Bad name : ' . $Field['Name']);
		}
	}
	/**
	 * Check the field type
	 * 
	 * @access private
	 * @param int $FieldKey
	 * @param array $Field
	 */
	private static function CheckFieldType($FieldKey, $Field)
	{
		switch ($Field['Type'])
		{
			case 'bool' :
				return 'CHAR (1)';
			case 'num' :
				return 'BIGINT';
			case 'line' :
				return 'CHAR(255)';
			case 'multiline' :
				return 'TEXT';
			case 'file' :
				return 'CHAR(255)';
			default :
				throw new exception('Field ' . $FieldKey . ', Field type not supported : ' . $Field['Type']);
		}
	}
	/**
	 * Check for predefined information
	 * 
	 * @access private
	 * @param int $FieldKey
	 * @param array $Field
	 */
	private static function CheckFieldPredefined($FieldKey, $Field)
	{
		if ($Field['UsePredefined'] === true)
		{
			if (!is_array($Field['Predefined']))
			{
				throw new exception('Field ' . $FieldKey . ', To use predefined define anything ;)');
			}
			if (!is_numeric($Field['PredefinedDefault']))
			{
				throw new exception('Field ' . $FieldKey . ', Use a number from 0 to ' . sizeof($Field['Predefined']) . ' to define a default predefined content');
			}
			if (sizeof($Field['Predefined']) < $Field['PredefinedDefault'] || $Field['PredefinedDefault'] < 0)
			{
				throw new exception('Field ' . $FieldKey . ', Default predefined content does not exist : ' . $Field['PredefinedDefault']);
			}
		}
	}
	private static function CheckInit()
	{
		if (self :: $Initialized !== true)
		{
			throw new exception('Uninitialized');
		}
	}
	private static function CreateQueryNewTable($TableName, $TableDescription, $Fields)
	{
		$Query= '';
		foreach ($Fields as $FieldKey => $Field)
		{
			$Query .= ',`' . $Field['Name'] . '` ';
			$Query .= self :: CheckFieldType($FieldKey, $Field);
		}
		$Query= 'CREATE TABLE IF NOT EXISTS ' . $TableName . ' (' . substr($Query, 1).')';
		echo $Query;
		
	}
	private static function GetFieldType($Field)
	{
	}
}
?>