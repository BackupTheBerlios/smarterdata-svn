<?php
class DataCore extends Datamanager
{
	protected $DataId= null;
	protected $DataParentId= null;
	protected $DataParentIdChanged= false;
	protected $DataPosition= null;
	protected $DataPositionChanged= false;
	protected $DataDate= null;
	protected $DataAttributes= array ();
	protected $DataAttributesChanged= array ();
	protected $DataValues= array ();
	protected $DataValuesChanged= array ();
	protected $Sorting= array (
		'position' => 'ASC'
	);
	public function __construct($DataId= 0)
	{
	}
	public function __destruct()
	{
	}
	public function SortChildren($Sorting= array (
		'position' => 'ASC'
	))
	{
	}
	public function & FirstChild($DataType= null)
	{
	}
	public function & NextChild($DataType= null)
	{
	}
	public function AllChildrenIds($DataType= null)
	{
	}
	public function SetParentId($DataId= 0)
	{
		if ($this->DataParentId !== $DataId)
		{
			$this->DataParentId= $DataId;
			$this->DataParentIdChanged= true;
		}
	}
	public function SetPosition($Position= 0)
	{
		if ($this->DataPosition !== $Position)
		{
			$this->DataPosition= $Position;
			$this->DataPositionChanged= true;
		}
	}
	public function SetAttribute($AttributeName, $AttributeValue, $AttributeType= 'text')
	{
		if (!isset ($this->DataAttributes[$AttributeName]))
		{
			$this->DataAttributesChanged[$AttributeName]= true;
			$this->DataAttributes[$AttributeName]['date']= time();
			$this->DataAttributes[$AttributeName]['type']= $AttributeType;
			$this->DataAttributes[$AttributeName]['content']= $AttributeValue;
		}
		else
		{
			if ($this->DataAttributes[$AttributeName]['type'] !== $AttributeType)
			{
				$this->DataAttributesChanged[$AttributeName]= true;
				$this->DataAttributes[$AttributeName]['date']= time();
				$this->DataAttributes[$AttributeName]['type']= $AttributeType;
			}
			if ($this->DataAttributes[$AttributeName]['content'] !== $AttributeValue)
			{
				$this->DataAttributesChanged[$AttributeName]= true;
				$this->DataAttributes[$AttributeName]['date']= time();
				$this->DataAttributes[$AttributeName]['content']= $AttributeValue;
			}
		}
	}
	public function SetValue($ValueName, $ValueContent, $ValueType= 'text')
	{
		if (!isset ($this->DataValues[$ValueName]))
		{
			$this->DataValues[$ValueName]['date']= time();
			$this->DataValuesChanged[$ValueName]= true;
			$this->DataValues[$ValueName]['type']= $ValueType;
			$this->DataValues[$ValueName]['content']= $ValueContent;
		}
		else
		{
			if ($this->DataValues[$ValueName]['type'] !== $ValueType)
			{
				$this->DataValues[$ValueName]['date']= time();
				$this->DataValuesChanged[$ValueName]= true;
				$this->DataValues[$ValueName]['type']= $ValueType;
			}
			if ($this->DataValues[$ValueName]['content'] !== $ValueContent)
			{
				$this->DataValues[$ValueName]['date']= time();
				$this->DataValuesChanged[$ValueName]= true;
				$this->DataValues[$ValueName]['content']= $ValueContent;
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
		$QueryData= array ();
		$Query= 'DELETE FROM `td_data` WHERE data_id = ?';
		$QueryData[]= $this->DataId;
		$Pdo= $this->Query($Query);
		$Pdo->Execute($QueryData);
	}
	private function RemoveAttributes()
	{
		$QueryData= array ();
		$Query= 'DELETE FROM `td_data_attribute` WHERE data_id = ?';
		$QueryData[]= $this->DataId;
		$Pdo= $this->Query($Query);
		$Pdo->Execute($QueryData);
	}
	private function RemoveValues()
	{
		$QueryData= array ();
		$Query= 'DELETE FROM `td_data_value` WHERE data_id = ?';
		$QueryData[]= $this->DataId;
		$Pdo= $this->Query($Query);
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
		$UpdateMain= array ();
		if ($this->DataParentIdChanged === true)
		{
			$UpdateMain['data_parent_id']= $this->DataParentId;
		}
		if ($this->DataPositionChanged === true)
		{
			$UpdateMain['data_position']= $this->DataPosition;
		}
		if (sizeof($UpdateMain) == 0)
		{
			return true;
		}
		$UpdateMain['data_date']= time();
		$QueryBit= '';
		$QueryData= array ();
		foreach ($UpdateMain as $Key => $Value)
		{
			$QueryBit .= ', `' . $Key . '`=?';
			$QueryData[]= $Value;
		}
		$Query= 'UPDATE `td_data` SET ';
		$Query .= substr($QueryBit, 1);
		$Query .= ' WHERE `data_id`=?';
		$QueryData[]= $this->DataId;
		$Pdo= self :: $Db->Prepare($Query);
		$Pdo->Execute($QueryData);
		$this->DataParentIdChanged= false;
		$this->DataPositionChanged= false;
	}
	private function StoreAttributes()
	{
		if (sizeof($this->DataAttributesChanged) == 0)
		{
			return true;
		}
		foreach ($this->DataAttributesChanged as $Key => $Values)
		{
			$Value= $this->DataAttributes[$Key];
			$QueryData= array ();
			$Query= 'REPLACE `td_data_attribute` SET ';
			$Query .= ' `data_id` = ?';
			$QueryData[]= $this->DataId;
			$Query .= ' `attribute_name` = ?';
			$QueryData[]= $Key;
			$Query .= ' ,`attribute_type` = ?';
			$QueryData[]= $Value['type'];
			$Query .= ' ,`attribute_date` = ?';
			$QueryData[]= time();
			if ($Value['type'] === 'text')
			{
				$Query .= ' ,`attribute_content_text` = ?';
				$QueryData[]= $Value['content'];
				$Query .= ' ,`attribute_content_binary` = ?';
				$QueryData[]= '';
			}
			else
			{
				$Query .= ' ,`attribute_content_text` = ?';
				$QueryData[]= '';
				$Query .= ' ,`attribute_content_binary` = ?';
				$QueryData[]= $Value['content'];
			}
			$Pdo= $this->Query($Query);
			$Pdo->Execute($QueryData);
			unset ($this->DataAttributesChanged[$Key]);
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
			$Value= $this->DataValues[$Key];
			$QueryData= array ();
			$Query= 'REPLACE `td_data_value` SET ';
			$Query .= ' `data_id` = ?';
			$QueryData[]= $this->DataId;
			$Query .= ' `value_name` = ?';
			$QueryData[]= $Key;
			$Query .= ' ,`value_type` = ?';
			$QueryData[]= $Value['type'];
			$Query .= ' ,`value_date` = ?';
			$QueryData[]= time();
			if ($Value['type'] === 'text')
			{
				$Query .= ' ,`value_content_text` = ?';
				$QueryData[]= $Value['content'];
				$Query .= ' ,`value_content_binary` = ?';
				$QueryData[]= '';
			}
			else
			{
				$Query .= ' ,`value_content_text` = ?';
				$QueryData[]= '';
				$Query .= ' ,`value_content_binary` = ?';
				$QueryData[]= $Value['content'];
			}
			$Pdo= $this->Query($Query);
			$Pdo->Execute($QueryData);
			unset ($this->DataValuesChanged[$Key]);
		}
	}
}
?>