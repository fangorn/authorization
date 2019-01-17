<?php

use Fangorn\Users\UsersTable;

include dirname(__DIR__) . '/view/registration.phtml';

error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('display_startup_errors', true);

if (empty($_POST)) {
    die();
}

try {
    $user = UsersTable::createUser($_POST['name'], $_POST['email'], $_POST['password']);

    var_dump($user);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
