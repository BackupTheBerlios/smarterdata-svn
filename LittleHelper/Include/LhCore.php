<?php
class LhCore extends LhTest
{
	private $pdoHandler;
	private $tableName;
	private $cellNameUniqueId;
	private $cellNameParentId;
	private $cellNameDateCreated;
	private $cellNameDateChanged;
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
		$this->setPdoHandler($pdoHandler);
		if (!isset ($translation['tableName']))
		{
			throw new exception('tableName not set');
		}
		$this->setTableName($translation['tableName']);
		if (!isset ($translation['cellNameUniqueId']))
		{
			throw new exception('cellNameUniqueId not set');
		}
		$this->setCellNameUniqueId($translation['cellNameUniqueId']);
		if (isset ($translation['cellNameParentId']))
		{
			$this->setCellNameParentId($translation['cellNameParentId']);
		}
		if (isset ($translation['cellNameDateCreated']))
		{
			$this->setCellNameDateCreated($translation['cellNameDateCreated']);
		}
		if (isset ($translation['cellNameDateChanged']))
		{
			$this->setCellNameDateChanged($translation['cellNameDateChanged']);
		}
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
	 * Set the pdohandler
	 * @param referenceOfPdo $pdoHandler
	 */
	protected function setPdoHandler(& $pdoHandler)
	{
		$this->pdoHandler= $pdoHandler;
	}
	/**
	 * Get the reference of pdohandler
	 * @return referenceOfPdo
	 */
	protected function & getPdoHandler()
	{
		return $this->pdoHandler;
	}
	/**
	 * Set the name of the table
	 * @param string $tableName
	 */
	protected function setTableName($tableName)
	{
		$this->tableName= $tableName;
	}
	/**
	 * Get the name of the table
	 * @return string
	 */
	protected function getTableName()
	{
		return $this->tableName;
	}
	/**
	 * Set the cell name for uniqueId 
	 * @param string $cellNameUniqueId
	 */
	protected function setCellNameUniqueId($cellNameUniqueId)
	{
		$this->cellNameUniqueId= $cellNameUniqueId;
	}
	/**
	 * Get the cell name for uniqueId 
	 * @return string
	 */
	protected function getCellNameUniqueId()
	{
		return $this->cellNameUniqueId;
	}
	/**
	 * Set the cell name for parentId 
	 * @param string $cellNameParentId
	 */
	protected function setCellNameParentId($cellNameParentId)
	{
		$this->cellNameParentId= $cellNameParentId;
	}
	/**
	 * Get the cell name for parentId 
	 * @return string
	 */
	protected function getCellNameParentId()
	{
		return $this->cellNameParentId;
	}
	/**
	 * Set the cell name for dateCreated 
	 * @param string $cellNameDateCreated
	 */
	protected function setCellNameDateCreated($cellNameDateCreated)
	{
		$this->cellNameDateCreated= $cellNameDateCreated;
	}
	/**
	 * Get the cell name for dateCreated 
	 * @return string
	 */
	protected function getCellNameDateCreated()
	{
		return $this->cellNameDateCreated;
	}
	/**
	 * Set the cell name for dateChanged
	 * @param string $cellNameDateChanged
	 */
	protected function setCellNameDateChanged($cellNameDateChanged)
	{
		$this->cellNameDateChanged= $cellNameDateChanged;
	}
	/**
	 * Get the cell name for dateChanged
	 * @return string
	 */
	protected function getCellNameDateChanged()
	{
		return $this->cellNameDateChanged;
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
			$orderQuery .= ', `' . $order['cell_name'] . '` ' . $order['direction'];
		}
		if (strlen($orderQuery) > 0)
		{
			$this->order= 'ORDER BY ';
			$this->order .= trim(substr($orderQuery, 2));
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
			$whereQuery .= '&& `' . $where['cell_name'] . '`' . $where['cell_op'] . '\'' . $where['cell_value'] . '\'';
		}
		if (strlen($whereQuery) > 0)
		{
			$this->where= 'WHERE ';
			$this->where .= trim(substr($whereQuery, 2));
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
	protected function prepareResults($results)
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
	protected function prepareResult($result)
	{
		foreach ($result as $key => $value)
		{
			if (is_array($value))
			{
				$result[$key]= $value;
			}
			else
			{
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
					default :
						{
							$result[$key]= $value;
						}
				}
			}
		}
		return $result;
	}
}
?>