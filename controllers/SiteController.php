<?php

namespace app\controllers;
use \app\core\Controller;
use \app\core\Request;

class SiteController extends Controller
{
    public function index()
    {
        return $this->render('home');
    }

    public function contact()
    {
        return $this->render('contact');
    }

    public function handleContact(Request $request)
    {
        $data = $request->body();
    }
}