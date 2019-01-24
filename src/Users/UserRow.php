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

    public function findByEmail(string $email): void {
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

        $arr = $result->fetch(PDO::FETCH_ASSOC);

        if ($arr) {
            $this->user_id       = $arr['user_id'];
            $this->name          = $arr['name'];
            $this->email         = $arr['email'];
            $this->password_hash = $arr['password_hash'];
            return;
        }
        $this->user_id       = null;
        $this->name          = null;
        $this->email         = null;
        $this->password_hash = null;
        return;
    }
}
