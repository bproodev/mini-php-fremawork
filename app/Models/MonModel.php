<?php

namespace App\Models;
use Core\Model;

class MonModel  extends Model {

    public string $table = "products";

    public function getAllActive(): ?array {
        return $this->fetchAll("SELECT * FROM $this->table WHERE status = 'active' ORDER BY created_at DESC");
    }   

    public function all():array {
        return $this->fetchAll("SELECT * FROM $this->table");
    }

    public function find(int $id): array {
        return $this->fetch("SELECT * FROM $this->table WHERE id = :id", ["id" => $id]);
    }

    public function create(array $data): int {
        return $this->insert($data);
    }
     
    public function update(int $id, array $data): bool {
        return $this->update($id, $data);
    }

    public function findBySlug(string $slug): ?array {
        return $this->fetch("SELECT * FROM $this->table WHERE slug = :slug", ["slug" => $slug]);
    }

    public function getFeaturedProducts(): ?array {
        return $this->fetchAll("SELECT * FROM $this->table WHERE status = 'active' AND category = 'Nouveau' ORDER BY created_at DESC LIMIT 3");
    }

    public function getLuxuryProducts(): ?array {
        return $this->fetchAll("SELECT * FROM $this->table WHERE status = 'active' AND category = 'Luxe' ORDER BY created_at DESC LIMIT 3");
    }

}