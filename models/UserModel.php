<?php

namespace app\models;
use app\core\Model;

class UserModel extends Model
{
    protected string $firstname;
    protected string $lastname;
    protected string $email;
    protected string $password;
    protected string $confirmPassword;

    protected function rules(): array
    {
        return [
            'firstname' => [
                'required',
            ],
            'lastname' => [
                'required',
            ],
            'email' => [
                'required',
                'email',
            ],
            'password' => [
                'required',
                ['min', ['min' => 6]],
                ['max', ['max' => 12]],
            ],
            'confirmPassword' => [
                'required',
                ['match', ['field' => 'Confirm Password', 'match' => 'password']],
            ],
        ];
    }
}