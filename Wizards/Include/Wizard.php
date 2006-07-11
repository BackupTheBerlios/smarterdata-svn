<?php
class Wizard
{
	static protected $dataHandlerGlobal;
	private static function __construct()
	{
	}
	private static function __destruct()
	{
	}
	static public function & NewWizard($wizardName)
	{
		$wizardPattern= '/^([a-zA-Z0-1_]{1,})$/';
		if (!preg_match($wizardPattern, $wizardName))
		{
			throw new exception('Allowed wizard characters: ' . $wizardPattern . '    ,    given: ' . $wizardName);
		}
		$wizardNameClass= 'Wizard' . $wizardName;
		$currentDirectory= str_replace('\\', '/', dirname(__FILE__));
		$wizardFileName= $wizardNameClass . '.php';
		$wizardFileNameAbsolute= $currentDirectory . '/' . $wizardFileName;
		if (!class_exists($wizardNameClass))
		{
			if (!file_exists($wizardFileNameAbsolute))
			{
				throw new exception('Wizard does not exist: ' . $wizardName . ' ( ' . $wizardNameClass . '), at position: ' . $wizardFileNameAbsolute);
			}
			require_once $wizardFileNameAbsolute;
		}
		return new $wizardNameClass ();
	}
	static public function setDataHandlerGlobal(& $dataHandlerGlobal)
	{
		self :: $dataHandlerGlobal= & $dataHandlerGlobal;
	}
}
?>