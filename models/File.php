<?php

namespace DeLuxis\Yii2SimpleFilemanager\models;

use DeLuxis\Yii2SimpleFilemanager\SimpleFilemanagerModule;

/**
 * Class File
 * @package DeLuxis\Yii2SimpleFilemanager\models
 * @property string $mime
 * @property string $url
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
}