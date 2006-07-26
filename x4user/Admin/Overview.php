<?php
if (!defined('OK'))
{
	require str_replace('\\', '/', dirname(__FILE__)) . '/../Include.php';
}
$currentPage= 0;
if (isset ($_POST['currentPage']))
{
	$currentPage= (int) $_POST['currentPage'];
}
if ($currentPage < 0)
{
	$currentPage= 0;
}
$userList= $userManager->getUserlist('%', $currentPage, 30);
$tplVar['userList']= $userList;
$tplVar['POST']= $_POST;
$tpl= new SmarterTemplate($directoryRoot . '/Admin/Templates/Overview.php');
$tpl->assign($tplVar);
$page= $Tpl->Result();
echo $page;
?>