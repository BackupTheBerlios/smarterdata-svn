<?php
class DatabaseThief
{
	protected $Db;
	protected $DbType;
	public function __construct($DbType)
	{
		$this->DbType=$DbType;
	}
	public function __destruct()
	{
	}
	public function Connect($DatabaseHost, $DatabasePort, $DatabaseName, $DatabaseUserName, $DatabaseUserPassword)
	{
		$this->Db= DbConnect :: Connect($DatabaseHost, $DatabasePort, $DatabaseName, $DatabaseUserName, $DatabaseUserPassword);
		$this->Db->setAttribute(PDO :: ATTR_ERRMODE, PDO :: ERRMODE_EXCEPTION);
	}
	public function ListDatabases()
	{
		$MethodName= $this->DbType . __FUNCTION__;
		if (!method_exists($this, $MethodName))
		{
			return $this->DbTypeNotSupported(__FUNCTION__);
		}
		return $this-> $MethodName ();
	}
	private function MySqlListDatabases()
	{
		$Query= 'SHOW DATABASES';
		$Pdo=$this->Db->Prepare($Query);
		$Pdo->Execute();
		if(!($Values=$Pdo->FetchAll()))
		{
			return null;
		}
		return $Values;
	}
	public function ListTables($DatabaseName)
	{
		$MethodName= $this->DbType . __FUNCTION__;
		if (!method_exists($this, $MethodName))
		{
			return $this->DbTypeNotSupported(__FUNCTION__);
		}
		return $this-> $MethodName ($DatabaseName);
	}
	private function MySqlListTables($DatabaseName)
	{
		$Query= 'USE ' . $DatabaseName;
		$Query= 'SHOW TABLES';
		$Pdo=$this->Db->Prepare($Query);
		$Pdo->Execute();
		if(!($Values=$Pdo->FetchAll()))
		{
			return null;
		}
		return $Values;
	}
	public function ListFields($DatabaseName, $TableName)
	{
		$MethodName= $this->DbType . __FUNCTION__;
		if (!method_exists($this, $MethodName))
		{
			return $this->DbTypeNotSupported(__FUNCTION__);
		}
		return $this-> $MethodName ($DatabaseName, $TableName);
	}
	private function MySqlListFields($DatabaseName, $TableName)
	{
		$Query= 'USE ' . $DatabaseName;
		$Query= 'SHOW COLUMNS FROM ' . $TableName;
		$Pdo=$this->Db->Prepare($Query);
		$Pdo->Execute();
		if(!($Values=$Pdo->FetchAll()))
		{
			return null;
		}
		return $Values;
	}
	private function ErrorDbTypeNotSupported($Method)
	{
		throw new exception('Method: ' . $Method . ' - DbType not supported: ' . $this->DbType);
	}
}
?>