<?php

namespace App\Models;
use Core\Model;

class AuthModel extends Model {

    public string $table = "users";

    public function all():array {
        return $this->fetchAll("SELECT * FROM $this->table");
    }

    public function find(int $id): array {
        return $this->fetch("SELECT * FROM $this->table WHERE id = :id", ["id" => $id]);
    }


    public function create(array $data): int {
        return $this->insert($data);
    }

    public function findByEmail(string $email): ?array 
    {
        return $this->fetch("SELECT * FROM $this->table WHERE email = :email", ["email" => $email]);
    }

    public function update(int $id, array $data): bool
    {
        return parent::update($id, $data);
    }
}