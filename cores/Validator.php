<?php

namespace Core;

class Validator {

    private array $data;
    private array $rules;
    private array $errors;

    public function __construct(array $data, array $rules){
        $this->data = $data;
        $this->rules = $rules;
        $this->validate();
    }
    
    public function validate(): void {
        foreach ($this->rules as $field => $rulesSet) {
            $rules = explode('|', $rulesSet);

            // Récupère la valeur (champ texte ou fichier)
            $value = $this->data[$field] ?? null;

            // Si ce n'est pas un fichier => string
            if (!is_array($value)) {
                $value = trim((string)$value);
            }

            foreach ($rules as $rule) {
                // ---- Champs textes ----
                if (!is_array($value)) {
                    if ($rule === "required" && $value === "") {
                        $this->addError($field, "Le champ $field est requis.");
                    }

                    if ($rule === "email" && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $this->addError($field, "Le champ $field n'est pas un email valide.");
                    }

                    if (str_starts_with($rule, "min:")) {
                        $min = (int) substr($rule, 4);
                        if (strlen($value) < $min) {
                            $this->addError($field, "Le champ $field doit contenir au moins $min caractères");
                        }
                    }

                    if (str_starts_with($rule, "max:")) {
                        $max = (int) substr($rule, 4);
                        if (strlen($value) > $max) {
                            $this->addError($field, "Le champ $field doit contenir maximum $max caractères");
                        }
                    }
                }

                // ---- Champs fichiers ----
                if ($rule === "file") {
                    if (!isset($_FILES[$field]) || $_FILES[$field]["error"] !== UPLOAD_ERR_OK) {
                        $this->addError($field, "Le fichier $field est requis ou invalide");
                    }
                }

                if (str_starts_with($rule, "mimes:")) {
                    $allowed = explode(",", substr($rule, 6));
                    $fileType = pathinfo($_FILES[$field]['name'] ?? "", PATHINFO_EXTENSION);

                    if (!in_array(strtolower($fileType), $allowed)) {
                        $this->addError($field, "Le fichier $field doit être de type : " . implode(", ", $allowed));
                    }
                }

                if (str_starts_with($rule, "maxSize:")) {
                    $max = (int) substr($rule, 8); // en Ko
                    $size = ($_FILES[$field]['size'] ?? 0) / 1024;
                    if ($size > $max) {
                        $this->addError($field, "Le fichier $field est plus grand que la taille max de $max Ko");
                    }
                }
            }
        }
    }

    private function addError(string $filed, string $message): void {
        $this->errors[$filed][] = $message;
    }

    public function fails(): bool {
        return !empty($this->errors);
    }

    public function errors(): array {
        return $this->errors;
    }
}