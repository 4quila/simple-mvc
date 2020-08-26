<?php

namespace app\core;

abstract class Model
{
    public array $errors = [];
    protected string $RULE_REQUIRED = 'required';
    protected string $RULE_EMAIL = 'email';
    protected string $RULE_MIN = 'min';
    protected string $RULE_MAX = 'max';
    protected string $RULE_MATCH = 'match';

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

                if (($ruleName == $this->RULE_REQUIRED) && empty($value)) {
                    $this->addError($attr, $ruleName);
                }
                if (($ruleName == $this->RULE_EMAIL) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($attr, $ruleName);
                }
                if (($ruleName == $this->RULE_MIN) && (strlen($value) < $rule[1]['min'])) {
                    $this->addError($attr, $ruleName, $rule[1]);
                }
                if (($ruleName == $this->RULE_MAX) && (strlen($value) > $rule[1]['max'])) {
                    $this->addError($attr, $ruleName, $rule[1]);
                }
                if (($ruleName == $this->RULE_MATCH) && ($value !== $this->{$rule[1]['match']})) {
                    $this->addError($attr, $ruleName, $rule[1]);
                }
            }
        }
    }

    public function addError(string $attr, string $ruleName, array $params = [])
    {
        $errorText = $this->errorList()[$ruleName];
        if (!empty($params))
        {
            foreach ($params as $key => $value)
            {
                $errorText = str_replace("{{$key}}", ucfirst($value), $errorText);
            }
        }
        $this->errors[$attr][] = $errorText;
    }

    public function errorList()
    {
        return [
            $this->RULE_REQUIRED => 'This field is required.',
            $this->RULE_EMAIL => 'Email has to be in the right format.',
            $this->RULE_MATCH => '{field} must be the same as {match}.',
            $this->RULE_MIN => 'This field has to be longer than {min}.',
            $this->RULE_MAX => 'This field has to be less than {max}',
        ];
    }
}