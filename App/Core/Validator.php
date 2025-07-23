<?php

namespace App\Core;

class Validator
{
    protected array $data;
    protected array $rules;
    protected array $errors = [];

    public function __construct(array $data, array $rules)
    {
        $this->data = $data;
        $this->rules = $rules;
    }

    public static function make(array $data, array $rules): self
    {
        return new self($data, $rules);
    }

    public function validate(): bool
    {
        foreach ($this->rules as $field => $rules) {
            $value = $this->data[$field] ?? null;

            foreach ($rules as $rule) {
                [$ruleName, $params] = $this->parseRule($rule);
                $method = 'validate' . ucfirst($ruleName);
                
                if (method_exists($this, $method)) {
                    $this->$method($field, $value, $params);
                } else {
                    error_log("Règle de validation '$ruleName' non trouvée pour le champ '$field'");
                }
            }
        }

        return empty($this->errors);
    }

    protected function parseRule(string $rule): array
    {
        if (strpos($rule, ':') !== false) {
            [$ruleName, $params] = explode(':', $rule, 2);
            $params = explode(',', $params);
        } else {
            $ruleName = $rule;
            $params = [];
        }
        return [$ruleName, $params];
    }

   
    protected function validateCni(string $field, $value, array $params)
    {
        if ($value && !self::isCniValid($value)) {
            $this->addError($field, "Le CNI $field n'est pas valide.");
        }
    }

    protected static function isCniValid($cni): bool
    {
        return preg_match('/^(1|2)\d{11}$/', $cni) === 1;
    }

    protected function validateUnique(string $field, $value, array $params)
    {
        if (count($params) !== 2) {
            throw new \Exception("La règle unique doit avoir deux paramètres: table,colonne");
        }
        
        [$table, $column] = $params;
        $repositoryClass = "App\\Repositories\\" . ucfirst($table) . "Repository";

        if (!class_exists($repositoryClass)) {
            throw new \Exception("Le repository $repositoryClass n'existe pas.");
        }

        /** @var \App\Core\Abstract\AbstractRepository $repo */
        $repo = $repositoryClass::getInstance();

        if (!$repo->isUnique($column, $value)) {
            $this->addError($field, "La valeur de $field existe déjà.");
        }
    }

    protected function addError(string $field, string $message)
    {
        $this->errors[$field][] = $message;
    }

    public function errors(): array
    {
        return $this->errors;
    }
}