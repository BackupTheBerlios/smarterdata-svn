<?php
class DbCounter
{
	private static function NewCounter($Group = 'default')
	{
		$QueryData = array ();
		$QueryData[] = $Group;
		$Query = 'SELECT * FROM `td_index_counter` WHERE counter_group=?';
		$Pdo = self :: $Db->Prepare($Query);
		$Pdo->Execute($QueryData);
		if (!($Counter = $Pdo->Fetch()))
		{
			$Counter['counter_value'] = 1;
		}
		else
		{
			$Counter['counter_value']++;
		}
		$Pdo=null;
		$QueryData=array();
		$Query = 'REPLACE INTO `td_index_counter` SET ';
		$Query .= ' counter_group=?';
		$QueryData[] = $Group;
		$Query .= ' , counter_value=?';
		$QueryData[] = $Counter['counter_value'];
		$Pdo = self :: $Db->Prepare($Query);
		$Pdo->Execute($QueryData);
		$Pdo=null;
		self::_CheckNewCounter($Group, $Counter['counter_value']);
		return $Counter['counter_value'];
	}
	private static function _CheckNewCounter($Group, $Value)
	{
		$Query = 'SELECT COUNT(*) AS total FROM `td_index_counter` WHERE ';
		$Query .= ' `counter_group`=?';
		$QueryData[] = $Group;
		$Query .= '  && `counter_value`=?';
		$QueryData[] = $Value;
		$Pdo = self::$Db->Prepare($Query);
		$Pdo->Execute($QueryData);
		if (!($Value = $Pdo->Fetch()))
		{
			throw new exception('Counter wrong! 1');
		}
		$Pdo=null;
		if ($Value['total'] != 1)
		{
			throw new exception('Counter wrong! 2');
		}
	}
	public static function ResetTableCounter()
	{
		$Query = 'DROP TABLE IF EXISTS `td_index_counter`';
		$Pdo = self :: $Db->Prepare($Query);
		$Pdo->Execute();
		$Pdo=null;
		self :: InitTableCounter();
	}
	private static function InitTableCounter()
	{
		$Query = 'CREATE TABLE IF NOT EXISTS `td_index_counter` ';
		$Query .= ' ( ';
		$Query .= ' `counter_group` CHAR(255) NOT NULL ';
		$Query .= ' ,`counter_value` BIGINT(20) NOT NULL ';
		$Query .= ' , unique(`counter_group`) ';
		$Query .= ' ) ';
		$Pdo = self :: $Db->Prepare($Query);
		$Pdo->Execute();
		$Pdo=null;
	}
}
?>