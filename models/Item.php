<?php

namespace DeLuxis\Yii2SimpleFilemanager\models;

use yii\base\Model;

/**
 * Class Item
 * @package DeLuxis\Yii2SimpleFilemanager\models
 *
 * @property string $name
 * @property string $type
 * @property string $fullPath
 */
class Item extends Model
{
    public $path = DIRECTORY_SEPARATOR;
    public $root;

    public function attributeLabels()
    {
        return [
            'name' => \Yii::t('filemanager', 'Name')
        ];
    }

    public function getFullPath()
    {
        return $this->root . $this->path;
    }

    public function getName()
    {
        return basename($this->fullPath);
    }

    public function getType()
    {
        return filetype($this->fullPath);
    }
}