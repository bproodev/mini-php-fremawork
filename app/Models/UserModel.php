<?php

namespace App\Model;
use Core\Model;

class UserModel extends Model {

    private string $table = "users";

    public function all():array {
        return $this->fetchAll("SELECT * FROM $this->table");
    }

    public function find(int $id): array {
        return $this->fetch("SELECT * FROM $this->table WHERE id = :id", ["id" => $id]);
    }

    public function create(array $data): int {
        return $this->insert($data);
    }
}