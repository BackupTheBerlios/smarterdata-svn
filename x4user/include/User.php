<?php
class User extends UserManager
{
	protected $userId= null;
	protected $userName= null;
	protected $userPassword= null;
	protected $userEmail= null;
	protected $userLogedIn= false;
	public function __construct(& $db, $userName, $userPassword)
	{
		$this->db= & $db;
		$this->login($userName, $userPassword);
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
	public function getUserEmail()
	{
		$this->checkLogin();
		return $this->userEmail;
	}
	protected function setInfo($cellName, $cellValue)
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
	protected function checkLogin()
	{
		if ($this->userLogedIn !== true)
		{
			throw new exceptionNotLogedIn('Please login first to use setUserLogedIn');
		}
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
}
?>