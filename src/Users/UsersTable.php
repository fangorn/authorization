<?php

namespace Fangorn\Users;

class UsersTable {
    /** @var string */
    protected $name = 'Users';

    /** @var string */
    protected $rowClass = UserRow::class;

    public static function makeUnsavedRow(): UserRow {
        return new UserRow();
    }

    public static function createUser(string $name, string $email, string $password): UserRow {
        $user = self::makeUnsavedRow();

        $user->name  = $name;
        $user->email = $email;
        $user->setPassword($password);
        $user->save();

        return $user;
    }
}
