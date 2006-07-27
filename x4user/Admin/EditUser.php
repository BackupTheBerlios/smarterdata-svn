<?php
if (!defined('OK'))
{
	require str_replace('\\', '/', dirname(__FILE__)) . '/../Include.php';
}
if (!is_numeric($_REQUEST['userId']))
{
	require $directoryRoot . '/Admin/Overview.php';
	die();
}
$currentErrors= '';
$user= $userManager->getUserById((int) $_REQUEST['userId']);
if (isset ($_POST['action']))
{
	if ($_POST['action'] == 'editUser')
	{
		if (!empty ($_POST['userName']))
		{
			$user->setUserName($_POST['userName']);
		}
		if (!empty ($_POST['userPassword']))
		{
			$user->setUserPassword($_POST['userPassword']);
		}
		if (!empty ($_POST['userEmail']))
		{
			$user->setUserEmail($_POST['userEmail']);
		}
	}
}
$tplvar['error']= $currentErrors;
$tplvar['userName']= $user->getUserName();
$tplvar['userId']= (int) $_REQUEST['userId'];
$tplvar['userPassword']= $user->getUserPassword();
$tplvar['userEmail']= $user->getUserEmail();
$tplvar['currentRequestFile']= 'EditUser.php';
$tpl= new SmarterTemplate($directoryRoot . '/Admin/Templates/EditUser.html');
$tpl->assign($tplvar);
echo $tpl->result();
?>