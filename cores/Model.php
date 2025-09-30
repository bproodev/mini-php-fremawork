<?php

namespace Core;

use Core\Database;
use PDO;
use PDOStatement;

abstract class Model {

    protected PDO $db;

    public function __construct(){
        $this->db = Database::getInstance();
    }

    protected function query(string $sql, array $params=[]): PDOStatement {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    protected function fetchAll(string $sql, array $params=[]): ?array {
        return $this->query($sql, $params)->fetchAll();
    }

    protected function fetch($sql, $params=[]): ?array {
        $result = $this->query($sql, $params)->fetch();
        return $result ?: null;
    }

    protected function insert(array $data): int {

        $columns = implode(", ", array_keys($data)); 
        $placeholders = implode(", ", array_map( fn($k)=> ":$k", array_keys($data)));

        $sql = "INSERT INTO {$this->table} ($columns) Values ($placeholders)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);

        return (int) $this->db->lastInsertId();
    }

    protected function update(int $id, array $data): bool
    {
        // Dynamically build SET clause and bind parameters
        $set = [];
        $params = [];
        foreach ($data as $column => $value) {
            $set[] = "$column = :$column";
            $params[":$column"] = $value;
        }
        $params[":id"] = $id;
        $sql = "UPDATE {$this->table} SET " . implode(", ", $set) . " WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    protected function delete(int $id): bool {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}