<?php

namespace app\models;
use app\core\Model;

class UserModel extends Model
{
    public string $firstname = '';
    public string $lastname = '';
    public string $email = '';
    public string $password = '';
    public string $confirmPassword = '';

    public function register()
    {
        return 'Creating User.';
    }

    protected function rules(): array
    {
        return [
            'firstname' => [
                self::RULE_REQUIRED,
            ],
            'lastname' => [
                self::RULE_REQUIRED,
            ],
            'email' => [
                self::RULE_REQUIRED,
                self::RULE_REQUIRED,
            ],
            'password' => [
                self::RULE_REQUIRED,
                [self::RULE_MIN, 'min' => 6],
                [self::RULE_MAX, 'max' => 12],
            ],
            'confirmPassword' => [
                self::RULE_REQUIRED,
                [self::RULE_MATCH, 'field' => 'Confirm Password', 'match' => 'password'],
            ],
        ];
    }
}