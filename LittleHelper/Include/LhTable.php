<?php
class LhTable extends LhCore
{
	private $keyForChildren= '/CHILDREN/';
	private $order;
	private $orderRaw;
	private $where;
	private $whereRaw;
	/**
	 * Constructor
	 * @param PDO-Reference $pdoHandler
	 * @param array $translation
	 */
	protected function __construct(& $pdoHandler, $translation)
	{
		parent :: __construct($pdoHandler, $translation);
		if (isset ($translation['order']))
		{
			$this->setOrder($translation['order']);
		}
		if (isset ($translation['where']))
		{
			$this->setWhere($translation['where']);
		}
		if (isset ($translation['keyForChildren']))
		{
			$this->setKeyForChildren($translation['keyForChildren']);
		}
	}
	/**
	 * Destructor
	 */
	protected function __destruct()
	{
	}
	/**
	 * Set the array-key for the children-array
	 * @param string $keyName
	 */
	protected function setKeyForChildren($keyName)
	{
		$this->keyForChildren= $keyName;
	}
	/**
	 * Get the array-key for the children-array
	 * @return string
	 */
	protected function getKeyForChildren()
	{
		return $this->keyForChildren;
	}
	/**
	 * Set the order for selects
	 * 
	 * $orderRaw as string
	 *   'ORDER BY...'
	 * $orderRaw as array
	 *   $orderRaw = array (
	 *    array ( 'cell_name' => 'CELLNAME', 'direction' => 'DIRECTION'),
	 *    ...
	 *   );
	 * @param mixed Order
	 */
	protected function setOrder($orderRaw)
	{
		if (!is_array($orderRaw))
		{
			$this->setOrderComplex($orderRaw);
		}
		else
		{
			$this->setOrderNormal($orderRaw);
		}
		$this->orderRaw= $orderRaw;
	}
	/**
	 * Set the order from a simple array
	 * @param array $orderArray
	 */
	private function setOrderNormal($orderArray)
	{
		$orderQuery= '';
		foreach ($orderArray as $order)
		{
			$orderQuery .= ', ' . $order['cell_name'] . ' ' . $order['direction'];
		}
		if (strlen($orderQuery) > 0)
		{
			$this->order= 'ORDER BY ';
			$this->order .= substr($orderQuery, 2);
		}
		else
		{
			$this->order= '';
		}
	}
	/**
	 * Set the order from a string
	 * @param string $orderString
	 */
	private function setOrderComplex($orderString)
	{
		if (strlen($orderString) > 0)
		{
			if (is_array($orderString))
			{
				throw new exception('complex order expects a string started with "ORDER BY ..."');
			}
			if (strtoupper(substr($orderString, 0, 8)) !== 'ORDER BY')
			{
				throw new exception('complex order expects a string started with "ORDER BY ..."');
			}
			$this->order= $orderString;
		}
		else
		{
			$this->order= '';
		}
	}
	/**
	 * Get the order for selects
	 * @return mixed depends on setOrder
	 */
	protected function getOrder()
	{
		return $this->orderRaw;
	}
	/**
	 * Get the order for selects as string 'ORDER BY...'
	 * @return string
	 */
	protected function getOrderQuery()
	{
		return $this->order;
	}
	/**
	 * Set the where for selects
	 * 
	 * $whereRaw as string
	 *   'WHERE ...'
	 * $whereRaw as array
	 *   $whereRaw = array (
	 *    array ( 'cell_name' => 'CELLNAME', 'cell_op' => 'OPERATOR', 'cell_value'=> 'CELLVALUE'),
	 *    ...
	 *   );
	 * @param mixed Order
	 */
	protected function setWhere($whereRaw)
	{
		if (!is_array($whereRaw))
		{
			$this->setWhereComplex($whereRaw);
		}
		else
		{
			$this->setWhereNormal($whereRaw);
		}
		$this->whereRaw= $whereRaw;
	}
	/**
	 * Set the where from a simple array
	 * @param array $whereArray
	 */
	private function setWhereNormal($whereArray)
	{
		$whereQuery= '';
		foreach ($whereArray as $where)
		{
			$whereQuery .= '&& `' . $where['cell_name'] . '`' . $where['cell_op'] . $where['cell_value'];
		}
		if (strlen($whereQuery) > 0)
		{
			$this->where= 'WHERE ';
			$this->where .= substr($whereQuery, 2);
		}
		else
		{
			$this->where= '';
		}
	}
	/**
	 * Set the where from a string
	 * @param string $whereString
	 */
	private function setWhereComplex($whereString)
	{
		if (strlen($whereString) > 0)
		{
			if (is_array($whereString))
			{
				throw new exception('complex where expects a string started with "WHERE ..."');
			}
			if (strtoupper(substr($whereString, 0, 5)) !== 'WHERE')
			{
				throw new exception('complex where expects a string started with "WHERE ..."');
			}
			$this->where= $whereString;
		}
		else
		{
			$this->where= '';
		}
	}
	/**
	 * Get the where for select
	 * @return mixed depends on setWhere
	 */
	protected function getWhere()
	{
		return $this->whereRaw;
	}
	/**
	 * Get te where for selects as string 'WHERE ...'
	 * @return string
	 */
	protected function getWhereQuery()
	{
		return $this->where;
	}
	/**
	 * Preparing select-results
	 * @param array $results rows in an array
	 * @return array Prepared results
	 */
	private function prepareResults($results)
	{
		foreach ($results as $key => $result)
		{
			$results[$key]= $this->prepareResult($result);
		}
		return $results;
	}
	/**
	 * Preparing one select-result
	 * @param array $result one row
	 * @return array Prepared result
	 */
	private function prepareResult($result)
	{
		foreach ($result as $key => $value)
		{
			if (!is_array($value))
			{
				$result[$key]= stripslashes($value);
			}
			else
			{
				$result[$key]= $value;
			}
			switch ($key)
			{
				case $this->getCellNameDateCreated() :
					{
						$result[$key]= $this->generateTimestampFromDateCreated($value);
						break;
					}
				case $this->getCellNameDateChanged() :
					{
						$result[$key]= $this->generateTimestampFromDateChanged($value);
						break;
					}
			}
		}
		return $result;
	}
	/**
	 * Get the total rows depending on current where
	 * @return int total number of rows
	 */
	protected function getTotal()
	{
		$query= 'SELECT COUNT(*) as total FROM `' . $this->getTableName() . '` ';
		$query .= $this->getWhereQuery() . ' ';
		$pdo= $this->getPdoHandler()->prepare($query);
		$pdo->execute();
		if (!($result= $pdo->fetch()))
		{
			return 0;
		}
		$pdo= null;
		return $result['total'];
	}
	/**
	 * Get one row
	 * @param int $uniqueId this can be anything if your class manage new IDs getNewUniqueId
	 * @return array Result
	 */
	protected function getRow($uniqueId)
	{
		$query= 'SELECT * FROM `' . $this->getTableName() . '` WHERE ';
		$query .= ' `' . $this->getCellNameUniqueId() . '`=? ';
		$queryData[]= $uniqueId;
		$pdo= $this->getPdoHandler()->prepare($query);
		$pdo->execute($queryData);
		if (!($result= $pdo->fetch()))
		{
			return null;
		}
		$pdo= null;
		return $this->prepareResult($result);
	}
	/**
	 * Get the first row depending on where and order
	 * @return array Result
	 */
	protected function getFirstRow()
	{
		$query= 'SELECT * FROM `' . $this->getTableName() . '` ';
		$query .= $this->getWhereQuery() . ' ';
		$query .= $this->getOrderQuery() . ' ';
		$query .= ' LIMIT 0,1';
		$pdo= $this->getPdoHandler()->prepare($query);
		$pdo->execute();
		if (!($result= $pdo->fetch()))
		{
			return null;
		}
		$result= $this->prepareResult($result);
		$pdo= null;
		return $result;
	}
	/**
	 * Get a couple of rows depending on where and order 
	 * @param int $currentPage
	 * @param int $rowsPerPage
	 * @return array Results
	 */
	protected function getPage($currentPage, $rowsPerPage)
	{
		$currentPos= $currentPage * $rowsPerPage;
		$query= 'SELECT * FROM `' . $this->getTableName() . '` ';
		$query .= $this->getWhereQuery() . ' ';
		$query .= $this->getOrderQuery() . ' ';
		$query .= ' LIMIT ' . $currentPos . ',' . $rowsPerPage;
		$pdo= $this->getPdoHandler()->prepare($query);
		$pdo->execute();
		if (!($results= $pdo->fetchAll()))
		{
			return null;
		}
		$results= $this->prepareResults($results);
		return $results;
	}
	/**
	 * Get ALL children if parentId is available
	 *  Example: getRowsRecursiveDown(0) mostly returns nearly all rows
	 * @param int $uniqueId
	 * @return array Results
	 */
	protected function getRowsRecursiveDown($uniqueId)
	{
		if ($this->getCellNameParentId() == '')
		{
			throw new exception('No parentId set. getRowsRecursiveDown disabled!');
		}
		$currentRow= $this->getRow($uniqueId);
		if ($currentRow === null)
		{
			return null;
		}
		$return[$currentRow[$this->getCellNameUniqueId()]]= $currentRow;
		$return[$currentRow[$this->getCellNameUniqueId()]][$this->keyForChildren]= $this->getRowsRecursiveDown_($uniqueId);
		return $return;
	}
	/**
	 * Main class for getRowsRecursiveDown($uniqueId)
	 * @param int $parentId
	 * @return array Results
	 */
	private function getRowsRecursiveDown_($uniqueId)
	{
		$children= $this->getChildren($uniqueId);
		if ($children === null)
		{
			return null;
		}
		$return= array ();
		foreach ($children as $row)
		{
			$row= $this->prepareResult($row);
			$returnbit= $row;
			$returnbit[$this->getKeyForChildren()]= $this->getRowsRecursiveDown_($row[$this->getCellNameUniqueId()]);
			$return[$row[$this->getCellNameUniqueId()]]= $returnbit;
		}
		return $return;
	}
	/**
	 * Get ALL parents and her children up to rootUniqueId if parentId is available
	 * @param int $uniqueId
	 * @param int $rootUniqueId
	 * @return array Results
	 */
	protected function getRowsRecursiveUp($uniqueId, $rootUniqueId= 1)
	{
		if ($this->getCellNameParentId() == '')
		{
			throw new exception('No parentId set. getRowsRecursiveUp disabled!');
		}
		$children= array ();
		$idList= array ();
		$row= array ();
		while ($uniqueId >= $rootUniqueId)
		{
			$idList[]= $uniqueId;
			$currentRow= $this->getRow($uniqueId);
			$row[$uniqueId]= $currentRow;
			$uniqueId= $currentRow[$this->getCellNameParentId()];
		}
		krsort($idList);
		$return= array ();
		$currentReturn= & $return;
		$uniqueId= $idList[key($idList)];
		$return[$uniqueId]= $row[$uniqueId];
		for (krsort($idList); $key= key($idList); next($idList))
		{
			$uniqueId= $idList[key($idList)];
			$currentReturn[$uniqueId][$this->keyForChildren]= $this->getChildren($uniqueId);
			$currentReturn= & $currentReturn[$uniqueId][$this->keyForChildren];
		}
		return $return;
	}
	/**
	 * Get all children
	 * @param $uniqueId
	 * @return array Results
	 */
	protected function getChildren($uniqueId)
	{
		$query= 'SELECT * FROM `' . $this->getTableName() . '` WHERE';
		$query .= ' `' . $this->getCellNameParentId() . '`=?';
		$query .= $this->getOrderQuery();
		$queryData[]= $uniqueId;
		$pdo= $this->getPdoHandler()->prepare($query);
		$pdo->execute($queryData);
		if (!($rows= $pdo->fetchAll()))
		{
			return null;
		}
		$pdo= null;
		$return= array ();
		foreach ($rows as $row)
		{
			$row= $this->prepareResult($row);
			$returnbit= $row;
			$return[$row[$this->getCellNameUniqueId()]]= $returnbit;
		}
		return $return;
	}
	/**
	 * Update a row, change dateChanged
	 * @param int $uniqueId
	 * @param array $rowData
	 * @return bool
	 */
	protected function updateRow($uniqueId, $rowData)
	{
		if ($this->getCellNameDateCreated() > '')
		{
			if (isset ($rowData[$this->getCellNameDateCreated()]))
			{
				unset ($rowData[$this->getCellNameDateCreated()]);
			}
		}
		if ($this->getCellNameDateChanged() > '')
		{
			$rowData[$this->getCellNameDateChanged()]= $this->generateDateChangedFromTimestamp(time());
		}
		return $this->setRow($uniqueId, $rowData);
	}
	/**
	 * Force update
	 * @param int $uniqueId
	 * @param array $rowData
	 * @return bool
	 */
	protected function setRow($uniqueId, $rowData)
	{
		$rowData[$this->getCellNameUniqueId()]= $uniqueId;
		$querySet= '';
		$queryData= array ();
		$queryGet= '';
		foreach ($rowData as $key => $value)
		{
			$querySet .= ', `' . $key . '`=? ';
			$queryGet .= '&& `' . $key . '`=? ';
			$queryData[]= $value;
		}
		$query= 'UPDATE `' . $this->getTableName() . '` SET ' . substr($querySet, 2);
		$query .= ' WHERE `' . $this->getCellNameUniqueId() . '`=?';
		$queryData[]= $uniqueId;
		$pdo= $this->getPdoHandler()->prepare($query);
		$pdo->execute($queryData);
		$pdo= null;
		$query= 'SELECT count(*) as total FROM `' . $this->getTableName() . '` WHERE ' . substr($queryGet, 2);
		$pdo= $this->getPdoHandler()->prepare($query);
		$pdo->execute($queryData);
		if (!($result= $pdo->fetch()))
		{
			throw new exception('error while updating');
		}
		return true;
	}
	/**
	 * Get the last uniqueID
	 * @return int ID
	 */
	protected function getLastUniqueId()
	{
		$query= 'SELECT ' . $this->getCellNameUniqueId() . ' ';
		$query .= 'FROM `' . $this->getTableName() . '` ';
		$query .= 'ORDER BY ' . $this->getCellNameUniqueId() . ' DESC ';
		$query .= 'LIMIT 0, 1';
		$pdo= $this->getPdoHandler()->prepare($query);
		$pdo->execute();
		if (!($result= $pdo->fetch()))
		{
			return 0;
		}
		return $result[$this->getCellNameUniqueId()];
	}
	/**
	 * Get a new unique ID
	 * @return int ID
	 */
	protected function getNewUniqueId()
	{
		$result= $this->getLastUniqueId();
		$result++;
		return $result;
	}
	/**
	 * Add a new row
	 * @param array $rowData Content for the row
	 * @param int $overrideUniqueId Use your own generated uniqueID
	 * @param string $overrideDateCreated Use your own date
	 * @param string $overrideDateChanged Use your own date
	 * @return int ID for the new row
	 */
	protected function newRow($rowData, $overrideUniqueId= false, $overrideDateCreated= false, $overrideDateChanged= false)
	{
		$uniqueId= false;
		$query= '';
		$queryCheck= '';
		$queryData= array ();
		foreach ($rowData as $key => $value)
		{
			if ($key == $this->getCellNameUniqueId())
			{
				if ($overrideUniqueId === false)
				{
					throw new exception('unique id not accepted for a new row.');
				}
				continue;
			}
			if ($key == $this->getCellNameDateCreated())
			{
				if ($overrideDateCreated === false)
				{
					throw new exception('date created not accepted for a new row.');
				}
				continue;
			}
			if ($key == $this->getCellNameDateChanged())
			{
				if ($overrideDateChanged === false)
				{
					throw new exception('date changed not accepted for a new row.');
				}
				continue;
			}
			$query .= ', `' . $key . '`=? ';
			$queryCheck .= '&& `' . $key . '`=? ';
			$queryData[]= $value;
		}
		$query .= ', `' . $this->getCellNameUniqueId() . '`=? ';
		$queryCheck .= '&& `' . $this->getCellNameUniqueId() . '`=? ';
		if ($overrideUniqueId !== false)
		{
			$queryData[]= $overrideUniqueId;
		}
		else
		{
			$uniqueId= $this->getNewUniqueId();
			$queryData[]= $uniqueId;
		}
		if ($this->getCellNameDateCreated() > '')
		{
			$query .= ', `' . $this->getCellNameDateCreated() . '`=? ';
			$queryCheck .= '&& `' . $this->getCellNameDateCreated() . '`=? ';
			if ($overrideDateCreated === false)
			{
				$overrideDateCreated= time();
			}
			$queryData[]= $this->generateDateCreatedFromTimestamp($overrideDateCreated);
		}
		if ($this->getCellNameDateChanged() > '')
		{
			$query .= ', `' . $this->getCellNameDateChanged() . '`=? ';
			$queryCheck .= '&& `' . $this->getCellNameDateChanged() . '`=? ';
			if ($overrideDateChanged === false)
			{
				$overrideDateChanged= time();
			}
			$queryData[]= $this->generateDateChangedFromTimestamp($overrideDateChanged);
		}
		$query= 'INSERT INTO `' . $this->getTableName() . '` SET ' . substr($query, 2);
		$pdo= $this->getPdoHandler()->prepare($query);
		$pdo->execute($queryData);
		$pdo= null;
		$query= 'SELECT COUNT(*) AS total FROM `' . $this->getTableName() . '` WHERE ' . substr($queryCheck, 2);
		$pdo= $this->getPdoHandler()->prepare($query);
		$pdo->execute($queryData);
		if (!($value= $pdo->fetch()))
		{
			throw new exception('error while creating a row. A most frequent cause: cell_type wrong');
		}
		$pdo= null;
		if ($value['total'] != 1)
		{
			throw new exception('error while creating a row. A most frequent cause: cell_type wrong');
		}
		return $uniqueId;
	}
	/**
	 * Dummy class calculating dateCreated from a timestamp
	 * @param string $timestamp
	 * @return string date
	 */
	protected function generateDateCreatedFromTimestamp($timestamp)
	{
		return $timestamp;
	}
	/**
	 * Dummy class calculating dateChanged from a timestamp
	 * @param string $timestamp
	 * @return string date
	 */
	protected function generateDateChangedFromTimestamp($timestamp)
	{
		return $timestamp;
	}
	/**
	 * Dummy class calculating a timestamp from dateCreated
	 * @param string $date
	 * @return string Timestamp
	 */
	protected function generateTimestampFromDateCreated($date)
	{
		return $date;
	}
	/**
	 * Dummy class calculating a timestamp from dateChanged
	 * @param string $date
	 * @return string Timestamp
	 */
	protected function generateTimestampFromDateChanged($date)
	{
		return $date;
	}
}
?>