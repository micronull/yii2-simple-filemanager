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
 * @property boolean $isExist
 */
class Item extends Model
{
    public $path = DIRECTORY_SEPARATOR;
    public $root;

    /**
     * @var string
     */
    private $_fullPath;

    public function attributeLabels()
    {
        return [
            'name' => \Yii::t('filemanager', 'Name')
        ];
    }

    public function getFullPath()
    {
        if (!isset($this->_fullPath)){
            $this->_fullPath = $this->root . $this->path;

            if (!is_file($this->_fullPath) && substr($this->_fullPath, -1) !== DIRECTORY_SEPARATOR)
                $this->_fullPath .= DIRECTORY_SEPARATOR;
        }

        return $this->_fullPath;
    }

    public function getName()
    {
        return basename($this->fullPath);
    }

    public function getType()
    {
        return filetype($this->fullPath);
    }

    public function isExist()
    {
        return file_exists($this->fullPath);
    }
}