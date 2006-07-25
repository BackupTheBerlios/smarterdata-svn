<?php
class x4tension extends x4core
{
	public final function __construct()
	{
		if (self :: isInitialized() !== true)
		{
			throw new exception('Please initialize first');
		}
		if (self :: isConnected() !== true)
		{
			throw new exception('Please initialize first');
		}
		parent :: setAllowChangeInit(false);
		$this->initPart();
	}
	public final function __destruct()
	{
		$this->deInitPart();
	}
	public function initPart()
	{
	}
	public function deInitPart()
	{
	}
}
?>