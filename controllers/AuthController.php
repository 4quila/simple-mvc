<?php

namespace app\controllers;
use app\core\Controller;
use app\core\Request;
use app\models\UserModel;

class AuthController extends Controller
{
    public function register()
    {
        return $this->render('register');
    }

    public function handleRegister(Request $request)
    {
        $model = new UserModel();
        $model->loadData($request->body());
        $model->validate();
        return var_dump($model->errors);
    }
}