<?php

namespace app\controllers;
use app\core\Controller;
use app\core\Request;
use app\models\UserModel;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $model = new UserModel();
        if ($request->isPost()) {
            $model->loadData($request->body());
            if ($model->validate() && $model->register()) {
                return "register successful.";
            }
            return $this->render('register', [
                'model' => $model
            ]);
        }
        return $this->render('register', [
            'model' => $model
        ]);
    }

}