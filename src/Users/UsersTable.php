<?php

namespace Fangorn\Users;

use PDO;
use Fangorn\App;

class UsersTable {

    public static function makeUnsavedRow(): UserRow {
        return new UserRow();
    }

    public static function createFromArray(array $data): UserRow {
        $user = static::makeUnsavedRow();
        foreach ($data as $name => $value) {
            $user->{$name} = $value;
        }
        return $user;
    }

    public static function createUser(string $name, string $email, string $password): UserRow {
        $user = self::makeUnsavedRow();

        $user->name  = $name;
        $user->email = $email;
        $user->setPassword($password);
        $user->save();

        return $user;
    }

    public static function login(string $email, string $password): ?UserRow {
        $user = static::getUserByEmail($email);

        if (!$user) {
            return null;
        }

        if (!password_verify($password, $user->password_hash)) {
            return null;
        }

        return $user;
    }

    public static function getUserByEmail(string $email): ?UserRow {
        $db = App::getDb();

        $result = $db->query(
            "
                SELECT user_id, name, email, password_hash
                FROM users
                WHERE email = :email
            ",
            [
                'email' => $email,
            ]
        );

        $data = $result->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return static::createFromArray($data);
        }

        return null;
    }

    public static function getUserById(int $user_id) {
        $db = App::getDb();

        $result = $db->query(
            "
                SELECT user_id, name, email, password_hash
                FROM users
                WHERE user_id = :user_id
            ",
            [
                'user_id' => $user_id,
            ]
        );

        $data = $result->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return static::createFromArray($data);
        }

        return null;
    }
}
