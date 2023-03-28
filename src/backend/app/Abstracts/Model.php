<?php

namespace App\Abstracts;

use App\Core\DB;

abstract class Model {

    protected string $tableName = '';
    private array $selectFields = [];
    private array $whereConditions = [];
    private ?DB $dbInstance = null;

    private function buildQuery(): string
    {
        $fileds = implode(', ', $this->selectFields);
        $query = "SELECT {$fileds} FROM {$this->tableName}";

        if (!count($this->whereConditions)) {
            return $query;
        }

        $query .= ' WHERE ';

        foreach ($this->whereConditions as $key => $condition) {
            $query .= "{$condition[0]} {$condition[1]} {$condition[2]}";
            if ($key !== count($this->whereConditions) - 1) {
                $query .= ' AND ';
            }
        }
        return $query;
    }

    public function query(): static
    {
        $this->dbInstance = DB::getInstance();
        return $this;
    }

    public function select(array $fields): static
    {
        $this->selectFields = $fields;
        return $this;
    }

    public  function where(array $whereConditions): static
    {
        $this->whereConditions = $whereConditions;
        return $this;
    }

    public function get(): array
    {
        $query = $this->buildQuery();
        return $this->dbInstance->query($query);
    }

    private function emptyQuery(): void
    {
        $this->whereConditions = [];
        $this->selectFields = [];
    }

    public function insert(array $data): bool
    {
        $this->dbInstance = DB::getInstance();
        $fields = array_keys($data);
        $names = '';
        $values = '';
        foreach ($fields as $key => $field) {
            $names .= "{$field}";
            $values .= ":{$field}";
            if ($key !== count($fields) - 1) {
                $names .= ", ";
                $values .= ", ";
            }
        }
        $sql = "INSERT INTO {$this->tableName} ({$names}) VALUES ({$values})";
        return $this->dbInstance->execute($sql, $data);
    }
}