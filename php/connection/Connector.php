<?php

namespace Aeki\Connection;

use PDO;
use PDOStatement;

class Connector
{
    private static ?Connector $instance = null;

    private ?PDO $pdo = null;

    private function __construct()
    {
        $this->openConnection();
    }

    private function __clone()
    {
    }

    public static function getInstance(): Connector
    {
        if (self::$instance === null) {
            self::$instance = new Connector();
        }

        if (self::$instance->pdo === null) {
            self::$instance->openConnection();
        }

        return self::$instance;
    }

    private function openConnection(): void
    {
        $charset = 'utf8';
        $dbHost = 'localhost';
        $dbPort = 3308;
        $dbName = 'database';

        $dsn = "mysql:host=$dbHost;port=$dbPort;dbname=$dbName;charset=$charset";

        $username = 'root';
        $password = '';

        $this->pdo = new PDO($dsn, $username, $password);
    }

    /**
     * @param string $sql
     * @param array $args
     * @return PDOStatement
     */
    public function execute(string $sql, array $args = []): PDOStatement
    {
        if (empty($args)) {
            return $this->pdo->query($sql);
        }

        $statement = $this->pdo->prepare($sql);
        $statement->execute($args);

        return $statement;
    }
}
