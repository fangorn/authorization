<?php

use Fangorn\Users\UsersTable;

include dirname(__DIR__) . '/common.php';

$error = null;

if (!empty($_POST)) {
    // TODO: Фильтруем данные формы
    $email = htmlspecialchars(trim($_POST['email']));
    $password = trim($_POST['password']);

    $user = UsersTable::login($email, $password);
    if ($user) {
        // Сохранить данные в сессию (id)
        session_start();

        $_SESSION['user_id'] = $user->user_id;
        $_SESSION['name']    = $user->name;

        // Редирект на hello.php
        header("Location: hello.php");

        exit();
    } else {
        $error = 'Пользователь не найден';
    }
}

include dirname(__DIR__) . '/view/auth.phtml';
