<?php

namespace DeLuxis\Yii2SimpleFilemanager\controllers;


use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}