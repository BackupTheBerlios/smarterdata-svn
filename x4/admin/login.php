<?php
require_once str_replace('\\', '/', dirname(__FILE__)) . '/../include.php';
if ($user->getUserId() === false)
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
?>