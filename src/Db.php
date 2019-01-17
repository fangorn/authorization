<?php

namespace Fangorn;

use Config;
use PDO;
use PDOException;
use PDOStatement;


class Db {
    /** @var PDO */
    private $connection;

    private function __construct(string $user, string $password, string $schema) {
        $this->connection = new PDO("mysql:host=localhost;dbname={$schema}", $user, $password);
    }

    /** @var Db */
    private static $db;

    public static function getInstance(): self {
        if (self::$db === null) {
            $config   = App::getConfig();
            self::$db = new self($config->databaseUser, $config->databasePassword, $config->databaseSchema);
        }
        return self::$db;
    }

    public function query(string $query, array $params = []): PDOStatement {
        $stmt = $this->connection->prepare($query);

        foreach ($params as &$key => $value) {
            $key = ":{$key}";
        }
        unset($key);

        $result = $stmt->execute($params);
        if (!$result) {
            throw new PDOException("Result is false");
        }

        return $stmt;
    }

    public function getLastInsertedId(): int {
        return $this->connection->lastInsertId();
    }
}
