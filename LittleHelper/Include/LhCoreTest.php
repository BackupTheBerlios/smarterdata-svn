<?php
class LhCoreTest extends LhCore
{
	public function __construct(& $pdoHandler, $translation)
	{
		parent :: __construct(& $pdoHandler, $translation);
		parent :: checkRef('setPdoHandler', 'getPdoHandler');
		parent :: checkVal('setTableName', 'getTableName');
		parent :: checkVal('setCellNameUniqueId', 'getCellNameUniqueId');
		parent :: checkVal('setCellNameParentId', 'getCellNameParentId');
		parent :: checkVal('setCellNameDateCreated', 'getCellNameDateCreated');
		parent :: checkVal('setCellNameDateChanged', 'getCellNameDateChanged');
		parent :: checkVal('setKeyForChildren', 'getKeyForChildren');
		parent :: checkWhere();
		parent :: checkOrder();
	}
	public function __destruct()
	{
		parent :: __destruct();
	}
}
?>