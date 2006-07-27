<?php
class UserManager
{
	protected $tableUser= 'users';
	protected $internalQueryValue= ':?:';
	protected $anonUserId= 1;
	protected $anonUserName= 'anonymous';
	protected $anonUserPassword= 'anonymous';
	protected $anonUserEmail= 'anonymous@localhost';
	protected $db;
	private $tablePrefix;
	public function __construct(& $db, $tablePrefix)
	{
		$this->tablePrefix= $tablePrefix;
		$this->tableUser= $tablePrefix . 'users';
		$this->db= & $db;
		$this->checkTable();
		$this->checkUserAnonymous();
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
		$userPassword= $this->prepareUserPassword($userPassword);
		$this->createAccount($userId, $userName, $userPassword, $userEmail);
	}
	public function getUserlist($userName, $currentPage, $usersPerPage)
	{
		$query= 'SELECT *';
		$query .= ' FROM `' . $this->tableUser . '`';
		$query .= ' WHERE ';
		$query .= ' user_name LIKE :?:';
		$queryData[]= $userName;
		$query .= ' ORDER BY user_name ASC';
		$query .= ' LIMIT ' . (int) ($currentPage * $usersPerPage) . ',' . (int) $usersPerPage;
		$query= $this->query($query, $queryData);
		$result= mysql_query($query);
		if (mysql_num_rows($result) == 0)
		{
			return false;
		}
		$return= array ();
		while ($row= mysql_fetch_array($result))
		{
			$return[]= array (
				'userId' => stripslashes($row['user_id']
			), 'userName' => stripslashes($row['user_name']), 'userEmail' => stripslashes($row['user_email']));
		}
		mysql_free_result($result);
		return $return;
	}
	protected function prepareUserPassword($userPassword)
	{
		$userPassword= md5(sha1($userPassword));
		return mysql_real_escape_string($userPassword);
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
					throw new exceptionUserProblem('Data not found for ' . ($number) . 'th value: ' . $queryStringOriginal);
				}
				else
				{
					$queryString .= '\'' . mysql_real_escape_string($queryData[$number]) . '\'';
				}
			}
		}
		return $queryString;
	}
	public function checkUserExist($userName)
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
		if ($row['total'] == 0)
		{
			return false;
		}
		return true;
	}
	protected function checkUserAnonymous()
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
		$queryData[]= $this->prepareUserPassword($this->anonUserPassword);
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
			$this->createAccount($this->anonUserId, $this->anonUserName, $this->prepareUserPassword($this->anonUserPassword), $this->anonUserEmail);
		}
	}
	protected function createAccount($userId, $userName, $userPassword, $userEmail)
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
		echo '<pre>' . print_r($queryData, 1) . '</pre>';
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
	protected function checkTable()
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
	public function loginAsUser($userName= null, $userPassword= null)
	{
		if ($userName === null)
		{
			$userName= $this->anonUserName;
			$userPassword= $this->anonUserPassword;
		}
		return new User(& $this->db, $this->tablePrefix, $userName, $userPassword);
	}
	public function getUserById($userId)
	{
		$query= 'SELECT user_name, user_password FROM `' . $this->tableUser . '` WHERE user_id=:?:';
		$queryData[]= (int) $userId;
		$query= $this->query($query, $queryData);
		$result= mysql_query($query);
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
		return new User(& $this->db, $this->tablePrefix, stripslashes($row['user_name']), stripslashes($row['user_password']), true);
	}
}
?>