<?php

namespace DeLuxis\Yii2SimpleFilemanager\controllers;

use Yii;
use DeLuxis\Yii2SimpleFilemanager\models\Directory;
use DeLuxis\Yii2SimpleFilemanager\models\DirectoryForm;
use yii\helpers\FileHelper;
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

        $model       = new DirectoryForm();
        $model->path = $path;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['default/index', 'path' => $model->path]);
        } else {
            Yii::error($model->errors);
        }

        return $this->render('create', [
            'model'     => $model,
            'directory' => Directory::createByPath($path)
        ]);
    }

    public function actionUpdate($path)
    {
        if (strstr($path, '../')) {
            throw new BadRequestHttpException();
        }

        $directory = Directory::createByPath($path);

        $model           = new DirectoryForm();
        $model->path     = $directory->parent->path;
        $model->name     = $directory->name;
        $model->newName     = $directory->name;
        $model->scenario = DirectoryForm::SCENARIO_RENAME;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['default/index', 'path' => $model->path]);
        } else {
            Yii::error($model->errors);
        }

        return $this->render('update', [
            'model'     => $model,
            'directory' => $directory
        ]);
    }

    public function actionDelete($path)
    {
        if (strstr($path, '../')) {
            throw new BadRequestHttpException();
        }

        $directory = Directory::createByPath($path);

        FileHelper::removeDirectory($directory->fullPath);

        return $this->redirect(['default/index', 'path' => $directory->parent->path]);
    }
}