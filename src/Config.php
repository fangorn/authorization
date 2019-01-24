<?php

namespace Fangorn;

class Config {
    /** @var string */
    public $databaseUser;

    /** @var string */
    public $databasePassword;

    /** @var string */
    public $databaseSchema;

    /** @var Config */
    private static $config;

    private function __construct() {
        // Используй метод getInstance()
    }

    public static function getInstance(): self {
        if (self::$config === null) {
            $data = include (App::getRoot() . '/local/config.php');

            $config = new Config();
            $config->databaseUser     = $data['user'];
            $config->databasePassword = $data['password'];
            $config->databaseSchema   = $data['schema'];

            self::$config = $config;
        }
        return self::$config;
    }
}
