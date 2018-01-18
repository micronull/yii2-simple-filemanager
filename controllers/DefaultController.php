<?php

namespace DeLuxis\Yii2SimpleFilemanager\controllers;

use DeLuxis\Yii2SimpleFilemanager\models\Directory;
use DeLuxis\Yii2SimpleFilemanager\SimpleFilemanagerModule;
use yii\data\ArrayDataProvider;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

/**
 * Class DefaultController
 * @package DeLuxis\Yii2SimpleFilemanager\controllers
 * @property SimpleFilemanagerModule $module
 */
class DefaultController extends Controller
{
    /**
     * @param null $path
     *
     * @return string
     * @throws BadRequestHttpException
     */
    public function actionIndex($path = null)
    {
        if (strstr($path, '../')) {
            throw new BadRequestHttpException();
        }

        $directory       = new Directory();
        $directory->root = \Yii::getAlias($this->module->uploadPath);

        if ($path) {
            if (substr($path, 0, 1) != DIRECTORY_SEPARATOR) {
                $path = DIRECTORY_SEPARATOR . $path;
            }

            $directory->path = $path;
        }

        return $this->render('index', [
            'directory'    => $directory,
            'dataProvider' => new ArrayDataProvider(['allModels' => $directory->list])
        ]);
    }
}