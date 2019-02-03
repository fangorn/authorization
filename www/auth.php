<?php

use Fangorn\Filter;
use Fangorn\Users\UsersTable;

include dirname(__DIR__) . '/common.php';

$errors = [];

if (!empty($_POST)) {
    // Фильтруем данные формы
    [$email, $error] = Filter::email($_POST['email'] ?? null);
    if ($error) {
        $errors['email'] = $error;
    }

    [$password, $error] = Filter::password($_POST['password'] ?? null);
    if ($error) {
        $errors['password'] = $error;
    }

    if (empty($errors)) {
        if (UsersTable::getUserByEmail($email) === null) {
            $errors['common'] = 'Пользователь с заданным email в системе не зарегистрирован';
        } else {
            $user = UsersTable::login($email, $password);
            if ($user) {
                // Сохранить данные в сессию
                $_SESSION['user_id'] = $user->user_id;

                // Редирект на hello.php
                header("Location: hello.php");

                exit();
            } else {
                $errors['common'] = 'Неверно введен пароль';
            }
        }
    }
}

include dirname(__DIR__) . '/view/auth.phtml';
