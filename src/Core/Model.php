<?php

namespace Core;

use PDO;
use App\Config;

abstract class Model
{
    /**
     * @return PDO connect
     */
    protected static function getDB()
    {
        static $db = null;

        if (null === $db) {
            $dsn = 'mysql:host=' . Config::DB_HOST . ';dbname=' . Config::DB_NAME . ';charset=utf8';
            $db = new PDO($dsn, Config::DB_USER, Config::DB_PASSWORD);
        }

        return $db;
    }
}
