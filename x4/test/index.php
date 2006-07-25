<?php
require_once str_replace('\\', '/', dirname(__FILE__)) . '/../include.php';
$user->loginForAdmin('root');
if($user->getUserType()===false)
{
	echo 'loged in user is '.$user->getUserName().'<br>';
}
else
{
	echo 'loged in user is '.$user->getUserName().'<br>';
	$user->setUserPassword($user->getUserName());
	$user->setUserEmail($user->getUserName());
	$user->setUserActivated('Y');
	$user->setUserBaned('Y');
	$user->setUserBanedTo(time()+3600);

}
#echo $user->getUserId();
#$user->newUser('root', 'root', 'root@localhost');
#$user->login('root', 'root');
?>