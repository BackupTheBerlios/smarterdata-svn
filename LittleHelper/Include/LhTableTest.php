<?php
class LhTableTest extends LhTable
{
	private $pdoHandler;
	private $notPdoHandler= '';
	private $translation= array ();
	public function __construct(& $pdoHandler, $translation)
	{
		$this->pdoHandler= & $pdoHandler;
		$this->translation= $translation;
		parent :: __construct(& $this->notPdoHandler, $translation);
		$this->checkPdoHandler();
		$this->checkTableName();
		$this->checkCellNameUniqueId();
		$this->checkCellNameParentId();
		$this->checkCellDateCreated();
	}
	private function checkPdoHandler()
	{
		$result= $this->getPdoHandler();
		if (is_object($result))
		{
			echo 'BAD: pdoHandler should be null<br>';
		}
		if ($result === null)
		{
			echo 'BAD: pdoHandler should be null<br>';
		}
		$this->setPdoHandler(& $this->pdoHandler);
		$result= $this->getPdoHandler();
		if (!is_object($result))
		{
			echo 'BAD: pdoHandler should be an object<br>';
		}
		if (strtolower(get_class($result)) !== 'pdo')
		{
			echo 'BAD: pdoHandler should be class pdo<br>';
		}
	}
	private function checkTableName()
	{
		$newValue= '__TEST/';
		if ($this->getTableName() != $this->translation['tableName'])
		{
			echo 'BAD: tableName should be ' . $this->translation['tableName'] . '<br>';
		}
		$this->setTableName($newValue);
		if ($this->getTableName() != $newValue)
		{
			echo 'BAD: tableName should be ' . $newValue . '<br>';
		}
	}
	private function checkCellNameUniqueId()
	{
		$newValue= '__TEST/';
		if ($this->getCellNameUniqueId() != $this->translation['cellNameUniqueId'])
		{
			echo 'BAD: cellNameUniqueId should be ' . $this->translation['cellNameUniqueId'] . '<br>';
		}
		$this->setCellNameUniqueId($newValue);
		if ($this->getCellNameUniqueId() != $newValue)
		{
			echo 'BAD: cellNameUniqueId should be ' . $newValue . '<br>';
		}
	}
	private function checkCellNameParentId()
	{
		$newValue= '__TEST/';
		if ($this->getCellNameParentId() != $this->translation['cellNameParentId'])
		{
			echo 'BAD: cellNameParentId should be ' . $this->translation['cellNameParentId'] . '<br>';
		}
		$this->setCellNameParentId($newValue);
		if ($this->getCellNameParentId() != $newValue)
		{
			echo 'BAD: cellNameParentId should be ' . $newValue . '<br>';
		}
	}
	private function checkCellDateCreated()
	{
		$newValue= '__TEST/';
		if ($this->getCellNameDateCreated() != $this->translation['cellNameDateCreated'])
		{
			echo 'BAD: cellNameDateCreated should be ' . $this->translation['cellNameDateCreated'] . '<br>';
		}
		$this->setCellNameDateCreated($newValue);
		if ($this->getCellNameDateCreated() != $newValue)
		{
			echo 'BAD: cellNameDateCreated should be ' . $newValue . '<br>';
		}
	}
	private function checkCellDateChanged()
	{
		$newValue= '__TEST/';
		if ($this->getCellNameDateChanged() != $this->translation['cellNameDateChanged'])
		{
			echo 'BAD: cellNameDateChanged should be ' . $this->translation['cellNameDateChanged'] . '<br>';
		}
		$this->setCellNameDateChanged($newValue);
		if ($this->getCellNameDateChanged() != $newValue)
		{
			echo 'BAD: cellNameDateChanged should be ' . $newValue . '<br>';
		}
	}
}
?>