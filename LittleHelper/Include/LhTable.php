<?php
class LhTable extends LhCore
{
	private $keyForChildren= '/CHILDREN/';
	private $order;
	private $orderRaw;
	private $where;
	private $whereRaw;
	public function __construct(& $pdoHandler, $translation)
	{
		parent :: __construct(& $pdoHandler, $translation);
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
	public function __destruct()
	{
	}
	public function setKeyForChildren($keyName)
	{
		$this->keyForChildren= $keyName;
	}
	public function getKeyForChildren()
	{
		return $this->keyForChildren;
	}
	public function setOrder($orderRaw)
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
	public function getOrder()
	{
		return $this->orderRaw;
	}
	public function getOrderQuery()
	{
		return $this->order;
	}
	public function setWhere($whereRaw)
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
	public function getWhere()
	{
		return $this->whereRaw;
	}
	public function getWhereQuery()
	{
		return $this->where;
	}
	private function prepareResults($results)
	{
		foreach ($results as $key => $result)
		{
			$results[$key]= $this->prepareResult($result);
		}
		return $results;
	}
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
	public function getTotal()
	{
		$query= 'SELECT COUNT(*) as total FROM `' . $this->getTableName() . '` ';
		$query .= $this->getWhereQuery() . ' ';
		$pdo= $this->getPdoHandler()->prepare($query);
		$pdo->execute();
		if (!($result= $pdo->fetch()))
		{
			return null;
		}
		$pdo= null;
		return $result['total'];
	}
	public function getRow($uniqueId)
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
	public function getFirstRow()
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
	public function getPage($currentPage, $rowsPerPage)
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
	public function getRowsRecursiveDown($parentId)
	{
		/*
		 * Process
		 * Call method
		 *  getRowsRecursiveDown(10);
		 * Query
		 *  SELECT * FROM .. WHERE PARENTID=10
		 * Rows
		 *  11,12,13
		 * Loop (Rows)
		 *  getRowRecursiveDown(UNIQUEID);
		 * End;
		 */
		$currentRow= $this->getRow($parentId);
		if ($currentRow === null)
		{
			return null;
		}
		$return[$currentRow[$this->getCellNameUniqueId()]]= $currentRow;
		$return[$currentRow[$this->getCellNameUniqueId()]][$this->keyForChildren]= $this->getRowsRecursiveDown_($parentId);
		return $return;
	}
	private function getRowsRecursiveDown_($parentId)
	{
		/*
		 * Process
		 * Call method
		 *  getRowsRecursiveDown(10);
		 * Query
		 *  SELECT * FROM .. WHERE PARENTID=10
		 * Rows
		 *  11,12,13
		 * Loop (Rows)
		 *  getRowRecursiveDown(UNIQUEID);
		 * End;
		 */
		$children= $this->getChildren($parentId);
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
	public function getRowsRecursiveUp($uniqueId, $rootUniqueId= 1)
	{
		/*
		 * Process
		 * Call method
		 *  getRowsRecursiveUp(13,0);
		 * Query
		 *  SELECT * FROM .. WHERE UNIQUE=10
		 * Query
		 *  SELECT * FROM .. WHERE UNIQUE=PARENTID
		 * Result
		 *  10
		 *  getRowRecursiveUp(PARENTID);
		 * Query
		 *  SELECT * FROM .. WHERE PARENT
		 * End;
		 */
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
	public function getChildren($parentId)
	{
		$query= 'SELECT * FROM `' . $this->getTableName() . '` WHERE';
		$query .= ' `' . $this->getCellNameParentId() . '`=?';
		$query .= $this->getOrderQuery();
		$queryData[]= $parentId;
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
	public function updateRow($uniqueId, $rowData)
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
		$this->setRow($uniqueId, $rowData);
	}
	public function setRow($uniqueId, $rowData)
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
	public function getLastUniqueId()
	{
		$query= 'SELECT ' . $this->getCellNameUniqueId() . ' ';
		$query .= 'FROM `' . $this->getTableName() . '` ';
		$query .= 'ORDER BY ' . $this->getCellNameUniqueId() . ' DESC ';
		$query .= 'LIMIT 0, 1';
		$pdo= $this->getPdoHandler()->prepare($query);
		$pdo->execute();
		if (!($result= $pdo->fetch()))
		{
			throw new exception('can not get last id');
		}
		return $result[$this->getCellNameUniqueId()];
	}
	public function getNewUniqueId()
	{
		$result= $this->getLastUniqueId();
		$result++;
		return $result;
	}
	public function newRow($rowData, $overrideUniqueId= false, $overrideDateCreated= false, $overrideDateChanged= false)
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
		echo '<pre>' . print_r($queryData, 1) . '</pre>';
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
	protected function generateDateCreatedFromTimestamp($timestamp)
	{
		return $timestamp;
	}
	protected function generateDateChangedFromTimestamp($timestamp)
	{
		return $timestamp;
	}
	protected function generateTimestampFromDateCreated($date)
	{
		return $date;
	}
	protected function generateTimestampFromDateChanged($date)
	{
		return $date;
	}
}
?>