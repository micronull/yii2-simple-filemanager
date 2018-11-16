<?php

namespace DeLuxis\Yii2SimpleFilemanager\models;

use yii\base\InvalidCallException;
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
    public $path = '/';
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

            if ( ! is_file($this->_fullPath) && substr($this->_fullPath, -1) !== '/') {
                $this->_fullPath .= '/';
            }
        }

        return $this->_fullPath;
    }

    /**
     * @return string
     */
    public function getName()
    {
        if ( ! preg_match('/\/([^\/]+?)\/?$/', $this->fullPath, $m)) {
            throw new InvalidCallException('Not correct full path.');
        }

        return $m[1];
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