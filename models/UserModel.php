<?php

namespace app\models;
use app\core\DbModel;

class UserModel extends DbModel
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;

    public string $firstname = '';
    public string $lastname = '';
    public string $email = '';
    public string $password = '';
    public string $confirmPassword = '';
    public int $status = self::STATUS_INACTIVE;

    public function save()
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
    }

    public static function tableName(): string
    {
        return 'users';
    }

    public function attributes(): array
    {
        return ['firstname', 'lastname', 'email', 'password', 'status'];
    }

    public function getLabels()
    {
        return [
            'firstname' => 'First name',
            'lastname' => 'Last name',
            'email' => 'Email',
            'password' => 'Password',
            'confirmPassword' => 'Confirm password',
        ];
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
                [self::RULE_UNIQUE, 'class' => self::class, 'attr' => 'email'],
            ],
            'password' => [
                self::RULE_REQUIRED,
                [self::RULE_MIN, 'min' => 6],
                [self::RULE_MAX, 'max' => 12],
            ],
            'confirmPassword' => [
                self::RULE_REQUIRED,
                [self::RULE_MATCH, 'field' => 'confirmPassword', 'match' => 'password'],
            ],
        ];
    }
}