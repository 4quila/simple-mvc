<?php

namespace app\controllers;
use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\UserModel;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $user = new UserModel();
        if ($request->isPost()) {
            $user->loadData($request->body());
            if ($user->validate() && $user->save()) {
                Application::$app->session->setFlashMessage('success', 'You have successfully signed up!');
                Application::$app->response->redirect('/');
                exit;
            }
            return $this->render('register', [
                'model' => $user
            ]);
        }
        return $this->render('register', [
            'model' => $user
        ]);
    }

}