<?php

namespace Fangorn\Users;

use Fangorn\App;
use PDO;

class UserRow {
    /** @var int|null */
    public $user_id;

    /** @var string */
    public $name;

    /** @var string */
    public $email;

    /** @var string */
    public $password_hash;

    public function setPassword(string $password): void {
        $this->password_hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }

    public function save(): void {
        $db = App::getDb();

        if ($this->user_id === null) {
            $db->query(
                "
                    INSERT INTO users (name, email, password_hash)
                    VALUE (:name, :email, :password_hash)
                ",
                [
                    'name'          => $this->name,
                    'email'         => $this->email,
                    'password_hash' => $this->password_hash,
                ]
            );

            $this->user_id = $db->getLastInsertedId();
        } else {
            $db->query(
                "
                    UPDATE users 
                    SET
                      name = :name,
                      email = :email,
                      password_hash = :password_hash
                    WHERE user_id = :user_id
                ",
                [
                    'name'          => $this->name,
                    'email'         => $this->email,
                    'password_hash' => $this->password_hash,
                    'user_id'       => $this->user_id,
                ]
            );
        }
    }
}
