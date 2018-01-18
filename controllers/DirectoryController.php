<?php

namespace DeLuxis\Yii2SimpleFilemanager\controllers;

use yii\web\BadRequestHttpException;
use yii\web\Controller;

class DirectoryController extends Controller
{
    /**
     * @param null|string $path
     *
     * @return string
     * @throws BadRequestHttpException
     */
    public function actionCreate($path = null)
    {
        if (strstr($path, '../')) {
            throw new BadRequestHttpException();
        }

        return $this->render('create');
    }
}