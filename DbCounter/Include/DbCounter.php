<?php
class DbCounter extends DbConnect
{
	private $Db;
	private $Prefix;
	private $Tablename;
	public function __construct($Prefix, $DatabaseHost, $DatabasePort, $DatabaseName, $DatabaseUserName, $DatabaseUserPassword)
	{
		$this->Prefix= $Prefix;
		$this->Tablename= $this->Prefix . '_counters';
		$this->Db= DbConnect :: Connect($DatabaseHost, $DatabasePort, $DatabaseName, $DatabaseUserName, $DatabaseUserPassword);
	}
	public function __destruct()
	{
	}
	private function CreateTable()
	{
		$Query= '';
		$Query .= 'CREATE TABLE IF NOT EXISTS `' . $this->Tablename . '`';
		$Query .= ' `counter_name` CHAR(255) NOT NULL';
		$Query .= ',`counter_value` BIGINT NOT NULL';
		$Query .= ',UNIQUE (`counter_id`)';
		$Query .= ') TYPE = MYISAM CHARACTER SET latin1 COLLATE latin1_general_ci';
		$Pdo= $this->Db->Prepare($Query);
		$Pdo->Execute();
	}
	public function Increment($CounterName)
	{
		$this->CheckCounter($CounterName);
		$this->IncCounter($CounterName);
		return $this->GetCounter($CounterName);
	}
	public function Decrement($CounterName)
	{
		$this->CheckCounter($CounterName);
		$this->DecCounter($CounterName);
		return $this->GetCounter($CounterName);
	}
	private function CheckCounter($CounterName)
	{
		if ($this->GetCounter($CounterName) === null)
		{
			$this->CreateCounter($CounterName);
			if ($this->GetCounter($CounterName) === null)
			{
				throw new exception('Can not create counter : ' . $CounterName);
			}
		}
	}
	private function CreateCounter($CounterName)
	{
		$Query= 'INSERT INTO `' . $this->Tablename . '` SET';
		$Query .= '  counter_name=?';
		$Query .= ', counter_value=?';
		$QueryData[]= $CounterName;
		$QueryData[]= 0;
		$Pdo= $this->Db->Prepare($Query);
		$Pdo->Execute($QueryData);
	}
	private function GetCounter($CounterName)
	{
		$Query= 'SELECT * FROM `' . $this->Tablename . '` WHERE';
		$Query .= ' counter_name LIKE ?';
		$QueryData[]= $CounterName;
		$Pdo= $this->Db->Prepare($Query);
		$Pdo->Execute($QueryData);
		if (!($Result= $Pdo->Fetch()))
		{
			return null;
		}
		else
		{
			return (int) $Result['counter_value'];
		}
	}
	private function IncCounter($CounterName)
	{
		$LastValue= $this->GetCounter($CounterName);
		$Query= 'UPDATE `' . $this->Tablename . '` SET';
		$Query .= ' counter_value = counter_value+1';
		$Query .= ' WHERE counter_name LIKE ?';
		$QueryData[]= $CounterName;
		$Pdo= $this->Db->Prepare($Query);
		$Pdo->Execute($QueryData);
		$CurrentValue= $this->GetCounter($CounterName);
		if ($CurrentValue -1 !== $LastValue)
		{
			throw new exception('Counter not incremented : ' . $CounterName);
		}
		return $CurrentValue;
	}
	private function DecCounter($CounterName)
	{
		$LastValue= $this->GetCounter($CounterName);
		$Query= 'UPDATE `' . $this->Tablename . '` SET';
		$Query .= ' counter_value = counter_value-1';
		$Query .= ' WHERE counter_name LIKE ?';
		$QueryData[]= $CounterName;
		$Pdo= $this->Db->Prepare($Query);
		$Pdo->Execute($QueryData);
		$CurrentValue= $this->GetCounter($CounterName);
		if ($CurrentValue +1 !== $LastValue)
		{
			throw new exception('Counter not decremented : ' . $CounterName);
		}
		return $CurrentValue;
	}
	private function ResetCounter($CounterName)
	{
		$Query= 'UPDATE `' . $this->Tablename . '` SET';
		$Query .= ' counter_value = counter_value-1';
		$Query .= ' WHERE counter_name LIKE ?';
		$QueryData[]= $CounterName;
		$Pdo= $this->Db->Prepare($Query);
		$Pdo->Execute($QueryData);
		$CurrentValue= $this->GetCounter($CounterName);
		if ($CurrentValue !== 0)
		{
			throw new exception('Counter not reseted : ' . $CounterName);
		}
		return $CurrentValue;
	}
}
?>