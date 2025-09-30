<?php

namespace App\Models;
use Core\Model;

class AdminModel  extends Model {

    public string $table = "products";

    public function all():array {
        return $this->fetchAll("SELECT * FROM $this->table");
    }

    public function find(int $id): array {
        return $this->fetch("SELECT * FROM $this->table WHERE id = :id", ["id" => $id]);
    }

    public function create(array $data): int {
        return $this->insert($data);
    }

    public function update(int $id, array $data): bool
    {
        return parent::update($id, $data);
    }

    public function delete(int $id): bool {
        return parent::delete($id);
    }
     
}