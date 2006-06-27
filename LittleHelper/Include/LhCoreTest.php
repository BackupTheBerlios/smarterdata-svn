<?php
class LhCoreTest extends LhCore
{
	public function __construct(& $pdoHandler, $translation)
	{
		parent :: __construct(& $pdoHandler, $translation);
		$this->checkRef('setPdoHandler', 'getPdoHandler');
		$this->checkVal('setTableName', 'getTableName');
		$this->checkVal('setCellNameUniqueId', 'getCellNameUniqueId');
		$this->checkVal('setCellNameParentId', 'getCellNameParentId');
		$this->checkVal('setCellNameDateCreated', 'getCellNameDateCreated');
		$this->checkVal('setCellNameDateChanged', 'getCellNameDateChanged');
		$this->checkVal('setKeyForChildren', 'getKeyForChildren');
		$this->checkWhere();
		$this->checkOrder();
	}
	public function __destruct()
	{
		parent :: __destruct();
	}
	public function checkRef($setMethod, $getMethod)
	{
		echo $setMethod . '/' . $getMethod . ' ';
		$testvalue= time();
		$test= new LhTest();
		$test->setThis($testvalue);
		parent :: $setMethod ($test);
		if ($test !== parent :: $getMethod ())
		{
			echo ' works incorrect';
		}
		else
		{
			echo ' works correct';
		}
		echo '<br>';
	}
	public function checkVal($setMethod, $getMethod)
	{
		echo $setMethod . '/' . $getMethod . ' ';
		$testvalue= time();
		parent :: $setMethod ($testvalue);
		if ($testvalue !== parent :: $getMethod ())
		{
			echo ' works incorrect';
		}
		else
		{
			echo ' works correct';
		}
		echo '<br>';
	}
	public function checkWhere()
	{
		echo 'where ';
		$where[]= array (
			'cell_name' => 'name1',
			'cell_op' => '>',
			'cell_value' => 'val1'
		);
		$where[]= array (
			'cell_name' => 'name2',
			'cell_op' => '<',
			'cell_value' => 'val2'
		);
		$where[]= array (
			'cell_name' => 'name3',
			'cell_op' => '<',
			'cell_value' => 'val3'
		);
		$shouldBe= 'WHERE `name1`>\'val1\'&& `name2`<\'val2\'&& `name3`<\'val3\'';
		parent :: setWhere($where);
		$error= false;
		if (parent :: getWhere() !== $where)
		{
			echo 'where raw incorrect';
			$error= true;
		}
		if (parent :: getWhereQuery() !== $shouldBe)
		{
			echo 'where query incorrect';
			$error= true;
		}
		if ($error === false)
		{
			echo 'OK';
		}
		echo '<br>';
	}
	public function checkOrder()
	{
		echo 'order ';
		$order[]= array (
			'cell_name' => 'name1',
			'direction' => 'ASC'
		);
		$order[]= array (
			'cell_name' => 'name2',
			'direction' => 'DESC'
		);
		$order[]= array (
			'cell_name' => 'name3',
			'direction' => 'ASC'
		);
		$shouldBe= 'ORDER BY `name1` ASC, `name2` DESC, `name3` ASC';
		parent :: setOrder($order);
		$error= false;
		if ($this->getOrder() !== $order)
		{
			echo 'order query incorrect';
			$error= true;
		}
		if ($this->getOrderQuery() !== $shouldBe)
		{
			echo 'order query incorrect';
			$error= true;
		}
		if ($error === false)
		{
			echo 'OK';
		}
		echo '<br>';
	}
}
?>