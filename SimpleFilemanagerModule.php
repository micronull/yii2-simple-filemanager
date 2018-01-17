<?php

namespace DeLuxis\Yii2SimpleFilemanager;

use yii\base\Module;

class SimpleFilemanagerModule extends Module
{
    public $controllerNamespace = 'DeLuxis\Yii2SimpleFilemanager\controllers';

    public function init()
    {
        parent::init();

        if ( ! isset(\Yii::$app->i18n->translations['filemanager'])) {
            \Yii::$app->i18n->translations['filemanager'] = [
                'class'          => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en',
                'basePath'       => $this->basePath . DIRECTORY_SEPARATOR . 'messages',
                'fileMap'        => ['filemanager' => 'filemanager.php'],
            ];
        }
    }
}