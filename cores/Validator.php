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
        foreach($this->rules as $field => $rulesSet){
            $rules = explode('|', $rulesSet);
            $value = trim($this->data[$field] ?? "");

            foreach($rules as $rule){
                if($rule === "required" && $value === ""){
                    $this->addError($field, "Le champ $field est requis.");
                }

                if($rule === "email" && !filter_var($value, FILTER_VALIDATE_EMAIL)){
                    $this->addError($field, "Le champ $field n'ai pas un email valide.");
                }

                if(str_starts_with($rule, "min:")){
                    $min = (int) substr($rule, 4);
                    if(strlen($value) < $min){
                        $this->addError($field, "Le champ $field doit conteni au moins $min caracteres");
                    }
                }

                if(str_starts_with($rule, "max:")){
                    $max = (int) substr($rule, 4);
                    if(strlen($value) > $max){
                        $this->addError($field, "Le champ $field doit conteni maximum $max caracteres");
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