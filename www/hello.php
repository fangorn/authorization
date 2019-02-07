<?php

use Fangorn\Filter;
use Fangorn\Users\UsersTable;

require_once dirname(__DIR__) . '/common.php';

[$id, $error] = Filter::userId($_SESSION['user_id'] ?? null);

if (!$error) {
    // Проверить, что пользователь существует
    $user = UsersTable::getUserById($id);
    if (!$user) {
        $error = 'При авторизации произошла ошибка. Попробуйте еще раз';
    }
}

// В случае ошибок редиректим на страницу с авторизацией
if ($error) {
    header("Location: auth.php");
} else {
    include dirname(__DIR__) . '/view/hello.phtml';
}
