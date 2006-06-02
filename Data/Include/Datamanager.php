<?php
class Data
{
	protected static $Init= false;
	protected static $Id= array ();
	protected static $Item= array ();
	public static function ResetAll()
	{
	}
	public static function & NewData($DataType)
	{
		$DataId= self :: NewId();
		$QueryData= array ();
		$Query= 'INSERT INTO `td_data` SET ';
		$Query .= ' `data_id`=?';
		$QueryData[]= $DataId;
		$Query .= ' , `data_type`=?';
		$QueryData[]= $DataType;
		$Pdo= self :: $Db->Prepare($Query);
		$Pdo->Execute($QueryData);
		return self :: GetData($DataId);
	}
	public static function RemoveData($DataId)
	{
	}
	public static function & GetData($DataId)
	{
		if (!isset (self :: $Item[$DataId]))
		{
			$QueryData= array ();
			$QueryData[]= $DataId;
			$Query= 'SELECT data_id,data_type FROM `td_data` WHERE data_id=?';
			$Pdo= self :: $Db->Prepare($Query);
			$Pdo->Execute($QueryData);
			$DataCommon= $Pdo->Fetch();
			if (!isset ($DataCommon['data_type']))
			{
				throw new exception('DataId does not exist: ' . $DataId);
			}
			$DataType= $DataCommon['data_type'];
			self :: LoadClass($DataType);
			$DataType= 'Data' . $DataCommon['data_type'];
			self :: $Item[$DataId]= new $DataType ($DataId);
		}
		return self :: $Item[$DataId];
	}
	private static function LoadClass($DataType)
	{
		if (!class_exists('Data' . $DataType))
		{
			$Filename= str_replace('\\', '/', dirname(__FILE__)) . '/Datatype/Data' . strtoupper(substr($DataType, 0, 1)) . strtolower(substr($DataType, 1)) . '.php';
			if (!file_exists($Filename))
			{
				throw new exception('Dataclass not found: Data' . $DataType);
			}
			require_once ($Filename);
		}
	}
	private static function NewId($Group= 'default')
	{
		$QueryData= array ();
		$QueryData[]= $Group;
		$Query= 'SELECT * FROM `td_index_id` WHERE id_group=?';
		$Pdo->Prepare($Query);
		$Pdo->Execute();
		if(!($Counter=$Pdo->Fetch()))
		{
			$Counter['id_value'] = 1;
		}
		else
		{
			$Counter['id_value']++;
		}
		$Query = 'REPLACE INTO `td_index_id` SET ';
		$Query .= ' id_value';
	}
	private static function ResetTableValues()
	{
		$Query= 'DROP TABLE IF EXISTS `td_index_id`';
		$Pdo->Prepare($Query);
		$Pdo->Execute();
		self :: InitTableId();
	}
	private static function InitTableId()
	{
		$Query= 'CREATE TABLE IF NOT EXISTS `td_index_id` ';
		$Query .= ' ( ';
		$Query .= ' `id_group` CHAR(255) NOT NULL ';
		$Query .= ' ,`id_value` BIGINT(20) NOT NULL ';
		$Query .= ' , unique(`id_group`) ';
		$Query .= ' ) ';
		$Pdo->Prepare($Query);
		$Pdo->Execute();
	}
	private static function ResetTableValues()
	{
		$Query= 'DROP TABLE IF EXISTS `td_data`';
		$Pdo->Prepare($Query);
		$Pdo->Execute();
		self :: InitTableData();
	}
	private static function InitTableData()
	{
		$Query= 'CREATE TABLE IF NOT EXISTS `td_data` ';
		$Query .= ' ( ';
		$Query .= ' `data_id` BIGINT(20) NOT NULL ';
		$Query .= ' ,`data_type` CHAR(255) NOT NULL ';
		$Query .= ' ,`data_parent_id` BIGINT(20) NOT NULL ';
		$Query .= ' ,`data_position` BIGINT(20) NOT NULL ';
		$Query .= ' ,`data_date` CHAR(20) NOT NULL ';
		$Query .= ' , unique(`data_id`) ';
		$Query .= ' ) ';
		$Pdo->Prepare($Query);
		$Pdo->Execute();
	}
	private static function ResetTableAttribute()
	{
		$Query= 'DROP TABLE IF EXISTS `td_data_attribute`';
		$Pdo->Prepare($Query);
		$Pdo->Execute();
		self :: InitTableAttribute();
	}
	private static function InitTableAttribute()
	{
		$Query= 'CREATE TABLE IF NOT EXISTS `td_data_attribute` ';
		$Query .= ' ( ';
		$Query .= ' `data_id` BIGINT(20) NOT NULL ';
		$Query .= ' ,`attribute_type` CHAR(255) NOT NULL ';
		$Query .= ' ,`attribute_date` CHAR(20) NOT NULL ';
		$Query .= ' ,`attribute_content_text` TEXT NOT NULL ';
		$Query .= ' ,`attribute_content_binary` BLOB NOT NULL ';
		$Query .= ' , index(`data_id`,`attribute_type`) ';
		$Query .= ' ) ';
		$Pdo->Prepare($Query);
		$Pdo->Execute();
	}
	private static function ResetTableValues()
	{
		$Query= 'DROP TABLE IF EXISTS `td_data_value`';
		$Pdo->Prepare($Query);
		$Pdo->Execute();
		self :: InitTableValues();
	}
	private static function InitTableValues()
	{
		$Query= 'CREATE TABLE IF NOT EXISTS `td_data_value` ';
		$Query .= ' ( ';
		$Query .= ' `data_id` BIGINT(20) NOT NULL ';
		$Query .= ' ,`value_type` CHAR(255) NOT NULL ';
		$Query .= ' ,`value_date` CHAR(20) NOT NULL ';
		$Query .= ' ,`value_content_text` TEXT NOT NULL ';
		$Query .= ' ,`value_content_binary` BLOB NOT NULL ';
		$Query .= ' , index(`data_id`,`value_type`) ';
		$Query .= ' ) ';
		$Pdo->Prepare($Query);
		$Pdo->Execute();
	}
}
?>