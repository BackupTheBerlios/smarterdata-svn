<?php
if (!defined('OK'))
{
	require str_replace('\\', '/', dirname(__FILE__)) . '/../Include.php';
}
$tplvar['userName']= '';
$tplvar['userPassword']= '';
$tplvar['userEmail']= '';
$tplvar['error']= '';
if (isset ($_POST['action']))
{
	if ($_POST['action'] == 'addUser')
	{
		$currentOk= true;
		if (empty ($_POST['userName']))
		{
			$tplvar['error'][]['value']= 'username not set';
			$currentOk= false;
		}
		if (empty ($_POST['userPassword']))
		{
			$tplvar['error'][]['value']= 'password not set';
			$currentOk= false;
		}
		if (empty ($_POST['userEmail']))
		{
			$tplvar['error'][]['value']= 'email not set';
			$currentOk= false;
		}
		if ($currentOk === true)
		{
			try
			{
				$user= $userManager->createUser($_POST['userName'], $_POST['userPassword'], $_POST['userEmail']);
			}
			catch (exceptionUserLogin $error)
			{
				$currentOk= false;
				$tplvar['error'][]['value']= $error->getMessage();
			}
			catch (exceptionUserProblem $error)
			{
				$currentOk= false;
				$tplvar['error'][]['value']= $error->getMessage();
			}
			catch (exceptionUserSql $error)
			{
				$currentOk= false;
				$tplvar['error'][]['value']= $error->getMessage();
			}
			catch (exceptionUserSet $error)
			{
				$currentOk= false;
				$tplvar['error'][]['value']= $error->getMessage();
			}
			unset ($user);
		}
		if ($currentOk === true)
		{
			require $directoryRoot . '/Admin/Overview.php';
			die();
		}
		$tplvar['userName']= $_REQUEST['userName'];
		$tplvar['userPassword']= $_REQUEST['userPassword'];
		$tplvar['userEmail']= $_REQUEST['userEmail'];
	}
}
$tplvar['currentRequestFile']= 'AddUser.php';
$tpl= new SmarterTemplate($directoryRoot . '/Admin/Templates/AddUser.html');
$tpl->assign($tplvar);
echo $tpl->result();
?>