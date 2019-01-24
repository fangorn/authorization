<?php

use Fangorn\Users\UsersTable;

include dirname(__DIR__) . '/common.php';

include dirname(__DIR__) . '/view/registration.phtml';

if (empty($_POST)) {
    die();
}

$name  = htmlspecialchars(trim($_POST['name']));
$email = htmlspecialchars(trim($_POST['email']));
$password = trim($_POST['password']);

try {
    if ($name !== '' && $email !== '' && $password !== '') {
        UsersTable::createUser($name, $email, $password);
    }
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
