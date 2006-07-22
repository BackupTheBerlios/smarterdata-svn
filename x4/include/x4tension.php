<?php
class x4tension extends x4core
{
	public function __construct()
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
	public function __destruct()
	{
		$this->store();
	}
	protected function initPart()
	{
	}
	protected function load()
	{
	}
	protected function store()
	{
	}
}
?>