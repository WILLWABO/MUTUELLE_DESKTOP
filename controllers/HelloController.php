<?php

namespace app\controllers;

use yii\web\Controller;


class HelloController extends Controller
{
    public function actionBonjour()
    {
        return $this->render('bonjour');
    }
}
