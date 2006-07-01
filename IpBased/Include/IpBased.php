<?php
class IpBased
{
	//List of the private ips described in the RFC.
	private $ip_private_list = array (
		'10.0.0.0/8',
		'172.16.0.0/12',
		'192.168.0.0/16'
	);
	private $dataDirectory = '';
	private $currentIp = '';
	public function __construct()
	{
		$this->dataDirectory = str_replace('\\', '/', dirname(__FILE__));
		$this->dataDirectory .= '/Data';
		if (!is_dir($this->dataDirectory))
		{
			if (!@ mkdir($this->dataDirectory, 0700))
			{
				throw new exception('can not create data directory');
			}
		}
		$this->currentIp = $this->findIp();
	}
	public function functionOk($functionName, $minTime)
	{
		$functionHash = sha1($functionName);
		$directory = $this->dataDirectory . '/' . $functionHash;
		if (!is_dir($directory))
		{
			if (!@ mkdir($directory, 0700))
			{
				throw new exception('can not create function directory');
			}
		}
		$clientFile = $directory . '/' . $this->currentIp;
		if (file_exists($clientFile))
		{
			$clientData = trim(implode('', file($clientFile)));
			if (time() < $minTime + $clientData)
			{
				return false;
			}
		}
		$fileHandler = fopen($clientFile, 'w');
		if (!$fileHandler)
		{
			throw new exception('can not create/overwrite client file');
		}
		fputs($fileHandler, time());
		fclose($fileHandler);
		return true;
	}
	public function getIp()
	{
		return $this->currentIp;
	}
	private function findIp()
	{
		$ip = 'unknown';
		$ip_array = $this->getIpArray();
		foreach ($ip_array as $ip_s)
		{
			if ($ip_s != '' AND !$this->isIPInNetArray($ip_s, $this->ip_private_list))
			{
				$ip = $ip_s;
				break;
			}
		}
		return ($ip);
	}
	private function isIPInNet($ip, $net, $mask)
	{
		$lnet = ip2long($net);
		$lip = ip2long($ip);
		$binnet = str_pad(decbin($lnet), 32, '0', 'STR_PAD_LEFT');
		$firstpart = substr($binnet, 0, $mask);
		$binip = str_pad(decbin($lip), 32, '0', 'STR_PAD_LEFT');
		$firstip = substr($binip, 0, $mask);
		return (strcmp($firstpart, $firstip) == 0);
	}
	private function isIpInNetArray($theip, $thearray)
	{
		$exit_c = false;
		foreach ($thearray as $subnet)
		{
			list ($net, $mask) = split('/', $subnet);
			if ($this->isIPInNet($theip, $net, $mask))
			{
				$exit_c = true;
				break;
			}
		}
		return ($exit_c);
	}
	private function getIpArray()
	{
		$arIps = array ();
		if (isset ($_SERVER['HTTP_X_FORWARDED_FOR']))
		{
			if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ','))
			{
				$arIps = array_merge($arIps, explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
			}
			else
			{
				array_push($arIps, $_SERVER['HTTP_X_FORWARDED_FOR']);
			}
		}
		array_push($arIps, $_SERVER['REMOTE_ADDR']);
		return $arIps;
	}
}
?>