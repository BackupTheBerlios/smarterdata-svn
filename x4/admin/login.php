<?php
require_once str_replace('\\', '/', dirname(__FILE__)) . '/../include.php';
if ($user->getUserType() === false)
{
	if (isset ($_POST['userName']) && isset ($_POST['userPassword']))
	{
		try
		{
			$user->login($_POST['userName'], $_POST['userPassword']);
		}
		catch (exception $error)
		{
			echo $error;
			require $rootpath . '/admin/templates/login.html';
			exit (1);
		}
	}
	else
	{
		echo $error;
		require $rootpath . '/admin/templates/login.html';
		exit (1);
	}
}
?>