<?php

use Fangorn\Filter;
use Fangorn\Users\UsersTable;

include dirname(__DIR__) . '/common.php';

$errors = [];

if (!empty($_POST)) {

    [$name, $error] = Filter::name($_POST['name'] ?? null);
    if ($error) {
        $errors['name'] = $error;
    }

    [$email, $error] = Filter::email($_POST['email'] ?? null);
    if ($error) {
        $errors['email'] = $error;
    }

    [$password, $error] = Filter::password($_POST['password'] ?? null);
    if ($error) {
        $errors['password'] = $error;
    }

    if (empty($errors)) {
        try {
            if (!UsersTable::getUserByEmail($email)) {
                UsersTable::createUser($name, $email, $password);
                header("Location: auth.php");
            } else {
                $errors['common'] = 'Пользователь с таким email уже зарегистрирован';
            }
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}

include dirname(__DIR__) . '/view/registration.phtml';
