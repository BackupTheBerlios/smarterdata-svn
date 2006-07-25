<?php
require_once str_replace('\\', '/', dirname(__FILE__)) . '/include/userexceptions.php';
require_once str_replace('\\', '/', dirname(__FILE__)) . '/include/usercore.php';
require_once str_replace('\\', '/', dirname(__FILE__)) . '/include/user.php';
$_G['db']= mysql_connect('localhost', 'test', 'test');
if (!mysql_select_db('test', $_G['db']))
{
	die('Can not use database: ' . $dbDatabase);
}
try
{
	if(usercore::checkUserExist('root')==false)
	{
		usercore::createUser('root', 'rootpw', 'root@localhost');
	}
	$user= new user(& $_G['db'], 'root', 'rootpw');
}
catch( exceptionUserLogin $error)
{
	echo '<pre>'.print_r($error->getMessage(), 1).'</pre>';;
}
catch( exceptionUserProblem $error)
{
	echo '<pre>'.print_r($error->getMessage(), 1).'</pre>';;
}
catch( exceptionUserSql $error)
{
	echo '<pre>'.print_r($error->getMessage(), 1).'</pre>';;
}
catch( exceptionUserSet $error)
{
	echo '<pre>'.print_r($error->getMessage(), 1).'</pre>';;
}
?>