<?php

namespace Fangorn;

use Config;

class App {
    public static function getRoot(): string {
        return dirname(__DIR__);
    }

    public static function getConfig(): Config {
        return Config::getInstance();
    }

    public static function getDb(): Db {
        return Db::getInstance();
    }
}
