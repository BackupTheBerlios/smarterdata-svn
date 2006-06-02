<?php
class Data
{
	protected static $Init= false;
	protected static $Id= array ();
	protected static $Item= array ();
	public function __construct($DataId= 0)
	{
	}
	public function __destruct()
	{
	}
	public function SortChildren($Sorting= array (
		'position' => 'ASC'
	))
	{
	}
	public static function NewData($DataType, $DataAttributes= null, $DataValues= null)
	{
	}
	protected static function NewId($Group= 'item')
	{
	}
	private static function ResetTableValues()
	{
		$Query= 'DROP TABLE IF EXISTS `td_index_id`';
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
	}
	private static function ResetTableValues()
	{
		$Query= 'DROP TABLE IF EXISTS `td_data`';
		self :: InitTableData();
	}
	private static function InitTableData()
	{
		$Query= 'CREATE TABLE IF NOT EXISTS `td_data` ';
		$Query .= ' ( ';
		$Query .= ' `data_id` BIGINT(20) NOT NULL ';
		$Query .= ' ,`data_parent_id` BIGINT(20) NOT NULL ';
		$Query .= ' ,`data_position` BIGINT(20) NOT NULL ';
		$Query .= ' ,`data_date` CHAR(20) NOT NULL ';
		$Query .= ' , unique(`data_id`) ';
		$Query .= ' ) ';
	}
	private static function ResetTableAttribute()
	{
		$Query= 'DROP TABLE IF EXISTS `td_data_attribute`';
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
	}
	private static function ResetTableValues()
	{
		$Query= 'DROP TABLE IF EXISTS `td_data_value`';
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
	}
}
?>