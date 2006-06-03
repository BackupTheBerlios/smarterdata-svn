<?php
class Datamanager
{
	protected static $Init = false;
	protected static $Id = array ();
	protected static $Item = array ();
	protected static $Db = null;
	public static function Connect($DatabaseHost, $DatabasePort, $DatabaseName, $DatabaseUserName, $DatabaseUserPassword)
	{
		self :: $Db = DbConnect :: Connect($DatabaseHost, $DatabasePort, $DatabaseName, $DatabaseUserName, $DatabaseUserPassword);
		self :: $Db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	public static function ResetAll()
	{
	}
	public static function & NewData($DataType)
	{
		$DataParentId = 0;
		$DataPosition = 0;
		$DataDate = time();
		$DataId = self :: NewId();
		$QueryData = array ();
		$Query = 'INSERT INTO `td_data` SET ';
		$Query .= ' data_id=?';
		$QueryData[] = $DataId;
		$Query .= ' , data_type=?';
		$QueryData[] = $DataType;
		$Query .= ' , data_parent_id=?';
		$QueryData[] = $DataParentId;
		$Query .= ' , data_position=?';
		$QueryData[] = $DataPosition;
		$Query .= ' , data_date=?';
		$QueryData[] = $DataDate;
		$Pdo = self :: $Db->Prepare($Query);
		$Pdo->Execute($QueryData);
		self :: _CheckStoredMain($DataId, $DataType, $DataParentId, $DataPosition, $DataDate);
		return self :: GetData($DataId);
	}
	protected static function _CheckStoredMain($DataId, $DataType, $DataParentId, $DataPosition, $DataDate)
	{
		$QueryData = array ();
		$Query = 'SELECT COUNT(*) as total FROM `td_data` WHERE ';
		$Query .= ' `data_id`=?';
		$QueryData[] = $DataId;
		$Query .= ' && `data_type`=?';
		$QueryData[] = $DataType;
		$Query .= ' && `data_parent_id`=?';
		$QueryData[] = $DataParentId;
		$Query .= ' && `data_position`=?';
		$QueryData[] = $DataPosition;
		$Query .= ' && `data_date`=?';
		$QueryData[] = $DataDate;
		$Pdo = self :: $Db->Prepare($Query);
		$Pdo->Execute($QueryData);
#		echo '<pre>' . print_r ($Query, 1) . '</pre>';
#		echo '<pre>' . print_r ($QueryData, 1) . '</pre>';
		if (!($Result = $Pdo->Fetch()))
		{
			throw new exception('NewData wrong!');
		}
		if ($Result['total'] != 1)
		{
			throw new exception('NewData wrong');
		}
		$Pdo=null;
	}
	public static function & GetData($DataId)
	{
		if (!isset (self :: $Item[$DataId]))
		{
			$QueryData = array ();
			$QueryData[] = $DataId;
			$Query = 'SELECT data_id,data_type FROM `td_data` WHERE data_id=?';
			$Pdo = self :: $Db->Prepare($Query);
			$Pdo->Execute($QueryData);
			$DataCommon = $Pdo->Fetch();
			$Pdo=null;
			if (!isset ($DataCommon['data_type']))
			{
				throw new exception('DataId does not exist: ' . $DataId);
			}
			$DataType = $DataCommon['data_type'];
			self :: LoadClass($DataType);
			$DataType = 'Data' . $DataCommon['data_type'];
			self :: $Item[$DataId] = new $DataType ($DataId);
		}
		return self :: $Item[$DataId];
	}
	private static function LoadClass($DataType)
	{
		if (!class_exists('Data' . $DataType))
		{
			$Filename = str_replace('\\', '/', dirname(__FILE__)) . '/Datatype/Data' . strtoupper(substr($DataType, 0, 1)) . strtolower(substr($DataType, 1)) . '.php';
			if (!file_exists($Filename))
			{
				throw new exception('Dataclass not found: Data' . $DataType);
			}
			require_once ($Filename);
		}
	}
	private static function NewId($Group = 'default')
	{
		$QueryData = array ();
		$QueryData[] = $Group;
		$Query = 'SELECT * FROM `td_index_id` WHERE id_group=?';
		$Pdo = self :: $Db->Prepare($Query);
		$Pdo->Execute($QueryData);
		if (!($Counter = $Pdo->Fetch()))
		{
			$Counter['id_value'] = 1;
		}
		else
		{
			$Counter['id_value']++;
		}
		$Pdo=null;
		$QueryData=array();
		$Query = 'REPLACE INTO `td_index_id` SET ';
		$Query .= ' id_group=?';
		$QueryData[] = $Group;
		$Query .= ' , id_value=?';
		$QueryData[] = $Counter['id_value'];
		$Pdo = self :: $Db->Prepare($Query);
		$Pdo->Execute($QueryData);
		$Pdo=null;
		self::_CheckNewId($Group, $Counter['id_value']);
		return $Counter['id_value'];
	}
	private static function _CheckNewId($Group, $Value)
	{
		$Query = 'SELECT COUNT(*) AS total FROM `td_index_id` WHERE ';
		$Query .= ' `id_group`=?';
		$QueryData[] = $Group;
		$Query .= '  && `id_value`=?';
		$QueryData[] = $Value;
		$Pdo = self::$Db->Prepare($Query);
		$Pdo->Execute($QueryData);
		if (!($Value = $Pdo->Fetch()))
		{
			throw new exception('Id wrong! 1');
		}
		$Pdo=null;
		if ($Value['total'] != 1)
		{
			throw new exception('Id wrong! 2');
		}
	}
	public static function ResetTableId()
	{
		$Query = 'DROP TABLE IF EXISTS `td_index_id`';
		$Pdo = self :: $Db->Prepare($Query);
		$Pdo->Execute();
		$Pdo=null;
		self :: InitTableId();
	}
	private static function InitTableId()
	{
		$Query = 'CREATE TABLE IF NOT EXISTS `td_index_id` ';
		$Query .= ' ( ';
		$Query .= ' `id_group` CHAR(255) NOT NULL ';
		$Query .= ' ,`id_value` BIGINT(20) NOT NULL ';
		$Query .= ' , unique(`id_group`) ';
		$Query .= ' ) ';
		$Pdo = self :: $Db->Prepare($Query);
		$Pdo->Execute();
		$Pdo=null;
	}
	public static function ResetTableData()
	{
		$Query = 'DROP TABLE IF EXISTS `td_data`';
		$Pdo = self :: $Db->Prepare($Query);
		$Pdo->Execute();
		$Pdo=null;
		self :: InitTableData();
	}
	private static function InitTableData()
	{
		$Query = 'CREATE TABLE IF NOT EXISTS `td_data` ';
		$Query .= ' ( ';
		$Query .= ' `data_id` BIGINT(20) NOT NULL ';
		$Query .= ' ,`data_type` CHAR(255) NOT NULL ';
		$Query .= ' ,`data_parent_id` BIGINT(20) NOT NULL ';
		$Query .= ' ,`data_position` BIGINT(20) NOT NULL ';
		$Query .= ' ,`data_date` CHAR(20) NOT NULL ';
		$Query .= ' , unique(`data_id`) ';
		$Query .= ' ) ';
		$Pdo = self :: $Db->Prepare($Query);
		$Pdo->Execute();
		$Pdo=null;
	}
	public static function ResetTableAttribute()
	{
		$Query = 'DROP TABLE IF EXISTS `td_data_attribute`';
		$Pdo = self :: $Db->Prepare($Query);
		$Pdo->Execute();
		$Pdo=null;
		self :: InitTableAttribute();
	}
	private static function InitTableAttribute()
	{
		$Query = 'CREATE TABLE IF NOT EXISTS `td_data_attribute` ';
		$Query .= ' ( ';
		$Query .= ' `data_id` BIGINT(20) NOT NULL ';
		$Query .= ' ,`attribute_name` CHAR(255) NOT NULL ';
		$Query .= ' ,`attribute_type` CHAR(255) NOT NULL ';
		$Query .= ' ,`attribute_date` CHAR(20) NOT NULL ';
		$Query .= ' ,`attribute_content_text` TEXT NOT NULL ';
		$Query .= ' ,`attribute_content_binary` BLOB NOT NULL ';
		$Query .= ' , unique(`data_id`,`attribute_name`) ';
		$Query .= ' ) ';
		$Pdo = self :: $Db->Prepare($Query);
		$Pdo->Execute();
		$Pdo=null;
	}
	public static function ResetTableValues()
	{
		$Query = 'DROP TABLE IF EXISTS `td_data_value`';
		$Pdo = self :: $Db->Prepare($Query);
		$Pdo->Execute();
		$Pdo=null;
		self :: InitTableValues();
	}
	private static function InitTableValues()
	{
		$Query = 'CREATE TABLE IF NOT EXISTS `td_data_value` ';
		$Query .= ' ( ';
		$Query .= ' `data_id` BIGINT(20) NOT NULL ';
		$Query .= ' ,`value_name` CHAR(255) NOT NULL ';
		$Query .= ' ,`value_type` CHAR(255) NOT NULL ';
		$Query .= ' ,`value_date` CHAR(20) NOT NULL ';
		$Query .= ' ,`value_content_text` TEXT NOT NULL ';
		$Query .= ' ,`value_content_binary` BLOB NOT NULL ';
		$Query .= ' , unique(`data_id`,`value_name`) ';
		$Query .= ' ) ';
		$Pdo = self :: $Db->Prepare($Query);
		$Pdo->Execute();
		$Pdo=null;
	}
}
?>