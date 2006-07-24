<?php
$rootpath= str_replace('\\', '/', dirname(__FILE__));
require_once $rootpath . '/include/x4core.php';
require_once $rootpath . '/include/x4tension.php';
require_once $rootpath . '/include/x4user.php';
x4core :: init();
x4core :: connect('mysql', 'localhost', 'test', 'test', 'test');
$user= new x4user();
$user->loginForAdmin('root');
echo $user->getUserId();
#$user->newUser('root', 'root', 'root@localhost');
#$user->login('root', 'root');
#$user->setUserPassword('root');
#$user->setUserEmail('root2@localhost');
#$user->setUserActivated(true);
#$user->setUserBaned(true);
#$user->setUserBanedTo(true);
?>