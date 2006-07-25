<?php
class user extends usercore
{
	private $userId= null;
	private $userName= null;
	private $userPassword= null;
	private $userEmail= null;
	private $userLogedIn= false;
	public function __construct(& $db, $userName= null, $userPassword= null, $userEmail= null)
	{
		parent :: __construct($db, $userName, $userPassword);
		if ($userName === null)
		{
			$userName= $this->anonUserName;
			$userPassword= $this->anonUserPassword;
		}
		$this->login($userName, $userPassword);
	}
	protected function login($userName, $userPassword)
	{
		$query= 'SELECT *';
		$query .= ' FROM `' . $this->tableUser. '`';
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
	public function setUserLogedIn($userLogedIn= false)
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
	public function getUserEmail()
	{
		$this->checkLogin();
		return $this->userEmail;
	}
	private function setInfo($cellName, $cellValue)
	{
		$query= ' UPDATE `' . $this->tableUser. '`';
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
}
?>