<?php
$rootpath= str_replace('\\', '/', dirname(__FILE__));
require_once $rootpath . '/include/x4core.php';
require_once $rootpath . '/include/x4tension.php';
require_once $rootpath . '/include/x4user.php';
x4core :: init();
x4core :: connect('mysql', 'localhost', 'test', 'test', 'test');
$user= new x4user();
?>