<?php

namespace app\core;

abstract class Model
{
    public array $errors = [];
    const RULE_REQUIRED = 'required';
    const RULE_EMAIL = 'email';
    const RULE_MIN = 'min';
    const RULE_MAX = 'max';
    const RULE_MATCH = 'match';
    const RULE_UNIQUE = 'unique';

    public function loadData(array $data)
    {
        foreach ($data as $attr => $value)
        {
            if (property_exists($this, $attr))
            {
                $this->{$attr} = $value;
            }
        }
    }

    abstract protected function rules(): array;

    public function getLabels()
    {
        return [];
    }

    public function validate()
    {
        foreach ($this->rules() as $attr => $rules)
        {
            $value = $this->{$attr};
            foreach ($rules as $rule)
            {
                if (is_array($rule)) {
                    $ruleName = $rule[0];
                } else {
                    $ruleName = $rule;
                }

                if (($ruleName == self::RULE_REQUIRED) && empty($value)) {
                    $this->addError($attr, $ruleName);
                }
                if (($ruleName == self::RULE_EMAIL) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($attr, $ruleName);
                }
                if (($ruleName == self::RULE_MIN) && (strlen($value) < $rule['min'])) {
                    $this->addError($attr, $ruleName, $rule);
                }
                if (($ruleName == self::RULE_MAX) && (strlen($value) > $rule['max'])) {
                    $this->addError($attr, $ruleName, $rule);
                }
                if (($ruleName == self::RULE_MATCH) && ($value !== $this->{$rule['match']})) {
                    $this->addError($attr, $ruleName, $rule);
                }
                if ($ruleName == self::RULE_UNIQUE) {
                    $tableName = $rule['class']::tableName();
                    $stmt = $this->prepare("SELECT * FROM {$tableName} WHERE {$rule['attr']}='{$value}'");
                    $stmt->execute();
                    $record = $stmt->fetch(\PDO::FETCH_OBJ);
                    if ($record) {
                        $this->addError($attr, $ruleName, $rule);
                    }
                }
            }
        }
        return empty($this->errors);
    }

    public function addError(string $attr, string $ruleName, array $params = [])
    {
        $errorText = $this->errorList()[$ruleName];
        if (!empty($params))
        {
            foreach ($params as $key => $value)
            {
                $errorText = str_replace("{{$key}}", $this->getLabels()[$value] ?? '', $errorText);
            }
        }
        $this->errors[$attr][] = $errorText;
    }

    public function errorList()
    {
        return [
            self::RULE_REQUIRED => 'This field is required.',
            self::RULE_EMAIL => 'Email has to be in the right format.',
            self::RULE_MATCH => '{field} must be the same as {match}.',
            self::RULE_MIN => 'This field has to be longer than {min}.',
            self::RULE_MAX => 'This field has to be less than {max}',
            self::RULE_UNIQUE => 'There is already a user by this {attr}.',
        ];
    }

    public function hasError(string $attr)
    {
        return $this->errors[$attr] ?? false;
    }

    public function getFirstError(string $attr)
    {
        return $this->errors[$attr][0] ?? false;
    }
}