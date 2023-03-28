<?php

namespace App\Core;


class DB {

    private static ?DB $instance = null;
    private ?\PDO $dbInstance = null;

    public static function getInstance(): DB
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    private function __construct()
    {
        $this->connect();
    }
    private function connect(): void
    {
        $host = Helper::env('DB_HOST');
        $dbName = Helper::env('DB_NAME');
        $user = Helper::env('DB_USERNAME');
        $password = Helper::env('DB_PASSWORD');
        $this->dbInstance = new \PDO("mysql:host={$host};dbname={$dbName}", $user, $password);
    }

    public function query(string $queryString): array
    {
        $statement = $this->dbInstance->query($queryString);
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function execute(string $sql, array $data): bool
    {
        $stmt = $this->dbInstance->prepare($sql);
        return $stmt->execute($data);
    }

}