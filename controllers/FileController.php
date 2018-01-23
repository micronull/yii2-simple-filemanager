<?php

namespace DeLuxis\Yii2SimpleFilemanager\controllers;

use DeLuxis\Yii2SimpleFilemanager\models\Directory;
use DeLuxis\Yii2SimpleFilemanager\models\File;
use DeLuxis\Yii2SimpleFilemanager\models\UploadForm;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\UploadedFile;

class FileController extends Controller
{
    public function actionUpload($path)
    {
        if (strstr($path, '../')) {
            throw new BadRequestHttpException();
        }

        $directory = Directory::createByPath($path);

        $model       = new UploadForm();
        $model->path = $path;

        if (\Yii::$app->request->isPost) {
            $model->files = UploadedFile::getInstances($model, 'files');

            if ($model->upload()) {
                return $this->redirect(['default/index', 'path' => $model->path]);
            }
        }

        return $this->render('upload', [
            'directory' => $directory,
            'model'     => $model
        ]);
    }

    public function actionDelete($path)
    {
        if (strstr($path, '../')) {
            throw new BadRequestHttpException();
        }

        $file = File::createByPath($path);

        unlink($file->fullPath);

        return $this->redirect(['default/index', 'path' => $file->directory->path]);

    }
}