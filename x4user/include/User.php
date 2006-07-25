<?php
class user
{
	protected $tableUser= 'users';
	private $internalQueryValue= ':?:';
	private $anonUserId= 1;
	private $anonUserName= 'anonymous';
	private $anonUserPassword= 'anonymous';
	private $anonUserEmail= 'anonymous@localhost';
	private $userId= null;
	private $userName= null;
	private $userPassword= null;
	private $userEmail= null;
	private $db;
	private $userLogedIn= false;
	public function __construct(& $db, $userName= null, $userPassword= null, $userEmail= null)
	{
		$this->db= & $db;
		$this->checkTable();
		$this->checkUserAnonymous();
		if ($userName === null)
		{
			$userName= $this->anonUserName;
			$userPassword= $this->anonUserPassword;
		}
		if ($this->checkUserExist($userName))
		{
			$this->login($userName, $userPassword);
		}
	}
	public function setUserLogedIn($userLogedIn)
	{
		$this->checkLogin();
		$this->userLogedIn= $userLogedIn;
	}
	public function getUserLogedIn()
	{
		$this->checkLogin();
		return $this->userLogedIn();
	}
	public function setUserName($userName)
	{
		$this->checkLogin();
		$this->setInfo('user_name', $userName);
		$this->userName= $userName;
	}
	public function getUserName()
	{
		$this->checkLogin();
		return $this->userName;
	}
	public function setUserPassword($userPassword)
	{
		$this->checkLogin();
		$this->setInfo('user_password', $this->prepareUserPassword($userPassword));
		$this->userPassword= $userPassword;
	}
	public function getUserPassword()
	{
		$this->checkLogin();
		return $this->userPassword;
	}
	public function setUserEmail($userEmail)
	{
		$this->checkLogin();
		$this->setInfo('user_email', $userEmail);
		$this->userEmail= $userEmail;
	}
	public function createUser($userName, $userPassword, $userEmail)
	{
		$query= 'SELECT * FROM `' . $this->tableUser . '` ORDER BY user_id DESC LIMIT 1';
		$result= mysql_query($query, $this->db);
		if (!$result)
		{
			throw new exceptionUserSql('Error sql: ' . mysql_error($this->db));
		}
		if (mysql_num_rows($result) == 0)
		{
			throw new exceptionUserProblem('Error, no result');
		}
		$row= mysql_fetch_array($result);
		mysql_free_result($result);
		$userId= $row['user_id'] + 1;
		$this->createAccount($userId, $userName, $userPassword, $userEmail);
	}
	public function getUserEmail()
	{
		$this->checkLogin();
		return $this->userEmail;
	}
	protected function login($userName, $userPassword)
	{
		$query= 'SELECT *';
		$query .= ' FROM `' . $this->tableUser . '`';
		$query .= ' WHERE ';
		$query .= ' user_name=:?:';
		$queryData[]= $userName;
		$query .= ' && user_password=:?:';
		$queryData[]= $this->prepareUserPassword($userPassword);
		$query= $this->query($query, $queryData);
		echo $query;
		$result= mysql_query($query);
		if (!$result)
		{
			throw new exceptionUserSql('SQL: ' . mysql_error($this->db));
		}
		if (mysql_num_rows($result) == 0)
		{
			throw new exceptionUserLogin('Username/Password unknown');
		}
		$this->userLogedIn= true;
	}
	protected function prepareUserPassword($userPassword)
	{
		$userPassword= md5(sha1($userPassword));
		return mysql_real_escape_string($userPassword);
	}
	protected function checkLogin()
	{
		if ($this->userLogedIn !== true)
		{
			throw new exceptionNotLogedIn('Please login first to use setUserLogedIn');
		}
	}
	protected function query($queryString, $queryData= null)
	{
		$queryStringOriginal= $queryString;
		if (strstr($queryString, $this->internalQueryValue))
		{
			$queryBits= explode(':?:', $queryString);
			$queryString= '';
			foreach ($queryBits as $number => $bit)
			{
				$queryString .= $bit;
				if ($number +1 == sizeof($queryBits))
				{
					continue;
				}
				if (!isset ($queryData[$number]))
				{
					throw new exceptionProblem('Data not found for ' . ($number) . 'th value: ' . $queryStringOriginal);
				}
				else
				{
					$queryString .= '\'' . mysql_real_escape_string($queryData[$number]) . '\'';
				}
			}
		}
		return $queryString;
	}
	private function checkUserExist($userName)
	{
		$queryData= array ();
		$query= ' SELECT COUNT(*) AS total';
		$query .= ' FROM `' . $this->tableUser . '`';
		$query .= ' WHERE';
		$query .= ' user_name=:?:';
		$queryData[]= $userName;
		$query= $this->query($query, $queryData);
		echo $query . '<br>';
		$result= mysql_query($query, $this->db);
		if (!$result)
		{
			throw new exceptionUserSql('Error sql: ' . mysql_error($this->db));
		}
		if (mysql_num_rows($result) == 0)
		{
			throw new exceptionUserProblem('Error, no result');
		}
		$row= mysql_fetch_array($result);
		mysql_free_result($result);
		if ($row['total'] != 1)
		{
			$this->createAccount($this->anonUserId, $this->anonUserName, $this->anonUserPassword, $this->anonUserEmail);
		}
	}
	private function setInfo($cellName, $cellValue)
	{
		$query= ' UPDATE `' . $this->tableUser . '`';
		$query .= ' SET';
		$query .= ' ' . $cellName . '=:?:';
		$queryData[]= $cellValue;
		$query .= ' WHERE';
		$query .= ' user_id=:?:';
		$queryData[]= $this->userId;
		$query= $this->query($query, $queryData);
		$result= mysql_query($query, $this->db);
		if (!$result)
		{
			throw new exceptionUserSql('Error sql: ' . mysql_error($this->db));
		}
		if (mysql_affected_rows($this->db) == 0)
		{
			throw new exceptionUserSet('Error, not updated');
		}
	}
	private function checkUserAnonymous()
	{
		$queryData= array ();
		$query= ' SELECT COUNT(*) AS total';
		$query .= ' FROM `' . $this->tableUser . '`';
		$query .= ' WHERE';
		$query .= ' user_id=:?:';
		$queryData[]= $this->anonUserId;
		$query .= ' && user_name=:?:';
		$queryData[]= $this->anonUserName;
		$query .= ' && user_password=:?:';
		$queryData[]= $this->anonUserPassword;
		$query .= ' && user_email=:?: ';
		$queryData[]= $this->anonUserEmail;
		$query= $this->query($query, $queryData);
		echo $query . '<br>';
		$result= mysql_query($query, $this->db);
		if (!$result)
		{
			throw new exceptionUserSql('Error sql: ' . mysql_error($this->db));
		}
		if (mysql_num_rows($result) == 0)
		{
			throw new exceptionUserProblem('Error, no result');
		}
		$row= mysql_fetch_array($result);
		mysql_free_result($result);
		if ($row['total'] != 1)
		{
			$this->createAccount($this->anonUserId, $this->anonUserName, $this->anonUserPassword, $this->anonUserEmail);
		}
	}
	private function createAccount($userId, $userName, $userPassword, $userEmail)
	{
		$query= ' REPLACE';
		$query .= ' INTO `' . $this->tableUser . '`';
		$query .= ' SET';
		$query .= ' user_id=:?:';
		$query .= ' ,user_name=:?:';
		$query .= ' ,user_password=:?:';
		$query .= ' ,user_email=:?:';
		$queryData[]= $userId;
		$queryData[]= $userName;
		$queryData[]= $userPassword;
		$queryData[]= $userEmail;
		$query= $this->query($query, $queryData);
		$result= mysql_query($query, $this->db);
		if (!$result)
		{
			throw new exceptionUserSql('Error sql: ' . mysql_error($this->db));
		}
		if (mysql_affected_rows($this->db) == 0)
		{
			throw new exceptionUserSet('Error, not inserted');
		}
	}
	private function checkTable()
	{
		$query= 'CREATE TABLE IF NOT EXISTS `' . $this->tableUser . '` (';
		$query .= ' `user_id` BIGINT NOT NULL';
		$query .= ',`user_name` CHAR(255) NOT NULL';
		$query .= ',`user_password` CHAR(255) NOT NULL';
		$query .= ',`user_email` CHAR(255) NOT NULL';
		$query .= ', UNIQUE (`user_id`));';
		echo $query . '<br>';
		$result= mysql_query($query, $this->db);
		if (!$result)
		{
			throw new exceptionUserSql('SQL: ' . mysql_error($this->db));
		}
	}
}
?>