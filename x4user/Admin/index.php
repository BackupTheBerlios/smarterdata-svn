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
$userManager->getUserlist('%', $currentPage, 30);
?>