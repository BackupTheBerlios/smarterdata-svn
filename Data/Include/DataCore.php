<?php
class DataCore extends Datamanager
{
	private $DataId = null;
	private $DataParentId = null;
	private $DataParentIdChanged = false;
	private $DataPosition = null;
	private $DataPositionChanged = false;
	private $DataDate = null;
	private $DataAttributes = array ();
	private $DataAttributesChanged = array ();
	private $DataValues = array ();
	private $DataValuesChanged = array ();
	private $Sorting = array (
		'position' => 'ASC'
	);
	public function __construct($DataId)
	{
		$this->DataId = $DataId;
		$this->Load();
	}
	public function __destruct()
	{
		$this->Store();
	}
	private function Load()
	{
		$this->LoadMain();
		$this->LoadAttributes();
		$this->LoadValues();
	}
	private function LoadMain()
	{
		$QueryData = array ();
		$QueryData[] = $this->DataId;
		$Query = 'SELECT * FROM `td_data` WHERE data_id=?';
		$Pdo = self :: $Db->Prepare($Query);
		$Pdo->Execute($QueryData);
		$DataCommon = $Pdo->Fetch();
		$Pdo=null;
		$this->DataType = stripslashes($DataCommon['data_type']);
		$this->DataParentId = stripslashes($DataCommon['data_parent_id']);
		$this->DataPosition = stripslashes($DataCommon['data_position']);
		$this->DataDate = stripslashes($DataCommon['data_date']);
	}
	private function LoadAttributes()
	{
		$QueryData = array ();
		$QueryData[] = $this->DataId;
		$Query = 'SELECT * FROM `td_data_attribute` WHERE data_id=?';
		$Pdo = self :: $Db->Prepare($Query);
		$Pdo->Execute($QueryData);
		$DataAttributes = $Pdo->FetchAll();
		$Pdo=null;
		foreach ($DataAttributes as $Attribute)
		{
			$this->DataAttributes[$Attribute['attribute_name']]['date'] = stripslashes($Attribute['attribute_type']);
			$this->DataAttributes[$Attribute['attribute_name']]['type'] = stripslashes($Attribute['attribute_type']);
			if ($this->DataAttributes[$Attribute['attribute_name']]['type'] === 'text')
			{
				$this->DataAttributes[$Attribute['attribute_name']]['content'] = stripslashes($Attribute['attribute_content_text']);
			}
			else
			{
				$this->DataAttributes[$Attribute['attribute_name']]['content'] = stripslashes($Attribute['attribute_content_binary']);
			}
		}
	}
	private function LoadValues()
	{
		$QueryData = array ();
		$QueryData[] = $this->DataId;
		$Query = 'SELECT * FROM `td_data_value` WHERE data_id=?';
		$Pdo = self :: $Db->Prepare($Query);
		$Pdo->Execute($QueryData);
		$DataValues = $Pdo->FetchAll();
		$Pdo=null;
		foreach ($DataValues as $Value)
		{
			$this->DataValues[$Value['value_name']]['date'] = stripslashes($Value['value_type']);
			$this->DataValues[$Value['value_name']]['type'] = stripslashes($Value['value_type']);
			if ($this->DataValues[$Value['value_name']]['type'] === 'text')
			{
				$this->DataValues[$Value['value_name']]['content'] = stripslashes($Value['value_content_text']);
			}
			else
			{
				$this->DataValues[$Value['value_name']]['content'] = stripslashes($Value['value_content_binary']);
			}
		}
	}
	public function SortChildren($Sorting = array (
		'position' => 'ASC'
	))
	{
	}
	public function & FirstChild($DataType = null)
	{
	}
	public function & NextChild($DataType = null)
	{
	}
	public function AllChildrenIds($DataType = null)
	{
	}
	public function SetParentId($DataId = 0)
	{
		if ($this->DataParentId !== $DataId)
		{
			$this->DataParentId = $DataId;
			$this->DataParentIdChanged = true;
		}
	}
	public function SetPosition($Position = 0)
	{
		if ($this->DataPosition !== $Position)
		{
			$this->DataPosition = $Position;
			$this->DataPositionChanged = true;
		}
	}
	public function SetAttribute($AttributeName, $AttributeValue, $AttributeType = 'text')
	{
		if (!isset ($this->DataAttributes[$AttributeName]))
		{
			$this->DataAttributesChanged[$AttributeName] = true;
			$this->DataAttributes[$AttributeName]['date'] = time();
			$this->DataAttributes[$AttributeName]['type'] = $AttributeType;
			$this->DataAttributes[$AttributeName]['content'] = $AttributeValue;
		}
		else
		{
			if ($this->DataAttributes[$AttributeName]['type'] !== $AttributeType)
			{
				$this->DataAttributesChanged[$AttributeName] = true;
				$this->DataAttributes[$AttributeName]['date'] = time();
				$this->DataAttributes[$AttributeName]['type'] = $AttributeType;
			}
			if ($this->DataAttributes[$AttributeName]['content'] !== $AttributeValue)
			{
				$this->DataAttributesChanged[$AttributeName] = true;
				$this->DataAttributes[$AttributeName]['date'] = time();
				$this->DataAttributes[$AttributeName]['content'] = $AttributeValue;
			}
		}
	}
	public function SetValue($ValueName, $ValueContent, $ValueType = 'text')
	{
		if (!isset ($this->DataValues[$ValueName]))
		{
			$this->DataValues[$ValueName]['date'] = time();
			$this->DataValuesChanged[$ValueName] = true;
			$this->DataValues[$ValueName]['type'] = $ValueType;
			$this->DataValues[$ValueName]['content'] = $ValueContent;
		}
		else
		{
			if ($this->DataValues[$ValueName]['type'] !== $ValueType)
			{
				$this->DataValues[$ValueName]['date'] = time();
				$this->DataValuesChanged[$ValueName] = true;
				$this->DataValues[$ValueName]['type'] = $ValueType;
			}
			if ($this->DataValues[$ValueName]['content'] !== $ValueContent)
			{
				$this->DataValues[$ValueName]['date'] = time();
				$this->DataValuesChanged[$ValueName] = true;
				$this->DataValues[$ValueName]['content'] = $ValueContent;
			}
		}
	}
	public function Remove()
	{
		$this->RemoveMain();
		$this->RemoveAttributes();
		$this->RemoveValues();
	}
	private function RemoveMain()
	{
		$QueryData = array ();
		$Query = 'DELETE FROM `td_data` WHERE data_id = ?';
		$QueryData[] = $this->DataId;
		$Pdo = self::$Db->Query($Query);
		$Pdo->Execute($QueryData);
	}
	private function RemoveAttributes()
	{
		$QueryData = array ();
		$Query = 'DELETE FROM `td_data_attribute` WHERE data_id = ?';
		$QueryData[] = $this->DataId;
		$Pdo = self::$Db->Query($Query);
		$Pdo->Execute($QueryData);
	}
	private function RemoveValues()
	{
		$QueryData = array ();
		$Query = 'DELETE FROM `td_data_value` WHERE data_id = ?';
		$QueryData[] = $this->DataId;
		$Pdo = self::$Db->Query($Query);
		$Pdo->Execute($QueryData);
	}
	public function Store()
	{
		$this->StoreMain();
		$this->StoreAttributes();
		$this->StoreValues();
	}
	private function StoreMain()
	{
		$UpdateMain = array ();
		if ($this->DataParentIdChanged === true)
		{
			$UpdateMain['data_parent_id'] = $this->DataParentId;
		}
		if ($this->DataPositionChanged === true)
		{
			$UpdateMain['data_position'] = $this->DataPosition;
		}
		if (sizeof($UpdateMain) == 0)
		{
			return true;
		}
		$UpdateMain['data_date'] = time();
		$QueryBit = '';
		$QueryData = array ();
		foreach ($UpdateMain as $Key => $Value)
		{
			$QueryBit .= ', `' . $Key . '`=?';
			$QueryData[] = $Value;
		}
		$Query = 'UPDATE `td_data` SET ';
		$Query .= substr($QueryBit, 1);
		$Query .= ' WHERE `data_id`=?';
		$QueryData[] = $this->DataId;
		$Pdo = self :: $Db->Prepare($Query);
		$Pdo->Execute($QueryData);
		$Pdo=null;
		$this->DataParentIdChanged = false;
		$this->DataPositionChanged = false;
		$this->DataDate=$UpdateMain['data_date'];
		self :: _CheckStoredMain($this->DataId, $this->DataType, $this->DataParentId, $this->DataPosition, $this->DataDate);
	}
	private function StoreAttributes()
	{
		if (sizeof($this->DataAttributesChanged) == 0)
		{
			return true;
		}
		foreach ($this->DataAttributesChanged as $Key => $Values)
		{
			$Value = $this->DataAttributes[$Key];
			$QueryData = array ();
			$Query = 'REPLACE INTO `td_data_attribute` SET ';
			$Query .= ' data_id=?';
			$QueryData[] = $this->DataId;
			$Query .= ' , attribute_name=?';
			$QueryData[] = $Key;
			$Query .= ' , attribute_type=?';
			$QueryData[] = $Value['type'];
			$Query .= ' , attribute_date=?';
			$QueryData[] = time();
			if ($Value['type'] === 'text')
			{
				$Query .= ' , attribute_content_text=?';
				$QueryData[] = $Value['content'];
				$Query .= ' , attribute_content_binary=?';
				$QueryData[] = '';
			}
			else
			{
				$Query .= ' , attribute_content_text=?';
				$QueryData[] = '';
				$Query .= ' , attribute_content_binary=?';
				$QueryData[] = $Value['content'];
			}
			$Pdo = self::$Db->Prepare($Query);
			$Pdo->Execute($QueryData);
			unset ($this->DataAttributesChanged[$Key]);
		}
	}
	private function _CheckStoredAttribute($AttributeName, $AttributeType, $AttributeDate, $AttributeContentText, $AttributeContentBinary)
	{
		$Query = 'SELECT COUNT(*) AS total FROM `td_data_attribute` WHERE ';
		$Query .= ' `data_id`=?';
		$QueryData[] = $this->DataId;
		$Query .= ' && `attribute_name`=?';
		$QueryData[] = $AttributeName;
		$Query .= ' && `attribute_type`=?';
		$QueryData[] = $AttributeType;
		$Query .= ' && `attribute_date`=?';
		$QueryData[] = $AttributeDate;
		$Query .= ' && `attribute_content_text`=?';
		$QueryData[] = $AttributeContentText;
		$Query .= ' && `attribute_content_binary`=?';
		$QueryData[] = $AttributeContentBinary;
		$Pdo = self::$Db->Query($Query);
		$Pdo->Execute($QueryData);
		if (!($Value = $Pdo->Fetch()))
		{
			throw new exception('Attribute wrong! 1');
		}
		if ($Value['total'] != 1)
		{
			throw new exception('Attribute wrong! 2');
		}
	}
	private function StoreValues()
	{
		if (sizeof($this->DataValuesChanged) == 0)
		{
			return true;
		}
		foreach ($this->DataValuesChanged as $Key => $Values)
		{
			$Value = $this->DataValues[$Key];
			$QueryData = array ();
			$Query = 'REPLACE `td_data_value` SET ';
			$Query .= ' `data_id` = ?';
			$QueryData[] = $this->DataId;
			$Query .= ' `value_name` = ?';
			$QueryData[] = $Key;
			$Query .= ' ,`value_type` = ?';
			$QueryData[] = $Value['type'];
			$Query .= ' ,`value_date` = ?';
			$Time = time();
			$QueryData[] = $Time;
			if ($Value['type'] === 'text')
			{
				$Value['content_text'] = $Value['content'];
				$Value['content_binary'] = '';
			}
			else
			{
				$Value['content_text'] = '';
				$Value['content_binary'] = $Value['content'];
			}
			$Query .= ' ,`value_content_text` = ?';
			$QueryData[] = $Value['content_text'];
			$Query .= ' ,`value_content_binary` = ?';
			$QueryData[] = $Value['content_binary'];
			$Pdo = self::$Db->Query($Query);
			$Pdo->Execute($QueryData);
			$this->_CheckStoredValue($Key, $Value['type'], $Time, $Value['content_text'], $Value['content_binary']);
			unset ($this->DataValuesChanged[$Key]);
		}
	}
	private function _CheckStoredValue($ValueName, $ValueType, $ValueDate, $ValueContentText, $ValueContentBinary)
	{
		$Query = 'SELECT COUNT(*) AS total FROM `td_data_value` WHERE ';
		$Query .= ' `data_id`=?';
		$QueryData[] = $this->DataId;
		$Query .= ' && `value_name`=?';
		$QueryData[] = $ValueName;
		$Query .= ' && `value_type`=?';
		$QueryData[] = $ValueType;
		$Query .= ' && `value_date`=?';
		$QueryData[] = $ValueDate;
		$Query .= ' && `value_content_text`=?';
		$QueryData[] = $ValueContentText;
		$Query .= ' && `value_content_binary`=?';
		$QueryData[] = $ValueContentBinary;
		$Pdo = self::$Db->Query($Query);
		$Pdo->Execute($QueryData);
		if (!($Value = $Pdo->Fetch()))
		{
			throw new exception('Value wrong!');
		}
		if ($Value['total'] != 1)
		{
			throw new exception('Value exists more than one time!');
		}
	}
}
?>