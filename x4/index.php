<?php
require_once str_replace('\\', '/', dirname(__FILE__)) . '/../include.php';
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