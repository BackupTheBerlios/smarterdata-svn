<?php
class LhCore
{
	private $pdoHandler;
	private $tableName;
	private $cellNameUniqueId;
	private $cellNameParentId;
	private $cellNameDateCreated;
	private $cellNameDateChanged;
	protected function __construct(& $pdoHandler, $translation)
	{
		$this->setPdoHandler(& $pdoHandler);
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
		if (!isset ($translation['cellNameParentId']))
		{
			throw new exception('cellNameParentId not set');
		}
		$this->setCellNameParentId($translation['cellNameParentId']);
		if (isset ($translation['cellNameDateCreated']))
		{
			$this->setCellDateCreated($translation['cellNameDateCreated']);
		}
		if (isset ($translation['cellNameDateChanged']))
		{
			$this->setCellDateChanged($translation['cellNameDateChanged']);
		}
	}
	public function setPdoHandler(& $pdoHandler)
	{
		$this->pdoHandler= & $pdoHandler;
	}
	public function & getPdoHandler()
	{
		return $this->pdoHandler;
	}
	public function setTableName($tableName)
	{
		$this->tableName= $tableName;
	}
	public function getTableName()
	{
		return $this->tableName;
	}
	public function setCellNameUniqueId($cellNameUniqueId)
	{
		$this->cellNameUniqueId= $cellNameUniqueId;
	}
	public function getCellNameUniqueId()
	{
		return $this->cellNameUniqueId;
	}
	public function setCellNameParentId($cellNameParentId)
	{
		$this->cellNameParentId= $cellNameParentId;
	}
	public function getCellNameParentId()
	{
		return $this->cellNameParentId;
	}
	public function setCellDateCreated($cellNameDateCreated)
	{
		$this->cellNameDateCreated= $cellNameDateCreated;
	}
	public function getCellNameDateCreated()
	{
		return $this->cellNameDateCreated;
	}
	public function setCellDateChanged($cellNameDateChanged)
	{
		$this->cellNameDateChanged= $cellNameDateChanged;
	}
	public function getCellNameDateChanged()
	{
		return $this->cellNameDateChanged;
	}
}
?>