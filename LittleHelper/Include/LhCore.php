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
	}
	protected function setPdoHandler(& $pdoHandler)
	{
		$this->pdoHandler = $pdoHandler;
	}
	protected function & getPdoHandler()
	{
		return $this->pdoHandler;
	}
	protected function setTableName($tableName)
	{
		$this->tableName = $tableName;
	}
	protected function getTableName()
	{
		return $this->tableName;
	}
	protected function setCellNameUniqueId($cellNameUniqueId)
	{
		$this->cellNameUniqueId = $cellNameUniqueId;
	}
	protected function getCellNameUniqueId()
	{
		return $this->cellNameUniqueId;
	}
	protected function setCellNameParentId($cellNameParentId)
	{
		$this->cellNameParentId = $cellNameParentId;
	}
	protected function getCellNameParentId()
	{
		return $this->cellNameParentId;
	}
	protected function setCellNameDateCreated($cellNameDateCreated)
	{
		$this->cellNameDateCreated = $cellNameDateCreated;
	}
	protected function getCellNameDateCreated()
	{
		return $this->cellNameDateCreated;
	}
	protected function setCellNameDateChanged($cellNameDateChanged)
	{
		$this->cellNameDateChanged = $cellNameDateChanged;
	}
	protected function getCellNameDateChanged()
	{
		return $this->cellNameDateChanged;
	}
}
?>