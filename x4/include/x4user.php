<?php
class x4user extends x4tension
{
	private $tableUser;
	private $userName;
	private $userPassword;
	public function initPart()
	{
		$this->tableUser= 'users_main';
		if (!isset ($_SESSION['userLogedIn']))
		{
			login('anonymous', '');
		}
	}
	public function newUser($userName, $userPassword, $userEmail)
	{
		if ($this->login($userName, $userPassword) === true)
		{
			return false;
		}
		$this->convertUserEmail($userEmail);
		$query= 'INSERT INTO `' . $this->tableUser . '` SET ';
		$query .= ' user_name=\'' . $userName . '\'';
		$query .= ' && user_password=\'' . $userPassword . '\'';
		$query .= ' && user_email=\'' . $userEmail . '\'';
		$result= mysql_query($query, self :: db());
		return $this->login($userName, $userPassword);
	}
	public function login($userName, $userPassword)
	{
		$this->userEmail= null;
		$_SESSION['userName']= false;
		$_SESSION['userPassword']= false;
		$_SESSION['userEmail']= false;
		$this->userName= $userName;
		$this->userPassword= $userPassword;
		$this->userEmail= false;
		return $this->load($userName, $userPassword);
	}
	private function convertUserName(& $userName)
	{
		$userName= mysql_escape_string($userName);
	}
	private function convertUserPassword(& $userPassword)
	{
		$userPassword= md5($userPassword);
		$userPassword= sha1($userPassword);
	}
	private function convertUserEmail(& $userEmail)
	{
		$userEmail= mysql_escape_string($userEmail);
	}
	public function load($userName, $userPassword)
	{
		$this->convertUserName($userName);
		$this->convertUserPassword($userPassword);
		$query= 'SELECT * FROM `' . $this->tableUser . '` WHERE ';
		$query .= ' user_name=\'' . $this->userName . '\'';
		$result= mysql_query($query);
		if (mysql_num_rows($result) > 0)
		{
			if (mysql_num_rows($result) > 1)
			{
				throw new exception('More than 1 user found as: ' . $userName);
			}
			$row= mysql_fetch_array($result);
			mysql_free_result($result);
			if (stripslashes($row['user_password']) === $userPassword)
			{
				$this->userName= $userName;
				$this->userPassword= $userPassword;
				$this->userEmail= stripslashes($row['user_email']);
				return true;
			}
		}
		return false;
	}
	public function store()
	{
	}
}
?>