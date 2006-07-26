<?php
require_once str_replace('\\', '/', dirname(__FILE__)) . '/include/UserExceptions.php';
require_once str_replace('\\', '/', dirname(__FILE__)) . '/include/UserManager.php';
require_once str_replace('\\', '/', dirname(__FILE__)) . '/include/User.php';
try
{
	$userManager= new UserManager(& $_G['db']);
	if ($userManager->checkUserExist('root') == false)
	{
		$userManager->createUser('root', 'rootpw', 'root@localhost');
	}
	$user= $userManager->loginAsUser('root', 'rootpw');
}
catch (exceptionUserLogin $error)
{
	echo '<pre>' . print_r($error->getMessage(), 1) . '</pre>';
}
catch (exceptionUserProblem $error)
{
	echo '<pre>' . print_r($error->getMessage(), 1) . '</pre>';
}
catch (exceptionUserSql $error)
{
	echo '<pre>' . print_r($error->getMessage(), 1) . '</pre>';
}
catch (exceptionUserSet $error)
{
	echo '<pre>' . print_r($error->getMessage(), 1) . '</pre>';
}
?>