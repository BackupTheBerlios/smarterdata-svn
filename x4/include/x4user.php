<?php
class x4user extends x4tension
{
	private $tableUser;
	private $userId;
	private $userName;
	private $userPassword;
	private $userEmail;
	private $userActivated;
	private $userBaned;
	private $userBanedTo;
	private $anonymousUserName= 'anonymous';
	private $anonymousUserPassword= 'anonymous';
	private $anonymousUserEmail= 'anonymous@localhost';
	public function initPart()
	{
		$this->tableUser= 'users_main';
		$this->checkTable();
		$this->checkAnonymous();
	}
	public function deInitPart()
	{
		if ($this->getUserType() === false)
		{
			$this->unsetUser();
		}
	}
	public function newUser($userName, $userPassword, $userEmail)
	{
		if ($this->checkExistUserName($userName))
		{
			throw new exception('Username exist');
		}
		if ($this->checkExistUserEmail($userEmail))
		{
			throw new exception('Useremail exist');
		}
		$userId= $this->getNewId();
		$this->convertUserName($userName);
		$this->convertUserPassword($userPassword);
		$this->convertUserEmail($userEmail);
		$query= 'INSERT INTO `' . $this->tableUser . '` SET ';
		$query .= ' user_id=\'' . $userId . '\'';
		$query .= ' ,user_name=\'' . $userName . '\'';
		$query .= ' ,user_password=\'' . $userPassword . '\'';
		$query .= ' ,user_email=\'' . $userEmail . '\'';
		echo $query . '<br>';
		$result= mysql_query($query, self :: db());
		if (!$result)
		{
			throw new exception('SQL: ' . mysql_error(self :: db()));
		}
	}
	public function login($userName, $userPassword)
	{
		$this->convertUserName($userName);
		$this->convertUserPassword($userPassword);
		return $this->loginInternal($userName, $userPassword);
	}
	public function loginForAdmin($userName)
	{
		$this->convertUserName($userName);
		$query= 'SELECT user_password FROM `' . $this->tableUser . '` WHERE user_name=\'' . $userName . '\'';
		echo $query . '<br>';
		$result= mysql_query($query, self :: db());
		if (!$result)
		{
			throw new exception('SQL: ' . mysql_error(self :: db()));
		}
		if (mysql_num_rows($result) == 0)
		{
			throw new exception('loginForAdmin can not find username: ' . $userName);
		}
		$row= mysql_fetch_array($result);
		mysql_free_result($result);
		return $this->loginInternal($userName, stripslashes($row['user_password']));
	}
	private function loginInternal(& $userName, & $userPassword)
	{
		$this->unsetUser();
		$query= 'SELECT *';
		$query .= ' FROM `' . $this->tableUser . '`';
		$query .= ' WHERE user_name=\'' . $userName . '\'';
		$query .= ' && user_password=\'' . $userPassword . '\'';
		echo $query . '<br>';
		$result= mysql_query($query, self :: db());
		if (!$result)
		{
			throw new exception('SQL: ' . mysql_error(self :: db()));
		}
		if (mysql_num_rows($result) == 0)
		{
			throw new exception('Username or password incorrect');
		}
		$row= mysql_fetch_array($result);
		mysql_free_result($result);
		if (stripslashes($row['user_activated']) == 'N')
		{
			$this->unsetUser();
			throw new exception('User not activated');
		}
		if (stripslashes($row['user_baned']) == 'Y')
		{
			$this->unsetUser();
			throw new exception('User baned');
		}
		if (stripslashes($row['user_baned_to']) > time())
		{
			$this->unsetUser();
			throw new exception('User temporary baned');
		}
		$this->userId= stripslashes($row['user_id']);
		$this->userName= stripslashes($row['user_name']);
		$this->userPassword= stripslashes($row['user_password']);
		$this->userEmail= stripslashes($row['user_email']);
		$this->userActivated= stripslashes($row['user_activated']);
		$this->userBaned= stripslashes($row['user_baned']);
		$this->userBanedTo= stripslashes($row['user_baned_to']);
		return $this->userId;
	}
	public function getUserId()
	{
		return $this->userId;
	}
	public function setUserPassword($userPassword)
	{
		if ($this->userId === null)
		{
			throw new exception('Log in to change your password');
		}
	}
	public function getUserPassword()
	{
		return $this->userPassword;
	}
	public function setUserEmail($userEmail)
	{
		if ($this->userId === null)
		{
			throw new exception('Log in to change your email');
		}
	}
	public function getUserEmail()
	{
		return $this->userEmail;
	}
	public function setUserActivated($userActivated)
	{
		if (!$this->checkExistUserId($this->userId))
		{
			throw new exception('User id does not exist to set banTo: ' . $this->userId . ' : ' . $userActivated);
		}
		$this->checkSettingUserActivated($userActivated);
		$query= 'UPDATE `' . $this->tableUser . '`';
		$query .= ' SET user_activated=\'' . $userActivated . '\'';
		$query .= ' WHERE user_id=\'' . $this->userId . '\'';
		echo $query . '<br>';
		$result= mysql_query($query, self :: db());
		if (!$result)
		{
			throw new exception('SQL: ' . mysql_error(self :: db()));
		}
		$this->userActivated= $userActivated;
	}
	public function getUserActivated()
	{
		return $this->userActivated;
	}
	public function setUserBaned($userBaned)
	{
		if (!$this->checkExistUserId($this->userId))
		{
			throw new exception('User id does not exist to set ban: ' . $this->userId . ' : ' . $userBaned);
		}
		$this->checkSettingUserBaned($userBaned);
		$query= 'UPDATE `' . $this->tableUser . '`';
		$query .= ' SET user_baned=\'' . $userBaned . '\'';
		$query .= ' WHERE user_id=\'' . $this->userId . '\'';
		echo $query . '<br>';
		$result= mysql_query($query, self :: db());
		if (!$result)
		{
			throw new exception('SQL: ' . mysql_error(self :: db()));
		}
	}
	public function getUserBaned()
	{
		return $this->userBaned;
	}
	public function setUserBanedTo($userBanedTo)
	{
		if ($this->userId === null)
		{
			throw new exception('Log in to change userBanedTo');
		}
		$this->checkSettingUserBanedTo($userBanedTo);
		$query= 'UPDATE `' . $this->tableUser . '`';
		$query .= ' SET user_baned_to=\'' . $userBanedTo . '\'';
		$query .= ' WHERE user_id=\'' . $this->userId . '\'';
		echo $query . '<br>';
		$result= mysql_query($query, self :: db());
		if (!$result)
		{
			throw new exception('SQL: ' . mysql_error(self :: db()));
		}
	}
	public function getUserBanedTo()
	{
		return $this->userBanedTo;
	}
	public function getUserType()
	{
		if ($this->userName == $this->anonymousUserName)
		{
			return false;
		}
		return true;
	}
	public function getUserName()
	{
		return $this->userName;
	}
	private function checkTable()
	{
		$query= 'CREATE TABLE IF NOT EXISTS `' . $this->tableUser . '` (';
		$query .= ' `user_id` BIGINT NOT NULL';
		$query .= ',`user_name` CHAR(255) NOT NULL';
		$query .= ',`user_password` CHAR(255) NOT NULL';
		$query .= ',`user_email` CHAR(255) NOT NULL';
		$query .= ',`user_activated` CHAR(1) NOT NULL';
		$query .= ',`user_baned` CHAR(1) NOT NULL';
		$query .= ',`user_baned_to` CHAR(20) NOT NULL';
		$query .= ', UNIQUE (`user_id`));';
		echo $query . '<br>';
		$result= mysql_query($query, self :: db());
		if (!$result)
		{
			throw new exception('SQL: ' . mysql_error(self :: db()));
		}
	}
	private function checkAnonymous()
	{
		if (!$this->checkExistUserName($this->anonymousUserName))
		{
			$this->newUser($this->anonymousUserName, $this->anonymousUserPassword, $this->anonymousUserEmail);
		}
	}
	private function checkExistUserId($userId)
	{
		$this->convertUserId($userId);
		$query= 'SELECT COUNT(user_id) AS total';
		$query .= ' FROM `' . $this->tableUser . '`';
		$query .= ' WHERE user_id=\'' . $userId . '\'';
		echo $query . '<br>';
		$result= mysql_query($query, self :: db());
		if (!$result)
		{
			throw new exception('SQL: ' . mysql_error(self :: db()));
		}
		if (mysql_num_rows($result) == 0)
		{
			throw new exception('Error while get a users name');
		}
		$row= mysql_fetch_array($result);
		mysql_free_result($result);
		if ($row['total'] == 0)
		{
			return false;
		}
		return true;
	}
	private function checkExistUserName($userName)
	{
		$this->convertUserName($userName);
		$query= 'SELECT COUNT(user_name) AS total';
		$query .= ' FROM `' . $this->tableUser . '`';
		$query .= ' WHERE user_name=\'' . $userName . '\'';
		echo $query . '<br>';
		$result= mysql_query($query, self :: db());
		if (!$result)
		{
			throw new exception('SQL: ' . mysql_error(self :: db()));
		}
		if (mysql_num_rows($result) == 0)
		{
			throw new exception('Error while get a users name');
		}
		$row= mysql_fetch_array($result);
		mysql_free_result($result);
		if ($row['total'] == 0)
		{
			return false;
		}
		return true;
	}
	private function checkExistUserEmail($userEmail)
	{
		$this->convertUserName($userEmail);
		$query= 'SELECT COUNT(*) AS total';
		$query .= ' FROM `' . $this->tableUser . '`';
		$query .= ' WHERE user_email=\'' . $userEmail . '\'';
		echo $query . '<br>';
		$result= mysql_query($query, self :: db());
		if (!$result)
		{
			throw new exception('SQL: ' . mysql_error(self :: db()));
		}
		if (mysql_num_rows($result) == 0)
		{
			throw new exception('Error while get a users email');
		}
		$row= mysql_fetch_array($result);
		mysql_free_result($result);
		if ($row['total'] == 0)
		{
			return false;
		}
		return true;
	}
	private function getLastId()
	{
		$query= 'SELECT user_id';
		$query .= ' FROM `' . $this->tableUser . '`';
		$query .= ' ORDER BY user_id DESC LIMIT 1';
		echo $query . '<br>';
		$result= mysql_query($query, self :: db());
		if (!$result)
		{
			throw new exception('SQL: ' . mysql_error(self :: db()));
		}
		if (mysql_num_rows($result) == 0)
		{
			return 0;
		}
		$row= mysql_fetch_array($result);
		mysql_free_result($result);
		return $row['user_id'];
	}
	private function getNewId()
	{
		return ($this->getLastId() + 1);
	}
	private function unsetUser()
	{
		$this->userId= null;
		$this->userName= null;
		$this->userPassword= null;
		$this->userEmail= null;
		$this->userActivated= null;
		$this->userBaned= null;
		$this->userBanedTo= null;
	}
	private function convertUserId(& $userId)
	{
		$userId= (int) $userId;
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
	private function checkSettingUserActivated(& $userActivated)
	{
		if ($userActivated !== 'Y' && $userActivated !== 'N')
		{
			throw new exception('Setting activated is: ' . $userActivated . ' not (Y/N)');
		}
	}
	private function checkSettingUserBaned(& $userBaned)
	{
		if ($userBaned !== 'Y' && $userBaned !== 'N')
		{
			throw new exception('Setting baned is: ' . $userBaned . ' not (Y/N)');
		}
	}
	private function checkSettingUserBanedTo(& $userBanedTo)
	{
		if (!is_numeric($userBanedTo))
		{
			throw new exception('Setting banedTo is: ' . $userBanedTo . ' not a numeric');
		}
	}
}
?>