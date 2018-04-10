<?php

namespace DeLuxis\Yii2SimpleFilemanager\models;

use DeLuxis\Yii2SimpleFilemanager\SimpleFilemanagerModule;
use yii\web\BadRequestHttpException;

/**
 * Class File
 * @package DeLuxis\Yii2SimpleFilemanager\models
 * @property string $mime
 * @property string $url
 * @property Directory $directory
 */
class File extends Item
{
    public function getUrl()
    {
        return \Yii::getAlias(SimpleFilemanagerModule::getInstance()->urlPath . $this->path);
    }

    public function getMime()
    {
        return mime_content_type($this->fullPath);
    }

    public function getIcon()
    {
        /**
         * @var SimpleFilemanagerModule $module
         */
        $module = SimpleFilemanagerModule::getInstance();

        if (isset($module->icons[$this->mime])) {
            return $module->icons[$this->mime];
        }

        if (isset($module->icons[$this->type])) {
            return $module->icons[$this->type];
        }
    }

    public function getDirectory()
    {
        return Directory::createByPath(dirname($this->path));
    }

    public function getSize()
    {
        return filesize($this->fullPath);
    }

    /**
     * @param string $path
     *
     * @return File
     * @throws BadRequestHttpException
     */
    public static function createByPath($path)
    {
        $file       = new File();
        $file->root = SimpleFilemanagerModule::getInstance()->fullUploadPath;
        $file->path = $path;

        if ($file->type != 'file') {
            throw new BadRequestHttpException();
        }

        return $file;
    }
}