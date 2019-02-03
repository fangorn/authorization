<?php

namespace Fangorn;

class Filter {
    /**
     * @param mixed $email
     * @return array (filtered email, error)
     */
    public static function email($email): array {
        if ($email === null) {
            return [$email, 'Не указан email'];
        }

        if (!is_string($email)) {
            return [null, 'Указан некорректный email'];
        }

        $email = strtolower(trim($email));
        if (!$email) {
            return [null, 'Не указан email'];
        }

        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        if ($email === false) {
            return [null, 'Указан некорректный email'];
        }

        return [$email, null];
    }

    /**
     * @param mixed $password
     * @return array (filtered $password, error)
     */
    public static function password($password): array {
        if ($password === null) {
            return [null, 'Введите пароль'];
        }

        if (!is_string($password)) {
            return [null, 'Указан некорректный пароль'];
        }

        $password = trim($_POST['password']);
        if ($password === '') {
            return [null, 'Пароль не может быть пустым'];
        }

        if (strlen($password) < 6) {
            return [null, 'Пароль должен содержать не менее 6 символов'];
        }

        return [$password, null];
    }

    /**
     * @param mixed $name
     * @return array (filtered $name, error)
     */
    public static function name($name): array {
        if ($name === null) {
            return [null, 'Необходимо задать имя'];
        }

        if (!is_string($name)) {
            return [null, 'Некорректно задано имя'];
        }

        $name = trim($name);
        if ($name === '') {
            return [null, 'Имя не может быть пустым'];
        }

        if (preg_match('/^[А-ЯЁа-яё\s-]+$/u', $name) !== 1) {
            return [null, 'Имя должно состоять из русских букв'];
        }

        return [$name, null];
    }

    /**
     * @param mixed $user_id
     * @return array (filtered $user_id, error)
     */
    public static function user_id($user_id) {
        // Проверить, что в сессии есть ключ user_id
        if ($user_id === null) {
            return [null, 'Для просмотра этой страницы необходимо авторизоваться'];
        }
        // Проверить, что в сессии лежит число
        if (preg_match('/^\d*$/', $user_id) !== 1) {
            return [null, 'При авторизации произошла ошибка. Попробуйте еще раз'];
        }
        return [$user_id, null];
    }
}
