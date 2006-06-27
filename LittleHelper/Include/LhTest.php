<?php
class LhTest
{
	private $setThis;
	public function __construct()
	{
	}
	public function __destruct()
	{
	}
	public function setThis($setThis)
	{
		$this->setThis= $setThis;
	}
	public function getThis()
	{
		return $this->setThis;
	}
}
?>