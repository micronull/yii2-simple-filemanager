<?php

namespace DeLuxis\Yii2SimpleFilemanager;

use yii\base\Module;

class SimpleFilemanagerModule extends Module
{
    public $controllerNamespace = 'DeLuxis\Yii2SimpleFilemanager\controllers';
    public $uploadPath = '@webroot' . DIRECTORY_SEPARATOR . 'upload';
    public $urlPath = '@web/upload';

    public $icons = [];

    public $defaultIcons = [
        'dir' => 'fa-folder-o',
        'file'=> 'fa-file-o',
        'image/gif' => 'fa-file-image-o',
        'image/tiff' => 'fa-file-image-o',
        'image/png' => 'fa-file-image-o',
        'image/jpeg' => 'fa-file-image-o',
        'application/pdf' => 'fa-file-pdf-o',
        'application/zip' => 'fa-file-archive-o',
        'application/x-gzip' => 'fa-file-archive-o',
        'text/plain' => 'fa-file-text-o',
    ];

    public function init()
    {
        parent::init();

        $this->_checkPath();

        $this->icons = array_merge($this->defaultIcons, $this->icons);

        if ( ! isset(\Yii::$app->i18n->translations['filemanager'])) {
            \Yii::$app->i18n->translations['filemanager'] = [
                'class'          => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en-US',
                'basePath'       => $this->basePath . DIRECTORY_SEPARATOR . 'messages',
                'fileMap'        => ['filemanager' => 'filemanager.php'],
            ];
        }
    }

    private function _checkPath()
    {
        $path = \Yii::getAlias($this->uploadPath);
        if (!is_dir($path))
            mkdir($path, 0755, true);
    }
}